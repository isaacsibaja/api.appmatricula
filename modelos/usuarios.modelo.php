<?php

require_once "conexion.php";

class ModeloUsuarios{

	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	static public function mdlMostrarUsuarios($tabla, $item, $valor){

		if($item != null){

			$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("SELECT * FROM $tabla WHERE $item = ?");

			$stmt -> bindParam(1, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		

	}

	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function mdlIngresarUsuario($tabla, $datos){

		$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("INSERT INTO $tabla(nombre, usuario, password, perfil, foto) VALUES (?, ?, ?, ?, ?)");

		$stmt->bindParam(1, $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(2, $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(3, $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(4, $datos["perfil"], PDO::PARAM_STR);
		$stmt->bindParam(5, $datos["foto"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";	

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;

	}
	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function mdlIngresarUsuarioApp($tabla,$datos){
	    
		$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("INSERT INTO $tabla (nombre, usuario, password, perfil, foto, isActive, telefono, correo, direccion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
		$stmt->bindParam(1, $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(2, $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(3, $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(4, $datos["perfil"], PDO::PARAM_STR);
		$stmt->bindParam(5, $datos["foto"], PDO::PARAM_STR);
		$stmt->bindParam(6, $datos["isActive"], PDO::PARAM_STR);
		$stmt->bindParam(7, $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(8, $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(9, $datos["direccion"], PDO::PARAM_STR);
		
		if($stmt->execute()){
			$data = ['response' => 1];
			echo "111111";
			return json_encode($data);

		}else{
			$data = ['response' => 2];
			return json_encode($data);
		
		}
        
		$stmt->close();
		
		$stmt = null;

	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function mdlEditarUsuario($tabla, $datos){
	
		$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("UPDATE $tabla SET nombre = ?, password = ?, perfil = ?, foto = ? WHERE usuario = ?");

		$stmt -> bindParam(1, $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(2, $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(3, $datos["perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(4, $datos["foto"], PDO::PARAM_STR);
		$stmt -> bindParam(5, $datos["usuario"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/

	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = ConexionBD::obtenerInstancia()->obtenerBD()->prepare("UPDATE $tabla SET $item1 = ? WHERE $item2 = ?");

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
	BORRAR USUARIO
	=============================================*/

	static public function mdlBorrarUsuario($tabla, $datos){

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