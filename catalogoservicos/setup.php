<?php

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

    // Adiciona entrada no menu de plugins
    $PLUGIN_HOOKS['menu_toadd']['catalogoservicos'] = [
        'plugins' => 'catalogoservicos.php'
    ];

    // Adiciona botão na página principal (dashboard central)
    $PLUGIN_HOOKS['display_central']['catalogoservicos'] = 'plugin_catalogoservicos_display_central';
}

function plugin_catalogoservicos_display_central() {
    echo '<div class="center" style="margin-top: 20px; margin-bottom: 20px;">
            <a class="vsubmit" href="http://localhost:8080/index.php" target="_blank" 
               style="display: inline-block; margin-bottom: 10px; background-color: #134372ff; color: white;">
                Acessar Catálogo de Serviços
            </a>
          </div>';
}

function plugin_catalogoservicos_install() {
    // Aqui você pode criar tabelas, campos extras, etc.
    return true; // true = instalação ok
}

function plugin_catalogoservicos_uninstall() {
    // Aqui você pode remover tabelas, campos extras, etc.
    return true; // true = desinstalação ok
}

