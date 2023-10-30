     <?php 

  if($_SESSION["superperfil"]==0){
      echo '<script type="text/javascript">
        window.location = "inicio";
        </script>';
        }
   ?>
    <main class="app-content">
      <div class="app-title">
        

        <div class="contador">
          <?php 

                    
          $Usuarios = ControladorUsuarios::ctrMostrarUsuario(null, null,null);
          $Usuario=count($Usuarios);
         
          $maxihabilitado=0;
          
          $cantidades =ControladorSucursales:: ctrMostrarCantidadSucursal(null, null);
     
          foreach ($cantidades as $key => $value){
            $maxihabilitado=$value["CANT_USUARIOS"];
          
            }
                
             
        //   if($Usuario<$maxihabilitado){

        //      echo' <h5><button class="btn btn-primary btnNuevo" CantSucursal="'; echo $maxihabilitado; echo'" type="button"  data-toggle="modal" data-target="#ModalUsuario"><i class="fas fa-plus-circle"></i> Agregar Nuevo</button> Crear usuarios</h5>';
        //   }else{
        //       echo '<div class="box-header with-border" >
        //          <label style="color:red"> 
        //          Supero la cantidad de usuario concedido, puede actualizar su plan llamando a este número 0982-203.704 Ing. Marcos Contrera  0972-905.218 Ing. Danilo Martinez<br>
        //            ESTA PERMITIDO: '; echo $maxihabilitado; echo' Usuarios
        //           </label>

        //         </div>';

        // }
        ?>
        <h5><button class="btn btn-primary btnNuevo" CantUsuario="<?php  echo $Usuario; ?>" type="button"  data-toggle="modal" data-target="#ModalUsuario"><i class="fas fa-plus-circle"></i> Agregar Nuevo</button> Crear usuarios</h5>

           <div class="alert alert-dismissible alert-danger texto" >

         <p>Supero la cantidad de productos concedido, puedes actualizar su plan llamando a estos números 0982-203.704 o 0972-905.218 CompumarkApp.com<br>
         ESTA PERMITIDO: <?php  echo $maxihabilitado; ?> Usuarios</p>

        </div>

        <input type="hidden" id="cantidad" value="<?php echo $maxihabilitado; ?>">
         <!--  <p>En este módulo, puedes crear, modificar,eliminar Sucursales</p> -->
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
             <!--  <div class="row">
                <div class="col-auto mr-auto"></div>
                <div class="col-auto">
                 <button class="btn btn-primary" id="btnActivo" activo=1>Ver datos Inactivo</i></button>
                </div>
              </div>
            
               <div class="mr-md-auto">

              </div> -->

              <div class="table-responsive">
                
                <table class="table table-sm table-hover table-bordered tablaUsuarios">

                  <thead>
                    <tr>
                        <th style="width:10px">#</th>
                        <th style="width:100px">Acciones</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Perfil</th>
                        <th>Hora Desde</th>
                        <th>Hora Hasta</th>
                        <th>Sucursal</th>
                        <th>Último login</th>
                        <th>Estado</th>
                        <th>Foto</th>
                        <th>P</th>
                       
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
<div class="modal fade" id="ModalUsuario" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background:#464775; color:white">
        <h6 class="modal-title" id="titulo">Nuevo usuario</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

                     <!-- FORMULARIOS -->
              <!-- <form  onsubmit="return Guardarformulario()" method="post" name="formUsuario" id="formUsuario -->
             <form  method="post" name="formUsuario" id="formUsuario">
                  <input class="form-control" type="hidden" name="idUsuario"  id="idUsuario">
                  <input class="form-control" type="hidden" name="TokenUsuario" id= "TokenUsuario">

                  <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                    <!-- PRIMERA FILA -->
                  <div class="form-group col-md-6">
                    <div class="form-group">
                        <label class="control-label">Funcionario</label>
                        <label class="control-label" style="color:red">*</label>
                       <!--  <label class="control-label" name="editarFuncionario"></label> -->
                       
                       <select class="form-control select2" nane="cmbFuncionario" id="cmbFuncionario" style="width: 100%;" required="">
                          <option selected="selected">Seleccione una opción</option>
                          <?php 

                            $item="EST_FUNCIONARIO";
                            $valor=1;
                            $funcionario = ControladorFuncionarios::ctrMostrarFuncionario($item,$valor,null);
                       
                           foreach ($funcionario as $key => $value) {
                              echo '<option value="'.$value["COD_FUNCIONARIO"].'/'.$value["TOKEN_FUNCIONARIO"].'" >'.$value["NOMBRE_FUNC"].'</option>';

                          }

                   ?>
                       </select>
                     </div>
                    </div>


                    <!-- SEGUNDA FILA -->
                    <div class="form-group col-md-6">

                      <div class="form-group">
                        <label class="control-label">Usuario <span style="color:red">*</span></label>
                        <input class="form-control" type="text" name="txtUsuario" placeholder="Ingresar la Usuario" required>
                     </div>
                    </div>

                  </div>

                <!-- =========================================== -->


                  <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row" >

                    <!-- PRIMERA FILA -->
                    <div class="form-group col-md-6" id="divclave">
                        <!-- ENTRADA PARA LA CONTRASEÑA -->
                        <label class="control-label" id="lblclave">Contraseña <span style="color:red">*</span></label>
                        <div class="input-group">
                            <input class="form-control" type="password" id="txtPassword" name="txtPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Mínimo 8 caracteres que incluyen una letra mayúscula y minúscula, un número" placeholder="Ingresar la contraseña" required  />  

                            <span class="input-group-addon" onclick="OcultarMostrarP()" >
                              <i  style="display:none"  id="eye" class="fa fa-eye"></i>
                              <i id="slash" class="fa fa-eye-slash"></i>
                             
                            </span>
                            
                          </div>
                
                     
                    </div>

                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-6" id="divclave2">
                     <label class="control-label" id="lblrepetirclave">Repetir Contraseña <span style="color:red">*</span></label>
                         <div class="input-group">          
                            <input class="form-control" type="password" id="repetirPassword" name="repetirPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Mínimo 8 caracteres que incluyen una letra mayúscula y minúscula, un número" placeholder="Repetir la contraseña" required />
                        </div>
                      </div>
                    </div>

                <!-- =========================================== -->


                  <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                    <!-- PRIMERA FILA -->
                   <div class="form-group col-md-6">
                      <div class="form-group">
                        <label class="control-label">Seleccione el perfil</label>
                         <label class="control-label" style="color:red">*</label>
                        <!-- <label class="control-label" name="editarPerfil"></label> -->
                       <select class="form-control select2" nane="cmbPerfil" id="cmbPerfil" style="width: 100%;" required="">
                          <option selected="selected">Seleccione una opción</option>
                          <?php 

                            $item="ESTADO_PERFIL";
                            $valor=1;
                            $Perfiles = ControladorPerfiles::ctrMostrarPerfil($item,$valor,null);
                       
                           foreach ($Perfiles as $key => $value) {

                              if ($value["SUPER_PERFIL"]==1){
                                $perfil="Administrador";
                              }else{
                                 $perfil="Usuario";
                              }
                             echo '<option perfil='.$perfil.' value="'.$value["COD_PERFIL"].'/'.$value["TOKEN_PERFIL"].'">'.$value["NOMBRE_PERFIL"].'-'.$perfil.'</option> ';

                         }

                   ?>
                       </select>
                      
                     </div>

                    </div>

                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-6">
                      <div class="form-group">
                        <label class="control-label">Seleccione la sucursal</label>
                        <label class="control-label" style="color:red">*</label>
                       <!--  <label class="control-label" name="editarSucursal"></label> -->
                       <select class="form-control select2" nane="cmbSucursal" id="cmbSucursal" style="width: 100%;" required="">
                          <option selected="selected">Seleccione una opción</option>
                          <?php 

                            $item="ESTADO_SUCURSAL";
                            $valor=1;
                            $Sucursales = ControladorSucursales::ctrMostrarSucursal($item,$valor,null);
                       
                           foreach ($Sucursales as $key => $value) {

                             echo '<option value="'.$value["COD_SUCURSAL"].'/'.$value["TOKEN_SUCURSAL"].'" >'.$value["SUCURSAL"].'</option>';

                         }

                   ?>
                       </select>
                     </div>

                    </div>


                  </div>

                <!-- =========================================== -->

                   <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                    <!-- PRIMERA FILA -->
                    <div class="form-group col-md-4">
                        <!-- ENTRADA PARA LA CONTRASEÑA -->
                        <label class="control-label">Horario desde</label>
                        <label class="control-label" style="color:red">*</label>
                          <div class="input-group">
                            <input class="form-control time" type="time" id="txtHorad" name="txtHorad"  required='required'>
                            
                          </div>
                
                     
                    </div>

                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-4">
                     <label class="control-label">Horario hasta</label>
                        <label class="control-label" style="color:red">*</label>
                         <div class="input-group">          
                        
                            <input style="vertical-align:font-weight;" class="form-control time" type="time" id ="txtHorah" name="txtHorah" required='required'>
                        </div>
                      </div>

                       <div class="form-group col-md-4">
                    <div class="form-group">
                        <label for="cmbEstado">Seleccione el estado</label>
                        <select class="form-control" name="cmbEstado" id="cmbEstado" required>
                          <option value="1">Activo</option>
                          <option value="0">Inactivo</option>
                         
                        </select>
                    </div>

                    </div>
                  </div>

                <!-- =========================================== -->

                <!-- SEGUNDAD FILA -->
                 <div class="form-row">
                    <div class="form-group col-md-4">
                     <label class="control-label" style="display: none;" id="lblintento">Resetear Intento</label>
                         <div class="input-group">          
                            <input style="display: none;" class="form-control" type="text" id="txtintento" name="txtintento" placeholder="Resetear intento" />
                        </div>
                      </div>
                      <div class="form-group col-md-4"></div>
                      <div class="form-group col-md-4"></div>
                   </div>
                    <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                 <!--  <div class="form-group">
                   <div class="animated-checkbox">
                      <label>
                        <input type="checkbox" value=0 id="nuevoActivo" name="nuevoActivo" onclick="Activarcheck()"><span class="label-text">Local principal</span>
                      </label>
                    </div>
        
                </div>
 -->

                <!-- =========================================== -->

                <!-- Galería -->

              <div class="card rounded-lg card-secondary card-outline">
                
                <div class="card-header pl-2 pl-sm-3">

                  <h5>Imagen del usuario:</h5>

                </div>

                <div class="card-body">  

                  <ul class="row p-0 vistaGaleria">


                    
                  </ul>

                </div>

                <input type="hidden" class="inputNuevaGaleria">
                <input type="hidden" class="inputGaleria">
                <input type="hidden" class="inputAntiguaGaleria">
                <input type="hidden" class="inputAntiguaGaleriaEstatica">

                <div class="card-footer">
                  
                  <input type="file" multiple name="galeria[]" id="galeria" class="d-none" accept="image/jpeg,image/png">

                  <label for="galeria" class="text-dark text-center py-5 border rounded bg-white w-100 subirGaleria">

                     Haz clic aquí o arrastra las imágenes <br>
                     <span class="help-block small">Formato: JPG-PNG-GIF</span>
                     
                  </label>

                </div>

              </div>

        </div>

                <!-- =========================================== -->


                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
                  </div>

              </form>
                   
          </div>


    </div>

  </div>

</div>
 
<script src="vistas/js/usuarios.js"></script>