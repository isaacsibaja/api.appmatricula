<aside class="main-sidebar">

	 <section class="sidebar">

	 	<div class="user-panel">

        <div class="pull-left image">

          <img class="img-circle" <?php

if ($_SESSION["foto"] != "") {

    echo '<img src="' . $_SESSION["foto"] . '" class="user-image">';

} else {

    echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';

}

?>
        </div>

	        <div class="pull-left info">
	          <p><?php echo $_SESSION["nombre"]; ?></p>
	          <a href="#"><i class="fa fa-circle text-success"></i>En línea</a>
	        </div>
      	</div>

		<ul class="sidebar-menu">

			<li class="active">

				<a href="inicio">

					<i class="fa fa-home"></i>
					<span>Inicio</span>

				</a>

			</li>

			<li>

				<a href="usuarios">

					<i class="fa fa-user"></i>
					<span>Usuarios</span>

				</a>

			</li>

			<li>

				<a href="cursos">

					<i class="fa fa-book"></i>
					<span>Cursos</span>

				</a>

			</li>

			<li>

				<a href="sucursal">

					<i class="fa fa-bank"></i>
					<span>Sucursal</span>

				</a>

			</li>

			<li class="treeview">

				<a href="#">

					<i class="fa fa-list-ul"></i>

					<span>Matrícula</span>

					<span class="pull-right-container">

						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">

					<li>

						<a href="matricula">

							<i class="fa fa-circle-o"></i>
							<span>Administrar matrícula</span>

						</a>

					</li>

					<li>

						<a href="pago-matricula">

							<i class="fa fa-circle-o"></i>
							<span>Pago Matrícula</span>

						</a>

					</li>

					<li>

						<a href="reportes">

							<i class="fa fa-circle-o"></i>
							<span>Reporte matrícula</span>

						</a>

					</li>

				</ul>

			</li>

		</ul>

	 </section>

</aside>