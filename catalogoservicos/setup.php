<?php

function plugin_version_catalogoservicos() {
    return [
        'name'           => 'Catalogo',
        'version'        => '3.0.0',
        'author'         => 'Fernando de Azambuja Petit',
        'license'        => 'GPLv2+',
        'homepage'       => 'http://10.8.75.86/',
        'minGlpiVersion' => '10.0'
    ];
}

function plugin_init_catalogoservicos() {
    global $PLUGIN_HOOKS;

    $PLUGIN_HOOKS['csrf_compliant']['catalogoservicos'] = true;
    $PLUGIN_HOOKS['add_topmenu_item']['catalogoservicos'] = 'plugin_catalogoservicos_add_topmenu_item';

    $autoloader = __DIR__ . '/vendor/autoload.php';
    if (file_exists($autoloader)) {
        require_once $autoloader;
    }

    return true;
}

function plugin_catalogoservicos_install() {
    return true;
}

function plugin_catalogoservicos_uninstall() {
    return true;
}
