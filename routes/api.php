<?php

/* 
 | API routes
 */

$router->group(['prefix' => 'redirect_url'], function() use ($router) {
  $router->post('/store', 'RedirectUrlController@store');
});
