<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Controller;

use Iqbal\Sistem\Informasi\Mahasiswa\App\View;
use Iqbal\Sistem\Informasi\Mahasiswa\Config\Database;
use Iqbal\Sistem\Informasi\Mahasiswa\Exception\ValidationException;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\UserLoginRequest;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\UserRegistrationRequest;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\SessionRepository;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\UserRepository;
use Iqbal\Sistem\Informasi\Mahasiswa\Service\SessionService;
use Iqbal\Sistem\Informasi\Mahasiswa\Service\UserService;

class UserController
{
     private UserService $userService;
     private SessionService $sessionService;

     public function __construct()
     {
          $connection = Database::getConnection();
          $userRepository = new UserRepository($connection);
          $this->userService = new UserService($userRepository);

          $sessionRepository = new SessionRepository($connection);
          $this->sessionService = new SessionService($sessionRepository, $userRepository);
     }

     public function register()
     {
          View::renderRegister("User/register", [
               'title' => "Register Admin"
          ]);
     }

     public function postRegister()
     {
          $request = new UserRegistrationRequest();
          $request->id = $_POST['id'];
          $request->username = $_POST['username'];
          $request->password = $_POST['password'];

          try {
               $this->userService->registration($request);
               View::redirect('/users/login');
          } catch (ValidationException $exception) {
               View::renderRegister("User/register", [
                    'title' => 'Register Admin',
                    'error' => $exception->getMessage()
               ]);
          }
     }

     public function login()
     {
          View::renderIndex('Home/index', [
               'title' => 'Login Admin'
          ]);
     }

     public function postLogin()
     {
          $request = new UserLoginRequest();
          $request->username = $_POST['username'];
          $request->password = $_POST['password'];

          try {
               $response = $this->userService->login($request);
               $this->sessionService->create($response->user->id);
               // ke halaman dasboard
               View::redirect("/");
          } catch (ValidationException $exception) {
               View::renderIndex('Home/index', [
                    'title' => 'Login Admin',
                    'error' => $exception->getMessage(),
               ]);
          }
     }

     public function logout()
     {
          $this->sessionService->destroy();
          View::renderIndex('Home/index', [
               'title' => 'Login Admin'
          ]);
     }
}
