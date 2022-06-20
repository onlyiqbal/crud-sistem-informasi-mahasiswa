<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Middleware {
     require_once __DIR__ . "/../Helper/helper.php";

     use Iqbal\Sistem\Informasi\Mahasiswa\Config\Database;
     use Iqbal\Sistem\Informasi\Mahasiswa\Domain\Session;
     use Iqbal\Sistem\Informasi\Mahasiswa\Domain\User;
     use Iqbal\Sistem\Informasi\Mahasiswa\Repository\SessionRepository;
     use Iqbal\Sistem\Informasi\Mahasiswa\Repository\UserRepository;
     use Iqbal\Sistem\Informasi\Mahasiswa\Service\SessionService;
     use PHPUnit\Framework\TestCase;

     class MustNotLoginMiddlewareTest extends TestCase
     {
          private MustNotLoginMiddleware $mustNotLoginMiddleware;
          private UserRepository $userRepository;
          private SessionRepository $sessionRepository;

          protected function setUp(): void
          {
               $this->mustNotLoginMiddleware = new MustNotLoginMiddleware();
               putenv("mode=test");

               $this->userRepository = new UserRepository(Database::getConnection());
               $this->sessionRepository = new SessionRepository(Database::getConnection());

               $this->sessionRepository->deleteAll();
               $this->userRepository->deleteAll();
          }


          public function testBeforeForGuest()
          {
               $this->mustNotLoginMiddleware->before();
               $this->expectOutputString("");
          }

          public function testBeforeForMember()
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

               $this->mustNotLoginMiddleware->before();
               $this->expectOutputRegex("[Location: /]");
          }
     }
}
