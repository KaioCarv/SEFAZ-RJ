<?php
if (!defined('GLPI_ROOT')) {
   die('Direct access not allowed');
}

// Definição da URL do catálogo. Crentalizei em uma variavel global pra alterar só aqui. uma boa pratica.
global $CATALOGO_HOST;
$CATALOGO_HOST = 'http://drhel8glpi001v.sefnet.rj/catalogo/';

function plugin_version_catalogoservicos() {
   return [
      'name'           => 'Catálogo de Serviços',
      'version'        => '1.0.0',
      'author'         => 'Kaio Sena',
      'license'        => 'GPLv2+',
      'homepage'       => 'http://drhel8glpi001v.sefnet.rj',
      'minGlpiVersion' => '10.0.0'
   ];
}

function plugin_init_catalogoservicos() {
   global $PLUGIN_HOOKS, $CATALOGO_HOST;

   $PLUGIN_HOOKS['csrf_compliant']['catalogoservicos'] = true;

   // Página de configuração (ícone engrenagem plugins)
   $PLUGIN_HOOKS['config_page']['catalogoservicos'] = $CATALOGO_HOST;

   // Botão no dashboard central
   $PLUGIN_HOOKS['display_central']['catalogoservicos'] = 'plugin_catalogoservicos_display_central';
}

function plugin_catalogoservicos_display_central() {
   global $CATALOGO_HOST;

   echo '<div class="center" style="margin:20px 0;">
            <a class="vsubmit" href="'.htmlspecialchars($CATALOGO_HOST).'" target="_blank"
               style="display:inline-block;background-color:#134372;color:#fff;padding:6px 12px;border-radius:4px;text-decoration:none;">
               Acessar Catálogo de Serviços
            </a>
         </div>';
}

function plugin_catalogoservicos_install()  { return true; }
function plugin_catalogoservicos_uninstall() { return true; }
