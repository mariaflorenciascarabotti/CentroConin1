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
			<h2>¿Estas seguro de eliminar el siguiente Tutor?</h2>
			<br><br>
			<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-file-earmark-x" viewBox="0 0 16 16"><path d="M6.854 7.146a.5.5 0 1 0-.708.708L7.293 9l-1.147 1.146a.5.5 0 0 0 .708.708L8 9.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 9l1.147-1.146a.5.5 0 0 0-.708-.708L8 8.293z"/><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
			</svg>
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