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

<style>
    #disabledMessage {
    display: none; 
    position: absolute; 
    background: #254510;
    color: white; 
    padding: 10px;
    border-radius: 5px; 
    pointer-events: none; 
    }
    button[disabled] {
    font-size: .85rem;
	background: #608235;
    opacity: 60%;
	padding: 10px;
	color: #fff;
	letter-spacing: 1px;
	border: 0;
	cursor: pointer;
	border-radius: 5px;
	width: 100%;
    margin-top: 2rem;
    }

    button[disabled]:hover + #disabledMessage {
        display: block; 
    }

    #submitButton:not(:disabled){
        font-size: .85rem;
	background: #608235;
	padding: 10px;
	color: #fff;
	letter-spacing: 1px;
	border: 0;
	cursor: pointer;
	border-radius: 5px;
	width: 100%;
    margin-top: 2rem;
    }
</style>

</head>
<body>

	<?php include "includes/header.php"; ?>

<!--FLIA qeu recibe el bolson -->
    <section id="container">
        

        <form action="" method="post"> 
        <h2 class="p-0">Familia que recibirá este bolsón</h2><br>
            <label for="dni_tutor">Seleccionar DNI del tutor</label>
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
            
            <button type="submit" name="submit_bolson" class="btn_suave"style="border-radius: 5px;">Aceptar</button>
            
        </form>

        <?php 
            include "../conexion.php";
        
            $submit_bolson_pressed = false;

            if(isset($_POST['submit_bolson'])){
              
                $seleccion = $_POST["dni_tutor"];

                if ($seleccion == "1"){
                    echo '<p class="msg_error">Se debe designar un Beneficiario</p>';
                } else {
                   
                    $submit_bolson_pressed = true;
                    $dni = $_POST["dni_tutor"];
                    $_SESSION['dni'] = $_POST["dni_tutor"];

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
                            <th>Niños menores hasta 6 años</th>
                            <th>Niños mayores a 6 años</th>
                            <th>Grado de desnutrición</th>
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
            } else{
                $_SESSION['dni'] = 0; // Limpia la selección de tutor en la sesión
            } 
        ?>             
     
	</section>

<!-- Lista de productos -->
     <section id="container1">
        
        <form id="myForm" action="bolsonArmado.php" method="post" >
        <h2>Lista de Productos</h2>

            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>U. de medida</th>
                    <!-- <th>Lote</th> -->
                    <th>Fecha de vencimiento</th>
                    <th>Stock disponible</th>    
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
                        <!-- <td><?php echo $data["lote"]; ?></td> -->
                        <td><?php echo date('d/m/Y', strtotime($data["fecha_vencimiento"])); ?></td>
                        <td><?php echo $data["cantidad"]; ?></td> 
                        <td><?php echo $data["tipo_alimenticio"]; ?></td>
                        <td>
                            <input type="number" name="cant_<?php echo $data["id_prod"]; ?>[]" min="0" max="<?php echo $data["cantidad"]; ?>" disabled >
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
            
            <button id="submitButton" type="submit" <?php if(!$submit_bolson_pressed) echo "disabled"; ?>>Enviar Selección de Productos</button>
            <p id="disabledMessage">Por favor, seleccione el DNI del tutor primer.</p>

        </form>
    </section>

	<?php include "includes/footer.php"; ?>
    
</body>
</html>