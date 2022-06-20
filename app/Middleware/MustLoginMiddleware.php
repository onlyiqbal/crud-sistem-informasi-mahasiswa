<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Middleware;

use Iqbal\Sistem\Informasi\Mahasiswa\App\View;
use Iqbal\Sistem\Informasi\Mahasiswa\Config\Database;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\SessionRepository;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\UserRepository;
use Iqbal\Sistem\Informasi\Mahasiswa\Service\SessionService;

class MustLoginMiddleware implements Middleware
{
     private SessionService $sessionService;

     public function __construct()
     {
          $userRepository = new UserRepository(Database::getConnection());
          $sessionRepository = new SessionRepository(Database::getConnection());
          $this->sessionService = new SessionService($sessionRepository, $userRepository);
     }

     public function before(): void
     {
          $user = $this->sessionService->current();
          if ($user == null) {
               View::redirect("/users/login");
          }
     }
}
