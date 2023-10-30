<?php

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

class TablaCategorias{

	/*=============================================
	Tabla Categorías
	=============================================*/ 
	
	public function mostrarTabla(){

		 
		$categorias = ControladorCategorias::ctrMostrarCategoria(null,null);

		if(count($categorias)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($categorias as $key => $value) {

	 			 		
			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarCategoria' data-toggle='modal' data-target='#ModalCategoria' tokenCategoria='".$value["TOKEN_CATEGORIA"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarCategoria' tokenCategoria='".$value["TOKEN_CATEGORIA"]."'><i class='fas fa-trash-alt'></i></button></div>";	

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["NOMBRE_CATEGORIA"].'",
						"'.$value["FECHA_CATEGORIA"].'"
						
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

$tabla = new TablaCategorias();
$tabla -> mostrarTabla();


