<?php

class cursos
{

    const NOMBRE_TABLA = "curso";

    const ID_CURSO        = "id";
    const NOMBRE          = "nombre";
    const DURACION        = "duracion";
    const HORARIO         = "horario";
    const HORAS           = "horas";
    const MENSUALIDAD     = "mensualidad";
    const NOTA            = "nota";
    const DESCRIPCION     = "descripcion";
    const INICIOLECCIONES = "inicioLecciones";
    const FINLECCIONES    = "finLecciones";
    const ISACTIVE        = "isActive";

    const ID_SUCURSAL = "idSucursal";
    const ID_PERSONA  = "idPersona";

    const CODIGO_EXITO            = 1;
    const ESTADO_EXITO            = 1;
    const ESTADO_ERROR            = 2;
    const ESTADO_ERROR_BD         = 3;
    const ESTADO_ERROR_PARAMETROS = 4;
    const ESTADO_NO_ENCONTRADO    = 5;

    public static function get($peticion)
    {
        //$idPersona = usuarios::autorizar();

        if (empty($peticion[0])) {
            return self::obtenerCursos($idPersona);
        } else {
            return self::obtenerCursos($idPersona, $peticion[0]);
        }

    }

    public static function post($peticion)
    {
        //$idPersona = usuarios::autorizar();

        $body  = file_get_contents('php://input');
        $curso = json_decode($body);

        $idCurso = cursos::crear($idPersona, $curso);

        http_response_code(201);
        return [
            "estado"  => self::CODIGO_EXITO,
            "mensaje" => "Curso creado correctamente",
            "id"      => $idCurso,
        ];

    }

    public static function put($peticion)
    {
        //$idPersona = usuarios::autorizar();

        if (!empty($peticion[0])) {
            $body  = file_get_contents('php://input');
            $curso = json_decode($body);

            if (self::actualizar($curso, $peticion[0]) > 0) {
                http_response_code(200);
                return [
                    "estado"  => self::CODIGO_EXITO,
                    "mensaje" => "Registro actualizado correctamente",
                ];
            } else {
                throw new ExcepcionApi(self::ESTADO_NO_ENCONTRADO,
                    "El curso al que intentas acceder no existe", 404);
            }
        } else {
            throw new ExcepcionApi(self::ESTADO_ERROR_PARAMETROS, "Falta id", 422);
        }
    }

