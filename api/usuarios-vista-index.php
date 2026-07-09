<?php

require_once __DIR__ . "/../libservidorphp/manejaErrores.php";
require_once __DIR__ . "/../libservidorphp/devuelveJson.php";
require_once __DIR__ . "/Bd.php";

$bd = Bd::conexion();
$stmt = $bd->query(
 "SELECT USU_ID, USU_NOMBRE, USU_APELLIDO_PATERNO, USU_APELLIDO_MATERNO, USU_MATRICULA, USU_GRUPO FROM USUARIOS ORDER BY USU_NOMBRE"
);
$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

$render = "";
foreach ($lista as $modelo) {
 $id = $modelo["USU_ID"];
 $query = htmlentities(http_build_query(["id" => $id]));
 $urlModifica = "modifica.php?$query";
 
 $nombre = htmlentities($modelo["USU_NOMBRE"]);
 $apellidoPaterno = htmlentities($modelo["USU_APELLIDO_PATERNO"] ?? "");
 $apellidoMaterno = htmlentities($modelo["USU_APELLIDO_MATERNO"] ?? "");
 $matricula = htmlentities($modelo["USU_MATRICULA"]);
 $grupo = htmlentities($modelo["USU_GRUPO"]);
 
 $render .=
  "<li>
    <div class='registro'>
     <div class='campo campo-nombre'>
      <span class='campo-label'>Nombre</span>
      <span class='campo-valor'>$nombre</span>
     </div>
     <div class='campo campo-apellido-paterno'>
      <span class='campo-label'>Apellido Paterno</span>
      <span class='campo-valor'>$apellidoPaterno</span>
     </div>
     <div class='campo campo-apellido-materno'>
      <span class='campo-label'>Apellido Materno</span>
      <span class='campo-valor'>$apellidoMaterno</span>
     </div>
     <div class='campo campo-matricula'>
      <span class='campo-label'>Matr&iacute;cula</span>
      <span class='campo-valor'>$matricula</span>
     </div>
     <div class='campo campo-grupo'>
      <span class='campo-label'>Grupo</span>
      <span class='campo-valor'>$grupo</span>
     </div>
     <div class='campo campo-acciones'>
      <a href='$urlModifica' class='modificar-link'>Modificar</a>
     </div>
    </div>
   </li>";
}

devuelveJson(["lista" => ["innerHTML" => $render]]);