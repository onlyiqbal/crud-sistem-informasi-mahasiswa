<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Repository;

use Iqbal\Sistem\Informasi\Mahasiswa\Config\Database;
use Iqbal\Sistem\Informasi\Mahasiswa\Domain\Session;
use Iqbal\Sistem\Informasi\Mahasiswa\Domain\User;
use PHPUnit\Framework\TestCase;

class SessionRepositoryTest extends TestCase
{
     private SessionRepository $sessionRepository;
     private UserRepository $userRepository;

     protected function setUp(): void
     {
          $this->userRepository = new UserRepository(Database::getConnection());
          $this->sessionRepository = new SessionRepository(Database::getConnection());

          $this->sessionRepository->deleteAll();
          $this->userRepository->deleteAll();

          $user = new User();
          $user->id = "budi";
          $user->username = "Budi";
          $user->password = "qwerty";
          $this->userRepository->save($user);
     }

     public function testSaveSuccess()
     {
          $session = new Session();
          $session->id = uniqid();
          $session->user_id = "budi";

          $this->sessionRepository->save($session);

          $result = $this->sessionRepository->findById($session->id);

          $this->assertEquals($session->id, $result->id);
          $this->assertEquals($session->user_id, $result->user_id);
     }

     public function testdeleteByIdSuccess()
     {
          $session = new Session();
          $session->id = uniqid();
          $session->user_id = "budi";

          $this->sessionRepository->save($session);

          $result = $this->sessionRepository->deleteById($session->id);

          $this->assertNull($result);
     }

     public function testDeleteByIdNotFound()
     {
          $result = $this->sessionRepository->deleteById("tidak ada");

          $this->assertNull($result);
     }
}
