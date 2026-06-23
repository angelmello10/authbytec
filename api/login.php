<?php

require_once __DIR__ . "/../libservidorphp/manejaErrores.php";
require_once __DIR__ . "/../libservidorphp/BAD_REQUEST.php";
require_once __DIR__ . "/../libservidorphp/recibeTextoObligatorio.php";
require_once __DIR__ . "/../libservidorphp/recibeTexto.php";
require_once __DIR__ . "/../libservidorphp/devuelveJson.php";
require_once __DIR__ . "/../libservidorphp/rolIdsParaUsuId.php";
require_once __DIR__ . "/SAN.php";
require_once __DIR__ . "/USU_ID.php";
require_once __DIR__ . "/ROL_IDS.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/protegeLogin.php";
require_once __DIR__ . "/usuarioBuscaSan.php";

protegeLogin([]);

$san = recibeTextoObligatorio("san");
$sen = recibeTexto("sen");

$bd = Bd::pdo();

$usuario = usuarioBuscaSan($bd, $san);

if (
 $usuario === false
 || !password_verify(
  ($sen === false || $sen === null) ? "" : $sen,
  $usuario["USU_SEN"]
 )
)
 throw new ProblemDetailsException([
  "status" => BAD_REQUEST,
  "type" => "/errors/datosincorrectos.html",
  "title" => "Datos incorrectos.",
  "detail" => "El san y/o el sen proporcionados son incorrectos.",
 ]);

$_SESSION[SAN] = $san;
$_SESSION[USU_ID] = $usuario[USU_ID];

devuelveJson([
 SAN => $san,
 ROL_IDS => rolIdsParaUsuId($bd, $usuario[USU_ID])
]);
