<?php

require_once __DIR__ . "/../libservidorphp/NO_AUTORIZADO.php";
require_once __DIR__ . "/../libservidorphp/PROHIBIDO.php";
require_once __DIR__ . "/../libservidorphp/ProblemDetailsException.php";
require_once __DIR__ . "/../libservidorphp/rolIdsParaUsuId.php";
require_once __DIR__ . "/SAN.php";
require_once __DIR__ . "/USU_ID.php";
require_once __DIR__ . "/Bd.php";

function protege(array $rolIdsPermitidos)
{

 session_start();

 $san = isset($_SESSION[SAN]) ? $_SESSION[SAN] : "";
 $usuId = isset($_SESSION[USU_ID]) ? $_SESSION[USU_ID] : -1;
 $rolIds = rolIdsParaUsuId(Bd::pdo(), $usuId);

 if (count($rolIdsPermitidos) === 0) {

  return [$san, $rolIds, $usuId];
 } else {

  if ($san === "")
   throw new ProblemDetailsException([
    "status" => NO_AUTORIZADO,
    "type" => "/errors/noautorizado.html",
    "title" => "No autorizado.",
    "detail" => "Necesitas iniciar sesión.",
   ]);

  foreach ($rolIdsPermitidos as $rolId) {
   if (array_search($rolId, $rolIds, true) !== false) {
    return [$san, $rolIds, $usuId];
   }
  }

  throw new ProblemDetailsException([
   "status" => PROHIBIDO,
   "type" => "/errors/prohibido.html",
   "title" => "Prohibido.",
   "detail" => "No tienes roles para usar este recurso.",
  ]);
 }
}
