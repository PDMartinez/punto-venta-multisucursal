<?php

require_once "../controladores/cuentasCobrar.controlador.php";
require_once "../modelos/cuentasCobrar.modelo.php";


class TablaListadoCuentasCobrar{

	/*=============================================
	Tabla Cuentas
	=============================================*/

	public function mostrarTabla(){

		$nombres = explode("/",$this->idSucursal);
		$COD_SUCURSAL=$nombres[0];

		$nombres = explode("/",$this->cliente);
		$COD_CLIENTE=$nombres[0];

		$item1 = "FECHA";
		$valor1 = $this->fechaInicio;

		$item2 = "FECHA";
		$valor2 = $this->fechaFin;

		$item3="COD_SUCURSAL";
		$valor3=$COD_SUCURSAL;

		$valor4 = "CANCELADO";

		$item5="COD_CLIENTE";
		$valor5=$COD_CLIENTE;

		// var_dump($valor1);
		// var_dump($valor2);
		// var_dump($valor3);
		// var_dump($valor4);
		// var_dump($valor5);
		// return;

        $cuentas = ControladorCuentasCobrar::ctrMostrarCuestasCobrarListado($valor1, $valor2, $item3, $valor3, $valor4, $item5, $valor5);
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
		RECORREMOS LA CABECERA ctascobrar
		=============================================*/

		foreach ($cuentas as $key => $value) {

	 		if($value["NRO_MOVIMIENTO"] != NULL){

	 			$saldo=0;


	 			$saldo = (intval($value["TOTAL_CUENTA"]) - intval($value["MONTO_PAGADO"]));

		 		if($value["CUOTA_PAGADA"] != ""){

		 			$cuotasPagadas = intval($value["CUOTA_PAGADA"]);

		 		}else{

		 			$cuotasPagadas = "0";

		 		}


		 		/*=============================================
				ESTADO DE LA CUENTA
				=============================================*/

		 		if($value["ESTADO_CUENTA"]=="CREDITO"){

		 			$estado="<div class='card text-white bg-success mb-3'><p class='card-text text-center'> CREDITO</p></div>";

		 		}else{

					$estado="<div class='card text-white bg-danger mb-3'><p class='card-text text-center'> CANCELADO</p></div>";
		 		}

				/*=============================================
				ACCIONES
				=============================================*/

				if($value["ESTADO_CUENTA"] != "CREDITO"){

					$acciones = "<div class='btn-group'><button class='btn btn-info btn-sm verDetallesCuenta' data-toggle='modal' data-target='#ModalVerDetalle' idCuenta='".$value["COD_CUENTA"]."/".$value["TOKEN_CTASCOBRAR"]."' saldo='".number_format($saldo,0,',','.')."'><i class='fas fa-eye text-white' title='Ver detalles de la cuenta'></i></button><button class='btn btn-warning btn-sm historialCuenta' data-toggle='modal' data-target='#ModalVerCobro' idCuenta='".$value["COD_CUENTA"]."/".$value["TOKEN_CTASCOBRAR"]."' title='Ver historial de Cobro'><i class='fa fa-list-alt'></i></button></div>";
				}else{

					$acciones = "";
					
				}

				$datosJson.= '[

							"'.($key+1).'",
							"'.$acciones.'",
							"'.$value["NRO_MOVIMIENTO"].' '.$value["TIPO_MOVIMIENTO"].'",
							"'.$value["CLIENTE"].'",
							"'.$value["RUC"].'",
							"'.$value["FECHA_VENTA"].'",
							"'.$value["FECHA_VENC_PROXIMO"].'",
							"'.number_format($value["TOTAL_CUENTA"],0,',','.').'",
							"'.number_format($value["MONTO_CUOTA"],0,',','.').'",
							"'.$cuotasPagadas.'/'.$value["CANT_CUOTA"].'",
							"'.number_format($saldo,0,',','.').'",
							"'.$value["TIPO_VENTA"].'",
							"'.$estado.'"
							
					],';

			}
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*================================================
	MOSTRAR LISTADO DE CUENTAS PAGADAS
==================================================*/
if(isset($_GET["fechaInicio"])){

	// var_dump($_GET["sucursal"]);
	// var_dump($_GET["fechaInicio"]);
	// var_dump($_GET["fechaFin"]);
	// var_dump($_GET["cliente"]);
	// return;

	$mostrar = new TablaListadoCuentasCobrar();
	$mostrar -> idSucursal = $_GET["sucursal"];
	$mostrar -> cliente = $_GET["cliente"];
	$mostrar -> fechaInicio = $_GET["fechaInicio"];
	$mostrar -> fechaFin = $_GET["fechaFin"];
	$mostrar -> mostrarTabla();

}