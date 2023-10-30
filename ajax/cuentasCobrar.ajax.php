<?php

require_once "../controladores/formapagos.controlador.php";
require_once "../modelos/formapagos.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

require_once "../controladores/cuentasCobrar.controlador.php";
require_once "../modelos/cuentasCobrar.modelo.php";

class AjaxCuentasCobrar{

	/*=============================================
	MOSTRAR METODO DE PAGO
	=============================================*/	

	public function ajaxMostrarMetodoPago(){

		$item = null;
		$valor = null;

		$metodoPago = ControladorFormaPagos::ctrMostrarFormapago($item, $valor,"ESTADO_FORMA",1);

		echo json_encode($metodoPago);

	}

	/*=============================================
	MOSTRAR CUENTAS A COBRAR
	=============================================*/	

	public function ajaxMostrarCuentasCobrar(){

		$nombres = explode("/",$this->codCuenta);
		$COD_CUENTA = $nombres[0];

		// var_dump($COD_CUENTA);
		// return;

		$item = "COD_CUENTA";
		$valor = $COD_CUENTA;

		$mostrarCuenta = ControladorCuentasCobrar::ctrMostrarCuentasCobrar($item, $valor);

		echo json_encode($mostrarCuenta);

	}

	/*=============================================
	MOSTRAR DETALLES DE CUENTAS A COBRAR
	=============================================*/	

	public function ajaxMostrarDetCuentasCobrar(){

		$nombres = explode("/",$this->codCuentaDet);
		$COD_CUENTA = $nombres[0];

		// var_dump($COD_CUENTA);
		// return;

		$item = "dcc.COD_CUENTA";
		$valor = $COD_CUENTA;

		$mostrarCuentaDet = ControladorCuentasCobrar::ctrMostrarDetCuentasCobrar($item, $valor);

		echo json_encode($mostrarCuentaDet);

	}

	/*=============================================
	MOSTRAR DETALLES DE CUENTAS A COBRAR
	=============================================*/	

	public function ajaxMostrarDetCuentasCobrar1(){

		$nombres = explode("/",$this->codCuentaDet);
		$COD_CUENTA = $nombres[0];

		$item = "COD_DETCUENTAS";
		$valor = $COD_CUENTA;

		// var_dump($valor);
		// return;

		$mostrarCuentaDet = ControladorCuentasCobrar::ctrMostrarDetCuentasCobrar1($item, $valor);

		echo json_encode($mostrarCuentaDet);

	}

	/*=============================================
	CONSULTA PARA OBTENER LA DIFERENCIA DE FECHA
	=============================================*/	

	public function ajaxMostrarDiferenciaFecha(){

		$nombres = explode("/",$this->codCuentaFecha);
		$COD_CUENTA=$nombres[0];

		// var_dump($COD_CUENTA);
		// return;

		$item = "COD_CUENTA";
		$valor = $COD_CUENTA;
		$where = "WHERE cc.COD_CUENTA = ".$valor;

		$mostrarCuentaDet = ControladorCuentasCobrar::ctrMostrarDiferenciaFecha($item, $valor, $where);

		echo json_encode($mostrarCuentaDet);

	}


	/*=============================================
	MOSTRAR CUENTAS A COBRAR CON INNER
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
	GUARDAR COBRO DE CUENTAS
	=============================================*/

