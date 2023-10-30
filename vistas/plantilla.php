
<?php 
session_start();

 ?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Software de gestion Compumark">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Ing. Marcos Contrera"> 
    <meta name="theme-color" content="#464775"> 
    <link rel="shortcut icon" href="assets/img/icono.png"> 
    <title>CompumarkApp|Sistema</title>
    

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/boton.css">

      <!-- Select 2 CSS -->
  <!--   <link rel="stylesheet" type="text/css" href="assets/css/select2-bootstrap4.css"> -->
    <link rel="stylesheet" type="text/css" href="assets/css/select2-bootstrap4.min.css">
 
      <!-- CALCULADORA -->
<!-- 
      <link rel="stylesheet" href="assets/calculadora/css/styles.css">
      <link rel="stylesheet" href="assets/calculadora/css/font-awesome.min.css"> -->

    <!-- bootstrap tags -->
     <link rel="stylesheet" href="assets/css/bootstrap-tagsinput.css">
        <!-- Font-icon css-->
    <!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->

    <!-- FONTAWESON VERSION 6 -->
    <link rel="stylesheet" type="text/css" href="assets/fontAwesone6/css/all.min.css">

 <!-- Bootstrap Rango Picker -->
  <link rel="stylesheet" href="assets/css/bootstrap-daterangepicker/daterangepicker.css">
   <!-- Essential javascripts for application to work-->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>


   <!-- Select2 -->
   <script type="text/javascript" src="assets/js/plugins/select2.min.js"></script>

    <!-- ICONOS DE fontawesome -->
