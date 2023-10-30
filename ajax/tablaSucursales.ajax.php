<?php

require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursales.modelo.php";

require_once "../controladores/ciudades.controlador.php";
require_once "../modelos/ciudades.modelo.php";

class TablaSucursales{

	/*=============================================
	Tabla Categorías
	=============================================*/ 
	// public $activo;
	public function mostrarTabla(){

			// $item="ESTADO_SUCURSAL";
			// $valor=$this->activo;
			//var_dump($valor);
			$item=null;
			$valor=null;

			$Sucursales = ControladorSucursales::ctrMostrarSucursal($item, $valor,null);
		
		if(count($Sucursales)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Sucursales as $key => $value) {

	 		if($value["PRINCIPAL"]==1){

	 			// $activo="<div class='toggle-flip'><label><input type='checkbox'><span class='flip-indecator'data-toggle-off='Activo'data-toggle-on='Inactivo'></span></label></div>";

	 			$principal="P";

	 		}else
	 		{
	 			// $activo="<div class='toggle-flip'><label><input type='checkbox'><span class='flip-indecator'data-toggle-on='Inactivo''data-toggle-off='Activo'></span></label></div>";
				$principal="S";
	 		}

	 		if($value["ESTADO_SUCURSAL"]==1){

	 			// $activo="<div class='toggle-flip'><label><input type='checkbox'><span class='flip-indecator'data-toggle-off='Activo'data-toggle-on='Inactivo'></span></label></div>";

	 			// $activo="<button class='btn btn-success btn-sm'>Activo</i></button>";
	 			$activo="<div class='card text-white bg-success mb-3'> <p class='card-text text-center'>Activo</p></div>";

	 		}else
	 		{
	 			// $activo="<div class='toggle-flip'><label><input type='checkbox'><span class='flip-indecator'data-toggle-on='Inactivo''data-toggle-off='Activo'></span></label></div>";
				$activo="<div class='card text-white bg-success mb-3'> <p class='card-text text-center'>Inactivo</p></div>";
	 		}


		  	/*=============================================
 	 		TRAEMOS LA IMAGEN
  			=============================================*/ 
  			$galeria = json_decode($value["IMAGEN_SUC"], true);

  			if ($galeria!="" && $galeria!=[""] && $galeria!=NULL){
	  			
	  			//var_dump($galeria);
				foreach ($galeria as $indice => $valor) {
				
				$imagen = "<img src='".$valor."'width='40px'>";
						}
			}else{

				$galeria = json_decode("[]", true);

				$imagen = "<td><img src='vistas/img/sucursales/default/anonymous.jpg'class='img-thumbnail'width='40px'></td>";

				//var_dump($imagen);
	
			}
			
		  	
			$item="COD_CIUDAD";
			$valor= $value["COD_CIUDAD"];
			$ciudad = ControladorCiudades::ctrMostrarCiudad($item,$valor);
	 		
			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarSucursal' data-toggle='modal' data-target='#ModalSucursal' tokenSucursal='".$value["TOKEN_SUCURSAL"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarSucursal' galeria='".implode(",", $galeria)."' principal='".$value["PRINCIPAL"]."' IdSucursal='".$value["COD_SUCURSAL"]."' tokenSucursal='".$value["TOKEN_SUCURSAL"]."'><i class='fas fa-trash-alt'></i></button></div>";	

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["SUCURSAL"].'",
						"'.$value["RUC"].'",
						"'.$value["ENCARGADO"].'",
						"'.$value["DIRECCION"].'",
						"'.$ciudad["DESCRIPCION_CIUDAD"].'",
						"'.$value["NROVERIFICADOR"].'",
						"'.$value["NROPEDIDO"].'",
						"'.$value["NROREMISION"].'",
						"'.$value["TELEFONO_SUC"].'",
						"'.$activo.'",
						"'.$imagen.'",
						"'.$principal.'"
						
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

$tabla = new TablaSucursales();
$tabla -> mostrarTabla();

// if(isset($_GET["activo"]))
// {

// 	$tabla = new TablaSucursales();
// 	$tabla -> activo = $_GET["activo"];
// 	$tabla -> mostrarTabla();

// }

