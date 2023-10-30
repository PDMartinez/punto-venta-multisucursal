<?php

require_once "../controladores/cuentasCobrar.controlador.php";
require_once "../modelos/cuentasCobrar.modelo.php";
require_once "../controladores/formapagos.controlador.php";
require_once "../modelos/formapagos.modelo.php";


class TablaHistorialCuentas{

	/*=============================================
	Tabla Historial de Pagos
	=============================================*/

	public function mostrarTabla(){

		$nombres = explode("/",$this->codCuentaHistorial);
		$COD_CUENTA=$nombres[0];

		$item = "dcc.COD_CUENTA";
		$valor = $COD_CUENTA;

		$tabla1 = "detctascobrar";
		$tabla2 = "usuarios";
		$tabla3 = "funcionarios";
		$order = "dcc.AGRUPAR_ANULADO";

		$mostrarHistorial = ControladorCuentasCobrar::ctrMostrarHistorialPago($tabla1, $tabla2, $tabla3, $item, $valor, $order);
        
        // var_dump($mostrarHistorial);
        // return;
		
		if(count($mostrarHistorial) == 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	// var_dump($mostrarHistorial[1]["DET_MOVIMIENTO"]);

	 	/*=============================================
		RECORREMOS LA CABECERA ctaspagar
		=============================================*/

		// var_dump(count($mostrarHistorial));

	 	foreach ($mostrarHistorial as $key => $value) {

	 		$MetodosPagosNuevo="";

	 		if($value["FORMAPAGO"]!=null){

				$metodospagos = json_decode($value["FORMAPAGO"], true);
			 
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

	 		$itemDet = "COD_CUENTA";
	 		$valorDet = $value["COD_DETCUENTAS"];

	 		// $cuentaDet = ControladorCuentasPagar::ctrMostrarDetCuentasPagar($itemDet, $valorDet);

		 	$fechaVenc = new DateTime($value["FECHA_VENC"]);
		 	$fechaPago = new DateTime(substr($value["FECHA_PAGO"], 0, 10));
		 	$diferencia = $fechaPago->diff($fechaVenc);
		 	$difDias;

		 	if($fechaPago > $fechaVenc){

		 		$difDias = "-".$diferencia->days;

		 	}else{

		 		$difDias = $diferencia->days;

		 	}

		 	// var_dump($fechaVenc);
		 	// var_dump($fechaPago);
		 	// var_dump($difDias);

			/*=============================================
			ACCIONES
			=============================================*/

			if($value["DET_MOVIMIENTO"] == "ANULADO" && intval($value["PAGO"]) > 0){

				/*====================================================================
				ESTO HACEMOS PARA QUE PODAMOS DESHABILITAR SOLO LOS BOTONES DE ANULADOS
				=====================================================================*/

				$acciones = "<i><div class='btn-group'><button class='btn btn-dark btn-sm anularPago' disabled idCuenta='".$value["COD_DETCUENTAS"]."/".$value["TOKEN_DETCTASCOBRAR"]."' idCuentaCab='".bin2hex(random_bytes(16)).$value["COD_CUENTA"]."'><i class='fas fa-trash-alt'></i></button></div></i>";
				// $acciones = "<button class='btn btn-danger btn-sm historialCuenta' data-toggle='popover' data-target='#modalVerAnulado' idcuenta='1/e2d2ba5d159a541501944ec431226d622' title='Ver historial de Cobro'><i class='fas fa-eye' aria-hidden='true'>ANULADO</i></button>";

			}else if($value["DET_MOVIMIENTO"] == "ANULADO" && intval($value["PAGO"]) < 0){

				$acciones = "<i>ANULADO</i>";
				// $acciones = "<button class='btn btn-danger' type='button' title='data-container='body' data-toggle='popover'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>ANULADO</font></font></button>";

			}else{

				$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm imprimirCobro' title='Imprimir Cobro' idCuenta='".$value["COD_DETCUENTAS"]."/".$value["TOKEN_DETCTASCOBRAR"]."' idCuentaCab='".$value["COD_CUENTA"]."/".bin2hex(random_bytes(16)).$value["COD_CUENTA"]."'><i class='fa-solid fa-print'></i></button><button class='btn btn-danger btn-sm anularPago' title='Anular Cobro' idCuenta='".$value["COD_DETCUENTAS"]."/".$value["TOKEN_DETCTASCOBRAR"]."' idCuentaCab='".$value["COD_CUENTA"]."/".bin2hex(random_bytes(16)).$value["COD_CUENTA"]."'><i class='fas fa-trash-alt'></i></button></div>";

			}

			// var_dump($key);
			// var_dump($c);

			$datosJson.= '[

				"'.($key+1).'",
				"'.$acciones.'",
				"'.$value["NRO_RECIBO"].'",
				"'.$value["TIPO_RECIBO"].'",
				"'.$MetodosPagosNuevo.'",
				"'.number_format($value["PAGO"],0,',','.').'",
				"'.$value["FECHA_VENC"].'",
				"'.$value["FECHA_PAGO"].'",
				"'.$difDias.'",
				"'.number_format($value["SALDO"],0,',','.').'",
				"'.$value["NOMBRE_FUNC"].'"
							
			],';
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*================================================
	MOSTRAR HISTORIAL DE PAGO
==================================================*/
if(isset($_GET["codCuentaHistorialPago"])){

	// var_dump($_GET["codCuentaHistorialPago"]);
	// return;

	$mostrar = new TablaHistorialCuentas();
	$mostrar -> codCuentaHistorial = $_GET["codCuentaHistorialPago"];
	$mostrar -> mostrarTabla();

}



