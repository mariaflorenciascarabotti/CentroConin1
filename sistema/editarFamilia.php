<?php 
    session_start();
    if($_SESSION['id_rol'] !=1){
        header("location: ./");
    } 

    include "../conexion.php";

    if(!empty($_POST)){

        $alert= "";

        if(empty($_POST["dni_tutor"]) || empty($_POST["nombre"]) || empty($_POST["apellido"]) || empty($_POST["domicilio"]) || empty($_POST["telefono"]) || empty($_POST["vinculo"]) || empty($_POST["infantes_6"]) || empty($_POST["infantes_mayores"]) || empty($_POST["desnutricion"]) ){
            $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
        }else{
            
            $id_tutor       = $_POST["id_tutor"];
            $dni_tutor      = $_POST["dni_tutor"];
            $nombre         = $_POST["nombre"];
            $apellido       = $_POST["apellido"];
            $domicilio      = $_POST["domicilio"];
            $telefono       = $_POST["telefono"];
            $vinculo        = $_POST["vinculo"];
            $infantes_6     = $_POST["infantes_6"];
            $infantes_mayores = $_POST["infantes_mayores"];
            $desnutricion = $_POST["desnutricion"];

            $query = mysqli_query($conn,"SELECT * FROM familia 
                                        WHERE (dni_tutor = '$dni_tutor' and id_tutor != '$id_tutor')");
            $result = mysqli_fetch_array($query);

            if($result > 0 ){
                $alert='<p class="msg_error">El DNI del tutor ya se encuentra registrado.</p>';

            }else{
                $sql_update = mysqli_query($conn, "UPDATE familia SET dni_tutor = '$dni_tutor', nombre_tutor = '$nombre', apellido_tutor = '$apellido', domicilio = '$domicilio', telefono_tutor = '$telefono', vinculo = '$vinculo', infantes_hasta6 = '$infantes_6', infantes_mayores6= '$infantes_mayores', grado_desnutricion ='$desnutricion' WHERE id_tutor='$id_tutor' ");
                
                if($sql_update){
                    $alert='<p class="msg_save">Usuario actualizado correctamente!</p>';
                }else{
                    $alert='<p class="msg_error">Error al actualizar el usuario.</p>';
                }
            }
        }
        mysqli_close($conn);
    }

    //---------------Mostrar datos
    if(empty($_GET['id'])){
        header('Location: listaFamilia.php');
        mysqli_close($conn);
    }
    
    include "../conexion.php";
    $id_tutor = $_GET['id'];
    $sql = mysqli_query($conn, "SELECT f.id_tutor, f.dni_tutor, f.nombre_tutor, f.apellido_tutor, f.domicilio, f.telefono_tutor, f.vinculo,  f.infantes_hasta6 , f.infantes_mayores6, f.fecha_ingreso,  f.grado_desnutricion, d.tipo_desnutricion 
        FROM familia f
        INNER JOIN desnutricion d 
        on f.grado_desnutricion = d.grado_desnutricion 
        WHERE id_tutor = $id_tutor");
                                
    mysqli_close($conn);
    $result_sql = mysqli_num_rows($sql);
    if($result_sql==0){
        header('Location: listaFamilia.php');
    }else{
        $option = '';
        while($data = mysqli_fetch_array($sql)){

            $id_tutor       = $data["id_tutor"];
            $dni_tutor      = $data["dni_tutor"];
            $nombre         = $data["nombre_tutor"];
            $apellido       = $data["apellido_tutor"];
            $domicilio      = $data["domicilio"];
            $telefono       = $data["telefono_tutor"];
            $vinculo        = $data["vinculo"];
            $infantes_6     = $data["infantes_hasta6"];
            $infantes_mayores = $data["infantes_mayores6"];
            $grado_desnutricion = $data["grado_desnutricion"];
            $desnutricion = $data["tipo_desnutricion"];

            if($grado_desnutricion == 1){
                $option = '<option value="'.$grado_desnutricion.'" select>'.$desnutricion.'</option>';
            }else if($grado_desnutricion == 2){
                $option = '<option value="'.$grado_desnutricion.'" select>'.$desnutricion.'</option>';
            }else if($grado_desnutricion == 3){
                $option = '<option value="'.$grado_desnutricion.'" select>'.$desnutricion.'</option>';
            }

        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Editar Familia</title>
</head>

<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		
        <div class="form_register">
            <h2>Editar Familia</h2>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : '' ; ?></div>

            <form action="" method="post">

                <input type="hidden" name="id_tutor" value="<?php echo $id_tutor; ?> ">
                
                <label for="dni_tutor">DNI</label>
                <input type="text" name="dni_tutor" id="dni_tutor" placeholder="sin puntos" value="<?php echo $dni_tutor; ?> ">

                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre; ?> ">

                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" placeholder="Apellido" value="<?php echo $apellido; ?> ">

                <label for="domicilio">Domicilio</label>
                <input type="text" name="domicilio" id="domicilio" placeholder="Domicilio" value="<?php echo $domicilio; ?> ">

                <label for="telefono">Telefono</label>
                <input type="text" name="telefono" id="telefono" placeholder="Sin 0 ni 15" value="<?php echo $telefono; ?> ">

                <label for="vinculo">Vinculo</label>
                <input type="text" name="vinculo" id="vinculo" placeholder="Vinculo con el menor. Ej: madre" value="<?php echo $vinculo; ?> ">

                <label for="infantes_6">Menores hasta 6 años</label>
                <input type="text" name="infantes_6" id="infantes_6" placeholder="Cantidad de niños hasta 6 años incluidos" value="<?php echo $infantes_6; ?> ">

                <label for="infantes_mayores">Menores mayores a 6 años</label>
                <input type="text" name="infantes_mayores" id="infantes_mayores" placeholder="Cantidad de niños mayores 6 años" value="<?php echo $infantes_mayores; ?> ">

                <label for="desnutricion">Grado de desnutrición</label>
                
                <?php 
                   include "../conexion.php";
                   $query_desnutricion = mysqli_query($conn, "SELECT * FROM desnutricion");
                   mysqli_close($conn);
                   $result_desnutricion = mysqli_num_rows($query_desnutricion);
                    
                ?>   

                <select name="desnutricion" id="desnutricion" class="notItemOne">

                    <?php 
                        echo $option;
                        if($result_desnutricion>0){
                            while ($desnutricion =  mysqli_fetch_array($query_desnutricion)){
                    ?>
                            <option value="<?php echo $desnutricion["grado_desnutricion"]; ?>"> <?php echo $desnutricion["tipo_desnutricion"]; ?> </option>
                    <?php 
                            }
                        }
                    ?>
                                
                </select>
                <input type="submit" value="Agregar Familia" class="btn_suave">

            </form>
            
        </div>
	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>