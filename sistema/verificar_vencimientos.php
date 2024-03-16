<?php

include "../conexion.php";

// Obtener la fecha actual en el formato Y-m-d
$fechaActual = date("Y-m-d");

// Consulta para obtener todas las fechas de alerta de vencimiento
$query = mysqli_query($conn, "SELECT `alerta_vencimiento`,`nombre`,`marca`,`lote`,`cantidad` FROM `producto`");

// Array para almacenar las fechas coincidentes
$fechasCoincidentes = array();

// Verificar si hay resultados en la consulta
if ($query) {
    // Recorrer los resultados de la consulta
    while ($row = mysqli_fetch_assoc($query)) {
        // Obtener la fecha de alerta de vencimiento de la fila actual
        $fechaAlerta = $row['alerta_vencimiento'];
        
        // Verificar si la fecha de alerta coincide con la fecha actual
        if ($fechaAlerta == $fechaActual) {
            // Agregar la fecha coincidente al array
            $fechasCoincidentes[] = array(
                'nombre' => $row['nombre'],
                'marca' => $row['marca'],
                'lote' => $row['lote'],
                'cantidad' => $row['cantidad'],
                'fecha_alerta' => $fechaAlerta
            );
        }
    }

    // Cerrar la conexión
    mysqli_close($conn);

    if (!empty($fechasCoincidentes)) {
        // Construir el mensaje para mostrar en el alert
        $mensaje = "Hay productos próximos a vencer:\\n";
        foreach ($fechasCoincidentes as $fechaCoincidente) {
            $mensaje .= "Nombre: " . $fechaCoincidente['nombre'] . ", ";
            $mensaje .= "Marca: " . $fechaCoincidente['marca'] . ", ";
            $mensaje .= "Lote: " . $fechaCoincidente['lote'] . ", ";
            $mensaje .= "Cantidad: " . $fechaCoincidente['cantidad'] . "\\n";
        }
        echo "<script>alert('$mensaje');</script>";
    } else {
       
    }
} else {
    echo "<script>alert('Error al realizar la consulta.');</script>";
}
?>
