<?php

require_once "../controladores/cajas.controlador.php";
require_once "../modelos/cajas.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class AjaxCantidadUso{

	
	/*=============================================
	CONSULTAR CANTIDAD DE CAJA POR SUCURSAL
	=============================================*/	

	public function ajaxConsultarCantidaduso(){

		$item1=null;
	    $valor1=null;

	    $uso = ControladorCajas::ctrMostrarCantidadUso($item1, $valor1);
			echo json_encode($uso);

	}


}

///////////////////////////////////////////////////////////////////////

/*=============================================
	GUARDAR y EDITAR CAJA
=============================================*/	
// var_dump($_POST["sucursal"]);

	$consultar = new AjaxCantidadUso();
	$consultar -> ajaxConsultarCantidaduso();