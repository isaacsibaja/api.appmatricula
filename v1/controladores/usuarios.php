<?php

require_once "../v1/datos/ConexionBD.php";

class usuarios
{
    /*
    perfil
    foto
    isActive
    telefono
    correo
    direccion
     */
    // Datos de la tabla "usuario"
    const NOMBRE_TABLA = "usuarios";
    const ID_USUARIO   = "id";
    const NOMBRE       = "nombre";
    const CONTRASENA   = "password";
    const CLAVE_API    = "claveApi";

    const PERFIL    = "perfil";
    const FOTO      = "foto";
    const ISACTIVE  = "isActive";
    const TELEFONO  = "telefono";
    const EMAIL     = "correo";
    const DIRECCION = "direccion";

    const USUARIO = "usuario";

    const ESTADO_CREACION_EXITOSA       = 1;
    const ESTADO_CREACION_FALLIDA       = 2;
    const ESTADO_ERROR_BD               = 3;
    const ESTADO_AUSENCIA_CLAVE_API     = 4;
    const ESTADO_CLAVE_NO_AUTORIZADA    = 5;
    const ESTADO_URL_INCORRECTA         = 6;
    const ESTADO_FALLA_DESCONOCIDA      = 7;
    const ESTADO_PARAMETROS_INCORRECTOS = 8;

