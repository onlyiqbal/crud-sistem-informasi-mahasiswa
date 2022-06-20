<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Service;

use Iqbal\Sistem\Informasi\Mahasiswa\Config\Database;
use Iqbal\Sistem\Informasi\Mahasiswa\Domain\Student;
use Iqbal\Sistem\Informasi\Mahasiswa\Exception\ValidationException;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\StudentAddRequest;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\StudentUpdateRequest;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\StudentRepository;
use PHPUnit\Framework\TestCase;

class StudentServiceTest extends TestCase
{
     private StudentService $studentService;
     private StudentRepository $studentRepository;

     protected function setUp(): void
     {
          $this->studentRepository = new StudentRepository(Database::getConnection());
          $this->studentService = new StudentService($this->studentRepository);

          $this->studentRepository->deleteAll();
     }

     public function testAddSuccess()
     {
          $request = new StudentAddRequest();
          $request->nim = "56781234";
          $request->nama = "Budi";
          $request->tempat_lahir = "Bandung";
          $request->tgl = "25";
          $request->bln = "06";
          $request->thn = "2001";
          $request->fakultas = "Teknik";
          $request->jurusan = "Teknik Informatika";
          $request->ipk = 3.65;

          $tanggal_lahir = $request->thn . "-" . $request->bln . "-" . $request->tgl;

          $response = $this->studentService->add($request);

          $this->assertEquals($response->student->nim, $request->nim);
          $this->assertEquals($response->student->tanggal_lahir, $tanggal_lahir);
          $this->assertEquals($response->student->ipk, $request->ipk);
     }

     public function testAddFaild()
     {
          $this->expectException(ValidationException::class);
          $request = new StudentAddRequest();
          $request->nim = "";
          $request->nama = "";
          $request->tempat_lahir = "";
          $request->tgl = "";
          $request->bln = "";
          $request->thn = "";
          $request->fakultas = "";
          $request->jurusan = "";
          $request->ipk = null;

          $this->studentService->add($request);
     }

     public function testShow()
     {
          $result = $this->studentService->show();

          $this->assertNotNull($result);
     }

     public function testShowByNim()
     {
          $student = new Student();
          $student->nim = "12345678";
          $student->nama = "Budi";
          $student->tempat_lahir = "Bandung";
          $student->tanggal_lahir = "2002-06-09";
          $student->fakultas = "Teknik";
          $student->jurusan = "Teknik Informatika";
          $student->ipk = 2.65;
          $this->studentRepository->save($student);

          $result = $this->studentService->editStudent("12345678");

          $this->assertNotNull($result);
     }

     public function testUpdateDataSuccess()
     {
          $student = new Student();
          $student->nim = "12345678";
          $student->nama = "Budi";
          $student->tempat_lahir = "Bandung";
          $student->tanggal_lahir = "2002-06-09";
          $student->fakultas = "Teknik";
          $student->jurusan = "Teknik Informatika";
          $student->ipk = 2.65;
          $this->studentRepository->save($student);

          $request = new StudentUpdateRequest();
          $request->nim = "12345678";
          $request->nama = "Udin";
          $request->tempat_lahir = "Cilacap";
          $request->tgl = "15";
          $request->bln = "12";
          $request->thn = "2001";
          $request->fakultas = "Teknik";
          $request->jurusan = "Teknik Industri";
          $request->ipk = 2.85;
          $this->studentService->updateStudent($request);

          $result = $this->studentRepository->findByNim($student->nim);

          $this->assertEquals($result->nama, $request->nama);
          $this->assertEquals($result->tempat_lahir, $request->tempat_lahir);
          $this->assertEquals($result->jurusan, $request->jurusan);
     }

     public function testUpdateStudentFaild()
     {
          $this->expectException(ValidationException::class);

          $request = new StudentUpdateRequest();
          $request->nim = "12345678";
          $request->nama = "";
          $request->tempat_lahir = "";
          $request->tgl = "";
          $request->bln = "";
          $request->thn = "";
          $request->fakultas = "";
          $request->jurusan = "";
          $request->ipk = "";
          $this->studentService->updateStudent($request);
     }

     public function testUpdateStudentNotFound()
     {
          $this->expectException(ValidationException::class);

          $request = new StudentUpdateRequest();
          $request->nim = "12345610";
          $request->nama = "Udin";
          $request->tempat_lahir = "Cilacap";
          $request->tgl = "15";
          $request->bln = "12";
          $request->thn = "2001";
          $request->fakultas = "Teknik";
          $request->jurusan = "Teknik Industri";
          $request->ipk = 2.85;
          $this->studentService->updateStudent($request);
     }

     public function testDeleteStudentSuccess()
     {
          $student = new Student();
          $student->nim = "12345678";
          $student->nama = "Budi";
          $student->tempat_lahir = "Bandung";
          $student->tanggal_lahir = "2002-06-09";
          $student->fakultas = "Teknik";
          $student->jurusan = "Teknik Informatika";
          $student->ipk = 2.65;
          $this->studentRepository->save($student);

          $result = $this->studentService->deleteStudentByNim($student->nim);

          $this->assertNull($result);
     }
}
