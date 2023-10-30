<?php

require_once "../controladores/canalesProductos.controlador.php";
require_once "../modelos/canalesProductos.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";
class AjaxCanales{

	/*=============================================
	Guardar Canales
	=============================================*/	

	public function ajaxGuardarCanal(){

		if(($this->tokenCanal) != ""){

			$datos = array("txtCanal" => $this->txtCanal,
							"Estado" => $this->cmbEstado,
							"tokenCanal" => $this->tokenCanal);
			
			// var_dump($datos);
			// return;

			$respuesta = ControladorCanalesProductos::ctrEditarCanal($datos);
				
			echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

			die();

		}else{

				$datos = array("txtCanal" => $this->txtCanal,
							"Estado" => $this->cmbEstado,
							"tokenCanal" => $this->tokenCanal);
				// var_dump($datos);
				// return;

				$respuesta = ControladorCanalesProductos::ctrCrearCanal($datos);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

				die();

		}

	}


	/*=============================================
	EDITAR CANALES
	=============================================*/	

	public function ajaxEditarCanal(){

		$item="TOKEN_CANAL";
    	$valor=$this->token_canal;
        $var=1;
        $order="COD_CANAL ASC";//POR NECESIDAD NOMAS PASAMOS

        $respuesta = ControladorCanalesProductos::ctrMostrarCanal($item, $valor, $var, $order);

		echo json_encode($respuesta);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}


	/*=============================================
	Eliminar Canal
	=============================================*/	

	public $idEliminar;

	public function ajaxEliminarCanal(){
		
		$item = "TOKEN_CANAL";
		$valor = $this->idEliminar;

		$respuesta = ControladorCanalesProductos::ctrBorrarCanal($item, $valor);

		echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

		die();
	}


}

///////////////////////////////////////////////////////////////////////

/*=============================================
	GUARDAR y EDITAR CANAL
=============================================*/	

if(isset($_POST["txtCanal"])){

	$Guardar = new AjaxCanales();
	$Guardar -> txtCanal = $_POST["txtCanal"];
	$Guardar -> cmbEstado = $_POST["cmbEstado"];
	$Guardar -> tokenCanal = $_POST["tokenCanal"];

	// var_dump($_POST["tokenCanal"]);
	
	$Guardar -> ajaxGuardarCanal();

}

/*================================================
	EDITAR/MOSTRAR CANAL
==================================================*/
if(isset($_POST["token_canal"])){

	$editar = new AjaxCanales();
	$editar -> token_canal = $_POST["token_canal"];
	$editar -> ajaxEditarCanal();

}

/*=============================================
	Eliminar Canal
=============================================*/	

if(isset($_POST["idEliminar"])){

	//echo'<script>alert("'.$_POST["idEliminar"].'");</script>';

	$eliminar = new AjaxCanales();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarCanal();

}


