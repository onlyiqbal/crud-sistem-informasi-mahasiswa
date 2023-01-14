<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Service;

use Iqbal\Sistem\Informasi\Mahasiswa\Config\Database;
use Iqbal\Sistem\Informasi\Mahasiswa\Domain\User;
use Iqbal\Sistem\Informasi\Mahasiswa\Exception\ValidationException;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\UserLoginRequest;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\UserRegistrationRequest;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\SessionRepository;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
     private UserService $userService;
     private UserRepository $userRepository;
     private SessionRepository $sessionRepository;

     protected function setUp(): void
     {
          $connection = Database::getConnection();
          $this->userRepository = new UserRepository($connection);
          $this->userService = new UserService($this->userRepository);
          $this->sessionRepository = new SessionRepository($connection);

          $this->sessionRepository->deleteAll();
          $this->userRepository->deleteAll();
     }

     public function testRegisterSuccess()
     {
          $request = new UserRegistrationRequest();
          $request->id = "budi";
          $request->username = "Budi";
          $request->password = "qwerty";

          $response = $this->userService->register($request);

          $this->assertEquals($request->id, $response->user->id);
          $this->assertEquals($request->username, $response->user->username);
          $this->assertNotEquals($request->password, $response->user->password);

          $this->assertTrue(password_verify($request->password, $response->user->password));
     }

     public function testRegistrationFailed()
     {
          $this->expectException(ValidationException::class);
          $request = new UserRegistrationRequest();
          $request->id = '';
          $request->username = '';
          $request->password = '';

          $this->userService->register($request);
     }

     public function testUserRegistrationDuplicate()
     {
          $user = new User();
          $user->id = 'budi';
          $user->username = 'Budi';
          $user->password = 'qwerty';

          $this->userRepository->save($user);

          $this->expectException(ValidationException::class);

          $request = new UserRegistrationRequest();
          $request->id = 'budi';
          $request->username = 'Budi';
          $request->password = 'qwerty';

          $this->userService->register($request);
     }

     public function testLoginNotFound()
     {
          $this->expectException(ValidationException::class);

          $request = new UserLoginRequest();
          $request->username = "iqbal";
          $request->password = "rahasia";

          $this->userService->login($request);
     }

     public function testLoginPasswordWrong()
     {
          $user = new User();
          $user->id = 'budi';
          $user->username = 'Budi';
          $user->password = password_hash('qwerty', PASSWORD_BCRYPT);

          $this->expectException(ValidationException::class);

          $request = new UserLoginRequest();
          $request->username = 'iqbal';
          $request->password = 'rahasia';

          $this->userService->login($request);
     }

     public function testLoginSuccess()
     {
          $user = new User();
          $user->id = 'budi';
          $user->username = 'Budi';
          $user->password = password_hash('qwerty', PASSWORD_BCRYPT);

          $this->expectException(ValidationException::class);

          $request = new UserLoginRequest();
          $request->username = 'Budi';
          $request->password = 'qwerty';

          $response = $this->userService->login($request);

          $this->assertEquals($request->username, $response->user->username);
          $this->assertTrue(password_verify($request->password, $response->user->password));
     }
}
