<?php
session_start();
require_once __DIR__ . '/../Bd.php';
require_once __DIR__ . "/../../libservidorphp/devuelveJson.php";
require_once __DIR__ . "/../../libservidorphp/registraLog.php";
require_once __DIR__ . "/../../helper/sessionUser.php";

$bd = Bd::conexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = json_decode(file_get_contents('php://input'), true);
    if ($datos === null) {
        devuelveJson([
            'success' => false,
            'message' => 'Cuerpo JSON inválido o vacío.',
        ]);
    }

    $ADM_NOMBRE = $datos['ADM_NOMBRE'];
    $ADM_APELLIDO_PATERNO = $datos['ADM_APELLIDO_PATERNO'];
    $ADM_APELLIDO_MATERNO = $datos['ADM_APELLIDO_MATERNO'];
    $ADM_CORREO = $datos['ADM_CORREO'];
    $ADM_EDAD = $datos['ADM_EDAD'];
    $ADM_PASSWORD = password_hash($datos['ADM_PASSWORD'], PASSWORD_DEFAULT);
    $rol = 'user';

    $currentUser = getSessionUser();
    $requestedRole = $datos['ADM_ROL'] ?? 'user';
    if (!empty($currentUser) && ($currentUser['rol'] ?? '') === 'admin' && in_array($requestedRole, ['admin', 'user'], true)) {
        $rol = $requestedRole;
    }

    $sql = "INSERT INTO ADMINS 
                (ADM_NOMBRE, ADM_APELLIDO_PATERNO, ADM_APELLIDO_MATERNO, ADM_CORREO, ADM_EDAD, ADM_PASSWORD_HASH, ADM_ROL)
            VALUES 
                (:nombre, :apellidoPaterno, :apellidoMaterno, :correo, :edad, :passwordHash, :rol)";

    $stmt = $bd->prepare($sql);
    $stmt->execute([
        ':nombre'          => $ADM_NOMBRE,
        ':apellidoPaterno' => $ADM_APELLIDO_PATERNO,
        ':apellidoMaterno' => $ADM_APELLIDO_MATERNO,
        ':correo'          => $ADM_CORREO,
        ':edad'            => $ADM_EDAD,
        ':passwordHash'    => $ADM_PASSWORD,
        ':rol'             => $rol
    ]);

    registraLog($bd, $ADM_NOMBRE, 'saveLogin.php', 'CREATE', "Registro de usuario {$ADM_CORREO} con rol {$rol}");

    devuelveJson([
        'success'  => true,
        'message'  => 'Registro exitoso. Ya puedes iniciar sesión.',
        'redirect' => '../../views/auth/login.php'
    ]);
}