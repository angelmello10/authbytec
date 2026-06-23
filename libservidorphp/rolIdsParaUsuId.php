<?php

function rolIdsParaUsuId(\PDO $bd, int $usuId)
{
 $stmt = $bd->prepare(
  "SELECT ROL_ID
   FROM USU_ROL
   WHERE USU_ID = :USU_ID
   ORDER BY USU_ID"
 );
 $stmt->execute([":USU_ID" => $usuId]);
 $rolIds = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
 return $rolIds;
}
