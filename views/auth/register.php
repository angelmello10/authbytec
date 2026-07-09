<?php
session_start();
require_once '../../helper/sessionUser.php';

$currentUser = getSessionUser();
$isAdmin = isset($currentUser['rol']) && $currentUser['rol'] === 'admin';

// Si está logueado y no es admin, no puede entrar a registro.
if (!$isAdmin && !empty($currentUser)) {
    header('Location: ../listar.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./auth.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-plus display-4 register-icon"></i>
                <h3>Crear Cuenta</h3>
                <p class="description">Completa todos los campos para registrarte</p>
            </div>
            <div class="card-body">
                <div id="errorContainer" class="d-none" role="alert"></div>
                <div id="successContainer" class="d-none" role="alert"></div>

                        <form id="registerForm" autocomplete="off">
                            <input type="hidden" name="ADM_ROL" value="user">
                            <?php if ($isAdmin): ?>
                                <div class="mb-3">
                                    <label for="rol" class="form-label fw-semibold">Rol</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                        <select class="form-select" id="rol" name="ADM_ROL">
                                            <option value="user">Usuario</option>
                                            <option value="admin">Administrador</option>
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <!-- Nombre -->
                            <div class="mb-3">
                                <label for="nombre" class="form-label fw-semibold">Nombre</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nombre" name="ADM_NOMBRE"
                                           placeholder="Tu nombre" required autofocus>
                                </div>
                            </div>

                            <!-- Apellido Paterno -->
                            <div class="mb-3">
                                <label for="apellidoPaterno" class="form-label fw-semibold">Apellido Paterno</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="apellidoPaterno" name="ADM_APELLIDO_PATERNO"
                                           placeholder="Apellido paterno" required>
                                </div>
                            </div>

                            <!-- Apellido Materno (opcional) -->
                            <div class="mb-3">
                                <label for="apellidoMaterno" class="form-label fw-semibold">Apellido Materno <span class="text-muted">(opcional)</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="apellidoMaterno" name="ADM_APELLIDO_MATERNO"
                                           placeholder="Apellido materno (opcional)">
                                </div>
                            </div>

                            <!-- Correo -->
                            <div class="mb-3">
                                <label for="correo" class="form-label fw-semibold">Correo Electrónico</label>
                                <div class="input-group">
                                    <input type="email" class="form-control" id="correo" name="ADM_CORREO"
                                           placeholder="tu@correo.com" required>
                                </div>
                            </div>

                            <!-- Edad -->
                            <div class="mb-3">
                                <label for="edad" class="form-label fw-semibold">Edad</label>
                                <div class="input-group">

                                    <input type="number" class="form-control" id="edad" name="ADM_EDAD"
                                           placeholder="Ej. 25" required min="1" max="120">
                                </div>
                            </div>

                            <!-- Contraseña -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Contraseña</label>
                                <div class="input-group">
                                
                                    <input type="password" class="form-control" id="password" name="ADM_PASSWORD"
                                           placeholder="Mínimo 8 caracteres" required minlength="8">
                                    <button class="toggle-password" type="button" id="togglePassword">
                                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                    </button>
                                </div>
                                <div id="passwordHelp" class="password-strength text-muted">
                                    <i class="bi bi-info-circle"></i> Mínimo 8 caracteres, incluye mayúscula, minúscula y número.
                                </div>
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div class="mb-4">
                                <label for="confirmPassword" class="form-label fw-semibold">Confirmar Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirmPassword"
                                           placeholder="Repite tu contraseña" required>
                                </div>
                                <div id="confirmHelp" class="password-strength text-muted"></div>
                            </div>

                            <button type="submit" class="btn-register" id="btnSubmit">
                                <i class="bi bi-person-plus me-2"></i>Registrarse
                            </button>
                        </form>
                        <div class="footer-note">
                            <small>¿Ya tienes cuenta? <a href="./login.php">Inicia sesión aquí</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const baseUrl = '/authBytech';
        const form = document.getElementById('registerForm');
        const errorContainer = document.getElementById('errorContainer');
        const successContainer = document.getElementById('successContainer');
        const btnSubmit = document.getElementById('btnSubmit');
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('confirmPassword');
        const toggleIcon = document.getElementById('toggleIcon');
        const confirmHelp = document.getElementById('confirmHelp');

        // Mostrar/ocultar contraseña
        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            confirmInput.type = isPassword ? 'text' : 'password';
            toggleIcon.classList.toggle('bi-eye-slash', !isPassword);
            toggleIcon.classList.toggle('bi-eye', isPassword);
        });

        // Validar coincidencia de contraseñas en tiempo real
        confirmInput.addEventListener('input', validarCoincidencia);
        passwordInput.addEventListener('input', validarCoincidencia);

        function validarCoincidencia() {
            const pass = passwordInput.value;
            const confirm = confirmInput.value;
            if (confirm.length === 0) {
                confirmHelp.textContent = '';
                confirmHelp.className = 'password-strength text-muted';
                return;
            }
            if (pass === confirm) {
                confirmHelp.textContent = '✅ Las contraseñas coinciden';
                confirmHelp.className = 'password-strength text-success';
            } else {
                confirmHelp.textContent = '❌ Las contraseñas no coinciden';
                confirmHelp.className = 'password-strength text-danger';
            }
        }

        function mostrarMensaje(contenedor, tipo, mensaje) {
            contenedor.className = `alert alert-${tipo}`;
            contenedor.innerHTML = `
                <span class="bi bi-${tipo === 'danger' ? 'exclamation-triangle-fill' : 'check-circle-fill'} me-2"></span>
                ${mensaje}`;
        }

        function ocultarMensajes() {
            errorContainer.classList.add('d-none');
            successContainer.classList.add('d-none');
        }      

        // Enviar registro (POST)
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            ocultarMensajes();

            // Validación extra de contraseñas
            if (passwordInput.value !== confirmInput.value) {
                mostrarMensaje(errorContainer, 'danger', 'Las contraseñas no coinciden.');
                return;
            }

          

            btnSubmit.disabled = true;
            btnSubmit.textContent = 'Registrando...';

            // Recolectar datos del formulario
            const formData = new FormData(form);
           
            const datos = Object.fromEntries(formData.entries());
            delete datos.confirmPassword; // no lo enviamos

            try {
                console.log('try');
                // Cambia la URL por tu endpoint de registro
                const res = await fetch(`${baseUrl}/api/auth/saveLogin.php`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(datos)
                });

                const contentType = res.headers.get('content-type') || '';
                const resultado = contentType.includes('application/json')
                    ? await res.json()
                    : { success: false, message: await res.text() };

                if (res.ok && resultado.success) {
                    mostrarMensaje(successContainer, 'success', resultado.message || 'Registro exitoso. Redirigiendo...');
                    // Opcional: redirigir después de unos segundos
                    setTimeout(() => {
                        window.location.href = resultado.redirect || `${baseUrl}/views/auth/login.php`;
                    }, 2000);
                } else {
                    mostrarMensaje(errorContainer, 'danger', resultado.error || 'Error al registrarse');
                }
            } catch (err) {
                console.error('Error de red:', err);
                mostrarMensaje(errorContainer, 'danger', 'Error de conexión. Inténtalo más tarde.');
            } finally {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="bi bi-person-plus me-2"></i>Registrarse';
            }
        });
    </script>
</body>
</html>