    public static function delete($peticion)
    {
        //$idPersona = usuarios::autorizar();

        if (!empty($peticion[0])) {
            if (self::eliminar($peticion[0]) > 0) {
                http_response_code(200);
                return [
                    "estado"  => self::CODIGO_EXITO,
                    "mensaje" => "Registro eliminado correctamente",
                ];
            } else {
                throw new ExcepcionApi(self::ESTADO_NO_ENCONTRADO,
                    "El curso al que intentas acceder no existe", 404);
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
    private function obtenerCursos($idPersona, $idCurso = null)
    {
        try {
            if (!$idCurso) {

                $comando = "SELECT * FROM " . self::NOMBRE_TABLA. " WHERE " . self::ISACTIVE ." = 1"; 

                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idPersona
            } else {
                $comando = "SELECT * FROM " . self::NOMBRE_TABLA .
                " WHERE " . self::ID_CURSO . "= ? and ".self::ISACTIVE ." = 1";

                /*" WHERE " . self::ID_CURSO . "=? AND " .
                self::ID_PERSONA . "=?";*/

                // Preparar sentencia
                $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
                // Ligar idCurso e idPersona
                $sentencia->bindParam(1, $idCurso, PDO::PARAM_INT);
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
    private function crear($idPersona, $curso)
    {
        if ($curso) {
            try {

                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

                // Sentencia INSERT
                $comando = "INSERT INTO " . self::NOMBRE_TABLA . " ( " .
                self::NOMBRE . "," .
                self::DURACION . "," .
                self::HORARIO . "," .
                self::HORAS . "," .
                self::MENSUALIDAD . "," .
                self::NOTA . "," .
                self::DESCRIPCION . "," .
                self::INICIOLECCIONES . "," .
                self::FINLECCIONES . "," .
                self::ISACTIVE . "," .
                self::ID_SUCURSAL . "," .
                self::ID_PERSONA . ")" .
                    " VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
                // Preparar la sentencia
                $sentencia = $pdo->prepare($comando);

                $sentencia->bindParam(1, $nombre);
                $sentencia->bindParam(2, $duracion);
                $sentencia->bindParam(3, $horario);
                $sentencia->bindParam(4, $horas);
                $sentencia->bindParam(5, $mensualidad);
                $sentencia->bindParam(6, $nota);
                $sentencia->bindParam(7, $descripcion);
                $sentencia->bindParam(8, $inicioLecciones);
                $sentencia->bindParam(9, $finLecciones);
                $sentencia->bindParam(10, $isActive);

                $sentencia->bindParam(11, $idSucursal);
                $sentencia->bindParam(12, $idPersona);

                $nombre   = $curso->nombre;
                $duracion = $curso->duracion;
                $horario  = $curso->horario;
                $horas    = $curso->horas;

                $mensualidad     = $curso->mensualidad;
                $nota            = $curso->nota;
                $descripcion     = $curso->descripcion;
                $inicioLecciones = $curso->inicioLecciones;
                $finLecciones    = $curso->finLecciones;
                $isActive        = $curso->isActive;

                $idSucursal = $curso->idSucursal;
                $idPersona  = $curso->idPersona;

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
    private function actualizar($curso, $idCurso){
        try {
            $consulta = "UPDATE " . self::NOMBRE_TABLA . " SET " .
                self::NOMBRE . " = ?," .
                self::DURACION . " = ?," .
                self::HORARIO . " = ?," .
                self::HORAS . " = ?," .
                self::MENSUALIDAD . " = ?," .
                self::NOTA . " = ?," .
                self::DESCRIPCION . " = ?," .
                self::INICIOLECCIONES . " = ?," .
                self::FINLECCIONES . " = ?," .
                self::ISACTIVE . " = ?," .
                self::ID_SUCURSAL . " = ?," .
                self::ID_PERSONA . " = ? WHERE ".
                self::ID_CURSO ." = ?";

            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($consulta);

            $sentencia->bindParam(1, $curso->nombre);
            $sentencia->bindParam(2, $curso->duracion);
            $sentencia->bindParam(3, $curso->horario);
            $sentencia->bindParam(4, $curso->horas);
            $sentencia->bindParam(5, $curso->mensualidad);
            $sentencia->bindParam(6, $curso->nota);
            $sentencia->bindParam(7, $curso->descripcion);
            $sentencia->bindParam(8, $curso->inicioLecciones);
            $sentencia->bindParam(9, $curso->finLecciones);
            $sentencia->bindParam(10, $curso->isActive);
            $sentencia->bindParam(11, $curso->idSucursal);
            $sentencia->bindParam(12, $curso->idPersona);
            $sentencia->bindParam(13, $idCurso);

            $nombre          = $curso->nombre;
            $duracion        = $curso->duracion;
            $horario         = $curso->horario;
            $horas           = $curso->horas;
            $mensualidad     = $curso->mensualidad;
            $nota            = $curso->nota;
            $descripcion     = $curso->descripcion;
            $inicioLecciones = $curso->inicioLecciones;
            $finLecciones    = $curso->finLecciones;
            $isActive        = $curso->isActive;
            $idSucursal      = $curso->idSucursal;
            $idPersona       = $curso->idPersona;

            $sentencia->execute();

            return $sentencia->rowCount();

        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

    /**
     * Elimina un contacto asociado a un usuario
     * @param int $idPersona identificador del usuario
     * @param int $idContacto identificador del contacto
     * @return bool true si la eliminación se pudo realizar, en caso contrario false
     * @throws Exception excepcion por errores en la base de datos
     */
    private function eliminar($idCurso)
    {
        try {
            // Sentencia DELETE
            $comando = "UPDATE " . self::NOMBRE_TABLA . " SET ".
            self::ISACTIVE." = 0 WHERE " . self::ID_CURSO . " = ?";

            // Preparar la sentencia
            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);

            $sentencia->bindParam(1, $idCurso);

            $sentencia->execute();

            return $sentencia->rowCount();

        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }
}
