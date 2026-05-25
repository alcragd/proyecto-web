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

	function confirm() {
		$('#registroSuccess').remove();
		var msg = $('<div id="registroSuccess" class="alert alert-success mt-3"><strong>Registro confirmado.</strong> Tus datos han sido registrados.</div>');
		$('#resumenRegistro').before(msg);
		
	}

	function registro() {
		$('#formRegistro').addClass('d-none');
		showResumen();
	}


	$('#confirmRegistro').click(function () {
		confirm();
		$('#formRegistro')[0].reset();
		$('#resumenRegistro').addClass('d-none');
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

});

