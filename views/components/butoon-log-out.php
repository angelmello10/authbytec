<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Botón flotante de cierre de sesión</title>
    <style>
        /* Estilos generales para el botón flotante */
        .logout-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background-color: #ffffff;
            color: #1a1a1a;
            border: 1px solid #e0e0e0;
            border-radius: 6px; /* Bordes menos redondeados para un look más limpio */
            padding: 10px 18px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease-in-out;
        }

        .logout-btn:hover {
            background-color: #1a1a1a;
            color: #ffffff;
            border-color: #1a1a1a;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .logout-btn:active {
            transform: scale(0.98);
        }

        /* Icono SVG para cerrar sesión */
        .logout-icon {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }

        /* Estilos para el texto del botón */
        .logout-text {
            display: inline-block;
        }

        /* Efecto de pulso minimalista (opcional) */
        .logout-btn.pulse {
            animation: pulse 2.5s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.1);
            }
            70% {
                box-shadow: 0 0 0 8px rgba(0, 0, 0, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
            }
        }

        /* Versión móvil - botón más compacto */
        @media (max-width: 768px) {
            .logout-text {
                display: none; /* Oculta el texto en móvil */
            }
            
            .logout-btn {
                border-radius: 6px;
                width: 40px;
                height: 40px;
                padding: 0;
            }
            
            .logout-icon {
                width: 20px;
                height: 20px;
            }
        }

        /* Estilos adicionales para el contenido de prueba */
        body {
            margin: 0;
            padding: 40px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f9f9f9;
            min-height: 100vh;
        }

        .content {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: #1a1a1a;
            font-weight: 600;
        }

        p {
            color: #666666;
            line-height: 1.6;
        }
    </style>
</head>
<body>

    <div class="logout-container">
        <button class="logout-btn pulse" onclick="logOut()" aria-label="Cerrar sesión">
            <svg class="logout-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
            </svg>
            <span class="logout-text">Cerrar Sesión</span>
        </button>
    </div>

    <script>
        function logOut() {
            const btn = document.querySelector('.logout-btn');
            const originalText = btn.innerHTML;
            btn.innerHTML = 'Cerrando...';
            btn.style.opacity = '0.5';
            btn.disabled = true;

            fetch('../api/auth/logOut.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '../index.php';
                    } else {
                        btn.innerHTML = originalText;
                        btn.style.opacity = '1';
                        btn.disabled = false;
                        alert('Error al cerrar sesión.');
                    }
                })
                .catch(error => {
                    btn.innerHTML = originalText;
                    btn.style.opacity = '1';
                    btn.disabled = false;
                    console.error('Error:', error);
                    alert('Error de conexión.');
                });
        }
    </script>
</body>
</html>