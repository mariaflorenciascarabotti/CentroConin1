<?php 
	 session_start();
	 if($_SESSION['id_rol'] !=1){
		 header("location: ./");
	 }
 
	include "../conexion.php";

	if(!empty($_POST)){

		if( $_POST['id_usuario']==1){
			header("location: listaUsuario.php");
			mysqli_close($conn);
			exit;
		}

		$id_usuario = $_POST['id_usuario'];
		$query_check_rol = mysqli_query($conn, "SELECT id_rol FROM usuario WHERE id_usuario = $id_usuario");
		$data_rol = mysqli_fetch_array($query_check_rol);
		$id_rol_usuario = $data_rol['id_rol'];

		if ($id_rol_usuario == 1) {
			header("location: listaUsuario.php");
			exit;
		}
		
		$query_delete = mysqli_query($conn, "DELETE FROM usuario WHERE id_usuario = $id_usuario");
		mysqli_close($conn);

		if($query_delete){
			header("location: listaUsuario.php");
		}else{
			echo "Error al eliminar";
		}
	}
	
	if(empty($_REQUEST['id']) || $_REQUEST['id'] ==1){
		header("location: listaUsuario.php");
		mysqli_close($conn);
	}else{
		
		$id_usuario = $_REQUEST['id'];
		$query = mysqli_query($conn, "SELECT u.nombre, u.usuario, r.rol 
											FROM usuario u 
											INNER JOIN rol r 
											on u.id_rol = r.id_rol 
											WHERE u.id_usuario=$id_usuario" );
		mysqli_close($conn);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while($data = mysqli_fetch_array($query)){
				$nombre = $data['nombre'];
				$usuario = $data['usuario']; 	
				$rol = $data['rol'];
			}
		}else{
			header("location: listaUsuario.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Usuario</title>
</head>
<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		<div class="data_delete">
			<h2>¿Estas seguro de eliminar el siguiente Usuario?</h2>
			<p>Nombre: <span><?php echo $nombre; ?></span></p>
			<p>Usuario: <span><?php echo $usuario; ?></span></p>
			<p>Tipo de Usuario: <span><?php echo $rol; ?></span></p>

			<form action="" method="post">
				<input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
				<a class="btn_cancel" href="listaUsuario.php">Cancelar</a>
				<input class="btn_ok" type="submit" value="Aceptar">
			</form>
		</div>

	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>