<?php 
session_start();
require_once '../helper/notAuth.php';
require_once '../helper/sessionUser.php';
require_once '../api/Bd.php';
require_once '../libservidorphp/registraLog.php';

$bd = Bd::conexion();
$user = getSessionUser();
$usuarioNombre = $user['nombre'] ?? 'Desconocido';
registraLog($bd, $usuarioNombre, 'listar.php', 'PAGE_VIEW');
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />

    <title>Acceso a base de datos</title>

    <script src="../dompurify/purify.min.js"></script>
    <script type="module" src="../libclienteweb/manejaErrores.js"></script>
    <link rel="stylesheet" href="../index.css" />
       
  </head>

  <body>
    <div class="container-center">
      <h1>Acceso a base de datos</h1>

      <div class="botones-superiores">
          <p class="boton-agregar"><a href="agrega.php">Agregar</a></p>
          <?php if (($user['rol'] ?? '') === 'admin'): ?>
              <p class="boton-agregar"><a href="logs.php">Ver logs</a></p>
          <?php endif; ?>
      </div>

      <ul id="lista">
        <li><progress max="100">Cargando…</progress></li>
      </ul>
    </div>
    
    <script type="module">
      import { descargaVista } from "../libclienteweb/descargaVista.js";

      descargaVista("../api/usuarios-vista-index.php");
    </script>
     <?php include './components/butoon-log-out.php'?>
  </body>
</html>