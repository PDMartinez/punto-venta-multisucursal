<?php

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";


class AjaxClientes{

	public function ajaxGuardarCliente(){
		
		$COD_CIUDAD;

		//$TOKEN_CIUDAD SEPARAMOS;
		if(($this->cmbCiudad)!=""){

			$nombres = explode("/", $this->cmbCiudad);
			$COD_CIUDAD=$nombres[0];
		}


		$COD_CANAL;

		//$TOKEN_CIUDAD SEPARAMOS;
		if(($this->cmbTipoCliente)!=""){

			$nombres1 = explode("/", $this->cmbTipoCliente);
			$COD_CANAL=$nombres1[0];
		}


		if(($this->tokenCliente)!=""){

			$datos = array("Ciudad" => $COD_CIUDAD,
							"Cliente"=>$this->txtCliente,
							"Ruc"=>$this->txtRuc,
						    "Direccion" =>$this->txtDireccion,
							"ClavesCelular"=>$this->pClavesCelular,
							"Email"=>$this->txtEmail,
							"FechaNac"=> $this->txtFechaNac,
							"TipoCliente"=>$COD_CANAL,
							"Categoria"=>$this->cmbCategoria,
							"Garante"=>$this->txtGarante,
							"CedulaGarante"=> $this->txtCedulaGarante,
							"ClavesRefLaboral"=>$this->pClavesRefLaboral,
							"ClavesRefPersonal"=>$this->pClavesRefPersonal,
							"Estado"=>$this->cmbEstado,
							"Galeria"=>$this->galeria,
							"galeriaAntigua"=>$this->galeriaAntigua,
							"galeriaAntiguaEstatica"=>$this->galeriaAntiguaEstatica,
							"CedulaFrontal"=> $this->cedulaFrontal,
							"cedulaFrontalAntigua"=> $this->cedulaFrontalAntigua,
							"cedulaFrontalAntiguaEstatica"=> $this->cedulaFrontalAntiguaEstatica,
							"cedulaTrasera"=> $this->cedulaTrasera,
							"cedulaTraseraAntigua"=> $this->cedulaTraseraAntigua,
							"cedulaTraseraAntiguaEstatica"=> $this->cedulaTraseraAntiguaEstatica,
							"Latitud"=>$this->txtLatitud,
							"Longitud"=>$this->txtLongitud,
							"TokenCliente"=>$this->tokenCliente);
			
				// var_dump($datos);
				// return;
				
				$editar = ControladorClientes::ctrEditarCliente($datos);
				
				echo json_encode($editar,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

		}else{
				$datos = array("Ciudad" => $COD_CIUDAD,
							"Cliente"=>$this->txtCliente,
							"Ruc"=>$this->txtRuc,
						    "Direccion" =>$this->txtDireccion,
							"ClavesCelular"=>$this->pClavesCelular,
							"Email"=>$this->txtEmail,
							"FechaNac"=> $this->txtFechaNac,
							"TipoCliente"=>$COD_CANAL,
							"Categoria"=>$this->cmbCategoria,
							"Garante"=>$this->txtGarante,
							"CedulaGarante"=> $this->txtCedulaGarante,
							"ClavesRefLaboral"=>$this->pClavesRefLaboral,
							"ClavesRefPersonal"=>$this->pClavesRefPersonal,
							"Estado"=>$this->cmbEstado,
							"Galeria"=>$this->galeria,
							"CedulaFrontal"=> $this->cedulaFrontal,
							"CedulaTrasera"=> $this->cedulaTrasera,
							"Latitud"=>$this->txtLatitud,
							"Longitud"=>$this->txtLongitud);
				// var_dump($datos);
				// return;
				$respuesta = ControladorClientes::ctrCrearCliente($datos);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

		}

	}

	/*=============================================
	EDITAR/MOSTRAR CLIENTES
	=============================================*/	

	public function ajaxEditarCliente(){

		$item = "TOKEN_CLIENTE";
		$valor = $this->token_cliente;
		$var=1;
		$respuesta = ControladorClientes::ctrMostrarClienteCiudad($item, $valor,$var);

		echo json_encode($respuesta);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}

	/*=============================================
	Eliminar Clientes
	=============================================*/	

	public $idEliminar;

	public function ajaxEliminarCliente(){

		$datos = array( "idEliminar" => $this->idEliminar,
						"galeria" => $this->galeria,
						"cedulaFrontal" => $this->cedulaFrontal,
						"cedulaTrasera" => $this->cedulaTrasera);

		// var_dump($datos);
		// return;

		$respuesta = ControladorClientes::ctrBorrarCliente($datos);

		echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

		die();
	}


	/*=============================================
	VALIDAR RUC
	=============================================*/

	public function ajaxValidarRuc(){

		$item = "RUC";
		$valor = $this->validarRuc;
        $var=1;

		$respuesta = ControladorClientes::ctrMostrarCliente($item, $valor, $var);

		echo json_encode($respuesta);

	}

	/*=============================================
	VALIDAR EMAIL
	=============================================*/

	public function ajaxValidarEmail(){

		$item = "EMAIL";
		$valor = $this->validarEmail;
        $var=1;

		$respuesta = ControladorClientes::ctrMostrarCliente($item, $valor, $var);

		echo json_encode($respuesta);

	}

	/*=============================================
	INACTIVAR CLIENTE
	=============================================*/

	public $inactivarId;

	public function ajaxInactivarCliente(){

		$item = "COD_CLIENTE";
		$valor = $this->inactivarId;

		// $respuesta = ModeloClientes::mdlActualizarCliente($tabla, $item, $valor);
		$respuesta = ControladorClientes::ctrActualizarCliente($item, $valor);

		echo json_encode($respuesta);

	}


}


/*=============================================
GUARDAR y EDITAR CLIENTES
=============================================*/	

if(isset($_POST["txtCliente"])){

	$Guardar = new AjaxClientes();
	$Guardar -> txtCliente = $_POST["txtCliente"];
	$Guardar -> txtRuc = $_POST["txtRuc"];
	$Guardar -> cmbCiudad = $_POST["cmbCiudad"];
	$Guardar -> txtDireccion = $_POST["txtDireccion"];
	$Guardar -> pClavesCelular = $_POST["pClavesCelular"];
	$Guardar -> txtEmail = $_POST["txtEmail"];
	$Guardar -> txtFechaNac = $_POST["txtFechaNac"];
	$Guardar -> cmbTipoCliente = $_POST["cmbTipoCliente"];
	$Guardar -> cmbCategoria = $_POST["cmbCategoria"];
	$Guardar -> txtGarante = $_POST["txtGarante"];
	$Guardar -> txtCedulaGarante = $_POST["txtCedulaGarante"];
	$Guardar -> pClavesRefLaboral = $_POST["pClavesRefLaboral"];
	$Guardar -> pClavesRefPersonal = $_POST["pClavesRefPersonal"];
	$Guardar -> cmbEstado = $_POST["cmbEstado"];
	$Guardar -> galeria = $_POST["imgGaleria"];
	$Guardar -> galeriaAntigua = $_POST["imgGaleriaAntigua"];
	$Guardar -> galeriaAntiguaEstatica = $_POST["imgGaleriaAntiguaEstatica"];
	$Guardar -> cedulaFrontal = $_POST["cedulaFrontal"];
	$Guardar -> cedulaFrontalAntigua = $_POST["cedulaFrontalAntigua"];
	$Guardar -> cedulaFrontalAntiguaEstatica = $_POST["cedulaFrontalAntiguaEstatica"];
	$Guardar -> cedulaTrasera = $_POST["cedulaTrasera"];
	$Guardar -> cedulaTraseraAntigua = $_POST["cedulaTraseraAntigua"];
	$Guardar -> cedulaTraseraAntiguaEstatica = $_POST["cedulaTraseraAntiguaEstatica"];
	$Guardar -> txtLatitud = $_POST["txtLatitud"];
	$Guardar -> txtLongitud = $_POST["txtLongitud"];
	$Guardar -> tokenCliente = $_POST["tokenCliente"];
	
	$Guardar -> ajaxGuardarCliente();

}

/*================================================
	EDITAR/MOSTRAR CLIENTE
==================================================*/
if(isset($_POST["token_cliente"])){

	$editar = new AjaxClientes();
	$editar -> token_cliente = $_POST["token_cliente"];
	$editar -> ajaxEditarCliente();

}

/*=============================================
	Eliminar Cliente
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxClientes();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> galeria = $_POST["galeria"];
	$eliminar -> cedulaFrontal = $_POST["cedulaFrontal"];
	$eliminar -> cedulaTrasera = $_POST["cedulaTrasera"];
	$eliminar -> ajaxEliminarCliente();

}

/*=============================================
	Eliminar Cliente
=============================================*/	

if(isset($_POST["inactivarId"])){

	$inactivar = new AjaxClientes();
	$inactivar -> inactivarId = $_POST["inactivarId"];
	$inactivar -> ajaxInactivarCliente();

}

/*=============================================
 VALIDAR QUE NO SE REPITA EL RUC
=============================================*/	

if(isset($_POST["validarRuc"])){

	$validar = new AjaxClientes();
	$validar -> validarRuc = $_POST["validarRuc"];
	$validar -> ajaxValidarRuc();

}

/*=============================================
 VALIDAR QUE NO SE REPITA EL EMAIL
=============================================*/	

if(isset($_POST["validarEmail"])){

	$validar = new AjaxClientes();
	$validar -> validarEmail = $_POST["validarEmail"];
	$validar -> ajaxValidarEmail();

}
