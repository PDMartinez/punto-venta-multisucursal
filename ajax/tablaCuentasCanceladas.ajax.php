<?php

require_once "../controladores/cuentasPagar.controlador.php";
require_once "../modelos/cuentasPagar.modelo.php";


class TablaCuentasCanceladas{

	/*=============================================
	Tabla Cajas
	=============================================*/

	public function mostrarTabla(){

		$nombres = explode("/",$this->sucursal);
		$COD_SUCURSAL = $nombres[0];
		$item1 = "COD_SUCURSAL";
		$valor1 = $COD_SUCURSAL;

		$proveedor = explode("/",$this->proveedor);
		$COD_PROVEEDOR = $proveedor[0];
		$item2 = "COD_PROVEEDOR";
		$valor2 = $COD_PROVEEDOR;

		$item3 = "ESTADO_CUENTA";
		$valor3 = "Cancelado";

		$tabla1="ctaspagar";
		$tabla2="compras";

		$order="COD_CUENTA";


        $cuentasCanceladas = ControladorCuentasPagar::ctrMostrarCuentaPagarInner($item1, $valor1, $item2, $valor2, $item3, $valor3, $tabla1, $tabla2, $order);
        // var_dump($cuentasCanceladas);
        // return;
		
		if(count($cuentasCanceladas) == 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	/*=============================================
		RECORREMOS LA CABECERA ctaspagar
		=============================================*/

	 	foreach ($cuentasCanceladas as $key => $value) {


	 		$pagoTotal=0;
	 		$saldo=0;

			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-info btn-sm verDetallesCuenta' data-toggle='modal' data-target='#ModalVerDetalle' idCuenta='".$value["COD_CUENTA"]."/".$value["TOKEN_CTASPAGAR"]."' saldo='".number_format($saldo,0,',','.')."'><i class='fas fa-eye text-white' title='Ver detalles de la cuenta'></i></button><button class='btn btn-warning btn-sm historialCuenta ' data-toggle='modal' data-target='#ModalVerPago' idCuenta='".$value["COD_CUENTA"]."/".$value["TOKEN_CTASPAGAR"]."' title='Ver historial de pago'><i class='fa fa-list-alt'></i></button></div>";

			if($value["CUOTA_PAGADA"] == NULL){

				$datosJson.= '[

						"'.$acciones.'",
						"'.$value["NROCOMPRA"].' '.$value["TIPO_PAGO"].'",
						"'.$value["FECHA_COMPRA"].'",
						"'.$value["FECHA_VENCIMIENTO"].'",
						"'. 0 ."/".$value["CANT_CUOTA"].'",
						"'.number_format($value["MONTO_CUOTA"],0,',','.').'",
						"'.number_format($value["TOTAL_CUENTA"],0,',','.').'",
						"'.number_format((intval($value["TOTAL_CUENTA"]) - intval(0)) ,0,',','.').'"
						
				],';

			}else{

				$datosJson.= '[

						"'.$acciones.'",
						"'.$value["NROCOMPRA"].' '.$value["TIPO_PAGO"].'",
						"'.$value["FECHA_COMPRA"].'",
						"'.$value["FECHA_VENCIMIENTO"].'",
						"'.intval($value["CUOTA_PAGADA"])."/".$value["CANT_CUOTA"].'",
						"'.number_format($value["MONTO_CUOTA"],0,',','.').'",
						"'.number_format($value["TOTAL_CUENTA"],0,',','.').'",
						"'.number_format((intval($value["TOTAL_CUENTA"]) - intval($value["MONTO_PAGADO"])) ,0,',','.').'"
						
				],';

			}
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*=============================================
Mostrar Tabla Cuentas a Pagar
=============================================*/ 

if(isset($_GET["sucursal"]))
{

	$tabla = new TablaCuentasCanceladas();
	$tabla -> sucursal = $_GET["sucursal"];
	$tabla -> proveedor = $_GET["proveedor"];

	$tabla -> mostrarTabla();

	
}


