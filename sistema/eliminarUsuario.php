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
			<br><br>
			<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-file-earmark-x" viewBox="0 0 16 16"><path d="M6.854 7.146a.5.5 0 1 0-.708.708L7.293 9l-1.147 1.146a.5.5 0 0 0 .708.708L8 9.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 9l1.147-1.146a.5.5 0 0 0-.708-.708L8 8.293z"/><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
			</svg>
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