<!--     <script src="assets/js/fontawesome.js"></script> -->
    <!-- The javascript plugin to display page loading on top-->
    <script src="assets/js/plugins/pace.min.js"></script>
    <!-- Alerta-->
    <script src="assets/js/plugins/sweetalert.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="assets/js/plugins/chart.js"></script>

    <!-- Data table plugin-->
    <script type="text/javascript" src="assets/js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/dataTables.bootstrap.min.js"></script>
 
     <!-- Dar formato a los numeros -->
  <script src="assets/js/plugins/jquerynumber.min.js"></script>

   <!-- Dar formato a los numeros -->
  <script src="assets/js/botonFlotante.js"></script>

    <!-- bootstrap tags -->
    <script src="assets/js/bootstrap-tagsinput.min.js"></script>
    
 <!--  <script type="text/javascript" src="assets/js/plugins/dropzone.js"></script> -->

   <script type="text/javascript" src="assets/js/plugins/bootstrap-notify.min.js"></script>

   <!-- RANGOS DE FECHAS -->
    <script src="assets/js/moment/moment.js"></script>
   <script src="assets/css/bootstrap-daterangepicker/daterangepicker.js"></script>

   <!-- FECHA EN -->
    <script type="text/javascript" src="assets/js/plugins/bootstrap-datepicker.min.js"></script>
  

  
   <!-- para usar botones en datatables JS -->  
    <script src="assets/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>  
    <script src="assets/datatables/JSZip-2.5.0/jszip.min.js"></script>    
    <script src="assets/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
    <script src="assets/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="assets/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
   
  <style>
    .table thead{
   /*   background-color: #464775;*/
       background-color: #02567D;
      /* background-color: #2B2B2C;*/
      
      color: azure;
    } 
  </style>
  </head>

  <body class="app  sidebar-mini">

    

   <div id="divLoading" >
        <div>
          <img src="assets/img/loading.svg" alt="Loading">
        </div>
      </div>


      <!--*******************
        Efecto de precargado start
    ********************-->
    <!-- <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div> -->
    <!--*******************
        Efecto de precargado end
    ********************-->

  
  <?php 

  if(isset($_GET["token"])){

      $item = "TOKEN_SUCURSAL";
          
      $valor = $_GET["token"];

    $sucursales = ControladorSucursales::ctrMostrarSucursal($item, $valor,1);
     
    $_SESSION["fotosucursal"]=$sucursales["IMAGEN_SUC"];
    $_SESSION["sucursal"]=$sucursales["SUCURSAL"];
    $_SESSION["idsucursal"]=$sucursales["COD_SUCURSAL"]."/".$sucursales["TOKEN_SUCURSAL"];
      $_SESSION["nroverificadorSucural"]=$sucursales["NROVERIFICADOR"];
         

      }      

    if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"]=="ok"){
      // var_dump($_SESSION["iniciarSesion"]);

      if (isset($_SESSION["sucursal"]) && $_SESSION["sucursal"]!=""){

      
      /*================================
      =            CABEZOTE           =
      ================================*/
      
     include "menu/cabecera.php";

      /*================================
      =            MENU           =
      ================================*/
        include "menu/menu.php";


         /*================================
          =           INICIO           =
          ================================*/
          if(isset($_GET["ruta"])){
            if($_GET["ruta"]=="inicio" ||
              $_GET["ruta"]=="usuarios" ||
              $_GET["ruta"]=="categorias" ||
              $_GET["ruta"]=="subcategorias" ||
              $_GET["ruta"]=="ciudades" ||
              $_GET["ruta"]=="productos" ||
              $_GET["ruta"]=="clientes" ||
              $_GET["ruta"]=="proveedores" ||
              $_GET["ruta"]=="ventas" ||
              $_GET["ruta"]=="reportes" ||
              $_GET["ruta"]=="perfiles" ||
              $_GET["ruta"]=="sucursales" ||
              $_GET["ruta"]=="funcionarios" ||
              $_GET["ruta"]=="formapagos" ||
              $_GET["ruta"]=="marcas" ||
              $_GET["ruta"]=="cambiarPerfil" ||
              $_GET["ruta"]=="seleccionSucursal" ||
              $_GET["ruta"]=="compras" ||
              $_GET["ruta"]=="comprasAnulada" ||
              $_GET["ruta"]=="cajas" ||
              $_GET["ruta"]=="descuentos" ||
              $_GET["ruta"]=="canales" ||
              $_GET["ruta"]=="aperturaDetalle" ||
              $_GET["ruta"]=="apertura" ||
              $_GET["ruta"]=="aperturaInicio" ||
              $_GET["ruta"]=="canalesProductos" ||
              $_GET["ruta"]=="descuentosProductos" ||
              $_GET["ruta"]=="cuotas" ||
              $_GET["ruta"]=="cuentasPagar" ||
              $_GET["ruta"]=="combos" ||
              $_GET["ruta"]=="fletes" ||
              $_GET["ruta"]=="remision" ||
              $_GET["ruta"]=="remisionAnulada" ||
              $_GET["ruta"]=="crearCuentasPagar" ||
              $_GET["ruta"]=="ventasAnuladas" ||
              $_GET["ruta"]=="cierreCajas" ||
              $_GET["ruta"]=="gastos" ||
              $_GET["ruta"]=="preventas" ||
              $_GET["ruta"]=="cuentasPagarCanceladas" ||
              $_GET["ruta"]=="listarpreventas" ||
              $_GET["ruta"]=="cuentasCobrar" ||
              $_GET["ruta"]=="cuentasCobrarCanceladas" ||
              $_GET["ruta"]=="generarToken" ||
              $_GET["ruta"]=="servicios" ||
              $_GET["ruta"]=="salir" )
              {
              include "paginas/".$_GET["ruta"].".php";
            
            }else{
              include 'menu/error404.php';
            }

          } else{
           include "menu/inicio.php";
          }

     }else{
      include "paginas/seleccionSucursal.php";
     }
      
         // include "menu/inicio.php";
    }else{
       // var_dump($_SESSION["iniciarSesion"]);
         include "paginas/login.php";
    }
   ?>


   <!-- <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
   <script type="text/javascript">$('#sampleTable').DataTable();</script> -->
    <script src="vistas/js/plantilla.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- Google analytics script-->
  <!--  <script src="assets/js/plugins/pace.min.js"></script> -->
<!--     <script src="assets/js/popper.min.js"></script> -->
<!--    <script src="assets/js/bootstrap.min.js"></script> -->
   



   <!-- para usar botones en datatables JS -->  
 <!--    <script src="assets/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>  
    <script src="assets/datatables/JSZip-2.5.0/jszip.min.js"></script>    
    <script src="assets/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
    <script src="assets/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="assets/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
 -->

  </body>
</html>