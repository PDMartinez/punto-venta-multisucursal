<?php 

	class ControladorDescuentosProductos{

		/*============================================================
					MOSTRAR DESCUENTOS
 		==============================================================*/
		static public function ctrMostrarDescuento($item, $valor,$var, $order){

			$tabla="detcanal_productos";
			
			$respuesta=ModeloDescuentosProductos::MdlMostrarDescuento($tabla, $item, $valor,$var,$order);
			return $respuesta;
		}

		/*============================================================
					CREAR CAJA Y SUCURSAL
 		==============================================================*/

 		static public function ctrMostrarDescuentoCanal($item, $valor){

			$tabla1="detcanal_productos";
			$tabla2="canal_productos";

			$respuesta=ModeloDescuentosProductos::MdlMostrarDescuentoCanal($tabla1, $tabla2, $item, $valor);

			return $respuesta;
		}

		/*============================================================
					CREAR DESCUENTOS
 		==============================================================*/
		static public function ctrCrearDescuento($datos){

			if(isset($datos["txtDescuento"])){
				// var_dump($datos);
				//validamos los datos nuevamente
				if(preg_match('/^[0-9. ]+$/', $datos["canal"]) && 
				   preg_match('/^[0-9., ]+$/', $datos["txtDescuento"]) && 
				   preg_match('/^[0-9. ]+$/', $datos["txtDesde"]) && 
				   preg_match('/^[0-9. ]+$/', $datos["txtHasta"]))
				{

					date_default_timezone_set("America/Asuncion");
					$fecha = date('Y-m-d');
					$hora = date('H:i:s');

					$fechaActual = $fecha.' '.$hora;
				    $tabla="detcanal_productos";

					$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_DETCANAL");
				    $token=bin2hex(random_bytes(16));//se genera el token
				    $token=$token.$ValorMaximo["maximo"];

				    $datos= array("Canal"=>$datos["canal"],
				    				"Descuento"=>str_replace(',','.',$datos["txtDescuento"]),
								    "Desde"=>str_replace('.','',$datos["txtDesde"]),
								    "Hasta"=>str_replace('.','',$datos["txtHasta"]),
								    "Token"=>$token,
									"fecha_registro"=>$fechaActual);
								    
				    $respuesta=ModeloDescuentosProductos::mdlIngresarDescuento($tabla, $datos);
				    
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
 		static public function ctrEditarDescuento($datos){

			if(isset($datos["txtDescuento"])){

				date_default_timezone_set('America/Asuncion');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');

				$fechaActual = $fecha.' '.$hora;

				// var_dump($datos);

				//validamos los datos nuevamente

				if(preg_match('/^[0-9. ]+$/', $datos["canal"]) && 
				   preg_match('/^[0-9., ]+$/', $datos["txtDescuento"]) && 
				   preg_match('/^[0-9. ]+$/', $datos["txtDesde"]) &&
				   // preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $fechaActual) && 
				   preg_match('/^[0-9. ]+$/', $datos["txtHasta"]))
				{

				    $tabla="detcanal_productos";

				    // var_dump(str_replace(',','.',$datos["txtDescuento"]));
				    // return;

				    $datos= array("Canal"=>$datos["canal"],
				    				"Descuento"=>str_replace(',','.',$datos["txtDescuento"]),
								    "Desde"=>str_replace('.','',$datos["txtDesde"]),
								    "Hasta"=>str_replace('.','',$datos["txtHasta"]),
								    "FechaMod"=>$fechaActual,
								    // "estado"=>$datos["estado"],
								    "Token"=>$datos["tokenDescuento"]);

				    // var_dump($datos);
				    // return;
				    
				    $respuesta=ModeloDescuentosProductos::mdlEditarDescuento($tabla, $datos);
				    
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

		static public function ctrBorrarDescuento($item, $valor){


				//echo'<script>alert("'.$_POST["idEliminar"].'");</script>';

				$tabla ="detcanal_productos";
				
				$respuesta = ModeloDescuentosProductos::mdlEliminarDescuento($tabla, $item, $valor);
				
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
