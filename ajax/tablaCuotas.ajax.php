<?php

require_once "../controladores/cuotas.controlador.php";
require_once "../modelos/cuotas.modelo.php";
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class TablaCuotas{

	/*=============================================
	Tabla Descuentos
	=============================================*/ 

	public function mostrarTabla(){

	 	$item="";
    	$valor=null;
        $var=null;
        $order="COD_CUOTA ASC";

        $cuotas = ControladorCuotas::ctrMostrarCuota($item, $valor, $var, $order);
		
		if(count($cuotas) == 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($cuotas as $key => $value) {	 		

	 	$item ="COD_USUARIO";
        $valor = $value["COD_USUARIO"];

        $usuarios = ControladorUsuarios::ctrMostrarUsuario($item, $valor);
		  	
			/*=============================================
			ACCIONES
			=============================================*/
			
			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarCuotas' data-toggle='modal' data-target='#ModalCuotas' idCuotas='".$value["COD_CUOTA"]."' tokenCuotas='".$value["TOKEN_CUOTA"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarCuotas' idCuotas='".$value["COD_CUOTA"]."' tokenCuotas='".$value["TOKEN_CUOTA"]."'><i class='fas fa-trash-alt'></i></button></div>";


			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["RECARGO_CUOTA"].'",
						"'.number_format($value["MONTO_CUOTA"],0,',','.').'",
						"'.number_format($value["MONTO_MAXIMA"],0,',','.').'",
						"'.$value["FECHA_REGISTRO"].'",
						"'.$value["FECHA_MODIFICACION"].'",
						"'.$usuarios["USUARIO"].'"
						
				],';
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*=============================================
Tabla Cuotass
=============================================*/ 

$tabla = new TablaCuotas();
$tabla -> mostrarTabla();

