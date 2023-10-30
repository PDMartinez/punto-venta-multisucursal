<?php

require_once "../controladores/formapagos.controlador.php";
require_once "../modelos/formapagos.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

require_once "../controladores/cuentasPagar.controlador.php";
require_once "../modelos/cuentasPagar.modelo.php";

class AjaxCuentasPagar{

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
	MOSTRAR CUENTAS A PAGAR
	=============================================*/	

	public function ajaxMostrarCuentasPagar(){

		$nombres = explode("/",$this->codCuenta);
		$COD_CUENTA = $nombres[0];

		// var_dump($COD_CUENTA);
		// return;

		$item = "COD_CUENTA";
		$valor = $COD_CUENTA;

		$mostrarCuenta = ControladorCuentasPagar::ctrMostrarCuentasPagar($item, $valor);

		echo json_encode($mostrarCuenta);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}

	/*=============================================
	MOSTRAR DETALLES DE CUENTAS A PAGAR
	=============================================*/	

	public function ajaxMostrarDetCuentasPagar(){

		$nombres = explode("/",$this->codCuentaDet);
		$COD_CUENTA = $nombres[0];

		// var_dump($COD_CUENTA);
		// return;

		$item = "dcp.COD_CUENTA";
		$valor = $COD_CUENTA;

		$mostrarCuentaDet = ControladorCuentasPagar::ctrMostrarDetCuentasPagar($item, $valor);

		echo json_encode($mostrarCuentaDet);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}

	/*=============================================
	MOSTRAR DETALLES DE CUENTAS A PAGAR
	=============================================*/	

	public function ajaxMostrarDetCuentasPagar1(){

		$item = "TOKEN_DETCTASPAGAR";
		$valor = $this->codCuentaDet;

		$mostrarCuentaDet = ControladorCuentasPagar::ctrMostrarDetCuentasPagar1($item, $valor);

		echo json_encode($mostrarCuentaDet);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}

	/*=============================================
	CONSULTA PARA OBTENER LA DIFERENCIA DE FECHA
	=============================================*/	

	public function ajaxMostrarDiferenciaFecha(){

		$nombres = explode("/",$this->codCuentaFecha);
		$COD_CUENTA=$nombres[0];

		$codCuentaProveedor = $COD_CUENTA;

		$item="cp.COD_CUENTA";
        $valor=$codCuentaProveedor;
        $where="WHERE cp.COD_CUENTA = ".$valor;

		// var_dump($valor);
		// return;

		$mostrarCuentaDet = ControladorCuentasPagar::ctrMostrarDiferenciaFecha($item, $valor, $where);

		echo json_encode($mostrarCuentaDet);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}


	/*=============================================
	MOSTRAR CUENTAS A PAGAR CON INNER
	=============================================*/	

	// public function ajaxMostrarCuentaPagarInner(){

	// 	$item1 = "COD_SUCURSAL";
	// 	$valor1 = $this->codCuenta;

	// 	$item2 = "COD_PROVEEDOR";
	// 	$valor2 = $this->codSucursal;

	// 	$tabla1="ctaspagar";
	// 	$tabla2="compras";

	// 	$order="COD_CUENTA";

	// 	$mostrarCuentaInner = ControladorCuentasPagar::ctrMostrarCuentaPagarInner($item1, $valor1, $item2, $valor2, $tabla1, $tabla2, $order);

	// 	echo json_encode($mostrarCuentaInner);

	// }

	/*=============================================
	GUARDAR PAGO DE CUENTAS
	=============================================*/

	public function ajaxGuardarPago(){
		
		$datos = array("codCuenta"=>$this->codCuenta,
			"codUsuario"=>$this->codUsuario,
			"pago"=>$this->pago,
			"fechaVenc" =>$this->fechaVenc,
			"saldo"=>$this->saldo,
			"fechaPago"=> $this->fechaPago,
			"estadoCuenta"=>$this->estadoCuenta,
			"nroMovimiento"=>$this->nroMovimiento,
			"nroRecibo"=>$this->nroRecibo,
			"tipoRecibo"=> $this->tipoRecibo,
			"formaPago"=>$this->formaPago,
			"tipoVenta"=>$this->tipoVenta);
		// var_dump($datos);
		// return;
		$respuesta = ControladorCuentasPagar::ctrCrearPago($datos);
				
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
		die();


	}

	/*=============================================
	MOSTRAR ULTIMO NUMERO DE RECIBO
	=============================================*/	

	// public function ajaxMostrarNroRecibo(){

	// 	$item = "TIPO_RECIBO";
	// 	$valor = $this->tipoRecibo;

	// 	$mostrarNroRecibo = ControladorCuentasPagar::ctrMostrarNroRecibo($item, $valor);

	// 	echo json_encode($mostrarNroRecibo);

	// }

	/*=============================================
	MOSTRAR HISTORIAL DE PAGO
	=============================================*/	

	// public function ajaxMostrarHistorialPago(){

