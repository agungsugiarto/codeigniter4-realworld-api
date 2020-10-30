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
    $routes->get('user', UserController::class . '::index', ['filter' => 'api']);
    $routes->put('user', UserController::class . '::update', ['filter' => 'api']);

    /**
     * User profile
     */
    $routes->group('profiles/(:any)', ['filter' => 'api'], function (Routes $routes) {
        
        $routes->get('/', ProfileController::class . '::show/$1');
        $routes->post('follow', ProfileController::class . '::follow/$1');
        $routes->delete('follow', ProfileController::class . '::unFollow/$1');
    });

    /**
     * Articles
     */
    $routes->get('articles', ArticleController::class . '::index');
    $routes->post('articles/create', ArticleController::class . '::store', ['filter' => 'api']);
    $routes->get('articles/feed', ArticleController::class . '::feed', ['filter' => 'api']);

    $routes->group('articles/([^/]+)', function (Routes $routes) {

        $routes->get('/', ArticleController::class . '::show/$1');
        $routes->put('/', ArticleController::class . '::update/$1', ['filter' => 'api']);
        $routes->delete('/', ArticleController::class . '::destroy/$1', ['filter' => 'api']);

        /**
         * Comments
         */
        $routes->post('comments', CommentController::class . '::store/$1', ['filter' => 'api']);
        $routes->get('comments',  CommentController::class . '::index/$1', ['filter' => 'api']);
        $routes->delete('comments/(:num)', CommentController::class . '::destroy/$1/$2', ['filter' => 'api']);

        /**
         * Favorites
         */
        $routes->post('favorite', ArticleController::class . '::addFavorite/$1', ['filter' => 'api']);
        $routes->delete('favorite', ArticleController::class . '::unFavorite/$1', ['filter' => 'api']);
    });

    /**
     * Tags
     */
    $routes->get('tags', TagController::class . '::index');
});