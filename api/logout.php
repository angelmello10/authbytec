<?php

require_once __DIR__ . "/../libservidorphp/manejaErrores.php";
require_once __DIR__ . "/../libservidorphp/devuelveNoContent.php";
require_once __DIR__ . "/SAN.php";
require_once __DIR__ . "/ROL_IDS.php";

session_start();

if (isset($_SESSION[SAN])) {
 unset($_SESSION[SAN]);
}
if (isset($_SESSION[ROL_IDS])) {
 unset($_SESSION[ROL_IDS]);
}

session_destroy();

devuelveNoContent();
