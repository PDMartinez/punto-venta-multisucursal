<?php

require_once "../controladores/perfiles.controlador.php";
require_once "../modelos/perfiles.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class AjaxPerfiles{


	/*=============================================
	EDITAR PERFILES
	=============================================*/	

	public $token_perfil;

	public function ajaxEditarPerfil()
	{

		$item = "TOKEN_PERFIL";
		$valor = $this->token_perfil;
		
		$respuesta = ControladorPerfiles::ctrMostrarPerfil($item, $valor,1);

		echo json_encode($respuesta);
		//var_dump($respuesta);
	}



	/*=============================================
	Guardar Perfiles
	=============================================*/	

	public $txtNombre;
	public $txtDescripcion;
	public $chkActivo;
	public $idPerfilEditar;
	public $tokenPerfil;
	public $estado;
	public $principal;
	public function ajaxGuardarPerfil(){

		if(($this->tokenPerfil)!=""){

			$datos = array("perfil" => strtoupper($this->txtNombre),
							"descripcion"=>strtoupper($this->txtDescripcion),
							"idPerfil"=>($this->tokenPerfil),
							"estado"=>($this->estado),
							"activo"=> $this->chkActivo,
							"principal"=>$this->principal);
			
				$editar = ControladorPerfiles::ctrEditarPerfil($datos);
				
				echo json_encode($editar,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

		}else{
				$datos = array("perfil" => strtoupper($this->txtNombre),
								"descripcion"=>strtoupper($this->txtDescripcion),
								"estado"=>($this->estado),
								"activo"=> $this->chkActivo,
								"principal"=>$this->principal);
			//var_dump($datos);
				$respuesta = ControladorPerfiles::ctrCrearPerfil($datos);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

			}
		}


	/*=============================================
	Eliminar PERFILES
	=============================================*/	

	public $idEliminar;
	
	public function ajaxEliminarPerfil(){

		$respuesta = ControladorPerfiles::ctrBorrarPerfil($this->idEliminar);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
		die();
	}


}

	

/*=============================================
LLAMAR A LA FUNCIÓN EDITAR PREFILES QUE ESTA FUERA DE CLASE
=============================================*/
if(isset($_POST["token_perfil"]))
{

	$editar = new AjaxPerfiles();
	$editar -> token_perfil = $_POST["token_perfil"];
	$editar -> ajaxEditarPerfil();

}

/*=============================================
GUARDAR y EDITAR PERFIL
=============================================*/	

if(isset($_POST["txtNombre"])){

	$Guardar = new AjaxPerfiles();
	$Guardar -> txtNombre = $_POST["txtNombre"];
	$Guardar -> txtDescripcion = $_POST["txtDescripcion"];
	$Guardar -> chkActivo = $_POST["chkActivo"];
	$Guardar -> idPerfilEditar = $_POST["idPerfilEditar"];
	$Guardar -> tokenPerfil = $_POST["tokenPerfil"];
	$Guardar -> estado = $_POST["estado"];
	$Guardar -> principal = $_POST["principal"];
	$Guardar -> ajaxGuardarPerfil();

}

/*=============================================
Eliminar Perfil
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxPerfiles();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarPerfil();

}
