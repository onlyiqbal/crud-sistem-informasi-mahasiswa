<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Controller;

use Iqbal\Sistem\Informasi\Mahasiswa\App\View;
use Iqbal\Sistem\Informasi\Mahasiswa\Config\Database;
use Iqbal\Sistem\Informasi\Mahasiswa\Exception\ValidationException;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\StudentAddRequest;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\StudentUpdateRequest;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\StudentRepository;
use Iqbal\Sistem\Informasi\Mahasiswa\Service\StudentService;

class StudentController
{
     private StudentService $studentService;

     public function __construct()
     {
          $connection = Database::getConnection();
          $studentRepository = new StudentRepository($connection);
          $this->studentService = new StudentService($studentRepository);
     }
     public function add()
     {
          View::renderStudent("Student/add", [
               "title" => "Tambah Data Mahasiswa"
          ]);
     }

     public function postAdd()
     {
          $request = new StudentAddRequest();
          $request->nim = $_POST['nim'];
          $request->nama = $_POST['nama'];
          $request->tempat_lahir = $_POST['tempat_lahir'];
          $request->tgl = $_POST['tgl'];
          $request->bln = $_POST['bln'];
          $request->thn = $_POST['thn'];
          $request->fakultas = $_POST['fakultas'];
          $request->jurusan = $_POST['jurusan'];
          $request->ipk = $_POST['ipk'];

          try {
               $this->studentService->add($request);
               View::redirect("/students/show");
          } catch (ValidationException $exception) {
               View::renderStudent("Student/add", [
                    'title' => "Tambah Data Mahasiswa",
                    'error' => $exception->getMessage(),
               ]);
          }
     }

     public function show()
     {
          View::renderStudent("Student/show", [
               "title" => "Data Mahasiswa",
               "students" => $this->studentService->show(),
          ]);
     }

     public function edit()
     {
          View::renderStudent("Student/edit", [
               "title" => "Edit Data Mahasiswa",
               "students" => $this->studentService->show()
          ]);
     }

     public function postEdit(string $nim)
     {
          View::renderStudent("Student/form_edit", [
               "title" => "Edit Data Mahasiswa",
               "student" => $this->studentService->editStudent($nim)
          ]);
     }

     public function postUpdate()
     {
          $request = new StudentUpdateRequest();
          $request->nim = $_POST['nim'];
          $request->nama = $_POST['nama'];
          $request->tempat_lahir = $_POST['tempat_lahir'];
          $request->tgl = $_POST['tgl'];
          $request->bln = $_POST['bln'];
          $request->thn = $_POST['thn'];
          $request->fakultas = $_POST['fakultas'];
          $request->jurusan = $_POST['jurusan'];
          $request->ipk = $_POST['ipk'];

          try {
               $this->studentService->updateStudent($request);
               View::redirect("/students/show");
          } catch (ValidationException $exception) {
               View::renderStudent("Student/form_edit", [
                    "title" => "Edit Data Mahasiswa",
                    "error" => $exception->getMessage()
               ]);
          }
     }

     public function delete()
     {
          View::renderStudent("Student/delete", [
               'title' => "Hapus Data Mahasiswa",
               'students' => $this->studentService->show()
          ]);
     }

     public function postDelete(string $nim)
     {
          try {
               $this->studentService->deleteStudentByNim($nim);
               View::redirect("/students/show");
          } catch (ValidationException $exception) {
               View::renderStudent("Student/delete", [
                    'title' => 'Hapus Data Mahasiswa',
                    'error' => $exception->getMessage(),
               ]);
          }
     }
}
