<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";
require_once "../controladores/formapagos.controlador.php";
require_once "../modelos/formapagos.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxVentas{

	public function ajaxCrearVentas(){

		$datos = array("txtnroVenta" => $this->txtnroVenta,
						"txtUsuario"=>$this->txtUsuario,
						"txtidSucursal"=>$this->txtidSucursal,
						"cmbClientes"=> $this->cmbClientes,
						"cmbFormapago" =>$this->cmbFormapago,
						"cmbTipoMovimiento"=>$this->cmbTipoMovimiento,
						"cmbTipoPago" => $this->cmbTipoPago,
						"txtcantidadCuota"=>$this->txtcantidadCuota,
						"txtFechaVencimiento"=>$this->txtFechaVencimiento,
						"txtproductos"=> $this->txtproductos,
						"txtMontoCuota"=> $this->txtMontoCuota,
						"txtpreciototal" =>$this->txtpreciototal,
						"txtFechaVenta" =>$this->txtFechaVenta,
						"cmbMetodopago"=>$this->cmbMetodopago,
						"txtidApertura"=>$this->txtidApertura,
						"txtidCaja"=>$this->txtidCaja,
						"avisoStock"=>$this->avisoStock,
						"txtpedidos"=>$this->txtpedidos,
						"txtTotal"=>$this->txtTotal);

			
				// var_dump($datos);
				// return;
				$guardar = ControladorVentas::ctrCrearVenta($datos);
				
				echo json_encode($guardar,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

	}


	public function ajaxMostrarDatosCodigoBarra(){

		$item="EST_ARTICULOS";
		$valor=$this->activo;
			
		$nombres = explode("/",$this->sucursal);
		$CODIGO_SUCURSAL=$nombres[0];
		$TOKEN_SUCURSAL=$nombres[1];
	
		if($this->variable=="C"){
			
			$item1="CODBARRA";
			$valor1=$this->CodigoBarra;
		}else{

			$token = explode("/",$this->CodigoBarra);
			$CODIGO_PRODUCTO=$token[0];
			$TOKEN_PRODUCTO=$token[1];

			$item1="TOKEN_PRODUCTO";
			$valor1=$TOKEN_PRODUCTO;

		}
		
		

		$item2="COD_SUCURSAL";
		$valor2=$CODIGO_SUCURSAL;
        $respuesta = ControladorVentas::ctrMostrarProductoCodigoBarra($item, $valor,$item1, $valor1,$item2, $valor2);
       
        echo json_encode($respuesta);
   
      	
	}

	public function ajaxMostrarDatosProductos(){

		$item="COD_CANAL";
		$valor=$this->codigocanal;
	

		$item1="ESTADO";
		$valor1=$this->activo;
		
		$tabla="canal_productos";
		$tabla1="detcanal_productos";
		$order="DESC_CANAL";
		$seleccionar=" DESC_CANAL, CANTIDAD_DESDE, CANTIDAD_HASTA ";

		
        $respuesta = ControladorVentas::ctrMostrarCanalProducto($tabla,$tabla1,$seleccionar, $item, $valor,$item1, $valor1,$order);
               
        echo json_encode($respuesta);
   
      	
	}

	public function ajaxMostrarDatosClientes(){

		$item="COD_CANAL";
		$valor=$this->codigocanal;
	

		$item1="ESTADO";
		$valor1=$this->activo;
		
		$tabla="canal";
		$tabla1="detcanal";
		$order="DESC_CANAL";
		$seleccionar=" DESCRIPCION_CANAL,DESC_CANAL,MONTO_DESDE,MONTO_HASTA ";

		
        $respuesta = ControladorVentas::ctrMostrarCanalProducto($tabla,$tabla1,$seleccionar, $item, $valor,$item1, $valor1,$order);
               
        echo json_encode($respuesta);
   
      	
	}


	public function ajaxBuscarCaja(){
	$nombres = explode("/",$this->token_caja);
		$codigocaja=$nombres[0];
	
		$item="COD_CAJA";
		$valor=$codigocaja;
		$select="NRO_FACTURA,NROTICKET";
        $respuesta = ControladorVentas::ctrMostrarCaja($item, $valor,$select);
        //echo '<pre>'; print_r($respuesta); echo '</pre>';
  	
        echo json_encode($respuesta);
   
      	
	}


	public function ajaxBuscarDatosVarios(){

    	$combosnuevos = json_decode($this->combosProductos, true);

    	$Subproductos="";
  					// echo '<pre>'; print_r($combosnuevos); echo '</pre>';

		if ($combosnuevos!="" && $combosnuevos!=null){
				  			
				  			//var_dump($galeria);
			foreach ($combosnuevos as $indice => $valor) {

				$nombres = explode("/",$valor["id"]);
				$cant=$valor["cantidad"];
								
				$codigoproducto=$nombres[0];

				$item="COD_PRODUCTO";
				$valor=$codigoproducto;

				$tabla="productos";
				$select="DESCRIPCION";
		
        		$combos = ControladorVentas::ctrMostrarCombos($tabla,$item, $valor,$select);

				$Subproductos.="<p class='dropdown-item'>".$combos["DESCRIPCION"].'- CANT.: '.$cant."</p>";
								//echo '<pre>'; print_r($Subproductos); echo '</pre>';

							
									}
						}


						echo $Subproductos;        	
	
	}

	public function ajaxDatosSeleccion(){

		
		$item=null;
		$valor=null;

		$tabla="canti_uso";
		if($this->cantidad==1){
			$select="CUOTA";
		}elseif($this->cantidad==2){
			$select="CUOTA,DESCUENTO";
		}elseif($this->cantidad==3){
			$select="CUOTA,DESCUENTO,AVISO_STOCK";
		}elseif($this->cantidad==4){
			$select="CUOTA,DESCUENTO,AVISO_STOCK,CANT_USUARIOS";

		}else{
			$select="*";
		}
		$select="CUOTA,DESCUENTO,AVISO_STOCK";
		$where=null;
		
        $respuesta = ModeloVarios::mdlConsultarColumnas($tabla,$item, $valor,$select,$where);

		echo json_encode($respuesta);
	}

	public function ajaxClonarVenta(){

			$nombres = explode("/",$this->sucursal);
			$TOKEN_SUCURSAL=$nombres[1];

			$item="TOKEN_SUCURSAL";
			$valor=$TOKEN_SUCURSAL;

			$item1="TOKEN_VENTA";
			$valor1=$this->token_venta;   

		 	$valor2 = $this->activo;
		 	$forma=$this->formapago;
		
        $Venta = ControladorVentas::ctrBuscarVenta($item,$valor, $item1, $valor1,$valor2,$forma);

		echo json_encode($Venta);

	}


	public function ajaxBuscarVenta(){


			$nombres = explode("/",$this->sucursal);
			$TOKEN_SUCURSAL=$nombres[1];

			$item="TOKEN_SUCURSAL";
			$valor=$TOKEN_SUCURSAL;
			
			$fechaInicial =  $this->txtfechaInicial;
			
			$fechaFinal=  $this->txtfechaFinal;       

		 	$valor1 = $this->activo;
			$UsuarioAnulo="";
		
        $Venta = ControladorVentas::ctrRangoFechasVenta( $item,$valor, $fechaInicial, $fechaFinal,$valor1);

        // var_dump($Venta[0]["COD_FACTURA"]);
        // return;
       
		if(count($Venta)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Venta as $key => $value) {		
		  	
	 		$MetodosPagosNuevo="";

	 		if($value["METODO_PAGO"]!=null){

			 $metodospagos = json_decode($value["METODO_PAGO"], true);
			 
			 foreach ($metodospagos as $keyes => $valores) {
			 	if ($valores["id_metodo"]!=null){
			 		$nombres = explode("/",$valores["id_metodo"]);
			 
				$token_formapagos=$nombres[1];
                 	$item = "TOKEN_FORMAPAGO";
					$valor =$token_formapagos;
		
					$respuesta = ControladorFormaPagos::ctrMostrarFormapago($item, $valor,"ESTADO_FORMA", 1);

                  $MetodosPagosNuevo.= "<div class='badge badge-secondary mx-1'>".$respuesta["DESCRIPCION_FORMA"].': '.number_format($valores["entrega"],0,',','.').'<br>Transacción N°: '.$valores["nrotransaccion"]."</div>";
			 	}else{
			 	$MetodosPagosNuevo= "<div class='badge badge-secondary mx-1'>No hay métodos de pagos</div>";
			 }
			 	
                 
              }

			 }else{
			 	$MetodosPagosNuevo= "<div class='badge badge-secondary mx-1'>No hay métodos de pagos</div>";
			 }

			/*=============================================
			ACCIONES
			=============================================*/

	$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm clonarVenta' title='Clonar Venta' formapago='".$value["FORMA_PAGO"]."' tokenVenta='".$value["TOKEN_VENTA"]."' CodigoVenta='".$value["COD_FACTURA"]."' ><i class='fa-solid fa-clone'></i></button><button class='btn btn-info btn-sm detalleVenta' data-toggle='modal' data-target='#ModalDetVenta' title='Ver Detalle venta'  tokenVenta='".$value["TOKEN_VENTA"]."'CodigoVenta='".$value["COD_FACTURA"]."' ><i class='fa-solid fa-info'></i></button><button class='btn btn-danger btn-sm eliminarVenta' title='Anular Venta' tokenVenta='".$value["TOKEN_VENTA"]."' tokenSucursal='".$value["tokenSucursal"]."' CodigoVenta='".$value["COD_FACTURA"]."' estado='".$value["ESTADO_FACTURA"]."'><i class='fa-solid fa-ban'></i></button><button class='btn btn-primary btn-sm imprimirVenta' title='Imprimir Venta' formapago='".$value["FORMA_PAGO"]."' tokenVenta='".$value["COD_FACTURA"]."/".$value["TOKEN_VENTA"]."' CodigoVenta='".$value["COD_FACTURA"]."'><i class='fa-solid fa-print'></i></button></div>";

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["NRO_MOVIMIENTO"].'",
						"'.$value["FECHA_VENTA"].'",
						"'.number_format($value["TOTAL_VENTA"],0,',','.').'",
						"'.$value["FORMA_PAGO"].'",
						"'.$value["TIPO_MOVIMIENTO"].'",
						"'.$MetodosPagosNuevo.'",
						"'.$value["CLIENTE"].'",
						"'.$value["SUCURSAL"].'",
						"'.$value["USUARIO"].'"
						
				],';
				
				
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;


	}


	public function ajaxBuscarComprasAnulada(){


			$nombres = explode("/",$this->sucursal);
			$TOKEN_SUCURSAL=$nombres[1];

			$item="TOKEN_SUCURSAL";
			$valor=$TOKEN_SUCURSAL;
			
			$fechaInicial =  $this->txtfechaInicial;
			
			$fechaFinal=  $this->txtfechaFinal;       

		 	$valor1 = $this->activo;
	
		
        $Compras = ControladorCompras::ctrRangoFechasCompra( $item,$valor, $fechaInicial, $fechaFinal,$valor1);
       
		if(count($Compras)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Compras as $key => $value) {		


	 			$item = "COD_USUARIO";
					$valor = $value["USUARIO_ANULADO"];

					$respuesta = ControladorUsuarios::ctrMostrarUsuario($item, $valor);

					$UsuarioAnulo=$respuesta["USUARIO"];	

		  	
			/*=============================================
			ACCIONES
			=============================================*/

			$MetodosPagosNuevo="";
	 		if($value["METODO_PAGO"]!=null){

			 $metodospagos = json_decode($value["METODO_PAGO"], true);
			 
			 foreach ($metodospagos as $keyes => $valores) {


			 	if ($valores["id_metodo"]!=null){
			 		$nombres = explode("/",$valores["id_metodo"]);
			 
				$token_formapagos=$nombres[1];
                 	$item = "TOKEN_FORMAPAGO";
					$valor =$token_formapagos;
		
					$respuesta = ControladorFormaPagos::ctrMostrarFormapago($item, $valor,"ESTADO_FORMA",1);

                  $MetodosPagosNuevo.= "<div class='badge badge-secondary mx-1'>".$respuesta["DESCRIPCION_FORMA"].': '.number_format($valores["entrega"],0,',','.').'<br>Transacción N°: '.$valores["nrotransaccion"]."</div>";
			 	}else{
			 	$MetodosPagosNuevo= "<div class='badge badge-secondary mx-1'>No hay métodos de pagos</div>";
			 }
			 	
                 
              }

			 }else{
			 	$MetodosPagosNuevo= "<div class='badge badge-secondary mx-1'>No hay métodos de pagos</div>";
			 }

			$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm clonarCompra' title='Clonar Compra' tokenCompra='".$value["TOKEN_COMPRA"]."' formapago='".$value["FORMA_PAGO"]."' CodigoCompra='".$value["COD_COMPRA"]."' ><i class='fas fa-clone text-white'></i></button><button class='btn btn-info btn-sm detalleCompra' data-toggle='modal' data-target='#ModalDetCompra' title='Ver Detalle Compra' tokenCompra='".$value["TOKEN_COMPRA"]."' CodigoCompra='".$value["COD_COMPRA"]."' ><i class='fa fa-info text-white'></i></button><button class='btn btn-success btn-sm eliminarCompra' title='Recuperar Compra' tokenCompra='".$value["TOKEN_COMPRA"]."' tokenSucursal='".$value["tokenSucursal"]."' CodigoCompra='".$value["COD_COMPRA"]."' estado='".$value["ESTADO_COMPRA"]."'><i class='fa fa-recycle'></i></button></div>";

				
			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["NROCOMPRA"].'",
						"'.$value["FECHA_COMPRA"].'",
						"'.$value["FECHA_ANULADA"].'",
						"'.number_format($value["TOTAL_COMPRA"],0,',','.').'",
						"'.$value["FORMA_PAGO"].'",
						"'.$value["TIPO_PAGO"].'",
						"'.$MetodosPagosNuevo.'",
						"'.$value["NOMBRE"].'",
						"'.$value["SUCURSAL"].'",
						"'.$value["USUARIO"].'",
						"'.$UsuarioAnulo.'",
						"'.$value["DESCRIPCION_ANULACION"].'"
						
				],';
				

		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}
	


	public function ajaxBuscarDetVenta(){


			$nombres = explode("/",$this->sucursal);
			$TOKEN_SUCURSAL=$nombres[1];

			$item="TOKEN_SUCURSAL";
			$valor=$TOKEN_SUCURSAL;

			$item1="TOKEN_VENTA";
			$valor1=$this->token_venta;   

		 	$valor2 = $this->activo;
		
        $Venta = ModelosVentas::mdlBusquedaDetalle($item,$valor, $item1, $valor1,$valor2);

		if(count($Venta)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Venta as $key => $value) {		
		  	
			/*=============================================
			ACCIONES
			=============================================*/
			$MetodosPagosNuevo="";
	 		
	 		if($value["METODO_PAGO"]!=null){

			 $metodospagos = json_decode($value["METODO_PAGO"], true);
			 
			 foreach ($metodospagos as $keyes => $valores) {
			 	if ($valores["id_metodo"]!=null){
			 		$nombres = explode("/",$valores["id_metodo"]);
			 
				$token_formapagos=$nombres[1];
                 	$item = "TOKEN_FORMAPAGO";
					$valor =$token_formapagos;
		
					$respuesta = ControladorFormaPagos::ctrMostrarFormapago($item, $valor,"ESTADO_FORMA",1);

                  $MetodosPagosNuevo.= "<div class='badge badge-secondary mx-1'>".$respuesta["DESCRIPCION_FORMA"].': '.number_format($valores["entrega"],0,',','.').'<br>Transacción N°: '.$valores["nrotransaccion"]."</div>";
			 	}else{
			 	$MetodosPagosNuevo= "<div class='badge badge-secondary mx-1'>No hay métodos de pagos</div>";
			 }
			 	
                 
              }

			 }else{
			 	$MetodosPagosNuevo= "<div class='badge badge-secondary mx-1'>No hay métodos de pagos</div>";
			 }

	$Productos = str_replace(array(',', '"'), '', $value["DESCRIPCION"]);
			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$value["NRO_MOVIMIENTO"].'",
						"'.$value["FECHA_VENTA"].'",
						"'.$value["FORMA_PAGO"].'",
						"'.$value["TIPO_MOVIMIENTO"].'",
						"'.$MetodosPagosNuevo.'",
						"'.$value["CLIENTE"].'",
						"'.$value["CODBARRA"].'",
						"'.$Productos.'",
						"'.$value["CANTIDAD"].'",
						"'.number_format($value["PRECIO_UNI"],0,',','.').'",
						"'.number_format($value["PRECIO_NETO"],0,',','.').'",
						"'.$value["DESCUENTO"].'",
						"'.$value["USUARIO"].'",
						"'.$value["STOCK_ANTERIOR"].'",
						"'.$value["SUCURSAL"].'"
						
				],';
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}


	

	public function ajaxAnularVenta(){

			$nombres = explode("/",$this->tokenSucursal);
			$CODIGO_SUCURSAL=$nombres[0];

			$usuarios = explode("/",$this->usuario);
			$usuario=$usuarios[0];

		
					$datos = array("token_venta" => $this->token_venta,
							"estado"=>$this->estado,
							"usuario"=>$usuario,
							"descripcion"=> $this->descripcion,
							"codigoSucursal"=> $CODIGO_SUCURSAL);



				$respuesta = ControladorVentas::ctrAnularVenta($datos);
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();
	
	}



			
	/*=============================================
	MOSTRAR METODO DE PAGO
	=============================================*/	

	public function ajaxMostrarMetodoPago(){

		$item = null;
		$valor = null;

		$metodoPago = ControladorFormaPagos::ctrMostrarFormapago($item, $valor,"ESTADO_FORMA",1);

		echo json_encode($metodoPago);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}


	/*=============================================
	MOSTRAR VENTA CABECERA TICKET
	=============================================*/	

	public function ajaxMostrarCabeceraTicket(){

		$item = "COD_FACTURA";
		$valor = $this->codVenta;

		// var_dump($valor);
		// return;

		$cabeceraTicket = ControladorVentas::ctrMostrarCabeceraTicket($item, $valor);

		echo json_encode($cabeceraTicket);//se imprime para que se pueda ver en el js

	}

	/*=============================================
	MOSTRAR METODO DE PAGO X ID
	=============================================*/	

	public function ajaxMostrarMetodoPagoId(){

		$nombres = explode("/",$this->metodoPagoId);
		$CODIGO_PAGO=$nombres[0];

		$item = "COD_FORMAPAGO";
		$valor = $CODIGO_PAGO;

		// var_dump($item);
		// var_dump($valor);
		// return;
		$metodoPago = ControladorVentas::ctrMostrarMetodoPagoId($item, $valor,"ESTADO_FORMA",1);

		echo json_encode($metodoPago);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}

	
}




