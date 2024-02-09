<?php
session_start();
include "../conexion.php";

// Obtener la fecha actual
$fecha_actual = date("Y-m-d");

echo $fecha_actual;

// Consultar los productos cuya fecha de alerta de vencimiento coincida con la fecha actual
$query = mysqli_query($conn, "SELECT * FROM producto WHERE alerta_vencimiento = '$fecha_actual'");

// Verificar si hay productos que coincidan con la fecha actual
if (mysqli_num_rows($query) > 0) {
    // Envía un correo electrónico a todos los usuarios
    $subject = "Alerta de vencimiento de productos";
    $message = "Uno o más productos han alcanzado su fecha de alerta de vencimiento. Por favor, revisa tus productos.";
    $headers = "From: tu_correo@example.com";

    // Consulta para obtener los correos electrónicos de todos los usuarios
    $query_usuarios = mysqli_query($conn, "SELECT email FROM usuarios");

    // Envía el correo electrónico a cada usuario
    while ($usuario = mysqli_fetch_assoc($query_usuarios)) {
        mail($usuario['email'], $subject, $message, $headers);
    }
}
?>
