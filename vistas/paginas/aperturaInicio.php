  <?php 

  $item = "ESTADO_APERTURA";
  $valor = "APERTURA";
  $var=1;
  $usuario=$_SESSION["id_usu"];
  $sucursal=$_SESSION["idsucursal"];
  $cajaApertura = ControladorAperturas::ctrMostrarAperturasucursalCaja($item, $valor,$usuario,$sucursal,$var);
  //echo '<pre>'; print_r($cajaApertura); echo '</pre>';
  
  if(!$cajaApertura){

  $_SESSION["id_apertura"]= null;
  $_SESSION["SesionVentas"]= null;
  $_SESSION["gastos"]=null;

    echo '<script>

      window.location = "apertura";

      </script>';


  }else{
    $_SESSION["id_apertura"]= $cajaApertura["COD_APERTURA"];
    $_SESSION["nombreCaja"]= $cajaApertura["NROCAJA"];
    $_SESSION["cod_caja"]= $cajaApertura["COD_CAJA"].'/'.$cajaApertura["TOKEN_CAJA"];
    $_SESSION["SesionVentas"]= 1;
    $_SESSION["gastos"]=null;
   
    echo '<script>

    window.location = "ventas";

    </script>';
   
  }
         ?>
