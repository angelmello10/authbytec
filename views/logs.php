<?php
session_start();
require_once '../helper/notAuth.php';
require_once '../helper/adminOnly.php';
require_once __DIR__ . '/../api/Bd.php';
require_once __DIR__ . '/../libservidorphp/registraLog.php';
require_once __DIR__ . '/../helper/sessionUser.php';

$user = getSessionUser();
$usuarioNombre = $user['nombre'] ?? 'Desconocido';

$bd = Bd::conexion();
registraLog($bd, $usuarioNombre, 'logs.php', 'PAGE_VIEW');

$stmt = $bd->query('SELECT LOG_TIMESTAMP, LOG_IP, LOG_USER, LOG_VIEW, LOG_ACTION, LOG_DETAILS FROM LOGS ORDER BY LOG_TIMESTAMP DESC');
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs de Auditoría</title>
    <link rel="stylesheet" href="../index.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f7fb; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: auto; }
        h1 { margin-bottom: 20px; }
        .table-wrapper { overflow-x: auto; background: #fff; border-radius: 8px; box-shadow: 0 0 18px rgba(0,0,0,.08); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 14px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        th { background: #1f2937; color: #fff; text-transform: uppercase; font-size: 12px; letter-spacing: .05em; }
        tr:hover { background: #f3f4f6; }
        .empty { padding: 40px; text-align: center; color: #6b7280; }
        .actions { margin-bottom: 20px; display: flex; gap: 12px; align-items: center; }
        .actions a { color: #2563eb; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
<div class="container">
    <div class="actions">
        <a href="listar.php">Regresar a Usuarios</a>
        <a href="../views/auth/login.php">Cerrar sesión</a>
    </div>
    <h1>Logs de Auditoría</h1>
    <div class="table-wrapper">
        <?php if (empty($logs)): ?>
            <div class="empty">No hay registros de auditoría todavía.</div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Fecha / Hora (UTC)</th>
                        <th>IP</th>
                        <th>Usuario</th>
                        <th>Vista</th>
                        <th>Acción</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?= htmlspecialchars($log['LOG_TIMESTAMP']) ?></td>
                            <td><?= htmlspecialchars($log['LOG_IP']) ?></td>
                            <td><?= htmlspecialchars($log['LOG_USER']) ?></td>
                            <td><?= htmlspecialchars($log['LOG_VIEW']) ?></td>
                            <td><?= htmlspecialchars($log['LOG_ACTION']) ?></td>
                            <td><?= htmlspecialchars($log['LOG_DETAILS'] ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
