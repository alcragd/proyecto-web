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
				<strong>Registro confirmado.</strong> Tus datos han sido registrados correctamente.
				<br><br>
				<a href="docs/php/generar_acuse.php?boleta=${boleta}" 
				class="btn btn-institucional" 
				target="_blank">
				<i class="bi bi-file-earmark-pdf"></i> Imprimir Acuse
				</a>
			</div>
		`);
		
		$('#resumenRegistro').before(msg);
	}

	function registro() {
		$('#formRegistro').addClass('d-none');
		showResumen();
	}


	const anioActual = new Date().getFullYear();
    
    const anioMax = anioActual - 17;
    
    const anioMin = anioActual - 100;

    const fechaMax = `${anioMax}-12-31`; // Hasta el último día del año permitido
    const fechaMin = `${anioMin}-01-01`; // Desde el primer día del año permitido

    // Aplicar al input
    const $inputFecha = $("#fechaNacimiento");
    $inputFecha.attr("max", fechaMax);
    $inputFecha.attr("min", fechaMin);
    

});

