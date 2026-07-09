<?php
    require_once '../../helper/isAuth.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./auth.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-circle display-4 matricula-icon"></i>
                <h3>Iniciar Sesión</h3>
                <p class="text-muted">Ingresa tus credenciales</p>
            </div>
            <div class="card-body">
<div id="errorContainer" class="alert d-none" role="alert"></div>

                        <form id="loginForm" autocomplete="off">
                            <input type="hidden" name="csrf_token" id="csrfToken">

                            <div class="mb-3">
                                <label for="correo" class="form-label fw-semibold">Correo Electronico</label>
                                <div class="input-group">
                                   
                                    <input type="text" class="form-control" id="correo" name="correo"
                                           placeholder="Tu correo" required autofocus>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Contraseña</label>
                                <div class="input-group">

                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="••••••••" required>
                                    <button class="toggle-password" type="button" id="togglePassword">
                                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn-login" id="btnSubmit">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
                            </button>
                        </form>
                        <div class="footer-note">
                            <a href="./register.php">Registrarse</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const baseUrl = '/authBytech';
        const form = document.getElementById('loginForm');
        const errorContainer = document.getElementById('errorContainer');
        const csrfInput = document.getElementById('csrfToken');
        const btnSubmit = document.getElementById('btnSubmit');
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        // Mostrar/ocultar contraseña
        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleIcon.classList.toggle('bi-eye-slash', !isPassword);
            toggleIcon.classList.toggle('bi-eye', isPassword);
        });

        function mostrarError(mensaje) {
            errorContainer.className = 'alert alert-danger';
            errorContainer.innerHTML = `
                <span class="bi bi-exclamation-triangle-fill me-2"></span>
                ${mensaje}`;
        }

        function ocultarError() {
            errorContainer.classList.add('d-none');
        }

       

        // Enviar login (POST)
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            ocultarError();

            btnSubmit.disabled = true;
            btnSubmit.textContent = 'Ingresando...';
            const formData = new FormData(form);
            const datos = Object.fromEntries(formData.entries());

            try {
                const res = await fetch(`${baseUrl}/api/auth/login.php`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(datos)
                });

                const contentType = res.headers.get('content-type') || '';
                const respuesta = contentType.includes('application/json')
                    ? await res.json()
                    : { success: false, message: await res.text() };

                if (res.ok && respuesta.success) {
                    window.location.href = respuesta.redirect || `${baseUrl}/views/listar.php`;
                } else {
                    mostrarError(respuesta.message || `Error HTTP ${res.status} al iniciar sesión`);
                }
            } catch (err) {
                console.error('Error de red:', err);
                mostrarError('Error de conexión. Inténtalo más tarde.');
            } finally {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Ingresar';
            }
        });
    </script>
</body>
</html>