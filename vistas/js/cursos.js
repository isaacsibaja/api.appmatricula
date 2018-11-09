$(document).on("click", ".btnEditarCurso", function(){

	var idCurso = $(this).attr("idCurso");

	var datos = new FormData();
	datos.append("idCurso", idCurso);

	$.ajax({
		url:"ajax/curso.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json"
	}).done(function(respuesta){
		$("#editarEstadoCurso").val(respuesta["isActive"]);
		$("#editarNombreCurso").val(quitarAcutes(respuesta["nombre"]));
		$("#editarHorarioCurso").val(quitarAcutes(respuesta["horario"]));
		$("#editarMensualidadCurso").val(respuesta["mensualidad"]);
		$("#editarDescripCurso").val(quitarAcutes(respuesta["descripcion"]));
		$("#editarCurso").val(respuesta["id"]);
		$("#editarDuracionDiasCurso").val(respuesta["duracion"]);
		$("#editarDuracionHorasCurso").val(respuesta["horas"]);
		$("#editarInicioCurso").val(respuesta["inicioLecciones"]);
		$("#editarFinCurso").val(respuesta["finLecciones"]);

	});

});

function quitarAcutes(texto) {
    texto = texto.replace("&Aacute;","Á");
    texto = texto.replace("&aacute;","á");
    texto = texto.replace("&Eacute;","É");
    texto = texto.replace("&eacute;","é");
    texto = texto.replace("&iacute;","í");
    texto = texto.replace("&Iacute;","Í");
    texto = texto.replace("&oacute;","ó");
    texto = texto.replace("&Oacute;","Ó");
    texto = texto.replace("&uacute;","ú");
    texto = texto.replace("&Uacute;","Ú");
    texto = texto.replace("&ntilde;","ñ");
    texto = texto.replace("&Ntilde;","Ñ");
    texto = texto.replace("&uuml;","ü");
    texto = texto.replace("&Uuml;","Ü");
            
 	return texto;
}