<?php

use Glpi\Session;
use Firebase\JWT\JWT;

function plugin_catalogoservicos_add_topmenu_item() {
    global $CFG_GLPI;

    if (!Session::getLoginUserID()) {
        return [];
    }

    try {
        $secret_key = 'chave secreta 123 sefaz 456';
        $catalog_url_base = 'http://drhel8glpi001v.sefnet.rj:8080/index.php';

        $username = Session::getLoginUsername();
        $active_profile = Session::getActiveProfile();
        $profile_name = '';

        if (!empty($active_profile) && isset($active_profile['name'])) {
            $profile_name = $active_profile['name'];
        } else if (isset($active_profile['id'])) {
            $profile_name = \Profile::getFriendlyName($active_profile['id']);
        }

        if (empty($username) || empty($profile_name)) {
            return [];
        }

        $payload = [
            'iss' => $CFG_GLPI['url_base'],
            'aud' => $catalog_url_base,
            'iat' => time(),
            'exp' => time() + 60,
            'data' => [
                'user'    => $username,
                'profile' => $profile_name
            ]
        ];

        $jwt = JWT::encode($payload, $secret_key, 'HS256');
        $catalog_url = $catalog_url_base . '?token=' . $jwt;

        // Em vez de dar echo aqui, retornamos um item para o menu
        return [
            'title' => __('Catálogo de Serviços', 'catalogoservicos'),
            'page'  => $catalog_url,
            'links' => []
        ];

    } catch (Throwable $e) {
        return [];
    }
}
