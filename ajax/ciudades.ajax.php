<?php

require_once "../controladores/ciudades.controlador.php";
require_once "../modelos/ciudades.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class AjaxCiudades{


	/*=============================================
	EDITAR CIUDADES
	=============================================*/	

	public $token_ciudad;

	public function ajaxEditarCiudad()
	{

		$item = "TOKEN_CIUDAD";
		$valor = $this->token_ciudad;
		
		$respuesta = ControladorCiudades::ctrMostrarCiudad($item, $valor);

		echo json_encode($respuesta);
		//var_dump($respuesta);
	}



	/*=============================================
	Guardar Ciudades
	=============================================*/	

	public $txtCiudad;
	public $idCiudadEditar;
	public $tokenCiudad;
	public function ajaxGuardarCiudad(){

		if(($this->tokenCiudad)!=""){

			$datos = array("ciudad" => strtoupper($this->txtCiudad),
							"token"=>($this->tokenCiudad));
			
				$editar = ControladorCiudades::ctrEditarCiudad($datos);
				
				echo json_encode($editar,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

		}else{
				
			//var_dump($datos);
				$respuesta = ControladorCiudades::ctrCrearCiudad($this->txtCiudad);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

			}
		}


	/*=============================================
	Eliminar CIUDADES
	=============================================*/	

	public $idEliminar;
	
	public function ajaxEliminarCiudad(){

		$respuesta = ControladorCiudades::ctrBorrarCiudad($this->idEliminar);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
		die();
	}


	public function ajaxConsultarCiudad()
			{

				$item = "DESCRIPCION_CIUDAD";
				$valor =$this->descripcion;
				//	var_dump($valor);
				$respuesta = ControladorCiudades::ctrMostrarCiudad($item, $valor);

				echo json_encode($respuesta);
					//var_dump($respuesta);
			}



}

	

/*=============================================
LLAMAR A LA FUNCIÓN EDITAR CIUDADES QUE ESTA FUERA DE CLASE
=============================================*/
if(isset($_POST["token_ciudad"]))
{

	$editar = new AjaxCiudades();
	$editar -> token_ciudad = $_POST["token_ciudad"];
	$editar -> ajaxEditarCiudad();

}

/*=============================================
GUARDAR y EDITAR CIUDAD
=============================================*/	

if(isset($_POST["txtCiudad"])){

	$Guardar = new AjaxCiudades();
	$Guardar -> txtCiudad = $_POST["txtCiudad"];
	$Guardar -> idCiudadEditar = $_POST["idCiudadEditar"];
	$Guardar -> tokenCiudad = $_POST["tokenCiudad"];
	$Guardar -> ajaxGuardarCiudad();

}

/*=============================================
Eliminar Ciudades
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxCiudades();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarCiudad();

}


/*=============================================
LLAMAR A LA FUNCIÓN EDITAR CATEGORIAS QUE ESTA FUERA DE CLASE
=============================================*/
if(isset($_POST["descripcion"]))
{
	$consultar = new AjaxCiudades();
	$consultar -> descripcion = $_POST["descripcion"];
	$consultar -> ajaxConsultarCiudad();

}