/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_POST["txtnroVenta"])){

	$Guardar = new AjaxVentas();
	$Guardar -> txtnroVenta = $_POST["txtnroVenta"];
	$Guardar -> txtUsuario = $_POST["txtUsuario"];
	$Guardar -> txtidSucursal = $_POST["txtidSucursal"];
	$Guardar -> txtproductos = $_POST["txtproductos"];
	$Guardar -> cmbClientes = $_POST["cmbClientes"];
	$Guardar -> txtpreciototal = $_POST["txtpreciototal"];
	$Guardar -> cmbFormapago = $_POST["cmbFormapago"];
	$Guardar -> cmbTipoMovimiento = $_POST["cmbTipoMovimiento"];
	$Guardar -> txtcantidadCuota = $_POST["txtcantidadCuota"];
	$Guardar -> txtFechaVencimiento = $_POST["txtFechaVencimiento"];
	$Guardar -> txtMontoCuota = $_POST["txtMontoCuota"];
	$Guardar -> cmbMetodopago = $_POST["cmbMetodopago"];
	$Guardar -> cmbTipoPago = $_POST["cmbTipoPago"];
	$Guardar -> txtFechaVenta = $_POST["txtFechaVenta"];
	$Guardar -> txtidApertura = $_POST["txtidApertura"];
	$Guardar -> txtidCaja = $_POST["txtidCaja"];
	$Guardar -> txtpedidos = $_POST["txtpedidos"];
	$Guardar -> avisoStock = $_POST["avisoStock"];
	$Guardar -> txtTotal = $_POST["txtTotal"];
	$Guardar -> ajaxCrearVentas();


}

