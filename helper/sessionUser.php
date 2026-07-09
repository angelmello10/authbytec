<?php

function getSessionUser(): array
{
    if (!isset($_SESSION['user'])) {
        return [];
    }

    $user = $_SESSION['user'];
    if (!is_array($user)) {
        $decoded = json_decode($user, true);
        return is_array($decoded) ? $decoded : [];
    }

    return $user;
}
