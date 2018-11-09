<?php

require_once "conexion.php";

class ModeloMatricula{

	static public function mdlMostrarMatricula($tabla, $item, $valor){

		if($item != null){

			$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("SELECT * FROM $tabla WHERE $item = ?");

			$stmt -> bindParam(1, $valor, PDO::PARAM_STR);

			$stmt -> execute();
			$temporal = $stmt -> fetch();
			$array = array("id" => $temporal["id"],
						"fecha" => $temporal["fecha"],
			         	"monto" => $temporal["monto"],
			           	"idCurso" => $temporal["idCurso"],
			           	"idPersona"=> $temporal["idPersona"]);
					

			return $array; 

		}else{

			$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}

	static public function mdlMostrarMatriculaPorPersona($valor){
		$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("SELECT id, idCurso FROM matricula WHERE idPersona = ?");

		$stmt -> bindParam(1, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();
	}


	static public function mdlIngresarMatricula($tabla, $datos){

		$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("INSERT INTO $tabla (fecha, monto, idCurso, idPersona) VALUES (?, ?, ?, ?)");

		$stmt->bindParam(1, $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(2, $datos["monto"], PDO::PARAM_STR);
		$stmt->bindParam(3, $datos["idCurso"], PDO::PARAM_STR);
		$stmt->bindParam(4, $datos["idPersona"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";	

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;

	}


	static public function mdlBorrarMatricula($valor){

		$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("DELETE FROM matricula WHERE id = ?");

		$stmt -> bindParam(1, $valor);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}
}