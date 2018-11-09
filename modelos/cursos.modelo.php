<?php

require_once "conexion.php";

class ModeloCurso{

	/*=============================================
	MOSTRAR CURSO
	=============================================*/

	static public function mdlMostrarCursos($tabla, $item, $valor){

		if($item != null){

			$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("SELECT * FROM $tabla WHERE $item = ?");

			$stmt -> bindParam(1, $valor, PDO::PARAM_STR);

			$stmt -> execute();
			$temporal = $stmt -> fetch();
			$array = array("id" => $temporal["id"],
						"nombre" => $temporal["nombre"],
			         	"duracion" => $temporal["duracion"],
			           	"horario" => $temporal["horario"],
			           	"horas" => $temporal["horas"],
			           	"mensualidad"=> $temporal["mensualidad"],
			            "nota"=> $temporal["nota"],
			            "descripcion"=> $temporal["descripcion"],
			            "inicioLecciones"=> $temporal["inicioLecciones"],
			            "finLecciones"=> $temporal["finLecciones"],
			            "isActive"=> $temporal["isActive"],
			            "idSucursal"=> $temporal["idSucursal"],
			            "idPersona"=> $temporal["idPersona"]
				);
					

			return $array; 

		}else{

			$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	REGISTRO DE CURSO
	=============================================*/

	static public function mdlIngresarCurso($tabla, $datos){

		$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("INSERT INTO $tabla (nombre, duracion, horario, horas, mensualidad, nota, descripcion, inicioLecciones, finLecciones, isActive, idSucursal, idPersona) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

		$stmt->bindParam(1, $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(2, $datos["duracion"], PDO::PARAM_STR);
		$stmt->bindParam(3, $datos["horario"], PDO::PARAM_STR);
		$stmt->bindParam(4, $datos["horas"], PDO::PARAM_STR);
		$stmt->bindParam(5, $datos["mensualidad"], PDO::PARAM_STR);
		$stmt->bindParam(6, $datos["nota"], PDO::PARAM_STR);
		$stmt->bindParam(7, $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(8, $datos["inicioLecciones"], PDO::PARAM_STR);
		$stmt->bindParam(9, $datos["finLecciones"], PDO::PARAM_STR);
		$stmt->bindParam(10, $datos["isActive"], PDO::PARAM_STR);
		$stmt->bindParam(11, $datos["idSucursal"], PDO::PARAM_STR);
		$stmt->bindParam(12, $datos["idPersona"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";	

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;

	}

	/*=============================================
	EDITAR CURSO
	=============================================*/

	static public function mdlEditarCurso($datos){
	
		$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("UPDATE curso SET nombre = ?, duracion = ?, horario = ?, horas = ?, mensualidad = ?, nota = ?, descripcion = ?, inicioLecciones = ?, finLecciones = ?, isActive = ? WHERE id = ?");
		//echo print_r($datos);
		$stmt->bindParam(1, $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(2, $datos["duracion"], PDO::PARAM_STR);
		$stmt->bindParam(3, $datos["horario"], PDO::PARAM_STR);
		$stmt->bindParam(4, $datos["horas"], PDO::PARAM_STR);
		$stmt->bindParam(5, $datos["mensualidad"], PDO::PARAM_STR);
		$stmt->bindParam(6, $datos["nota"], PDO::PARAM_STR);
		$stmt->bindParam(7, $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(8, $datos["inicioLecciones"], PDO::PARAM_STR);
		$stmt->bindParam(9, $datos["finLecciones"], PDO::PARAM_STR);
		$stmt->bindParam(10, $datos["isActive"], PDO::PARAM_STR);
		$stmt->bindParam(11, $datos["curso"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		
		}else{
			return "error";	

		}
		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR CURSO
	=============================================*/

	static public function mdlActualizarCurso($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = CConexionBD::obtenerInstancia()->obtenerBD()->prepare("UPDATE $tabla SET $item1 = ? WHERE $item2 = ?");

		$stmt -> bindParam(1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	BORRAR CURSO
	=============================================*/

	static public function mdlBorrarCurso($tabla, $datos){

		$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("DELETE FROM $tabla WHERE id = ?");

		$stmt -> bindParam(1, $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;


	}

}