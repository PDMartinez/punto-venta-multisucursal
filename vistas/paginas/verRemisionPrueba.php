<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar ventas
    
    </h1>
 <input type="hidden" value="EMITIDO" id="EstadoFactura">

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar ventas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <!-- Boton para agregar nuevo pedido -->

      <div class="box-header with-border">
  
        <a href="crear-ventaInicio">

          <button class="btn btn-primary">
            
            Agregar ventas

          </button>

          


        </a>

        <button type="button" class="btn btn-default pull-right" id="daterange-btn">
           
            <span>
              <i class="fa fa-calendar"></i> Rango de fecha
            </span>

            <i class="fa fa-caret-down"></i>

         </button>


      </div>
     
 <!-- =========================================== -->
       

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Nº venta</th>
           <th>Cliente</th>
           <th>Usuario</th>
           <th>Habitación</th>
           <th>Cobro habitación</th>
           <th>Descuento/Aumento</th>
           <th>Total habitación</th>
           <th>Hora uso</th>
           <th>Fecha</th>
           <th>Tipo venta</th>
           <th>Movimiento</th>
           <th>Observación</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

        
          
          if(isset($_GET["fechaInicial"])){

            $fechaInicial = $_GET["fechaInicial"];
            $fechaFinal = $_GET["fechaFinal"];

           }else{
             $fechaInicial =null;
            $fechaFinal = null;
           }

           $valor1 = "EMITIDO";
         
          $respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial,$fechaFinal,$valor1);


          foreach ($respuesta as $key => $value) {
           

           echo '<tr>

                  <td>'.($key+1).'</td>

                  <td>'.$value["NROMOVIMIENTO"].'</td>';

                  $itemCliente = "COD_CLIENTE";
                  $valorCliente = $value["COD_CLIENTE"];

                  $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                  echo '<td>'.$respuestaCliente["RUC"].'-'.$respuestaCliente["EMPRESA"].'</td>';

                  $itemUsuario = "COD_USUARIO";
                  $valorUsuario = $value["COD_USUARIO"];

                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);


                  $itemHabi= "COD_HABITACION";
                  $valorHabi= $value["COD_HABITACION"];
                  $ActivoHabi=null;

                  $habitacion = ControladorHabitaciones::ctrMostrarHabitaciones($itemHabi, $valorHabi,$ActivoHabi);

                $totalHabitacion=$value["PRECIO_HABITACION"]-$value["PRECIO_AJUSTE"];
                if($value["TIPO_PAGO"]=="EFECTIVO"){
                  $movimiento=number_format($value["TIPO_PAGO_NUMERO"],0,',','.');

                }else{
                  $movimiento= $value["TIPO_PAGO_NUMERO"];
                }
              
                  echo '<td>'.
                  $respuestaUsuario["NOMBRE_USUARIO"].'</td>

                  <td>'.$habitacion["NROHABITACION"].'-'.$habitacion["DESCRIPCION_HABITACION"].'</td>
                  <td>'.number_format($value["PRECIO_HABITACION"],0,',','.').'</td>
                   <td>'.number_format($value["PRECIO_AJUSTE"],0,',','.').'</td>
                    <td>'.number_format($totalHabitacion,0,',','.').'</td>
                  <td>'.$value["HORA_USO"].'</td>
                  <td>'.$value["FECHA"].'</td>
                  <td>'.$value["TIPO_PAGO"].'</td>
                  <td>'.$movimiento.'</td>
                  <td>'.$value["OBSERVACION"].'</td>
                  <td>

                    <div class="btn-group">

                      <button class="btn btn-danger btnEliminarVenta" idVenta="'.$value["COD_VENTA"].'" estado="'.$value["ESTADO_VENTAS"].'"  usuario="'.$_SESSION["id_usu"].'" <i class="fa  fa-ban"></i>'.$value["ESTADO_VENTAS"].'</button>

                    </div>  

                  </td>

                </tr>';
           
}
        ?>
               
        </tbody>

       </table>

       <?php

      $eliminarVenta = new ControladorVentas();
      $eliminarVenta -> ctrEliminarVenta();

      ?>
       

      </div>

    </div>

  </section>

</div>