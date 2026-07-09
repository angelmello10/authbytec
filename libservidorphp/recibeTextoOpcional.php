<?php

require_once __DIR__ . "/recibeTexto.php";

function recibeTextoOpcional(string $parametro): ?string
{
 $texto = recibeTexto($parametro);

 if ($texto === false) {
  return null;
 }

 $trimTexto = trim($texto);

 if ($trimTexto === "") {
  return null;
 }

 return $trimTexto;
}