<?php 
 session_start();
 include "../conexion.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "includes/scripts.php"; ?>
    <title>Bolson</title>
</head>
<body>
    <?php include "includes/header.php"; ?>

    <section id="container">
        
    <div class="title_page">
            <h2>Bolson</h2>
        </div>

        <!-- Datos de la Familia que recibe el bolson -->
        <div class="datos_flia">
            <div class="action_flia">
                <h4>Datos del Beneficiario</h4>
            </div>

            <form name="form_new_flia" id="form_new_flila" class="datos">
                
                <input type="hidden" name="action" value="addFlia">
                <input type="hidden" id="id_tutor" name="id_tutor" value="" required>
                
                <div class="wd30">
                    <label for="dni_tutor">DNI</label>
                    <input type="number" name="dni_tutor" id="dni_tutor">
                </div>
                <div class="wd30">
                    <label for="nombre_tutor">Nombre</label>
                    <input type="text" name="nombre_tutor" id="nombre_tutor" disabled required>
                </div>
                <div class="wd30">
                    <label  for="apellido_tutor">Apellido</label>
                    <input type="text" name="apellido_tutor" id="apellido_tutor" disabled required>
                </div>
                <div class="wd30">
                    <label  for="infantes_hasta6">Infantes hasta 6 años</label>
                    <input type="text" name="infantes_hasta6" id="infantes_hasta6" disabled required>
                </div>
                <div class="wd30">
                    <label for="infantes_mayores6">Infantes mayores a 6 años</label>
                    <input type="text" name="infantes_mayores6" id="infantes_mayores6" disabled required>
                </div>
               
            </form>
        </div>
       
        <!-- Datos del Usuario que arma el bolson -->
        <div class="datos_usuario_armado">
            <h4>Datos del usuario</h4>
            <div class="datos">
                <div class="wd50">
                    
                    <p>Usuario: <?php echo $_SESSION['user'] ?> </p>
                    <p>Fecha de entrega: <?php echo fechaC() ?> </p>
                </div>
                <!-- <div class="wd50">
                    <label for="">Acciones</label>
                    <div id="acciones_usuario">
                        <a href="#" class="btn_ok textcenter" id="btn_anular_bolson">Anular</a>
                        <a href="#" class="btn_ok textcenter" id="btn_ok_bolson">Procesar</a>
                    </div>
                </div> -->
            </div>
        </div>

        <!-- Datos del armado del bolson -->
        <table class="tbl_bolson">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>U. de medida</th>
                    <th>Lote</th>
                    <th>En stock</th>
                    <th>Vencimiento</th>
                    <th>Grupo alimenticio</th>
                    <th>Observaciones</th>
                    <th>Cantidad</th>
                    <th>Acción</th>
                </tr>
                <tr>
                    <th><input type="text" name="txt_cod_prod" id="txt_cod_prod"></th>
                    <th id="txt_nombre">-</th>
                    <th id="txt_marca">-</th>
                    <th id="txt_medida">-</th>
                    <th id="txt_lote">-</th>
                    <th id="txt_stock">-</th>
                    <th id="txt_vencimineto">-</th>
                    <th id="txt_grupo_alimenticio"></th>
                    <th id="txt_observaciones">-</th>
                    <th><input type="text" name="txt_cant" id="txt_cant" value="0" min="1" disabled></th>
                    <th><a href="#" id="add_prod" class="link_add">Agregar</a></th>
                </tr>
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>U. de medida</th>
                    <th colspan="2">Lote</th>
                    <th>Vencimiento</th>
                    <th>Grupo alimenticio</th>
                    <th>Observaciones</th>
                    <th>Cantidad</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody id="detalle_bolson">
                <tr>
                    <th>1</th>
                    <th>Harina</th>
                    <th>marolio</th>
                    <th>1 kg</th>
                    <th colspan="2">5241lp</th>
                    <th>21/02/2024</th>
                    <th>Lacteos</th>
                    <th>Ninguna</th>
                    <th>5</th>
                    <th>
                        <a href="#" class="link_delete" onclick="event.preventDefault(); del_prod_detalle(1);"></a>
                    </th>
                </tr>
                <tr>
                    <th>11</th>
                    <th>Leche</th>
                    <th>sancor</th>
                    <th>1 lt</th>
                    <th colspan="2">8521lp</th>
                    <th>01/10/2024</th>
                    <th>Lacteos</th>
                    <th>Ninguna</th>
                    <th>2</th>
                    <th>
                        <a href="#" class="link_delete" onclick="event.preventDefault(); del_prod_detalle(11);"></a>
                    </th>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9">Total de productos</td>
                    <td class="textright">7</td>
                </tr>
            </tfoot>

        </table>

    </section>

    <?php include "includes/footer.php"; ?>

</body>
</html>