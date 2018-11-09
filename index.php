<?php

require_once "controladores/plantilla.controlador.php";

require_once "controladores/usuarios.controlador.php";
require_once "controladores/cursos.controlador.php";
require_once "controladores/sucursal.controlador.php";
require_once "controladores/matricula.controlador.php";

require_once "modelos/usuarios.modelo.php";
require_once "modelos/cursos.modelo.php";
require_once "modelos/sucursal.modelo.php";
require_once "modelos/matricula.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla->ctrPlantilla();
