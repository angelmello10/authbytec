<?php

require_once __DIR__ . "/../libservidorphp/manejaErrores.php";
require_once __DIR__ . "/../libservidorphp/recibeEnteroObligatorio.php";
require_once __DIR__ . "/../libservidorphp/recibeTextoObligatorio.php";
require_once __DIR__ . "/../libservidorphp/recibeTextoOpcional.php";
require_once __DIR__ . "/../libservidorphp/devuelveJson.php";
require_once __DIR__ . "/../libservidorphp/registraLog.php";
require_once __DIR__ . "/../helper/sessionUser.php";
require_once __DIR__ . "/Bd.php";

$id = recibeEnteroObligatorio("id");
$nombre = recibeTextoObligatorio("nombre");
$apellidoPaterno = recibeTextoObligatorio("apellido_paterno");
$apellidoMaterno = recibeTextoOpcional("apellido_materno");
$matricula = recibeTextoObligatorio("matricula");
$grupo = recibeTextoObligatorio("grupo");

$bd = Bd::conexion();
$stmt = $bd->prepare(
 "UPDATE USUARIOS
   SET
    USU_NOMBRE = TRIM(:USU_NOMBRE),
    USU_APELLIDO_PATERNO = TRIM(:USU_APELLIDO_PATERNO),
    USU_APELLIDO_MATERNO = TRIM(:USU_APELLIDO_MATERNO),
    USU_MATRICULA = TRIM(:USU_MATRICULA),
    USU_GRUPO = TRIM(:USU_GRUPO)
   WHERE
    USU_ID = :USU_ID"
);
$stmt->execute([
 ":USU_NOMBRE" => $nombre,
 ":USU_APELLIDO_PATERNO" => $apellidoPaterno,
 ":USU_APELLIDO_MATERNO" => $apellidoMaterno,
 ":USU_MATRICULA" => $matricula,
 ":USU_GRUPO" => $grupo,
 ":USU_ID" => $id,
]);

$bd = Bd::conexion();
$user = getSessionUser();
$usuarioNombre = $user['nombre'] ?? 'Desconocido';
registraLog($bd, $usuarioNombre, 'usuarios-modifica.php', 'UPDATE', "Actualizó usuario ID {$id}");

devuelveJson([
 "id" => ["value" => $id],
 "nombre" => ["value" => $nombre],
 "apellido_paterno" => ["value" => $apellidoPaterno],
 "apellido_materno" => ["value" => $apellidoMaterno],
 "matricula" => ["value" => $matricula],
 "grupo" => ["value" => $grupo],
]);