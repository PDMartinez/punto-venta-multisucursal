<?php 

	class ControladorGenerarToken{

			
		/*============================================================
					CREAR Aperturas
 		==============================================================*/
		static public function ctrCrearToken(){

			if(isset($_POST["txtnombreTabla"])){
				// var_dump($datos);
				//validamos los datos nuevamente
			
				    $tabla=$_POST["txtnombreTabla"];
				    $columana=$_POST["txtnombreColumna"];
				    $columanaPrimari=$_POST["txtprimarikey"];

												    
				    $respuesta=ModeloGenerarToken::mdlIngresartoken($tabla, $columana,$columanaPrimari);
				    
				    if ($respuesta=="ok"){
				    		echo'<script>
											

										swal({
							      		title: "El token fue generado con Éxito",
							      		type: "success",
							      		confirmButtonText: "Cerrar"
							      	}, function(isConfirm) {
							      		if (isConfirm) {
							      			window.location="generarToken";
							      		} 
							      	});

										</script>';

				    }

						

		}
}



		/*============================================================
					GUARDAR DETALLE Aperturas
 		==============================================================*/
 		static public function ctrGuardarAperturaDetalle($datos){

			if(isset($datos["codapertura"])){
			
				if(preg_match('/^[0-9. ]+$/', $datos["monto"]))
				{
					date_default_timezone_set("America/Asuncion");
					$hora = date('H:i:s');
				    $tabla="aperturas_det";

				    $datos= array("codigo"=>$datos["codapertura"],
				    "hora_apertura"=>$hora,
				    "monto_apertura"=>str_replace('.','',$_POST["monto"]),
					"estado"=>'APERTURA');


				    // var_dump($datos);

				    // return;

				    
				    $respuesta=ModeloAperturas::mdlIngresarAperturaDet($tabla, $datos);
				    
				    if ($respuesta=='ok'){

						$arrResponse=array('status'=>true,'msg'=> 'Datos guardado correctamente');

					}else{

						$arrResponse=array('status'=>false,'msg'=> 'No es posible guardare los datos.');

					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die();

				}else{

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en monto de apertura!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die();
				}
				
			}

		}




			/*============================================================
					GUARDAR Cierre
 		==============================================================*/
 		static public function ctrGuardarCierre($datos){

			if(isset($datos["codapertura"])){
			
				if(preg_match('/^[0-9. ]+$/', $datos["montoCierre"]))
				{
					date_default_timezone_set("America/Asuncion");
					$fecha = date('Y-m-d');
					$hora = date('H:i:s');

					$fechaActual = $fecha.' '.$hora;
					
				    $tabla="aperturas_cab";

				    $datos= array("codigo"=>$datos["codapertura"],
				    "fecha_hora"=>$fechaActual,
				    "hora_apertura"=>$hora,
				    "montoCierre"=>str_replace('.','',$datos["montoCierre"]),
				    "Diferencia"=>str_replace('.','',$datos["Diferencia"]),
				    "monto_apertura"=>str_replace('.','',$datos["totalcaja"]),
				    "Observaciones"=>$datos["Observaciones"],
					"estado"=>'CIERRE');


				    // var_dump($datos);

				    // return;

				   
				    $respuesta=ModeloAperturas::mdlEditarCierre($tabla, $datos);

				    
				    
				    if ($respuesta=='ok'){

						$arrResponse=array('status'=>true,'msg'=> 'La caja se ha cerrado correctamente');

					}else{

						$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');

					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die();

				}else{

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en Monto Cierre!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die();
				}
				
			}

		}




		/*============================================================
					BORRAR Aperturas
 		==============================================================*/

		static public function ctrBorrarApertura($item,$valor,$item1,$valor1){


				//echo'<script>alert("'.$_POST["idEliminar"].'");</script>';

				$tabla="aperturas_cab";
				
				$respuesta = ModeloVarios::mdlActualizarVario($tabla, $item,$valor,$item1,$valor1);
				
				if ($respuesta=='ok'){

					$arrResponse=array('status'=>true,'msg'=> 'Datos Anulado Correctamente');

				}else{

					$arrResponse=array('status'=>false,'msg'=> 'No es posible Anular el dato, el mismo está siendo usado.');

				}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();
			
		}


	}
