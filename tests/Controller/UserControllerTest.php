<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Controller {
     require_once __DIR__ . "/../Helper/helper.php";

     use Iqbal\Sistem\Informasi\Mahasiswa\Config\Database;
     use Iqbal\Sistem\Informasi\Mahasiswa\Domain\Session;
     use Iqbal\Sistem\Informasi\Mahasiswa\Domain\User;
     use Iqbal\Sistem\Informasi\Mahasiswa\Repository\SessionRepository;
     use Iqbal\Sistem\Informasi\Mahasiswa\Repository\UserRepository;
     use PHPUnit\Framework\TestCase;

     class UserControllerTest extends TestCase
     {
          private UserController $userController;
          private UserRepository $userRepository;
          private SessionRepository $sessionRepository;

          protected function setUp(): void
          {
               $this->userController = new UserController();

               $this->sessionRepository = new SessionRepository(Database::getConnection());
               $this->sessionRepository->deleteAll();

               $this->userRepository = new UserRepository(Database::getConnection());
               $this->userRepository->deleteAll();

               putenv("mode=test");
          }

          public function testRegister()
          {
               $this->userController->register();

               $this->expectOutputRegex("[Register Admin]");
          }

          public function testPostRegisterSuccess()
          {
               $_POST['id'] = "budi";
               $_POST['username'] = "Budi";
               $_POST['password'] = "qwerty";
               $this->userController->postRegister();

               $this->expectOutputRegex("[Location: /users/login]");
          }

          public function testRegisterValidationError()
          {
               $_POST['id'] = "";
               $_POST['username'] = "";
               $_POST['password'] = "";

               $this->userController->postRegister();
               $this->expectOutputRegex("[]");
          }

          public function testPostRegisterDuplicate()
          {
               $user = new User();
               $user->id = 'budi';
               $user->username = 'Budi';
               $user->password = 'qwerty';
               $this->userRepository->save($user);

               $_POST['id'] = "budi";
               $_POST['username'] = "Budi";
               $_POST['password'] = "qwerty";
               $this->userController->postRegister();

               $this->expectOutputRegex("[]");
          }

          public function testLoginSuccess()
          {
               $user = new User();
               $user->id = "budi";
               $user->username = "Budi";
               $user->password = password_hash("qwerty", PASSWORD_BCRYPT);
               $this->userRepository->save($user);

               $_POST['username'] = "budi";
               $_POST['password'] = "qwerty";

               $this->userController->postLogin();

               $this->expectOutputRegex("[Location: /]");
               $this->expectOutputRegex("[X-IQBAL-SESSION]");
          }

          public function testLoginValidationError()
          {
               $_POST['username'] = "";
               $_POST['password'] = "";

               $this->userController->postLogin();

               $this->expectOutputRegex("[]");
          }

          public function testLoginNotFound()
          {
               $_POST['username'] = "tidak ada";
               $_POST['password'] = "tidak ada";

               $this->userController->postLogin();
               $this->expectOutputRegex("[]");
          }

          public function testLoginPasswordWrong()
          {
               $user = new User();
               $user->id = "budi";
               $user->username = "Budi";
               $user->password = password_hash("qwerty", PASSWORD_BCRYPT);
               $this->userRepository->save($user);

               $_POST['username'] = "Budi";
               $_POST['password'] = "salah";
               $this->userController->postLogin();

               $this->expectOutputRegex("[]");
          }

          public function testLogout()
          {
               $user = new User();
               $user->id = "budi";
               $user->username = "Budi";
               $user->password = password_hash("qwerty", PASSWORD_BCRYPT);
               $this->userRepository->save($user);

               $session = new Session();
               $session->id = uniqid();
               $session->user_id = $user->id;
               $this->sessionRepository->save($session);

               $this->userController->logout();

               $this->expectOutputRegex("[Location: /]");
               $this->expectOutputRegex("[X-IQBAL-SESSION]");
          }
     }
}
