# Aplikasi Sistem Informasi Mahasiswa
## Aplikasi CRUD Sistem Informasi Mahasiswa sederhana menggunakan PHP Native
## Spesifikasi Aplikasi :
- Menggunakan konsep MVC
- Menggunakan Repository Pattern
- PHP Native
- Database MySQL
- Server : PHP Development Server
## Cara menggunakan aplikasi :
- Clone repository ini atau download file zip.
- Buat dua database, database "db_student" dan "db_student_test" (unit test).
- Import file sql script yang terdapat didalam projectnaya sesuai dengan nama databasenya.
- Buka folder projectnya menggunkan text editor, lalu buka terminal bawaan dari text editornya.
- Masuk ke folder public dan aktifkan php development server, ketik "php -S localhost:8080".
- Jika sudah aktif, akses url "localhost:8080" di browser maka aplikasi sudah bisa digunakan.
## Cara menjalankan unit test :
- Pastikan sudah menginstall composer php.
- Buka folder projectnya menggunkan text editor, lalu buka terminal bawaanya.
- Ketik diterminal "composer install" maka seluruh dependency akan terinstall.
- Setelah terinstall ketik diterminal "vendor/bin/phpunit tests" maka seluruh unit test akan berjalan.