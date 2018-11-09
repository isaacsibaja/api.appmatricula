<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Administrar matrícula

    </h1>

    <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar matrícula</li>

    </ol>

  </section>
  <div id="respuesta"></div>
  <!-- Main content -->
  <div class="contenedorCursos container">
    <section class="content">

      <?php
        
        $cursos = ControladorCurso::ctrMostrarCurso(null, null);
        $matriculas = ControladorMatricula::ctrMostrarMatriculaPorPersona($_SESSION['id']);

        foreach ($cursos as $key => $value){
          $temporal = 0;
          for ($i = 0; $i < count($matriculas); $i++) { 
            if(in_array($value['id'], $matriculas[$i])){
             
              echo '<div class="cursoIndividual">';
              echo '<div class="nombreCurso">'.$value["nombre"].'</div>';

              echo '<div class="infoCurso">';
              echo '<div class="info-importante">';
              echo '<div class="contenedorCorto">';
              echo '<label><i class="fa fa-money"></i> Mensualidad: </label><br>';
              echo '<span>'.$value["mensualidad"].'</span></div>';

              echo '<div class="contenedorCorto">';
              echo '<label><i class="fa fa-calendar"></i> Fecha de inicio: </label><br>';
              echo '<span>'.$value["inicioLecciones"].'</span></div>';

              echo '<div class="contenedorCorto">';
              echo '<label><i class="fa fa-calendar"></i> Fecha fin: </label><br>';
              echo '<span>'.$value["finLecciones"].'</span></div>';

              echo '<div class="contenedorCorto">';
              echo '<label><i class="fa fa-hourglass-half"></i> Duraci&oacute;n: </label><br>';
              echo '<span>'.$value["horas"].'</span></div>';

              echo '<div class="contenedorCorto">';
              echo '<label><i class="fa fa-hourglass-half"></i> Tiempo: </label><br>';
              echo '<span>'.$value["duracion"].'</span></div>';

              echo '<div class="contenedorCorto">';
              echo '<label><i class="fa fa-calendar-check-o"></i> Horario: </label><br>';
              echo '<span>'.$value["horario"].'</span></div>';
              echo '</div>';
              echo '<div class="descripcion"><label>Descripci&oacute;n</label>';
              echo $value['descripcion'].'</div>';

              echo '<div class="btnMatricula" float="center">';
              echo '<button id="'.$matriculas[$i][0].'" class="btn btn-danger btn-suscrito-matricula">Ya estas suscrito</button></div> </div> </div>';
            }
          }
        }
      ?>
    </section>
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
