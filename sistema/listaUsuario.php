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
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Lista de Usuarios</h2>
                <a href="registroUsuario.php" class="btn_new">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16"><path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/><path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
                    </svg> Crear Usuario
                </a>
            </div>
<!------------ Buscador -->
        <form action="buscarUsuario.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
            <button type="submit" class="btn_search">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg> Buscar
            </button>
        </form>
        </div>
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
                            <a class="link_edit" href="editarUsuario.php?id=<?php echo $data["id_usuario"]; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg> Editar
                            </a>

                    <?php if($data['id_rol'] != 1 ){ ?>
                            |
                            <a class="link_delete" href="eliminarUsuario.php?id=<?php echo $data["id_usuario"]; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16"><path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                </svg> Eliminar
                            </a>
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

	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>