	// 	$item = "dcp.COD_CUENTA";
	// 	$valor = substr($this->codCuentaDetUsuario, 32, 99999999999999999);

	// 	$tabla1 = "detctaspagar";
	// 	$tabla2 = "usuarios";
	// 	$tabla3 = "funcionarios";
	// 	$order = "dcp.COD_CUENTA ASC";

	// 	$mostrarCuentaDet = ControladorCuentasPagar::ctrMostrarHistorialPago($tabla1, $tabla2, $tabla3, $item, $valor, $order);

	// 	echo json_encode($mostrarCuentaDet);

	// }

	/*=============================================
	MOSTRAR PROVEEDORES CON CUENTA A PAGAR
	=============================================*/

	public function ajaxMostrarProveedorCuentaPagar(){

		$nombres = explode("/",$this->codCuentaProveedor);
		$COD_CUENTA=$nombres[0];

		$codCuentaProveedor = $COD_CUENTA;

		$item="cp.COD_CUENTA";
        $valor=$codCuentaProveedor;
        $where="WHERE cp.COD_CUENTA = ".$valor;

		$mostrarCuentaProveedor = ControladorCuentasPagar::ctrMostrarProveedorCuentaPagar($item, $valor, $where);

		echo json_encode($mostrarCuentaProveedor);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}

	/*=============================================
	MOSTRAR CUENTAS CABECERA
	=============================================*/	

	public function ajaxMostrarCuentasCabecera(){

		$nombres = explode("/",$this->codCuentaCabecera);
		$COD_CUENTA=$nombres[0];

		$item = "COD_CUENTA";
		$valor = $COD_CUENTA;

		// var_dump($valor);
		$mostrarCuenta = ControladorCuentasPagar::ctrMostrarCuentasCabecera($item, $valor);

		echo json_encode($mostrarCuenta);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}

	/*=============================================
	ANULAR PAGO DE CUENTAS
	=============================================*/

	public function ajaxAnularPago(){
		
		$datos = array("codCuenta" => $this->codCuenta,
			"codUsuario" => $this->codUsuario,
			"pago" => $this->pago,
			"fechaVenc" =>$this->fechaVenc,
			"saldo" => $this->saldo,
			"fechaPago" => $this->fechaPago,
			"estadoCuenta" => $this->estadoCuenta,
			"formaPago" => $this->formaPago,
			"nroMovimiento" => $this->nroMovimiento,
			"nroRecibo" => $this->nroRecibo,
			"tipoRecibo" => $this->tipoRecibo,
			"agruparAnulado" => $this->agruparAnulado,
			"detMovimiento" => $this->detMovimiento,
			"tokenCuentaDet" => $this->tokenCuentaDet);
		// var_dump($datos);
		// return;
		$respuesta = ControladorCuentasPagar::ctrAnularPago($datos);
				
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
		die();


	}

	/*=============================================
	MODIFICAR COMENTARIO
	=============================================*/	

	public function ajaxModificarComentario(){

		$nombres = explode("/",$this->codCuentaComentario);
		$COD_CUENTA = $nombres[0];

		$item1 = "COD_CUENTA";
		$valor1 = $COD_CUENTA;

		$item2 = "OBSERVACIONES";
		$valor2 = $this->comentario;

		// var_dump($valor1);
		// var_dump($valor2);

		$metodoPago = ControladorCuentasPagar::ctrModificarComentario($item1, $valor1, $item2, $valor2);

		echo json_encode($metodoPago);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}


}

///////////////////////////////////////////////////////////////////////


/*================================================
	MOSTRAR METODO DE PAGO
==================================================*/
if(isset($_POST["item"])){

	$mostrar = new AjaxCuentasPagar();
	$mostrar -> item = $_POST["item"];
	$mostrar -> ajaxMostrarMetodoPago();

}

/*================================================
	MOSTRAR CUENTAS A PAGAR
==================================================*/
if(isset($_POST["codCuenta"])){

	$mostrar = new AjaxCuentasPagar();
	$mostrar -> codCuenta = $_POST["codCuenta"];
	$mostrar -> ajaxMostrarCuentasPagar();

}

/*================================================
	MOSTRAR DETALLES DE CUENTAS A PAGAR
==================================================*/
if(isset($_POST["codCuentaDet"])){

	$mostrar = new AjaxCuentasPagar();
	$mostrar -> codCuentaDet = $_POST["codCuentaDet"];
	$mostrar -> ajaxMostrarDetCuentasPagar();

}

/*================================================
	MOSTRAR DETALLES DE CUENTAS A PAGAR1
==================================================*/
if(isset($_POST["codCuentaDet1"])){

	$mostrar = new AjaxCuentasPagar();
	$mostrar -> codCuentaDet = $_POST["codCuentaDet1"];
	$mostrar -> ajaxMostrarDetCuentasPagar1();

}

