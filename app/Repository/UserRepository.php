<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Repository;

use Iqbal\Sistem\Informasi\Mahasiswa\Domain\User;
use PDO;

class UserRepository
{
     private PDO $connection;

     public function __construct(PDO $connection)
     {
          $this->connection = $connection;
     }

     public function save(User $user): User
     {
          $statement = $this->connection->prepare("INSERT INTO users(id, username, password) VALUES (?, ?, ?)");
          $statement->execute([
               $user->id, $user->username, $user->password
          ]);
          return $user;
     }

     public function findById(string $id): ?User
     {
          $statement = $this->connection->prepare("SELECT id, username, password FROM users WHERE id = ?");
          $statement->execute([$id]);

          try {
               if ($row = $statement->fetch()) {
                    $user = new User();
                    $user->id = $row['id'];
                    $user->username = $row['username'];
                    $user->password = $row['password'];
                    return $user;
               } else {
                    return null;
               }
          } finally {
               $statement->closeCursor();
          }
     }

     public function findByUsername(string $username): ?User
     {
          $statement = $this->connection->prepare("SELECT id, username, password FROM users WHERE username = ?");
          $statement->execute([$username]);

          try {
               if ($row = $statement->fetch()) {
                    $user = new User();
                    $user->id = $row['id'];
                    $user->username = $row['username'];
                    $user->password = $row['password'];
                    return $user;
               } else {
                    return null;
               }
          } finally {
               $statement->closeCursor();
          }
     }

     public function deleteAll(): void
     {
          $this->connection->exec("DELETE FROM users");
     }
}
