<?php 

    if(empty($_SESSION["active"]))
    {
        header("location: ../");
    } 
?>

<header>
		<div class="header">
			<h1 class="m-0">CENTRO <span>CONIN</span></h1>
			
			<div class="optionsBar">
				<p class="m-0">Cañada de Gómez,  <?php echo fechaC() ?></p>
				<span> | </span>
				<div class="user">
					<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
					</svg> 
					<p class="m-0">
						<?php echo  $_SESSION["user"] ?>
					</p>
				</div>
				
				<a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>

		<?php include "nav.php"; ?>

</header>