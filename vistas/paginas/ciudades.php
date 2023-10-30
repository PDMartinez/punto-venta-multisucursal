
    <main class="app-content">
      <div class="app-title">
        <div>

          <h5><button class="btn btn-primary" id="btnNuevo" type="button"  data-toggle="modal" data-target="#ModalCiudad"><i class="fas fa-plus-circle"></i> Agregar Nuevo</button> Cargar ciudades</h5>
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
                <table class="table table-hover table-bordered tablaCiudad">

                  <thead>
                    <tr>
                      <th style="width:10px">#</th>
                      <th style="width:100px">Acciones</th>
                      <th>Ciudad</th>
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
<div class="modal fade" id="ModalCiudad" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background:#464775; color:white">
        <h6 class="modal-title" id="titulo">Nueva ciudad</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

                     <!-- FORMULARIOS -->
              <form  onsubmit="return Guardarformulario() " method="post" id="formCiudad">
                  <input class="form-control" type="hidden" name="idCiudad" >
                  <input class="form-control" type="hidden" name="TokenCiudad" >
                <div class="form-group">
                  <label class="control-label">Ciudad</label>
                  <input class="form-control" type="text" onkeyup="mayusculas(this);" name="txtCiudad" placeholder="Ingresar ciudad">
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


<script src="vistas/js/ciudades.js"></script>