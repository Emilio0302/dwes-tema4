<?php
session_start();

//Si el usuario esta logeado, no puede estar aqui
if (isset($_SESSION['usuario'])) {
    header('location: index.php');
    exit();
}

require 'lib/gestionUsuarios.php';

if ($_POST) {
    $errores = registroUsuario(
        isset($_POST['usuario']) ? $_POST['usuario'] : '',
        isset($_POST['clave']) ? $_POST['clave'] : '',
        isset($_POST['repite_clave']) ? $_POST['repite_clave'] : ''
    );
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registro de usuarios</title>
</head>

<body>
    <header>
        <h1>Sistema de autenticación</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="pagina_publica.php">Página pública</a></li>
            <li><a href='login.php'>Iniciar sesión</a></li>
            <li><strong>Regístrate</strong></li>
        </ul>
    </nav>

    <main>
        <h1>Regístrate</h1>
        <?php
        if (isset($errores) && !$errores) {
            echo "<p> Te has registrado correctamente </p>";
        } else {
        ?>
        <form action="registro.php" method="post">
            <p>
                <label for="usuario">Nombre de usuario</label><br>
                <input type="text" name="usuario" id="usuario" 
                       value="<?= $_POST && isset($_POST['usuario']) ? $_POST['usuario'] : "" ?>">
            </p>
            <?php
            if (isset($errores) && isset($errores['usuario'])) {
                echo "<p>" . $errores['usuario'] . "</p>";
            }
            ?>
            <p>
                <label for="clave">Contraseña</label><br>
                <input type="password" name="clave" id="clave">
            </p>
            <?php
            if (isset($errores) && isset($errores['clave'])) {
                echo $errores['clave'];
            }
            ?>
            <p>
                <label for="repite_clave">Repite la contraseña</label><br>
                <input type="password" name="repite_clave" id="repite_clave">
            </p>
            <p>
                <input type="submit" value="Registrarse">
            </p>
        </form>
        <?php } ?>
    </main>

    <footer>
        <small>&copy; sitio web</small>
    </footer>
</body>

</html>