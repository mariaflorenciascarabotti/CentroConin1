$(document).ready(function(){
    console.log('El archivo function.js se está ejecutando correctamente.');

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

    function toggleCantidadInput(checkbox) {
        var cantidadInput = $(checkbox).closest('tr').find('input[type="number"]');
        cantidadInput.prop('disabled', !checkbox.checked);
        cantidadInput.prop('required', checkbox.checked);
    }

     // Obtener referencia al botón y al mensaje
     var submitButton = $('#submitButton');
     var disabledMessage = $('#disabledMessage');
 
     // Escuchar eventos de hover sobre el botón
     submitButton.on('mouseenter', function() {
         // Mostrar el mensaje solo si el botón está deshabilitado
         if (submitButton.prop('disabled')) {
             disabledMessage.css('display', 'block');
         }
     });
 
     submitButton.on('mouseleave', function() {
         // Ocultar el mensaje cuando el cursor sale del botón
         disabledMessage.css('display', 'none');
     });
     // Función para validar el formulario antes de enviar
   
});