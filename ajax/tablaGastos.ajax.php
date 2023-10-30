<?php

require_once "../controladores/gastos.controlador.php";
require_once "../modelos/gastos.modelo.php";
require_once "../controladores/formapagos.controlador.php";
require_once "../modelos/formapagos.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class TablaGastos{

	/*=============================================
	Tabla Aperturas
	=============================================*/ 

	public function mostrarTabla(){

		
		$item=null;
		$valor=null;
		$item1="COD_APERTURA";
		$valor1=$this->apertura;
		$item2="ESTADO_GASTOS";
		$valor2=$this->estado;
       
       
        $Aperturas = ControladorGastos::ctrMostrarGastosSucursal($item, $valor,$item1,$valor1,$item2, $valor2);
        
      
		if(count($Aperturas) == 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Aperturas as $key => $value) {

	 			$estraccion="NO";
	 			if($value["VER_CAJA"]==1){
	 				$estraccion="SI";
	 			}


	 			$MetodosPagosNuevos="";

	 		if($value["FORMAPAGO"]!=null){

			 $metodospagos = json_decode($value["FORMAPAGO"], true);
			 
			 foreach ($metodospagos as $keyes => $valores) {
			 	if ($valores["id_metodo"]!=null){
			 		$nombres = explode("/",$valores["id_metodo"]);
			 
					$token_formapagos=$nombres[1];
                 	$item = "TOKEN_FORMAPAGO";
					$valor =$token_formapagos;
		
					$respuesta = ControladorFormaPagos::ctrMostrarFormapago($item, $valor,null,null);
					
                  $MetodosPagosNuevos.= "<div class='badge badge-secondary mx-1'>".$respuesta["DESCRIPCION_FORMA"].': '.$valores["entrega"].'<br>Transacción N°: '.$valores["nrotransaccion"]."</div>";
			 	}else{
			 	$MetodosPagosNuevos= "<div class='badge badge-secondary mx-1'>No hay métodos de pagos</div>";
			 }
			 	
                 
              }

			 }else{
			 	$MetodosPagosNuevos= "<div class='badge badge-secondary mx-1'>No hay métodos de pagos</div>";
			 }

	 		
	 			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm EditarGastos' data-toggle='modal' data-target='#ModalGastos' codgastos='".$value["COD_GASTO"]."' token_gastos='".$value["TOKEN_GASTOS"]."' cod_apertura='".$value["COD_APERTURA"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarGastos' token_gastos='".$value["TOKEN_GASTOS"]."' codgastos='".$value["COD_GASTO"]."' estado='".$value["ESTADO_GASTOS"]."'><i class='fas fa-trash-alt'></i></button></div>";

	 		
			/*=============================================
			ACCIONES
			=============================================*/

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["DESCRIPCION"].'",
						"'.$value["CATEGORIA"].'",
						"'.number_format($value["TOTAL"],0,',','.').'",
						"'.$MetodosPagosNuevos.'",
						"'.$estraccion.'",
						"'.$value["TIPO_GASTO"].'",
						"'.$value["NROCAJA"].'",
						"'.$value["NROFACTURA"].'",
						"'.$value["RUC"].'",
						"'.$value["EMPRESA"].'",
						"'.$value["IVA"].'",
						"'.$value["SUCURSAL"].'",
						"'.$value["USUARIO"].'"
						
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

if(isset($_GET["apertura"]))
{

	$tabla = new TablaGastos();
	$tabla -> apertura = $_GET["apertura"];
	$tabla -> estado = $_GET["estado"];
	$tabla -> mostrarTabla();
	
}


