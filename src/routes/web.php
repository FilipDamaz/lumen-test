<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {

    $router->get('viewers',  ['uses' => 'ViewersController@showAllViewers']);
    $router->get('viewers/{id}', ['uses' => 'ViewersController@showOneViewer']);
    $router->post('viewers', ['uses' => 'ViewersController@create']);
    $router->put('viewers/{id}', ['uses' => 'ViewersController@update']);

    $router->post('svod_package', ['uses' => 'SvodPackageController@createNewPackage']);
    $router->post('svod_package/change_of_state', ['uses' => 'SvodPackageController@changeOfState']);
    $router->post('svod_package/change_properties', ['uses' => 'SvodPackageController@changeProperties']);
    $router->get('svod_package', ['uses' => 'SvodPackageController@showAllSvodPackages']);
    $router->get('svod_package/{id}', ['uses' => 'SvodPackageController@showOneSvodPackages']);
    $router->post('svod_package/buy_package', ['uses' => 'SvodPackageController@buyPackage']);

    $router->get('video/{id}', ['uses' => 'VideoController@showOneVideo']);
    $router->post('video', ['uses' => 'VideoController@createNewVideo']);
    $router->post('video/direct_access', ['uses' => 'VideoController@buyVideo']);

});
