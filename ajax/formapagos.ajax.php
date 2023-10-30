<?php

require_once "../controladores/formapagos.controlador.php";
require_once "../modelos/formapagos.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class AjaxFormaPagos{


	/*=============================================
	EDITAR Formas de pagos
	=============================================*/	

	public $token_formapagos;

	public function ajaxEditarFormapago()
	{

		$item = "TOKEN_FORMAPAGO";
		$valor = $this->token_formapagos;
		
		$respuesta = ControladorFormaPagos::ctrMostrarFormapago($item, $valor);

		echo json_encode($respuesta);
		//var_dump($respuesta);
	}



	/*=============================================
	Guardar Formas de pagos
	=============================================*/	

	public $txtFormaPagos;
	public $idFormapagosEditar;
	public $tokenFormapagos;
	public function ajaxGuardarFormapagos(){

		if(($this->tokenFormapagos)!=""){

			$datos = array("formapagos" => strtoupper($this->txtFormaPagos),
							"activoefectivo" => $this->activoefectivo,
							"token"=>$this->tokenFormapagos);
			
				$editar = ControladorFormaPagos::ctrEditarFormaPago($datos);
				
				echo json_encode($editar,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

		}else{
				
			//var_dump($datos);
			$datos = array("formapagos" => strtoupper($this->txtFormaPagos),
							"activoefectivo" => $this->activoefectivo);
				$respuesta = ControladorFormaPagos::ctrCrearFormaPago($datos);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

			}
		}


	/*=============================================
	Eliminar Formas de pagos
	=============================================*/	

	public $idEliminar;
	
	public function ajaxEliminarFormaPagos(){

		$respuesta = ControladorFormaPagos::ctrBorrarFormapago($this->idEliminar);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
		die();
	}



	public function ajaxAnularFormaPagos(){


		if($this->estado==1){
			$estadoNUevo=0;
		}else{
			$estadoNUevo=1;
		}
		$item = "ESTADO_FORMA";
		$valor = $estadoNUevo;
		$item1 = "TOKEN_FORMAPAGO";
		$valor1 = $this->idAnular;
		//var_dump($valor1);
		$respuesta = ControladorFormaPagos::ctrAnularFormapagos($item,$valor,$item1,$valor1);

		echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

		die();
	}


}

	

/*=============================================
LLAMAR A LA FUNCIÓN EDITAR Formas de pagos
=============================================*/
if(isset($_POST["token_formapagos"]))
{

	$editar = new AjaxFormaPagos();
	$editar -> token_formapagos = $_POST["token_formapagos"];
	$editar -> ajaxEditarFormapago();

}

/*=============================================
GUARDAR y EDITAR Formas de pagos
=============================================*/	

if(isset($_POST["txtFormaPagos"])){

	$Guardar = new AjaxFormaPagos();
	$Guardar -> txtFormaPagos = $_POST["txtFormaPagos"];
	$Guardar -> idFormapagosEditar = $_POST["idFormaPagosEditar"];
	$Guardar -> tokenFormapagos = $_POST["TokenFormaPagos"];
	$Guardar -> activoefectivo = $_POST["activoefectivo"];
	$Guardar -> ajaxGuardarFormapagos();

}

/*=============================================
Eliminar Forma de pagos
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxFormaPagos();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarFormaPagos();

}


/*=============================================
Anular Forma de pagos
=============================================*/	

if(isset($_POST["idAnular"])){

	$Anular = new AjaxFormaPagos();
	$Anular -> idAnular = $_POST["idAnular"];
	$Anular -> estado = $_POST["estado"];
	$Anular -> ajaxAnularFormaPagos();

}

