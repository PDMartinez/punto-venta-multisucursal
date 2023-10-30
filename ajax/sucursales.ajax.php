<?php

require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursales.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class AjaxSucursales{

	public $validarSucursal;

	public function ajaxValidarSucursal(){

		$item = "SUCURSAL";
		$valor = $this->validarSucursal;

		$respuesta = ControladorSucursales::ctrMostrarSucursal($item, $valor,1);

		echo json_encode($respuesta);

	}


	public $validarPrincipal;

	public function ajaxValidarPrincipal(){

		$item = "PRINCIPAL";
		$valor = $this->validarPrincipal;

		$respuesta = ControladorSucursales::ctrMostrarSucursal($item, $valor,null);

		echo json_encode($respuesta);

	}



	/*=============================================
	EDITAR PERFILES
	=============================================*/	

	public $token_sucursal;

	public function ajaxEditarSucursal()
	{

		$item = "TOKEN_SUCURSAL";
		$valor = $this->token_sucursal;
		
		$respuesta = ControladorSucursales::ctrMostrarSucursalInner($item, $valor);

		echo json_encode($respuesta);
		//var_dump($respuesta);
	}



	/*=============================================
	Guardar Perfiles
	=============================================*/	

	public $txtSucursal;
	public $txtEncargado;
	public $txtDireccion;
	public $idSucursalEditar;
	public $tokenSucursal;
	public $principal;
	public $cmbCiudad;
	public $txtVerificador;
	public $txtpedidos;
	public $txtRemision;
	public $txtTelefono;
	public $imgGaleria;
	public $imgGaleriaAntigua;
	public $imgGaleriaAntiguaEstatica;
	public $cmbEstado;
	public $ruc;

	public function ajaxGuardarSucursal(){
		$COD_CIUDAD;
		//$TOKEN_CIUDAD;
		if(($this->cmbCiudad)!=""){
			$nombres = explode("-", $this->cmbCiudad);
			$COD_CIUDAD=$nombres[0];
		//	$TOKEN_CIUDAD=$nombres[1];
		}


		if(($this->tokenSucursal)!=""){

			$datos = array("sucursal" => strtoupper($this->txtSucursal),
							"encargado"=>strtoupper($this->txtEncargado),
							"direccion"=>strtoupper($this->txtDireccion),
							"tokensucursal"=>$this->tokenSucursal,
							"ciudad"=> $COD_CIUDAD,
						    "verificador" =>$this->txtVerificador,
							"pedidos"=>$this->txtpedidos,
							"remision"=> $this->txtRemision,
							"telefono"=>($this->txtTelefono),
							"imgGaleria"=>($this->imgGaleria),
							"imgGaleriaAntigua"=>($this->imgGaleriaAntigua),
							"imgGaleriaAntiguaEstatica"=>($this->imgGaleriaAntiguaEstatica),
							"estado"=> $this->cmbEstado,
							"ruc"=> $this->ruc,
							"principal"=>$this->principal);
			
				 // var_dump($datos);
				 // return;
				$editar = ControladorSucursales::ctrEditarSucursal($datos);
				
				echo json_encode($editar,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

			}else{
				$datos = array("sucursal" => strtoupper($this->txtSucursal),
							"encargado"=>strtoupper($this->txtEncargado),
							"direccion"=>strtoupper($this->txtDireccion),
							"ciudad"=> $this->cmbCiudad,
						    "verificador" =>$this->txtVerificador,
							"pedidos"=>$this->txtpedidos,
							"remision"=> $this->txtRemision,
							"telefono"=>($this->txtTelefono),
							"imgGaleria"=>($this->imgGaleria),
							"estado"=> $this->cmbEstado,
							"ruc"=> $this->ruc,
							"principal"=>$this->principal);
			//var_dump($datos);
			// return;
				$respuesta = ControladorSucursales::ctrCrearSucursal($datos);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

			}
		}


	/*=============================================
	Eliminar PERFILES
	=============================================*/	

	public $idEliminar;
	public $galeria;
	public function ajaxEliminarSucursal(){

		$datos = array( "idEliminar" => $this->idEliminar,
						"galeria" => $this->galeria);

		$respuesta = ControladorSucursales::ctrBorrarSucursal($datos);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
		die();
	}


}

	

/*=============================================
LLAMAR A LA FUNCIÓN EDITAR PREFILES QUE ESTA FUERA DE CLASE
=============================================*/
if(isset($_POST["token_sucursal"]))
{

	$editar = new AjaxSucursales();
	$editar -> token_sucursal = $_POST["token_sucursal"];
	$editar -> ajaxEditarSucursal();

}

/*=============================================
GUARDAR y EDITAR PERFIL
=============================================*/	

if(isset($_POST["txtSucursal"])){

	$Guardar = new AjaxSucursales();
	$Guardar -> txtSucursal = $_POST["txtSucursal"];
	$Guardar -> txtEncargado = $_POST["txtEncargado"];
	$Guardar -> txtDireccion = $_POST["txtDireccion"];
	$Guardar -> idSucursalEditar = $_POST["idSucursalEditar"];
	$Guardar -> tokenSucursal = $_POST["tokenSucursal"];
	$Guardar -> cmbCiudad = $_POST["cmbCiudad"];
	$Guardar -> txtVerificador = $_POST["txtVerificador"];
	$Guardar -> txtpedidos = $_POST["txtpedidos"];
	$Guardar -> txtRemision = $_POST["txtRemision"];
	$Guardar -> txtTelefono = $_POST["txtTelefono"];
	$Guardar -> cmbEstado = $_POST["cmbEstado"];
	$Guardar -> imgGaleria = $_POST["imgGaleria"];
	$Guardar -> imgGaleriaAntigua = $_POST["imgGaleriaAntigua"];
	$Guardar -> imgGaleriaAntiguaEstatica = $_POST["imgGaleriaAntiguaEstatica"];
	$Guardar -> ruc = $_POST["txtRuc"];
	$Guardar -> principal = $_POST["principal"];
	
	$Guardar -> ajaxGuardarSucursal();

}

/*=============================================
Eliminar Perfil
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxSucursales();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> galeria = $_POST["galeria"];
	$eliminar -> ajaxEliminarSucursal();

}

/*=============================================
 validar que no se repita el nombre
=============================================*/	

if(isset($_POST["validarSucursal"])){

	$validar = new AjaxSucursales();
	$validar -> validarSucursal = $_POST["validarSucursal"];
	$validar -> ajaxValidarSucursal();

}

/*=============================================
 validar que se seleccione almenos 1 sucursal
=============================================*/	

if(isset($_POST["validarPrincipal"])){

	$validar = new AjaxSucursales();
	$validar -> validarPrincipal = $_POST["validarPrincipal"];
	$validar -> ajaxValidarPrincipal();

}

