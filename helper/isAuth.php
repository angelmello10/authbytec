<?php

$baseUrl = '/authBytech';

if (isset($_SESSION['user'])) {
    header("Location: {$baseUrl}/views/listar.php");
    exit();
}