<?php

/**
 * Setup Route
 */
$camsCollection = new \Phalcon\Mvc\Micro\Collection();
$camsCollection->setHandler(App\Controllers\CameraController::class, true);
$camsCollection->setPrefix('/api/v1');
$camsCollection->post('/people-counting', 'createAction');
$app->mount($camsCollection);

/**
 * Not found handler
 */
$app->notFound(function () use($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});