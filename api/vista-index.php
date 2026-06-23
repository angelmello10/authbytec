<?php

require_once __DIR__ . "/../libservidorphp/manejaErrores.php";
require_once __DIR__ . "/protege.php";
require_once __DIR__ . "/../libservidorphp/devuelveJson.php";
require_once __DIR__ . "/jsonMiNav.php";

list($san, $rolIds) = protege([]);

devuelveJson(jsonMiNav($san, $rolIds));
