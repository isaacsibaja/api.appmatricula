<?php

require_once "../controladores/matricula.controlador.php";
require_once "../modelos/matricula.modelo.php";
require_once "../modelos/cursos.modelo.php";

class AjaxMatricula{

	/*=============================================
	MATRICULAR CURSO
	=============================================*/	

	public $idCurso;

	public function matricularCurso(){

		$valor = $this->idCurso;

		$respuesta = ControladorMatricula::ctrGuardarMatricula($valor);

	}

	public $idMatricula;

	public function quitarMatricula(){

		$valor = $this->idMatricula;

		$respuesta = ControladorMatricula::ctrBorrarMatricula($valor);

	}
}

if(isset( $_POST["idCurso"])){

	$ajax = new AjaxMatricula();
	$ajax -> idCurso = $_POST["idCurso"];
	$ajax -> matricularCurso();

}

if(isset( $_POST["idMatricula"])){
	$ajax = new AjaxMatricula();
	$ajax -> idMatricula = $_POST["idMatricula"];
	$ajax -> quitarMatricula();

}