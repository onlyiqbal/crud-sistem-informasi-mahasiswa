<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Controller {
     require_once __DIR__ . "/../Helper/helper.php";

     use Iqbal\Sistem\Informasi\Mahasiswa\Config\Database;
     use Iqbal\Sistem\Informasi\Mahasiswa\Domain\Student;
     use Iqbal\Sistem\Informasi\Mahasiswa\Repository\StudentRepository;
     use PHPUnit\Framework\TestCase;

     class StudentControllerTest extends TestCase
     {
          private StudentController $studentController;
          private StudentRepository $studentRepository;

          protected function setUp(): void
          {
               $this->studentController = new StudentController();
               $this->studentRepository = new StudentRepository(Database::getConnection());

               $this->studentRepository->deleteAll();

               putenv("mode=test");
          }

          public function testAdd()
          {
               $this->studentController->add();

               $this->expectOutputRegex("[Tambah Data Mahasiswa]");
               $this->expectOutputRegex("[Tampil]");
               $this->expectOutputRegex("[Tambah]");
               $this->expectOutputRegex("[Edit]");
               $this->expectOutputRegex("[Hapus]");
               $this->expectOutputRegex("[Logout]");
          }

          public function testPostAdd()
          {
               $_POST['nim'] = "12345678";
               $_POST['nama'] = "Japra";
               $_POST['tempat_lahir'] = "Bandung";
               $_POST['tgl'] = "25";
               $_POST['bln'] = "07";
               $_POST['thn'] = "2000";
               $_POST['fakultas'] = "Teknik";
               $_POST['jurusan'] = "Teknik Informatika";
               $_POST['ipk'] = 2.57;
               $this->studentController->postAdd();

               $this->expectOutputRegex("[Location: /students/show]");
          }

          public function testShow()
          {
               $this->studentController->show();

               $this->expectOutputRegex("[Data Mahasiswa]");
               $this->expectOutputRegex("[NIM]");
               $this->expectOutputRegex("[Nama]");
               $this->expectOutputRegex("[Tempat Lahir]");
               $this->expectOutputRegex("[Tanggal Lahir]");
               $this->expectOutputRegex("[Fakultas]");
          }

          public function testEdit()
          {
               $this->studentController->edit();

               $this->expectOutputRegex("[Edit Data Mahasiswa]");
               $this->expectOutputRegex("[Edit]");
               $this->expectOutputRegex("[NIM]");
               $this->expectOutputRegex("[Nama]");
               $this->expectOutputRegex("[Tempat Lahir]");
               $this->expectOutputRegex("[Tanggal Lahir]");
               $this->expectOutputRegex("[Fakultas]");
          }

          public function testPostEdit()
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

               $this->studentController->postEdit($student->nim);

               $this->expectOutputRegex("[Edit Data Mahasiswa]");
               $this->expectOutputRegex("[Mahasiswa Baru]");
               $this->expectOutputRegex("[Update Data]");
          }

          public function testUpdateSuccess()
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

               $_POST['nim'] = "12345678";
               $_POST['nama'] = "Bambang";
               $_POST['tempat_lahir'] = "Bandung";
               $_POST['tgl'] = "25";
               $_POST['bln'] = "12";
               $_POST['thn'] = "2005";
               $_POST['fakultas'] = "FMIPA";
               $_POST['jurusan'] = "Biologi";
               $_POST['ipk'] = "2.45";
               $this->studentController->postUpdate();

               $this->expectOutputRegex("[Location: /students/show]");

               $result = $this->studentRepository->findByNim("12345678");

               $this->assertEquals($result->nama, "Bambang");
          }

          public function testUpdateFaild()
          {
               $_POST['nim'] = "12345678";
               $_POST['nama'] = null;
               $_POST['tempat_lahir'] = null;
               $_POST['tgl'] = "25";
               $_POST['bln'] = "12";
               $_POST['thn'] = "2005";
               $_POST['fakultas'] = "FMIPA";
               $_POST['jurusan'] = "Biologi";
               $_POST['ipk'] = "2.45";
               $this->studentController->postUpdate();

               $this->expectOutputRegex("[]");
          }

          public function testDelete()
          {
               $this->studentController->delete();

               $this->expectOutputRegex("[Hapus Data Mahsiswa]");
               $this->expectOutputRegex("[Hapus]");
          }

          public function testPostDeleteSuccess()
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

               $this->studentController->postDelete($student->nim);

               $this->expectOutputRegex("[Location: /students/show]");

               $result = $this->studentRepository->findByNim($student->nim);

               $this->assertNull($result);
          }
     }
}
