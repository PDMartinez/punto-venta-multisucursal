<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";
require_once "../controladores/perfiles.controlador.php";
require_once "../modelos/perfiles.modelo.php";

class AjaxUsuarios{

	public $validarUsuario;

	public function ajaxValidarUsuario(){

		$item = "USUARIO";
		$valor = $this->validarUsuario;

		$respuesta = ControladorUsuarios::ctrMostrarUsuario($item, $valor);

		echo json_encode($respuesta);

	}


	public $validarPrincipal;

	public function ajaxValidarPrincipal(){

		$item = "SUPER_PERFIL";
		$valor = $this->validarPrincipal;

		$respuesta = ControladorPerfiles::ctrMostrarPerfil($item, $valor,null);

		echo json_encode($respuesta);

	}



	/*=============================================
	EDITAR USUARIOS
	=============================================*/	

	public $token_Usuario;

	public function ajaxEditarUsuario()
	{

		$item = "TOKEN_USUARIO";
		$valor = $this->token_Usuario;
		$respuesta = ControladorUsuarios::ctrMostrarUsuario($item, $valor);

		echo json_encode($respuesta);
		//var_dump($respuesta);
	}



	/*=============================================
	Guardar Perfiles
	=============================================*/	

	public $cmbFuncionario;
	public $txtUsuario;
	public $txtPassword;
	public $idUsuarioEditar;
	public $tokenUsuario;
	//public $principal;
	public $cmbPerfil;
	public $cmbSucursal;
	public $txtHorad;
	public $txtHorah;
	public $imgGaleria;
	public $imgGaleriaAntigua;
	public $imgGaleriaAntiguaEstatica;
	public $cmbEstado;
	public $intento;
	public $perfil;

	public function ajaxGuardarUsuario(){
		$COD_FUNCIONARIO;
		$COD_PERFIL;
		$COD_SUCURSAL;
		//$TOKEN_CIUDAD;
		if(($this->cmbPerfil)!=""){
			$nombres = explode("/", $this->cmbPerfil);
			$COD_PERFIL=$nombres[0];
		//	$TOKEN_CIUDAD=$nombres[1];
		}

		if(($this->cmbFuncionario)!=""){
			$nombres = explode("/", $this->cmbFuncionario);
			$COD_FUNCIONARIO=$nombres[0];
		//	$TOKEN_CIUDAD=$nombres[1];
		}

		if(($this->cmbSucursal)!=""){
			$nombres = explode("/", $this->cmbSucursal);
			$COD_SUCURSAL=$nombres[0];
		//	$TOKEN_CIUDAD=$nombres[1];
		}


		if(($this->tokenUsuario)!=""){

			$datos = array("perfil" => ($COD_PERFIL),
							"usuario"=>($this->txtUsuario),
							"token"=>$this->tokenUsuario,
							"sucursal"=> $COD_SUCURSAL,
						    "funcionario" =>$COD_FUNCIONARIO,
							"horadesde"=>$this->txtHorad,
							"horahasta"=> $this->txtHorah,
							"imgGaleria"=>($this->imgGaleria),
							"imgGaleriaAntigua"=>($this->imgGaleriaAntigua),
							"imgGaleriaAntiguaEstatica"=>($this->imgGaleriaAntiguaEstatica),
							"estado"=> $this->cmbEstado,
							"intento"=>$this->intento,
							"perfilDesc"=>$this->perfil);
			
				  // var_dump($datos);
				 // return;
				$editar = ControladorUsuarios::ctrEditarUsuario($datos);
				
				echo json_encode($editar,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

			}else{
				$datos = array("perfil" => ($COD_PERFIL),
							"usuario"=>($this->txtUsuario),
							"clave"=>($this->txtPassword),
							"sucursal"=> $COD_SUCURSAL,
						    "funcionario" =>$COD_FUNCIONARIO,
							"horadesde"=>$this->txtHorad,
							"horahasta"=> $this->txtHorah,
							"imgGaleria"=>($this->imgGaleria),
							"estado"=> $this->cmbEstado,
							"perfilDesc"=>$this->perfil);
			//var_dump($datos);
			// return;
				$respuesta = ControladorUsuarios::ctrCrearUsuario($datos);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

			}
		}


	/*=============================================
	Eliminar PERFILES
	=============================================*/	

	public $idEliminar;
	public $galeria;
	public function ajaxEliminarUsuario(){

		$datos = array( "idEliminar" => $this->idEliminar,
						"galeria" => $this->galeria);

		$respuesta = ControladorUsuarios::ctrBorrarUsuario($datos);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
		die();
	}


}

	

/*=============================================
LLAMAR A LA FUNCIÓN EDITAR PREFILES QUE ESTA FUERA DE CLASE
=============================================*/
if(isset($_POST["token_usuario"]))
{

	$editar = new AjaxUsuarios();
	$editar -> token_Usuario = $_POST["token_usuario"];
	$editar -> ajaxEditarUsuario();

}

/*=============================================
GUARDAR y EDITAR PERFIL
=============================================*/	

if(isset($_POST["txtUsuario"])){

	$Guardar = new AjaxUsuarios();
	$Guardar -> cmbFuncionario = $_POST["cmbFuncionario"];
	$Guardar -> txtUsuario = $_POST["txtUsuario"];
	$Guardar -> txtPassword = $_POST["txtPassword"];
	$Guardar -> idUsuarioEditar = $_POST["idUsuarioEditar"];
	$Guardar -> tokenUsuario = $_POST["tokenUsuario"];
	$Guardar -> cmbPerfil = $_POST["cmbPerfil"];
	$Guardar -> cmbSucursal = $_POST["cmbSucursal"];
	$Guardar -> txtHorad = $_POST["txtHorad"];
	$Guardar -> txtHorah = $_POST["txtHorah"];
	$Guardar -> cmbEstado = $_POST["cmbEstado"];
	$Guardar -> imgGaleria = $_POST["imgGaleria"];
	$Guardar -> imgGaleriaAntigua = $_POST["imgGaleriaAntigua"];
	$Guardar -> imgGaleriaAntiguaEstatica = $_POST["imgGaleriaAntiguaEstatica"];
	$Guardar -> intento = $_POST["intento"];
	$Guardar -> perfil = $_POST["perfil"];
	
	
	$Guardar -> ajaxGuardarUsuario();

}

/*=============================================
Eliminar Perfil
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxUsuarios();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> galeria = $_POST["galeria"];
	$eliminar -> ajaxEliminarUsuario();

}

/*=============================================
 validar que no se repita el nombre
=============================================*/	

if(isset($_POST["validarUsuario"])){

	$validar = new AjaxUsuarios();
	$validar -> validarUsuario = $_POST["validarUsuario"];
	$validar -> ajaxValidarUsuario();

}

/*=============================================
 validar que se seleccione almenos 1 Usuario
=============================================*/	

if(isset($_POST["validarPrincipal"])){

	$validar = new AjaxUsuarios();
	$validar -> validarPrincipal = $_POST["validarPrincipal"];
	$validar -> ajaxValidarPrincipal();

}

