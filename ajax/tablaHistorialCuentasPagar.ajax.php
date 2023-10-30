<?php

require_once "../controladores/cuentasPagar.controlador.php";
require_once "../modelos/cuentasPagar.modelo.php";
require_once "../controladores/formapagos.controlador.php";
require_once "../modelos/formapagos.modelo.php";


class TablaListadoCuentas{

	/*=============================================
	Tabla Historial de Pagos
	=============================================*/

	public function mostrarTabla(){

		$nombres = explode("/",$this->codCuentaHistorial);
		$COD_CUENTA=$nombres[0];

		$item = "dcp.COD_CUENTA";
		$valor = $COD_CUENTA;

		$tabla1 = "detctaspagar";
		$tabla2 = "usuarios";
		$tabla3 = "funcionarios";
		$order = "dcp.AGRUPAR_ANULADO";

		$mostrarHistorial = ControladorCuentasPagar::ctrMostrarHistorialPago($tabla1, $tabla2, $tabla3, $item, $valor, $order);
        
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

				$acciones = "<i><div class='btn-group'><button class='btn btn-dark btn-sm anularPago' disabled idCuenta='".$value["COD_DETCUENTAS"]."/".$value["TOKEN_DETCTASPAGAR"]."' idCuentaCab='".bin2hex(random_bytes(16)).$value["COD_CUENTA"]."'><i class='fas fa-trash-alt'></i></button></div></i>";

			}else if($value["DET_MOVIMIENTO"] == "ANULADO" && intval($value["PAGO"]) < 0){

				$acciones = "<i>ANULADO</i>";

			}else{

				$acciones = "<div class='btn-group'><button class='btn btn-danger btn-sm anularPago' idCuenta='".$value["TOKEN_DETCTASPAGAR"]."' idCuentaCab='".$value["COD_CUENTA"]."/".bin2hex(random_bytes(16)).$value["COD_CUENTA"]."'><i class='fas fa-trash-alt'></i></button></div>";

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

	$mostrar = new TablaListadoCuentas();
	$mostrar -> codCuentaHistorial = $_GET["codCuentaHistorialPago"];
	$mostrar -> mostrarTabla();

}



