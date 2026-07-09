<?php

require_once __DIR__ . "/../libservidorphp/manejaErrores.php";
require_once __DIR__ . "/../libservidorphp/recibeEnteroObligatorio.php";
require_once __DIR__ . "/../libservidorphp/devuelveJson.php";
require_once __DIR__ . "/../libservidorphp/registraLog.php";
require_once __DIR__ . "/../helper/sessionUser.php";
require_once __DIR__ . "/Bd.php";

$id = recibeEnteroObligatorio("id");

$bd = Bd::conexion();
$stmt = $bd->prepare("DELETE FROM USUARIOS WHERE USU_ID = :USU_ID");
$stmt->execute([":USU_ID" => $id]);

$user = getSessionUser();
$usuarioNombre = $user['nombre'] ?? 'Desconocido';
registraLog($bd, $usuarioNombre, 'usuarios-elimina.php', 'DELETE', "Eliminó usuario ID {$id}");

devuelveJson(["id" => ["value" => $id]]);