<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../static/styles.css">
    <style>
        /* Estilos del modal */
        .modal {
            display: none; /* Ocultar inicialmente */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo semi-transparente */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-content button {
            margin: 10px;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h1 onclick="redirectTo('index.php')">Casino Sideral Luján Carrión</h1>
        <nav>
            <ul>
                <li>"Nosotros ganamos tu plata, tú la experiencia"</li>
            </ul>
        </nav>
    </header>
    <div class="hero">
        <div class="hero-content">
            <h2>Bienvenido a Casino Sideral Luján Carrión</h2>
            <p>Gestione y supervise todos los aspectos de su casino desde un solo lugar.</p>
            
        </div>
    </div>
    <main>
        <section class="features">
            <h2>Características Principales</h2>
            <ul class="features-list">
                <li onclick="openUserManagementModal()">Gestión de usuarios</li>
                <li onclick="redirectTo('estadisticasJuegos.php')">Administración de juegos</li>
                <li onclick="redirectTo('almacen.php')">Configuración del casino</li>
                <li onclick="openSupportModal()">Soporte y asistencia</li>
            </ul>
        </section>
    </main>

    <!-- Modal para gestión de usuarios -->
    <div id="userManagementModal" class="modal">
        <div class="modal-content">
            <h2>Gestión de usuarios</h2>
            <button onclick="redirectTo('registroCliente.php')">Crear</button>
            <button onclick="redirectTo('buscarCliente.php')">Buscar</button>
            <button onclick="closeUserManagementModal()">Cerrar</button>
        </div>
    </div>

    <!-- Modal para configuración del casino -->
    <div id="casinoConfigModal" class="modal">
        <div class="modal-content">
            <h2>Configuración del casino</h2>
            <button onclick="redirectTo('almacen.php')">Almacén</button>
            <button onclick="closeCasinoConfigModal()">Cerrar</button>
        </div>
    </div>

    <!-- Modal para soporte y asistencia -->
    <div id="supportModal" class="modal">
        <div class="modal-content">
            <h2>Soporte y asistencia</h2>
            <button onclick="openProveedorModal()">Proveedores</button>
            <button onclick="openPersonalManagementModal()">Personal</button>
            <button onclick="closeSupportModal()">Cerrar</button>
        </div>
    </div>
    <!-- Modal para Personal -->
    <div id="ProveedorModal" class="modal">
        <div class="modal-content">
            <h2>Proveedor</h2>
            <button onclick="redirectTo('registro_proveedores.php')">Crear</button>
            <button onclick="redirectTo('buscarProveedor.php')">Buscar</button>
            <button onclick="closeProveedorModal()">Cerrar</button>
        </div>
    </div>

    <div id="personalManagementModal" class="modal">
        <div class="modal-content">
            <h2>Personal</h2>
            <button onclick="redirectTo('registroPersonal.php')">Crear</button>
            <button onclick="redirectTo('buscarPersonal.php')">Buscar</button>
            <button onclick="closePersonalManagementModal()">Cerrar</button>
        </div>
    </div>

    <script src="script.js"></script>

    <script>
        // Función para redireccionar a una página específica
        function redirectTo(page) {
            window.location.href = page;
        }

        // Función para mostrar el modal de gestión de usuarios
        function openUserManagementModal() {
            var modal = document.getElementById('userManagementModal');
            modal.style.display = 'block';
        }

        // Función para cerrar el modal de gestión de usuarios
        function closeUserManagementModal() {
            var modal = document.getElementById('userManagementModal');
            modal.style.display = 'none';
        }

        // Función para mostrar el modal de configuración del casino
        function openCasinoConfigModal() {
            var modal = document.getElementById('casinoConfigModal');
            modal.style.display = 'block';
        }

        // Función para cerrar el modal de configuración del casino
        function closeCasinoConfigModal() {
            var modal = document.getElementById('casinoConfigModal');
            modal.style.display = 'none';
        }

        // Función para mostrar el modal de soporte y asistencia
        function openSupportModal() {
            var modal = document.getElementById('supportModal');
            modal.style.display = 'block';
        }

        // Función para cerrar el modal de soporte y asistencia
        function closeSupportModal() {
            var modal = document.getElementById('supportModal');
            modal.style.display = 'none';
        }

        function openProveedorModal() {
            var modal = document.getElementById('ProveedorModal');
            modal.style.display = 'block';
        }

        // Función para cerrar el modal de gestión de personal
        function closeProveedorModal() {
            var modal = document.getElementById('ProveedorModal');
            modal.style.display = 'none';
        }

        // Función para abrir el modal de gestión de personal
        function openPersonalManagementModal() {
            var modal = document.getElementById('personalManagementModal');
            modal.style.display = 'block';
        }

        // Función para cerrar el modal de gestión de personal
        function closePersonalManagementModal() {
            var modal = document.getElementById('personalManagementModal');
            modal.style.display = 'none';
        }
    </script>
</body>
</html>
