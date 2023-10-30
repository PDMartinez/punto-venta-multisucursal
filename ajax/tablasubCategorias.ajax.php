<?php

require_once "../controladores/subcategorias.controlador.php";
require_once "../modelos/subcategorias.modelo.php";

class TablaSubCategorias{

	/*=============================================
	Tabla Categorías
	=============================================*/ 
	
	public function mostrarTabla(){

		 
		$subcategorias = ControladorSubCategorias::ctrMostrarSubCategoria(null,null);

		if(count($subcategorias)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($subcategorias as $key => $value) {

	 			 		
			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarSubCategoria' data-toggle='modal' data-target='#ModalSubCategoria' tokenSubCategoria='".$value["TOKEN_SUBCATEGORIA"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarSubCategoria' tokenSubCategoria='".$value["TOKEN_SUBCATEGORIA"]."'><i class='fas fa-trash-alt'></i></button></div>";	

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["NOMBRE_SUBCATEGORIA"].'",
						"'.$value["FECHA_SUBCATEGORIA"].'"
						
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

$tabla = new TablaSubCategorias();
$tabla -> mostrarTabla();


