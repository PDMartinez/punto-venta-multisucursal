<?php
require_once "../controladores/formapagos.controlador.php";
require_once "../modelos/formapagos.modelo.php";
require_once "../controladores/compras.controlador.php";
require_once "../modelos/compras.modelo.php";
require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursales.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxCompras{

	public function ajaxCrearCompras(){

		$datos = array("txtnrocompra" => $this->txtnrocompra,
						"txtUsuario"=>$this->txtUsuario,
						"txtidSucursal"=>$this->txtidSucursal,
						"cmbproveedor"=> $this->cmbproveedor,
						"cmbFormapago" =>$this->cmbFormapago,
						"cmbTipoMovimiento"=>$this->cmbTipoMovimiento,
						"cmbTipoPago" => $this->cmbTipoPago,
						"txtcantidadCuota"=>$this->txtcantidadCuota,
						"txtFechaVencimiento"=>$this->txtFechaVencimiento,
						"txtproductos"=> $this->txtproductos,
						"txtMontoCuota"=> $this->txtMontoCuota,
						"txtpreciototal" =>$this->txtpreciototal,
						"txtFechaCompra" =>$this->txtFechaCompra,
						"cmbMetodopago"=>$this->cmbMetodopago);

					 // var_dump($datos);
				  // return;
				$guardar = ControladorCompras::ctrCrearCompra($datos);
				
				echo json_encode($guardar,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

	}

public function ajaxMostrarDatos(){

		$item="EST_ARTICULOS";
		$valor=$this->activo;
			
		$nombres = explode("/",$this->sucursal);
		$TOKEN_SUCURSAL=$nombres[1];

		$item1="TIPO_PRODUCTO";
		$valor1=$this->tipo_producto;

		$item2="TOKEN_SUCURSAL";
		$valor2=$TOKEN_SUCURSAL;

		$nombres = explode("/",$this->token_producto);
		
		$item3="TOKEN_PRODUCTO";
		$valor3=$nombres[1];

		$var=0;
        $respuesta = ControladorCompras::ctrMostrarProducto($item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3,$var);

		echo json_encode($respuesta);
}

public function ajaxClonarCompra(){

			$nombres = explode("/",$this->sucursal);
			$TOKEN_SUCURSAL=$nombres[1];

			$item="TOKEN_SUCURSAL";
			$valor=$TOKEN_SUCURSAL;

			$item1="TOKEN_COMPRA";
			$valor1=$this->token_Compra;   

		 	$valor2 = $this->activo;
		 	$forma=$this->formapago;
		
        $Compra = ControladorCompras::ctrBuscarCompra($item,$valor, $item1, $valor1,$valor2,$forma);

		echo json_encode($Compra);

      }


public function ajaxBuscarCompra(){


			$nombres = explode("/",$this->sucursal);
			$TOKEN_SUCURSAL=$nombres[1];

			$item="TOKEN_SUCURSAL";
			$valor=$TOKEN_SUCURSAL;
			
			$fechaInicial =  $this->txtfechaInicial;
			
			$fechaFinal=  $this->txtfechaFinal;       

		 	$valor1 = $this->activo;
			$UsuarioAnulo="";
		
        $Compra = ControladorCompras::ctrRangoFechasCompra( $item,$valor, $fechaInicial, $fechaFinal,$valor1);
       
		if(count($Compra)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Compra as $key => $value) {		
		  	
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
	$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm clonarCompra' title='Clonar Compra' formapago='".$value["FORMA_PAGO"]."' tokenCompra='".$value["TOKEN_COMPRA"]."' CodigoCompra='".$value["COD_COMPRA"]."' ><i class='fas fa-clone text-white'></i></button><button class='btn btn-info btn-sm detalleCompra' data-toggle='modal' data-target='#ModalDetCompra' title='Ver Detalle Compra'  tokenCompra='".$value["TOKEN_COMPRA"]."' CodigoCompra='".$value["COD_COMPRA"]."' ><i class='fa fa-info text-white'></i></button><button class='btn btn-danger btn-sm eliminarCompra' title='Anular Compra' tokenCompra='".$value["TOKEN_COMPRA"]."' tokenSucursal='".$value["tokenSucursal"]."' CodigoCompra='".$value["COD_COMPRA"]."' estado='".$value["ESTADO_COMPRA"]."'><i class='fa fa-ban'></button></div>";	

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["NROCOMPRA"].'",
						"'.$value["FECHA_COMPRA"].'",
						"'.number_format($value["TOTAL_COMPRA"],0,',','.').'",
						"'.$value["FORMA_PAGO"].'",
						"'.$value["TIPO_PAGO"].'",
						"'.$MetodosPagosNuevo.'",
						"'.$value["NOMBRE"].'",
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
		
					$respuesta = ControladorFormaPagos::ctrMostrarFormapago($item, $valor,"ESTADO_FORMA", 1);

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
	


public function ajaxBuscarDetRemision(){


			$nombres = explode("/",$this->sucursal);
			$TOKEN_SUCURSAL=$nombres[1];

			$item="TOKEN_SUCURSAL";
			$valor=$TOKEN_SUCURSAL;

			$item1="TOKEN_COMPRA";
			$valor1=$this->token_compra;   

		 	$valor2 = $this->activo;
		
        $Compra = ModelosCompras::mdlBusquedaDetalle($item,$valor, $item1, $valor1,$valor2);

		if(count($Compra)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Compra as $key => $value) {		
		  	
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
		
					$respuesta = ControladorFormaPagos::ctrMostrarFormapago($item, $valor,"ESTADO_FORMA", 1);

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
						"'.$value["NROCOMPRA"].'",
						"'.$value["FECHA_COMPRA"].'",
						"'.$value["NRORECIBO"].'",
						"'.$value["FORMA_PAGO"].'",
						"'.$value["TIPO_PAGO"].'",
						"'.$MetodosPagosNuevo.'",
						"'.$value["NOMBRE"].'",
						"'.$value["CODBARRA"].'",
						"'.$Productos.'",
						"'.$value["CANTIDAD"].'",
						"'.number_format($value["PREC_UNITARIO"],0,',','.').'",
						"'.number_format($value["PREC_NETO"],0,',','.').'",
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


	

		public function ajaxAnularCompra(){

			$nombres = explode("/",$this->tokenSucursal);
			$CODIGO_SUCURSAL=$nombres[0];

			$usuarios = explode("/",$this->usuario);
			$usuario=$usuarios[0];

		
					$datos = array("token_compra" => $this->token_compra,
							"estado"=>$this->estado,
							"usuario"=>$usuario,
							"descripcion"=> $this->descripcion,
							"codigoSucursal"=> $CODIGO_SUCURSAL);



				$respuesta = ControladorCompras::ctrAnularCompra($datos);
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();
			}



			
	/*=============================================
	MOSTRAR METODO DE PAGO
	=============================================*/	

	public function ajaxMostrarMetodoPago(){

		$item = null;
		$valor = null;

		$metodoPago = ControladorFormaPagos::ctrMostrarFormapago($item, $valor,"ESTADO_FORMA", 1);

		echo json_encode($metodoPago);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}

	
}


/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_POST["txtnrocompra"])){

	$Guardar = new AjaxCompras();
	$Guardar -> txtnrocompra = $_POST["txtnrocompra"];
	$Guardar -> txtUsuario = $_POST["txtUsuario"];
	$Guardar -> txtidSucursal = $_POST["txtidSucursal"];
	$Guardar -> txtproductos = $_POST["txtproductos"];
	$Guardar -> cmbproveedor = $_POST["cmbproveedor"];
	$Guardar -> txtpreciototal = $_POST["txtpreciototal"];
	$Guardar -> cmbFormapago = $_POST["cmbFormapago"];
	$Guardar -> cmbTipoMovimiento = $_POST["cmbTipoMovimiento"];
	$Guardar -> txtcantidadCuota = $_POST["txtcantidadCuota"];
	$Guardar -> txtFechaVencimiento = $_POST["txtFechaVencimiento"];
	$Guardar -> txtMontoCuota = $_POST["txtMontoCuota"];
	$Guardar -> cmbMetodopago = $_POST["cmbMetodopago"];
	$Guardar -> cmbTipoPago = $_POST["cmbTipoPago"];
	$Guardar -> txtFechaCompra = $_POST["txtFechaCompra"];
	$Guardar -> ajaxCrearCompras();


}

/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_GET["txtfechaInicial"])){

	$consultar = new AjaxCompras();
	$consultar -> txtfechaInicial = $_GET["txtfechaInicial"];
	$consultar -> txtfechaFinal = $_GET["txtfechaFinal"];
	$consultar -> activo = $_GET["activo"];
	$consultar -> sucursal = $_GET["sucursal"];
	

	if($_GET["activo"]==1){
		$consultar -> ajaxBuscarCompra();
	}else{
		$consultar -> ajaxBuscarComprasAnulada();
	}


}

/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_POST["token_Compra"])){

	$consultar = new AjaxCompras();
	$consultar -> token_Compra = $_POST["token_Compra"];
	$consultar -> sucursal = $_POST["sucursal"];
	$consultar -> activo = $_POST["activo"];
	$consultar -> formapago = $_POST["forma"];
	$consultar -> ajaxClonarCompra();


}