/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_GET["txtfechaInicial"])){

	$consultar = new AjaxVentas();
	$consultar -> txtfechaInicial = $_GET["txtfechaInicial"];
	$consultar -> txtfechaFinal = $_GET["txtfechaFinal"];
	$consultar -> activo = $_GET["activo"];
	$consultar -> sucursal = $_GET["sucursal"];
	
	if($_GET["activo"]==1){
		$consultar -> ajaxBuscarVenta();
	}else{
		$consultar -> ajaxBuscarVentasAnulada();
	}


}

/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_POST["token_Venta"])){

	$consultar = new AjaxVentas();
	$consultar -> token_venta = $_POST["token_Venta"];
	$consultar -> sucursal = $_POST["sucursal"];
	$consultar -> activo = $_POST["activo"];
	$consultar -> formapago = $_POST["forma"];
	$consultar -> ajaxClonarVenta();


}


/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_GET["token_ventas"])){

	$consultar = new AjaxVentas();
	$consultar -> token_venta = $_GET["token_ventas"];
	$consultar -> sucursal = $_GET["sucursal"];
	$consultar -> activo = $_GET["activo"];
	$consultar -> ajaxBuscarDetVenta();


}


/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_POST["tokenVenta"])){

	$consultar = new AjaxVentas();
	$consultar -> token_venta = $_POST["tokenVenta"];
	$consultar -> estado = $_POST["estado"];
	$consultar -> usuario = $_POST["usuario"];
	$consultar -> descripcion = $_POST["descripcion"];
	$consultar -> tokenSucursal = $_POST["tokenSucursal"];
	$consultar -> ajaxAnularVenta();


}

