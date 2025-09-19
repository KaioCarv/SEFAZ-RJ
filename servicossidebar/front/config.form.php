<?php
if (!defined('GLPI_ROOT')) { include('../../inc/includes.php'); }
Session::checkRight('config', READ);

Html::header(__('Serviços na Sidebar', 'servicossidebar'), $_SERVER['PHP_SELF'], 'plugins', 'servicossidebar');
echo "<div class='card'><div class='card-body'>";
echo "<h3>Configuração</h3>";
echo "<p>Edite <code>plugins/servicossidebar/config/links.json</code> para controlar os links exibidos abaixo de <b>Categoria</b> nos chamados.</p>";

$cfg = GLPI_ROOT . '/plugins/servicossidebar/config/links.json';
if (is_readable($cfg)) {
  $data = json_decode(file_get_contents($cfg), true);
  if (is_array($data) && count($data)) {
    echo "<h4>Links atuais</h4><ul>";
    foreach ($data as $l) {
      $label = \Html::entities_deep($l['label'] ?? $l['url'] ?? '#');
      $url   = \Html::entities_deep($l['url'] ?? '#');
      echo "<li><a href='{$url}' target='_blank' rel='noopener'>{$label}</a></li>";
    }
    echo "</ul>";
  } else {
    echo "<p><em>Nenhum link configurado.</em></p>";
  }
} else {
  echo "<p><em>Arquivo links.json não encontrado.</em></p>";
}
echo "</div></div>";
Html::footer();
