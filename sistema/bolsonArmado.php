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
            <!-- <h4>Selección de productos a cargo de:</h4> -->
            <div class="datos">
                <div class="wd50">
                    <!-- <p><span  class="text-decoration-underline">Usuario :</span> <?php echo $_SESSION['user'] ?> </p> -->
                    <p><span  style="font-weight: bold;">Fecha de entrega: </span><?php echo fechaC() ?> </p>
                </div>
            </div>
        </div>
    </section>

 <!--Flia que recibe el bolson -->
    <section id="container1" style="margin-bottom: 1rem;">  
        <h4>Familia que recibe el bolsón</h4>
        <?php 
            $dni = $_SESSION['dni'];
     
            $query = mysqli_query($conn,"SELECT f.id_tutor, f.dni_tutor, f.nombre_tutor, f.apellido_tutor, f.domicilio, f.telefono_tutor, f.vinculo,  f.infantes_hasta6 , f.infantes_mayores6, f.fecha_ingreso,  d.grado_desnutricion, d.tipo_desnutricion FROM familia f INNER JOIN desnutricion d on f.grado_desnutricion = d.grado_desnutricion WHERE dni_tutor = $dni ");
        
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
            }else{
                echo 'No se ha designado un beneficiario';
            }
        ?>  
    </section>

 <!-- Listado de productos -->
 
    <section id="container1">  
        <h4>Lista de productos entregados</h4>

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
                    $nombre_usuario = $_SESSION['user'];
                    $query_usuario = mysqli_query($conn, "SELECT id_usuario FROM usuario WHERE usuario = '$nombre_usuario'");
                    $row_usuario = mysqli_fetch_assoc($query_usuario);
                    $id_usuario = $row_usuario['id_usuario'];

                    $dni = $_SESSION['dni'];
                    $query_dni_tutor = mysqli_query($conn, "SELECT id_tutor FROM familia WHERE dni_tutor = '$dni'");
                    $row_dni_tutor = mysqli_fetch_assoc($query_dni_tutor);
                    $id_tutor = $row_dni_tutor['id_tutor'];

                    $query_insert_bolson = "INSERT INTO bolson (id_tutor, id_usuario) VALUES ('$id_tutor', '$id_usuario')";
                    $result_insert_bolson = mysqli_query($conn, $query_insert_bolson);
            
                    if($result_insert_bolson) {
                        $id_bolson = mysqli_insert_id($conn);
                    } else {
                        echo "Error al insertar en la tabla bolson: " . mysqli_error($conn);
                    }
                    
                    if ($result_insert_bolson) {
                   
                        foreach($productosSeleccionados as $idProducto) { 
                        
                            $cantidadInputName = "cant_" . $idProducto;
                            $cantidad = $_POST[$cantidadInputName][0];

                            // Resto la cantidad elegida para actualizar el stock disponible
                            $restarCantidadQuery = "UPDATE producto SET cantidad = (cantidad - $cantidad) WHERE id_prod = $idProducto";
                            $resultadoResta = mysqli_query($conn, $restarCantidadQuery);

                            if(!$resultadoResta) {
                                echo "Error al restar la cantidad del producto con ID: $idProducto";
                            }
                            // -------------

                            $queryProducto = mysqli_query($conn, "SELECT p.nombre, p.marca, p.unidad_medida, p.lote, p.fecha_vencimiento, p.cantidad, p.observaciones, a.tipo_alimenticio FROM producto p INNER JOIN alimentos a ON p.grupo_alimenticio = a.grupo_alimenticio WHERE p.id_prod = $idProducto");

                            $query_insert_prod = "INSERT INTO prod_selecionados (id_bolson, id_prod, cantidad_selec) VALUES ('$id_bolson', '$idProducto', '$cantidad')";

                            $result_insert_prod = mysqli_query($conn, $query_insert_prod);
                
                            if(!$result_insert_prod) {
                                echo "Error al insertar en la tabla prod_selecionados: " . mysqli_error($conn);
                            }
                        
                            if($queryProducto) {
                        
                                $producto = mysqli_fetch_assoc($queryProducto);
            ?>
                <tr>
                    <td><?php echo $producto["nombre"]; ?></td> 
                    <td><?php echo $producto["marca"]; ?></td>
                    <td><?php echo $producto["unidad_medida"]; ?></td>
                    <td><?php echo $producto["lote"]; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($producto["fecha_vencimiento"])); ?></td>

                   
                    <td><?php echo $producto["tipo_alimenticio"]; ?></td>
                    <td><?php echo $producto["observaciones"]; ?></td>   
                    <td><?php echo $cantidad; ?></td>   
                </tr>
           
          <?php 
                            } else {
                                echo "Error al obtener los detalles del producto con ID: $idProducto";
                            } 
                        }
                    } else {
                        echo "No se han seleccionado productos.";
                    }  
                }
                
            ?>

            </table>
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3 no-print">
          <button class="btn btn-primary" type="button" onclick="window.print()">Imprimir</button>
        </div>

    </section>

    <?php include "includes/footer.php"; ?>

</body>
</html>

