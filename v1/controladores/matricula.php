<?php

require_once "../v1/datos/ConexionBD.php";

class matricula{
	const NOMBRE_TABLA = "matricula";

	const ID_MATRICULA 	  = "id";
    const ID_CURSO        = "idCurso";
    const MONTO 		  = "monto";
    const FECHA 		  = "fecha";
    const ID_PERSONA  = "idPersona";

    const CODIGO_EXITO            = 1;
    const ESTADO_EXITO            = 1;
    const ESTADO_ERROR            = 2;
    const ESTADO_ERROR_BD         = 3;
    const ESTADO_ERROR_PARAMETROS = 4;
    const ESTADO_NO_ENCONTRADO    = 5;

    public static function get($peticion){
        if (empty($peticion[0])) {
            return self::obtenerMatriculas();
        } else {
            return self::obtenerMatriculas($peticion[0]);
        }
    }

    public static function post($peticion){
        $body  = file_get_contents('php://input');
        $matricula = json_decode($body);

        $idMatricula = self::crear($matricula);

        http_response_code(201);
        return [
            "estado"  => self::CODIGO_EXITO,
            "mensaje" => "Matricula creada correctamente",
            "id"      => $idMatricula,
        ];
    }

    public static function put($peticion){
        if (!empty($peticion[0])) {
            $body  = file_get_contents('php://input');
            $matricula = json_decode($body);

            if (self::actualizar($matricula, $peticion[0]) > 0) {
                http_response_code(200);
                return [
                    "estado"  => self::CODIGO_EXITO,
                    "mensaje" => "Registro actualizado correctamente",
                ];
            } else {
                throw new ExcepcionApi(self::ESTADO_NO_ENCONTRADO,
                    "La matricula al que intentas acceder no existe", 404);
            }
        } else {
            throw new ExcepcionApi(self::ESTADO_ERROR_PARAMETROS, "Falta id", 422);
        }
    }

     /**
     * Obtiene la colección de contactos o un solo contacto indicado por el identificador
     * @param int $idPersona identificador del usuario
     * @param null $idContacto identificador del contacto (Opcional)
     * @return array registros de la tabla contacto
     * @throws Exception
     */
    private function obtenerMatriculas($idMatricula = null){
        try {
            if (!$idMatricula) {

                $comando = "SELECT * FROM " . self::NOMBRE_TABLA; 

                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idPersona
            } else {
                $comando = "SELECT * FROM " . self::NOMBRE_TABLA ." WHERE " . self::ID_MATRICULA . "= ?;";

                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idCurso e idPersona
                $sentencia->bindParam(1, $idMatricula, PDO::PARAM_INT);
                //$sentencia->bindParam(2, $idPersona, PDO::PARAM_INT);
            }

            // Ejecutar sentencia preparada
            if ($sentencia->execute()) {
                http_response_code(200);
                return
                    [
                    "estado" => self::ESTADO_EXITO,
                    "datos"  => $sentencia->fetchAll(PDO::FETCH_ASSOC),
                ];
            } else {
                throw new ExcepcionApi(self::ESTADO_ERROR, "Se ha producido un error");
            }

        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

    /**
     * Añade un nuevo contacto asociado a un usuario
     * @param int $idPersona identificador del usuario
     * @param mixed $contacto datos del contacto
     * @return string identificador del contacto
     * @throws ExcepcionApi
     */
    private function crear($matricula){
        if ($matricula->idCurso > 0 && $matricula->idPersona > 0) {
            try {

                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

                $hoy = date("Y-m-d");
                // Sentencia INSERT
                $comando = "INSERT INTO " . self::NOMBRE_TABLA . " ( " .
                self::ID_CURSO . "," .
                self::MONTO . "," .
                self::FECHA . "," .
                self::ID_PERSONA . ")" .
                    " VALUES(?,?,?,?)";
                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);
                $sentencia->bindParam(1, $matricula->idCurso);
                $sentencia->bindParam(2, $matricula->monto);
                $sentencia->bindParam(3, $hoy);
                $sentencia->bindParam(4, $matricula->idPersona);

                $sentencia->execute();

                // Retornar en el último id insertado
                return $pdo->lastInsertId();

            } catch (PDOException $e) {
                throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
            }
        } else {
            throw new ExcepcionApi(
                self::ESTADO_ERROR_PARAMETROS,
                utf8_encode("Error en existencia o sintaxis de parámetros"));
        }

    }

    /**
     * Actualiza el contacto especificado por idPersona
     * @param int $idPersona
     * @param object $contacto objeto con los valores nuevos del contacto
     * @param int $idContacto
     * @return PDOStatement
     * @throws Exception
     */
    private function actualizar($matricula, $idMatricula){
        try {
            $consulta = "UPDATE " . self::NOMBRE_TABLA . " SET " .
                self::ID_CURSO . " = ?," .
                self::MONTO . " = ?," .
                self::FECHA . " = ?," .
                self::ID_PERSONA . " = ? WHERE ".
                self::ID_MATRICULA ." = ?;";

            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($consulta);

            $sentencia->bindParam(1, $matricula->idCurso);
            $sentencia->bindParam(2, $matricula->monto);
            $sentencia->bindParam(3, $matricula->fecha);
            $sentencia->bindParam(4, $matricula->idPersona);
            $sentencia->bindParam(5, $idMatricula);

            $sentencia->execute();

            return $sentencia->rowCount();

        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
}
?>