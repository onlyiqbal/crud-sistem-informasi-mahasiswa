<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Service;

use Iqbal\Sistem\Informasi\Mahasiswa\Domain\User;
use Iqbal\Sistem\Informasi\Mahasiswa\Exception\ValidationException;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\UserLoginRequest;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\UserLoginResponse;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\UserRegistrationRequest;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\UserRegistrationResponse;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\UserRepository;

class UserService
{
     private UserRepository $userRepository;

     public function __construct(UserRepository $userRepository)
     {
          $this->userRepository = $userRepository;
     }

     public function registration(UserRegistrationRequest $request): UserRegistrationResponse
     {
          $this->validateUserRegistrationRequest($request);

          $user = $this->userRepository->findById($request->id);
          if ($user != null) {
               throw new ValidationException("Admin yang didaftarkan sudah ada");
          }

          $user = new User();
          $user->id = $request->id;
          $user->username = $request->username;
          $user->password = password_hash($request->password, PASSWORD_BCRYPT);
          $this->userRepository->save($user);

          $response = new UserRegistrationResponse();
          $response->user = $user;
          return $response;
     }

     private function validateUserRegistrationRequest(UserRegistrationRequest $request)
     {
          if ($request->id == null || $request->username == null || $request->password == null) {
               throw new ValidationException("Id, Username, Password tidak boleh kosong");
          }
     }

     public function login(UserLoginRequest $request): UserLoginResponse
     {
          $this->validateUserLoginRequest($request);

          $user = $this->userRepository->findByUsername($request->username);
          if ($user == null) {
               throw new ValidationException("Username atau password salah");
          }

          if (password_verify($request->password, $user->password)) {
               $response = new UserLoginResponse();
               $response->user = $user;
               return $response;
          } else {
               throw new ValidationException("Username atau password salah");
          }
     }

     private function validateUserLoginRequest(UserLoginRequest $request)
     {
          if ($request->username == null || trim($request->password) == null) {
               throw new ValidationException("Username atau password tidak boleh kosong");
          }
     }
}
