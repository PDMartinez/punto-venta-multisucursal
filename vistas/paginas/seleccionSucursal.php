 <?php 
        $item = "ESTADO_SUCURSAL";
        $valor = 1;
        $sucursales = ControladorSucursales::ctrMostrarSucursal($item, $valor,null);
     
          // var_dump($sucursales);
        if($_SESSION["superperfil"]==0){
           echo '<script type="text/javascript">

                    window.location = "inicio";

                    </script>';
        }
       

      ?>
<main style="background-color:#464775" class="app-content">
      <div class="app-title">
        <div>
          <h3><i style="color:#464775" class="fa fa-laptop"></i> SUCURSALES: Seleccione una sucursal</h3>
         
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-users fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="salir">Login</a></li>
        </ul>
      </div>
      <div class="row">
        <?php foreach ($sucursales as $key => $value): ?>
          <?php  $item="COD_CIUDAD";
        $valor= $value["COD_CIUDAD"];
        $ciudad = ControladorCiudades::ctrMostrarCiudad($item,$valor); ?>
        <div class="col-md-6">

          <div class="tile">
            
            <h3 class="tile-title"><?php echo $value["SUCURSAL"]; ?></h3>
            

          <!--    <div class="col-md-6"> -->
               <div class="tile-body">
               <?php
              $galeria = json_decode($value["IMAGEN_SUC"], true);
              if ($galeria!="" && $galeria!=[""] && $galeria!=NULL){
          
                  //var_dump($galeria);
                foreach ($galeria as $indice => $valor) {
                 
                      echo '<img class="img-thumbnail" src="'.$valor.'">';
                                     }
              } else{
                $valor='vistas/img/sucursales/default/anonymous.jpg';
                      echo '<img class="img-thumbnail" src="'.$valor.'">';
                    }

                ?>
          
          <!--     </div> -->

             </div>


          <!--   <div class="col-md-6"> -->
               <div class="tile-body">
                <?php echo "ENCARGADO: ".$value["ENCARGADO"];?>
                 </div>  
                  <div class="tile-body">
                <?php echo "DIRECCIÓN: ".$value["DIRECCION"];?>
                 </div>  
                  <div class="tile-body">
                <?php echo "TELÉFONO: ".$value["TELEFONO_SUC"];?>
                 </div>  
          <!--   </div> -->

          
            <div class="tile-footer">

              <button type="button" class="btn btn-primary btnSeleccionSucursal" tokensucursal="<?php echo $value["TOKEN_SUCURSAL"]; ?>" Sucursal="<?php echo $value["SUCURSAL"]; ?>"fotoSucursal="<?php echo $valor; ?>" estadoSucursal="0">Seleccione una sucursal</button>
            </div>

          </div>

        </div>

       <?php endforeach ?>

        <div class="clearfix"></div>
      </div>
    </main>


    <script>
     
 $(document).on("click", ".btnSeleccionSucursal", function(){
    var token=$(this).attr("tokensucursal");
    var sucursal=$(this).attr("Sucursal");
    var fotosucursal=$(this).attr("fotoSucursal");
   
    window.location = "index.php?ruta=inicio&token="+token+"&SucImagen="+fotosucursal+"&sucursal="+sucursal;
  

  })

    </script>