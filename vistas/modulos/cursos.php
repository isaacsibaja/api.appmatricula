<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Administrar cursos

    </h1>

    <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar cursos</li>

    </ol>

  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
          <button class="btn btn-success" data-toggle="modal" data-target="#modal-agregar"><i class="fa fa-fw fa-plus"></i> Agregar un curso</button>
      </div>
    </div>

    <div class="modal fade in" id="modal-agregar">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Formulario del curso</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" method="post">
              
              <div class="form-group">
                <label for="estadoCurso" class="col-sm-2 control-label">Estado</label>
                <div class="col-sm-10">
                  <select class="form-control" name="estadoCurso">
                    <option value="0">Abierto</option>
                    <option value="1">Iniciado</option>
                    <option value="2">Cerrado</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="nombreCurso" class="col-sm-2 control-label">Nombre</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="nombreCurso" placeholder="Nombre del curso">
                </div>
              </div>
             
              <div class="form-group">
                <label for="horarioCurso" class="col-sm-2 control-label">Horario</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="horarioCurso" placeholder="Ejemplo: Lunes y Jueves">
                </div>
              </div>
             
              <div class="form-group">
                <label for="mensualidadCurso" class="col-sm-2 control-label">Monto de mensualidad</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control" name="mensualidadCurso" placeholder="Ejemplo: ₡35000" min="5000" step="5000">
                </div>
              </div>

              <div class="form-group">
                <label for="descripCurso" class="col-sm-2 control-label">Descripci&oacute;n</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="descripCurso" placeholder="Descrip&oacute;n del curso, sobre que trata"></textarea>
                </div>
              </div>
              
              <div class="form-group">
                <label for="duracionDiasCurso" class="col-sm-3 control-label">Duraci&oacute;n en meses</label>
                <div class="col-sm-3">
                  <input type="number" class="form-control" name="duracionDiasCurso" min="1" placeholder="Meses">
                </div>

                <label for="duracionHorasCurso" class="col-sm-3 control-label">Horas totales</label>
                <div class="col-sm-3">
                  <input type="number" class="form-control" name="duracionHorasCurso" min="1" placeholder="Horas" step="1">
                </div>
              </div>

              <div class="form-group">
                <label for="inicioCurso" class="col-sm-3 control-label">Inicio de lecciones</label>
                <div class="col-sm-3">
                  <input type="date" class="form-control" name="inicioCurso">
                </div>

                <label for="finCurso" class="col-sm-3 control-label">Fin de lecciones</label>
                <div class="col-sm-3">
                  <input type="date" class="form-control" name="finCurso">
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
              </div>

              <?php
              if(isset($_POST['nombreCurso']) && isset($_POST["horarioCurso"]) && isset($_POST["mensualidadCurso"]) && isset($_POST["descripCurso"]) && isset($_POST["duracionDiasCurso"]) && isset($_POST["duracionHorasCurso"]) && isset($_POST["inicioCurso"]) && isset($_POST["finCurso"]) && isset($_POST["estadoCurso"])){
                  $curso = new ControladorCurso();
                  $curso->ctrGuardarCurso($_POST['nombreCurso'],$_POST['horarioCurso'],$_POST['mensualidadCurso'],$_POST['descripCurso'],$_POST['duracionDiasCurso'],$_POST['duracionHorasCurso'],$_POST['inicioCurso'],$_POST['finCurso'],$_POST['estadoCurso']);
                }
              ?>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade in" id="modal-editar">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Formulario del curso</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" method="post">
              
              <div class="form-group">
                <label for="editarEstadoCurso" class="col-sm-2 control-label">Estado</label>
                <div class="col-sm-10">
                  <select class="form-control" id="editarEstadoCurso" name="editarEstadoCurso">
                    <option value="0">Abierto</option>
                    <option value="1">Iniciado</option>
                    <option value="2">Cerrado</option>
                  </select>
                </div>
              </div>

              <input type="hidden" id="editarCurso" name="editarCurso">

              <div class="form-group">
                <label for="editarNombreCurso" class="col-sm-2 control-label">Nombre</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="editarNombreCurso" name="editarNombreCurso" placeholder="Nombre del curso">
                </div>
              </div>
             
              <div class="form-group">
                <label for="editarHorarioCurso" class="col-sm-2 control-label">Horario</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="editarHorarioCurso" name="editarHorarioCurso" placeholder="Ejemplo: Lunes y Jueves">
                </div>
              </div>
             
              <div class="form-group">
                <label for="editarMensualidadCurso" class="col-sm-2 control-label">Monto de mensualidad</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control" id="editarMensualidadCurso" name="editarMensualidadCurso" placeholder="Ejemplo: ₡35000" min="5000" step="5000">
                </div>
              </div>

              <div class="form-group">
                <label for="editarDescripCurso" class="col-sm-2 control-label">Descripci&oacute;n</label>
                <div class="col-sm-10">
                  <textarea class="form-control" id="editarDescripCurso" name="editarDescripCurso" placeholder="Descrip&oacute;n del curso, sobre que trata"></textarea>
                </div>
              </div>
              
              <div class="form-group">
                <label for="editarDuracionDiasCurso" class="col-sm-3 control-label">Duraci&oacute;n en meses</label>
                <div class="col-sm-3">
                  <input type="number" class="form-control" id="editarDuracionDiasCurso" name="editarDuracionDiasCurso" min="1" placeholder="Meses">
                </div>

                <label for="editarDuracionHorasCurso" class="col-sm-3 control-label">Horas totales</label>
                <div class="col-sm-3">
                  <input type="number" class="form-control" id="editarDuracionHorasCurso" name="editarDuracionHorasCurso" min="1" placeholder="Horas" step="0.5">
                </div>
              </div>

              <div class="form-group">
                <label for="editarInicioCurso" class="col-sm-3 control-label">Inicio de lecciones</label>
                <div class="col-sm-3">
                  <input type="date" class="form-control" id="editarInicioCurso" name="editarInicioCurso">
                </div>

                <label for="editarFinCurso" class="col-sm-3 control-label">Fin de lecciones</label>
                <div class="col-sm-3">
                  <input type="date" class="form-control" id="editarFinCurso" name="editarFinCurso">
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
              </div>

              <?php
              if(isset($_POST['editarCurso']) && isset($_POST['editarNombreCurso']) && isset($_POST["editarHorarioCurso"]) && isset($_POST["editarMensualidadCurso"]) && isset($_POST["editarDescripCurso"]) && isset($_POST["editarDuracionDiasCurso"]) && isset($_POST["editarDuracionHorasCurso"]) && isset($_POST["editarInicioCurso"]) && isset($_POST["editarFinCurso"]) && isset($_POST["editarEstadoCurso"])){
                  $curso = new ControladorCurso();
                  $curso->ctrEditarCurso($_POST['editarCurso'], $_POST['editarNombreCurso'],$_POST['editarHorarioCurso'],$_POST['editarMensualidadCurso'],$_POST['editarDescripCurso'],$_POST['editarDuracionDiasCurso'],$_POST['editarDuracionHorasCurso'],$_POST['editarInicioCurso'],$_POST['editarFinCurso'],$_POST['editarEstadoCurso']);
                }
              ?>
            </form>
          </div>
        </div>
      </div>
    </div>

    <br>
    <div class="box">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lista de cursos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                <thead>
                  <tr>
                    <th >Nombre</th>
                    <th>Horario</th>
                    <th>Duraci&oacute;n</th>
                    <th>Horas</th>
                    <th>Profesor</th>
                    <th>Estado</th>
                    <th>Modificar</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $item = null;
                    $valor = null;

                    $cursos = ControladorCurso::ctrMostrarCurso($item, $valor);

                    foreach ($cursos as $key => $value){
                      echo '<tr>';
                      if(strlen($value['nombre']) > 45)
                        echo "<td>" . substr($value['nombre'],0,45) . "...</td>";
                      else
                        echo '<td>'.$value['nombre'].'</td>';
                      echo '<td>'.$value['horario'].'</td>';
                      
                      if($value['duracion'] > 1)
                        echo '<td>'.$value['duracion'].' meses</td>';
                      else
                        echo '<td>'.$value['duracion'].' mes</td>';
                      
                      if($value['horas'] > 1)
                        echo '<td>'.$value['horas'].' horas</td>';
                      else
                        echo '<td>'.$value['horas'].' hora</td>'; 

                      $persona = ControladorUsuarios::ctrMostrarUsuarios("id", $value['idPersona']);
                      echo '<td>'.$persona['nombre'].'</td>';

                      if($value['isActive'] == 0)
                        echo '<td><span class="label label-success">Cupo abierto</span></td>';
                      else 
                        if($value['isActive'] == 1)
                          echo '<td><span class="label label-warning">Curso iniciado</span></td>';
                        else 
                          echo '<td><span class="label label-danger">Curso cerrado</span></td>';

                      echo '<td><button class="btn btn-primary btnEditarCurso" idCurso="'.$value['id'].'" data-toggle="modal" data-target="#modal-editar"><i class="fa fa-edit"> Editar</i></button></td></tr>';
                    }
                  ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
