<?php 
    session_start(); 

    include "../conexion.php";
    
    if(!empty($_POST)){

        $alert= "";

        if( empty($_POST["nombre"]) || empty($_POST["marca"]) || empty($_POST["unidad_medida"]) || empty($_POST["lote"]) || empty($_POST["fecha_vencimiento"]) || empty($_POST["cantidad"]) || empty($_POST["alerta_vencimiento"]) || empty($_POST["precio"]) || empty($_POST["tipo_alimenticio"]) ){
            $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
        }else{

            $nombre          = $_POST["nombre"];
            $marca           = $_POST["marca"];
            $unidad_medida   = $_POST["unidad_medida"];
            $lote            = $_POST["lote"];
            $fecha_vencimiento = $_POST["fecha_vencimiento"];
            $cantidad        = $_POST["cantidad"];
            $alerta_vencimiento = $_POST["alerta_vencimiento"];
            $precio          = $_POST["precio"];
            $grupo_alimenticio = $_POST["tipo_alimenticio"];
            $observaciones   = $_POST["observaciones"];

            $query = mysqli_query($conn,"SELECT * FROM producto WHERE lote = '$lote'");
            $result = mysqli_fetch_array($query);

            if($result > 0 ){
                $alert='<p class="msg_error">Ese lote ya se encuentra registrado.</p>';

            }else{
                $query_insert = mysqli_query($conn,"INSERT INTO producto (nombre, marca, unidad_medida, lote, fecha_vencimiento, cantidad, alerta_vencimiento, precio, grupo_alimenticio, observaciones) VALUES ('$nombre','$marca','$unidad_medida','$lote','$fecha_vencimiento','$cantidad', '$alerta_vencimiento' , '$precio', '$grupo_alimenticio', '$observaciones') ");

                mysqli_close($conn);

                if($query_insert){
                    $alert='<p class="msg_save">Producto agregado correctamente!</p>';
                }else{
                    $alert='<p class="msg_error">Lo siento, ha ocurrido un error.</p>';
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Agregar Nuevo Producto</title>
</head>

<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		
        <div class="form_register">
            <h2>Agregar Nuevo Producto</h2>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : '' ; ?></div>

            <form action="" method="post">
                
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre">

                <label for="marca">Marca</label>
                <input type="text" name="marca" id="marca" placeholder="Marca">

                <label for="unidad_medida">Unidad de medida</label>
                <input type="text" name="unidad_medida" id="unidad_medida" placeholder="Unidad de medida. Ej: 1kg">

                <label for="lote">Lote</label>
                <input type="text" name="lote" id="lote" >

                <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                <input type="date" name="fecha_vencimiento" id="fecha_vencimiento">

                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad total de unidades">

                <label for="alerta_vencimiento">Alerta de Vencimiento</label>
                <input type="date" name="alerta_vencimiento" id="alerta_vencimiento">

                <label for="precio">Precio</label>
                <input type="text" name="precio" id="precio" placeholder="Colocar 0 si fue donado">

                <label for="tipo_alimenticio">Grupo Alimenticio</label>
                
                <?php 
                   include "../conexion.php";
                   $query_grupoAlimenticio = mysqli_query($conn, "SELECT * FROM alimentos");
                   mysqli_close($conn);
                   $result_grupoAlimenticio = mysqli_num_rows($query_grupoAlimenticio);
                    
                ?>   

                <select name="tipo_alimenticio" id="tipo_alimenticio">

                    <?php 
                        if($result_grupoAlimenticio>0){
                            while ($grupo_alimenticio =  mysqli_fetch_array($query_grupoAlimenticio)){
                    ?>
                            <option value="<?php echo $grupo_alimenticio["grupo_alimenticio"]; ?>"> <?php echo $grupo_alimenticio["tipo_alimenticio"]; ?> </option>
                    <?php 
                            }
                        }
                    ?>
                                
                </select>

                <label for="observaciones">Observaciones</label>
                <input type="text" name="observaciones" id="observaciones">

                
                <input type="submit" value="Agregar Producto" class="btn_suave">

            </form>
        </div>
	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>