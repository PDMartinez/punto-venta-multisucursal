<?php

require_once "../controladores/marcas.controlador.php";
require_once "../modelos/marcas.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class AjaxMarcas{


public $validarMarcas;

	public function ajaxValidarMarcas(){

		$item = "NOMBRE_MARCA";
		$valor = $this->validarMarcas;

		$respuesta = ControladorMarcas::ctrMostrarMarca($item, $valor);

		echo json_encode($respuesta);

	}



	/*=============================================
	EDITAR Marcas
	=============================================*/	

	public $tokenMarca;

	public function ajaxConsultarMarca()
	{

		$item = "TOKEN_MARCA";
		$valor = $this->tokenMarca;
		
		$respuesta = ControladorMarcas::ctrMostrarMarca($item, $valor);

		echo json_encode($respuesta);
		//var_dump($respuesta);
	}



	/*=============================================
	Guardar Marcas
	=============================================*/	

	public $txtMarca;
	public $idMarcaEditar;
	public $tokenMarcaEditar;
	public function ajaxGuardarMarca(){

		if(($this->tokenMarcaEditar)!=""){

			$datos = array("Marca" => strtoupper($this->txtMarca),
							"token"=>($this->tokenMarcaEditar));
			
				$editar = ControladorMarcas::ctrEditarMarca($datos);
				
				echo json_encode($editar,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

		}else{
				
				$guardar = ControladorMarcas::ctrCrearMarca($this->txtMarca);
				
				echo json_encode($guardar,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

			}
		}


	/*=============================================
	Eliminar Marcas
	=============================================*/	

	public $idEliminar;
	
	public function ajaxEliminarMarca(){

		$respuesta = ControladorMarcas::ctrBorrarMarca($this->idEliminar);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
		die();
	}


		public function ajaxEdtitarMarca()
			{

				$item = "NOMBRE_MARCA";
				$valor =$this->descripcion;
				//	var_dump($valor);
				$respuesta = ControladorMarcas::ctrMostrarMarca($item, $valor);

				echo json_encode($respuesta);
					//var_dump($respuesta);
			}


}

	

/*=============================================
LLAMAR A LA FUNCIÓN EDITAR MARCAS QUE ESTA FUERA DE CLASE
=============================================*/
if(isset($_POST["tokenMarca"]))
{

	$editar = new AjaxMarcas();
	$editar -> tokenMarca = $_POST["tokenMarca"];
	$editar -> ajaxConsultarMarca();

}

/*=============================================
GUARDAR y EDITAR MARCAS
=============================================*/	

if(isset($_POST["txtmarca"])){

	$Guardar = new AjaxMarcas();
	$Guardar -> txtMarca = $_POST["txtmarca"];
	$Guardar -> idMarcaEditar = $_POST["idMarcaEditar"];
	$Guardar -> tokenMarcaEditar = $_POST["tokenMarcaEditar"];
	
	$Guardar -> ajaxGuardarMarca();

}

/*=============================================
Eliminar MARCAS
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxMarcas();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarMarca();

}

/*=============================================
validar marca
=============================================*/	

if(isset($_POST["validarmarca"])){

	$validar = new AjaxMarcas();
	$validar -> validarMarcas = $_POST["validarmarca"];
	$validar -> ajaxValidarMarcas();

}



/*=============================================
LLAMAR A LA FUNCIÓN EDITAR CATEGORIAS QUE ESTA FUERA DE CLASE
=============================================*/
if(isset($_POST["descripcion"]))
{
	$consultar = new AjaxMarcas();
	$consultar -> descripcion = $_POST["descripcion"];
	$consultar -> ajaxEdtitarMarca();

}
