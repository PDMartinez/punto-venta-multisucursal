<?php

require_once "../controladores/cuentasPagar.controlador.php";
require_once "../modelos/cuentasPagar.modelo.php";


class TablaListadoCuentasCanceladas{

	/*=============================================
	Tabla Cuentas
	=============================================*/

	public function mostrarTabla(){

		$nombres = explode("/",$this->idSucursal);
		$COD_SUCURSAL=$nombres[0];

		$nombres = explode("/",$this->proveedor);
		$COD_PROVEEDOR=$nombres[0];

		$item1 = "FECHA";
		$valor1 = $this->fechaInicio;

		$item2 = "FECHA";
		$valor2 = $this->fechaFin;

		$item3="COD_SUCURSAL";
		$valor3=$COD_SUCURSAL;

		$valor4 = "CANCELADO";

		$item5="COD_PROVEEDOR";
		$valor5=$COD_PROVEEDOR;
		

        $cuentas = ControladorCuentasPagar::ctrMostrarCuestasPagarListado($valor1, $valor2, $item3, $valor3, $valor4, $item5, $valor5);
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
		RECORREMOS LA CABECERA ctaspagar
		=============================================*/

		foreach ($cuentas as $key => $value) {

	 		if($value["NROCOMPRA"] != NULL){

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

					$acciones = "<div class='btn-group'><button class='btn btn-info btn-sm verDetallesCuenta' data-toggle='modal' data-target='#ModalVerDetalle' idCuenta='".$value["COD_CUENTA"]."/".$value["TOKEN_CTASPAGAR"]."' saldo='".number_format($saldo,0,',','.')."'><i class='fas fa-eye text-white' title='Ver detalles de la cuenta'></i></button><button class='btn btn-warning btn-sm historialCuentaCancelada' data-toggle='modal' data-target='#ModalVerPago' idCuenta='".$value["COD_CUENTA"]."/".$value["TOKEN_CTASPAGAR"]."' montoCuota='".number_format($value["MONTO_CUOTA"],0,',','.')."' totalCuenta='".number_format($value["TOTAL_CUENTA"],0,',','.')."' saldo='".number_format($saldo,0,',','.')."' idProv='".$value["COD_PROVEEDOR"].'/'.$value["TOKEN_PROVEEDOR"]."' title='Ver Historial de Pago'><i class='fa fa-list-alt'></i></button></div>";
				}else{

					$acciones = "";
					
				}

				$datosJson.= '[

							"'.($key+1).'",
							"'.$acciones.'",
							"'.$value["NROCOMPRA"].' '.$value["TIPO_PAGO"].'",
							"'.$value["NOMBRE"].'",
							"'.$value["RUC"].'",
							"'.$value["FECHA_COMPRA"].'",
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
	// var_dump($_GET["proveedor"]);
	// var_dump($_GET["fechaInicio"]);
	// var_dump($_GET["fechaFin"]);
	// return;

	$mostrar = new TablaListadoCuentasCanceladas();
	$mostrar -> idSucursal = $_GET["sucursal"];
	$mostrar -> proveedor = $_GET["proveedor"];
	$mostrar -> fechaInicio = $_GET["fechaInicio"];
	$mostrar -> fechaFin = $_GET["fechaFin"];
	$mostrar -> mostrarTabla();

}