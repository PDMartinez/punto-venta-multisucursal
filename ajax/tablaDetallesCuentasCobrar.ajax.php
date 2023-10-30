<?php

require_once "../controladores/cuentasCobrar.controlador.php";
require_once "../modelos/cuentasCobrar.modelo.php";


class TablaDetCuentasCobrar{


	public function mostrarTabla(){

		$nombres = explode("/",$this->codCuentaDetCobro);
		$COD_CUENTA=$nombres[0];

		$item = "COD_CUENTA";
		$valor = $COD_CUENTA;

		$order = "COD_CUENTA ASC";

        $cuentas = ControladorCuentasCobrar::ctrMostrarCuentasCobrarProductos($item, $valor, $order);

        // var_dump($cuentas);
        // return;
		
		if(count($cuentas) == 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	/*=============================================
		RECORREMOS LOS DETALLES DE LA CUENTA
		=============================================*/

		foreach ($cuentas as $key => $value) {

			$productos = str_replace(array(',', '"'), '', $value["DESCRIPCION"]);
			$datosJson.= '[

				"'.($key+1).'",
				"'.$value["CODBARRA"].'",
				"'.$productos.'",
				"'.$value["CANTIDAD"].'",
				"'.number_format($value["PRECIO_UNI"],0,',','.').'",
				"'.$value["DESCUENTO"].'",
				"'.$value["STOCK_ANTERIOR"].'",
				"'.number_format($value["PRECIO_NETO"],0,',','.').'"
						
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

if(isset($_GET["codCuentaDetCobro"]))
{

	$tabla = new TablaDetCuentasCobrar();
	$tabla -> codCuentaDetCobro = $_GET["codCuentaDetCobro"];

	$tabla -> mostrarTabla();

	
}


