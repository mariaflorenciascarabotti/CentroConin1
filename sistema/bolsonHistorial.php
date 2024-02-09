<?php 
    session_start();
    include "../conexion.php";
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
        <a href="prodSelecionados.php" class="btn_new">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
            </svg> Armar Bolson
        </a>
        
<!------------ Buscador -->
        <form action="buscarBolson.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
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

<!----------------------- Paginador -->
        <?php 
 
            $sql_register = mysqli_query($conn,"SELECT COUNT(*) as total_registro FROM bolson" );

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
            ORDER BY `fecha` ASC LIMIT $desde, $por_pagina");

            mysqli_close($conn);

            $result = mysqli_num_rows($query);

            if($result > 0){
                while($data = mysqli_fetch_array($query)){
        ?>
                    <tr>
                        <td><?php echo $data["nombre_tutor"] . ' ' . $data["apellido_tutor"]; ?></td>

                        <td><?php echo $data["id_bolson"]; ?> 
                            <a href="bolsonDetalle.php?id_bolson=<?php echo $data["id_bolson"]; ?>" style="padding-left: 1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                </svg> Ver
                            </a>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($data["fecha"])); ?></td>
                        <td><?php echo $data["usuario"]; ?></td>
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