// if(isset($_POST["token_producto"]))
// {

// 	$editar = new AjaxVentas();
// 	$editar -> token_producto = $_POST["token_producto"];
// 	$editar -> sucursal =$_POST["sucursal"];
// 	$editar -> activo = $_POST["activo"];
// 	$editar -> ajaxMostrarDatos();

// }


/*================================================
	MOSTRAR METODO DE PAGO
==================================================*/
if(isset($_POST["item"])){

	$mostrar = new AjaxVentas();
	$mostrar -> item = $_POST["item"];
	$mostrar -> ajaxMostrarMetodoPago();

}


/*================================================
	MOSTRAR METODO DE PAGO
==================================================*/
if(isset($_POST["cant"])){

	$mostrar = new AjaxVentas();
	$mostrar -> cantidad = $_POST["cant"];
	$mostrar -> ajaxDatosSeleccion();

}


/*================================================
	MOSTRAR METODO DE PAGO
==================================================*/
if(isset($_POST["token_caja"])){

	$mostrar = new AjaxVentas();
	$mostrar -> token_caja = $_POST["token_caja"];
	$mostrar -> ajaxBuscarCaja();

}


if(isset($_POST["CodigoBarra"]))
{

	$codigobarra = new AjaxVentas();
	$codigobarra -> CodigoBarra = $_POST["CodigoBarra"];
	$codigobarra -> sucursal =$_POST["sucursal"];
	$codigobarra -> activo = $_POST["activo"];
	$codigobarra -> variable = $_POST["variable"];
	$codigobarra -> ajaxMostrarDatosCodigoBarra();

}

if(isset($_POST["canalProductos"]))
{

	$canal = new AjaxVentas();
	$canal -> codigocanal = $_POST["canalProductos"];
	$canal -> activo = $_POST["activo"];
	$canal -> ajaxMostrarDatosProductos();

}


if(isset($_POST["canalClientes"]))
{

	$canal = new AjaxVentas();
	$canal -> codigocanal = $_POST["canalClientes"];
	$canal -> activo = $_POST["activo"];
	$canal -> ajaxMostrarDatosClientes();

}

/*================================================
	MOSTRAR VENTA CABECERA TICKET
==================================================*/
if(isset($_POST["txtCodVenta"])){

	$mostrar = new AjaxVentas();
	$mostrar -> codVenta = $_POST["txtCodVenta"];
	$mostrar -> ajaxMostrarCabeceraTicket();

}

/*================================================
	MOSTRAR METODO DE PAGO X ID
==================================================*/
if(isset($_POST["metodoPagoId"])){

	$mostrar = new AjaxVentas();
	$mostrar -> metodoPagoId = $_POST["metodoPagoId"];
	$mostrar -> ajaxMostrarMetodoPagoId();

}

