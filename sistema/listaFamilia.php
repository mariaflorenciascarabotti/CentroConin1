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
	<title>Lista Familias</title>
</head>
<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		<h2>Lista de Familias</h2>
        <a href="registroFamilia.php" class="btn_new">Agregar Familia</a>
        
<!------------ Buscador -->
        <form action="buscarFamilia.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
            <input type="submit" value="Buscar" class="btn_search">
        </form>
        
        <table>
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Domicilio</th>
                <th>Telefono</th>
                <th>Vinculo</th>
                <th>Menores hasta 6 años</th>
                <th>Mayores a 6 años</th>
                <th>Fecha ingreso</th>
                <th>Grado de desnutricion</th>
                <th>Acciones</th>
            </tr>

<!----------------------- Paginador -->
        <?php 
 
            $sql_register = mysqli_query($conn,"SELECT COUNT(*) as total_registro FROM familia" );
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

            $query = mysqli_query($conn,"SELECT f.id_tutor, f.dni_tutor, f.nombre_tutor, f.apellido_tutor, f.domicilio, f.telefono_tutor, f.vinculo,  f.infantes_hasta6 , f.infantes_mayores6, f.fecha_ingreso,  d.grado_desnutricion, d.tipo_desnutricion FROM familia f INNER JOIN desnutricion d on f.grado_desnutricion = d.grado_desnutricion  ORDER BY apellido_tutor ASC LIMIT $desde, $por_pagina");
            mysqli_close($conn);
            $result = mysqli_num_rows($query);

            if($result > 0){
                while($data = mysqli_fetch_array($query)){
        ?>
                    <tr>
                        <!-- <td><?php echo $data["id_tutor"]; ?></td> --> 
                        <td><?php echo $data["dni_tutor"]; ?></td> 
                        <td><?php echo $data["nombre_tutor"]; ?></td>
                        <td><?php echo $data["apellido_tutor"]; ?></td>
                        <td><?php echo $data["domicilio"]; ?></td>
                        <td><?php echo $data["telefono_tutor"]; ?></td>
                        <td><?php echo $data["vinculo"]; ?></td>
                        <td><?php echo $data["infantes_hasta6"]; ?></td>
                        <td><?php echo $data["infantes_mayores6"]; ?></td>
                        <td><?php echo $data["fecha_ingreso"]; ?></td>
                        <td><?php echo $data["tipo_desnutricion"]; ?></td>

                        <td>
                            <a class="link_edit" href="editarFamilia.php?id=<?php echo $data["id_tutor"]; ?>">Editar</a>
                            |
                            <a class="link_delete" href="eliminarFamilia.php?id=<?php echo $data["id_tutor"]; ?>">Eliminar</a>
                 
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