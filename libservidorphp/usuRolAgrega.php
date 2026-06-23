<?php

function usuRolAgrega(\PDO $bd, string $usuId, array $rolIds)
{
 $usuRolAgrega = $bd->prepare(
  "INSERT INTO USU_ROL (USU_ID, ROL_ID) values (:USU_ID, :ROL_ID)"
 );
 foreach ($rolIds as $rolId) {
  $usuRolAgrega->execute([
   ":USU_ID" => $usuId,
   ":ROL_ID" => $rolId,
  ]);
 }
}
