<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\App;

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
     public function testIndex()
     {
          View::renderIndex('Home/index', [
               'title' => 'Login Admin',
          ]);
          $this->expectOutputRegex('[Selamat Datang]');
          $this->expectOutputRegex('[html]');
          $this->expectOutputRegex('[body]');
          $this->expectOutputRegex('[LOGIN]');
          $this->expectOutputRegex('[Username]');
          $this->expectOutputRegex('[Password]');
     }
}
