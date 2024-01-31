<nav>
	<ul>
		<li><a href="#">Inicio</a></li>
	<?php 
		if($_SESSION['id_rol'] == 1){ // con este codigo, lo que hago es que solo vea este campo, el id_rol 1 = administrador
	?>
		<li class="principal">
			<a href="#">Usuarios</a>
			<ul>
				<li><a href="registroUsuario.php">Nuevo Usuario</a></li>
				<li><a href="listaUsuario.php">Lista de Usuarios</a></li>
			</ul>
		</li>
	<?php } ?>
		<li class="principal">
			<a href="#">Familias</a>
			<ul>
				<li><a href="registroFamilia.php">Nueva Familia</a></li>
				<li><a href="listaFamilia.php">Lista de Familias</a></li>
			</ul>
		</li>
		
		<li class="principal">
			<a href="#">Productos</a>
			<ul>
				<li><a href="registroProducto.php">Nuevo Producto</a></li>
				<li><a href="listaProducto.php">Lista de Productos</a></li>
			</ul>
		</li>
		<li class="principal">
			<a href="#">Bolson</a>
			<ul>
				<li><a href="#">Armar Bolson</a></li>
				<li><a href="#">Historial Bolsones Entregados</a></li>
			</ul>
		</li>
	</ul>
</nav>

