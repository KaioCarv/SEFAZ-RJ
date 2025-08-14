<?php
require_once(__DIR__ . '/../../../inc/includes.php');

\Session::checkLoginUser();

global $CFG_GLPI;

$secret_key       = 'chave secreta 123 sefaz 456';
$catalog_url_base = 'http://drhel8glpi001v.sefnet.rj:8080/index.php';

$username       = \Session::getLoginUsername();
$active_profile = \Session::getActiveProfile();
$profile_name   = '';

if (!empty($active_profile) && isset($active_profile['name'])) {
   $profile_name = $active_profile['name'];
} elseif (isset($active_profile['id'])) {
   $profile_name = \Profile::getFriendlyName($active_profile['id']);
}

if (empty($username) || empty($profile_name)) {
   \Session::addMessageAfterRedirect(__('Usuário sem perfil ativo.'), false, ERROR);
   \Html::redirect($CFG_GLPI['url_base'] . '/front/central.php');
   exit;
}

$payload = [
   'iss'  => $CFG_GLPI['url_base'],
   'aud'  => $catalog_url_base,
   'iat'  => time(),
   'exp'  => time() + 60,
   'data' => ['user' => $username, 'profile' => $profile_name]
];

$catalog_url = $catalog_url_base;
if (class_exists('\Firebase\JWT\JWT')) {
   $jwt         = \Firebase\JWT\JWT::encode($payload, $secret_key, 'HS256');
   $catalog_url = $catalog_url_base . '?token=' . urlencode($jwt);
}

\Html::redirect($catalog_url);
exit;
