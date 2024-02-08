<?php 
 session_start();
 include "../conexion.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "includes/scripts.php"; ?>
    <title>Bolson</title>
</head>
<body>
    <?php include "includes/header.php"; ?>

    <section id="container">
        
    <div class="title_page">
            <h2>Bolson</h2>
        </div>

        <!-- Datos de la Familia que recibe el bolson -->
        <div class="datos_flia">
            <div class="action_flia">
                <h4>Datos del Beneficiario</h4>
            </div>

            <form name="form_new_flia" id="form_new_flila" class="datos">
                
                <input type="hidden" name="action" value="addFlia">
                <input type="hidden" id="id_tutor" name="id_tutor" value="" required>
                
                <div class="wd30">
                    <label for="dni_tutor">DNI</label>
                    <input type="number" name="dni_tutor" id="dni_tutor">
                </div>
                <div class="wd30">
                    <label for="nombre_tutor">Nombre</label>
                    <input type="text" name="nombre_tutor" id="nombre_tutor" disabled required>
                </div>
                <div class="wd30">
                    <label  for="apellido_tutor">Apellido</label>
                    <input type="text" name="apellido_tutor" id="apellido_tutor" disabled required>
                </div>
                <div class="wd30">
                    <label  for="infantes_hasta6">Infantes hasta 6 años</label>
                    <input type="text" name="infantes_hasta6" id="infantes_hasta6" disabled required>
                </div>
                <div class="wd30">
                    <label for="infantes_mayores6">Infantes mayores a 6 años</label>
                    <input type="text" name="infantes_mayores6" id="infantes_mayores6" disabled required>
                </div>
               
            </form>
        </div>
       
        <!-- Datos del Usuario que arma el bolson -->
        <div class="datos_usuario_armado">
            <h4>Datos del usuario</h4>
            <div class="datos">
                <div class="wd50">
                    
                    <p>Usuario: <?php echo $_SESSION['user'] ?> </p>
                    <p>Fecha de entrega: <?php echo fechaC() ?> </p>
                </div>
                <!-- <div class="wd50">
                    <label for="">Acciones</label>
                    <div id="acciones_usuario">
                        <a href="#" class="btn_ok textcenter" id="btn_anular_bolson">Anular</a>
                        <a href="#" class="btn_ok textcenter" id="btn_ok_bolson">Procesar</a>
                    </div>
                </div> -->
            </div>
        </div>

        <!-- Datos del armado del bolson -->
        <table class="tbl_bolson">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>U. de medida</th>
                    <th>Lote</th>
                    <th>En stock</th>
                    <th>Vencimiento</th>
                    <th>Grupo alimenticio</th>
                    <th>Observaciones</th>
                    <th>Cantidad</th>
                    <th>Acción</th>
                </tr>
                <tr>
                    <th><input type="text" name="txt_cod_prod" id="txt_cod_prod"></th>
                    <th id="txt_nombre">-</th>
                    <th id="txt_marca">-</th>
                    <th id="txt_medida">-</th>
                    <th id="txt_lote">-</th>
                    <th id="txt_stock">-</th>
                    <th id="txt_vencimineto">-</th>
                    <th id="txt_grupo_alimenticio"></th>
                    <th id="txt_observaciones">-</th>
                    <th><input type="text" name="txt_cant" id="txt_cant" value="0" min="1" disabled></th>
                    <th><a href="#" id="add_prod" class="link_add">Agregar</a></th>
                </tr>
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>U. de medida</th>
                    <th colspan="2">Lote</th>
                    <th>Vencimiento</th>
                    <th>Grupo alimenticio</th>
                    <th>Observaciones</th>
                    <th>Cantidad</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody id="detalle_bolson">
                <tr>
                    <th>1</th>
                    <th>Harina</th>
                    <th>marolio</th>
                    <th>1 kg</th>
                    <th colspan="2">5241lp</th>
                    <th>21/02/2024</th>
                    <th>Lacteos</th>
                    <th>Ninguna</th>
                    <th>5</th>
                    <th>
                        <a href="#" class="link_delete" onclick="event.preventDefault(); del_prod_detalle(1);"></a>
                    </th>
                </tr>
                <tr>
                    <th>11</th>
                    <th>Leche</th>
                    <th>sancor</th>
                    <th>1 lt</th>
                    <th colspan="2">8521lp</th>
                    <th>01/10/2024</th>
                    <th>Lacteos</th>
                    <th>Ninguna</th>
                    <th>2</th>
                    <th>
                        <a href="#" class="link_delete" onclick="event.preventDefault(); del_prod_detalle(11);"></a>
                    </th>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9">Total de productos</td>
                    <td class="textright">7</td>
                </tr>
            </tfoot>

        </table>

    </section>

    <?php include "includes/footer.php"; ?>

