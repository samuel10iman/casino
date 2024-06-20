<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino Admin</title>
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
    <div class="hero">
        <div class="hero-content">
            <h2>Bienvenido a Casino Admin</h2>
            <p>Gestione y supervise todos los aspectos de su casino desde un solo lugar.</p>
            <button onclick="redirectTo('InicioSesion.php')">Empezar</button>
        </div>
    </div>
    <main>
        <section class="features">
            <h2>Características Principales</h2>
            <ul class="features-list">
                <li>Gestión de usuarios</li>
                <li>Estadísticas de juegos</li>
                <li>Configuración del casino</li>
                <li>Soporte y asistencia</li>
            </ul>
        </section>
    </main>
    <script src="script.js"></script>
</body>
</html>
