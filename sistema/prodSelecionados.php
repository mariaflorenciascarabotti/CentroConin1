<?php 
    session_start();
    include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de Productos</title>
</head>
<body>

	<?php include "includes/header.php"; ?>

<!--FLIA qeu recibe el bolson -->
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

            if(isset($_POST['submit_bolson'])){
                
                $seleccion = $_POST["dni_tutor"];
                $_SESSION['seleccion'] = $_POST["dni_tutor"];
            
                if ($seleccion == "1"){
                    echo '<p class="msg_error">Se debe designar un Beneficiario</p>';
                }else{
                    
                    $dni = $_POST["dni_tutor"];

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
       
       <?php  
            include "../conexion.php";

            if(isset($_SESSION['user'])) {
             
                $nombre_usuario = $_SESSION['user'];
                $query_usuario = mysqli_query($conn, "SELECT id_usuario FROM usuario WHERE usuario = '$nombre_usuario'");
                $row_usuario = mysqli_fetch_assoc($query_usuario);
                $id_usuario = $row_usuario['id_usuario'];

                if(isset($_POST['submit_bolson'])) {
                    
                    if(isset($_POST['dni_tutor'])) {
                       
                        $dni = $_POST['dni_tutor'];   

                        $query2 = mysqli_query($conn,"SELECT id_tutor from familia WHERE dni_tutor = $dni ");

                        $row = mysqli_fetch_assoc($query2);
                        if ($row) {
                            $id_tutor = $row['id_tutor'];
                        } else {
                            echo '';
                        }

                       
                       /* $insert_query = "INSERT INTO bolson (id_usuario, id_tutor) VALUES ('$id_usuario', '$id_tutor')";
                        $result = mysqli_query($conn, $insert_query);
                        
                        if($result) {
                            echo "El bolson se ha guardado exitosamente.";
                        } else {
                            echo "Error al guardar el bolson: " . mysqli_error($conn);
                        }*/
                    } else {
                        $_SESSION['seleccion'] = null; // Limpia la selección de tutor en la sesión
                        echo "Por favor, seleccione un DNI de tutor.";
                    }                    
                }
            } 
        ?>
	</section>

<!-- Lista de productos -->
	<section id="container" ">
		<h2>Lista de Productos</h2>

        <form action="borrador.php" method="post">
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>U. de medida</th>
                    <th>Lote</th>
                    <th>Fecha de vencimiento</th>
                    <th>Stock</th>    
                    <th>Grupo alimenticio</th>
                    <th>Cantidad</th>
                    <th>Seleccionar</th>
                </tr>

        <?php 
            include "../conexion.php";
            
            $query = mysqli_query($conn,"SELECT p.id_prod, p.nombre, p.marca, p.unidad_medida, p.lote, p.fecha_vencimiento, p.cantidad, p.alerta_vencimiento, p.precio, p.observaciones, a.grupo_alimenticio, a.tipo_alimenticio FROM producto p INNER JOIN alimentos a on p.grupo_alimenticio = a.grupo_alimenticio  ORDER BY grupo_alimenticio ASC "); 
            mysqli_close($conn);
            $result = mysqli_num_rows($query);

            if($result > 0){
                while($data = mysqli_fetch_array($query)){
        ?>
                <tr>
                    <td><?php echo $data["nombre"]; ?></td> 
                    <td><?php echo $data["marca"]; ?></td>
                    <td><?php echo $data["unidad_medida"]; ?></td>
                    <td><?php echo $data["lote"]; ?></td>
                    <td><?php echo $data["fecha_vencimiento"]; ?></td>
                    <td><?php echo $data["cantidad"]; ?></td> 
                    <td><?php echo $data["tipo_alimenticio"]; ?></td>
                    <td>
                        <input type="number" name="cant_<?php echo $data["id_prod"]; ?>[]" min="0" max="<?php echo $data["cantidad"]; ?>">
                    </td>
                    <td>
                        <input type="checkbox" name="selected_items[]" value="<?php echo $data["id_prod"]; ?>"> 
                    </td>
                </tr>
        <?php 
                }
            }
        ?>
            </table>       
             
            <button type="submit">Enviar Selección de Productos</button>

        </form> 
        
	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>