<?php
function plugin_post_item_form_servicossidebar($params) {
  global $CFG_GLPI;

  // Descobre o item (array ou objeto)
  $item = null;
  if (is_array($params) && isset($params['item'])) {
    $item = $params['item'];
  } elseif (is_object($params)) {
    $item = $params;
  }
  if (!is_object($item)) return;

  $type = method_exists($item, 'getType') ? $item->getType() : get_class($item);
  if ($type !== 'Ticket') return;

  // Carrega links do JSON
  $links = [];
  $json  = GLPI_ROOT . '/plugins/servicossidebar/config/links.json';
  if (is_readable($json)) {
    $tmp = json_decode(file_get_contents($json), true);
    if (is_array($tmp)) $links = $tmp;
  }

  $root     = $CFG_GLPI['root_doc'] ?? '';
  $links_js = json_encode($links, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

  // CSS
  echo '<link rel="stylesheet" href="' . $root . '/plugins/servicossidebar/assets/servicossidebar.css?v=1.5.0">';

  // JS inline (ancora DEPOIS do contêiner do campo Categoria)
  echo \Html::scriptBlock("
    (function(){
      const LINKS    = $links_js;
      const PANEL_ID = 'servicossidebar-panel';

      function norm(t){return (t||'').normalize('NFD').replace(/[\\u0300-\\u036f]/g,'').trim().toLowerCase();}

      function findCategoryContainer(){
        // select real (oculto) usado pelo GLPI
        let sel = document.querySelector('select[name=\"itilcategories_id\"], select[id^=\"dropdown_itilcategories_id\"]');
        let base = sel;
        if (!base) {
          // fallback pelo rótulo
          const labels = Array.from(document.querySelectorAll('label,.col-form-label,.form-label,dt,.label'));
          const lb = labels.find(el => norm(el.textContent).startsWith('categoria'));
          base = lb || null;
        }
        if (!base) return null;

        // Sobe até o contêiner do campo (linha completa)
        const container = base.closest('.form-field, .mb-2, .form-group, .row') || base.parentElement;
        return container;
      }

      function ensurePanelAfter(container){
        if (!container || !container.parentNode) return null;
        let panel = document.getElementById(PANEL_ID);
        if (panel) return panel;

        panel = document.createElement('div');
        panel.id = PANEL_ID;
        panel.className = 'servicos-panel';
        panel.innerHTML =
          '<div class=\"servicos-card\">' +
            '<div class=\"servicos-header\">' +
               '<span class=\"servicos-icon\" aria-hidden=\"true\">' +
                 '<svg width=\"16\" height=\"16\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">' +
                   '<path d=\"M4 6h16M4 12h16M4 18h16\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"/>' +
                 '</svg>' +
               '</span>' +
               '<span class=\"servicos-title\">Serviços</span>' +
            '</div>' +
            '<div class=\"servicos-list\"><em>Carregando…</em></div>' +
          '</div>';

        // Insere DEPOIS do contêiner da Categoria (linha inteira abaixo)
        container.parentNode.insertBefore(panel, container.nextSibling);
        return panel;
      }

      function renderLinks(){
        const list = document.querySelector('#'+PANEL_ID+' .servicos-list');
        if (!list) return;
        if (!Array.isArray(LINKS) || !LINKS.length) {
          list.innerHTML = '<em class=\"servicos-empty\">Nenhum link configurado.</em>';
          return;
        }
        list.innerHTML = '';
        LINKS.forEach(l => {
          const a = document.createElement('a');
          a.className = 'servico-link';
          a.href = l.url;
          a.target = '_blank';
          a.rel = 'noopener';
          a.textContent = l.label || l.url;
          list.appendChild(a);
          if (l.desc) {
            const sm = document.createElement('div');
            sm.className = 'servico-desc';
            sm.textContent = l.desc;
            list.appendChild(sm);
          }
        });
      }

      function insertNow(){
        const container = findCategoryContainer();
        if (!container) return false;
        const p = ensurePanelAfter(container);
        if (!p) return false;
        renderLinks();
        return true;
      }

      if (!insertNow()) {
        let tries = 0;
        const t = setInterval(() => {
          if (insertNow() || ++tries > 80) clearInterval(t);
        }, 125);
      }

      const obs = new MutationObserver(() => {
        if (!document.getElementById(PANEL_ID)) insertNow();
      });
      obs.observe(document.body, { childList:true, subtree:true });
    })();
  ");
}
