<?php

require_once __DIR__ . "/../libservidorphp/manejaErrores.php";
require_once __DIR__ . "/../libservidorphp/recibeEnteroObligatorio.php";
require_once __DIR__ . "/../libservidorphp/validaEntidadObligatoria.php";
require_once __DIR__ . "/../libservidorphp/devuelveJson.php";
require_once __DIR__ . "/Bd.php";

$id = recibeEnteroObligatorio("id");

$bd = Bd::conexion();
$stmt = $bd->prepare("SELECT * FROM USUARIOS WHERE USU_ID = :USU_ID");
$stmt->execute([":USU_ID" => $id]);
$modelo = $stmt->fetch(PDO::FETCH_ASSOC);

$modelo = validaEntidadObligatoria("Usuario", $modelo);

devuelveJson([
 "id" => ["value" => $id],
 "nombre" => ["value" => $modelo["USU_NOMBRE"]],
 "apellido_paterno" => ["value" => $modelo["USU_APELLIDO_PATERNO"]],
 "apellido_materno" => ["value" => $modelo["USU_APELLIDO_MATERNO"]],
 "matricula" => ["value" => $modelo["USU_MATRICULA"]],
 "grupo" => ["value" => $modelo["USU_GRUPO"]],
]);