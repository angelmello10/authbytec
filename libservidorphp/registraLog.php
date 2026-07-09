<?php

require_once __DIR__ . '/getClientIp.php';

function registraLog(PDO $bd, string $usuario, string $vista, string $accion, ?string $detalles = null): void
{
    $ip = getClientIp();
    $timestamp = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('c');

    $stmt = $bd->prepare(
        'INSERT INTO LOGS (LOG_TIMESTAMP, LOG_IP, LOG_USER, LOG_VIEW, LOG_ACTION, LOG_DETAILS)
         VALUES (:timestamp, :ip, :user, :view, :action, :details)'
    );

    $stmt->execute([
        ':timestamp' => $timestamp,
        ':ip' => $ip,
        ':user' => $usuario,
        ':view' => $vista,
        ':action' => $accion,
        ':details' => $detalles,
    ]);
}
