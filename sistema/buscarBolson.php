<?php 
    session_start();
    
    include "../conexion.php";

    $busqueda = strtolower($_REQUEST['busqueda']);
    if(empty($busqueda)){
        header("location: bolsonHistorial.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Bolsones entregados</title>
</head>
<body>

	<?php include "includes/header.php"; ?>

	<section id="container">
		<h2>Bolsones entregados</h2>
        <a href="prodSelecionados.php.php" class="btn_new">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
            </svg> Armar Bolson
        </a>
<!------------ Buscador -->
        <form action="buscarBolson.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
            <button type="submit" class="btn_search">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg> Buscar
            </button>
        </form>
        
        <table>
            <tr>
                <th class="col-3">Familia</th>
                <th class="col-3">Bolson entregado</th>
                <th class="col-3">Fecha entragado</th>
                <th class="col-3">Usuario que armo el bolsón</th>
            </tr>
        
        <?php 
 // --------------------- Paginador
            $sql_register = mysqli_query($conn, "SELECT COUNT(*) as total_registro 
            FROM bolson
            WHERE (id_bolson LIKE '%$busqueda%' OR id_tutor LIKE '%$busqueda%' OR id_usuario LIKE '%$busqueda%' OR fecha LIKE '%$busqueda%')" );
                                                        
            $result_register = mysqli_fetch_array($sql_register);
            $total_registro = $result_register['total_registro'];

            $por_pagina = 10;
            if(empty($_GET['pagina'])){
                $pagina=1;
            }else{
                $pagina = $_GET['pagina'];
            }

            $desde = ($pagina-1) * $por_pagina;
            $total_paginas = ceil($total_registro / $por_pagina);
// ------------------- paginador

            $query = mysqli_query($conn, "SELECT b.id_tutor, b.fecha, b.id_usuario, f.nombre_tutor, f.apellido_tutor, f.dni_tutor, b.id_bolson, u.usuario
            FROM bolson b 
            INNER JOIN familia f ON b.id_tutor = f.id_tutor 
            INNER JOIN usuario u ON b.id_usuario = u.id_usuario
            WHERE (f.nombre_tutor LIKE '%$busqueda%' OR
            f.apellido_tutor LIKE '%$busqueda%' OR
            b.id_bolson LIKE '%$busqueda%' OR
            b.fecha LIKE '%$busqueda%' OR
            u.usuario LIKE '%$busqueda%') 
                                    ORDER BY fecha ASC LIMIT $desde, $por_pagina");

            mysqli_close($conn);
            $result = mysqli_num_rows($query);

            if($result > 0){
                while($data = mysqli_fetch_array($query)){
        ?>
                    <tr>
                        <td><?php echo $data["nombre_tutor"] . ' ' . $data["apellido_tutor"]; ?></td>

                        <td><a href="bolsonDetalle.php?id_bolson=<?php echo $data["id_bolson"]; ?>"><?php echo $data["id_bolson"]; ?></a></td>
                        <td><?php echo date('d/m/Y', strtotime($data["fecha"])); ?></td>
                        <td><?php echo $data["usuario"]; ?></td>
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