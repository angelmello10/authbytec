<?php

require_once __DIR__ . "/../libservidorphp/manejaErrores.php";
require_once __DIR__ . "/protege.php";
require_once __DIR__ . "/../libservidorphp/devuelveJson.php";
require_once __DIR__ . "/jsonMiNav.php";

list($san, $rolIds) = protege([]);

if ($san === "") {
 devuelveJson([
  ...jsonMiNav($san, $rolIds),
  "login" => ["hidden" => false],
  "outputSan" => ["value" => "No has iniciado sesión."],
  "outputRoles" => ["value" => ""],
 ]);
} else {
 devuelveJson([
  ...jsonMiNav($san, $rolIds),
  "botonLogout" => ["hidden" => false],
  "outputSan" => ["value" => $san],
  "outputRoles" => [
   "value" => count($rolIds) === 0
    ? "Sin roles."
    : implode(", ", $rolIds),
  ],
 ]);
}
