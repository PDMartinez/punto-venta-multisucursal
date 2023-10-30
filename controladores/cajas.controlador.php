<?php 

	class ControladorCajas{

		/*============================================================
					MOSTRAR CAJAS
 		==============================================================*/
		static public function ctrMostrarCaja($item, $valor,$var, $order){
		
			$tabla="cajas";
			
			$respuesta=ModeloCajas::MdlMostrarCaja($tabla, $item, $valor,$var,$order);
			return $respuesta;

		}

		/*============================================================
					CREAR CAJA Y SUCURSAL
 		==============================================================*/

 		static public function ctrMostrarCajaSucursal($item, $valor,$item1, $valor1,$var){
 			
			$tabla1="cajas";
			$tabla2="sucursales";
			$order="NRO_VERIFICADOR";
			$respuesta=ModeloCajas::MdlMostrarCajaSucursal($tabla1, $tabla2, $item, $valor,$item1, $valor1,$var,$order);

			return $respuesta;
		}

		/*============================================================
					CREAR CAJAS
 		==============================================================*/
		static public function ctrCrearCaja($datos){

			if(isset($datos["Sucursal"])){
				// var_dump($datos);
				//validamos los datos nuevamente

				if(! preg_match('/^[0-9. ]+$/', $datos["Sucursal"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la sucursal!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ. ]+$/', $datos["NroCaja"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en N° de caja!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[0-9. ]+$/', $datos["NroFactura"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en N° de factura!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[0-9. ]+$/', $datos["Timbrado"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el timbrado!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if( preg_match('/([012]?[1-9]|[12]0|3[01])\/(0?[1-9]|1[012])\/([0-9]{4})/', $datos["InicioVigencia"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el inicio de vigencia!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if( preg_match('/([012]?[1-9]|[12]0|3[01])\/(0?[1-9]|1[012])\/([0-9]{4})/', $datos["FinVigencia"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el fin de vigencia!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[0-9. ]+$/', $datos["Verificador"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el N° de verificador!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[0-9. ]+$/', $datos["Ticket"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el N° de ticket!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}
				
				if(! preg_match('/^[0-9. ]+$/', $datos["NC"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el N° de nota de crédito!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[0-9. ]+$/', $datos["Estado"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el estado!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				// $fechaInicio = explode("/",$datos["InicioVigencia"]);
				// $nuevaFechaInicio = $fechaInicio[2].'/'.$fechaInicio[1].'/'.$fechaInicio[0];

				// $fechaFin = explode("/",$datos["FinVigencia"]);
				// $nuevaFechaFin = $fechaFin[2].'/'.$fechaFin[1].'/'.$fechaFin[0];

				$tabla="cajas";

				 $ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_CAJA");
				    $token=bin2hex(random_bytes(16));//se genera el token
				    
				     $token=$token.$ValorMaximo["maximo"];

				$datos= array("Sucursal"=>$datos["Sucursal"],
				    			"NroCaja"=>$datos["NroCaja"],
								"NroFactura"=>$datos["NroFactura"],
								"Timbrado"=>$datos["Timbrado"],
								"InicioVigencia"=>$datos["InicioVigencia"],
								"FinVigencia"=>$datos["FinVigencia"],
								"txtEquipo"=>$datos["txtEquipo"],
								"Verificador"=>$datos["Verificador"],
								"Ticket"=>$datos["Ticket"],
								"NC"=>$datos["NC"],
								"Estado"=>$datos["Estado"],
								"token"=>$token);
								    
				$respuesta=ModeloCajas::mdlIngresarCaja($tabla, $datos);
				    
				if ($respuesta =='ok'){

					$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente');

				}else if($respuesta =='exist'){

					$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');

				}else{

					$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');
				}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

				die(); //para parar la aplicacion
				
			}

		}


		/*============================================================
					EDITAR CAJAS
 		==============================================================*/
 		static public function ctrEditarCaja($datos){

			if(isset($datos["Sucursal"])){
				// var_dump($datos);
				//validamos los datos nuevamente
				if(! preg_match('/^[0-9. ]+$/', $datos["Sucursal"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la sucursal!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ. ]+$/', $datos["NroCaja"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en N° de caja!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[0-9. ]+$/', $datos["NroFactura"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en N° de factura!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[0-9. ]+$/', $datos["Timbrado"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el timbrado!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if( preg_match('/([012]?[1-9]|[12]0|3[01])\/(0?[1-9]|1[012])\/([0-9]{4})/', $datos["InicioVigencia"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el inicio de vigencia!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if( preg_match('/([012]?[1-9]|[12]0|3[01])\/(0?[1-9]|1[012])\/([0-9]{4})/', $datos["FinVigencia"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el fin de vigencia!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[0-9. ]+$/', $datos["Verificador"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el N° de verificador!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[0-9. ]+$/', $datos["Ticket"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el N° de ticket!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}
				
				if(! preg_match('/^[0-9. ]+$/', $datos["NC"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el N° de nota de crédito!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				if(! preg_match('/^[0-9. ]+$/', $datos["Estado"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el estado!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

				$tabla="cajas";

				$datos= array("Sucursal"=>$datos["Sucursal"],
				    			"NroCaja"=>$datos["NroCaja"],
								"NroFactura"=>$datos["NroFactura"],
								"Timbrado"=>$datos["Timbrado"],
								"InicioVigencia"=>$datos["InicioVigencia"],
								"FinVigencia"=>$datos["FinVigencia"],
								"txtEquipo"=>$datos["txtEquipo"],
								"Verificador"=>$datos["Verificador"],
								"Ticket"=> $datos["Ticket"],
								"NC"=> $datos["NC"],
								"Estado"=> $datos["Estado"],
								"token"=>$datos["tokenCaja"]);

				// var_dump($datos);
				// return;

				$respuesta=ModeloCajas::mdlEditarCaja($tabla, $datos);
				    
				if ($respuesta=='ok'){

					$arrResponse=array('status'=>true,'msg'=> 'Datos Actualizado correctamente');

				}else{

					$arrResponse=array('status'=>false,'msg'=> 'No es posible Actualizar los datos.');

				}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

				die();
				
			}

		}

		/*============================================================
					BORRAR CAJAS
 		==============================================================*/

		static public function ctrBorrarCaja($item, $valor){


				//echo'<script>alert("'.$_POST["idEliminar"].'");</script>';

				$tabla ="cajas";
				
				$respuesta = ModeloCajas::mdlEliminarCaja($tabla, $item, $valor);
				
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

		/*=============================================
		CONSULTAR CANTIDAD DE CAJA POR SUCURSAL
		=============================================*/

		static public function ctrMostrarCantidadCaja($item, $valor,$var){

			$tabla="cajas";
			$order="COD_SUCURSAL ASC";
			$respuesta=ModeloCajas::MdlMostrarCaja($tabla, $item, $valor,$var,$order);
			return $respuesta;

		}

		/*=============================================
		CONSULTAR CANTIDAD DE USO DE CAJAS
		=============================================*/

		static public function ctrMostrarCantidadUso($item, $valor){

			$tabla="canti_uso";
			
			$respuesta=ModeloCajas::MdlMostrarCantidadUso($tabla, $item, $valor);
			return $respuesta;

		}


	}
