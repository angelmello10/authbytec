<?php

function usuarioBuscaSan(\PDO $bd, string $san)
{
 $usuarioBusca = $bd->prepare("SELECT * FROM USUARIO WHERE USU_SAN = :USU_SAN");
 $usuarioBusca->execute([":USU_SAN" => $san]);
 $usuario = $usuarioBusca->fetch(PDO::FETCH_ASSOC);
 return $usuario;
}
