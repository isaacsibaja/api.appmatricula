<?php
	
	require_once "../modelos/usuarios.modelo.php";

	if( isset($_POST['datos']) ){
		
		$data = json_decode($_POST['datos']);

		if(count(ModeloUsuarios::mdlMostrarUsuarios("usuarios","usuario",$data->usuario)) == 1){
			$aleatorio = mt_rand(100,999);
			$imagenString = base64_decode($data->foto);

			$ruta = "vistas/img/usuarios/".$data->usuario."/".$aleatorio.".jpg";
			$origen = imagecreatefromstring($imagenString);		
			
			if (!file_exists("../vistas/img/usuarios/".$data->usuario)) {
			    mkdir("../vistas/img/usuarios/".$data->usuario, 0777, true);
			}

		   	imagepng($origen, "../".$ruta);	 
		    imagedestroy($origen);

		    $encriptar = crypt($data->password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

		   	$hoy = date("Y m d h:i:s");
		    $datos = array("nombre" => $data->nombre,
		           	"usuario" => $data->usuario,
		           	"password" => $encriptar,
		           	"perfil" => "Estudiante",
		           	"foto" => $ruta,
		           	"isActive" => 1,
		           	"telefono" => $data->telefono,
		           	"correo" => $data->correo,
		           	"direccion" => $data->direccion);
		    ModeloUsuarios::mdlIngresarUsuarioApp("usuarios", $datos);		
		}else{
			$data = ['response' => 4];
			return json_encode($data);
		}
	}else {
		$data = ['response' => 3];
		return json_encode($data);
	}
?>