<?php

require_once __DIR__ . "/../libservidorphp/manejaErrores.php";
require_once __DIR__ . "/../libservidorphp/devuelveJson.php";
require_once __DIR__ . "/protegeLogin.php";

protegeLogin([]);

devuelveJson([
 "ocupado" => ["hidden" => true],
 "formulario" => ["hidden" =>  false],
]);
