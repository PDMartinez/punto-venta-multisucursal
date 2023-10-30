<?php
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";
require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursales.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";
require_once "../controladores/cajas.controlador.php";
require_once "../modelos/cajas.modelo.php";
class AjaxVentas{
	// public $txtnrocompra;
	// public $txtnrorecibo;
	// public $txtUsuario;
	// public $txtidSucursal;
	// public $cmbproveedor;
	// public $txtproductos;
	// public $cmbFormapago;
	// public $txtpreciototal;
	// public $cmbTipoMovimiento;
	// public $cmbTipoPago;
	// public $txtcantidadCuota;
	// public $txtFechaVencimiento;
	// public $txtMontoCuota;
	// public $cmbMetodopago;
	// public $txtFechaCompra;


	public function ajaxAgreVentas(){

			$datos = array("txtnrocompra" => $this->txtnrocompra,
							"txtUsuario"=>$this->txtUsuario,
							"txtidSucursal"=>$this->txtidSucursal,
							"txtnrorecibo"=> $this->txtnrorecibo,
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


		/*=============================================
		LLAMAR A REMISION PARA ALMACENAR
		=============================================*/	
	public function ajaxConsultaFactura(){

		$item = "EST_CAJA";
        $valor = 1;
        $nombres = explode("/",$this->idcaja);
        $TOKEN_CAJA=$nombres[1];
        $item1 ="TOKEN_CAJA";
        $valor1 =$TOKEN_CAJA;
        $var=1;
 		$respuesta = ControladorCajas::ctrMostrarCajaSucursal($item, $valor,$item1, $valor1,$var);
 		echo json_encode($respuesta);

	}
}


/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_POST["txtnrocompra"])){

	$Guardar = new AjaxVentas();
	$Guardar -> txtnrocompra = $_POST["txtnrocompra"];
	$Guardar -> txtUsuario = $_POST["txtUsuario"];
	$Guardar -> txtidSucursal = $_POST["txtidSucursal"];
	$Guardar -> txtnrorecibo = $_POST["txtnrorecibo"];
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
	$Guardar -> ajaxAgreVentas();


}

if(isset($_POST["idcaja"])){

	$ConsultarFactura = new AjaxVentas();
	$ConsultarFactura -> idcaja = $_POST["idcaja"];
	$ConsultarFactura -> ajaxConsultaFactura();


}

