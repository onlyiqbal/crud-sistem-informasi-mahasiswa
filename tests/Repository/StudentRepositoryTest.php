<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Repository;

use Iqbal\Sistem\Informasi\Mahasiswa\Config\Database;
use Iqbal\Sistem\Informasi\Mahasiswa\Domain\Student;
use PHPUnit\Framework\TestCase;

class StudentRepositoryTest extends TestCase
{
     private StudentRepository $studentRepository;

     protected function setUp(): void
     {
          $this->studentRepository = new StudentRepository(Database::getConnection());
          $this->studentRepository->deleteAll();
     }

     public function testSaveSuccess()
     {
          $student = new Student();
          $student->nim = "12345678";
          $student->nama = "Budi";
          $student->tempat_lahir = "Cilacap";
          $student->tanggal_lahir = "2001-07-20";
          $student->fakultas = "Teknik";
          $student->jurusan = "Teknik Informatika";
          $student->ipk = 3.75;
          $this->studentRepository->save($student);

          $result = $this->studentRepository->findByNim($student->nim);

          $this->assertEquals($result->nim, $student->nim);
          $this->assertEquals($result->tanggal_lahir, $student->tanggal_lahir);
          $this->assertEquals($result->ipk, $student->ipk);
     }

     public function testFindByNimNotFound()
     {
          $result = $this->studentRepository->findByNim("not found");
          $this->assertNull($result);
     }

     public function testShowAll()
     {
          $result = $this->studentRepository->showAll();

          $this->assertNotNull($result);
     }

     public function testUpdate()
     {
          $student = new Student();
          $student->nim = "12345678";
          $student->nama = "Budi";
          $student->tempat_lahir = "Cilacap";
          $student->tanggal_lahir = "2001-07-20";
          $student->fakultas = "Teknik";
          $student->jurusan = "Teknik Informatika";
          $student->ipk = 3.75;
          $this->studentRepository->save($student);

          $student->tempat_lahir = "Bandung";
          $this->studentRepository->update($student);

          $result = $this->studentRepository->findByNim($student->nim);

          $this->assertEquals($result->nim, $student->nim);
          $this->assertEquals($result->nama, $student->nama);
          $this->assertEquals($result->tempat_lahir, $student->tempat_lahir);
          $this->assertEquals($result->tanggal_lahir, $student->tanggal_lahir);
     }

     public function testDeleteSuccess()
     {
          $student = new Student();
          $student->nim = "12345678";
          $student->nama = "Budi";
          $student->tempat_lahir = "Cilacap";
          $student->tanggal_lahir = "2001-07-20";
          $student->fakultas = "Teknik";
          $student->jurusan = "Teknik Informatika";
          $student->ipk = 3.75;
          $this->studentRepository->save($student);

          $result = $this->studentRepository->deleteByNim($student->nim);

          $this->assertNull($result);
     }
}
