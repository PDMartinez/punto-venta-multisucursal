<?php

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class AjaxCategorias{


	/*=============================================
	EDITAR CATEGORIAS
	=============================================*/	

	public $token_categoria;

	public function ajaxEditarCategoria()
	{

		$item = "TOKEN_CATEGORIA";
		$valor = $this->token_categoria;
		
		$respuesta = ControladorCategorias::ctrMostrarCategoria($item, $valor);

		echo json_encode($respuesta);
		//var_dump($respuesta);
	}

	public function ajaxConsultarCategoria()
	{

		$item = "NOMBRE_CATEGORIA";
		$valor =$this->descripcion;
	//	var_dump($valor);
		$respuesta = ControladorCategorias::ctrMostrarCategoria($item, $valor);

		echo json_encode($respuesta);
		//var_dump($respuesta);
	}



	/*=============================================
	Guardar CATEGORIAS
	=============================================*/	

	public $txtCategoria;
	public $idCategoriaEditar;
	public $tokenCategoria;
	public function ajaxGuardarCategoria(){

		if(($this->tokenCategoria)!=""){

			$datos = array("categoria" => strtoupper($this->txtCategoria),
							"token"=>($this->tokenCategoria));
			
				$editar = ControladorCategorias::ctrEditarCategoria($datos);
				
				echo json_encode($editar,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

		}else{
				
			//var_dump($datos);
				$respuesta = ControladorCategorias::ctrCrearCategoria($this->txtCategoria);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

			}
		}


	/*=============================================
	Eliminar CATEGORIAS
	=============================================*/	

	public $idEliminar;
	
	public function ajaxEliminarCategoria(){

		$respuesta = ControladorCategorias::ctrBorrarCategoria($this->idEliminar);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
		die();
	}


}

	

/*=============================================
LLAMAR A LA FUNCIÓN EDITAR CATEGORIAS QUE ESTA FUERA DE CLASE
=============================================*/
if(isset($_POST["token_categoria"]))
{

	$editar = new AjaxCategorias();
	$editar -> token_categoria = $_POST["token_categoria"];
	$editar -> ajaxEditarCategoria();

}

/*=============================================
GUARDAR y EDITAR CATEGORIAS
=============================================*/	

if(isset($_POST["txtCategoria"])){

	$Guardar = new AjaxCategorias();
	$Guardar -> txtCategoria = $_POST["txtCategoria"];
	$Guardar -> idCategoriaEditar = $_POST["idCategoriaEditar"];
	$Guardar -> tokenCategoria = $_POST["tokenCategoria"];
	$Guardar -> ajaxGuardarCategoria();

}

/*=============================================
Eliminar CATEGORIAS
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxCategorias();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarCategoria();

}

/*=============================================
LLAMAR A LA FUNCIÓN EDITAR CATEGORIAS QUE ESTA FUERA DE CLASE
=============================================*/
if(isset($_POST["descripcion"]))
{
	$consultar = new AjaxCategorias();
	$consultar -> descripcion = $_POST["descripcion"];
	$consultar -> ajaxConsultarCategoria();

}
