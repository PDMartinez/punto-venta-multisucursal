
    <main class="app-content">
      <div class="app-title">
        <div>

          <h5><button class="btn btn-primary" id="btnNuevo" type="button"  data-toggle="modal" data-target="#ModalPerfil"><i class="fas fa-plus-circle"></i> Agregar Nuevo</button> Crear perfiles para usuario</h5>
         <!--  <p>En este módulo, puedes crear, modificar,eliminar perfiles</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        </ul>
      </div>
    

      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered tablaPerfiles">

                  <thead>
                    <tr>
                      <th style="width:10px">#</th>
                      <th style="width:100px">Acciones</th>
                      <th>Perfil</th>
                      <th>Descripción</th>
                      <th>Tipo</th>
                      <th>Estado</th>
                      <th>Perfil</th>
                    </tr>
                  </thead>
                  <tbody>
                 

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

    </main>


    <!-- MODAL AGREGAR -->

<!-- Modal -->
<div class="modal fade" id="ModalPerfil" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background:#464775; color:white">
        <h6 class="modal-title" id="titulo">Nuevo perfil</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

                     <!-- FORMULARIOS -->
              <form  onsubmit="return Guardarformulario() " method="post" id="formPerfil">
                  <input class="form-control" type="hidden" name="idPerfil" >
                  <input class="form-control" type="hidden" name="TokenPerfil" >
                <div class="form-group">
                  <label class="control-label">Nombre</label>
                  <input class="form-control" type="text" name="nuevoPerfil" onkeyup="mayusculas(this);" placeholder="Ingresar perfil">
                </div>

                <div class="form-group">
                  <label class="control-label">Descripcion</label>
                  <textarea class="form-control" rows="2" onkeyup="mayusculas(this);" name="nuevoDescripcion" id="nuevoDescripcion"  placeholder="Ingresar una descripcion" ></textarea>
                </div>

               <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="cmbEstado">Seleccione el estado</label>
                        <select class="form-control" name="cmbEstado" id="cmbEstado" required>
                          <option value="1">Activo</option>
                          <option value="0">Inactivo</option>
                         
                        </select>
                    </div>

                  </div>
                <div class="form-group col-md-6">
                    <label class="control-label">Marque la opción</label>
                  <div class="form-group">
                   <div class="animated-checkbox">

                      <label>
                        <input type="checkbox" value=0 id="nuevoActivo" name="nuevoActivo" onclick="Activarcheck()"><span class="label-text">Super Administrador</span>
                      </label>
                    </div>
                  <!-- <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" value=0 id="nuevoActivo" name="nuevoActivo" onclick="Activarcheck()">Super Administrador
                    </label>
                  </div> -->
                </div>
              </div>
            </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
                  </div>

              </form>
                   
          </div>


    </div>

  </div>

</div>


 <!-- MODAL EDITAR -->

<!-- Modal -->
<!-- <div class="modal fade" id="ModalEditarPerfil" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background:#464775; color:white">
        <h6 class="modal-title">Editar perfil</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> -->

                     <!-- FORMULARIOS -->
             <!--  <form  onsubmit="return Actualizarformulario() " method="post" id="formPerfil">
                <div class="form-group">
                  <label class="control-label">Nombre</label>
                  <input class="form-control" type="text" name="editarPerfil" id="editarPerfil" placeholder="Ingresar perfil">
                </div>-->
                <!-- codigo -->
       <!--          <input class="form-control" type="hidden" name="idPerfil" id="idPerfil">

                <div class="form-group">
                  <label class="control-label">Descripcion</label>
                  <textarea class="form-control" rows="2" name="editarDescripcion" id="editarDescripcion" placeholder="Ingresar una descripcion"></textarea>
                </div>
              
                <div class="form-group">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" id="editarActivo" name="editarActivo" onclick="Activarcheck()">Super Administrador
                    </label>
                  </div>
                </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                  </div>

              </form>
                   
          </div>


    </div>

  </div>

</div> -->

<script src="vistas/js/perfiles.js"></script>