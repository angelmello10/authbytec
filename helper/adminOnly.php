<?php

require_once __DIR__ . '/sessionUser.php';

$user = getSessionUser();
if (empty($user) || ($user['rol'] ?? '') !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    echo 'Acceso denegado. Solo usuarios ADMIN pueden ver esta página.';
    exit();
}
