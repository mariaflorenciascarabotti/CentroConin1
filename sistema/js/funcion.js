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

    //Funcion para que se habilite el campo de cantidad solo a los prod seleccionados
    $('input[name="selected_items[]"]').on('click', function() {
        toggleCantidadInput(this);
    });

    function toggleCantidadInput(checkbox) {
        var cantidadInput = $(checkbox).closest('tr').find('input[type="number"]');
        cantidadInput.prop('disabled', !checkbox.checked);
        cantidadInput.prop('required', checkbox.checked);
    }
    
    // muestra mjs del boton de "enviar prod selec" hasta q no ingrese dni tutor
    var submitButton = $('#submitButton');
    var disabledMessage = $('#disabledMessage');
    submitButton.on('mouseenter', function() {
        if (submitButton.prop('disabled')) {
            disabledMessage.css('display', 'block');
        }
    });
    submitButton.on('mouseleave', function() {
        disabledMessage.css('display', 'none');
    });


    // Función para validar el formulario antes de enviar
    $('#submitButton').on('click', function(event) {
        if (!validarFormulario()) {
            event.preventDefault();
        }
    });
    function validarFormulario() {
        var checkboxes = $('input[name="selected_items[]"]');
        var cantidadInputs = $('input[type="number"]');
        var alMenosUnoSeleccionado = false;
    
        // Verificar si al menos un checkbox está marcado
        checkboxes.each(function() {
            if ($(this).is(':checked')) {
                alMenosUnoSeleccionado = true;
                return false; // Salir del bucle each
            }
        });
    
        // Verificar si la cantidad correspondiente está habilitada
        var alMenosUnoConCantidad = false;
        cantidadInputs.each(function() {
            if ($(this).is(':disabled')) {
                return true; // Continuar con el siguiente input
            }
            if ($(this).val() > 0) {
                alMenosUnoConCantidad = true;
                return false; // Salir del bucle each
            }
        });
    
        // Comprobar si se cumplen ambas condiciones
        if (alMenosUnoSeleccionado && alMenosUnoConCantidad) {
            return true;
        } else {
            // Si no se cumplen alguna de las condiciones, mostrar un mensaje de error
            alert('Por favor, seleccione al menos un producto y especifique su cantidad.');
            return false; // Evitar el envío del formulario
        }
    }

    // Confirmar el envio del formulario
    $('#submitButton').on('click', function() {
        if (validarFormulario()) {
            if (confirm('¿Estás seguro de enviar el formulario?')) {
                $('#myForm').submit();
            }else{
                return false;
            }
        }
    });

    // validar formulario Solo texto
    $('#nombre, #apellido, #vinculo').on('input', function(){
        validarCamposTexto();
    });
    
    function validarCamposTexto() {
        var inputs = $('#nombre, #apellido, #vinculo');
        var expresion = /^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]*$/;
    
        inputs.each(function() {
            var valor = $(this).val();
            if (!expresion.test(valor)) {
                alert("Por favor, ingresa solo letras en el campo " + $(this).attr('name'));
                $(this).val("");
            }
        });
    }
      
    //Validar DNI  
    $('#dni_tutor').on('blur', function() {
        var dni = $(this).val().trim();
        if (dni !== "") {
            validarDNI(dni);
        }   
    });
    
    function validarDNI(dni) {
        var dniInput = $('#dni_tutor');
        var valor = dniInput.val();
        var expresion = /^\d{7,8}$/;
    
        if ((valor === '0000000') || (!expresion.test(valor))) {
            alert("Por favor, ingresa un DNI válido");
            dniInput.val("");
        } 
    }

     // validar numeros telefonicos
     $('input[name="telefono"]').on('input', function(){
        validarNumeros();
    });

    function validarNumeros() {
        var inputs = $('input[name="telefono"]');
        var expresion = /^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]*$/;
    
        inputs.each(function() {
            var valor = $(this).val();
            if (expresion.test(valor)) {
                alert("Por favor, ingresa solo números en el campo " + $(this).attr('name'));
                $(this).val("");
            }
        });
    }

     // validar formulario nombre de Producto
     $('#nombre_prod').on('input', function(){
        validarNombreProd();
    });
    
    function validarNombreProd() {
        var inputs = $('#nombre_prod');
        var expresion = /^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]/; // Comienza con una letra
    
        inputs.each(function() {
            var valor = $(this).val();
            if (valor.trim() !== '' && !expresion.test(valor)) {
                alert("El nombre del producto debe empezar con una letra");
                $(this).val(""); // Limpiar el campo si no cumple con la validación
            }
        });
    }
    
    // validar formulario marca de Producto
    $('#marca').on('input', function(){
        validarMarcaProd();
    });
    
    function validarMarcaProd() {
        var inputs = $('#marca');
        var expresion = /^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]/; // Comienza con una letra
    
        inputs.each(function() {
            var valor = $(this).val();
            if (valor.trim() !== '' && !expresion.test(valor)) {
                alert("El nombre del marca debe empezar con una letra");
                $(this).val(""); // Limpiar el campo si no cumple con la validación
            }
        });
    }
    // validar unidad de medida
    $('#unidad_medida').on('blur', function() {
        var texto = $(this).val().trim();
        if (texto !== "") {
            validarUnidadMedida(texto);
        }
    });
    
    function validarUnidadMedida(texto) {
        var contieneNumero = /\d/.test(texto);
        var contieneLetra = /[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]/.test(texto);
        var contieneCaracteresValidos = /^[a-zA-Z0-9\s]*[.,]?[a-zA-Z0-9\s]*$/.test(texto);

        if (!contieneNumero || !contieneLetra || !contieneCaracteresValidos) {
            alert("La unidad de medida debe contener la cantidad y la unidad de medida. Por ejemplo: 1 kg");
            $('#unidad_medida').val("");
        }
    }
    

});