    public static function post($peticion)
    {
        if ($peticion[0] == 'registro') {
            return self::registrar();
        } else if ($peticion[0] == 'login') {
            return self::loguear();
        } else {
            throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, "Url mal formada", 400);
        }
    }

    /**
     * Crea un nuevo usuario en la base de datos
     */
    private function registrar()
    {
        $cuerpo  = file_get_contents('php://input');
        $usuario = json_decode($cuerpo);

        $resultado = self::crear($usuario);

        switch ($resultado) {
            case self::ESTADO_CREACION_EXITOSA:
                http_response_code(200);
                return
                    [
                    "estado"  => self::ESTADO_CREACION_EXITOSA,
                    "mensaje" => utf8_encode("�Registro con �xito!"),
                ];
                break;
            case self::ESTADO_CREACION_FALLIDA:
                throw new ExcepcionApi(self::ESTADO_CREACION_FALLIDA, "Ha ocurrido un error");
                break;
            default:
                throw new ExcepcionApi(self::ESTADO_FALLA_DESCONOCIDA, "Falla desconocida", 400);
        }
    }

    /**
     * Crea un nuevo usuario en la tabla "usuario"
     * @param mixed $datosUsuario columnas del registro
     * @return int codigo para determinar si la inserci�n fue exitosa
     */
    private function crear($datosUsuario)
    {
        $nombre = $datosUsuario->nombre;

        $contrasena           = $datosUsuario->password;
        $contrasenaEncriptada = self::encriptarContrasena($contrasena);

        $usuario = $datosUsuario->usuario;

        $perfil = self::perfilUsuario();
        $foto      = self::crearFoto($usuario,$datosUsuario->foto);
        $isActive  = self::activarUsuario();
        $telefono  = $datosUsuario->telefono;
        $email     = $datosUsuario->correo;
        $direccion = $datosUsuario->direccion;
        $claveApi  = self::generarClaveApi();

        if(count(self::obtenerUsuario($usuario)) == 1){
            try {

                $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

                // Sentencia INSERT
                $comando = "INSERT INTO " . self::NOMBRE_TABLA . " ( " .
                self::NOMBRE . "," .
                self::CONTRASENA . "," .
                self::CLAVE_API . "," .
                self::PERFIL . "," .
                self::FOTO . "," .
                self::ISACTIVE . "," .
                self::TELEFONO . "," .
                self::EMAIL . "," .
                self::DIRECCION . "," .
                self::USUARIO . ")" .
                    " VALUES(?,?,?,?,?,?,?,?,?,?)";

                $sentencia = $pdo->prepare($comando);

                $sentencia->bindParam(1, $nombre);
                $sentencia->bindParam(2, $contrasenaEncriptada);
                $sentencia->bindParam(3, $claveApi);

                $sentencia->bindParam(4, $perfil);
                $sentencia->bindParam(5, $foto);
                $sentencia->bindParam(6, $isActive);
                $sentencia->bindParam(7, $telefono);
                $sentencia->bindParam(8, $email);
                $sentencia->bindParam(9, $direccion);

                $sentencia->bindParam(10, $usuario);

                $resultado = $sentencia->execute();

                if ($resultado) {
                    return self::ESTADO_CREACION_EXITOSA;
                } else {

                    return self::ESTADO_CREACION_FALLIDA;
                }
            } catch (PDOException $e) {
                throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
            }
        }
    }

    /**
     * Protege la contrase�a con un algoritmo de encriptado crypt de Longitud 60
     * @param $contrasenaPlana (contrasena sin hash insertada por el usuario)
     * @return bool|null|string
     */
    private function encriptarContrasena($contrasenaPlana)
    {
        if ($contrasenaPlana) {
            return crypt($contrasenaPlana, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
        } else {
            return null;
        }

    }

    private function crearFoto($usuario, $fotoBase64){
        $aleatorio = mt_rand(100,999);
        $imagenString = base64_decode($fotoBase64);

        $ruta = "vistas/img/usuarios/".$usuario."/".$aleatorio.".jpg";
        $origen = imagecreatefromstring($imagenString);     
        
        if (!file_exists("../vistas/img/usuarios/".$usuario)) {
            mkdir("../vistas/img/usuarios/".$usuario, 0777, true);
        }

        imagepng($origen, "../".$ruta);  
        imagedestroy($origen);

        return $ruta;
    }

    private function generarClaveApi()
    {
        return md5(microtime() . rand());
    }

    private function activarUsuario()
    {
        return 1;
    }

    private function perfilUsuario()
    {
        return "Estudiante";
    }

    private function loguear()
    {
        $respuesta = array();

        $body = file_get_contents('php://input');
        $user = json_decode($body);

        $usuario  = $user->usuario;
        $password = $user->password;

        if (self::autenticar($usuario, $password)) {
            $usuarioBD = self::obtenerUsuario($usuario);

            if ($usuarioBD != null) {
                http_response_code(200);
                $respuesta["nombre"]   = $usuarioBD["nombre"];
                $respuesta["usuario"]  = $usuarioBD["usuario"];
                $respuesta["claveApi"] = $usuarioBD["claveApi"];
                return ["estado" => 1, "usuario" => $respuesta];
            } else {
                throw new ExcepcionApi(self::ESTADO_FALLA_DESCONOCIDA,
                    "Ha ocurrido un error");
            }
        } else {
            throw new ExcepcionApi(self::ESTADO_PARAMETROS_INCORRECTOS,
                utf8_encode("Correo o contrase�a inv�lidos"));
        }
    }

    private function autenticar($usuario, $password)
    {
        $comando = "SELECT password FROM " . self::NOMBRE_TABLA .
        " WHERE " . self::USUARIO . "=?";

        try {

            $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);

            $sentencia->bindParam(1, $usuario);

            $sentencia->execute();

            if ($sentencia) {
                $resultado = $sentencia->fetch();

                if (self::validarContrasena($password, $resultado['password'])) {
                    return true;
                } else {
                    return false;
                }

            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new ExcepcionApi(self::ESTADO_ERROR_BD, $e->getMessage());
        }
    }

    private function validarContrasena($contrasenaPlana, $contrasenaHash)
    {
        return password_verify($contrasenaPlana, $contrasenaHash);
    }

    private function obtenerUsuario($usuario)
    {
        $comando = "SELECT " .
        self::NOMBRE . "," .
        self::CONTRASENA . "," .
        self::USUARIO . "," .
        self::CLAVE_API .
        " FROM " . self::NOMBRE_TABLA .
        " WHERE " . self::USUARIO . "=?";

        $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);

        $sentencia->bindParam(1, $usuario);

        if ($sentencia->execute()) {
            return $sentencia->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        }

    }

    /**
     * Otorga los permisos a un usuario para que acceda a los recursos
     * @return null o el id del usuario autorizado
     * @throws Exception
     */
    public static function autorizar()
    {
        $cabeceras = apache_request_headers();

        if (isset($cabeceras["Authorization"])) {

            $claveApi = $cabeceras["Authorization"];

            if (usuarios::validarClaveApi($claveApi)) {
                return usuarios::obtenerIdUsuario($claveApi);
            } else {
                throw new ExcepcionApi(
                    self::ESTADO_CLAVE_NO_AUTORIZADA, "Clave de API no autorizada", 401);
            }

        } else {
            throw new ExcepcionApi(
                self::ESTADO_AUSENCIA_CLAVE_API,
                utf8_encode("Se requiere Clave del API para autenticaci�n"));
        }
    }

    /**
     * Comprueba la existencia de la clave para la api
     * @param $claveApi
     * @return bool true si existe o false en caso contrario
     */
    private function validarClaveApi($claveApi)
    {
        $comando = "SELECT COUNT(" . self::ID_USUARIO . ")" .
        " FROM " . self::NOMBRE_TABLA .
        " WHERE " . self::CLAVE_API . "=?";

        $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);

        $sentencia->bindParam(1, $claveApi);

        $sentencia->execute();

        return $sentencia->fetchColumn(0) > 0;
    }

    /**
     * Obtiene el valor de la columna "idUsuario" basado en la clave de api
     * @param $claveApi
     * @return null si este no fue encontrado
     */
    private function obtenerIdUsuario($claveApi)
    {
        $comando = "SELECT " . self::ID_USUARIO .
        " FROM " . self::NOMBRE_TABLA .
        " WHERE " . self::CLAVE_API . "=?";

        $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);

        $sentencia->bindParam(1, $claveApi);

        if ($sentencia->execute()) {
            $resultado = $sentencia->fetch();
            return $resultado['id'];
        } else {
            return null;
        }

    }
}
