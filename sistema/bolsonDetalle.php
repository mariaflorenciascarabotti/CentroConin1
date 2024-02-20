<?php 
session_start();
include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Bolson</title>
</head>
<body>

    <?php include "includes/header.php"; ?>



 <!-- Listado de productos -->
    <section id="container">  
    
    <?php $id_bolson = $_GET['id_bolson']; ?>
    
    
        <h5 style="padding-bottom: 1rem; ">Bolson nro: <?php echo  $id_bolson; ?></h5>

        <div class="d-flex justify-content-between  align-items-center pb-3">
            <h2 class="p-0">Productos entregados</h2>
            <div class="noPrint">
                <button type="button" class="btn btn-secondary ">
                    <a href="bolsonHistorial.php" style="color: #fff;" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708z"/>
                        </svg> Volver
                    </a>
                </button>
            </div>
           
        </div>
            
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>U. de medida</th>
                    <th>Lote</th>
                    <th>Fecha de vencimiento</th>
                    <th>Grupo alimenticio</th>
                    <th>Cantidad</th>
                </tr>

                <?php 
                if(isset($_GET['id_bolson'])) {
                    $id_bolson = $_GET['id_bolson'];

                    $query_detalles_productos = mysqli_query($conn, "SELECT ps.id_prod, ps.cantidad_selec, p.nombre, p.marca, p.unidad_medida, p.lote, p.fecha_vencimiento, a.tipo_alimenticio FROM prod_selecionados ps INNER JOIN producto p ON ps.id_prod = p.id_prod INNER JOIN alimentos a ON p.grupo_alimenticio = a.grupo_alimenticio WHERE ps.id_bolson = $id_bolson");
                    $result = mysqli_num_rows($query_detalles_productos);

                    // Mostrar detalles del bolson
                    $query_bolson = mysqli_query($conn, "SELECT * FROM bolson WHERE id_bolson = $id_bolson");
                    $bolson = mysqli_fetch_assoc($query_bolson);
                   // echo "Fecha de entrega: " . $bolson['fecha_entrega'] . "<br>";

                    // Mostrar productos seleccionados
                    if($result > 0){
                        while($data = mysqli_fetch_array($query_detalles_productos)){
                            ?>
                            <tr>
                                <td><?php echo $data["nombre"]; ?></td> 
                                <td><?php echo $data["marca"]; ?></td>
                                <td><?php echo $data["unidad_medida"]; ?></td>
                                <td><?php echo $data["lote"]; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($data["fecha_vencimiento"])); ?></td>
                                <td><?php echo $data["tipo_alimenticio"]; ?></td>
                                <td><?php echo $data["cantidad_selec"]; ?></td>
                            </tr>
                            <?php 
                        }
                    } else {
                        echo "<tr><td colspan='8'>No se encontraron productos seleccionados para este bolson.</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No se proporcionó un ID de bolson.</td></tr>";
                }
                ?>
          
            </table>
            <div class="noPrint">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                    <button class="btn btn-primary " type="button" onclick="window.print()">Imprimir</button>
                </div>
            </div>
    </section>
   
    


    <?php include "includes/footer.php"; ?>

</body>
</html>















