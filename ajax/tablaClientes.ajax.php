<?php

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

require_once "../controladores/canales.controlador.php";
require_once "../modelos/canales.modelo.php";

require_once "../controladores/ciudades.controlador.php";
require_once "../modelos/ciudades.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class TablaClientes{

	/*=============================================
	Tabla Clientes
	=============================================*/ 

	public function mostrarTabla(){

		$item = "ESTADO_CLIENTE";
        $valor = 1;
        $var = null;

        $clientes = ControladorClientes::ctrMostrarClienteCiudad($item, $valor, $var);
		
		if(count($clientes) == 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($clientes as $key => $value) {

	 		/*=============================================
			TRAEMOS EL CANAL
			=============================================*/
	 		
	 		// if($value["ESTADO_CLIENTE"]==1){

	 		// 	$activo="<div class='card text-white bg-success mb-3'> <p class='card-text text-center'>Activo</p></div>";

	 		// }else{

				// $activo="<div class='card text-white bg-success mb-3'> <p class='card-text text-center'>Inactivo</p></div>";
	 		// }
			
		  	/*=============================================
 	 		TRAEMOS LA IMAGEN
  			=============================================*/ 
  			$galeria = json_decode($value["IMAGEN_CLIENTE"], true);
  			$cedulaFrontal = json_decode($value["IMAGEN_CEDULA"], true);
  			$cedulaTrasera = json_decode($value["IMAGEN_CEDULAATRAS"], true);

  			if ($galeria!="" && $galeria!=[""] && $galeria!=NULL){
	  			
	  			//var_dump($galeria);
				foreach ($galeria as $indice => $valor) {
				
				$imagen = "<img src='".$valor."'width='40px'>";
						}
			}else{

				$galeria = json_decode("[]", true);
				$cedulaFrontal = json_decode("[]", true);
				$cedulaTrasera = json_decode("[]", true);
			
				$imagen = "<td><img src='vistas/img/usuarios/default/anonymous.png'class='img-thumbnail'width='40px'></td>";

				//var_dump($imagen);
	
			}
			
		  	
			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarCliente' data-toggle='modal' data-target='#ModalClientes' tokenCliente='".$value["TOKEN_CLIENTE"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarCliente' IdCliente='".$value["COD_CLIENTE"]."' tokenCliente='".$value["TOKEN_CLIENTE"]."' galeria='".implode(",", $galeria)."' cedulaFrontal='".implode(",", $cedulaFrontal)."' cedulaTrasera='".implode(",", $cedulaTrasera)."'><i class='fas fa-trash-alt'></i></button></div>";	

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["CLIENTE"].'",
						"'.$value["RUC"].'",
						"'.$value["DESCRIPCION_CIUDAD"].'",
						"'.$value["DIRECCION"].'",
						"'.$value["EMAIL"].'",
						"'.$imagen.'",
						"'.$value["DESCRIPCION_CANAL"].'",
						"'.$value["CATEGORIA_CLIENTE"].'"
						
				],';
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*=============================================
Tabla Sucursales
=============================================*/ 

$tabla = new TablaClientes();
$tabla -> mostrarTabla();
