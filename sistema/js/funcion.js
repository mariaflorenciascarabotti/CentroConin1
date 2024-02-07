$(document).ready(function(){

    //Buscar tutor
    $('#dni_tutor').keyup(function(e){ 

        e.preventDefault();

        var tutor = $('#dni_tutor').val();

        var action = 'searchTutor';

        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async :  true,
            data: {action:action, tutor:tutor},

            success: function(response)
            {
                console.log(response);

                if(response == 0){
                    $('#id_tutor').val('');
                    $('#nombre_tutor').val('');
                    $('#apellido_tutor').val('');
                    $('#infantes_hasta6').val('');
                    $('#infantes_mayores').val('');
                }else{
                    var data = $.parseJSON(response);
                    $('#id_tutor').val(data.id_tutor);
                    $('#nombre_tutor').val(data.nombre_tutor);
                    $('#apellido_tutor').val(data.apellido_tutor);
                    $('#infantes_hasta6').val(data.infantes_hasta6);
                    $('#infantes_mayores6').val(data.infantes_mayores6);

                    // bloqueo campos
                    $('#apellido_tutor').attr('disabled, disabled');
                    $('#infantes_hasta6').attr('disabled, disabled');
                    $('#infantes_mayores').attr('disabled, disabled');
                }
            },
            error: function(error){
    
            }
        });

    });

    //buscar producto
    $('#txt_cod_prod').keyup(function(e){
        e.preventDefault();

        var producto = $('#txt_cod_prod').val();
        var action = 'infoProducto';

        if(producto != '')
        {
            $.ajax({
                url: 'ajax.php',
                type: "POST",
                async :  true,
                data: {action:action, producto:producto},
    
                success: function(response)
                {
                    if(response != 'error'){

                        var info = JSON.parse(response);
                        $('#txt_nombre').html(info.nombre);
                        $('#txt_marca').html(info.marca);
                        $('#txt_medida').html(info.unidad_medida);
                        $('#txt_lote').html(info.lote);
                        $('#txt_stock').html(info.cantidad);
                        $('#txt_vencimineto').html(info.fecha_vencimiento);
                        $('#txt_grupo_alimenticio').html(info.grupo_alimenticio);
                        $('#txt_observaciones').html(info.observaciones);

                        $('#txt_cant').removeAttr('disabled');

                        $('#add_prod').slideDown();
                    }else{
                        $('#txt_nombre').html('-');
                        $('#txt_marca').html('-');
                        $('#txt_medida').html('-');
                        $('#txt_lote').html('-');
                        $('#txt_stock').html('-');
                        $('#txt_vencimineto').html('-');
                        $('#txt_grupo_alimenticio').html('-');
                        $('#txt_observaciones').html('-');
                        $('#txt_cant').val(0);

                        $('#txt_cant').attr('disabled', 'disabled');

                        $('#add_prod').slideUp();
                    }
                    
                },
                error: function(error){
    
                }
            });
        }
       
    });

    //Funcion que evita que se agreguen + prod de los que hay en stock
    $('#txt_cant').keyup(function(e){
        e.preventDefault();

        var cantidad = parseInt ($('#txt_stock').html());
        
        if( ($(this).val()> cantidad))
        {
            $('#add_prod').slideUp();
        }else{
            $('#add_prod').slideDown();
        }
    });

    //Agregar producto
    $('#add_prod').click(function(e){
        e.preventDefault();

        if($('#txt_cant').val() > 0){
            var codProd = $('#txt_cod_prod').val();
            var cantidad = $('#txt_cant').val();
            var action = 'addProdDetalle';

            $.ajax({
                url: 'ajax.php',
                type: "POST",
                async :  true,
                data: {action:action, producto:codProd, cantidad:cantidad},
    
                success: function(response){
                    console.log(response);
                },
                error: function(error){
                }
            });
        }
    });

     // Obtener el elemento del campo de cantidad
     var cantidadInput = document.getElementById("cant");

     // Establecer el límite máximo inicial según el valor de cantidad en PHP
     cantidadInput.max = <?php echo $data["cantidad"]; ?>;
 
     // Agregar un evento de cambio para validar la entrada del usuario
     cantidadInput.addEventListener("input", function() {
         var cantidadMaxima = <?php echo $data["cantidad"]; ?>;
         var nuevaCantidad = parseInt(cantidadInput.value);
 
         // Validar si la nueva cantidad supera la cantidad máxima permitida
         if (nuevaCantidad > cantidadMaxima) {
             cantidadInput.value = ""; // Limpiar el campo de cantidad
         }
     });


    // cierra la funcion de linea 1

});