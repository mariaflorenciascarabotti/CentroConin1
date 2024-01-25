<?php 
    include "../conexion.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista Usuarios</title>
</head>
<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		
		<h2>Lista de Usuarios</h2>
        <a href="registroUsuario.php" class="btn_new">Crear Usuario</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>E-mail</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            <?php 
                $query = mysqli_query($conn,"SELECT u.id_usuario, u.nombre, u.apellido, u.email, u.usuario, r.rol FROM usuario u INNER JOIN rol r on u.id_rol = r.id_rol");

                $result = mysqli_num_rows($query);

                if($result > 0){
                    while($data = mysqli_fetch_array($query)){
            ?>

                        <tr>
                            <td><?php echo $data["id_usuario"]; ?></td>
                            <td><?php echo $data["nombre"]; ?></td>
                            <td><?php echo $data["apellido"]; ?></td>
                            <td><?php echo $data["email"]; ?></td>
                            <td><?php echo $data["usuario"]; ?></td>
                            <td><?php echo $data["rol"]; ?></td>
                            <td>
                                <a class="link_edit" href="editarUsuario.php?id=<?php echo $data["id_usuario"]; ?>">Editar</a>
                                |
                                <a class="link_delete" href="#">Eliminar</a>
                            </td>
                        </tr>
            <?php 
                    }
                }
            ?>

        </table>
	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>