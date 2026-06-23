<?php

require_once __DIR__ . "/../libservidorphp/manejaErrores.php";
require_once __DIR__ . "/../libservidorphp/devuelveJson.php";
require_once __DIR__ . "/ROL_ID_CLIENTE.php";
require_once __DIR__ . "/protege.php";

list($san) = protege([ROL_ID_CLIENTE]);

devuelveJson("Hola $san.");
