<?php
declare(strict_types=1);

use Phalcon\Mvc\View\Simple as View;
use Phalcon\Url as UrlResolver;
use Phalcon\Logger\Adapter\File as FileAdapter;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * Sets the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    return $view;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'schema'   => $config->database->schema,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    return $connection;
});

/**
 * Response
 */

$di->setShared('response', function() {
    $response = new \Phalcon\Http\Response();
    $response->setContentType('application/json', 'utf-8');

    return $response;
});

/**
 * Logger
 */

$di->setShared('logger', function() {
    $logger = new FileAdapter(APP_PATH . '/storage/logs/main.log');
    // $logger = new Logger('messages', ['main' => $adapter]);

    return $logger;
});
