<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Controller;

use Iqbal\Sistem\Informasi\Mahasiswa\Config\Database;
use Iqbal\Sistem\Informasi\Mahasiswa\Domain\Session;
use Iqbal\Sistem\Informasi\Mahasiswa\Domain\User;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\SessionRepository;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\UserRepository;
use Iqbal\Sistem\Informasi\Mahasiswa\Service\SessionService;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
     private HomeController $homeController;
     private UserRepository $userRepository;
     private SessionRepository $sessionRepository;

     protected function setUp(): void
     {
          $this->homeController = new HomeController();
          $this->sessionRepository = new SessionRepository(Database::getConnection());
          $this->userRepository = new UserRepository(Database::getConnection());

          $this->sessionRepository->deleteAll();
          $this->userRepository->deleteAll();
     }

     public function testGuest()
     {
          $this->homeController->index();
          $this->expectOutputRegex("[]");
     }

     public function testUserLogin()
     {
          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = "qwerty";
          $this->userRepository->save($user);

          $session = new Session();
          $session->id = uniqid();
          $session->user_id = $user->id;
          $this->sessionRepository->save($session);

          $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

          $this->homeController->index();

          $this->expectOutputRegex("[Dashboard Sistem Informasi Mahasiswa]");
     }
}
