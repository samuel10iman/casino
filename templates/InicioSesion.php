<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página de inicio de sesión para el panel administrativo del casino.">
    <title>Iniciar Sesión - Casino Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../static/styles.css">
</head>
<body>
    <header>
        <h1 onclick="redirectTo('index.php')">Casino Admin</h1>
        <nav>
            <ul>
                <li>"Nosotros ganamos tu plata, tú la experiencia"</li>
            </ul>
        </nav>
    </header>
    <main class="main-container">
        <div class="content-wrapper">
            <section id="login" class="login-container">
                <div class="login-box">
                    <h2>Iniciar Sesión</h2>
                    <form action="../login.php" method="POST" novalidate>
                        <div class="input-group">
                            <label for="username">Usuario:</label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        <div class="input-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <button type="submit" name="btningresar">Ingresar</button>
                    </form>
                </div>
            </section>
            <section id="info" class="info-box">
                <h2>Bienvenido al Panel Administrativo del Casino</h2>
                <p>Aquí puedes gestionar todos los aspectos del casino y acceder a los diferentes juegos.</p>
                <h3>Características</h3>
                <ul class="features-list">
                    <li>Gestión de usuarios</li>
                    <li>Estadísticas de juegos</li>
                    <li>Configuración del casino</li>
                    <li>Soporte y asistencia</li>
                </ul>
            </section>
            <section id="content" class="hidden">
                <h2 id="content-title"></h2>
                <div id="content-options" class="content-options hidden">
                    <button onclick="showAddForm()">Añadir</button>
                    <button onclick="showDeleteForm()">Eliminar</button>
                    <button onclick="showSearchForm()">Buscar</button>
                </div>
                <div id="add-form" class="hidden">
                    <h3>Añadir</h3>
                    <form onsubmit="addData(event)">
                        <div class="input-group">
                            <label for="add-data">Datos a añadir:</label>
                            <input type="text" id="add-data" name="add-data" required>
                        </div>
                        <button type="submit">Añadir</button>
                    </form>
                </div>
                <div id="delete-form" class="hidden">
                    <h3>Eliminar</h3>
                    <form onsubmit="deleteData(event)">
                        <div class="input-group">
                            <label for="delete-data">Datos a eliminar:</label>
                            <input type="text" id="delete-data" name="delete-data" required>
                        </div>
                        <button type="submit">Eliminar</button>
                    </form>
                </div>
                <div id="search-form" class="hidden">
                    <h3>Buscar</h3>
                    <form onsubmit="searchData(event)">
                        <div class="input-group">
                            <label for="search-data">Datos a buscar:</label>
                            <input type="text" id="search-data" name="search-data" required>
                        </div>
                        <button type="submit">Buscar</button>
                    </form>
                    <div id="search-results"></div>
                </div>
            </section>
        </div>
    </main>
    <script src="script.js"></script>
</body>
</html>
