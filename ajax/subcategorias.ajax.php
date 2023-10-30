<?php

require_once "../controladores/subcategorias.controlador.php";
require_once "../modelos/subcategorias.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class AjaxSubCategorias{


	/*=============================================
	EDITAR CATEGORIAS
	=============================================*/	

	public $token_subcategoria;

	public function ajaxEditarSubCategoria()
	{

		$item = "TOKEN_SUBCATEGORIA";
		$valor = $this->token_subcategoria;
		
		$respuesta = ControladorSubCategorias::ctrMostrarSubCategoria($item, $valor);

		echo json_encode($respuesta);
		//var_dump($respuesta);
	}



	/*=============================================
	Guardar CATEGORIAS
	=============================================*/	

	public $txtSubCategoria;
	public $idSubCategoriaEditar;
	public $tokenSubCategoria;
	public function ajaxGuardarSubCategoria(){

		if(($this->tokenSubCategoria)!=""){

			$datos = array("subcategoria" => strtoupper($this->txtSubCategoria),
							"token"=>($this->tokenSubCategoria));
			
				$editar = ControladorSubCategorias::ctrEditarSubCategoria($datos);
				
				echo json_encode($editar,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

		}else{
				
			//var_dump($datos);
				$respuesta = ControladorSubCategorias::ctrCrearSubCategoria($this->txtSubCategoria);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

			}
		}

			public function ajaxConsultarCategoria()
				{

					$item = "NOMBRE_SUBCATEGORIA";
					$valor =$this->descripcion;
				//	var_dump($valor);
					$respuesta = ControladorSubCategorias::ctrMostrarSubCategoria($item, $valor);

					echo json_encode($respuesta);
					//var_dump($respuesta);
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
if(isset($_POST["token_subcategoria"]))
{

	$editar = new AjaxSubCategorias();
	$editar -> token_subcategoria = $_POST["token_subcategoria"];
	$editar -> ajaxEditarSubCategoria();

}

/*=============================================
GUARDAR y EDITAR CATEGORIAS
=============================================*/	

if(isset($_POST["txtSubCategoria"])){

	$Guardar = new AjaxSubCategorias();
	$Guardar -> txtSubCategoria = $_POST["txtSubCategoria"];
	$Guardar -> idSubCategoriaEditar = $_POST["idSubCategoriaEditar"];
	$Guardar -> tokenSubCategoria = $_POST["tokenSubCategoria"];
	$Guardar -> ajaxGuardarSubCategoria();

}

/*=============================================
Eliminar CATEGORIAS
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxSubCategorias();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarCategoria();

}

/*=============================================
LLAMAR A LA FUNCIÓN EDITAR CATEGORIAS QUE ESTA FUERA DE CLASE
=============================================*/
if(isset($_POST["descripcion"]))
{
	$consultar = new AjaxSubCategorias();
	$consultar -> descripcion = $_POST["descripcion"];
	$consultar -> ajaxConsultarCategoria();

}