/*================================================
	MOSTRAR DIFERENCIA FECHA
==================================================*/
if(isset($_POST["codCuentaFecha"])){

	$mostrar = new AjaxCuentasPagar();
	$mostrar -> codCuentaFecha = $_POST["codCuentaFecha"];
	$mostrar -> ajaxMostrarDiferenciaFecha();

}

/*================================================
	MOSTRAR CUENTAS A PAGAR CON INNER JOIN
==================================================*/
// if(isset($_POST["codSucursal"])){

// 	$mostrar = new AjaxCuentasPagar();
// 	$mostrar -> codCuenta = $_POST["codCuenta"];
// 	$mostrar -> codSucursal = $_POST["codSucursal"];
// 	$mostrar -> ajaxMostrarCuentaPagarInner();

// }

/*=============================================
GUARDAR PAGO
=============================================*/	

if(isset($_POST["txtPago"])){

	$guardar = new AjaxCuentasPagar();
	$guardar -> codCuenta = $_POST["txtCodCuenta"];
	$guardar -> codUsuario = $_POST["txtCodUsuario"];
	$guardar -> pago = $_POST["txtPago"];
	$guardar -> fechaVenc = $_POST["txtFechaVenc"];
	$guardar -> saldo = $_POST["txtSaldo"];
	$guardar -> fechaPago = $_POST["txtFechaPago"];
	$guardar -> estadoCuenta = $_POST["txtEstadoCuenta"];
	$guardar -> nroMovimiento = $_POST["txtNroMovimiento"];
	$guardar -> nroRecibo = $_POST["txtNroRecibo"];
	$guardar -> tipoRecibo = $_POST["txtTipoRecibo"];
	$guardar -> formaPago = $_POST["txtFormaPago"];
	$guardar -> tipoVenta = $_POST["txtTipoVenta"];
	
	$guardar -> ajaxGuardarPago();

}

/*================================================
	MOSTRAR ULTIMO NUMERO DE RECIBO
==================================================*/
// if(isset($_POST["tipoRecibo"])){

// 	$mostrar = new AjaxCuentasPagar();
// 	$mostrar -> tipoRecibo = $_POST["tipoRecibo"];
// 	$mostrar -> ajaxMostrarNroRecibo();

// }

/*================================================
	MOSTRAR HISTORIAL DE PAGO
==================================================*/
// if(isset($_POST["codCuentaHistorialPago"])){

// 	$mostrar = new AjaxCuentasPagar();
// 	$mostrar -> codCuentaDetUsuario = $_POST["codCuentaDetUsuario"];
// 	$mostrar -> ajaxMostrarHistorialPago();

// }

/*=============================================
	MOSTRAR PROVEEDORES CON CUENTA A PAGAR
=============================================*/
if(isset($_POST["codCuentaProveedor"])){

	$mostrar = new AjaxCuentasPagar();
	$mostrar -> codCuentaProveedor = $_POST["codCuentaProveedor"];
	$mostrar -> ajaxMostrarProveedorCuentaPagar();

}

/*================================================
	MOSTRAR CUENTAS CABECERA
==================================================*/
if(isset($_POST["codCuentaCabecera"])){

	$mostrar = new AjaxCuentasPagar();
	$mostrar -> codCuentaCabecera = $_POST["codCuentaCabecera"];
	$mostrar -> ajaxMostrarCuentasCabecera();

}

/*=============================================
ANULAR PAGO
=============================================*/	

if(isset($_POST["txtPagoAnular"])){

	$guardar = new AjaxCuentasPagar();
	$guardar -> codCuenta = $_POST["txtCodCuenta"];
	$guardar -> codUsuario = $_POST["txtCodUsuario"];
	$guardar -> pago = $_POST["txtPagoAnular"];
	$guardar -> fechaVenc = $_POST["txtFechaVenc"];
	$guardar -> saldo = $_POST["txtSaldo"];
	$guardar -> fechaPago = $_POST["txtFechaPago"];
	$guardar -> estadoCuenta = $_POST["txtEstadoCuenta"];
	$guardar -> formaPago = $_POST["txtFormaPago"];
	$guardar -> nroMovimiento = $_POST["txtNroMovimiento"];
	$guardar -> nroRecibo = $_POST["txtNroRecibo"];
	$guardar -> tipoRecibo = $_POST["txtTipoRecibo"];
	$guardar -> agruparAnulado = $_POST["txtAgruparAnulado"];
	$guardar -> detMovimiento = $_POST["txtDetMovimiento"];
	$guardar -> tokenCuentaDet = $_POST["txtTokenCuentaDet"];
	
	$guardar -> ajaxAnularPago();

}

/*================================================
	MODIFICAR COMENTARIO DE LA CUENTA
==================================================*/
if(isset($_POST["codCuentaComentario"])){

	$modificarComentario = new AjaxCuentasPagar();
	$modificarComentario -> codCuentaComentario = $_POST["codCuentaComentario"];
	$modificarComentario -> comentario = $_POST["comentario"];
	$modificarComentario -> ajaxModificarComentario();

}
