<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\App {
     function header(string $value)
     {
          echo $value;
     }
}

namespace Iqbal\Sistem\Informasi\Mahasiswa\Service {
     function setcookie(string $name, string $value)
     {
          echo "$name: $value";
     }
}
