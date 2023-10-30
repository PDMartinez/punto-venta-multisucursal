<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class TablaUsuarios{

	/*=============================================
	Tabla Categorías
	=============================================*/ 
	// public $activo;
	public function mostrarTabla(){

			// $item="ESTADO_SUCURSAL";
			// $valor=$this->activo;
			//var_dump($valor);
		$item = null;
        $valor = null;

        $usuarios = ControladorUsuarios::ctrMostrarUsuario($item, $valor);
		
		if(count($usuarios)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($usuarios as $key => $value) {

	 		if($value["SUPER_PERFIL"]==1){

	 			// $activo="<div class='toggle-flip'><label><input type='checkbox'><span class='flip-indecator'data-toggle-off='Activo'data-toggle-on='Inactivo'></span></label></div>";

	 			$principal="P";

	 		}else
	 		{
	 			// $activo="<div class='toggle-flip'><label><input type='checkbox'><span class='flip-indecator'data-toggle-on='Inactivo''data-toggle-off='Activo'></span></label></div>";
				$principal="S";
	 		}

	 		
	 		if($value["ESTADO_USUARIO"]==1){

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
  			$galeria = json_decode($value["FOTO_USUARIO"], true);
  			
  			if ($galeria!="" && $galeria!=[""] && $galeria!=NULL){

	  			
	  			//var_dump($galeria);
				foreach ($galeria as $indice => $valor) {
				
				$imagen = "<img src='".$valor."'width='40px'>";
						}
			}else{
			$galeria = json_decode("[]", true);
				$imagen = "<td><img src='vistas/img/usuarios/default/anonymous.png'class='img-thumbnail'width='40px'></td>";

				//var_dump($imagen);
	
			}
			
		  	
			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarUsuario' data-toggle='modal' data-target='#ModalUsuario' tokenUsuario='".$value["TOKEN_USUARIO"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarUsuario' galeria='".implode(",", $galeria)."' principal='".$value["SUPER_PERFIL"]."' IdUsuario='".$value["COD_USUARIO"]."' tokenUsuario='".$value["TOKEN_USUARIO"]."'><i class='fas fa-trash-alt'></i></button></div>";	

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["NOMBRE_FUNC"].'",
						"'.$value["USUARIO"].'",
						"'.$value["NOMBRE_PERFIL"].'",
						"'.$value["HORA_DESDE"].'",
						"'.$value["HORA_HASTA"].'",
						"'.$value["SUCURSAL"].'",
						"'.$value["ULTIMO_LOGIN"].'",
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

$tabla = new TablaUsuarios();
$tabla -> mostrarTabla();

// if(isset($_GET["activo"]))
// {

// 	$tabla = new TablaSucursales();
// 	$tabla -> activo = $_GET["activo"];
// 	$tabla -> mostrarTabla();

// }

