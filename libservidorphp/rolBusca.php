<?php

function rolBusca(\PDO $bd, string $id)
{
 $rolBusca =  $bd->prepare("SELECT * FROM ROL WHERE ROL_ID = :ROL_ID");
 $rolBusca->execute([":ROL_ID" => $id]);
 $rol = $rolBusca->fetch(PDO::FETCH_ASSOC);
 return $rol;
}
