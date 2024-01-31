<?php 
	session_start();
	 
	include "../conexion.php";

	if(!empty($_POST)){

		$id_prod = $_POST['id_prod'];
		
		$query_delete = mysqli_query($conn, "DELETE FROM producto WHERE id_prod = $id_prod");
		mysqli_close($conn);

		if($query_delete){
			header("location: listaProducto.php");
		}else{
			echo "Error al eliminar";
		}
	}
	
	if(empty($_REQUEST['id'])){
		header("location: listaProducto.php");
		mysqli_close($conn);
	}else{
		
		$id_prod = $_REQUEST['id'];
		$query = mysqli_query($conn, "SELECT p.nombre, p.lote, p.fecha_vencimiento, p.cantidad 
										FROM producto p 
										WHERE p.id_prod=$id_prod " );
		mysqli_close($conn);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while($data = mysqli_fetch_array($query)){
				$nombre = $data['nombre'];
				$lote = $data['lote'];
				$fecha_vencimiento = $data['fecha_vencimiento']; 
				$cantidad = $data['cantidad'];	
			}
		}else{
			header("location: listaProducto.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Producto</title>
</head>
<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		<div class="data_delete">
			<h2>¿Estas seguro de eliminar el siguiente Usuario?</h2>
			<p>Nombre: <span><?php echo $nombre; ?></span></p>
			<p>Lote: <span><?php echo $lote; ?></span></p>
			<p>fecha de vencimiento: <span><?php echo $fecha_vencimiento; ?></span></p>
			<p>Cantidad: <span><?php echo $cantidad; ?></span></p>

			<form action="" method="post">
				<input type="hidden" name="id_prod" value="<?php echo $id_prod; ?>">
				<a class="btn_cancel" href="listaFamilia.php">Cancelar</a>
				<input class="btn_ok" type="submit" value="Aceptar">
			</form>
		</div>

	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>