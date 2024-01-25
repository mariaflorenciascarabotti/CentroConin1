<?php 
     session_start();
     if($_SESSION['id_rol'] !=1){
         header("location: ./");
     }
 
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
        
<!------------ Buscador -->
        <form action="buscarUsuario.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
            <input type="submit" value="Buscar" class="btn_search">
        </form>
        
        <table>
            <tr>
                <!-- <th>ID</th> -->
                <th>Nombre</th>
                <th>Apellido</th>
                <th>E-mail</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>

<!----------------------- Paginador -->
        <?php 
 
            $sql_register = mysqli_query($conn,"SELECT COUNT(*) as total_registro FROM usuario" );
            $result_register = mysqli_fetch_array($sql_register);
            $total_registro = $result_register['total_registro'];

            $por_pagina = 8;
            if(empty($_GET['pagina'])){
                $pagina=1;
            }else{
                $pagina = $_GET['pagina'];
            }

            $desde = ($pagina-1) * $por_pagina;
            $total_paginas = ceil($total_registro / $por_pagina);

            $query = mysqli_query($conn,"SELECT u.id_usuario, u.nombre, u.apellido, u.email, u.usuario, r.rol, r.id_rol FROM usuario u INNER JOIN rol r on u.id_rol = r.id_rol  ORDER BY apellido ASC LIMIT $desde, $por_pagina");
            mysqli_close($conn);
            $result = mysqli_num_rows($query);

            if($result > 0){
                while($data = mysqli_fetch_array($query)){
        ?>
                    <tr>
                        <!-- <td><?php echo $data["id_usuario"]; ?></td> --> 
                        <td><?php echo $data["nombre"]; ?></td>
                        <td><?php echo $data["apellido"]; ?></td>
                        <td><?php echo $data["email"]; ?></td>
                        <td><?php echo $data["usuario"]; ?></td>
                        <td><?php echo $data["rol"]; ?></td>
                        <td>
                            <a class="link_edit" href="editarUsuario.php?id=<?php echo $data["id_usuario"]; ?>">Editar</a>

                    <?php if($data['id_rol'] != 1 ){ ?>
                            |
                            <a class="link_delete" href="eliminarUsuario.php?id=<?php echo $data["id_usuario"]; ?>">Eliminar</a>
                    <?php } ?>

                        </td>
                    </tr>
        <?php 
                }
            }
        ?>

        </table>
        <div class="paginador">
            <ul>

            <?php 
                if($pagina != 1){
            ?>
                <li><a href="?pagina=<?php echo 1; ?>">|<</a></li>
                <li><a href="?pagina=<?php echo $pagina-1; ?>"><<</a></li>
            <?php 
                }
                for($i=1; $i <= $total_paginas; $i++){
                    if($i==$pagina){
                        echo '<li class="pageSelected">'.$i.'</li>';
                    }else{
                        echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
                    }
                }
                if($pagina != $total_paginas){
            ?>
                <li><a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>
                <li><a href="?pagina=<?php echo $total_paginas; ?>">>|</a></li>
            <?php 
                } 
            ?>
            </ul>
        </div>        
        
       
        <!-- <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end bg-light">
                <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
            </ul>
        </nav> -->


	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>