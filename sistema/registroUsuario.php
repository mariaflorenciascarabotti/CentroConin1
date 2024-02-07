<?php 
    session_start();

    if($_SESSION['id_rol'] !=1){
        header("location: ./");
    }

    include "../conexion.php";

    if(!empty($_POST)){

        $alert= "";

        if(empty($_POST["nombre"]) || empty($_POST["apellido"]) || empty($_POST["email"]) || empty($_POST["usuario"]) || empty($_POST["clave"]) || empty($_POST["rol"])){
            $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
        }else{
                       
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $email = $_POST["email"];
            $usuario = $_POST["usuario"];
            $clave = md5($_POST["clave"]);
            $rol = $_POST["rol"];

            $query = mysqli_query($conn,"SELECT * FROM usuario WHERE usuario = '$usuario' OR email = '$email' ");
            $result = mysqli_fetch_array($query);

            if($result > 0 ){
                $alert='<p class="msg_error">El email o usuario ya existen.</p>';
            }else{
                $query_insert = mysqli_query($conn,"INSERT INTO usuario(nombre,apellido,email,usuario,clave,id_rol) VALUES('$nombre','$apellido','$email','$usuario','$clave','$rol')");

                mysqli_close($conn);
                
                if($query_insert){
                    $alert='<p class="msg_save">Usuario creado correctamente!</p>';
                }else{
                    $alert='<p class="msg_error">Error al crear el usuario.</p>';
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
	<title>Registro Nuevo Usuario</title>
</head>

<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		
        <div class="form_register">
            <h2>Registro de Nuevo Usuario</h2>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : '' ; ?></div>

            <form action="" method="post">

                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre">

                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" placeholder="Apellido">

                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" placeholder="E-mail">

                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario">

                <label for="clave">Contraseña</label>
                <input type="password" name="clave" id="clave" placeholder="Contraseña">

                <label for="rol">Tipo de usuario</label>
                
                <?php 
                    include "../conexion.php";
                    $query_rol = mysqli_query($conn, "SELECT * FROM rol");
                    mysqli_close($conn);
                    $result_rol = mysqli_num_rows($query_rol);
                    
                ?>

                <select name="rol" id="rol">

                    <?php 
                        if($result_rol>0){
                            while ($rol =  mysqli_fetch_array($query_rol)){
                    ?>
                            <option value="<?php echo $rol["id_rol"]; ?>" ><?php echo $rol["rol"]; ?> </option>
                    <?php 
                            }
                        }
                    ?>
                                
                </select>
                <button type="submit" class="btn_suave">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                    </svg> Crear Usuario
                </button>

            </form>
        </div>
	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>