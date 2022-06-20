<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Repository;

use Iqbal\Sistem\Informasi\Mahasiswa\Config\Database;
use Iqbal\Sistem\Informasi\Mahasiswa\Domain\User;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
     private UserRepository $userRepository;

     protected function setUp(): void
     {
          $this->userRepository = new UserRepository(Database::getConnection());
          $this->userRepository->deleteAll();
     }

     public function testSaveSuccess()
     {
          $user = new User();
          $user->id = 'budi';
          $user->username = 'Budi';
          $user->password = 'qwerty';

          $this->userRepository->save($user);

          $result = $this->userRepository->findById('budi');

          $this->assertEquals($user->id, $result->id);
          $this->assertEquals($user->username, $result->username);
          $this->assertEquals($user->password, $result->password);
     }

     public function testFindByIdNotFound()
     {
          $user = $this->userRepository->findById('tidak ada');
          $this->assertNull($user);
     }

     public function testFindByUsernameNotFound()
     {
          $user = $this->userRepository->findByUsername('tidak ada');
          $this->assertNull($user);
     }
}
