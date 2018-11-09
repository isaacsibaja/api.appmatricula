 <header class="main-header">

	<!--=====================================
	LOGOTIPO
	======================================-->
	<a href="inicio" class="logo">

		<!-- logo mini -->
		<span class="logo-mini">

			<img src="vistas/img/plantilla/icono-blanco.png" class="img-responsive" style="padding:10px">

		</span>

		<!-- logo normal -->

		<span class="logo-lg">

			<img src="vistas/img/plantilla/logo-blanco-lineal.png" class="img-responsive" style="padding:10px 0px">

		</span>

	</a>

	<!--=====================================
	BARRA DE NAVEGACIÓN
	======================================-->
	<nav class="navbar navbar-static-top" role="navigation">

		<!-- Botón de navegación -->

	 	<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">

        	<span class="sr-only">Toggle navigation</span>

      	</a>

		<!-- perfil de usuario -->

		<div class="navbar-custom-menu">

			<ul class="nav navbar-nav">

				<li class="dropdown user user-menu">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">


              <?php

if ($_SESSION["foto"] != "") {

    echo '<img src="' . $_SESSION["foto"] . '" class="user-image">';

} else {

    echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';

}

?>

              <span class="hidden-xs">Bienvenido (a) : <?php echo $_SESSION["nombre"]; ?></span>

            </a>

            <ul class="dropdown-menu">


              <li class="user-header">
                <img class="img-circle" alt="User Image" <?php

if ($_SESSION["foto"] != "") {

    echo '<img src="' . $_SESSION["foto"] . '" class="user-image">';

} else {

    echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';

}

?>

                <p>
                  <?php echo $_SESSION["nombre"]; ?>

                  <small><?php echo $_SESSION["perfil"]; ?></small>

                </p>

              </li>

              <!--data-toggle="modal" data-target="#modalEditarUsuario"-->


              <li class="user-body">

                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#" >Mi Perfil</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Botón</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Botón</a>
                  </div>
                </div>

              </li>


              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Botón</a>
                </div>
                <div class="pull-right">
                   <a href="salir" class="btn btn-default btn-flat">Salir</a>
                </div>

						</li>

					</ul>

				</li>

			</ul>

		</div>

	</nav>

 </header>