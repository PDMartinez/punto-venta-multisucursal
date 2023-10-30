<?php

require_once "../controladores/cajas.controlador.php";
require_once "../modelos/cajas.modelo.php";
require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursales.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class TablaCajas{

	/*=============================================
	Tabla Cajas
	=============================================*/ 

	public function mostrarTabla(){

	 	$item="EST_CAJA";
    	$valor=1;
        $var=null;
        $order="COD_SUCURSAL ASC";

        $cajas = ControladorCajas::ctrMostrarCaja($item, $valor, $var, $order);
		
		if(count($cajas) == 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($cajas as $key => $value) {

	 		// if($value["EST_CAJA"]==1){

	 		// 	$activo="<div class='card text-white bg-success mb-3'> <p class='card-text text-center'>Activo</p></div>";

	 		// }else
	 		// {

				// $activo="<div class='card text-white bg-success mb-3'> <p class='card-text text-center'>Inactivo</p></div>";
	 		// }	 		

	 		/*=============================================
			TRAEMOS LA SUCURSAL
			=============================================*/

	 		$item="COD_SUCURSAL";
			$valor= $value["COD_SUCURSAL"];
			$sucursal = ControladorSucursales::ctrMostrarSucursal($item, $valor, 1);

			// var_dump($sucursal);

			// return;
		  	
			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarCaja' data-toggle='modal' data-target='#ModalCaja' tokenCaja='".$value["TOKEN_CAJA"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarCaja' IdCaja='".$value["COD_CAJA"]."' tokenCaja='".$value["TOKEN_CAJA"]."'><i class='fas fa-trash-alt'></i></button></div>";

			$fechaInicio = explode("-",$value["FECHA_DESDE"]);
			$nuevaFechaInicio = $fechaInicio[2].'/'.$fechaInicio[1].'/'.$fechaInicio[0];

			$fechaFin = explode("-",$value["FECHA_HASTA"]);
			$nuevaFechaFin = $fechaFin[2].'/'.$fechaFin[1].'/'.$fechaFin[0];	

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$sucursal["SUCURSAL"].'",
						"'.$value["NROCAJA"].'",
						"'.$value["NRO_FACTURA"].'",
						"'.$value["TIMBRADO"].'",
						"'.$nuevaFechaInicio.'",
						"'.$nuevaFechaFin.'",
						"'.$value["NOMBRE_EQUIPO"].'",
						"'.$value["NRO_VERIFICADOR"].'",
						"'.$value["NROTICKET"].'",
						"'.$value["NRONOTACREDITO"].'"
						
				],';
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*=============================================
Tabla Cajas
=============================================*/ 

$tabla = new TablaCajas();
$tabla -> mostrarTabla();


