$(document).on("click", ".btn-suscrito-matricula", function(){
	alertaQuitarMatricula($(this).attr("id"));
});

function quitarMatricula(idCurso){
	var datos = new FormData();
	datos.append("idMatricula", idCurso);

	$.ajax({
		url:"ajax/matricula.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "html"
	}).done(function(respuesta){
		console.log(respuesta)
		$("#respuesta").html(respuesta);
	});
}

function alertaQuitarMatricula(idCurso){
	swal({
	  	title: "¿Desea desmatricular el curso?",
	  	type: "warning",
	  	showCancelButton: true,
	  	confirmButtonColor: '#3085d6',
	  	cancelButtonColor: '#d33',
	  	confirmButtonText: "Desmatricular"
	}).then((result) => {
		if (result.value) {	   		
			quitarMatricula(idCurso);	
	  	}
	});
}
