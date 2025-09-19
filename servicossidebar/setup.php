<?php
if (!defined('GLPI_ROOT')) { die('Direct access not allowed'); }

define('SERVICOS_SIDEBAR_VERSION', '1.4.0');

function plugin_version_servicossidebar() {
  return [
    'name'           => 'Serviços na Sidebar (Links do Catálogo)',
    'version'        => SERVICOS_SIDEBAR_VERSION,
    'author'         => 'SEFAZ-RJ',
    'license'        => 'GPLv2+',
    'homepage'       => 'http://drhel8glpi001v.sefnet.rj',
    'minGlpiVersion' => '10.0.0'
  ];
}

function plugin_init_servicossidebar() {
  global $PLUGIN_HOOKS;
  $PLUGIN_HOOKS['csrf_compliant']['servicossidebar'] = true;
  $PLUGIN_HOOKS['config_page']['servicossidebar']    = 'front/config.form.php';

  // (Opcional) registra explicitamente o hook de form para garantir chamada
  $PLUGIN_HOOKS['post_item_form']['servicossidebar'] = 'plugin_post_item_form_servicossidebar';
}

// Garante que o arquivo de hooks seja carregado
require_once __DIR__ . '/hook.php';

function plugin_servicossidebar_install()   { return true; }
function plugin_servicossidebar_uninstall() { return true; }
