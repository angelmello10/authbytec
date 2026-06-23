<?php

require_once __DIR__ . "/../libservidorphp/PROHIBIDO.php";
require_once __DIR__ . "/../libservidorphp/ProblemDetailsException.php";
require_once __DIR__ . "/protege.php";

function protegeLogin(array $rolIdsPermitidos)
{

 list($san, $rolIds, $usuId) = protege($rolIdsPermitidos);

 if ($san !== "")
  throw new ProblemDetailsException([
   "status" => PROHIBIDO,
   "type" => "/errors/sesioniniciada.html",
   "title" => "Sesión iniciada.",
   "detail" => "La sesión ya está iniciada.",
  ]);

 return [$san, $rolIds, $usuId];
}
