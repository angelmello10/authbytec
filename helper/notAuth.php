<?php

$baseUrl = '/authBytech';

if (!isset($_SESSION['user'])) {
    header("Location: {$baseUrl}/views/auth/login.php");
    exit();
}