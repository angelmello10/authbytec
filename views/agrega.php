<?php 
session_start();
require_once '../helper/notAuth.php';
require_once '../helper/sessionUser.php';
require_once '../api/Bd.php';
require_once '../libservidorphp/registraLog.php';

$bd = Bd::conexion();
$user = getSessionUser();
$usuarioNombre = $user['nombre'] ?? 'Desconocido';
registraLog($bd, $usuarioNombre, 'agrega.php', 'PAGE_VIEW');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Agregar</title>

    <script type="module" src="../libclienteweb/manejaErrores.js"></script>

    <style>
    /* ESTILOS BÁSICOS Y MINIMALISTAS */

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background-color: #f8f9fa;
        color: #1a1a1a;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px 16px;
    }

    /* Tarjeta plana sin bordes gigantes ni sombras pesadas */
    form {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 32px 24px;
        max-width: 500px;
        width: 100%;
    }

    h1 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 12px;
    }

    /* Enlace Cancelar */
    p:first-of-type {
        margin-bottom: 20px;
    }

    a {
        text-decoration: none;
        font-weight: 500;
        color: #64748b;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    a::before {
        content: "←";
    }

    a:hover {
        color: #1a1a1a;
        text-decoration: underline;
    }

    /* Filas de campos */
    .campo-row {
        margin-bottom: 16px;
    }

    label {
        display: block;
        font-size: 0.85rem;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 6px;
    }

    .required {
        color: #991b1b;
        margin-left: 2px;
    }

    /* Inputs limpios y rectangulares */
    input {
        width: 100%;
        padding: 10px 12px;
        font-size: 0.95rem;
        font-family: inherit;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        background: #ffffff;
        color: #1a1a1a;
        outline: none;
        margin-top: 4px;
    }

    input:focus {
        border-color: #1a1a1a;
    }

    .obligatorio-texto {
        font-size: 0.8rem;
        color: #64748b;
        margin: 12px 0 20px 0;
    }

    /* Botón Agregar sólido */
    button {
        background: #1a1a1a;
        border: none;
        padding: 12px;
        border-radius: 4px;
        color: #ffffff;
        font-weight: 500;
        font-size: 0.95rem;
        font-family: inherit;
        cursor: pointer;
        width: 100%;
        transition: background 0.1s ease;
    }

    button:hover {
        background: #334155;
    }

    button:active {
        transform: scale(0.99);
    }

    /* Ajuste de márgenes de párrafos */
    form p {
        margin-bottom: 0;
    }

    /* Responsive */
    @media (max-width: 480px) {
        form {
            padding: 24px 16px;
        }
    }

    /* Placeholder sutil */
    input::placeholder {
        color: #94a3b8;
    }
    </style>

</head>

<body>

    <form id="formulario">

        <h1>Agregar</h1>

        <p><a href="./listar.php">Cancelar</a></p>

        <p class="campo-row">
            <label>
                Nombre <span class="required">*</span>
                <input name="nombre" placeholder="Ingrese el nombre">
            </label>
        </p>

        <p class="campo-row">
            <label>
                Apellido Paterno <span class="required">*</span>
                <input name="apellido_paterno" placeholder="Ingrese el apellido paterno">
            </label>
        </p>

        <p class="campo-row">
            <label>
                Apellido Materno
                <input name="apellido_materno" placeholder="Ingrese el apellido materno">
            </label>
        </p>

        <p class="campo-row">
            <label>
                Matrícula <span class="required">*</span>
                <input name="matricula" placeholder="Ingrese la matrícula">
            </label>
        </p>

        <p class="campo-row">
            <label>
                Grupo <span class="required">*</span>
                <input name="grupo" placeholder="Ingrese el grupo">
            </label>
        </p>

        <p class="obligatorio-texto">* Campos obligatorios</p>

        <p><button type="submit">Agregar</button></p>

    </form>

    <script type="module">
    import {
        configuraSubmitAccion
    } from "../libclienteweb/configuraSubmitAccion.js"

    configuraSubmitAccion("../api/usuarios-agrega.php", formulario, "./listar.php")
    </script>

</body>
</html>