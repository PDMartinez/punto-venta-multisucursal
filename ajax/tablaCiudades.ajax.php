<?php

require_once "../controladores/ciudades.controlador.php";
require_once "../modelos/ciudades.modelo.php";

class TablaCiudades{

	/*=============================================
	Tabla Categorías
	=============================================*/ 

	public function mostrarTabla(){

		$ciudades = ControladorCiudades::ctrMostrarCiudad(null, null);

		if(count($ciudades)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($ciudades as $key => $value) {

	 			 		
			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarCiudad' data-toggle='modal' data-target='#ModalCiudad' tokenCiudad='".$value["TOKEN_CIUDAD"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarCiudad' tokenCiudad='".$value["TOKEN_CIUDAD"]."'><i class='fas fa-trash-alt'></i></button></div>";	

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["DESCRIPCION_CIUDAD"].'"
						
				],';

		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*=============================================
Tabla Perfiles
=============================================*/ 

$tabla = new TablaCiudades();
$tabla -> mostrarTabla();


