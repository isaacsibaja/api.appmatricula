<?php

class ControladorCurso{

	/*=============================================
	REGISTRO DE CURSO
	=============================================*/

	static public function ctrGuardarCurso($nombreCurso,$horarioCurso,$mensualidadCurso,$descripCurso,$duracionDiasCurso,$duracionHorasCurso,$inicioCurso,$finCurso,$estadoCurso){
		require_once './modelos/validacion.modelo.php';

		if(isset($nombreCurso) && isset($horarioCurso) && isset($mensualidadCurso) && isset($descripCurso) && isset($duracionDiasCurso) && isset($duracionHorasCurso) && isset($inicioCurso) && isset($finCurso) && isset($estadoCurso)){
			
			$expFecha='((?:(?:[1]{1}\\d{1}\\d{1}\\d{1})|(?:[2]{1}\\d{3}))[-:\\/.](?:[0]?[1-9]|[1][012])[-:\\/.](?:(?:[0-2]?\\d{1})|(?:[3][01]{1})))(?![\\d])';

	
			$validar = new validacionPHP();

			if($validar->encontrarCaracteresNoPermitidos($nombreCurso) && $validar->encontrarCaracteresNoPermitidos($descripCurso) && $validar->encontrarCaracteresNoPermitidos($horarioCurso) && ($mensualidadCurso > 0) && ($duracionDiasCurso > 0)  &&  ($duracionHorasCurso > 0) && (preg_match_all ("/".$expFecha."/is", $inicioCurso, $matches)) && (preg_match_all ("/".$expFecha."/is", $finCurso, $matches)) && ($estadoCurso >= 0 && $estadoCurso <= 3)){

				$fecha1 = date($inicioCurso);
				$fecha2 = date($finCurso);

				if($fecha1 <= $fecha2){
					$datos = array("nombre" => $validar->reemplazarAcentos($nombreCurso),
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
						           "idPersona"=> $_SESSION["id"]);

					$tabla = "curso";

					$respuesta = ModeloCurso::mdlIngresarCurso($tabla, $datos);
				
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
							title: "¡La fecha no de cierre no puede ser mayor a la de inicio!",
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

	/*=============================================
	MOSTRAR CURSO
	=============================================*/

	static public function ctrMostrarCurso($item, $valor){

		$tabla = "curso";

		$respuesta = ModeloCurso::mdlMostrarCursos($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
	EDITAR CURSO
	=============================================*/

	static public function ctrEditarCurso($curso,$nombreCurso,$horarioCurso,$mensualidadCurso,$descripCurso,$duracionDiasCurso,$duracionHorasCurso,$inicioCurso,$finCurso,$estadoCurso){
		require_once 'modelos/validacion.modelo.php';

		if(isset($nombreCurso) && isset($horarioCurso) && isset($mensualidadCurso) && isset($descripCurso) && isset($duracionDiasCurso) && isset($duracionHorasCurso) && isset($inicioCurso) && isset($finCurso) && isset($estadoCurso)){

			$expFecha='((?:(?:[1]{1}\\d{1}\\d{1}\\d{1})|(?:[2]{1}\\d{3}))[-:\\/.](?:[0]?[1-9]|[1][012])[-:\\/.](?:(?:[0-2]?\\d{1})|(?:[3][01]{1})))(?![\\d])';
	
			$validar = new validacionPHP();

			if($validar->encontrarCaracteresNoPermitidos($nombreCurso) && $validar->encontrarCaracteresNoPermitidos($descripCurso) && $validar->encontrarCaracteresNoPermitidos($horarioCurso) && ($mensualidadCurso > 0) && ($duracionDiasCurso > 0)  &&  ($duracionHorasCurso > 0) && (preg_match_all ("/".$expFecha."/is", $inicioCurso, $matches)) && (preg_match_all ("/".$expFecha."/is", $finCurso, $matches)) && ($estadoCurso >= 0 && $estadoCurso <= 3)){

				$fecha1 = date($inicioCurso);
				$fecha2 = date($finCurso);

				if($fecha1 <= $fecha2){
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

					$respuesta = ModeloCurso::mdlEditarCurso($datos);


					if($respuesta == "ok"){

						echo '<script>

						swal({

							type: "success",
							title: "¡El curso ha sido actualizado correctamente!",
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
							title: "¡La fecha no de cierre no puede ser mayor a la de inicio!",
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

	/*=============================================
	BORRAR CURSO
	=============================================*/

	static public function ctrBorrarCurso(){

		if(isset($_GET["idCurso"])){

			$tabla ="curso";
			$datos = $_GET["idCurso"];

			$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El usuario ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "usuarios";

								}
							})

				</script>';

			}		

		}

	}


}
	


