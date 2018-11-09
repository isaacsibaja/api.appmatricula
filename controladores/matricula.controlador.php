<?php

class ControladorMatricula{

	static public function ctrGuardarMatricula($idCurso){

		if($idCurso > 0){
			session_start();
			$hoy = date("Y-m-d");
			$curso = ModeloCurso::mdlMostrarCursos("curso","id",$idCurso);

			$datos = array("idCurso" => $idCurso,
				           "idPersona" => $_SESSION['id'],
				           "fecha" => $hoy,
				           "monto" => $curso["mensualidad"]);


			$respuesta = ModeloMatricula::mdlIngresarMatricula("matricula", $datos);
		
			if($respuesta == "ok"){

				echo '<script>

				swal({

					type: "success",
					title: "¡La matricula se ha guardado correctamente!",
					showConfirmButton: true,
					confirmButtonText: "Cerrar"

				}).then(function(result){

					if(result.value){
					
						window.location = "pago-matricula";

					}

				});
			

				</script>';


			}	


		}else{

			echo '<script>

				swal({

					type: "error",
					title: "¡La matricula no puede ir vacía o llevar caracteres especiales!",
					showConfirmButton: true,
					confirmButtonText: "Cerrar"

				}).then(function(result){

					if(result.value){
					
						window.location = "pago-matricula";

					}

				});
			

			</script>';

		}


	}


	static public function ctrMostrarMatricula($item, $valor){

		$tabla = "matricula";

		$respuesta = ModeloMatricula::mdlMostrarMatricula($tabla, $item, $valor);

		return $respuesta;
	}


	static public function ctrMostrarMatriculaPorPersona($persona){
		$array = array();
		
		$respuesta = ModeloMatricula::mdlMostrarMatriculaPorPersona($persona);

		return $respuesta;
	}

	static public function ctrEditarMatricula($curso,$nombreCurso,$horarioCurso,$mensualidadCurso,$descripCurso,$duracionDiasCurso,$duracionHorasCurso,$inicioCurso,$finCurso,$estadoCurso){
		require_once 'modelos/validacion.modelo.php';

		if(isset($nombreCurso) && isset($horarioCurso) && isset($mensualidadCurso) && isset($descripCurso) && isset($duracionDiasCurso) && isset($duracionHorasCurso) && isset($inicioCurso) && isset($finCurso) && isset($estadoCurso)){

			$expFecha='((?:(?:[1]{1}\\d{1}\\d{1}\\d{1})|(?:[2]{1}\\d{3}))[-:\\/.](?:[0]?[1-9]|[1][012])[-:\\/.](?:(?:[0-2]?\\d{1})|(?:[3][01]{1})))(?![\\d])';
	
			$validar = new validacionPHP();

			if($validar->encontrarCaracteresNoPermitidos($nombreCurso) && $validar->encontrarCaracteresNoPermitidos($descripCurso) && $validar->encontrarCaracteresNoPermitidos($horarioCurso) && ($mensualidadCurso > 0) && ($duracionDiasCurso > 0)  &&  ($duracionHorasCurso > 0) && (preg_match_all ("/".$expFecha."/is", $inicioCurso, $matches)) && (preg_match_all ("/".$expFecha."/is", $finCurso, $matches)) && ($estadoCurso >= 0 && $estadoCurso <= 3)){

				
				$tabla = "curso";

				
				$datos = array("curso" => $curso,
								"nombre" => $validar->reemplazarAcentos($nombreCurso), 
					           	"duracion" => $duracionDiasCurso,
					           	"horario" => $validar->reemplazarAcentos($horarioCurso),
					           	"horas" => $duracionHorasCurso,
					           	"mensualidad"=> $mensualidadCurso,
					           	"nota"=> "100",
					           	"descripcion"=> $validar->reemplazarAcentos($descripCurso),
					           	"inicioLecciones"=> $inicioCurso,
					           	"finLecciones"=> $finCurso,
					           	"isActive"=> $estadoCurso,
					           	"idSucursal"=> 1,
					           	"idPersona"=> 1);

				echo $respuesta = ModeloCurso::mdlEditarCurso($tabla, $datos);

				if($respuesta == "ok"){

					echo '<script>

					swal({

						type: "success",
						title: "¡El curso ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "cursos";

						}

					});
				

					</script>';

				}


			}else{

				echo '<script>

					swal({

						type: "error",
						title: "¡El curso no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "cursos";

						}

					});
				

				</script>';

			}

		}

	}


	static public function ctrBorrarMatricula($idMatricula){

		if(isset($idMatricula)){

			$respuesta = ModeloMatricula::mdlBorrarMatricula($idMatricula);
			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "La matricula ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "matricula";

								}
							})

				</script>';

			}		

		}

	}


}
	


