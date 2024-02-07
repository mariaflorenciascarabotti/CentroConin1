<?php 
session_start();
include "../conexion.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Bolson</title>
</head>
<body>

    <?php include "includes/header.php"; ?>
  
 <!--Usuario que arma el bolson -->
    <section id="container">
        <div class="datos_usuario_armado">
            <h4>Datos del usuario</h4>
            <div class="datos">
                <div class="wd50">
                    <p>Usuario: <?php echo $_SESSION['user'] ?> </p>
                    <p>Fecha de entrega: <?php echo fechaC() ?> </p>
                </div>
             
            </div>
        </div>
    </section>

 <!--Flia que recibe el bolson -->
    <section id="container">  
        <?php 
            $seleccion = $_SESSION['seleccion'];

            $query = mysqli_query($conn,"SELECT f.id_tutor, f.dni_tutor, f.nombre_tutor, f.apellido_tutor, f.domicilio, f.telefono_tutor, f.vinculo,  f.infantes_hasta6 , f.infantes_mayores6, f.fecha_ingreso,  d.grado_desnutricion, d.tipo_desnutricion FROM familia f INNER JOIN desnutricion d on f.grado_desnutricion = d.grado_desnutricion WHERE dni_tutor = $seleccion ");
            
            mysqli_close($conn);
            $result = mysqli_num_rows($query);

            if($result > 0){
                while($data = mysqli_fetch_array($query)){
        ?>
            <table>
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Vinculo</th>
                    <th>Menores hasta 6 años</th>
                    <th>Mayores a 6 años</th>
                    <th>Grado de desnutricion</th>
                </tr>
                <tr>
                    <td><?php echo $data["dni_tutor"]; ?></td> 
                    <td><?php echo $data["nombre_tutor"]; ?></td>
                    <td><?php echo $data["apellido_tutor"]; ?></td>
                    <td><?php echo $data["vinculo"]; ?></td>
                    <td><?php echo $data["infantes_hasta6"]; ?></td>
                    <td><?php echo $data["infantes_mayores6"]; ?></td>
                    <td><?php echo $data["tipo_desnutricion"]; ?></td>
                </tr>
            </table>
        <?php 
                }
            }
        ?>  
    </section>

 <!-- Listado de productos -->
 
    <section id="container">  

        <h2>Lista de productos seleccionados</h2>
        
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>U. de medida</th>
                    <th>Lote</th>
                    <th>Fecha de vencimiento</th>
                    <th>Grupo alimenticio</th>
                    <th>Observaciones</th>
                    <th>Cantidad</th>
                </tr>

            <?php 
                include "../conexion.php";

                if(!empty($_POST["selected_items"])) {
                    
                    $productosSeleccionados = $_POST["selected_items"];
                    
                    foreach($productosSeleccionados as $idProducto) { 
                        
                        $cantidadInputName = "cant_" . $idProducto;
                        $cantidad = $_POST[$cantidadInputName][0];

                  /*      if(isset($_POST['confirmar'])){
                            // Restar la cantidad seleccionada de la cantidad en la tabla producto
                            $restarCantidadQuery = "UPDATE producto SET cantidad = (cantidad - $cantidad) WHERE id_prod = $idProducto";
                            $resultadoResta = mysqli_query($conn, $restarCantidadQuery);

                            if(!$resultadoResta) {
                                echo "Error al restar la cantidad del producto con ID: $idProducto";
                                // Puedes decidir cómo manejar este error, ya sea detener el proceso, registrar el error, etc.
                            }
                        }*/
                        
                        $queryProducto = mysqli_query($conn, "SELECT p.nombre, p.marca, p.unidad_medida, p.lote, p.fecha_vencimiento, p.cantidad, p.observaciones, a.tipo_alimenticio FROM producto p INNER JOIN alimentos a ON p.grupo_alimenticio = a.grupo_alimenticio WHERE p.id_prod = $idProducto");
                        
                        if($queryProducto) {
                    
                            $producto = mysqli_fetch_assoc($queryProducto);
            ?>

                <tr>
                    <td><?php echo $producto["nombre"]; ?></td> 
                    <td><?php echo $producto["marca"]; ?></td>
                    <td><?php echo $producto["unidad_medida"]; ?></td>
                    <td><?php echo $producto["lote"]; ?></td>
                    <td><?php echo $producto["fecha_vencimiento"]; ?></td>
                    <td><?php echo $producto["tipo_alimenticio"]; ?></td>
                    <td><?php echo $producto["observaciones"]; ?></td>   
                    <td><?php echo $cantidad; ?></td>   
                </tr>

            <?php 
                        } else {
                            echo "Error al obtener los detalles del producto con ID: $idProducto";
                        }
                    }
                    if(isset($_POST['confirmar'])){
                        // Obtener los valores de cantidad e idProducto
                        $cantidad = $_POST['cantidad']; // Asegúrate de que el nombre del campo en el formulario sea 'cantidad'
                        $idProducto = $_POST['id_producto']; // Asegúrate de que el nombre del campo en el formulario sea 'id_producto'
                    
                        // Depuración: Imprimir los valores para verificar
                        echo "Cantidad: $cantidad, ID Producto: $idProducto";
                    
                        // Restar la cantidad seleccionada de la cantidad en la tabla producto
                        $restarCantidadQuery = "UPDATE producto SET cantidad = (cantidad - $cantidad) WHERE id_prod = $idProducto";
                        $resultadoResta = mysqli_query($conn, $restarCantidadQuery);
                    
                        // Verificar si la consulta se ejecutó correctamente
                        if($resultadoResta) {
                            echo "La cantidad del producto con ID $idProducto se ha actualizado correctamente.";
                        } else {
                            echo "Error al restar la cantidad del producto con ID: $idProducto: " . mysqli_error($conn);
                            // Puedes decidir cómo manejar este error, ya sea detener el proceso, registrar el error, etc.
                        }  
                    }
                    
                } else {
                    echo "No se han seleccionado productos.";
                }  
                
            ?>
            
            </table>
      
            <button type="submit" name="confirmar">Confirmar</button>
       
        

    </section>
   
    
      

    <?php include "includes/footer.php"; ?>

</body>
</html>