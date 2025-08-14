<?php
if (!defined('GLPI_ROOT')) {
   die('Direct access not allowed');
}

function plugin_version_catalogoservicos() {
   return [
      'name'           => 'Catálogo de Serviços',
      'version'        => '1.0.0',
      'author'         => 'Kaio Sena',
      'license'        => 'GPLv2+',
      'homepage'       => 'http://10.8.75.86/',
      'minGlpiVersion' => '10.0.0'
   ];
}

function plugin_init_catalogoservicos() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['catalogoservicos'] = true;

   // ❌ REMOVIDO menu_toadd (causa "Class ... not found")
   // ✅ página de configuração (ícone de engrenagem na lista de plugins)
  $PLUGIN_HOOKS['config_page']['catalogoservicos'] = 'http://10.8.75.86/catalogo/';


   // Botão no dashboard central
   $PLUGIN_HOOKS['display_central']['catalogoservicos'] = 'plugin_catalogoservicos_display_central';
}

function plugin_catalogoservicos_display_central() {
   echo '<div class="center" style="margin:20px 0;">
            <a class="vsubmit" href="http://10.8.75.86/catalogo/" target="_blank"
               style="display:inline-block;background-color:#134372;color:#fff;">
               Acessar Catálogo de Serviços
            </a>
         </div>';
}

function plugin_catalogoservicos_install()  { return true; }
function plugin_catalogoservicos_uninstall(){ return true; }