	public function ajaxGuardarCobro(){

		// $nombres = explode("/",$this->codCaja);
		// $COD_CAJA=$nombres[0];
		
		
		$datos = array("pago"=>$this->pago);

		// $datos = array("codCuenta"=>$this->codCuenta,
		// 	"codUsuario"=>$this->codUsuario,
		// 	"pago"=>$this->pago,
		// 	"fechaVenc" =>$this->fechaVenc,
		// 	"saldo"=>$this->saldo,
		// 	"fechaPago"=> $this->fechaPago,
		// 	"estadoCuenta"=>$this->estadoCuenta,
		// 	"nroMovimiento"=>$this->nroMovimiento,
		// 	"nroRecibo"=>$this->nroRecibo,
		// 	"tipoRecibo"=> $this->tipoRecibo,
		// 	"formaPago"=>$this->formaPago,
		// 	"tipoVenta"=>$this->tipoVenta,
		// 	"codCaja"=>$COD_CAJA,
		// 	"codApertura"=>$this->codApertura);

		$respuesta = ControladorCuentasCobrar::ctrGuardarCobro($datos);
				
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
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
	MOSTRAR CLIENTES CON CUENTA A COBRAR
	=============================================*/

	public function ajaxMostrarClienteCuentaCobrar(){

		$nombres = explode("/",$this->codCuentaCliente);
		$COD_CUENTA=$nombres[0];

		// var_dump($COD_CUENTA);
		// return;

		$codCuentaCliente = $COD_CUENTA;

		$item="cc.COD_CUENTA";
        $valor=$codCuentaCliente;
        $where="WHERE cc.COD_CUENTA = ".$valor;

		$mostrarCuentaProveedor = ControladorCuentasCobrar::ctrMostrarClientesCuentaCobrar($item, $valor, $where);

		echo json_encode($mostrarCuentaProveedor);

	}

	/*=============================================
	MOSTRAR CUENTAS CABECERA
	=============================================*/	

	public function ajaxMostrarCuentasCabecera(){

		$nombres = explode("/",$this->codCuentaCabecera);
		$COD_CUENTA=$nombres[0];

		$item = "COD_CUENTA";
		$valor = $COD_CUENTA;

		$mostrarCuenta = ControladorCuentasCobrar::ctrMostrarCuentasCabecera($item, $valor);

		echo json_encode($mostrarCuenta);

	}

	/*=============================================
	ANULAR PAGO DE CUENTAS
	=============================================*/

	public function ajaxAnularPago(){

		$nombres = explode("/",$this->tokenCuentaDet);
		$COD_CUENTA=$nombres[0];
		
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
			"tokenCuentaDet" => $COD_CUENTA,
			"codCaja" => $this->codCaja,
			"codApertura" => $this->codApertura);

		// var_dump($datos);
		// return

		$respuesta = ControladorCuentasCobrar::ctrAnularCobro($datos);
				
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
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

		$metodoPago = ControladorCuentasCobrar::ctrModificarComentario($item1, $valor1, $item2, $valor2);

		echo json_encode($metodoPago);

	}

	/*=============================================
	MOSTRAR CABECERA DE TICKET
	=============================================*/

	public function ajaxMostrarCabeceraTicket(){

		// var_dump($this->codDetCtasCobrar);
		// return;

		$item = "dcc.COD_DETCUENTAS";
		$valor = $this->codDetCtasCobrar;

		$mostrarCuenta = ControladorCuentasCobrar::ctrMostrarCabeceraTicket($item, $valor);

		echo json_encode($mostrarCuenta);

	}

	/*=============================================
	MOSTRAR DETALLE DE TICKET
	=============================================*/

	public function ajaxMostrarDetalleTicket(){

		// var_dump($this->codDetCtasCobrar);
		// return;

		$item = "dcc.COD_DETCUENTAS";
		$valor = $this->codDetCtasCobrar;
		$valor1 = $this->codCuentaCobrar;

		$mostrarCuenta = ControladorCuentasCobrar::ctrMostrarDetalleTicket($item, $valor, $valor1);

		echo json_encode($mostrarCuenta);

	}

}

///////////////////////////////////////////////////////////////////////


/*================================================
	MOSTRAR METODO DE PAGO
==================================================*/
if(isset($_POST["item"])){

	$mostrar = new AjaxCuentasCobrar();
	$mostrar -> item = $_POST["item"];
	$mostrar -> ajaxMostrarMetodoPago();

}

/*================================================
	MOSTRAR CUENTAS A PAGAR
==================================================*/
if(isset($_POST["codCuenta"])){

	$mostrar = new AjaxCuentasCobrar();
	$mostrar -> codCuenta = $_POST["codCuenta"];
	$mostrar -> ajaxMostrarCuentasCobrar();

}

/*================================================
	MOSTRAR DETALLES DE CUENTAS A COBRAR
==================================================*/
if(isset($_POST["codCuentaDet"])){

	$mostrar = new AjaxCuentasCobrar();
	$mostrar -> codCuentaDet = $_POST["codCuentaDet"];
	$mostrar -> ajaxMostrarDetCuentasCobrar();

}

