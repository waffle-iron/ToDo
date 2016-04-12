$(document).ready(function() {
	$('#submit').click(function() {
		var originalLocation;
		originalLocation = window.location.href;
		originalLocation = originalLocation.replace(/\/persona.*/g, "/persona/ax_insert");
		var nombre = $('#nombre').val();
		
		if (!nombre || nombre == 'Nombre') {
			alert('Por favor ingrese su nombre');
			return false;
		}
		
		var form_data = $('#persona_form').serialize();
		
		$.ajax({
			url: originalLocation,
			dataType: 'json',
			type: 'POST',
			data: form_data,
			success: function(msg) {
				if(msg.resultado =='OK')
					$('#main_content').html('Alta Ok!');
				else
					$('#main_content').html('Error al dar de alta!')
			},
			error: function(msg) {
				res = msg;
				$('#main_content').html('Error al dar de alta');
			}
		});
		
		return false;
	});
});