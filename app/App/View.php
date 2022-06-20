<?php

namespace Iqbal\Sistem\Informasi\Mahasiswa\App;

class View
{
     static function renderIndex(string $view, $model)
     {
          require_once __DIR__ . "/../View/" . $view . ".php";
     }

     static function renderRegister(string $view, $model)
     {
          require_once __DIR__ . "/../View/" . $view . ".php";
     }

     static function renderDashboard(string $view, $model)
     {
          require_once __DIR__ . "/../View/" . $view . ".php";
     }

     static function renderStudent(string $view, $model)
     {
          require_once __DIR__ . "/../View/Student/header.php";
          require_once __DIR__ . "/../View/" . $view . ".php";
          require_once __DIR__ . "/../View/Student/footer.php";
     }

     static function redirect(string $url)
     {
          header("Location: $url");
          if (getenv("mode") != "test") {
               exit();
          }
     }
}
