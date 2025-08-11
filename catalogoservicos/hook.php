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

        // HTML customizado para o botão no cabeçalho
        echo '<li class="nav-item">
                <a class="btn btn-outline-primary btn-sm mt-2" 
                   style="margin-right:10px;" 
                   target="_blank" 
                   href="' . $catalog_url . '">
                   <i class="fas fa-book"></i> Catálogo de Serviços
                </a>
              </li>';

        return [];

    } catch (Throwable $e) {
        return [];
    }
}
