 <?php 

          
          $item="EMPRESA_ACTIVO";
          $valor=0;

          $cantidades =ControladorSucursales:: ctrMostrarCantidadSucursal($item, $valor);
        

          if($cantidades!=null){
           echo '<script type="text/javascript">
              window.location = "vistas/bloqueados/index.html";
              </script>';
          }
     
         

        ?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login - Gm-repuestos|Compumarkapp</title>
  </head>

  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>

    <section class="login-content" style="background-color: #434472;">

      <div class="rounded mx-auto d-block">
        <img src="assets/img/logo.png" class="img-rounded" width="355">
      </div>


      <div class="login-box">

        <!-- INGRESO AL LOGIN -->
        <form class="login-form" method="post" >
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Ingreso al Sistema</h3>
          <div class="form-group">
            <label class="control-label">USUARIO</label>
            <input class="form-control" type="text" name="ingUsuario" required placeholder="Usuario" autofocus>
          </div>

          <div class="form-group">
            <label class="control-label">CONTRASEÑA</label>
            <input class="form-control" type="password" name="ingPassword" id="ingPassword" required placeholder="Contraseña">
          </div>


          <div class="form-group">

            <div class="utility">

              <div class="animated-checkbox">

                <label>
                  <input type="checkbox" id="mostrar" onclick="mostrarContrasena()"><span class="label-text">Mostrar contraseña</span>
                </label>

              </div>
             <!--  <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Has olvidado tu contraseña ?</a></p> -->

            </div>

          </div>


          <div class="form-group btn-container">

            <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Ingresar</button>

          </div>



           <!--Instanciando un ojeto en php para llamar al proceso controlador-->
              <?php 
                    $login=new ControladorUsuarios(); //clase usuario
                    $login -> ctrIngresoUsuario(); //metodo usuarios.s
               ?>
        </form>


         <!-- =============================================================================== -->

        <!-- RECUPERAR CONTRASEÑA -->
        <form class="forget-form" method="post" >
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Has olvidado tu contraseña ?</h3>
          <div class="form-group">
            <label class="control-label">EMAIL</label>
            <input class="form-control" type="text" placeholder="Email">
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Atrás para iniciar sesión</a></p>
          </div>
        </form>
        <!-- =============================================================================== -->

      </div>

          <div class="alert alert-dismissible alert-danger texto" style="width:350px" >

           <div class="rounded mx-auto d-block"  style="float: left">
            <img src="assets/img/logocompumarklogin.png" class="img-rounded" width="150">
          
          </div>

           <p align="right" style="font-size:10px;">Licencia otorgada a la empresa GM-REPUESTOS por parte de la empresa <a href="compumarkapp.com">CompumarkApp.com</a></p>

        </div>
  
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="assets/js/plugins/pace.min.js"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });

  function mostrarContrasena()
 {
  var password = document.getElementById("ingPassword");
    
  if($("#mostrar").is(':checked') && password.type === 'password') {
    password.type = "text";

  }else{
    password.type = "password";
  }

}
    </script>
  </body>
</html>