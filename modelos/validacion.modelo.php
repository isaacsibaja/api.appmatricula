<?php
	class validacionPHP{
		function encontrarCaracteresNoPermitidos($texto){
			$expresion='([Á|É|Í|Ó|Ú|Ñ|Ü|á|é|í|ó|ú|ñ|ü]|[a-z]|-|,|.|´)';
			$bandera = 1;
			for($i = 0; $i < strlen($texto); $i++){
				if($texto{$i} != " "){
					if(!preg_match_all ("/".$expresion."/is", $texto{$i}, $matches)){
						$bandera = 0;
						break;
					}
				}
			}
			if($bandera == 0)
				echo "---------------------------".$texto;
			return $bandera;
		}

		function reemplazarAcentos($texto){
			$texto = str_replace('ñ','&ntilde;',$texto);
			$texto = str_replace('Ñ','&Ntilde;',$texto);
			$texto = str_replace('á','&aacute;',$texto);
			$texto = str_replace('é','&eacute;',$texto);
			$texto = str_replace('í','&iacute;',$texto);
			$texto = str_replace('ó','&oacute;',$texto);
			$texto = str_replace('ú','&uacute;',$texto);
			$texto = str_replace('Á','&Aacute;',$texto);
			$texto = str_replace('É','&Eacute;',$texto);
			$texto = str_replace('Í','&Iacute;',$texto);
			$texto = str_replace('Ó','&Oacute;',$texto);
			$texto = str_replace('Ú','&Uacute;',$texto);
			$texto = str_replace('ü','&uuml;',$texto);
			$texto = str_replace('Ü','&Uuml;',$texto);

			return $texto;
		}

		function reemplazarAcutes($texto){
			$texto = str_replace('&ntilde;','n',$texto);
			$texto = str_replace('&Ntilde;','n',$texto);
			$texto = str_replace('&aacute;','a',$texto);
			$texto = str_replace('&eacute;','e',$texto);
			$texto = str_replace('&iacute;','i',$texto);
			$texto = str_replace('&oacute;','o',$texto);
			$texto = str_replace('&uacute;','u',$texto);
			$texto = str_replace('&Aacute;','a',$texto);
			$texto = str_replace('&Eacute;','e',$texto);
			$texto = str_replace('&Iacute;','i',$texto);
			$texto = str_replace('&Oacute;','o',$texto);
			$texto = str_replace('&Uacute;','u',$texto);
			$texto = str_replace('&uuml;','u',$texto);
			$texto = str_replace('&Uuml;','u',$texto);

			return $texto;
		}

		
	}
?>