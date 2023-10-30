<?php

require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";

require_once "../controladores/ciudades.controlador.php";
require_once "../modelos/ciudades.modelo.php";

class TablaProveedores{

	/*=============================================
	Tabla Categorías
	=============================================*/ 

	public function mostrarTabla(){

	 	$item="ESTADO_PROVEEDOR";
    	$valor=1;
        $var=null;
        $proveedores = ControladorProveedores::ctrMostrarProveedor($item, $valor, $var);
		
		if(count($proveedores) == 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($proveedores as $key => $value) {
	 		
	 		

	 		/*=============================================
			TRAEMOS LA CIUDAD
			=============================================*/

	 		$item="COD_CIUDAD";
			$valor= $value["COD_CIUDAD"];
			$ciudad = ControladorCiudades::ctrMostrarCiudad($item,$valor);
		  	
			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarProveedor' data-toggle='modal' data-target='#ModalProveedor' tokenProveedor='".$value["TOKEN_PROVEEDOR"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarProveedor' IdProveedor='".$value["COD_PROVEEDOR"]."' tokenProveedor='".$value["TOKEN_PROVEEDOR"]."'><i class='fas fa-trash-alt'></i></button></div>";	

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["RUC"].'",
						"'.$value["NOMBRE"].'",
						"'.$ciudad["DESCRIPCION_CIUDAD"].'",
						"'.$value["DIRECCION"].'",
						"'.$value["EMAIL"].'",
						"'.$value["LINEABAJA"].'",
						"'.$value["CELULAR"].'",
						"'.$value["FECHA_REGISTRO"].'",
						"'.$value["FECHA_ACTUALIZACION"].'"
						
				],';
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*=============================================
Tabla Proveedores
=============================================*/ 

$tabla = new TablaProveedores();
$tabla -> mostrarTabla();


