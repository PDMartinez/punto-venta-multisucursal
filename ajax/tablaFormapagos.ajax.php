<?php

require_once "../controladores/formapagos.controlador.php";
require_once "../modelos/formapagos.modelo.php";

class TablaFormapagos{

	/*=============================================
	Tabla Categorías
	=============================================*/ 
	
	public function mostrarTabla(){

		 
		$Formapagos = ControladorFormaPagos::ctrMostrarFormapago(null,null,null,null);

		if(count($Formapagos)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Formapagos as $key => $value) {

	 		
			/*=============================================
			ACCIONES
			=============================================*/
	

			if($value["ESTADO_FORMA"]==1){
				$botonesEstado= "<div class='text-primary'> <h6>ACTIVO</h6></div>";
				$botonAnular="<button class='btn btn-info btn-sm AnularFormaPagos' estado='".$value["ESTADO_FORMA"]."' tokenFormaPagos='".$value["TOKEN_FORMAPAGO"]."'><i class='fa-solid fa-ban'></i></button>";
			}else{
				$botonesEstado= "<div class='text-danger'> <h6>DESACTIVADO</h6></div>";
				$botonAnular="<button class='btn btn-success btn-sm AnularFormaPagos' estado='".$value["ESTADO_FORMA"]."' tokenFormaPagos='".$value["TOKEN_FORMAPAGO"]."'><i class='fa-solid fa-power-off'></i></button>";
			}

			if($value["EFECTIVO"]==1){
				$texto= "<div class='text-primary'> <h6>EFECTIVO</h6></div>";
			}else{
				$texto= "<div class='text-danger'> <h6>PAGO VIRTUAL</h6></div>";
			}


			$modificar="<button class='btn btn-warning btn-sm editarFormaPagos' data-toggle='modal' data-target='#ModalFormapagos' tokenFormaPagos='".$value["TOKEN_FORMAPAGO"]."'><i class='fa-solid fa-pen-to-square'></i></button>";
			$eliminar="<button class='btn btn-danger btn-sm eliminarFormaPagos' tokenFormaPagos='".$value["TOKEN_FORMAPAGO"]."'><i class='fa-solid fa-trash'></i></button>";



			$acciones = "<div class='btn-group'> ".$modificar.$botonAnular.$eliminar." </div>";


			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["DESCRIPCION_FORMA"].'",
						"'.$texto.'",
						"'.$botonesEstado.'"						
				],';

		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*=============================================
Tabla Perfiles
=============================================*/ 
// if(isset($_GET["txtCategoria"]))
// {

// 	$tabla = new TablaFormapagos();
// 	$tabla -> txtCategoria = $_GET["txtCategoria"];
// 	$tabla -> mostrarTabla();

// }

$tabla = new TablaFormapagos();
$tabla -> mostrarTabla();


