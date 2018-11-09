$(document).on("click", ".btn-matricula", function(){

	var idCurso = $(this).attr("id");

	var datos = new FormData();
	datos.append("idCurso", idCurso);

	$.ajax({
		url:"ajax/matricula.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "html"
	}).done(function(respuesta){
		
		$("#respuesta").html(respuesta);
	});

});
linkAdminMatricula = "<a href='http://localhost/appmatricula/matricula'>Administrar matricula</a>";
$(document).on("click", ".btn-suscrito", function(){
	$("#respuesta").html('<script>swal({type: "error",title:"¡Ya estas suscrito a este curso! Si quires desmatricular el curso ve a '+linkAdminMatricula+'",showConfirmButton: true,confirmButtonText: "Cerrar"}).then(function(result){if(result.value){window.location = "pago-matricula";}});</script>');
});