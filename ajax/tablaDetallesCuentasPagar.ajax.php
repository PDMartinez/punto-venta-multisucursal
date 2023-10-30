<?php

require_once "../controladores/cuentasPagar.controlador.php";
require_once "../modelos/cuentasPagar.modelo.php";


class TablaDetCuentasPagar{


	public function mostrarTabla(){

		$nombres = explode("/",$this->codCuentaDetPago);
		$COD_CUENTA=$nombres[0];

		$item = "COD_CUENTA";
		$valor = $COD_CUENTA;

		$order = "COD_CUENTA ASC";

        $cuentas = ControladorCuentasPagar::ctrMostrarCuentasPagarProductos($item, $valor, $order);

        // var_dump($cuentas);
        // return;
		// echo json_encode($cuentas);
		if(count($cuentas) == 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	/*=============================================
		RECORREMOS LAS CUENTAS
		=============================================*/

		foreach ($cuentas as $key => $value) {

		 	$productos = str_replace(array(',', '"'), '', $value["DESCRIPCION"]);

			$datosJson.= '[

				"'.($key+1).'",
				"'.$value["CODBARRA"].'",
				"'.$productos.'",
				"'.$value["CANTIDAD"].'",
				"'.number_format($value["PREC_UNITARIO"],0,',','.').'",
				"'.$value["DESCUENTO"].'",
				"'.$value["STOCK_ANTERIOR"].'",
				"'.number_format($value["PREC_NETO"],0,',','.').'"
						
			],';

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

if(isset($_GET["codCuentaDetPago"]))
{

	$tabla = new TablaDetCuentasPagar();
	$tabla -> codCuentaDetPago = $_GET["codCuentaDetPago"];

	$tabla -> mostrarTabla();

	
}


