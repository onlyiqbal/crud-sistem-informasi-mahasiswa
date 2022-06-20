<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Iqbal\Sistem\Informasi\Mahasiswa\App\Router;
use Iqbal\Sistem\Informasi\Mahasiswa\Config\Database;
use Iqbal\Sistem\Informasi\Mahasiswa\Controller\HomeController;
use Iqbal\Sistem\Informasi\Mahasiswa\Controller\StudentController;
use Iqbal\Sistem\Informasi\Mahasiswa\Controller\UserController;
use Iqbal\Sistem\Informasi\Mahasiswa\Middleware\MustLoginMiddleware;
use Iqbal\Sistem\Informasi\Mahasiswa\Middleware\MustNotLoginMiddleware;

Database::getConnection('prod');

//Home Cotroller
Router::add("GET", "/", HomeController::class, 'index', []);

//User Controller
Router::add("GET", "/users/register", UserController::class, 'register', [MustNotLoginMiddleware::class]);

Router::add("POST", "/users/register", UserController::class, 'postRegister', [MustNotLoginMiddleware::class]);

Router::add("GET", "/users/login", UserController::class, 'login', [MustNotLoginMiddleware::class]);

Router::add("POST", "/users/login", UserController::class, 'postLogin', [MustNotLoginMiddleware::class]);

Router::add("GET", "/users/logout", UserController::class, 'logout', [MustLoginMiddleware::class]);

// Student Controller
Router::add("GET", "/students/add", StudentController::class, "add", [MustLoginMiddleware::class]);

Router::add("POST", "/students/add", StudentController::class, "postAdd", [MustLoginMiddleware::class]);

Router::add("GET", "/students/show", StudentController::class, "show", [MustLoginMiddleware::class]);

Router::add("GET", "/students/edit", StudentController::class, "edit", [MustLoginMiddleware::class]);

Router::add("POST", "/students/edit/([0-9a-zA-Z]*)", StudentController::class, "postEdit", [MustLoginMiddleware::class]);

Router::add("POST", "/students/update", StudentController::class, "postUpdate", [MustLoginMiddleware::class]);

Router::add("GET", "/students/delete", StudentController::class, "delete", [MustLoginMiddleware::class]);

Router::add("POST", "/students/delete/([0-9a-zA-Z]*)", StudentController::class, "postDelete", [MustLoginMiddleware::class]);

Router::run();
