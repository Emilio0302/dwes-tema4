<?php
$productos = [
    ['id' => 'pan', 'valor' => 'Pan'],
    ['id' => 'aceite', 'valor' => 'Aceite'],
    ['id' => 'platano', 'valor' => 'Plátano'],
    ['id' => 'arroz', 'valor' => 'Arroz']
];

function totalProductos(): int {
    $total = 0;
    if ($_SESSION && isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $cantidad) {
            $total += $cantidad;
        }
    }
    return $total;
}
