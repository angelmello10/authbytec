<?php

function rolAgrega(\PDO $bd, string $id, string $descripcion)
{
 $rolAgrega = $bd->prepare(
  "INSERT INTO ROL (
     ROL_ID, ROL_DESCRIPCION
    ) VALUES (
     :ROL_ID, :ROL_DESCRIPCION
    )"
 );
 $rolAgrega->execute([
  ":ROL_ID" => $id,
  ":ROL_DESCRIPCION" => $descripcion,
 ]);
}
