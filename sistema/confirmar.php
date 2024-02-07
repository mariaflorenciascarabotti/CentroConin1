<?php 
    session_start();
    include "../conexion.php";

    if(isset($_POST['confirmar'])) {
        // Verificar que se enviaron los productos seleccionados
        if(!empty($_POST["selected_items"])) {
          
            $productosSeleccionados = $_POST["selected_items"];
            
            foreach($productosSeleccionados as $idProducto) { 
               
                $cantidadInputName = "cant_" . $idProducto;
                $cantidad = $_POST[$cantidadInputName][0];
                
                // Restar la cantidad seleccionada de la cantidad en la tabla producto
                $restarCantidadQuery = "UPDATE producto SET cantidad = (cantidad - $cantidad)  WHERE `id_prod`= $idProducto;";
               
                $resultadoResta = mysqli_query($conn, $restarCantidadQuery);
                
                if(!$resultadoResta) {
                    echo "Error al restar la cantidad del producto con ID: $idProducto";
                    // Puedes decidir cómo manejar este error, ya sea detener el proceso, registrar el error, etc.
                }
            }
            
            // Aquí puedes agregar cualquier otra lógica que necesites después de restar las cantidades
        } else {
            echo "No se han seleccionado productos.";
        }
    } else {
        // Redireccionar o mostrar un mensaje de error si se intenta acceder a esta página sin enviar el formulario
    }

    // Puedes redirigir al usuario a otra página o mostrar un mensaje de éxito aquí
?>