/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_GET["token_compras"])){

	$consultar = new AjaxCompras();
	$consultar -> token_compra = $_GET["token_compras"];
	$consultar -> sucursal = $_GET["sucursal"];
	$consultar -> activo = $_GET["activo"];
	$consultar -> ajaxBuscarDetRemision();


}


/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_POST["tokenCompra"])){

	$consultar = new AjaxCompras();
	$consultar -> token_compra = $_POST["tokenCompra"];
	$consultar -> estado = $_POST["estado"];
	$consultar -> usuario = $_POST["usuario"];
	$consultar -> descripcion = $_POST["descripcion"];
	$consultar -> tokenSucursal = $_POST["tokenSucursal"];
	$consultar -> ajaxAnularCompra();


}

if(isset($_POST["token_producto"]))
{

	$editar = new AjaxCompras();
	$editar -> token_producto = $_POST["token_producto"];
	$editar -> sucursal =$_POST["sucursal"];
	$editar -> activo = $_POST["activo"];
	$editar -> tipo_producto = $_POST["tipo_producto"];
	$editar -> ajaxMostrarDatos();

}


/*================================================
	MOSTRAR METODO DE PAGO
==================================================*/
if(isset($_POST["item"])){

	$mostrar = new AjaxCompras();
	$mostrar -> item = $_POST["item"];
	$mostrar -> ajaxMostrarMetodoPago();

}