<?php

require_once "../controladores/apertura.controlador.php";
require_once "../modelos/apertura.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class AjaxAperturas{

	/*=============================================
	Guardar Aperturas
	=============================================*/	

	public function ajaxGuardarApertura(){

		$nombres = explode("/", $this->token);
		$COD_APERTURA=$nombres[0];


		
	
			$datos = array("codapertura" => $COD_APERTURA,
							"monto" => $this->monto);
			
			// var_dump($datos);
			// return;

			$respuesta = ControladorAperturas::ctrGuardarAperturaDetalle($datos);
				
			echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

			die();

	}


	/*=============================================
	Guardar Cierre
	=============================================*/	

	public function ajaxGuardarCierre(){

		$nombres = explode("/", $this->tokeneditar);
		$COD_APERTURA=$nombres[0];
	
			$datos = array("codapertura" => $COD_APERTURA,
							"montoCierre" => $this->montoCierre,
							"Diferencia" => $this->Diferencia,
							"Observaciones" => $this->Observaciones,
							"totalcaja"=>$this->totalcaja);

					
			// var_dump($datos);
			// return;

			$respuesta = ControladorAperturas::ctrGuardarCierre($datos);
				
			echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

			die();

	}



	/*=============================================
	EDITAR Aperturas
	=============================================*/	

	public function ajaxVerApertura(){

		$nombres = explode("/", $this->token_apertura);
		$COD_APERTURA=$nombres[0];

		$item = "COD_APERTURA";
		$valor = $COD_APERTURA;
		$var=1;

		$AperturasDetalle = ControladorAperturas::ctrMostrarAperturaDetalle($item, $valor,$var);

		header('Content-type:application/json;charset=utf-8');

		echo json_encode($AperturasDetalle, JSON_PRETTY_PRINT);
		

	}

	/*=============================================
	Eliminar Apertura
	=============================================*/	

	public $idEliminar;

	public function ajaxEliminarApertura(){

		$nombres = explode("/", $this->idEliminar);
		$token=$nombres[1];

		
		$item = "ESTADO";
		$valor = 0;
		$item1 = "TOKEN_APERTURA";
		$valor1 = $token;
		//var_dump($valor1);
		$respuesta = ControladorAperturas::ctrBorrarApertura($item,$valor,$item1,$valor1);

		echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

		die();
	}

	

}

///////////////////////////////////////////////////////////////////////

/*=============================================
	GUARDAR
=============================================*/	

if(isset($_POST["token"])){

	$Guardar = new AjaxAperturas();
	$Guardar -> token = $_POST["token"];
	$Guardar -> monto = $_POST["monto"];
	
	// var_dump($_POST["tokenApertura"]);
	
	$Guardar -> ajaxGuardarApertura();

}

/*================================================
	EDITAR/MOSTRAR Apertura
==================================================*/
if(isset($_POST["token_apertura"])){

	$ver = new AjaxAperturas();
	$ver -> token_apertura = $_POST["token_apertura"];
	$ver -> ajaxVerApertura();

}

/*=============================================
	Eliminar Apertura
=============================================*/	

if(isset($_POST["idEliminar"])){

	// var_dump($_POST["idEliminar"]);

	$eliminar = new AjaxAperturas();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarApertura();

}

/*=============================================
	Editar Cierre
=============================================*/	

if(isset($_POST["tokeneditar"])){

	// var_dump($_POST["idEliminar"]);

	$CierreCaja = new AjaxAperturas();
	$CierreCaja -> montoCierre = $_POST["montoCierre"];
	$CierreCaja -> tokeneditar = $_POST["tokeneditar"];
	$CierreCaja -> Diferencia = $_POST["Diferencia"];
	$CierreCaja -> Observaciones = $_POST["Observaciones"];
		$CierreCaja -> totalcaja = $_POST["totalcaja"];
	$CierreCaja -> ajaxGuardarCierre();

}



