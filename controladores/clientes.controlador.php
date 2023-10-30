<?php

	class ControladorClientes{

		/*============================================================
					MOSTRAR CLIENTES
 		==============================================================*/
		static public function ctrMostrarCliente($item, $valor, $var){

			$_SESSION["tipoBoton"]="nuevo";

			$tabla="clientes";
			$order = "CLIENTE ASC";

			$respuesta=ModeloClientes::MdlMostrarCliente($tabla, $item, $valor, $var, $order);

			return $respuesta;
		}

		/*============================================================
					MOSTRAR CLIENTES Y CIUDADES
 		==============================================================*/

 		static public function ctrMostrarClienteCiudad($item, $valor,$var){

 			$_SESSION["tipoBoton"]="editar";
			$tabla1="clientes";
			$tabla2="ciudades";
			$tabla3="canal";
			$order = "CLIENTE ASC";
			$respuesta=ModeloClientes::MdlMostrarClienteCiudad($tabla1, $tabla2, $tabla3, $item, $valor,$var);

			return $respuesta;
		}

		/*============================================================
					CREAR CLIENTES
 		==============================================================*/
		static public function ctrCrearCliente($datos){

			// var_dump($datos);
 			// 	return;

			if(isset($datos["Cliente"])){

				//validamos los datos nuevamente
				if(! preg_match('/^[()\-0-9a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ. ]+$/i', $datos["Cliente"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el nombre del cliente!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				} 
				 
				if(! preg_match('/^[-0-9\-]+$/', $datos["Ruc"])){
				
				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la cédula del cliente!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}  

				if(! preg_match('/^[()\-0-9a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ. ]+$/', $datos["Direccion"])){

				   	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la dirección del cliente!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				} 

				if(! preg_match('/^[-0-9\-,]+$/', $datos["ClavesCelular"])){

				 	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el N° de celular del cliente!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if( preg_match('/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)@[a-z0-9-]+(\.[a-z0-9-]+)(\.[a-z]{2,3})$/', $datos["Email"])){

				 	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el correo del cliente!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if( preg_match('/([012]?[1-9]|[12]0|3[01])\/(0?[1-9]|1[012])\/([0-9]{4})/', $datos["FechaNac"])){

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la fecha de nacimiento del cliente!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				 }

				if(! preg_match('/^[0-9]+$/', $datos["TipoCliente"])) {

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el canal del cliente!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ. ]+$/', $datos["Garante"]) && $datos["Garante"] != "") {

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el nombre del garante!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[()\-0-9\-. ]+$/', $datos["CedulaGarante"]) && $datos["CedulaGarante"] != "") {

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la cédula del garante!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[()\-0-9a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s., ]+$/', $datos["ClavesRefPersonal"]) && $datos["ClavesRefPersonal"] != "") {

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la Referencia Personal!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[()\-0-9a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s., ]+$/', $datos["ClavesRefLaboral"]) && $datos["ClavesRefLaboral"] != "") {

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la Referencia Laboral!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;
					
				}

					// $fechaNac = explode("/",$datos["FechaNac"]);
					// $nuevaFechaNac = $fechaNac[2].'/'.$fechaNac[1].'/'.$fechaNac[0];

					date_default_timezone_set("America/Asuncion");
					$fecha = date('Y-m-d');
					$hora = date('H:i:s');

					$fechaActual = $fecha.' '.$hora;

				    $tabla="clientes";

					$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_CLIENTE");
				    $token=bin2hex(random_bytes(16));//se genera el token
				    $token=$token.$ValorMaximo["maximo"];

				    if($datos["Email"]!="" || $datos["Email"]!=null){
					$emailEncryptado = md5($datos["Email"]);
				    }else{
				    	$emailEncryptado=null;
				    }

					

					$usuario = crypt($datos["Ruc"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
					$clave = crypt($datos["Ruc"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

					// var_dump($emailEncriptado);
					// return;

				    $datos = array("Ciudad" => $datos["Ciudad"],
							"Cliente"=>$datos["Cliente"],
							"Ruc"=>$datos["Ruc"],
						    "Direccion" =>$datos["Direccion"],
							"ClavesCelular"=>$datos["ClavesCelular"],
							"Email"=>$datos["Email"],
							"EmailEncyptado"=>$emailEncryptado,
							"FechaNac"=>$datos["FechaNac"],
							"TipoCliente"=>$datos["TipoCliente"],
							"Categoria"=>$datos["Categoria"],
							"Garante"=>$datos["Garante"],
							"CedulaGarante"=>$datos["CedulaGarante"],
							"ClavesRefLaboral"=>$datos["ClavesRefLaboral"],
							"ClavesRefPersonal"=>$datos["ClavesRefPersonal"],
							"Estado"=>$datos["Estado"],
							"Galeria"=>"[]",
							"CedulaFrontal"=>"[]",
							"CedulaTrasera"=>"[]",
							"Latitud"=>$datos["Latitud"],
							"Longitud"=>$datos["Longitud"],
							"TokenCliente"=>$token,
							"Usuario"=>$usuario,
							"Clave"=>$clave,
							"fecha_registro"=>$fechaActual);
				    
				    $respuesta=ModeloClientes::mdlIngresarCliente($tabla, $datos);
				    
				    if ($respuesta =='ok'){

						$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente','token'=>$token);

					}else if($respuesta =='exist'){

						$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');

					}else{

						$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');
					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die(); //para parar la aplicacion

				// }else{

				// 	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en ninguno de los campos!');

				// 	echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

				// 	die();
				// }
				
			}

		}

		/*============================================================
					EDITAR CLIENTES
 		==============================================================*/
 		static public function ctrEditarCliente($datos){

 			// var_dump($datos);
 			// return;

			if(isset($datos["Cliente"])){

				//validamos los datos nuevamente

				if(! preg_match('/^[()\-0-9a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ. ]+$/i', $datos["Cliente"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el nombre del cliente!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				} 
				 
				if(! preg_match('/^[-0-9]+$/', $datos["Ruc"])){

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la cédula del cliente!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}  

				if(! preg_match('/^[()\-0-9a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ. ]+$/', $datos["Direccion"])){

				   	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la dirección del cliente!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				} 

				if(! preg_match('/^([()\-0-9\s_;,.]){2,}$/i', $datos["ClavesCelular"])){

				 	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el N° de celular del cliente!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if( preg_match('/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)@[a-z0-9-]+(\.[a-z0-9-]+)(\.[a-z]{2,3})$/', $datos["Email"])){

				 	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el correo del cliente!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if( preg_match('/([012]?[1-9]|[12]0|3[01])\/(0?[1-9]|1[012])\/([0-9]{4})/', $datos["FechaNac"])){

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la fecha de nacimiento del cliente!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				 }

				if(! preg_match('/^[0-9. ]+$/', $datos["TipoCliente"])) {

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el canal del cliente!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ. ]+$/', $datos["Garante"]) && $datos["Garante"] != "") {

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el nombre del garante!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[()\-0-9. ]+$/', $datos["CedulaGarante"]) && $datos["CedulaGarante"] != "") {

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la cédula del garante!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[()\-0-9a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s., ]+$/', $datos["ClavesRefPersonal"]) && $datos["ClavesRefPersonal"] != "") {

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la Referencia Personal!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[()\-0-9a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s., ]+$/', $datos["ClavesRefLaboral"]) && $datos["ClavesRefLaboral"] != "") {

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la Referencia Laboral!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;
					
				}

				$tabla="clientes";

				//if($datos["Galeria"]!=""){

						//==========Eliminar las fotos de la galería de la carpeta===========

						$guardarRuta=[];
						
						// var_dump($datos["Galeria"]);
						// return;	

						if($datos["galeriaAntigua"] != "" ){	

							$galeriaBD = json_decode($datos["galeriaAntiguaEstatica"], true);
					
							$galeriaAntigua = explode("," , $datos["galeriaAntigua"]);

							$guardarRuta = $galeriaAntigua;
					
							$borrarFoto = array_diff($galeriaBD, $galeriaAntigua);


							$actualizar=ModeloVarios::mdlActualizarVario($tabla, "IMAGEN_CLIENTE", json_encode($guardarRuta), "TOKEN_CLIENTE", $datos["TokenCliente"]);

							foreach ($borrarFoto as $key => $valueFoto){

								if($valueFoto!=[""]){
									
									if (!file_exists($valueFoto)) {

										unlink("../".$valueFoto);

									}
								}

							}

						}else{

							$actualizar=ModeloVarios::mdlActualizarVario($tabla, "IMAGEN_CLIENTE", json_encode($guardarRuta), "TOKEN_CLIENTE", $datos["TokenCliente"]);

							if($datos["galeriaAntiguaEstatica"] != '[""]' && $datos["galeriaAntiguaEstatica"] != ""){

								// var_dump($datos["galeriaAntiguaEstatica"]);
								// return	

								$galeriaBD = json_decode($datos["galeriaAntiguaEstatica"], true);
								
								foreach ($galeriaBD as $key => $valueFoto){
									
									if($valueFoto!='[""]'){

										if (!file_exists($valueFoto)) {
												
											unlink("../".$valueFoto);

										}
										
									}

								}

							}

				
						}
						// var_dump($tabla, " IMAGEN_CLIENTE ", json_encode($guardarRuta), " TOKEN_CLIENTE ", $datos["TokenCliente"]);
						// return	

						// $actualizar=ModeloVarios::mdlActualizarVario($tabla, "IMAGEN_CLIENTE", json_encode($guardarRuta), "TOKEN_CLIENTE", $datos["TokenCliente"]);
	
				//}

			//	if($datos["CedulaFrontal"]==""){

						//==========Eliminar las fotos de la galería de la carpeta===========

						
						
						// var_dump($datos["cedulaFrontal"]);
						// return;	
						$guardarRuta=[];
						if($datos["cedulaFrontalAntigua"] != "" ){	
							
							$galeriaBD = json_decode($datos["cedulaFrontalAntiguaEstatica"], true);
					
							$galeriaAntigua = explode("," , $datos["cedulaFrontalAntigua"]);

							// var_dump("galeria antigua",	$galeriaAntigua);
							// return;
							$guardarRuta = $galeriaAntigua;
					
							$borrarFoto = array_diff($galeriaBD, $galeriaAntigua);

							foreach ($borrarFoto as $key => $valueFoto){

								if($valueFoto!=[""]){
									
									if (!file_exists($valueFoto)) {

										unlink("../".$valueFoto);

									}
								}

							}

						}else{

								$actualizar=ModeloVarios::mdlActualizarVario($tabla, "IMAGEN_CEDULA", json_encode($guardarRuta), "TOKEN_CLIENTE", $datos["TokenCliente"]);

							if($datos["cedulaFrontalAntiguaEstatica"] != '[""]' && $datos["cedulaFrontalAntiguaEstatica"] != ""){

								// var_dump($datos["cedulaFrontalAntiguaEstatica"]);
								// return	

								$galeriaBD = json_decode($datos["cedulaFrontalAntiguaEstatica"], true);
								
								foreach ($galeriaBD as $key => $valueFoto){
									
									if($valueFoto!='[""]'){

										if (!file_exists($valueFoto)) {
												
											unlink("../".$valueFoto);

										}
										
									}

								}

							}

				
						}
						// var_dump($tabla, " IMAGEN_CLIENTE ", json_encode($guardarRuta), " TOKEN_CLIENTE ", $datos["TokenCliente"]);
						// return	

					
	
				//}

				//if($datos["cedulaTrasera"]==""){

						//==========Eliminar las fotos de la galería de la carpeta===========

						$guardarRuta=[];
						
						// var_dump($datos["cedulaTrasera"]);
						// return;	

						if($datos["cedulaTraseraAntigua"] != "" ){	

							$galeriaBD = json_decode($datos["cedulaTraseraAntiguaEstatica"], true);
					
							$galeriaAntigua = explode("," , $datos["cedulaTraseraAntigua"]);

							// var_dump("galeria antigua",	$galeriaAntigua);
							// return;
							$guardarRuta = $galeriaAntigua;
					
							$borrarFoto = array_diff($galeriaBD, $galeriaAntigua);

							foreach ($borrarFoto as $key => $valueFoto){

								if($valueFoto!=[""]){
									
									if (!file_exists($valueFoto)) {

										unlink("../".$valueFoto);

									}
								}

							}

						}else{


						$actualizar=ModeloVarios::mdlActualizarVario($tabla, "IMAGEN_CEDULAATRAS", json_encode($guardarRuta), "TOKEN_CLIENTE", $datos["TokenCliente"]);

							if($datos["cedulaTraseraAntiguaEstatica"] != '[""]' && $datos["cedulaTraseraAntiguaEstatica"] != ""){

								// var_dump($datos["cedulaTraseraAntiguaEstatica"]);
								// return	

								$galeriaBD = json_decode($datos["cedulaTraseraAntiguaEstatica"], true);
								
								foreach ($galeriaBD as $key => $valueFoto){
									
									if($valueFoto!='[""]'){

										if (!file_exists($valueFoto)) {
												
											unlink("../".$valueFoto);

										}
										
									}

								}

							}

				
						}
						// var_dump($tabla, " IMAGEN_CLIENTE ", json_encode($guardarRuta), " TOKEN_CLIENTE ", $datos["TokenCliente"]);
						// return	

	
				//}



				 //    $fechaNac = explode("-",$datos["FechaNac"]);
					// $nuevaFechaNac = $fechaNac[0].'-'.$fechaNac[1].'-'.$fechaNac[2];

				    $emailEncryptado = md5(uniqid($datos["Email"],true));

				    $usuario = crypt($datos["Ruc"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
					$clave = crypt($datos["Ruc"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				    $datos = array("Ciudad" => $datos["Ciudad"],
							"Cliente"=>$datos["Cliente"],
							"Ruc"=>$datos["Ruc"],
						    "Direccion" =>$datos["Direccion"],
							"ClavesCelular"=>$datos["ClavesCelular"],
							"Email"=>$datos["Email"],
							"EmailEncyptado"=>$emailEncryptado,
							"FechaNac"=>$datos["FechaNac"],
							"TipoCliente"=>$datos["TipoCliente"],
							"Categoria"=>$datos["Categoria"],
							"Garante"=>$datos["Garante"],
							"CedulaGarante"=>$datos["CedulaGarante"],
							"ClavesRefLaboral"=>$datos["ClavesRefLaboral"],
							"ClavesRefPersonal"=>$datos["ClavesRefPersonal"],
							"Estado"=>$datos["Estado"],
							// "Galeria"=>"[]",
							// "CedulaFrontal"=>"[]",
							// "CedulaTrasera"=>"[]",
							"Latitud"=>$datos["Latitud"],
							"Longitud"=>$datos["Longitud"],
							"TokenCliente"=>$datos["TokenCliente"],
							"Usuario"=>$usuario,
							"Clave"=>$clave);
				    
				    $respuesta=ModeloClientes::mdlEditarCliente($tabla, $datos);
				    
				    if ($respuesta =='ok'){

						$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente','token'=>$datos["TokenCliente"]);

					}else if($respuesta =='exist'){

						$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');

					}else{

						$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');
					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die(); //para parar la aplicacion

				// }else{

				// 	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en ninguno de los campos!');

				// 	echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

				// 	die();
				// }
				
			}

		}

		/*============================================================
					BORRAR CLIENTES
 		==============================================================*/

		static public function ctrBorrarCliente($datos){

			$tabla ="clientes";
			$valor = $datos["idEliminar"];
			$item = "COD_CLIENTE";

			// var_dump($datos);
			// return;
				
			$respuesta = ModeloClientes::mdlEliminarCliente($tabla, $item, $valor);
				
			if ($respuesta=='ok'){

				// Eliminamos fotos de la galería
				if($datos["galeria"]!=""){

					// $galeria = explode("," , $datos["galeria"]);
							
					// foreach ($galeria as $key => $value) {

						// if($value!=[""]){
									
							// if (!file_exists($value)) {

								unlink("../".$datos["galeria"]);

							// }

						// }	
							
							
					// }
				}

				// Eliminamos fotos de la cedula frontal
				if($datos["cedulaFrontal"]!=""){

					unlink("../".$datos["cedulaFrontal"]);

				}

				// Eliminamos fotos de la cedula trasera
				if($datos["cedulaTrasera"]!=""){

					unlink("../".$datos["cedulaTrasera"]);

				}

				$arrResponse=array('status'=>true,'msg'=> 'Datos Eliminado Correctamente');

			}else if($respuesta[0]==23000){

				$arrResponse=array('status'=>false,'msg'=> 'No es posible Eliminar el dato, el mismo está siendo usado.');

			}else{

				$arrResponse=array('status'=>false,'msg'=> $respuesta[2]);
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
			die();
			
		}

		/*============================================================
					BORRAR CLIENTES
 		==============================================================*/

		static public function ctrActualizarCliente($item, $valor){

			$tabla ="clientes";

			// var_dump($item, $valor);
			// return;
				
			$respuesta = ModeloClientes::mdlActualizarCliente($tabla, $item, $valor);

			if ($respuesta=='ok'){

				$arrResponse=array('status'=>true,'msg'=> 'Dato Actualizado Correctamente');

			}else if($respuesta[0]==23000){

				$arrResponse=array('status'=>false,'msg'=> 'No es posible Actualizar el dato, el mismo está siendo usado.');

			}else{

				$arrResponse=array('status'=>false,'msg'=> $respuesta[2]);
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
			die();
			
		}

	}
