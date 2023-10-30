<?php 

	class ControladorCuotas{

		/*============================================================
					MOSTRAR DESCUENTOS
 		==============================================================*/
		static public function ctrMostrarCuota($item, $valor,$var, $order){

			$tabla="cuotas";
			
			$respuesta=ModeloCuotas::MdlMostrarCuota($tabla, $item, $valor,$var,$order);
			return $respuesta;
		}

		
		/*============================================================
					CREAR DESCUENTOS
 		==============================================================*/
		static public function ctrCrearCuota($datos){

			if(isset($datos["txtRecargo"])){
				// var_dump($datos);
				//validamos los datos nuevamente
				if(preg_match('/^[0-9., ]+$/', $datos["txtRecargo"]) && 
				   preg_match('/^[0-9. ]+$/', $datos["txtDesde"]) && 
				   preg_match('/^[0-9. ]+$/', $datos["txtHasta"]))
				{
					date_default_timezone_set("America/Asuncion");
					$fecha = date('Y-m-d');
					$hora = date('H:i:s');

					$fechaActual = $fecha.' '.$hora;

				    $tabla="cuotas";

					$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_CUOTA");
				    $token=bin2hex(random_bytes(16));//se genera el token
				    $token=$token.$ValorMaximo["maximo"];

				    $datos= array("idUsuario"=>$datos["idUsuario"],
				    			"Recargo"=>str_replace(',','.',$datos["txtRecargo"]),
								"Desde"=>str_replace('.','',$datos["txtDesde"]),
								"Hasta"=>str_replace('.','',$datos["txtHasta"]),
								"estado"=>str_replace('.','',$datos["cmbEstado"]),
								"Token"=>$token,
								"fecha_registro"=>$fechaActual);
								    
				    $respuesta=ModeloCuotas::mdlIngresarCuota($tabla, $datos);
				    
				    if ($respuesta =='ok'){

						$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente');

					}else if($respuesta =='exist'){

						$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe. Verifique intérvalo de montos');

					}else{

						$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');
					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die(); //para parar la aplicacion

				}else{

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en ninguno de los campos!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die();
				}
				
			}

		}


		/*============================================================
					EDITAR DESCUENTOS
 		==============================================================*/
 		static public function ctrEditarCuota($datos){

			if(isset($datos["txtRecargo"])){

				date_default_timezone_set('America/Asuncion');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');

				$fechaActual = $fecha.' '.$hora;

				// var_dump($datos);

				//validamos los datos nuevamente

				if(preg_match('/^[0-9., ]+$/', $datos["txtRecargo"]) && 
				   preg_match('/^[0-9. ]+$/', $datos["txtDesde"]) &&
				   preg_match('/^[0-9. ]+$/', $datos["txtHasta"]))
				{

				    $tabla="cuotas";

				    // var_dump(str_replace(',','.',$datos["txtDescuento"]));
				    // return;

				    $datos= array(	"txtRecargo"=>str_replace(',','.',$datos["txtRecargo"]),
								    "Desde"=>str_replace('.','',$datos["txtDesde"]),
								    "Hasta"=>str_replace('.','',$datos["txtHasta"]),
								    "FechaMod"=>$fechaActual,
								    "estado"=>$datos["cmbEstado"],
								    "Token"=>$datos["tokenCuotas"]);

				    // var_dump($datos);
				    // return;
				    
				    $respuesta=ModeloCuotas::mdlEditarCuota($tabla, $datos);
				    
				    if ($respuesta=='ok'){

						$arrResponse=array('status'=>true,'msg'=> 'Datos Actualizado correctamente');

					}else if($respuesta =='exist'){

						$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe. Verifique intérvalo de montos');

					}else{

						$arrResponse=array('status'=>false,'msg'=> 'No es posible Actualizar los datos.');

					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die();

				}else{

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en ninguno de los campos!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die();
				}
				
			}

		}

		/*============================================================
					BORRAR DESCUENTOS
 		==============================================================*/

		static public function ctrBorrarCuotas($item, $valor){


				//echo'<script>alert("'.$_POST["idEliminar"].'");</script>';

				$tabla ="cuotas";
				
				$respuesta = ModeloCuotas::mdlEliminarCuota($tabla, $item, $valor);
				
				if ($respuesta=='ok'){

					$arrResponse=array('status'=>true,'msg'=> 'Datos Eliminado Correctamente');

				}else if($respuesta[0]==23000){

					$arrResponse=array('status'=>false,'msg'=> 'No es posible Eliminar el dato, el mismo está siendo usado.');

				}else{

					$arrResponse=array('status'=>false,'msg'=> $respuesta[2]);
				}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();
			
		}


	}
