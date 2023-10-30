  <!-- Navbar-->
<header class="app-header"><a class="app-header__logo" href="inicio"> <img src="assets/img/logo.png" width="160"></a>
      <!-- Sidebar toggle button-->
      <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>

      <!-- Navbar Derecha Menu-->
      <ul class="app-nav">

        <!-- barra de busqueda -->
        <li class="app-search">
          <input class="app-search__input" type="search" placeholder="Search">
          <button class="app-search__button"><i class="fa fa-search"></i></button>
        </li>



 <!-- Usuario de Menu-->

     <!--    <li class="dropdown" title="Realizar ventas"><a class="app-nav__item" href="ventas"><i class="app-menu__icon fa-solid fa-cart-arrow-down" width="32px"></i></a>
     
        </li> -->
       
        <!--Notificacion de Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Show notifications"><i class="fa-solid fa-bell"  width="32px"></i></a>
          <ul class="app-notification dropdown-menu dropdown-menu-right">
            <li class="app-notification__title">You have 4 new notifications.</li>
            <div class="app-notification__content">
              <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span>
                  <div>
                    <p class="app-notification__message">Lisa sent you a mail</p>
                    <p class="app-notification__meta">2 min ago</p>
                  </div></a></li>
              <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-danger"></i><i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i></span></span>
                  <div>
                    <p class="app-notification__message">Mail server not working</p>
                    <p class="app-notification__meta">5 min ago</p>
                  </div></a></li>
              <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-success"></i><i class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
                  <div>
                    <p class="app-notification__message">Transaction complete</p>
                    <p class="app-notification__meta">2 days ago</p>
                  </div></a></li>
              <div class="app-notification__content">
                <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span>
                    <div>
                      <p class="app-notification__message">Lisa sent you a mail</p>
                      <p class="app-notification__meta">2 min ago</p>
                    </div></a></li>
                <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-danger"></i><i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i></span></span>
                    <div>
                      <p class="app-notification__message">Mail server not working</p>
                      <p class="app-notification__meta">5 min ago</p>
                    </div></a></li>
                <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-success"></i><i class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
                    <div>
                      <p class="app-notification__message">Transaction complete</p>
                      <p class="app-notification__meta">2 days ago</p>
                    </div></a></li>
              </div>
            </div>
            <li class="app-notification__footer"><a href="#">See all notifications.</a></li>
          </ul>
        </li>
        <!-- ========================================================================================== -->

        <!-- Usuario de Menu-->
        <li class="dropdown">
          <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu">
              <?php 

               $item = "COD_USUARIO";
          
              $valor =$_SESSION["id_usu"];

              $usuarios = ControladorUsuarios::ctrMostrarUsuario($item, $valor);
     
            $_SESSION["foto"]=$usuarios["FOTO_USUARIO"];
          
              $jsonIncluye = json_decode($_SESSION["foto"], true);

              if($jsonIncluye!=[]){
             
                  //var_dump($jsonIncluye);
                foreach ($jsonIncluye as $indice => $valor) {

                  if ($valor !=""){
                    
                       echo '<img src="'.$valor.'" class="img-fluid rounded-circle"  width="32px">';

                    }else{
                     
                       echo '<img src="vistas/img/usuarios/default/anonymous.png" class="rounded mx-auto d-block" width="35px>">';

                    }
                } 
              }else{
                     
                       echo '<img src="vistas/img/usuarios/default/anonymous.png" class="rounded mx-auto d-block" width="25px">';

                    }

             ?>
          </a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li>
              <a class="dropdown-item" href="cambiarPerfil">
                <i class="fa fa-users-cog fa-lg">
                </i> Configuracion
              </a>
            </li>
           
            <li>
              <a class="dropdown-item" href="cambiarPerfil">
                <i class="fa fa-user fa-lg">
                </i> Perfil
              </a>
            </li>

            <li>
              <a class="dropdown-item"href="salir">
                <i class="fa fa-sign-out fa-lg">
                </i> Cerrar Sesión
              </a>
            </li>

          </ul>
        </li>

        <!-- ======================================================================================== -->
      </ul>
    </header>