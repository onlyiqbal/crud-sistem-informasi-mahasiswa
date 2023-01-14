<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Service;

use Iqbal\Sistem\Informasi\Mahasiswa\Domain\Session;
use Iqbal\Sistem\Informasi\Mahasiswa\Domain\User;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\SessionRepository;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\UserRepository;

class SessionService
{
     public static string $COOKIE_NAME = "X-IQBAL-SESSION";
     private SessionRepository $sessionRepository;
     private UserRepository $userRepository;

     public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
     {
          $this->sessionRepository = $sessionRepository;
          $this->userRepository = $userRepository;
     }

     public function create(string $user_id): Session
     {
          $session = new Session();
          $session->id = uniqid();
          $session->user_id = $user_id;

          $this->sessionRepository->save($session);

          setcookie(self::$COOKIE_NAME, $session->id, time() + (60 * 60 * 24 * 30), "/");

          return $session;
     }

     public function destroy(): void
     {
          $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? "";
          $this->sessionRepository->deleteById($sessionId);

          setcookie(self::$COOKIE_NAME, "", 1, "/");
     }

     public function current(): ?User
     {
          $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? "";

          $session = $this->sessionRepository->findById($sessionId);
          if ($session == null) {
               return null;
          } else {
               return $this->userRepository->findById($session->user_id);
          }
     }
}
