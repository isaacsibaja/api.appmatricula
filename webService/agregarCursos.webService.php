<?php
	
	require_once "../modelos/cursos.modelo.php";

	if( isset($_POST['datos']) ){
		
		$data = json_decode($_POST['datos']);

	    $datos = array("nombre" => $data->nombre,
           "duracion" => $data->duracion,
           "horario" => $data->horario,
           "horas" => $data->horas,
           "mensualidad"=> $data->mensualidad,
           "descripcion"=> $data->descripcion,
           "nota"=> "100",
           "inicioLecciones"=> $data->inicioLecciones,
           "finLecciones"=>$data->finLecciones,
           "isActive"=> $data->isActive,
           "idSucursal"=> $data->idSucursal,
           "idPersona"=> $data->idPersona);

	   	if(ModeloCurso::mdlIngresarCurso("curso", $datos) == "ok"){
	   		$data = ['response' => 1];
			return json_encode($data);
	   	}else{
	   		$data = ['response' => 2];
			return json_encode($data);
	   	}
	}else {
		$data = ['response' => 3];
		return json_encode($data);
	}
?>

