<?php

$loader = new \Phalcon\Loader();
$loader->registerNamespaces([
    'App\Controllers' => APP_PATH . '/controllers/',
    'App\Models' => APP_PATH . '/models/',
    'App\Exceptions\Base' => APP_PATH . '/exceptions/Base/',
    'App\Exceptions\ApiException' => APP_PATH . '/exceptions/ApiException/',
    'App\Exceptions\ApiException\Base' => APP_PATH . '/exceptions/ApiException/Base/',
])->register();

$loader->registerClasses([
    'Nodeflux\Config\Response' => APP_PATH . '/config/response.php',
    'Nodeflux\Config\Constant' => APP_PATH . '/config/constant.php'
])->register();
