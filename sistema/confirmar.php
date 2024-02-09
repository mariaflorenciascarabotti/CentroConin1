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
                  
                }
            }
            
        } else {
            echo "No se han seleccionado productos.";
        }
    } else {
        
    }

   
?>

