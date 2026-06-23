<?php

require_once __DIR__ . "/../libservidorphp/manejaErrores.php";
require_once __DIR__ . "/../libservidorphp/recibeTextoObligatorio.php";
require_once __DIR__ . "/../libservidorphp/devuelveJson.php";
require_once __DIR__ . "/protege.php";
require_once __DIR__ . "/ROL_ID_CLIENTE.php";
require_once __DIR__ . "/Bd.php";

// Solo clientes pueden dar de baja
list($san, $rolIds, $usuId) = protege([ROL_ID_CLIENTE]);

$id = recibeTextoObligatorio("id");

$bd = Bd::pdo();

// El DELETE incluye el USU_ID para asegurar que sea dueño del registro
$stmt = $bd->prepare(
 "DELETE FROM CONTACTO WHERE CON_ID = :CON_ID AND USU_ID = :USU_ID"
);

$stmt->execute([
 ":CON_ID" => $id,
 ":USU_ID" => $usuId
]);

devuelveJson(true);