$(document).ready(function() {

	$("#correoOK").hide();
	$("#userOk").hide();
	$("#correoError").hide();
	$("#userError").hide();

	$("#email").change(function(){
		const campo = $("#email"); 
		campo[0].setCustomValidity(""); 

		const esCorreoValido = campo[0].checkValidity();
		if (esCorreoValido && correoValidoUCM(campo.val())) {
		
			$("#correoOK").show();
			$("#correoError").hide();

			campo[0].setCustomValidity("");
		} else {			
			
			$("#correoError").show();
			$("#correoOK").hide();

			campo[0].setCustomValidity(
				"El correo debe ser válido y acabar por @ucm.es");
		}
	});

	
	$("#nombreUsuario").change(function(){
		var url = "comprobarUsuario.php?user=" + $("#nombreUsuario").val();
		$.get(url,usuarioExiste);
  });


	function correoValidoUCM(correo) {
		
		var dominio = correo.split('@')[1];
		return dominio === 'ucm.es';
	}

	function usuarioExiste(data,status) {
		
		
		if (data == 'existe') {
			$("#userOk").hide();
			$("#userError").show();
			$("#nombreUsuario").focus();
			//alert("El usuario ya existe, escoge otro");
		} else if(data=='disponible') {
			$("#userError").hide();
			$("#userOk").show();
		}
	}
})