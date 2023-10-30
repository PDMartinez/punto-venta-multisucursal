  <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>

    <aside class="app-sidebar">

      <div class="app-sidebar__user">


         <?php 

            $jsonIncluye = json_decode($_SESSION["fotosucursal"], true);


                  //var_dump($jsonIncluye);
                foreach ($jsonIncluye as $indice => $valor) {

                  if ($valor !=""){
                      echo '<img class="app-sidebar__user-avatar" src="'.$valor.'">';
                    }else{
                      echo '<img class="app-sidebar__user-avatar" src="vistas/img/sucursales/default/anonymous.jpg">';
                    }
                }


          ?>

        <div>

          <p class="app-sidebar__user-name"><?php echo ucwords(strtolower($_SESSION["sucursal"])); ?></p>
          <p class="app-sidebar__user-designation"><?php echo ucwords(strtolower($_SESSION["funcionario"])); ?></p>
          <p class="app-sidebar__user-designation"><?php echo ucwords(strtolower($_SESSION["perfil"])); ?></p>
        </div>

      </div>

        <!-- Calculadora-->
       <!--  <li> -->
         <!--  <a class="app-menu__item active" href="inicio"> -->
           <!--  <i class="app-menu__icon fa fa-dashboard"></i>
            <span class="app-menu__label">Inicio</span> -->

             <!--  <div class="app-menu__item">
                <button class='btn btn-info btn-sm' id="agregarCliente" type="button" data-dismiss="modal" data-toggle="modal" data-target="#ModalCalculadora"> <i class="fa-solid fa-calculator"></i></button>
                   <button class='btn btn-info btn-sm' id="agregarCliente" type="button" data-dismiss="modal" data-toggle="modal" data-target="#ModalCalculadora"> <i class="fa-solid fa-calculator"></i></button>
              </div> -->
         <!--  </a> -->
      <!--   </li> -->
     
    <!-- =========================================================== -->

        <!-- INICIO-->
  <ul class="app-menu">
          
          <li>
            <a class="app-menu__item active" href="inicio">
              <i class="app-menu__icon fa fa-dashboard"></i>
              <span class="app-menu__label">Inicio</span>
            </a>
        </li>
    <!-- =========================================================== -->
    

      <!-- CAMBIOS DE SUCURSALES-->
    <!--   <ul class="app-menu"> -->
        <?php

          if($_SESSION["superperfil"]==1 && $_SESSION["var_sucursal"]==1){
          echo'  <li>
            <a class="app-menu__item" href="seleccionSucursal">
              <i class="app-menu__icon fa fa-home"></i>
              <span class="app-menu__label">Cambio de Sucursal</span>
            </a>
          </li>';
            }
        ?>
    <!-- =========================================================== -->

           <!-- MENU DE VENTAS -->

        <li class="treeview">

          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fas fa-cart-plus"></i>
            <span class="app-menu__label">Ventas</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>

          <ul class="treeview-menu">
           
            <li>
              <a class="treeview-item" href="ventas">
                <i class="icon fa-regular fa-circle"></i> Venta
              </a>
            </li>

             <li>
              <a class="treeview-item" href="preventas">
                <i class="icon fa-regular fa-circle"></i>  Pre Venta
              </a>
            </li>

            <li>
              <a class="treeview-item" href="formapagos">
                <i class="icon fa-regular fa-circle"></i> Registrar Forma pagos
              </a>
            </li>

          

             <li>
              <a class="treeview-item" href="clientes">
                <i class="icon fa-regular fa-circle"></i> Registrar Clientes
              </a>
            </li>

            <li>
              <a class="treeview-item" href="cuentasCobrar">
                <i class="icon fa-regular fa-circle"></i> Cuentas Cobrar
              </a>
            </li>


          </ul>

        </li>

        <!-- =========================================================== -->


          <!-- MENU DE CAJAS -->

        <li class="treeview">

          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa-solid fa-box"></i>
             <span class="app-menu__label">Cajas</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>

          <ul class="treeview-menu">
           
            <li>
              <a class="treeview-item" href="cajas">
               <i class="icon fa-regular fa-circle"></i> Registrar Cajas
              </a>
            </li>

            <li>
              <a class="treeview-item" href="aperturaDetalle">
               <i class="icon fa-regular fa-circle"></i> Registrar Apertura
              </a>

            </li>

             <li>
              <a class="treeview-item" href="cierreCajas">
                <i class="icon fa-regular fa-circle"></i> Registrar Cierre
              </a>
            </li>

             <li>
              <a class="treeview-item" href="gastos">
                <i class="icon fa-regular fa-circle"></i> Registrar Gastos
              </a>
            </li>

          </ul>

        </li>

        <!-- =========================================================== -->

            <!-- MENU DE REMISIONES -->
         <?php

          if($_SESSION["var_sucursal"]==1){
          echo ' 
          
          <li class="treeview">

          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fas fa-truck"></i>
            <span class="app-menu__label">Remisiones</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>

          <ul class="treeview-menu">
          
             <li>
              <a class="treeview-item" href="remision">
                <i class="icon fa-regular fa-circle"></i> Registrar remisión
              </a>
            </li>

           
            <li>
              <a class="treeview-item" href="remisionAnulada">
                <i class="icon fa-regular fa-circle"></i> Ver remisión anulada
              </a>

            </li>

             <li>
              <a class="treeview-item" href="#">
                <i class="icon fa-regular fa-circle"></i> Producto más remitido
              </a>

            </li>

          </ul>

        </li> ';
          }
 ?>

        <!-- =========================================================== -->

         <!-- MENU DE COMPRAS -->

        <li class="treeview">

          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fas fa-dolly-flatbed"></i>
             <span class="app-menu__label">Compras</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>

          <ul class="treeview-menu">
           
            <li>
              <a class="treeview-item" href="compras">
                <i class="icon fa-regular fa-circle"></i> Registrar Compras
              </a>
            </li>

            <li>
              <a class="treeview-item" href="cuentasPagar">
                <i class="icon fa-regular fa-circle"></i> Cuentas a pagar
              </a>

            </li>

             <li>
              <a class="treeview-item" href="proveedores">
                <i class="icon fa-regular fa-circle"></i> Registrar Proveedores
              </a>
            </li>

          </ul>

        </li>

        <!-- =========================================================== -->


        
              <!-- MENU DE PRODUCTOS -->

        <li class="treeview">

          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fab fa-product-hunt"></i>
            <span class="app-menu__label">Productos</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>

          <ul class="treeview-menu">
           
            <li>
              <a class="treeview-item" href="productos">
                <i class="icon fa-regular fa-circle"></i> Registrar Productos
              </a>
            </li>

            <li>
              <a class="treeview-item" href="combos">
                <i class="icon fa-regular fa-circle"></i> Registrar Combos
              </a>
            </li>

             <li>
              <a class="treeview-item" href="servicios">
                <i class="icon fa-regular fa-circle"></i> Registrar Servicios
              </a>
            </li>

            <li>
              <a class="treeview-item" href="fletes">
                <i class="icon fa-regular fa-circle"></i> Registrar Fletes
              </a>
            </li>

            <li>
              <a class="treeview-item" href="categorias">
                <i class="icon fa-regular fa-circle"></i> Registrar Categorias
              </a>
            </li>

            <li>
              <a class="treeview-item" href="subcategorias">
                <i class="icon fa-regular fa-circle"></i> Registrar Sub categorias
              </a>

            </li>

            <li>
              <a class="treeview-item" href="marcas">
                <i class="icon fa-regular fa-circle"></i> Registrar Marcas
              </a>

            </li>


            <li>
              <a class="treeview-item" href="canalesProductos">
                <i class="icon fa-regular fa-circle"></i> Registrar canales
              </a>
            </li>

            <li>
              <a class="treeview-item" href="descuentosProductos">
                <i class="icon fa-regular fa-circle"></i> Asignar descuentos
              </a>

            </li>


            <li>
              <a class="treeview-item" href="cuotas">
                <i class="icon fa-regular fa-circle"></i> Cuotas
              </a>

            </li>



          </ul>

        </li>

        <!-- =========================================================== -->

                 <!-- MENU DE CLIENTES -->
        <li class="treeview">

          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa-solid fa-user-tie"></i>
            <span class="app-menu__label">Clientes</span>
            <i class="treeview-indicator fa fa-angle-right"></i>

          </a>

          <ul class="treeview-menu">
            <li>
              <?php 
             echo '<a class="treeview-item" href="clientes">
                <i class="icon fa-regular fa-circle"></i> Registrar clientes
              </a>';
               ?>
              
            </li>

            <li>
              <a class="treeview-item" href="canales">
                <i class="icon fa-regular fa-circle"></i> Registrar canales
              </a>
            </li>

            <li>
              <a class="treeview-item" href="descuentos">
                <i class="icon fa-regular fa-circle"></i> Asignar descuentos
              </a>

            </li>

          </ul>

        </li>
 <!-- =========================================================== -->

         <!-- MENU DE SUCURSALES -->

        <li class="treeview">

          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-home"></i>
            <span class="app-menu__label">Sucursales</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>

          <ul class="treeview-menu">
            <li>
              <a class="treeview-item" href="sucursales">
                <i class="icon fa-regular fa-circle"></i> Registrar Sucursal
              </a>
            </li>

            <li>
              <a class="treeview-item" href="ciudades">
                <i class="icon fa-regular fa-circle"></i> Registrar Ciudad
              </a>
            </li>

          </ul>

        </li>

          <!-- =========================================================== -->

         <!-- MENU DE USUARIOS -->
        <li class="treeview">

          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-users"></i>
            <span class="app-menu__label">Usuarios</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>

          <ul class="treeview-menu">
            <li>
              <?php 
             echo '<a class="treeview-item" href="usuarios">
                <i class="icon fa-regular fa-circle"></i> Registrar Usuarios
              </a>';
               ?>
              
            </li>

            <li>
              <a class="treeview-item" href="perfiles">
                <i class="icon fa-regular fa-circle"></i> Registrar Perfil
              </a>
            </li>

            <li>
              <a class="treeview-item" href="asignarPerfiles">
                <i class="icon fa-regular fa-circle"></i> Asignar Permisos
              </a>

            </li>


             <li>
              <a class="treeview-item" href="funcionarios">
                <i class="icon fa-regular fa-circle"></i> Registrar funcionarios
              </a>

            </li>


          </ul>

        </li>

        <!-- =========================================================== -->

      </ul>
    </aside>