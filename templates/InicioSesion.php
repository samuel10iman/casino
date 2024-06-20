<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Casino Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../static/styles.css">
</head>
<body>
    <header>
        <h1 onclick="redirectTo('index.php')">Casino Admin</h1>
        <nav>
            <ul>
                <li><button onclick="redirectTo('slot.php')">Tragaperras</button></li>
                <li><button onclick="redirectTo('roulette.php')">Ruleta</button></li>
                <li><button onclick="redirectTo('blackjack.php')">Blackjack</button></li>
                <li><button onclick="redirectTo('poker.php')">Poker</button></li>
            </ul>
        </nav>
    </header>
    <main class="main-container">
        <div class="content-wrapper">
            <section id="login" class="login-container">
                <div class="login-box">
                    <h2>Iniciar Sesión</h2>
                    <form action="../login.php" method="POST">
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
            <section id="BarraLateral" class="sidebar hidden">
                <h2>PROBANDO</h2>
                <ul class="sidebar-buttons">
                    <li><button onclick="redirectTo('cliente.php')">Cliente</button></li>
                    <li><button onclick="redirectTo('juegos.php')">Juegos</button></li>
                    <li><button onclick="redirectTo('almacen.php')">Almacén</button></li>
                    <li><button onclick="redirectTo('personal.php')">Personal</button></li>
                </ul>
            </section>
        </div>
    </main>
    <script src="script.js"></script>
</body>
</html>
