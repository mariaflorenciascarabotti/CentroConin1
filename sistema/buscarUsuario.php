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

    <?php 
        $busqueda = strtolower($_REQUEST['busqueda']);
        if(empty($busqueda)){
            header("location: listaUsuario.php");
            mysqli_close($conn);
        }
    ?>
		
		<h2>Lista de Usuarios</h2>
        <a href="registroUsuario.php" class="btn_new">Crear Usuario</a>

<!------------ Buscador -->
        <form action="buscarUsuario.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
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
        
        <?php 
            $rol='';
            if($busqueda == 'Adminitrador'){
                $rol = " OR rol like '%1%' ";
            }else if ($busqueda == 'Voluntario'){
                $rol = " OR rol like '%2%' ";
            }else if ($busqueda == 'Invitado'){
                $rol = " OR rol like '%3%' ";
            }

            $sql_register = mysqli_query($conn, "SELECT COUNT(*) as total_registro FROM usuario
                                                WHERE (
                                                        nombre LIKE '%$busqueda%' OR
                                                        apellido LIKE '%$busqueda%' OR
                                                        email LIKE '%$busqueda%' OR
                                                        usuario LIKE '%$busqueda%' 
                                                        $rol)" );
                                                        
 // --------------------- Paginador
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

            $query = mysqli_query($conn,"SELECT u.id_usuario, u.nombre, u.apellido, u.email, u.usuario, r.rol, r.id_rol 
                                            FROM usuario u INNER JOIN rol r on u.id_rol = r.id_rol  
                                            WHERE (
                                                u.nombre LIKE '%$busqueda%' OR
                                                u.apellido LIKE '%$busqueda%' OR
                                                u.email LIKE '%$busqueda%' OR
                                                u.usuario LIKE '%$busqueda%' OR
                                                r.rol LIKE '%$busqueda%' )
                                            ORDER BY apellido ASC LIMIT $desde, $por_pagina");

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
    <?php 
        if($total_registro != 0 ){
    ?>
        <div class="paginador">
            <ul>

            <?php 
                if($pagina != 1){
            ?>
                <li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<</a></li>
                <li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>
            <?php 
                }
                for($i=1; $i <= $total_paginas; $i++){
                    if($i==$pagina){
                        echo '<li class="pageSelected">'.$i.'</li>';
                    }else{
                        echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
                    }
                }
                if($pagina != $total_paginas){
            ?>
                <li><a href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
                <li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>">>|</a></li>
            <?php 
                } 
            ?>
            </ul>
        </div>   

    <?php 
        }
    ?>     

	</section>

	<?php include "includes/footer.php"; ?>

</body>
</html>