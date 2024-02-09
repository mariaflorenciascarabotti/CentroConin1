<!-- empty($_POST["nombre"]) || empty($_POST["marca"]) || empty($_POST["unidad_medida"]) || empty($_POST["fecha_vencimiento"]) || empty($_POST["cantidad"]) || empty($_POST["alerta_vencimiento"]) || empty($_POST["precio"]) || empty($_POST["tipo_alimenticio"]) -->
<?php 
    session_start();
   
    include "../conexion.php";

    if(!empty($_POST)){

        $alert= "";

       if( empty($_POST["nombre"]) || empty($_POST["marca"]) || empty($_POST["unidad_medida"])  || empty($_POST["cantidad"]) || empty($_POST["precio"]) || empty($_POST["tipo_alimenticio"]) ){
            $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
        }else{

            $id_prod         = $_POST["id_prod"];
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
                if(empty($_POST['lote'])){
                    $sql_update = mysqli_query($conn, "UPDATE producto SET nombre = '$nombre', marca = '$marca', unidad_medida = '$unidad_medida', fecha_vencimiento = '$fecha_vencimiento', cantidad = '$cantidad', alerta_vencimiento = '$alerta_vencimiento', precio= '$precio', grupo_alimenticio ='$grupo_alimenticio' , observaciones= '$observaciones' WHERE id_prod ='$id_prod' ");
                }else{
                    $sql_update = mysqli_query($conn, "UPDATE producto SET nombre = '$nombre', marca = '$marca', unidad_medida = '$unidad_medida', lote = '$lote', fecha_vencimiento = '$fecha_vencimiento', cantidad = '$cantidad', alerta_vencimiento = '$alerta_vencimiento', precio= '$precio', grupo_alimenticio ='$grupo_alimenticio' , observaciones= '$observaciones' WHERE id_prod ='$id_prod' ");
                }
                
                if($sql_update){
                    $alert='<p class="msg_save">Producto actualizado correctamente!</p>';
                }else{
                    $alert='<p class="msg_error">Ha ocurrido un error.</p>';
                }
            }
        }
        mysqli_close($conn);
    }

    //---------------Mostrar datos
    if(empty($_GET['id'])){
        header('Location: listaProducto.php');
        mysqli_close($conn);
    }
    
    include "../conexion.php";
    $id_prod = $_GET['id'];
    $sql = mysqli_query($conn, "SELECT p.id_prod, p.nombre, p.marca, p.unidad_medida, p.lote,p.fecha_vencimiento, p.cantidad,  p.alerta_vencimiento , p.precio, p.grupo_alimenticio, p.observaciones, a.tipo_alimenticio
        FROM producto p
        INNER JOIN alimentos a 
        on p.grupo_alimenticio  = a.grupo_alimenticio  
        WHERE id_prod = $id_prod");
                                
    mysqli_close($conn);
    $result_sql = mysqli_num_rows($sql);
    if($result_sql==0){
        header('Location: listaProducto.php');
    }else{
        $option = '';
        while($data = mysqli_fetch_array($sql)){

            $id_prod         = $data["id_prod"];
            $nombre          = $data["nombre"];
            $marca           = $data["marca"];
            $unidad_medida   = $data["unidad_medida"];
            $lote            = $data["lote"];
            $fecha_vencimiento = $data["fecha_vencimiento"];
            $cantidad        = $data["cantidad"];
            $alerta_vencimiento = $data["alerta_vencimiento"];
            $precio          = $data["precio"];
            $grupo_alimenticio = $data["grupo_alimenticio"];
            $observaciones   = $data["observaciones"];
            $tipo_alimenticio = $data["tipo_alimenticio"];

            if($grupo_alimenticio == 1){
                $option = '<option value="'.$grupo_alimenticio.'" select>'.$tipo_alimenticio.'</option>';
            }else if($grupo_alimenticio == 2){
                $option = '<option value="'.$grupo_alimenticio.'" select>'.$tipo_alimenticio.'</option>';
            }else if($grupo_alimenticio == 3){
                $option = '<option value="'.$grupo_alimenticio.'" select>'.$tipo_alimenticio.'</option>';
            }

        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Editar Producto</title>
</head>

<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		
        <div class="form_register">
            
            
            <div class="alert"><?php echo isset($alert) ? $alert : '' ; ?></div>

            <form action="" method="post">
                <h2>Editar Producto</h2>
                <input type="hidden" name="id_prod" value="<?php echo $id_prod; ?> ">

                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre; ?> ">

                <label for="marca">Marca</label>
                <input type="text" name="marca" id="marca" placeholder="Marca" value="<?php echo $marca; ?> ">

                <label for="unidad_medida">Unidad de medida</label>
                <input type="text" name="unidad_medida" id="unidad_medida" placeholder="unidad_medida" value="<?php echo $unidad_medida; ?> ">

                <label for="lote">Lote</label>
                <input type="text" name="lote" id="lote" placeholder="<?php echo $lote; ?> ">

                <label for="fecha_vencimiento">Fecha de vencimiento</label>
                <input type="text" name="fecha_vencimiento" id="fecha_vencimiento" value="<?php echo $fecha_vencimiento; ?> ">

                <label for="cantidad">Cantidad</label>
                <input type="text" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?> ">

                <label for="alerta_vencimiento">Alerta de vencimiento</label>
                <input type="text" name="alerta_vencimiento" id="alerta_vencimiento" value="<?php echo $alerta_vencimiento; ?> ">

                <label for="precio">Precio</label>
                <input type="text" name="precio" id="precio" value="<?php echo $precio; ?> ">

                <label for="tipo_alimenticio">Grupo Alimenticio</label>
                
                <?php 
                   include "../conexion.php";
                   $query_grupoAlimenticio = mysqli_query($conn, "SELECT * FROM alimentos");
                   mysqli_close($conn);
                   $result_grupoAlimenticio = mysqli_num_rows($query_grupoAlimenticio);
                    
                ?>   

                <select name="tipo_alimenticio" id="tipo_alimenticio" class="notItemOne">

                    <?php 
                        echo $option;
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
                
                <input type="submit" value="Actualizar producto" class="btn_suave">

            </form>
            
        </div>
	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>