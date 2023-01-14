<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Service;

use Iqbal\Sistem\Informasi\Mahasiswa\Domain\Student;
use Iqbal\Sistem\Informasi\Mahasiswa\Exception\ValidationException;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\StudentAddRequest;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\StudentAddResponse;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\StudentUpdateRequest;
use Iqbal\Sistem\Informasi\Mahasiswa\Model\StudentUpdateResponse;
use Iqbal\Sistem\Informasi\Mahasiswa\Repository\StudentRepository;

class StudentService
{
     private StudentRepository $studentRepository;

     public function __construct(StudentRepository $studentRepository)
     {
          $this->studentRepository = $studentRepository;
     }

     public function add(StudentAddRequest $request): StudentAddResponse
     {
          $this->validateStudentAddRequest($request);

          $nim = $request->nim;
          $nama = $request->nama;
          $tempat_lahir = $request->tempat_lahir;
          $tgl = $request->tgl;
          $bln = $request->bln;
          $thn = $request->thn;
          $fakultas = $request->fakultas;
          $jurusan = $request->jurusan;
          $ipk = $request->ipk;
          // Gabung input tanggal lahir
          $tanggal_lahir = $thn . "-" . $bln . "-" . $tgl;

          $student = new Student();
          $student->nim = $nim;
          $student->nama = $nama;
          $student->tempat_lahir = $tempat_lahir;
          $student->tanggal_lahir = $tanggal_lahir;
          $student->fakultas = $fakultas;
          $student->jurusan = $jurusan;
          $student->ipk = $ipk;
          $this->studentRepository->save($student);

          $response = new StudentAddResponse();
          $response->student = $student;

          return $response;
     }

     private function validateStudentAddRequest(StudentAddRequest $request)
     {
          if ($request->nim == null || $request->nama == null || $request->tempat_lahir == null || $request->tgl == null || $request->bln == null || $request->thn == null || $request->fakultas == null || $request->jurusan == null || $request->ipk == null) {
               throw new ValidationException("Form tidak boleh kosong");
          }
     }

     public function show()
     {
          return $this->studentRepository->showAll();
     }

     public function editStudent(string $nim): array
     {
          $student = $this->studentRepository->findByNim($nim);

          $nim = $student->nim;
          $nama = $student->nama;
          $tempat_lahir = $student->tempat_lahir;
          $tgl = substr($student->tanggal_lahir, 8, 2);
          $bln = substr($student->tanggal_lahir, 5, 2);
          $thn = substr($student->tanggal_lahir, 0, 4);
          $fakultas = $student->fakultas;
          $jurusan = $student->jurusan;
          $ipk = $student->ipk;

          return [
               "nim" => $nim,
               "nama" => $nama,
               "tempat_lahir" => $tempat_lahir,
               "tgl" => $tgl,
               "bln" => $bln,
               "thn" => $thn,
               "fakultas" => $fakultas,
               "jurusan" => $jurusan,
               "ipk" => $ipk
          ];
     }

     public function updateStudent(StudentUpdateRequest $request): StudentUpdateResponse
     {
          $this->validateStudentDataUpdateRequest($request);

          $student = $this->studentRepository->findByNim($request->nim);
          if ($student == null) {
               throw new ValidationException("Mahasiswa tidak ditemukan");
          }

          $nim = $request->nim;
          $nama = $request->nama;
          $tempat_lahir = $request->tempat_lahir;
          $tgl = $request->tgl;
          $bln = $request->bln;
          $thn = $request->thn;
          $fakultas = $request->fakultas;
          $jurusan = $request->jurusan;
          $ipk = $request->ipk;
          // Gabung tanggal lahir
          $tanggal_lahir = $thn . "-" . $bln . "-" . $tgl;

          $student = new Student();
          $student->nim = $nim;
          $student->nama = $nama;
          $student->tempat_lahir = $tempat_lahir;
          $student->tanggal_lahir = $tanggal_lahir;
          $student->fakultas = $fakultas;
          $student->jurusan = $jurusan;
          $student->ipk = $ipk;
          $this->studentRepository->update($student);

          $response = new StudentUpdateResponse();
          $response->student = $student;

          return $response;
     }

     private function validateStudentDataUpdateRequest(StudentUpdateRequest $request)
     {
          if ($request->nim == null || $request->nama == null || $request->tempat_lahir == null || $request->tgl == null || $request->bln == null || $request->thn == null || $request->fakultas == null || $request->jurusan == null || $request->ipk == null) {
               throw new ValidationException("Form tidak boleh kosong");
          }
     }

     public function deleteStudentByNim(string $nim)
     {
          $student = $this->studentRepository->findByNim($nim);

          if ($student == null) {
               throw new ValidationException("Gagal Menghapus Data");
          }

          $this->studentRepository->deleteByNim($nim);
     }
}
