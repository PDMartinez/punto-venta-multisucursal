<?php 

	class ControladorCanales{

		/*============================================================
					MOSTRAR CANAL
 		==============================================================*/
		static public function ctrMostrarCanal($item, $valor,$var, $order){

			$tabla="canal";
			
			$respuesta=ModeloCanales::MdlMostrarCanal($tabla, $item, $valor, $var, $order);
		
			return $respuesta;
		}


		/*============================================================
					CREAR CANALES
 		==============================================================*/
		static public function ctrCrearCanal($datos){

			if(isset($datos["txtCanal"])){

				// var_dump($datos);
				// return;
				//validamos los datos nuevamente
				if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ. ]+$/', $datos["txtCanal"]) && 
				   preg_match('/^[0-9. ]+$/', $datos["Estado"]))
				{

				    $tabla="canal";

					 $ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_CANAL");
				    $token=bin2hex(random_bytes(16));//se genera el token
				    
				     $token=$token.$ValorMaximo["maximo"];

				    $datos= array("Canal"=>$datos["txtCanal"],
								   "Estado"=>$datos["Estado"],
								   "token"=>$token);
								    
				    $respuesta=ModeloCanales::mdlIngresarCanal($tabla, $datos);
				    
				    if ($respuesta =='ok'){

						$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente');

					}else if($respuesta =='exist'){

						$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');

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
					EDITAR CANALES
 		==============================================================*/
 		static public function ctrEditarCanal($datos){

			if(isset($datos["txtCanal"])){
				
				// var_dump($datos);
				// return;

				//validamos los datos nuevamente
				if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ. ]+$/', $datos["txtCanal"]) && 
				   preg_match('/^[0-9. ]+$/', $datos["Estado"]))
				{

				    $tabla="canal";

				    $datos= array("Canal"=>$datos["txtCanal"],
								   "Estado"=>$datos["Estado"],
								   "token"=>$datos["tokenCanal"]);

				    
				    $respuesta=ModeloCanales::mdlEditarCanal($tabla, $datos);
				    
				    if ($respuesta=='ok'){

						$arrResponse=array('status'=>true,'msg'=> 'Datos Actualizado correctamente');

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
					BORRAR CANALES
 		==============================================================*/

		static public function ctrBorrarCanal($item, $valor){


				//echo'<script>alert("'.$_POST["idEliminar"].'");</script>';

				$tabla ="canal";
				
				$respuesta = ModeloCanales::mdlEliminarCanal($tabla, $item, $valor);
				
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
