<?php

require_once __DIR__ . "/../libservidorphp/manejaErrores.php";
require_once __DIR__ . "/../libservidorphp/recibeTextoObligatorio.php";
require_once __DIR__ . "/../libservidorphp/devuelveJson.php";
require_once __DIR__ . "/protege.php";
require_once __DIR__ . "/ROL_ID_CLIENTE.php";
require_once __DIR__ . "/Bd.php";

// Solo clientes pueden dar de alta
list($san, $rolIds, $usuId) = protege([ROL_ID_CLIENTE]);

// Validación automática de campos obligatorios
$nombre = recibeTextoObligatorio("nombre");
$descripcion = recibeTextoObligatorio("descripcion");
$email = recibeTextoObligatorio("email");

$bd = Bd::pdo();

$stmt = $bd->prepare(
 "INSERT INTO CONTACTO (USU_ID, CON_NOMBRE, CON_DESCRIPCION, CON_EMAIL) 
  VALUES (:USU_ID, :CON_NOMBRE, :CON_DESCRIPCION, :CON_EMAIL)"
);

$stmt->execute([
 ":USU_ID" => $usuId,
 ":CON_NOMBRE" => $nombre,
 ":CON_DESCRIPCION" => $descripcion,
 ":CON_EMAIL" => $email
]);

devuelveJson(true);