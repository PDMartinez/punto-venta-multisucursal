<?php

require_once "../controladores/cuentasCobrar.controlador.php";
require_once "../modelos/cuentasCobrar.modelo.php";


class TablaCuentasCobrarCanceladas{

	/*=============================================
	Tabla Cuentas a Cobrar
	=============================================*/

	public function mostrarTabla(){

		$nombres = explode("/",$this->sucursal);
		$COD_SUCURSAL = $nombres[0];
		$item1 = "COD_SUCURSAL";
		$valor1 = $COD_SUCURSAL;

		$cliente = explode("/",$this->cliente);
		$COD_CLIENTE = $cliente[0];
		$item2 = "COD_CLIENTE";
		$valor2 = $COD_CLIENTE;

		$item3 = "ESTADO_CUENTA";
		$valor3 = "CANCELADO";

		$tabla1="ctascobrar";
		$tabla2="ventas";

		$order="COD_CUENTA";


        $cuentasCanceladas = ControladorCuentasCobrar::ctrMostrarCuentaCobrarInner($item1, $valor1, $item2, $valor2, $item3, $valor3, $tabla1, $tabla2, $order);
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

			$acciones = "<div class='btn-group'><button class='btn btn-info btn-sm verDetallesCuenta' data-toggle='modal' data-target='#ModalVerDetalle' idCuenta='".$value["COD_CUENTA"]."/".$value["TOKEN_CTASCOBRAR"]."' saldo='".number_format($saldo,0,',','.')."'><i class='fas fa-eye text-white' title='Ver detalles de la cuenta'></i></button><button class='btn btn-warning btn-sm historialCuenta ' data-toggle='modal' data-target='#ModalVerCobro' idCuenta='".$value["COD_CUENTA"]."/".$value["TOKEN_CTASCOBRAR"]."' title='Ver historial de pago'><i class='fa fa-list-alt'></i></button></div>";

			if($value["CUOTA_PAGADA"] == NULL){

				$datosJson.= '[

						"'.$acciones.'",
						"'.$value["NRO_MOVIMIENTO"].' '.$value["TIPO_MOVIMIENTO"].'",
						"'.$value["FECHA_VENTA"].'",
						"'.$value["FECHA_VENC_PROXIMO"].'",
						"'. 0 ."/".$value["CANT_CUOTA"].'",
						"'.number_format($value["MONTO_CUOTA"],0,',','.').'",
						"'.number_format($value["TOTAL_CUENTA"],0,',','.').'",
						"'.number_format((intval($value["TOTAL_CUENTA"]) - intval(0)) ,0,',','.').'"
						
				],';

			}else{

				$datosJson.= '[

						"'.$acciones.'",
						"'.$value["NRO_MOVIMIENTO"].' '.$value["TIPO_MOVIMIENTO"].'",
						"'.$value["FECHA_VENTA"].'",
						"'.$value["FECHA_VENC_PROXIMO"].'",
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

	$tabla = new TablaCuentasCobrarCanceladas();
	$tabla -> sucursal = $_GET["sucursal"];
	$tabla -> cliente = $_GET["cliente"];

	$tabla -> mostrarTabla();

	
}


