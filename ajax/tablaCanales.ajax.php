<?php

require_once "../controladores/canales.controlador.php";
require_once "../modelos/canales.modelo.php";

// require_once "../controladores/sucursales.controlador.php";
// require_once "../modelos/sucursales.modelo.php";

class TablaCanales{

	/*=============================================
	Tabla Canales
	=============================================*/ 

	public function mostrarTabla(){

	 	$item="ESTADO";
    	$valor=1;
        $var=null;
        $order="COD_CANAL ASC";

        $canales = ControladorCanales::ctrMostrarCanal($item, $valor, $var, $order);
		
		if(count($canales) == 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($canales as $key => $value) {

		  	
			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarCanal' data-toggle='modal' data-target='#ModalCanales' tokenCanal='".$value["TOKEN_CANAL"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarCanal' IdCanal='".$value["COD_CANAL"]."' tokenCanal='".$value["TOKEN_CANAL"]."'><i class='fas fa-trash-alt'></i></button><button class='btn btn-info btn-sm AsiganarCanal' data-toggle='modal' data-target='#ModalDescuento' nombrecanal='".$value["DESCRIPCION_CANAL"]."' IdCanal='".$value["COD_CANAL"]."' tokenCanal='".$value["TOKEN_CANAL"]."'><i class='fa fa-refresh'></i></button></div>";

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["DESCRIPCION_CANAL"].'"
						
				],';
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*=============================================
Tabla Canales
=============================================*/ 

$tabla = new TablaCanales();
$tabla -> mostrarTabla();


