$(document).ready(function () {
	function showResumen() {
		var arr = $('#formRegistro').serializeArray();
		var nombre = $('#formRegistro').find('[name="nombre"]').val().trim();

		$('#resumenSaludo').html('Hola <strong>' + nombre + '</strong>, verifica que los datos que ingresaste sean correctos:');

		var html = '<div class="row">';
		arr.forEach(function (field) {
			var name = field.name;
			var value = field.value;
			var fieldElement = $('#formRegistro').find('[name="' + name + '"]');
			var labelText = name;
			if (fieldElement.length && fieldElement.attr('id')) {
				var labelElement = $('#formRegistro').find('label[for="' + fieldElement.attr('id') + '"]');
				if (labelElement.length) labelText = labelElement.text().trim();
			}
			html += '<div class="col-sm-4">' + labelText + '</div>';
			html += '<div class="col-sm-8"><strong>' + (value || '-') + '</strong></div>';
		});
		html += '</div>';
		$('#resumenContenido').html(html);
		$('#resumenRegistro').removeClass('d-none');
		
	}

	function confirmRegistro(boleta) {
		
		$('#registroSuccess').remove();
		
		
		var msg = $(`
			<div id="registroSuccess" class="alert alert-success mt-3">
				<strong>¡Éxito!</strong> Tus datos han sido procesados y registrados correctamente en el sistema.
			</div>

			<div id="bloqueAcuse" class="card border-0 shadow-sm p-4 mt-3 bg-light">
				<h5 class="text-primary fw-bold mb-3"><i class="bi bi-file-earmark-pdf me-2"></i>Descarga tu acuse</h5>
				
				<p class="mb-3">
					Puedes descargar tu acuse de registro en cualquier momento. 
					Si lo necesitas más tarde, simplemente <strong>inicia sesión</strong> en nuestra plataforma 
					utilizando tu correo institucional y tu contraseña.
				</p>

				<a href="docs/php/generar_acuse.php?boleta=${boleta}" 
				class="btn btn-institucional w-100" 
				target="_blank">
				<i class="bi bi-download me-2"></i>Descargar Acuse PDF
				</a>
</div>
		`);
		
		$('#resumenRegistro').before(msg);
	}

	function registro() {
		$('#formRegistro').addClass('d-none');
		showResumen();
	}


	$('#confirmRegistro').click(function () {
		let formData = $('#formRegistro').serialize();

        // 2. Hacemos la petición AJAX hacia guardar.php
        $.ajax({
            url: "docs/php/registro.php",
            type: "POST",
            data: formData,
            success: function(respuesta) {

				if(respuesta == "Registro exitoso") {
					confirmRegistro($('#boleta').val()); 
					$('#formRegistro')[0].reset();
                	$('#resumenRegistro').addClass('d-none');
				}
				else {
					alert(respuesta);
				}
                
            },
            error: function() {
                alert("Hubo un error al conectar con el servidor.");
            }
        });
	});

	$('#editarRegistro').click(function () {
		$('#resumenRegistro').addClass('d-none');
		$('#formRegistro').removeClass('d-none');
	});

	$('#formRegistro').submit(function (evt) {
		evt.preventDefault();
		if(!validarFormularioRegistro()) return; 



		registro();
	});

	const anioActual = new Date().getFullYear();
    
    const anioMax = anioActual - 16;
    
    const anioMin = anioActual - 100;

    const fechaMax = `${anioMax}-12-31`; 
    const fechaMin = `${anioMin}-01-01`;

    const $inputFecha = $("#fechaNacimiento");
    $inputFecha.attr("max", fechaMax);
    $inputFecha.attr("min", fechaMin);


});

