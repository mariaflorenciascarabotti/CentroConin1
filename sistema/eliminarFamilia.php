<?php 
	 session_start();
	 if($_SESSION['id_rol'] !=1){
		 header("location: ./");
	 }
 
	include "../conexion.php";

	if(!empty($_POST)){

		$id_tutor = $_POST['id_tutor'];
		
		$query_delete = mysqli_query($conn, "DELETE FROM familia WHERE id_tutor = $id_tutor");
		mysqli_close($conn);

		if($query_delete){
			header("location: listaFamilia.php");
		}else{
			echo "Error al eliminar";
		}
	}
	
	if(empty($_REQUEST['id'])){
		header("location: listaFamilia.php");
		mysqli_close($conn);
	}else{
		
		$id_tutor = $_REQUEST['id'];
		$query = mysqli_query($conn, "SELECT f.dni_tutor, f.nombre_tutor, f.apellido_tutor 
										FROM familia f 
										WHERE f.id_tutor=$id_tutor" );
		mysqli_close($conn);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while($data = mysqli_fetch_array($query)){
				$dni_tutor = $data['dni_tutor'];
				$nombre = $data['nombre_tutor'];
				$apellido = $data['apellido_tutor']; 	
			}
		}else{
			header("location: listaFamilia.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Familia</title>
</head>
<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		<div class="data_delete">
			<h2>¿Estas seguro de eliminar el siguiente Usuario?</h2>
			<p>DNI: <span><?php echo $dni_tutor; ?></span></p>
			<p>Nombre: <span><?php echo $nombre; ?></span></p>
			<p>Apellido: <span><?php echo $apellido; ?></span></p>

			<form action="" method="post">
				<input type="hidden" name="id_tutor" value="<?php echo $id_tutor; ?>">
				<a class="btn_cancel" href="listaFamilia.php">Cancelar</a>
				<input class="btn_ok" type="submit" value="Aceptar">
			</form>
		</div>

	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>