<?php

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


$router->group(['prefix' => 'api/v1'],  function ($router) {

    $router->post('/register', 'UserController@register');
    $router->post('/login', 'UserController@login');


    $router->group(['prefix' => '/user', 'middleware' => 'userAccess'],  function ($router) {
        $router->get('/logout', 'UserController@logOut');
        $router->post('contacts/add-person', 'ContactsController@addPerson');
        $router->post('contacts/add-person-number/{personId}', 'ContactsController@addPersonNumber');
        $router->delete('contacts/{id}', 'ContactsController@deletePerson');
        $router->get('contacts/person/{id}', 'ContactsController@getPersonNumbers');
        $router->get('contacts/list', 'ContactsController@getList');
        $router->get('contacts/number/{number}', 'ContactsController@findPersonByNumber');
    });


});

