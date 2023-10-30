<?php

require_once "../controladores/cajas.controlador.php";
require_once "../modelos/cajas.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";
class AjaxCajas{

	/*=============================================
	Guardar CAJAS
	=============================================*/	

	public function ajaxGuardarCaja(){

		$COD_SUCURSAL;

		//$TOKEN_SUCURSAL SEPARAMOS;
		if(($this->cmbSucursal)!=""){

			$nombres = explode("/", $this->cmbSucursal);
			$COD_SUCURSAL=$nombres[0];
		}


		if(($this->tokenCaja) != ""){

			$datos = array("Sucursal" => $COD_SUCURSAL,
								"NroCaja" => $this->txtNroCaja,
								"NroFactura" => $this->txtNroFactura,
								"Timbrado" => $this->txtTimbrado,
							    "InicioVigencia" => $this->txtInicioVigencia,
								"FinVigencia" => $this->txtFinVigencia,
								"txtEquipo" => $this->txtEquipo,
								"Verificador" => $this->txtVerificador,
								"Ticket" => $this->txtTicket,
								"NC" => $this->txtNC,
								"Estado" => $this->cmbEstado,
								"tokenCaja" => $this->tokenCaja);
			
			// var_dump($datos);
			// return;

			$respuesta = ControladorCajas::ctrEditarCaja($datos);
				
			echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

			die();

		}else{

				$datos = array("Sucursal" => $COD_SUCURSAL,
								"NroCaja" => $this->txtNroCaja,
								"NroFactura" => $this->txtNroFactura,
								"Timbrado" => $this->txtTimbrado,
							    "InicioVigencia" => $this->txtInicioVigencia,
								"FinVigencia" => $this->txtFinVigencia,
								"txtEquipo" => $this->txtEquipo,
								"Verificador" => $this->txtVerificador,
								"Ticket" => $this->txtTicket,
								"NC" => $this->txtNC,
								"Estado" => $this->cmbEstado,
								"tokenCaja" => $this->tokenCaja);
				// var_dump($datos);
				// return;

				$respuesta = ControladorCajas::ctrCrearCaja($datos);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

				die();

		}

	}


	/*=============================================
	EDITAR CAJAS
	=============================================*/	

	public function ajaxEditarCaja(){

		

		$item = "TOKEN_CAJA";
		$valor = $this->token_caja;

		$item1=null;
		$valor1=null;
		$var=2;
		$respuesta = ControladorCajas::ctrMostrarCajaSucursal($item, $valor, $item1, $valor1, $var);

		echo json_encode($respuesta);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}

	/*=============================================
	Eliminar Caja
	=============================================*/	

	public $idEliminar;

	public function ajaxEliminarCaja(){
		
		$item = "TOKEN_CAJA";
		$valor = $this->idEliminar;

		$respuesta = ControladorCajas::ctrBorrarCaja($item, $valor);

		echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

		die();
	}

	/*=============================================
	CONSULTAR CANTIDAD DE CAJA POR SUCURSAL
	=============================================*/	

	public function ajaxConsultarCaja(){

		$item=null;
    	$valor=null;
		$var=1;
    	//$TOKEN_SUCURSAL SEPARAMOS;
		if(($this->sucursal)!=""){

			$nombres = explode("/", $this->sucursal);
			$valor = $nombres[0];
			$item = "COD_SUCURSAL";
			$var=null;
			// var_dump($valor);
			// return;
		}

		$respuesta = ControladorCajas::ctrMostrarCantidadCaja($item, $valor,$var);
		// var_dump($valor);
		// return;
		if(count($respuesta) > 0){

			$item1=null;
	    	$valor1=null;

	        $uso = ControladorCajas::ctrMostrarCantidadUso($item1, $valor1);

	  		
	        foreach ($uso as $key => $value) {

	        	$cantidad = $value["CANT_CAJAS"];
	        

	   //      	var_dump($cantidad);
				// return;

	        	if(intval($cantidad) > count($respuesta)){

	        		foreach ($respuesta as $key1 => $value1) {

	        			echo json_encode(count($respuesta)+1, JSON_UNESCAPED_UNICODE);
	        			die();

	        		}

	        	}else{

	        		echo json_encode("-", JSON_UNESCAPED_UNICODE);
	        		die();

	        	}

	        }

 		}else{

			echo json_encode("1", JSON_UNESCAPED_UNICODE);

			die();

 		}
	}


}

///////////////////////////////////////////////////////////////////////

/*=============================================
	GUARDAR y EDITAR CAJA
=============================================*/	

if(isset($_POST["txtNroCaja"])){

	$Guardar = new AjaxCajas();
	$Guardar -> cmbSucursal = $_POST["cmbSucursal"];
	$Guardar -> txtNroCaja = $_POST["txtNroCaja"];
	$Guardar -> txtNroFactura = $_POST["txtNroFactura"];
	$Guardar -> txtTimbrado = $_POST["txtTimbrado"];
	$Guardar -> txtInicioVigencia = $_POST["txtInicioVigencia"];
	$Guardar -> txtFinVigencia = $_POST["txtFinVigencia"];
	$Guardar -> txtEquipo = $_POST["txtEquipo"];
	$Guardar -> txtVerificador = $_POST["txtVerificador"];
	$Guardar -> txtTicket = $_POST["txtTicket"];
	$Guardar -> txtNC = $_POST["txtNC"];
	$Guardar -> txtVerificador = $_POST["txtVerificador"];
	$Guardar -> cmbEstado = $_POST["cmbEstado"];
	$Guardar -> tokenCaja = $_POST["tokenCaja"];

	// var_dump($_POST["tokenCaja"]);
	
	$Guardar -> ajaxGuardarCaja();

}

/*================================================
	EDITAR/MOSTRAR CAJA
==================================================*/
if(isset($_POST["token_caja"])){

	$editar = new AjaxCajas();
	$editar -> token_caja = $_POST["token_caja"];
	$editar -> ajaxEditarCaja();

}

/*=============================================
	Eliminar CAJA
=============================================*/	

if(isset($_POST["idEliminar"])){

	// var_dump($_POST["idEliminar"]);

	$eliminar = new AjaxCajas();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarCaja();

}

/*=============================================
	CONSULTAR CANTIDAD DE CAJA POR SUCURSAL
=============================================*/	

if(isset($_POST["sucursal"])){

	// var_dump($_POST["sucursal"]);

	$eliminar = new AjaxCajas();
	$eliminar -> sucursal = $_POST["sucursal"];
	$eliminar -> ajaxConsultarCaja();

}

