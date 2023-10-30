<?php

require_once "../controladores/descuentosProductos.controlador.php";
require_once "../modelos/descuentosProductos.modelo.php";

require_once "../controladores/canalesProductos.controlador.php";
require_once "../modelos/canalesProductos.modelo.php";

class TablaDescuentosProductos{

	/*=============================================
	Tabla Descuentos
	=============================================*/ 

	public function mostrarTabla(){

	 	$item="";
    	$valor=null;
        $var=null;
        $order="COD_DETCANAL ASC";

        $descuentos = ControladorDescuentosProductos::ctrMostrarDescuento($item, $valor, $var, $order);
		
		if(count($descuentos) == 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($descuentos as $key => $value) {	 		

	 		/*=============================================
			TRAEMOS EL CANAL
			=============================================*/

			$item="COD_CANAL";
            $valor=$value["COD_CANAL"];;
            $var=1;
            $order="COD_CANAL ASC";

            $canales = ControladorCanalesProductos::ctrMostrarCanal($item, $valor, $var, $order);

			// var_dump($canales);

			// return;
		  	
			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarDescuento' data-toggle='modal' data-target='#ModalDescuento' tokenDescuento='".$value["TOKEN"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarDescuento' IdDescuento='".$value["COD_DETCANAL"]."' tokenDescuento='".$value["TOKEN"]."'><i class='fas fa-trash-alt'></i></button></div>";


			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$canales["DESCRIPCION_CANAL"].'",
						"'.$value["DESC_CANAL"].'",
						"'.number_format($value["CANTIDAD_DESDE"],0,',','.').'",
						"'.number_format($value["CANTIDAD_HASTA"],0,',','.').'",
						"'.$value["FECHA_REGISTRO"].'",
						"'.$value["FECHA_MODIFICACION"].'"
						
				],';
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*=============================================
Tabla Descuentos
=============================================*/ 

$tabla = new TablaDescuentosProductos();
$tabla -> mostrarTabla();

