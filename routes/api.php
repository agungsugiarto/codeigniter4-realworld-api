<?php

/** @var \CodeIgniter\Router\RouteCollection $routes */

use App\Controllers\ArticleController;
use App\Controllers\AuthenticationController;
use App\Controllers\CommentController;
use App\Controllers\ProfileController;
use App\Controllers\TagController;
use App\Controllers\UserController;
use CodeIgniter\Router\RouteCollection as Routes;

$routes->group('api', function (Routes $routes) {

    /**
     * Authentication
     */
    $routes->post('users/login', AuthenticationController::class . '::login');
    $routes->post('users', AuthenticationController::class . '::register');

    /**
     * Current user
     */
    $routes->get('user', UserController::class . '::index', ['filter' => 'auth:api']);
    $routes->put('user', UserController::class . '::update', ['filter' => 'auth:api']);

    /**
     * User profile
     */
    $routes->group('profiles/(:any)', ['filter' => 'auth:api'], function (Routes $routes) {
        
        $routes->get('/', ProfileController::class . '::show/$1');
        $routes->post('follow', ProfileController::class . '::follow/$1');
        $routes->delete('follow', ProfileController::class . '::unFollow/$1');
    });

    /**
     * Articles
     */
    $routes->group('articles', function (Routes $routes) {
        
        $routes->get('/', ArticleController::class . '::index', ['filter' => 'optional']);
        $routes->get('feed', ArticleController::class . '::feed', ['filter' => 'auth:api']);
        $routes->post('create', ArticleController::class . '::store', ['filter' => 'auth:api']);
        $routes->get('(:any)/show', ArticleController::class . '::show/$1', ['filter' => 'optional']);
        $routes->put('(:any)/update', ArticleController::class . '::update/$1', ['filter' => 'auth:api']);
        $routes->delete('(:any)/destroy', ArticleController::class . '::destroy/$1', ['filter' => 'auth:api']);

        /**
         * Comments
         */
        $routes->post('(:any)/comments', CommentController::class . '::store/$1', ['filter' => 'auth:api']);
        $routes->get('(:any)/comments',  CommentController::class . '::index/$1', ['filter' => 'auth:api']);
        $routes->delete('(:any)/comments/(:num)', CommentController::class . '::destroy/$1/$2', ['filter' => 'auth:api']);

        /**
         * Favorites
         */
        $routes->post('(:any)/favorite', ArticleController::class . '::addFavorite/$1', ['filter' => 'auth:api']);
        $routes->delete('(:any)/favorite', ArticleController::class . '::unFavorite/$1', ['filter' => 'auth:api']);
    });

    /**
     * Tags
     */
    $routes->get('tags', TagController::class . '::index');
});