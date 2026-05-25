$(document).ready(function () {
	function showResumen() {
		var arr = $('#formRegistro').serializeArray();
		var nombre = $('#formRegistro').find('[name="nombre"]').val();

		$('#resumenSaludo').html('Hola <strong>' + nombre + '</strong>, verifica que los datos que ingresaste sean correctos:');

		var html = '<dl class="row">';
		arr.forEach(function (field) {
			var name = field.name;
			var value = field.value;
			var fieldElement = $('#formRegistro').find('[name="' + name + '"]');
			var labelText = name;
			if (fieldElement.length && fieldElement.attr('id')) {
				var labelElement = $('#formRegistro').find('label[for="' + fieldElement.attr('id') + '"]');
				if (labelElement.length) labelText = labelElement.text().trim();
			}
			html += '<dt class="col-sm-4">' + labelText + '</dt>';
			html += '<dd class="col-sm-8"><strong>' + (value || '-') + '</strong></dd>';
		});
		html += '</dl>';
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
		$('#confirmRegistro').off('click').on('click', function () {
			confirm();
			$('#formRegistro')[0].reset();
			$('#resumenRegistro').addClass('d-none');
		});

		$('#editarRegistro').off('click').on('click', function () {
			$('#resumenRegistro').addClass('d-none');
			$('#formRegistro').removeClass('d-none');
		});
	}

	$('#btnRegistrar').click(function () {
		registro();
	});

});

