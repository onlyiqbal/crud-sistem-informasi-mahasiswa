<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\Config;

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase {
     public function testGetConnection() {
          $connection = Database::getConnection();
          self::assertNotNull($connection);
     }

     public function testSingleton(){
          $connection1 = Database::getConnection();
          $connection2 = Database::getConnection();
          self::assertSame($connection1, $connection2);
     }
}