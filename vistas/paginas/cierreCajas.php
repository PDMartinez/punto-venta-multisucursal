  
    <?php 

      $item = "ESTADO_APERTURA";
      $valor = "APERTURA";
      $var=1;
      $item1 = "COD_USUARIO";
      $valor1 =$_SESSION["id_usu"];

      $nombres = explode("/",$_SESSION["idsucursal"]);
      $TOKEN_SUCURSAL=$nombres[0];

      $item2 = "COD_SUCURSAL";
      $valor2= $TOKEN_SUCURSAL;
                          
      $cajaApertura = ControladorAperturas::ctrMostrarAperturasucursalCaja($item, $valor,$item1,$valor1,$item2,$valor2,$var);
     
        
        if(!$cajaApertura){

        $_SESSION["id_apertura"]= null;
        $_SESSION["gastos"]=null;

          echo '<script>

            window.location = "apertura";

            </script>';

            return false;


        }else{


          $_SESSION["id_apertura"]= $cajaApertura["COD_APERTURA"];
          $_SESSION["tokenApertura"]= $cajaApertura["TOKEN_APERTURA"];
          $_SESSION["nombreCaja"]= $cajaApertura["NROCAJA"];
          $_SESSION["cod_caja"]= $cajaApertura["COD_CAJA"].'/'.$cajaApertura["TOKEN_CAJA"];
          $_SESSION["gastos"]=null;





            // SUMAMOS LAS VENTAS PARA LA CAJA CONTADO


                      $item = "COD_APERTURA";
                      $valor = $_SESSION["id_apertura"];
                     
                      $item1 = "ESTADO_APERTURA";
                      $valor1 ="APERTURA";

                      $item2 = "FORMA_PAGO";
                      $valor2= "CONTADO";

                      $item3 = "ESTADO_FACTURA";
                      $valor3= 1;

                      $select="METODO_PAGO";
                      $total=0;
                      $tabla="ventas";
                      $tabla1="aperturas_cab";  

                      $Formapagos = ControladorFormaPagos::ctrMostrarFormapago(null,null,null,null);
                                          
                      $VentaApertura = ControladorAperturas::ctrMostrarVentaApertura($tabla,$tabla1,$select,$item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3);
                     // echo '<pre>'; print_r($VentaApertura); echo '</pre>';

                            $arrayEntregas = array();
                            $arrayventnuevas = array();

                             foreach ($Formapagos as $key1 => $value2) {
                                $sumentrega=0;
                                
                                foreach ($VentaApertura as $key => $value){

                                  
                                  $metodopagos = json_decode($value["METODO_PAGO"], true);
                           
                                    if ($metodopagos!="" && $metodopagos!=null){
                                        
                                      
                                        foreach ($metodopagos as $indice => $value1) {
                                           

                                            $nombres = explode("/",$value1["id_metodo"]);
                                            $codigoapertura=$nombres[0];
                                          

                                                if($value2["COD_FORMAPAGO"]==$codigoapertura){
                                                
                                                  $sumentrega +=$value1["entrega"];

                                                    $arrayEntregas = array("codigoformapago"=>$value2["COD_FORMAPAGO"],"descripcion"=>$value2["DESCRIPCION_FORMA"],"entrega" => $sumentrega);
                                                    

                                                   }


                                            
                              
                                   

                                        }// FOR PARA TRAER EL METODO


                                    }// EL IF SI ES NULO


                            
                                 
                              }// TERMINA EL FOR DE VENTAS


                                array_push($arrayventnuevas,$arrayEntregas);

                               
       
                           
                          }// TERMINA EL FOR DE FORMAS DE PAGOS




    /*=================================================================================
                            // SUMAMOS LOS COBROS A CREDITOS
    ==================================================================================*/

                      $item = "COD_APERTURA";
                      $valor = $_SESSION["id_apertura"];
                     
                      $item1 = "ESTADO_APERTURA";
                      $valor1 ="APERTURA";

                      $item2 = "FORMA_PAGO";
                      $valor2= "CREDITO";

                      $item3 = "ESTADO_FACTURA";
                      $valor3= 1;

                      $select="FORMAPAGO";
                      $total=0;

                      $FormaspagosCreditos = ControladorFormaPagos::ctrMostrarFormapago(null,null,null,null);
                                          
                      $CobrosAperturas = ControladorAperturas::ctrMostrarCobrosApertura($select,$item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3);
                      // echo '<pre>'; print_r($CobrosAperturas); echo '</pre>';
                     // echo '<pre>'; print_r($VentaApertura); echo '</pre>';

                            $arrayEntregasCreditos = array();
                            $arrayCreditosCobros = array();

                             foreach ($FormaspagosCreditos as $key1 => $value2) {
                                $sumEntregaCreditos=0;
                                
                                foreach ($CobrosAperturas as $key => $value){

                                  
                                  $metodosPagosCreditos = json_decode($value["FORMAPAGO"], true);
                           
                                    if ($metodosPagosCreditos!="" && $metodosPagosCreditos!=null){
                                        
                                      
                                        foreach ($metodosPagosCreditos as $indice => $value1) {
                                           

                                            $nombres = explode("/",$value1["id_metodo"]);
                                            $codigoapertura=$nombres[0];
                                          

                                                if($value2["COD_FORMAPAGO"]==$codigoapertura){
                                                
                                                  $sumEntregaCreditos +=$value1["entrega"];

                                                    $arrayEntregasCreditos = array("codigoformapago"=>$value2["COD_FORMAPAGO"],"descripcion"=>$value2["DESCRIPCION_FORMA"],"entrega" => $sumEntregaCreditos);
                                                    

                                                   }


                                        }// FOR PARA TRAER EL METODO


                                    }// EL IF SI ES NULO


                            
                                 
                              }// TERMINA EL FOR DE VENTAS


                                array_push($arrayCreditosCobros,$arrayEntregasCreditos);

                               
       
                           
                          }// TERMINA EL FOR DE FORMAS DE PAGOS




      /*=================================================================================
                            // SUMAMOS LOS GASTOS EN EL SISTEMA
    ==================================================================================*/

                      $item = "COD_APERTURA";
                      $valor = $_SESSION["id_apertura"];
                     
                      $item1 = "ESTADO_APERTURA";
                      $valor1 ="APERTURA";

                      $item2 = "VER_CAJA";
                      $valor2= 1;

                      $item3 = "ESTADO_GASTOS";
                      $valor3= 1;

                      $select="FORMAPAGO";
                      $total=0;


                      $FormaspagosCreditos = ControladorFormaPagos::ctrMostrarFormapago(null,null,null,null);
                                          
                      $GastosAperturas = ControladorAperturas::ctrMostrarGastosApertura($select,$item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3);
                      // echo '<pre>'; print_r($GastosAperturas); echo '</pre>';
                      // echo '<pre>'; print_r($CobrosAperturas); echo '</pre>';
                     // echo '<pre>'; print_r($VentaApertura); echo '</pre>';

                            $arrayEntregaGastos = array();
                            $arrayGastos = array();

                             foreach ($FormaspagosCreditos as $key1 => $value2) {
                                $sumEtregaGastos=0;
                                
                                foreach ($GastosAperturas as $key => $value){

                                  
                                  $metodosPagosCreditos = json_decode($value["FORMAPAGO"], true);
                           
                                    if ($metodosPagosCreditos!="" && $metodosPagosCreditos!=null){
                                        
                                      
                                        foreach ($metodosPagosCreditos as $indice => $value1) {
                                           

                                            $nombres = explode("/",$value1["id_metodo"]);
                                            $codigoapertura=$nombres[0];
                                          

                                                if($value2["COD_FORMAPAGO"]==$codigoapertura){
                                                
                                                  $sumEtregaGastos +=$value1["entrega"];

                                                    $arrayEntregaGastos = array("codigoformapago"=>$value2["COD_FORMAPAGO"],"descripcion"=>$value2["DESCRIPCION_FORMA"],"entrega" => $sumEtregaGastos);
                                                    

                                                   }


                                        }// FOR PARA TRAER EL METODO


                                    }// EL IF SI ES NULO


                            
                                 
                              }// TERMINA EL FOR DE VENTAS


                                array_push($arrayGastos,$arrayEntregaGastos);

                           
                          }// TERMINA EL FOR DE FORMAS DE PAGOS



           }

    ?>

    <main class="app-content">
      <div class="app-title">
        <div class="text-primary">

          <h5>Realizar cierre de caja</h5>
         
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="inicio"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item"><a href="cierreCajas">Cierre cajas</a></li>
        </ul>
      </div>

  <!-- MODAL PARA VER DETALLE DE LA APERTURA -->
      <div class="card">
        <div class="card-body">

             <form onsubmit="return guardarCierre()" id="formularioCierre">
                     <!-- FORMULARIOS -->
                 <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $_SESSION["id_usu"].'/'.$_SESSION["tokenUsuario"]; ?>"> 
                  <input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $_SESSION["idsucursal"]; ?>">

                  <input type="hidden" name="codigoapertura" id="codigoapertura" value="<?php echo $_SESSION["id_apertura"]; ?>">

                  <input type="hidden" name="tokenapertura" id="tokenapertura" value="<?php  echo  $_SESSION["tokenApertura"]; ?>">


                  <div class="row">
                        
                      <div class="form-group col-lg-6">
                     
                        <label class="control-label">Usuario:</label>
                        <input class="form-control" id="txtNombreUsuario" type="text" value="<?php echo $_SESSION["funcionario"].' - '.$_SESSION["usuario"]; ?>" readonly>

                      </div>

                     <div class="form-group col-lg-6">
                     
                        <label class="control-label">N° de Caja:</label>
                        <input type="text" class="form-control input-lg" id="txtNroCaja" name="txtNroCaja"  value="<?php  echo $_SESSION["nombreCaja"]; ?>" readonly>

                      </div>
                   </div>

                     <div class="alert alert-dismissible alert-danger">
                      <h6 class="text-center">MOVIMIENTO AL CONTADO</h6>
                   </div>

                     <div class="row">

                   <?php 
                    $TotalContado=0;
                    $texto="";
    
                foreach ($Formapagos as $key5 => $value5) {
                     
                         $nuemro=0;

                    foreach ($arrayventnuevas as $key4 => $value4) {
                          
                      if( $value4!=null){
                        

                       if($value5["COD_FORMAPAGO"]==$value4["codigoformapago"] && $nuemro==0){
                         $nuemro=1;
                          $TotalContado += $value4["entrega"];
                           $texto=ucwords(strtolower($value4["descripcion"]));
                             echo ' <div class="form-group col-lg-6">
                              <label class="control-label">'.$texto.':</label>
                              <input type="text" class="form-control input-lg" value='.number_format($value4["entrega"],0,',','.').' readonly >

                            </div>';
                        }

                    }
                   

                     }

                    
                }

                    echo ' <div class="form-group col-lg-6">
                              <label class="control-label"><strong>Total Contado:</strong></label>
                              <input type="text" class="form-control input-lg" id="txtTotalContado" value='.number_format($TotalContado,0,',','.').' readonly >

                            </div>';
                                    
                 
                ?>

                  </div>

                  <?php 

                    if(count($arrayCreditosCobros)>0){

                      echo ' <div class="alert alert-dismissible alert-danger">

                  <h6 class="text-center">MOVIMIENTO COBROS A CREDITO</h6>
                </div>';
                    }


                   ?>
    
               
               
              <div class="row">

                   <?php 


                    $TotalCredito=0;
                    $texto="";
    
                         foreach ($Formapagos as $key5 => $value5) {
                     
                         $nuemro=0;

                         foreach ($arrayCreditosCobros as $key4 => $value4) {
                          
                      if( $value4!=null){
                        

                       if($value5["COD_FORMAPAGO"]==$value4["codigoformapago"] && $nuemro==0){
                         $nuemro=1;
                          $TotalCredito += $value4["entrega"];
                           $texto=ucwords(strtolower($value4["descripcion"]));
                             echo ' <div class="form-group col-lg-6">
                              <label class="control-label">'.$texto.':</label>
                              <input type="text" class="form-control input-lg" value='.number_format($value4["entrega"],0,',','.').' readonly >

                            </div>';
                        }

                    }
                   

                     }

                    
                }

                    echo ' <div class="form-group col-lg-6">
                              <label class="control-label"><strong>Total cobros a crédito:</strong></label>
                              <input type="text" class="form-control input-lg" id="txtTotalCredito" value='.number_format($TotalCredito,0,',','.').' readonly >

                            </div>';


                   ?>

                      </div>

                      
                   <div class="alert alert-dismissible alert-danger">

                     <h6 class="text-center">GASTOS EXTRAIDO DE CAJA</h6>

                  </div>

              <div class="row">

                  <?php 


                        $TotalGastos=0;
                        $texto="";
        
                          foreach ($Formapagos as $key5 => $value5) {
                         
                             $nuemro=0;

                             foreach ($arrayGastos as $key4 => $value4) {
                              
                                if( $value4!=null){
                                  

                                 if($value5["COD_FORMAPAGO"]==$value4["codigoformapago"] && $nuemro==0){
                                   $nuemro=1;
                                    $TotalGastos += $value4["entrega"];
                                     $texto=ucwords(strtolower($value4["descripcion"]));
                                       echo ' <div class="form-group col-lg-6">
                                        <label class="control-label">'.$texto.':</label>
                                        <input type="text" class="form-control input-lg" value='.number_format($value4["entrega"],0,',','.').' readonly >

                                      </div>';
                                  }

                              }
                       

                         }

                        
                    }




                        echo ' <div class="form-group col-lg-6">
                                  <label class="control-label"><strong>Total gastos extraido: </strong></label>
                                  <input type="text" class="form-control input-lg" id="txtTotalGastos" value='.number_format( $TotalGastos,0,',','.').' readonly >

                                </div>';


                   ?>


                   </div>


                   <div class="alert alert-dismissible alert-danger">

                          <h6 class="text-center">APERTURA DE CAJA</h6>
                    </div>

                  <?php 

                    
                        $COD_APERTURA=$_SESSION["id_apertura"];

                        $item = "COD_APERTURA";
                        $valor = $COD_APERTURA;
                        $var=null;

                        $AperturasDetalle = ControladorAperturas::ctrMostrarAperturaDetalle($item, $valor,$var);

                        $TotalEnCaja=($AperturasDetalle["TOTAL"]+$TotalCredito+$TotalContado)-$TotalGastos;
                       

                    echo '  <div class="row"><div class="form-group col-lg-6">
                              <label class="control-label"><strong>Apertura de caja:</strong></label>
                              <input type="text" class="form-control input-lg" id="txtTotalApertura" value='.number_format($AperturasDetalle["TOTAL"],0,',','.').' readonly >

                            </div>
                            <div class="form-group col-lg-6">

                              <label class="control-label"><strong>Total en caja:</strong></label>
                              <input type="text" class="form-control input-lg" id="txtTotalCaja" value='.number_format($TotalEnCaja,0,',','.').' readonly >

                            </div>



                            </div>';

                   ?>


                  <div class="row">

                      <div class="form-group col-lg-6">
                        <label class="control-label">Monto Cierre:</label>
                        <input type="text" class="form-control input-lg" id="nuevoCierre" name="nuevoCierre" min="0" step="any" placeholder="Ingresar el monto de cierre" onkeyup="format(this)" onchange="format(this)" required>

                      </div>

                      <div class="form-group col-lg-6">
                        <label class="control-label">Diferencia:</label>
                        <input type="text" class="form-control input-lg" id="nuevoDiferencia" name="nuevoDiferencia" min="0" step="any" placeholder="Diferencia" onkeyup="format(this)" onchange="format(this)" required readonly>

                      </div>

                </div>



                <div class="form-group col-lg-12">
                    <label class="control-label">Observaciones:</label>
                    <textarea class="form-control input-lg" name="txtObservaciones" id="txtObservaciones" cols="10" rows="5"></textarea>

                  </div>

                             
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-primary" id="btnGuardarCierre">Registrar Cierre</button>
                  </div>
                  
              </form>
        </div>
      </div>
         
 </main>

<script src="vistas/js/apertura.js"></script>