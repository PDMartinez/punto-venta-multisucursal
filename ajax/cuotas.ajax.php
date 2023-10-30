<?php

require_once "../controladores/cuotas.controlador.php";
require_once "../modelos/cuotas.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class AjaxCuotas{

	/*=============================================
	Guardar Descuentos
	=============================================*/	
	public $txtDescuento;

	public function ajaxGuardarCuota(){

		//$TOKEN canal SEPARAMOS;
		// if(($this->idCuotas)!=""){

		// 	$nombres = explode("/", $this->idCuotas);
		// 	$COD_CANAL=$nombres[0];
		// }

		if(($this->tokenCuotas) != ""){

			$datos = array("txtRecargo" => $this->txtRecargo,
							"txtDesde" => $this->txtDesde,
							"txtHasta" => $this->txtHasta,
							"cmbEstado" => $this->cmbEstado,
							"tokenCuotas" => $this->tokenCuotas);
			
			 // var_dump($datos);
			 // return;

			$respuesta = ControladorCuotas::ctrEditarCuota($datos);
				
			echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

			die();

		}else{

				$datos = array(	"txtRecargo" => $this->txtRecargo,
								"txtDesde" => $this->txtDesde,
								"txtHasta" => $this->txtHasta,
								"idUsuario" => $this->idUsuario,
								"cmbEstado" => $this->cmbEstado);
				// var_dump($datos);
				// return;

				$respuesta = ControladorCuotas::ctrCrearCuota($datos);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

				die();

		}

	}


	/*=============================================
	EDITAR DESCUENTOS
	=============================================*/	

	public function ajaxEditarCuotas(){

		$item="TOKEN_CUOTA";
    	$valor=$this->token_cuotas;

         $var=1;
        $order="COD_CUOTA ASC";

        $respuesta = ControladorCuotas::ctrMostrarCuota($item, $valor, $var, $order);

		echo json_encode($respuesta);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}

	/*=============================================
	Eliminar Descuentos
	=============================================*/	

	public $idEliminar;

	public function ajaxEliminarCuota(){
		
		$item = "TOKEN_CUOTA";
		$valor = $this->idEliminar;

		$respuesta = ControladorCuotas::ctrBorrarCuotas($item, $valor);

		echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

		die();
	}


	/*=============================================
	Mostrar Descuentos
	=============================================*/	

	public function ajaxMostrarCuotas(){

	
			$item=null;
	    	$valor=null;
	        $var=null;
	        $order="COD_CUOTA ASC";

			$respuesta = ControladorCuotas::ctrMostrarCuota($item, $valor, $var, $order);
				
			echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
			die();
	}


}

///////////////////////////////////////////////////////////////////////

/*=============================================
	GUARDAR y EDITAR DESCUENTO
=============================================*/	

if(isset($_POST["txtRecargo"])){

	$Guardar = new AjaxCuotas();
	$Guardar -> idUsuario = $_POST["idUsuario"];
	$Guardar -> txtRecargo = $_POST["txtRecargo"];
	$Guardar -> txtDesde = $_POST["txtDesde"];
	$Guardar -> txtHasta = $_POST["txtHasta"];
	$Guardar -> tokenCuotas = $_POST["tokenCuotas"];
	$Guardar -> cmbEstado = $_POST["cmbEstado"];
	
	$Guardar -> ajaxGuardarCuota();

}

/*================================================
	EDITAR/MOSTRAR DESCUENTO
==================================================*/
if(isset($_POST["token_cuotas"])){

	$editar = new AjaxCuotas();
	$editar -> token_cuotas = $_POST["token_cuotas"];
	$editar -> ajaxEditarCuotas();

}

/*=============================================
	Eliminar Descuento
=============================================*/	

if(isset($_POST["idEliminar"])){

	//echo'<script>alert("'.$_POST["idEliminar"].'");</script>';

	$eliminar = new AjaxCuotas();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarCuota();

}

/*=============================================
	Eliminar Descuento
=============================================*/	

if(isset($_POST["extraer"])){

	//echo'<script>alert("'.$_POST["idEliminar"].'");</script>';

	$eliminar = new AjaxCuotas();
	$eliminar -> extraer = $_POST["extraer"];
	$eliminar -> ajaxMostrarCuotas();

}


