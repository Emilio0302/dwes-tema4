<?php
session_start();

require 'modelo.php';

if (!$_SESSION || !$_SESSION['usuario']) {
    header('HTTP/1.0 401 Unauthorized');
    echo 'No puede acceder a esta página, <a href="../login.php">inicia sesión</a>';
    exit();
}

$productoNuevo = [];

function productoValido($producto)
{
    global $productos;

    $resultado = array_filter($productos, fn ($p) => $p['id'] == $producto);

    if (count($resultado) == 1) {
        return true;
    } else {
        return false;
    }
}

if ($_POST) {
    $datos = [
        'producto' => htmlspecialchars(trim($_POST['producto'])),
        'cantidad' => htmlspecialchars(trim($_POST['cantidad']))
    ];

    $argumentos = [
        'producto' => [
            'filter' => FILTER_CALLBACK,
            'options' => 'productoValido'
        ],
        'cantidad' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range' => 1]
        ]
    ];

    $validaciones = filter_var_array($datos, $argumentos);

    if ($validaciones['producto'] !== false && $validaciones['cantidad'] !== false) {
        $producto = $datos['producto'];
        $cantidad = $datos['cantidad'];
        $_SESSION['carrito'][$producto] = $cantidad;
        $productoNuevo[$producto] = $cantidad;
    }
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
            <li><strong>Tienda</strong></li>
            <li><a href="carrito.php">Carrito (<?= totalProductos() ?>)</a></li>
            <li><a href='logout.php'>Cerrar sesión</a></li>
        </ul>
    </nav>

    <?php if ($productoNuevo) { ?>
        <section>
            <p>
                Se ha añadido un nuevo producto:
            </p>
            <p>
            <ul>
                <li><?= array_key_first($productoNuevo) . ": " . $productoNuevo[array_key_first($productoNuevo)] ?></li>
            </ul>
            </p>
        </section>
    <?php } ?>

    <section>
        <form action="" method="post">
            <p>
                <label for="producto">Elige un producto</label>
                <select name="producto" id="producto">
                    <?php
                    foreach ($productos as $producto) {
                        echo "<option value='{$producto['id']}'>{$producto['valor']}</option>";
                        if (isset($validaciones) && $validaciones['producto'] === false) {
                            echo "<p>$producto no es una opción válida</p>";
                        }
                    }
                    ?>
                </select>
            </p>
            <p>
                <label for="cantidad">Elige la cantidad</label>
                <input type="number" name="cantidad" id="cantidad">
                <?php
                if (isset($validaciones) && $validaciones['cantidad'] === false) {
                    echo "<p>{$datos['cantidad']} no es una cantidad válida, elige una cantidad mayor que 0</p>";
                }
                ?>
            </p>
            <p>
                <input type="submit" value="Añadir al carrito">
            </p>
        </form>
    </section>
    </main>

    <footer>
        <small><em>&copy; El SuperCarrito de la compra</em></small>
    </footer>
</body>

</html>