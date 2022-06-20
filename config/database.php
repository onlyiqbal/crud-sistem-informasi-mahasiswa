<?php

function getDatabaseConfig(): array {
     return [
          "database" => [
               "test" => [
                    "url" => "mysql:host=localhost:3306;dbname=db_student_test",
                    "username" => "root",
                    "password" => ""
               ],
               "prod" => [
                    "url" => "mysql:host=localhost:3306;dbname=db_student",
                    "username" => "root",
                    "password" => ""
               ]
          ]
     ];
}