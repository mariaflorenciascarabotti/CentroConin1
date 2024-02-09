<?php

$alert="";
session_start();
if(!empty($_SESSION["active"])){
    header("location: sistema/");
}else{

    if(!empty($_POST)){
        if(empty($_POST["usuario"]) || empty($_POST["clave"])){
            $alert="Ingrese su usuario y contraseña ";
        }else{
            require_once "conexion.php";

            $user = mysqli_real_escape_string($conn, $_POST["usuario"]);
            $pass = md5(mysqli_real_escape_string($conn, $_POST["clave"]));


            $query = mysqli_query($conn, "SELECT * FROM `usuario` WHERE usuario='$user' AND clave = '$pass'");
            mysqli_close($conn);
            $result = mysqli_num_rows(($query));

            if($result > 0 ){
                $data = mysqli_fetch_array($query);
                
                $_SESSION["active"] = true;
                $_SESSION["idUser"] = $data["id_usuario"];
                $_SESSION["nombre"] = $data["nombre"];
                $_SESSION["email"] = $data["email"];
                $_SESSION["user"] = $data["usuario"];
                $_SESSION["id_rol"] = $data["id_rol"];

                header("location: sistema/");
            }else{
                $alert="El usuario o la contraseña no son correctas";
                session_destroy();
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_login.css">
    <title>Inicio de Sesión | Centro Conin</title>
</head>
<body>
    
        <section id="container">

            <form action="" method="post">

                <h3>Iniciar Sesión</h3>
                <input type="text" name="usuario" placeholder="Usuario">
                <input type="password" name="clave" placeholder="Contraseña">
                <div class="alert"> 
                    <?php echo isset($alert) ? $alert : ''; ?> 
                </div>
                <input class="btn-ingresar" type="submit" value="ingresar">

            </form>
        </section>
    

</body>
</html>