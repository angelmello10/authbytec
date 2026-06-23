<?php

function jsonMiNav(string $san, array $rolIds)
{
 $json = [
  "ocupado" => ["hidden" => true],
  "aAdmin" => [
   "hidden" => array_search(ROL_ID_ADMINISTRADOR, $rolIds, true) === false
  ],
  "aCliente" => [
   "hidden" => array_search(ROL_ID_CLIENTE, $rolIds, true) === false
  ],
  "san" => ["hidden" => $san === "", "textContent" => $san],
 ];

 return $json;
}
