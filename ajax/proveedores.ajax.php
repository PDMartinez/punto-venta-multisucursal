<?php

require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";
// require_once "../controladores/ciudades.controlador.php";
// require_once "../modelos/ciudades.modelo.php";

class AjaxProveedores{

	/*=============================================
	Guardar Proveedores
	=============================================*/	

	public function ajaxGuardarProveedor(){

		$COD_CIUDAD;

		//$TOKEN_CIUDAD SEPARAMOS;
		if(($this->cmbCiudad)!=""){

			$nombres = explode("/", $this->cmbCiudad);
			$COD_CIUDAD=$nombres[0];
		}


		if(($this->tokenProveedor) != ""){

			$datos = array("Empresa" => $this->txtEmpresa,
							"RUC" => $this->txtRUC,
							"Ciudad" => $COD_CIUDAD,
							"Direccion" => $this->txtDireccion,
						    "Telefono" => $this->txtTelefono,
							"Celular" => $this->txtCelular,
							"Email" => $this->txtEmail,
							"Estado" => $this->cmbEstado,
							"tokenProveedor" => $this->tokenProveedor);
			
				//var_dump($datos);
				//return;

				$respuesta = ControladorProveedores::ctrEditarProveedor($datos);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

				die();

		}else{

				$datos = array("Empresa" => $this->txtEmpresa,
								"RUC"=> $this->txtRUC,
								"Ciudad"=> $COD_CIUDAD,
								"Direccion"=> $this->txtDireccion,
							    "Telefono" => $this->txtTelefono,
								"Celular"=> $this->txtCelular,
								"Email" => $this->txtEmail,
								"Estado" => $this->cmbEstado);
				//var_dump($datos);
				//return;

				$respuesta = ControladorProveedores::ctrCrearProveedor($datos);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

				die();

		}

	}


	/*=============================================
	EDITAR Proveedores
	=============================================*/	

	public $token_proveedor;

	public function ajaxEditarProveedor(){

		$item = "TOKEN_PROVEEDOR";
		$valor = $this->token_proveedor;
		$respuesta = ControladorProveedores::ctrMostrarProveedorCiudad($item, $valor);

		echo json_encode($respuesta);//se imprime para que se pueda ver en el js
		//var_dump($respuesta);

	}

	/*=============================================
	Eliminar Proveedor
	=============================================*/	

	public $idEliminar;

	public function ajaxEliminarProveedor(){
		
		$item = "TOKEN_PROVEEDOR";
		$valor = $this->idEliminar;

		$respuesta = ControladorProveedores::ctrBorrarProveedor($item, $valor);

		echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

		die();
	}


}

///////////////////////////////////////////////////////////////////////

/*=============================================
	GUARDAR y EDITAR PROVEEDOR
=============================================*/	

if(isset($_POST["txtEmpresa"])){

	$Guardar = new AjaxProveedores();
	$Guardar -> txtEmpresa = $_POST["txtEmpresa"];
	$Guardar -> txtRUC = $_POST["txtRUC"];
	$Guardar -> cmbCiudad = $_POST["cmbCiudad"];
	$Guardar -> txtDireccion = $_POST["txtDireccion"];
	$Guardar -> txtTelefono = $_POST["txtTelefono"];
	$Guardar -> txtCelular = $_POST["txtCelular"];
	$Guardar -> txtEmail = $_POST["txtEmail"];
	$Guardar -> cmbEstado = $_POST["cmbEstado"];
	$Guardar -> tokenProveedor = $_POST["tokenProveedor"];
	
	$Guardar -> ajaxGuardarProveedor();

}

/*================================================
	EDITAR PROVEEDOR
==================================================*/
if(isset($_POST["token_proveedor"])){

	$editar = new AjaxProveedores();
	$editar -> token_proveedor = $_POST["token_proveedor"];
	$editar -> ajaxEditarProveedor();

}

/*=============================================
	Eliminar Proveedor
=============================================*/	

if(isset($_POST["idEliminar"])){

	//echo'<script>alert("'.$_POST["idEliminar"].'");</script>';

	$eliminar = new AjaxProveedores();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarProveedor();

}
