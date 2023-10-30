<?php

require_once "../controladores/perfiles.controlador.php";
require_once "../modelos/perfiles.modelo.php";

class TablaPerfiles{

	/*=============================================
	Tabla Categorías
	=============================================*/ 

	public function mostrarTabla(){

		$perfiles = ControladorPerfiles::ctrMostrarPerfil(null, null,null);

		if(count($perfiles)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($perfiles as $key => $value) {

	 		if($value["SUPER_PERFIL"]==1){

	 			// $activo="<div class='toggle-flip'><label><input type='checkbox'><span class='flip-indecator'data-toggle-off='Activo'data-toggle-on='Inactivo'></span></label></div>";

	 			$principal="A";

	 		}else
	 		{
	 			// $activo="<div class='toggle-flip'><label><input type='checkbox'><span class='flip-indecator'data-toggle-on='Inactivo''data-toggle-off='Activo'></span></label></div>";
				$principal="U";
	 		}


	 		if($value["SUPER_PERFIL"]==1){

	 			$admin="Administrador";

	 		}else
	 		{
	 			$admin="Usuario";
	 		}

	 		if($value["ESTADO_PERFIL"]==1){

	 			// $activo="<div class='toggle-flip'><label><input type='checkbox'><span class='flip-indecator'data-toggle-off='Activo'data-toggle-on='Inactivo'></span></label></div>";

	 			// $activo="<button class='btn btn-success btn-sm'>Activo</i></button>";
	 			$activo="<div class='card text-white bg-success mb-3'> <p class='card-text text-center'>Activo</p></div>";


	 		}else
	 		{
	 			// $activo="<div class='toggle-flip'><label><input type='checkbox'><span class='flip-indecator'data-toggle-on='Inactivo''data-toggle-off='Activo'></span></label></div>";
				$activo="<div class='card text-white bg-success mb-3'> <p class='card-text text-center'>Inactivo</p></div>";
	 		}

	 		
			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarPerfil' data-toggle='modal' data-target='#ModalPerfil' tokenPerfil='".$value["TOKEN_PERFIL"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarPerfil' tokenPerfil='".$value["TOKEN_PERFIL"]."'><i class='fas fa-trash-alt'></i></button></div>";	

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["NOMBRE_PERFIL"].'",
						"'.$value["DESCRIPCION_PERFIL"].'",
						"'.$admin.'",
						"'.$activo.'",
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
Tabla Perfiles
=============================================*/ 

$tabla = new TablaPerfiles();
$tabla -> mostrarTabla();


