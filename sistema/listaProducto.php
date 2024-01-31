<?php 
    session_start();
    include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de Productos</title>
</head>
<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		<h2>Lista de Productos</h2>
        <a href="registroProducto.php" class="btn_new">Agregar Producto</a>
        
<!------------ Buscador -->
        <form action="buscarProducto.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
            <input type="submit" value="Buscar" class="btn_search">
        </form>
        
        <table>
            <tr>
                <th>Nombre</th>
                <th>Marca</th>
                <th>U. de medida</th>
                <th>Lote</th>
                <th>Fecha de vencimiento</th>
                <th>Cantidad</th>
                <th>Alerta por vencimiento</th>
                <th>Precio</th>
                <th>Grupo alimenticio</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>

<!----------------------- Paginador -->
        <?php 
 
            $sql_register = mysqli_query($conn,"SELECT COUNT(*) as total_registro FROM producto" );
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

            $query = mysqli_query($conn,"SELECT p.id_prod, p.nombre, p.marca, p.unidad_medida, p.lote, p.fecha_vencimiento, p.cantidad, p.alerta_vencimiento, p.precio, p.observaciones, a.grupo_alimenticio, a.tipo_alimenticio FROM producto p INNER JOIN alimentos a on p.grupo_alimenticio = a.grupo_alimenticio  ORDER BY nombre ASC LIMIT $desde, $por_pagina");
            mysqli_close($conn);
            $result = mysqli_num_rows($query);

            if($result > 0){
                while($data = mysqli_fetch_array($query)){
        ?>
                    <tr>
                        <!-- <td><?php echo $data["id_prod"]; ?></td> --> 
                        <td><?php echo $data["nombre"]; ?></td> 
                        <td><?php echo $data["marca"]; ?></td>
                        <td><?php echo $data["unidad_medida"]; ?></td>
                        <td><?php echo $data["lote"]; ?></td>
                        <td><?php echo $data["fecha_vencimiento"]; ?></td>
                        <td><?php echo $data["cantidad"]; ?></td>
                        <td><?php echo $data["alerta_vencimiento"]; ?></td>
                        <td><?php echo $data["precio"]; ?></td>
                        <td><?php echo $data["tipo_alimenticio"]; ?></td>
                        <td><?php echo $data["observaciones"]; ?></td>
                       

                        <td>
                            <a class="link_edit" href="editarProducto.php?id=<?php echo $data["id_prod"]; ?>">Editar</a>
                            |
                            <a class="link_delete" href="eliminarProducto.php?id=<?php echo $data["id_prod"]; ?>">Eliminar</a>
                 
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