<?php
require_once "../modelos/actualizarVarios.modelo.php";


class TablaCantidades{

	/*=============================================
	Tabla Categorías
	=============================================*/ 
	
	public function mostrarTabla(){

		$tabla="canti_uso";
		$order="CANT_SUCURSALES ASC";
		$item=null;
		$valor=null;
		$respuesta=ModeloVarios::mdlMostrarCantidad($tabla,$item,$valor,$order);
	echo json_encode($respuesta);
		// echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
		// 		die();

		
	}
}
/*=============================================
Tabla Sucursales
=============================================*/ 

$cantidades = new TablaCantidades();
$cantidades -> mostrarTabla();

