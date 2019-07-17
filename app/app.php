<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

use Phalcon\Mvc\Micro\Collection as MicroCollection;

/**
 * Add your routes here
 */
$app->get('/', function () use($app) {
    $app->response->setContentType('application/json', 'UTF-8');
    $app->response->setJsonContent([
        'code' => '200',
        'message' => 'You\'re now flying with Phalcon. Great things are about to happen!',
    ]);
    $app->response->send();
});

/**
 * Robot
 */
$robots = new MicroCollection();
$robots->setHandler('RobotController', true);
$robots->setPrefix('/api/robots');
// Gets all users
$robots->get('/', 'indexAction');
// Creates a new user
$robots->post('/', 'saveAction');
// Gets user
$robots->get('/{id}', 'showAction');
// Updates user
$robots->put('/{id}', 'editAction');
// Deletes user
$robots->delete('/{id}', 'delete');
// Adds users routes to $app
$app->mount($robots);

/**
 * Not found handler
 */
$app->notFound(function () use($app) {
    $app->response->setStatusCode(404)->sendHeaders();
    $app->response->setContentType('application/json', 'UTF-8');
    $app->response->setJsonContent([
        'code' => '404',
        'message' => 'url not found',
    ]);
    $app->response->send();
});

/**
 * Error handler
 */
$app->error(
    function ($exception) use($app) {
        $app->response->setStatusCode(400);
        $app->response->setContentType('application/json', 'UTF-8');
        $app->response->setJsonContent([
            'code'    => 400,
            'message' => $exception->getMessage(),
            'data' => [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTrace(),
            ],
        ]);
        $app->response->send();
    }
);
