<?php 
    session_start(); 

    // este "if" sirve para que solo lo puede ver quien es administrador (Rol = 1)
   /* if($_SESSION['id_rol'] !=1){
        header("location: ./");
    }
*/
    include "../conexion.php";
    
    if(!empty($_POST)){

        $alert= "";

        if(empty($_POST["dni_tutor"]) || empty($_POST["nombre"]) || empty($_POST["apellido"]) || empty($_POST["domicilio"]) || empty($_POST["telefono"]) || empty($_POST["vinculo"]) || ($_POST["infantes_6"] === "" || $_POST["infantes_6"] === null) || ($_POST["infantes_mayores"] === "" || $_POST["infantes_mayores"] === null) || empty($_POST["desnutricion"]) ){
            $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
        }else{
            
            $dni            = $_POST["dni_tutor"];
            $nombre         = $_POST["nombre"];
            $apellido       = $_POST["apellido"];
            $domicilio      = $_POST["domicilio"];
            $telefono       = $_POST["telefono"];
            $vinculo        = $_POST["vinculo"];
            $infantes_6     = $_POST["infantes_6"];
            $infantes_mayores = $_POST["infantes_mayores"];
            $desnutricion = $_POST["desnutricion"];

            $query = mysqli_query($conn,"SELECT * FROM familia WHERE dni_tutor = '$dni'");
            $result = mysqli_fetch_array($query);

            if($result > 0 ){
                $alert='<p class="msg_error">El DNI del tutor ya se encuentra registrado.</p>';

            }else{
                $query_insert = mysqli_query($conn," INSERT INTO `familia` (`dni_tutor`, `nombre_tutor`, `apellido_tutor`, `domicilio`, `telefono_tutor`, `vinculo`, `infantes_hasta6`, `infantes_mayores6`, `grado_desnutricion`) VALUES ('$dni','$nombre','$apellido','$domicilio','$telefono','$vinculo','$infantes_6', '$infantes_mayores' , '$desnutricion') ");

                mysqli_close($conn);
                if($query_insert){
                    $alert='<p class="msg_save">Tutor agregado correctamente!</p>';
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
	<title>Registro Familia</title>
</head>

<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
    
          
        <div class="form_register">
          
            <div class="alert"><?php echo isset($alert) ? $alert : '' ; ?></div>

            <form action="" method="post">
            <h2>Registro de Nueva Familia</h2>
            <p class=" m-0">Datos sobre el tutor a cargo</p>
                
                <label for="dni_tutor">DNI</label>
                <input type="text" name="dni_tutor" id="dni_tutor" placeholder="sin puntos">

                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre">

                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" placeholder="Apellido">

                <label for="domicilio">Domicilio</label>
                <input type="text" name="domicilio" id="domicilio" placeholder="Domicilio">

                <label for="telefono">Telefono</label>
                <input type="text" name="telefono" id="telefono" placeholder="Sin 0 ni 15">

                <label for="vinculo">Vinculo</label>
                <input type="text" name="vinculo" id="vinculo" placeholder="Vinculo con el menor. Ej: madre">

                <label for="infantes_6">Menores hasta 6 años</label>
                <input type="number" name="infantes_6" id="infantes_6" placeholder="Cantidad de niños hasta 6 años incluidos">

                <label for="infantes_mayores">Menores mayores a 6 años</label>
                <input type="number" name="infantes_mayores" id="infantes_mayores" placeholder="Cantidad de niños mayores 6 años">

                <label for="desnutricion">Grado de desnutrición</label>
                
                <?php 
                   include "../conexion.php";
                   $query_desnutricion = mysqli_query($conn, "SELECT * FROM desnutricion");
                   mysqli_close($conn);
                   $result_desnutricion = mysqli_num_rows($query_desnutricion);
                    
                ?>   

                <select name="desnutricion" id="desnutricion">

                    <?php 
                        if($result_desnutricion>0){
                            while ($desnutricion =  mysqli_fetch_array($query_desnutricion)){
                    ?>
                            <option value="<?php echo $desnutricion["grado_desnutricion"]; ?>"> <?php echo $desnutricion["tipo_desnutricion"]; ?> </option>
                    <?php 
                            }
                        }
                    ?>
                                
                </select>
                
                <button type="submit" class="btn_suave">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                    </svg> Agregar Familia
                </button>

            </form>
        </div>
	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>