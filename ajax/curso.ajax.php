<?php

require_once "../controladores/cursos.controlador.php";
require_once "../modelos/cursos.modelo.php";

class AjaxCurso{

	/*=============================================
	EDITAR USUARIO
	=============================================*/	

	public $idCurso;

	public function ajaxEditarCurso(){

		$item = "id";
		$valor = $this->idCurso;

		$respuesta = ControladorCurso::ctrMostrarCurso($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	ACTIVAR CURSO
	=============================================*/	

	public $activarUsuario;
	public $activarId;


	public function ajaxActivarCurso(){

		$tabla = "curso";

		$item1 = "estado";
		$valor1 = $this->activarCurso;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ControladorCurso::ctrEditarCurso($tabla, $item1, $valor1, $item2, $valor2);

	}

	/*=============================================
	VALIDAR NO REPETIR CURSO
	=============================================*/	

	public $validarUsuario;

	public function ajaxValiarCurso(){

		$item = "curso";
		$valor = $this->validarUsuario;

		$respuesta = ControladorCurso::ctrMostrarUsuarios($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR CURSO
=============================================*/
if(isset($_POST["idCurso"])){

	$ajax = new AjaxCurso();
	$ajax -> idCurso = $_POST["idCurso"];
	$ajax -> ajaxEditarCurso();

}

/*=============================================
ACTIVAR CURSO
=============================================*/	

if(isset($_POST["activarCurso"])){

	$ajax = new AjaxCurso();
	$ajax -> activarCurso = $_POST["activarCurso"];
	$ajax -> activarId = $_POST["activarId"];
	$ajax -> ajaxActivarCurso();

}

/*=============================================
VALIDAR NO REPETIR CURSO
=============================================*/

if(isset( $_POST["validarCurso"])){

	$ajax = new AjaxCurso();
	$ajax -> validarCurso = $_POST["validarCurso"];
	$ajax -> ajaxValiarCurso();

}