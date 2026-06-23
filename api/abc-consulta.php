<?php

require_once __DIR__ . "/../libservidorphp/manejaErrores.php";
require_once __DIR__ . "/../libservidorphp/devuelveJson.php";
require_once __DIR__ . "/protege.php";
require_once __DIR__ . "/ROL_ID_CLIENTE.php";
require_once __DIR__ . "/Bd.php";

// Solo clientes pueden consultar
list($san, $rolIds, $usuId) = protege([ROL_ID_CLIENTE]);

$bd = Bd::pdo();

// Solo seleccionamos los contactos que pertenecen al usuId de la sesión
$stmt = $bd->prepare(
 "SELECT CON_ID, CON_NOMBRE, CON_DESCRIPCION, CON_EMAIL 
  FROM CONTACTO 
  WHERE USU_ID = :USU_ID 
  ORDER BY CON_NOMBRE"
);

$stmt->execute([":USU_ID" => $usuId]);
$contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);

devuelveJson($contactos);