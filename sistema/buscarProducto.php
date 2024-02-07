<?php 
    session_start();
    
    include "../conexion.php";

    $busqueda = strtolower($_REQUEST['busqueda']);
    if(empty($busqueda)){
        header("location: listaProducto.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista Productos</title>
</head>
<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
	
		<h2>Lista de Productos</h2>
        <a href="registroProducto.php" class="btn_new">Agregar Producto</a>

<!------------ Buscador -->
        <form action="buscarProducto.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
            <button type="submit" class="btn_search">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg> Buscar
            </button>
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
        
        <?php 
            $grupo_alimenticio='';
            if($busqueda == 'Lacteos'){
                $grupo_alimenticio = " OR tipo_alimenticio like '%1%' ";
            }else if ($busqueda == 'Cereales / Legumbre'){
                $grupo_alimenticio = " OR tipo_alimenticio like '%2%' ";
            }else if ($busqueda == 'Frutas / Verdura'){
                $grupo_alimenticio = " OR tipo_alimenticio like '%3%' ";
            }

            $sql_register = mysqli_query($conn, "SELECT COUNT(*) as total_registro FROM producto
                                                WHERE (
                                                    id_prod LIKE '%$busqueda%' OR
                                                nombre LIKE '%$busqueda%' OR
                                                marca LIKE '%$busqueda%' OR
                                                unidad_medida LIKE '%$busqueda%' OR
                                                lote LIKE '%$busqueda%' OR
                                                fecha_vencimiento LIKE '%$busqueda%' OR
                                                cantidad LIKE '%$busqueda%' OR
                                                alerta_vencimiento LIKE '%$busqueda%' OR
                                                precio LIKE '%$busqueda%' OR
                                                observaciones LIKE '%$busqueda%' 
                                                        $grupo_alimenticio)" );
                                                        
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

            $query = mysqli_query($conn,"SELECT p.id_prod, p.nombre, p.marca, p.unidad_medida, p.lote, p.fecha_vencimiento, p.cantidad, p.alerta_vencimiento, p.precio, p.observaciones, a.grupo_alimenticio, a.tipo_alimenticio 
            FROM producto p INNER JOIN alimentos a on p.grupo_alimenticio = a.grupo_alimenticio 
            WHERE ( p.id_prod LIKE '%$busqueda%' OR
                                    p.nombre LIKE '%$busqueda%' OR
                                    p.marca LIKE '%$busqueda%' OR
                                    p.unidad_medida LIKE '%$busqueda%' OR
                                    p.lote LIKE '%$busqueda%' OR
                                    p.fecha_vencimiento LIKE '%$busqueda%' OR
                                    p.cantidad LIKE '%$busqueda%' OR
                                    p.alerta_vencimiento LIKE '%$busqueda%' OR
                                    p.precio LIKE '%$busqueda%' OR
                                    p.observaciones LIKE '%$busqueda%' OR
                                    a.tipo_alimenticio LIKE '%$busqueda%') 
                                    ORDER BY nombre ASC LIMIT $desde, $por_pagina");

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