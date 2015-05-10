<?php
/**
 * Index File for GET / POST
 *
 * On this file we gonna recibe all the entrys for the request GET / POST for the the index
 */

namespace Coffeecircle;

require '../Slim/Slim.php';
\Slim\Slim::registerAutoloader();


$app = new \Slim\Slim();

    $app->config(array(
        'debug' => true,
        'templates.path' => 'templates'
    ));

/****************************** GET AND INDEX ***********************************************/
    $app->get('/',function () use ($app) {
        $app->render('index.phtml');
    });

/******************************* MAKE THE PETITION ******************************************/
    $app->post('/', function() use ($app) {
        $app->render('process.phtml');
    });

    $app->run();