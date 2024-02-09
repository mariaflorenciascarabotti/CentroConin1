<?php 
    session_start();
    if($_SESSION['id_rol'] !=1){
        header("location: ./");
    }

    include "../conexion.php";

    $busqueda = strtolower($_REQUEST['busqueda']);
    if(empty($busqueda)){
        header("location: listaFamilia.php");
        exit;
    }
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista Familia</title>
</head>
<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		
		<h2>Lista de Usuarios</h2>
        <a href="registroFamilia.php" class="btn_new">Agregar Familia</a>

<!------------ Buscador -->
        <form action="buscarFamilia.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>" >
            <button type="submit" class="btn_search">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg> Buscar
            </button>
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
        
        <?php 
            $desnutricion='';
            if($busqueda == 'Leve'){
                $desnutricion = " OR rol like '%1%' ";
            }else if ($busqueda == 'Moderada'){
                $desnutricion = " OR rol like '%2%' ";
            }else if ($busqueda == 'Grave'){
                $desnutricion = " OR rol like '%3%' ";
            }

            // Usar $busqueda en la consulta SQL
            $sql_register = mysqli_query($conn, "SELECT COUNT(*) as total_registro FROM familia
                                                    WHERE (
                                                        id_tutor LIKE '%$busqueda%' OR
                                                        nombre_tutor LIKE '%$busqueda%' OR
                                                        apellido_tutor LIKE '%$busqueda%' OR
                                                        domicilio LIKE '%$busqueda%' OR
                                                        telefono_tutor LIKE '%$busqueda%' OR
                                                        vinculo LIKE '%$busqueda%' OR
                                                        infantes_hasta6 LIKE '%$busqueda%' OR
                                                        infantes_mayores6 LIKE '%$busqueda%' OR
                                                        fecha_ingreso LIKE '%$busqueda%' 
                                                                $desnutricion)" );

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

            $query = mysqli_query($conn,"SELECT f.id_tutor, f.nombre_tutor, f.apellido_tutor, f.domicilio, f.telefono_tutor, f.vinculo,  f.infantes_hasta6 , f.infantes_mayores6, f.fecha_ingreso, d.tipo_desnutricion, d.grado_desnutricion FROM familia f INNER JOIN desnutricion d on f.grado_desnutricion = d.grado_desnutricion   
                                            WHERE (
                                                f.id_tutor LIKE '%$busqueda%' OR
                                                f.nombre_tutor LIKE '%$busqueda%' OR
                                                f.apellido_tutor LIKE '%$busqueda%' OR
                                                f.domicilio LIKE '%$busqueda%' OR
                                                f.telefono_tutor LIKE '%$busqueda%' OR
                                                f.vinculo LIKE '%$busqueda%' OR
                                                f.infantes_hasta6 LIKE '%$busqueda%' OR
                                                f.infantes_mayores6 LIKE '%$busqueda%' OR
                                                f.fecha_ingreso LIKE '%$busqueda%' OR
                                                d.tipo_desnutricion LIKE '%$busqueda%'
                                                )
                                                ORDER BY apellido_tutor ASC
                                             LIMIT $desde, $por_pagina");

            mysqli_close($conn);
            $result = mysqli_num_rows($query);

            if($result > 0){
                while($data = mysqli_fetch_array($query)){
        ?>
                    <tr>
                        <td><?php echo $data["id_tutor"]; ?></td> 
                        <td><?php echo $data["nombre_tutor"]; ?></td>
                        <td><?php echo $data["apellido_tutor"]; ?></td>
                        <td><?php echo $data["domicilio"]; ?></td>
                        <td><?php echo $data["telefono_tutor"]; ?></td>
                        <td><?php echo $data["vinculo"]; ?></td>
                        <td><?php echo $data["infantes_hasta6"]; ?></td>
                        <td><?php echo $data["infantes_mayores6"]; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($data["fecha_ingreso"])); ?></td>
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