<?php 
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes\scripts.php"; ?>
	<title>Centro Conin</title>
</head>
<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		
		<h2 class="prueba">Bienvenido al sistema</h2>
		<p class="fs-5">Por favor, tomese un momento para leer el 
			<a href="../img/Manual de Usuario 2024 -Conin.pdf" target="_blank" rel="noopener noreferrer">
				"Manual de Usuario"
			</a>y entender su funcionamiento.
		</p>
		
		<div class="manualUsuario">
			<a href="../img/Manual de Usuario 2024 -Conin.pdf" target="_blank" rel="noopener noreferrer">
				<img src="../img/manual_usuario.png" alt="Manual de Usuario" width="150">
			</a>
		</div>
		
	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>