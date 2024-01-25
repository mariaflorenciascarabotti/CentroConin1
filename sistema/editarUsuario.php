<?php 
    include "../conexion.php";

    if(!empty($_POST)){
        $alert= "";
        if(empty($_POST["nombre"]) || empty($_POST["apellido"]) || empty($_POST["email"]) || empty($_POST["usuario"]) || empty($_POST["rol"])){
            $alert='<p class="msg_error">Todos los ampos son obligatorios</p>';
        }else{
    
            $id_usuario = $_POST["id_usuario"];
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $email = $_POST["email"];
            $usuario = $_POST["usuario"];
            $clave = md5($_POST["clave"]);
            $rol = $_POST["rol"];

            $query = mysqli_query($conn,"SELECT * FROM usuario
                                         WHERE (usuario = '$usuario' and id_usuario != '$id_usuario')
                                         OR (email = '$email' and id_usuario != '$id_usuario')");
                                      
            $result = mysqli_fetch_array($query);

            if($result > 0 ){
                $alert='<p class="msg_error">El email o usuario ya existen.</p>';
            }else{
                if(empty($_POST['clave'])){
                    $sql_update = mysqli_query($conn, "UPDATE usuario SET nombre = '$nombre', email='$email', usuario='$usuario', id_rol='$rol' WHERE id_usuario=$id_usuario");
                }else{
                    $sql_update = mysqli_query($conn, "UPDATE usuario SET nombre = '$nombre', email='$email', usuario='$usuario', clave='$clave', id_rol='$rol' WHERE id_usuario=$id_usuario");
                }
              
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
        header('Location: listaUsuario.php');
        mysqli_close($conn);
    }

    $iduser = $_GET['id'];
    $sql = mysqli_query($conn, "SELECT u.id_usuario, u.nombre, u.apellido, u.email, u.usuario, (u.id_rol) as idrol, (r.rol) as rol 
                                FROM usuario u 
                                INNER JOIN rol r
                                on u.id_rol = r.id_rol
                                WHERE id_usuario = $iduser");
                                
    mysqli_close($conn);
    $result_sql = mysqli_num_rows($sql);
    if($result_sql==0){
        header('Location: listaUsuario.php');
    }else{
        $option = '';
        while($data = mysqli_fetch_array($sql)){

            $id_usuario = $data['id_usuario'];
            $nombre = $data['nombre'];
            $apellido = $data['apellido'];
            $email = $data['email'];
            $usuario = $data['usuario'];
            $idrol = $data['idrol'];
            $rol = $data['rol'];

            if($idrol == 1){
                $option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
            }else if($idrol == 2){
                $option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
            }else if($idrol == 3){
                $option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
            }

        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Editar Usuario</title>
</head>

<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		
        <div class="form_register">
            <h2>Editar Usuario</h2>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : '' ; ?></div>

            <form action="" method="post">

                <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?> ">

                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>">

                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" placeholder="Apellido" value="<?php echo $apellido; ?>">

                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" placeholder="E-mail" value="<?php echo $email; ?>">

                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario"  value="<?php echo $usuario; ?>">

                <label for="clave">Contraseña</label>
                <input type="password" name="clave" id="clave" placeholder="Contraseña">

                <label for="rol">Tipo de usuario</label>
                
                <?php 
                    include "../conexion.php";
                    $query_rol = mysqli_query($conn, "SELECT * FROM rol");
                    mysqli_close($conn);
                    $result_rol = mysqli_num_rows($query_rol);                
                ?>

                <select name="rol" id="rol" class="notItemOne">

                    <?php 
                        echo $option;
                        if($result_rol>0){
                            while ($rol =  mysqli_fetch_array($query_rol)){
                    ?>
                            <option value="<?php echo $rol["id_rol"]; ?>" ><?php echo $rol["rol"]; ?> </option>
                    <?php 
                            }
                        }
                    ?>
                                
                </select>
                <input type="submit" value="Actualizar Usuario" class="btn_suave">

            </form>
        </div>
	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>