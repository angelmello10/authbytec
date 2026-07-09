<?php

require_once __DIR__ . "/../libservidorphp/manejaErrores.php";
require_once __DIR__ . "/../libservidorphp/recibeTextoObligatorio.php";
require_once __DIR__ . "/../libservidorphp/recibeTextoOpcional.php";
require_once __DIR__ . "/../libservidorphp/devuelveCreated.php";
require_once __DIR__ . "/Bd.php";

$nombre = recibeTextoObligatorio("nombre");
$apellidoPaterno = recibeTextoObligatorio("apellido_paterno");
$apellidoMaterno = recibeTextoOpcional("apellido_materno");
$matricula = recibeTextoObligatorio("matricula");
$grupo = recibeTextoObligatorio("grupo");

$bd = Bd::conexion();
$stmt = $bd->prepare(
 "INSERT INTO USUARIOS (
    USU_NOMBRE,
    USU_APELLIDO_PATERNO,
    USU_APELLIDO_MATERNO,
    USU_MATRICULA,
    USU_GRUPO
   ) values (
    TRIM(:USU_NOMBRE),
    TRIM(:USU_APELLIDO_PATERNO),
    TRIM(:USU_APELLIDO_MATERNO),
    TRIM(:USU_MATRICULA),
    TRIM(:USU_GRUPO)
   )"
);
$stmt->execute([
 ":USU_NOMBRE" => $nombre,
 ":USU_APELLIDO_PATERNO" => $apellidoPaterno,
 ":USU_APELLIDO_MATERNO" => $apellidoMaterno,
 ":USU_MATRICULA" => $matricula,
 ":USU_GRUPO" => $grupo
]);
$id = $bd->lastInsertId();

$user = getSessionUser();
$usuarioNombre = $user['nombre'] ?? 'Desconocido';
registraLog($bd, $usuarioNombre, 'usuarios-agrega.php', 'CREATE', "Creó usuario ID {$id}");

$query = http_build_query(["id" => $id]);
devuelveCreated(
 "/api/usuarios-vista-modifica.php?$query",
 [
  "id" => ["value" => $id],
  "nombre" => ["value" => $nombre],
  "apellido_paterno" => ["value" => $apellidoPaterno],
  "apellido_materno" => ["value" => $apellidoMaterno],
  "matricula" => ["value" => $matricula],
  "grupo" => ["value" => $grupo],
 ]
);