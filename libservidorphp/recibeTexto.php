<?php

function recibeTexto(string $parametro)
{
 return $_POST[$parametro] ?? $_GET[$parametro] ?? false;
}