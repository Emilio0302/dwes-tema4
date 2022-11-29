<?php 
session_start();

if (!$_SESSION || !$_SESSION['usuario']) {
    header('HTTP/1.0 401 Unauthorized');
    echo 'No puede acceder a esta página, <a href="../login.php">inicia sesión</a>';
    exit();
}

session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de autenticación</title>
</head>
<body>
    <header>
        <h1>Sistema de autenticación</h1>
    </header>

    <main>
        <section>
            <article>
                <h1>Has cerrado la sesión</h1>
                <p>Te esperamos pronto</p>
                <p>Vuelve a la <a href="../index.php">página principal</a></p>
            </article>
        </section>
    </main>

    <footer>
        <small>&copy; sitio web</small>
    </footer>
</body>
</html>
