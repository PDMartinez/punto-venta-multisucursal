<?php

require_once "../controladores/marcas.controlador.php";
require_once "../modelos/marcas.modelo.php";

class TablaMarcas{

	/*=============================================
	Tabla Marcas
	=============================================*/ 
	
	public function mostrarTabla(){

		 
		$Marcas = ControladorMarcas::ctrMostrarMarca(null,null);

		if(count($Marcas)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Marcas as $key => $value) {

	 			 		
			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarMarca' data-toggle='modal' data-target='#ModalMarca' tokenMarca='".$value["TOKEN_MARCA"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarMarca' tokenMarca='".$value["TOKEN_MARCA"]."'><i class='fas fa-trash-alt'></i></button></div>";	

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["NOMBRE_MARCA"].'",
						"'.$value["FECHA_MARCA"].'"
						
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
// if(isset($_GET["txtCategoria"]))
// {

// 	$tabla = new TablaCategorias();
// 	$tabla -> txtCategoria = $_GET["txtCategoria"];
// 	$tabla -> mostrarTabla();

// }

$tabla = new TablaMarcas();
$tabla -> mostrarTabla();


