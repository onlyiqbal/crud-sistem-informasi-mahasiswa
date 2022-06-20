<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Controller;

use Iqbal\Sistem\Informasi\Mahasiswa\App\View;
use Iqbal\Sistem\Informasi\Mahasiswa\Config\Database;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\SessionRepository;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\UserRepository;
use Iqbal\Sistem\Informasi\Mahasiswa\Service\SessionService;

class HomeController
{
     private SessionService $sessionService;

     public function __construct()
     {
          $connection = Database::getConnection();
          $userRepository = new UserRepository($connection);
          $sessionRepository = new SessionRepository($connection);
          $this->sessionService = new SessionService($sessionRepository, $userRepository);
     }

     public function index()
     {
          $user = $this->sessionService->current();
          if ($user == null) {
               View::renderIndex("Home/index", [
                    'title' => 'Login Admin'
               ]);
          } else {
               // render halaman mahasiswa
               View::renderDashboard("Home/dashboard", [
                    "title" => "Sistem Infromasi Mahasiswa"
               ]);
          }
     }
}
