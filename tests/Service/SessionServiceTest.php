<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Service;

require_once __DIR__ . "/../Helper/helper.php";

use Iqbal\Sistem\Informasi\Mahasiswa\Config\Database;
use Iqbal\Sistem\Informasi\Mahasiswa\Domain\Session;
use Iqbal\Sistem\Informasi\Mahasiswa\Domain\User;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\SessionRepository;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class SessionServiceTest extends TestCase
{
     private SessionService $sessionService;
     private SessionRepository $sessionRepository;
     private UserRepository $userRepository;

     protected function setUp(): void
     {
          $this->sessionRepository = new SessionRepository(Database::getConnection());
          $this->userRepository = new UserRepository(Database::getConnection());
          $this->sessionService = new SessionService($this->sessionRepository, $this->userRepository);

          $this->sessionRepository->deleteAll();
          $this->userRepository->deleteAll();

          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = "qwerty";
          $this->userRepository->save($user);
     }

     public function testCreate()
     {
          $session = $this->sessionService->create("budi");

          $this->expectOutputRegex("[X-IQBAL-SESSION: $session->id]");

          $result = $this->userRepository->findById($session->user_id);

          $this->assertEquals("budi", $result->id);
     }

     public function testDestroy()
     {
          $session = new Session();
          $session->id = uniqid();
          $session->user_id = "budi";

          $this->sessionRepository->save($session);
          $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

          $this->sessionService->destroy();

          $this->expectOutputRegex("[X-IQBAL-SESSION: ]");

          $result = $this->sessionRepository->findById($session->id);
          $this->assertNull($result);
     }

     public function testCurrent()
     {
          $session = new Session();
          $session->id = uniqid();
          $session->user_id = "budi";

          $this->sessionRepository->save($session);
          $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

          $result = $this->sessionService->current();

          $this->assertEquals($session->user_id, $result->id);
     }
}
