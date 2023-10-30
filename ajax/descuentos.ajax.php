<?php

require_once "../controladores/descuentos.controlador.php";
require_once "../modelos/descuentos.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";
class AjaxDescuentos{

	/*=============================================
	Guardar Descuentos
	=============================================*/	
	public $txtDescuento;

	public function ajaxGuardarDescuento(){

		//$TOKEN canal SEPARAMOS;
		if(($this->cmbCanal)!=""){

			$nombres = explode("/", $this->cmbCanal);
			$COD_CANAL=$nombres[0];
		}

		if(($this->tokenDescuento) != ""){

			$datos = array("canal" => $COD_CANAL,
							"txtDescuento" => $this->txtDescuento,
							"txtDesde" => $this->txtDesde,
							"txtHasta" => $this->txtHasta,
							// "estado" => $this->estado,
							"tokenDescuento" => $this->tokenDescuento);
			
			 // var_dump($datos);
			 // return;

			$respuesta = ControladorDescuentos::ctrEditarDescuento($datos);
				
			echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

			die();

		}else{

				$datos = array("canal" => $COD_CANAL,
								"txtDescuento" => $this->txtDescuento,
								"txtDesde" => $this->txtDesde,
								"txtHasta" => $this->txtHasta,
								"tokenDescuento" => $this->tokenDescuento);
				// var_dump($datos);
				// return;

				$respuesta = ControladorDescuentos::ctrCrearDescuento($datos);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

				die();

		}

	}


	/*=============================================
	EDITAR DESCUENTOS
	=============================================*/	

	public function ajaxEditarDescuento(){

		$item="TOKEN";
    	$valor=$this->token_descuento;

        $respuesta = ControladorDescuentos::ctrMostrarDescuentoCanal($item, $valor);

		echo json_encode($respuesta);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}

	/*=============================================
	Eliminar Descuentos
	=============================================*/	

	public $idEliminar;

	public function ajaxEliminarDescuento(){
		
		$item = "TOKEN";
		$valor = $this->idEliminar;

		$respuesta = ControladorDescuentos::ctrBorrarDescuento($item, $valor);

		echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

		die();
	}


	/*=============================================
	Mostrar Descuentos
	=============================================*/	

	public function ajaxMostrarDescuento(){

		//$TOKEN canal SEPARAMOS;
		if(($this->idCanal)!=""){

			$nombres = explode("/", $this->idCanal);
			$COD_CANAL=$nombres[0];

			// $datos = array("canal" => $COD_CANAL);
			
			// var_dump($datos);
			// return;
			// $tabla = "detcanal";
			$item="COD_CANAL";
	    	$valor=$COD_CANAL;
	        $var=null;
	        $order="MONTO_DESDE ASC";

			$respuesta = ControladorDescuentos::ctrMostrarDescuento($item, $valor, $var, $order);
				
			echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

			die();

		}

	}


}

///////////////////////////////////////////////////////////////////////

/*=============================================
	GUARDAR y EDITAR DESCUENTO
=============================================*/	

if(isset($_POST["txtDescuento"])){

	$Guardar = new AjaxDescuentos();
	$Guardar -> cmbCanal = $_POST["cmbCanal"];
	$Guardar -> txtDescuento = $_POST["txtDescuento"];
	$Guardar -> txtDesde = $_POST["txtDesde"];
	$Guardar -> txtHasta = $_POST["txtHasta"];
	$Guardar -> tokenDescuento = $_POST["tokenDescuento"];
	// $Guardar -> estado = $_POST["estado"];

	// var_dump($_POST["txtDescuento"]);
	
	$Guardar -> ajaxGuardarDescuento();

}

/*================================================
	EDITAR/MOSTRAR DESCUENTO
==================================================*/
if(isset($_POST["token_descuento"])){

	$editar = new AjaxDescuentos();
	$editar -> token_descuento = $_POST["token_descuento"];
	$editar -> ajaxEditarDescuento();

}

/*=============================================
	Eliminar Descuento
=============================================*/	

if(isset($_POST["idEliminar"])){

	//echo'<script>alert("'.$_POST["idEliminar"].'");</script>';

	$eliminar = new AjaxDescuentos();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarDescuento();

}

/*=============================================
	Mostrar Descuento
=============================================*/	

if(isset($_POST["canal"])){

	$mostrar = new AjaxDescuentos();
	$mostrar -> idCanal = $_POST["canal"];
	$mostrar -> ajaxMostrarDescuento();

}