/*================================================
	MOSTRAR DETALLES DE CUENTAS A COBRAR1
==================================================*/
if(isset($_POST["codCuentaDet1"])){

	$mostrar = new AjaxCuentasCobrar();
	$mostrar -> codCuentaDet = $_POST["codCuentaDet1"];
	$mostrar -> ajaxMostrarDetCuentasCobrar1();

}

/*================================================
	MOSTRAR DIFERENCIA FECHA
==================================================*/
if(isset($_POST["codCuentaFecha"])){

	$mostrar = new AjaxCuentasCobrar();
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
GUARDAR COBRO
=============================================*/	

if(isset($_POST["txtPago"])){

	$guardar = new AjaxCuentasCobrar();
	$guardar -> pago = $_POST["txtPago"];

	// $listaCuenta = json_decode($_POST["txtPago"], true);

	// $guardar -> codUsuario = $_POST["txtCodUsuario"];
	// $guardar -> pago = $_POST["txtPago"];
	// $guardar -> fechaVenc = $_POST["txtFechaVenc"];
	// $guardar -> saldo = $_POST["txtSaldo"];
	// $guardar -> fechaPago = $_POST["txtFechaPago"];
	// $guardar -> estadoCuenta = $_POST["txtEstadoCuenta"];
	// $guardar -> nroMovimiento = $_POST["txtNroMovimiento"];
	// $guardar -> nroRecibo = $_POST["txtNroRecibo"];
	// $guardar -> tipoRecibo = $_POST["txtTipoRecibo"];
	// $guardar -> formaPago = $_POST["txtFormaPago"];
	// $guardar -> tipoVenta = $_POST["txtTipoVenta"];
	// $guardar -> codCaja = $_POST["txtCodCaja"];
	// $guardar -> codApertura = $_POST["txtCodApertura"];
	
	$guardar -> ajaxGuardarCobro();

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
	MOSTRAR CLIENTES CON CUENTA A COBRAR
=============================================*/
if(isset($_POST["codCuentaCliente"])){

	$mostrar = new AjaxCuentasCobrar();
	$mostrar -> codCuentaCliente = $_POST["codCuentaCliente"];
	$mostrar -> ajaxMostrarClienteCuentaCobrar();

}

/*================================================
	MOSTRAR CUENTAS CABECERA
==================================================*/
if(isset($_POST["codCuentaCabecera"])){

	$mostrar = new AjaxCuentasCobrar();
	$mostrar -> codCuentaCabecera = $_POST["codCuentaCabecera"];
	$mostrar -> ajaxMostrarCuentasCabecera();

}

/*=============================================
ANULAR PAGO
=============================================*/	

if(isset($_POST["txtPagoAnular"])){

	$guardar = new AjaxCuentasCobrar();
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
	$guardar -> codCaja = $_POST["txtCodCaja"];
	$guardar -> codApertura = $_POST["txtCodApertura"];
	
	$guardar -> ajaxAnularPago();

}

/*================================================
	MODIFICAR COMENTARIO DE LA CUENTA
==================================================*/
if(isset($_POST["codCuentaComentario"])){

	$modificarComentario = new AjaxCuentasCobrar();
	$modificarComentario -> codCuentaComentario = $_POST["codCuentaComentario"];
	$modificarComentario -> comentario = $_POST["comentario"];
	$modificarComentario -> ajaxModificarComentario();

}

/*================================================
	TRAER CABECERA DE CUENTAS
==================================================*/
if(isset($_POST["txtCabeceraTicket"])){

	$modificarComentario = new AjaxCuentasCobrar();
	$modificarComentario -> codDetCtasCobrar = $_POST["txtCabeceraTicket"];
	$modificarComentario -> ajaxMostrarCabeceraTicket();

}

/*================================================
	MODIFICAR COMENTARIO DE LA CUENTA
==================================================*/
if(isset($_POST["txtDetalleTicket"])){

	$modificarComentario = new AjaxCuentasCobrar();
	$modificarComentario -> codDetCtasCobrar = $_POST["txtDetalleTicket"];
	$modificarComentario -> codCuentaCobrar = $_POST["txtCodCuentaCobrar"];
	$modificarComentario -> ajaxMostrarDetalleTicket();

}

