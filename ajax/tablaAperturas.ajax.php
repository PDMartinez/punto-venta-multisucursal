<?php

require_once "../controladores/apertura.controlador.php";
require_once "../modelos/apertura.modelo.php";
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class TablaAperturas{

	/*=============================================
	Tabla Aperturas
	=============================================*/ 

	public function mostrarTabla(){

		$item=null;
		$valor=null;
		$nombresSucursal = explode("/",$this->sucursal);
		$TOKEN_SUCURSAL=$nombresSucursal[0];
		$item1="COD_SUCURSAL";
		$valor1=$TOKEN_SUCURSAL;

		$nombresUsuario = explode("/",$this->usuario);
		$codusuario=$nombresUsuario[0];
		$item2="COD_USUARIO";
		$valor2=$codusuario;
        $var=null;
       
        $Aperturas = ControladorAperturas::ctrMostrarAperturasucursalCaja($item, $valor,$item1,$valor1,$item2,$valor2,$var);
      
		if(count($Aperturas) == 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Aperturas as $key => $value) {

	 		$item="COD_APERTURA";
	 		$valor=$value["COD_APERTURA"];
	 		$var=null;

	 		 $AperturasDetalle = ControladorAperturas::ctrMostrarAperturaDetalle($item, $valor,$var);
	 		
	 		 $total=$AperturasDetalle["TOTAL"];

	 		 $item = "COD_USUARIO";
        	$valor = $value["COD_USUARIO"];

        $usuarios = ControladorUsuarios::ctrMostrarUsuario($item, $valor);
        	$verApertura="<button class='btn btn-info btn-sm VerApertura' data-toggle='modal' data-target='#ModalVerApertura' nombrecaja='".$value["NROCAJA"]."' token_apertura='".$value["TOKEN_APERTURA"]."' cod_apertura='".$value["COD_APERTURA"]."'><i class='fas fa-eye text-white'></i></button>";

        	$editarApertura="<button class='btn btn-warning btn-sm editarApertura' data-toggle='modal' data-target='#ModalApertura' token_apertura='".$value["TOKEN_APERTURA"]."' cod_apertura='".$value["COD_APERTURA"]."'  nombrecaja='".$value["NROCAJA"]."' ><i class='fas fa-pencil-alt text-white'></i></button>";
        	$eliminarApertura="<button class='btn btn-danger btn-sm eliminarApertura' token_apertura='".$value["TOKEN_APERTURA"]."' cod_apertura='".$value["COD_APERTURA"]."'><i class='fas fa-trash-alt'></i></button>";

	 		if($value["ESTADO_APERTURA"]=="APERTURA"){

	 			$acciones = "<div class='btn-group'>".$verApertura.$editarApertura.$eliminarApertura."</div>";

	 		}else{

					$acciones = "<div class='btn-group'>".$verApertura."</div>";
	 		}	 		

	 		
			/*=============================================
			ACCIONES
			=============================================*/

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.number_format($total,0,',','.').'",
						"'.$usuarios["USUARIO"].'",
						"'.$value["NROCAJA"].'",
						"'.$value["FECHA_APERTURA"].'",
						"'.$value["FECHA_CIERRE"].'",
						"'.number_format($value["MONTO_CIERRE"],0,',','.').'",
						"'.number_format($value["DIFERENCIA"],0,',','.').'",
						"'.$value["OBSERVACION"].'",
						"'.$value["ESTADO_APERTURA"].'"
						
				],';
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*=============================================
Tabla Aperturas
=============================================*/ 

// $tabla = new TablaAperturas();
// $tabla -> mostrarTabla();

if(isset($_GET["sucursal"]))
{

	$tabla = new TablaAperturas();
	$tabla -> sucursal = $_GET["sucursal"];
	$tabla -> usuario = $_GET["usuario"];
	$tabla -> mostrarTabla();
	
}


if(isset($_POST["CIERRE"]))
{

	$tabla = new TablaAperturas();
	$tabla -> sucursal = $_GET["sucursal"];
	$tabla -> usuario = $_GET["usuario"];
	$tabla -> mostrarTabla();
	
}


