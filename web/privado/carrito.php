<?php
session_start();

require 'modelo.php';

if (!$_SESSION || !$_SESSION['usuario']) {
    header('HTTP/1.0 401 Unauthorized');
    echo 'No puede acceder a esta página, <a href="../login.php">inicia sesión</a>';
    exit();
}
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

    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../pagina_publica.php">Página pública</a></li>
            <li><a href='pagina_privada.php'>Página privada</a></li>
            <li><a href="tienda.php">Tienda</a></li>
            <li><strong>Carrito (<?= totalProductos() ?>)</strong></li>
            <li><a href='logout.php'>Cerrar sesión</a></li>
        </ul>
    </nav>

    <main>
        <section>
            <h1>Cesta de la compra</h1>

            <?php
            if (isset($_SESSION['carrito'])) {
                echo "<ul>";
                foreach ($_SESSION['carrito'] as $producto => $cantidad) {
                    echo <<<END
                    <li>$producto: $cantidad</li>
                    END;
                }
                echo "</ul>";
            } else {
                echo "<p>No hay productos en el carrito de la compra</p>";
            }
            ?>
        </section>
    </main>

    <footer>
        <small><em>&copy; El SuperCarrito de la compra</em></small>
    </footer>
</body>

</html>