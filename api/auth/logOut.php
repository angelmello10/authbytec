<?php
session_start();

require_once __DIR__ . "/../../libservidorphp/devuelveJson.php";

unset($_SESSION['user']);
session_destroy();

devuelveJson([
    'success' => true,
    'message' => 'Sesión cerrada'
]);