</body>
</html>


------------
Lo que saque de preodSelecionados
 <!--FLIA qeu recibe el bolson -->
 <section id="container">
		<h2>Familia que recibe Bolson:</h2>

            <form action="borrador.php" method="post">
                <label for="dni_tutor">DNI</label>
                <select name="dni_tutor" id="dni_tutor">
                    <?php 
                        include "../conexion.php";
                        $query_flia = mysqli_query($conn, "SELECT * FROM familia");
                        while ($dni =  mysqli_fetch_array($query_flia)){
                            echo '<option value="' . $dni["dni_tutor"] . '">' . $dni["dni_tutor"] . '</option>';
                        }
                        mysqli_close($conn);
                    ?>
                </select>
                <button type="submit" name="submit_bolson" class="btn_suave" style="border-radius: 5px;">Aceptar</button>
            </form>

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

        <?php 
            include "../conexion.php";

            if(!empty($_POST)){
                $seleccion = $_POST["dni_tutor"];
            
                if ($seleccion === "1"){
                    echo '<p class="msg_error">Se debe designar un Beneficiario</p>';
                }else{
                    
                    $dni = $_POST["dni_tutor"];
                

                    $query = mysqli_query($conn,"SELECT f.id_tutor, f.dni_tutor, f.nombre_tutor, f.apellido_tutor, f.domicilio, f.telefono_tutor, f.vinculo,  f.infantes_hasta6 , f.infantes_mayores6, f.fecha_ingreso,  d.grado_desnutricion, d.tipo_desnutricion FROM familia f INNER JOIN desnutricion d on f.grado_desnutricion = d.grado_desnutricion WHERE dni_tutor = $dni ");
                    
                    mysqli_close($conn);
                    $result = mysqli_num_rows($query);

                    if($result > 0){
                        while($data = mysqli_fetch_array($query)){
                    ?>
                        <tr>
                            <td><?php echo $data["dni_tutor"]; ?></td> 
                            <td><?php echo $data["nombre_tutor"]; ?></td>
                            <td><?php echo $data["apellido_tutor"]; ?></td>
                            <td><?php echo $data["vinculo"]; ?></td>
                            <td><?php echo $data["infantes_hasta6"]; ?></td>
                            <td><?php echo $data["infantes_mayores6"]; ?></td>
                            <td><?php echo $data["tipo_desnutricion"]; ?></td>
                        </tr>
                    <?php 
                        }
                    }
                }
            }
        ?>
       
        </table>         
       
       <?php  
            include "../conexion.php";

            if(isset($_SESSION['user'])) {
             
                $nombre_usuario = $_SESSION['user'];
                $query_usuario = mysqli_query($conn, "SELECT id_usuario FROM usuario WHERE usuario = '$nombre_usuario'");
                $row_usuario = mysqli_fetch_assoc($query_usuario);
                $id_usuario = $row_usuario['id_usuario'];

                if(isset($_POST['submit_bolson'])) {
                    
                    if(isset($_POST['dni_tutor'])) {
                        $dni_tutor = $_POST['dni_tutor'];
                        
                        $query2 = mysqli_query($conn,"SELECT id_tutor from familia WHERE dni_tutor = $dni ");
                        $row = mysqli_fetch_assoc($query2);
                        $id_tutor = $row['id_tutor'];
                       
                        $insert_query = "INSERT INTO bolson (id_usuario, id_tutor) VALUES ('$id_usuario', '$id_tutor')";
                        $result = mysqli_query($conn, $insert_query);
                        
                        if($result) {
                            echo "El bolson se ha guardado exitosamente.";
                        } else {
                            echo "Error al guardar el bolson: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Por favor, seleccione un DNI de tutor.";
                    }
                }
            } else {
                echo "El usuario no está autenticado.";
            }
        ?>
</section>


----------------------
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
    <form action="confirmar.php" method="post">
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
           
            if(!empty($_POST["selected_items"])) {
                
                $productosSeleccionados = $_POST["selected_items"];
                
                foreach($productosSeleccionados as $idProducto) { 
                    
                    $cantidadInputName = "cant_" . $idProducto;
                    $cantidad = $_POST[$cantidadInputName][0];
                    
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
            } else {
                echo "No se han seleccionado productos.";
            }  
        ?>
        
        </table>
    </section>
   
    
        <button type="submit" name="confirmar">Confirmar</button>
    </form>
    

    <?php include "includes/footer.php"; ?>

</body>
</html>


    -----------++
    
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
    <form action="confirmar.php" method="post">
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
           
            if(!empty($_POST["selected_items"])) {
                
                $productosSeleccionados = $_POST["selected_items"];
                
                foreach($productosSeleccionados as $idProducto) { 
                    
                    $cantidadInputName = "cant_" . $idProducto;
                    
                    // Itera sobre todas las cantidades enviadas para este producto
                    foreach($_POST[$cantidadInputName] as $cantidad) {

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
                }
            } else {
                echo "No se han seleccionado productos.";
            }  
        ?>
        
        </table>
    </section>
   
    
        <button type="submit" name="confirmar">Confirmar</button>
    </form>
    

    <?php include "includes/footer.php"; ?>

</body>
</html>


-----------
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
                    
                  /*  $restarCantidadQuery = "UPDATE producto SET cantidad = (cantidad - $cantidad)  WHERE `id_prod`= $idProducto;";
               
                    $resultadoResta = mysqli_query($conn, $restarCantidadQuery);
                    
                    if(!$resultadoResta) {
                        echo "Error al restar la cantidad del producto con ID: $idProducto";
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
            } else {
                echo "No se han seleccionado productos.";
            }  
        ?>
        
        </table>
    </section>
   
    <button type="submit" name="confirmar">Confirmar</button>

    

    <?php include "includes/footer.php"; ?>

</body>
</html>
------------------------------------------------

<?php 
session_start();
include "../conexion.php";

// Validar la entrada del usuario
$dni_tutor = isset($_POST["dni_tutor"]) ? $_POST["dni_tutor"] : null;

if ($dni_tutor && $dni_tutor !== "1") {
    $query = "SELECT f.id_tutor, f.dni_tutor, f.nombre_tutor, f.apellido_tutor, f.domicilio, f.telefono_tutor, f.vinculo,  f.infantes_hasta6 , f.infantes_mayores6, f.fecha_ingreso,  d.grado_desnutricion, d.tipo_desnutricion FROM familia f INNER JOIN desnutricion d on f.grado_desnutricion = d.grado_desnutricion WHERE dni_tutor = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $dni_tutor);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_array($result)) {
            // Mostrar los datos de la familia
            // Aquí puedes imprimir los datos dentro del HTML o guardarlos en una variable para imprimir más adelante
        }
    } else {
        echo '<p class="msg_error">No se encontraron resultados para el DNI seleccionado.</p>';
    }

    mysqli_stmt_close($stmt);
} else {
    echo '<p class="msg_error">Se debe seleccionar un DNI válido.</p>';
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Familia que recibe Bolson</title>
</head>
<body>
    <section id="container">
        <h2>Familia que recibe Bolson:</h2>

        <form action="" method="post"> 
            <label for="dni_tutor">DNI</label>
            <select name="dni_tutor" id="dni_tutor">
                <option value="1"></option>
                <?php 
                    $query_flia = mysqli_query($conn, "SELECT * FROM familia");

                    while ($dni =  mysqli_fetch_array($query_flia)){
                        echo '<option value="' . $dni["dni_tutor"] . '">' . $dni["dni_tutor"] . '</option>';
                    }
                    mysqli_close($conn);
                ?>
            </select>
            <button type="submit" name="submit_bolson" class="btn_suave" style="border-radius: 5px;">Aceptar</button>
        </form>

        <?php 
            include "../conexion.php";
            $nombre_usuario = $_SESSION['user'];
            $query_usuario = mysqli_query($conn, "SELECT id_usuario FROM usuario WHERE usuario = '$nombre_usuario'");
            $row_usuario = mysqli_fetch_assoc($query_usuario);
            $id_usuario = $row_usuario['id_usuario'];

            if(isset($_POST['submit_bolson'])){
                
                $seleccion = $_POST["dni_tutor"];
                $_SESSION['seleccion'] = $_POST["dni_tutor"];
            
                if ($seleccion == "1" || $seleccion == "null"){
                    echo '<p class="msg_error">Se debe designar un Beneficiario</p>';
                    $_SESSION['seleccion'] = null; // Limpia la selección de tutor en la sesión
                    
                }else{
                    
                    $dni = $_POST["dni_tutor"];

                    $query2 = mysqli_query($conn,"SELECT id_tutor from familia WHERE dni_tutor = $dni ");

                    $row = mysqli_fetch_assoc($query2);
                    if ($row) {
                        $id_tutor = $row['id_tutor'];
                    } else {
                        echo '';
                    }

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
                    }
                }
            }  
        ?>   
    </section>
</body>
</html>
