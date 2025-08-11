<?php
include ('../../../inc/includes.php');

Html::header(
    __('Catálogo de Serviços', 'catalogoservicos'),
    $_SERVER['PHP_SELF'],
    'plugins',
    'catalogoservicos'
);

// Redireciona para seu catálogo externo
echo '<meta http-equiv="refresh" content="0;URL=http://localhost:8080/index.php">';
Html::footer();
