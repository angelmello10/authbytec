<?php
session_start();

$baseUrl = '/authBytech';

if (!isset($_SESSION['user'])) {
    header("Location: {$baseUrl}/views/auth/login.php");
    exit();
}

header("Location: {$baseUrl}/views/listar.php");
exit();
?>