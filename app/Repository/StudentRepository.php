<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Repository;

use Iqbal\Sistem\Informasi\Mahasiswa\Domain\Student;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\StudentAddRequest;
use PDO;

class StudentRepository
{
     private PDO $connection;

     public function __construct(PDO $connection)
     {
          $this->connection = $connection;
     }

     public function save(Student $student): Student
     {
          $statement = $this->connection->prepare("INSERT INTO students(nim, nama, tempat_lahir, tanggal_lahir, fakultas, jurusan, ipk) VALUES (?,?,?,?,?,?,?)");

          $statement->execute([$student->nim, $student->nama, $student->tempat_lahir, $student->tanggal_lahir, $student->fakultas, $student->jurusan, $student->ipk]);

          return $student;
     }

     public function findByNim(string $nim): ?Student
     {
          $statement = $this->connection->prepare("SELECT nim, nama, tempat_lahir, tanggal_lahir, fakultas, jurusan, ipk FROM students WHERE nim = ?");
          $statement->execute([$nim]);

          try {
               if ($row = $statement->fetch()) {
                    $student = new Student();
                    $student->nim = $row['nim'];
                    $student->nama = $row['nama'];
                    $student->tempat_lahir = $row['tempat_lahir'];
                    $student->tanggal_lahir = $row['tanggal_lahir'];
                    $student->fakultas = $row['fakultas'];
                    $student->jurusan = $row['jurusan'];
                    $student->ipk = $row['ipk'];

                    return $student;
               } else {
                    return null;
               }
          } finally {
               $statement->closeCursor();
          }
     }

     public function deleteAll()
     {
          $this->connection->exec("DELETE FROM students");
     }

     public function showAll()
     {
          $statement = $this->connection->query("SELECT nim, nama, tempat_lahir, tanggal_lahir,fakultas, jurusan, ipk FROM students");

          return $statement;
     }

     public function update(Student $student): Student
     {
          $statement = $this->connection->prepare("UPDATE students SET nim = ?, nama = ?, tempat_lahir = ?, tanggal_lahir = ?, fakultas = ?, jurusan = ?, ipk = ? WHERE nim = ?");

          $statement->execute([$student->nim, $student->nama, $student->tempat_lahir, $student->tanggal_lahir, $student->fakultas, $student->jurusan, $student->ipk, $student->nim]);

          return $student;
     }

     public function deleteByNim(string $nim)
     {
          $statement = $this->connection->prepare("DELETE FROM students WHERE nim = ?");
          $statement->execute([$nim]);
     }
}
