<?php
require_once __DIR__ . '/../Bd.php';
require_once __DIR__ . "/../../libservidorphp/devuelveJson.php";
require_once __DIR__ . "/../../libservidorphp/registraLog.php";
require_once __DIR__ . "/../../helper/sessionUser.php";
session_start();
$bd = Bd::conexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = json_decode(file_get_contents('php://input'), true);
    if ($datos === null) {
        devuelveJson([
            'success' => false,
            'message' => 'Cuerpo JSON inválido o vacío.',
        ]);
    }

    $correo = $datos['correo'];
    $password = $datos['password'];
}

$usuarioBusca = $bd->prepare("SELECT * FROM ADMINS WHERE ADM_CORREO = :correo");
$usuarioBusca->execute([":correo" => $correo]);
$usuario = $usuarioBusca->fetch(PDO::FETCH_ASSOC);

///si no existe usuario amndar mensaje de correo incorreco
if($usuario === false){
    devuelveJson([
        'success'  => false,
        'message'  => 'Correo electronico incorrecto.',
    ]);
}

///if existe usuario revisar contraseña
if(!password_verify($password, $usuario["ADM_PASSWORD_HASH"])){
    devuelveJson([
        'success'  => false,
        'message'  => 'Contraseña incorrecta.',
    ]);
}

$_SESSION['user']= formatUser($usuario);
registraLog($bd, $usuario["ADM_NOMBRE"].' '.$usuario["ADM_APELLIDO_PATERNO"], 'login.php', 'LOGIN', "Login exitoso para {$correo}");
devuelveJson([
    'success'  => true,
    'message'  => 'Acceso exitoso.',
    'redirect' => '../listar.php'
]);



function formatUser($usuario){
    return json_encode([
        'nombre'=>$usuario["ADM_NOMBRE"].' '.$usuario["ADM_APELLIDO_PATERNO"],
        'correo'=>$usuario["ADM_CORREO"],
        'rol'=>$usuario["ADM_ROL"],
    ]);
}
