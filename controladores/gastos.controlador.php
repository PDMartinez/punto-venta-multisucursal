<?php 

	class ControladorGastos{

			/*============================================================
					CREAR Apertura Y SUCURSAL
 		==============================================================*/

 		static public function ctrMostrarCategoria($tabla,$columna,$where,$item,$valor,$order){

			
			$respuesta=ModeloGastos::MdlMostrarCategoria($tabla,$columna,$where,$item,$valor,$order);
			
			return $respuesta;
		}



			/*============================================================
					CREAR Apertura Y SUCURSAL VENTAS
 		==============================================================*/

 		static public function ctrMostrarGastosSucursal($item, $valor,$item1,$valor1,$item2, $valor2){


			$order="COD_GASTO DESC";
			
			$respuesta=ModeloGastos::MdlMostrarGastosSucursal($item, $valor,$item1,$valor1,$item2, $valor2,$order);
			
			return $respuesta;
		
		}


			/*============================================================
					CREAR Apertura Y SUCURSAL COBROS
 		==============================================================*/

 		static public function ctrMostrarCobrosApertura($select,$item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3){
	
			$respuesta=ModeloAperturas::mdlCobrosApertura($select, $item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3);
		
			return $respuesta;
		}




		

		/*============================================================
					GUARDAR GASTOS
 		==============================================================*/
 		static public function ctrGuardarGastos($datos){

			if(isset($datos["tipofactura"])){
			
				if(preg_match('/^[0-9. ]+$/', $datos["txtmontoGastos"]))
				{

					date_default_timezone_set("America/Asuncion");
					$hora = date('H:i:s');

					$tabla="gastos";

					$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_GASTO");
				    $token=bin2hex(random_bytes(16));//se genera el token

				  $datos = array("tipofactura" => $datos["tipofactura"],
							"nrofactura" => $datos["nrofactura"],
							"txtruc" => $datos["txtruc"],
							"txtempresa" => $datos["txtempresa"],
							"txtnuevoDescripcion" => $datos["txtnuevoDescripcion"],
							"txtNuevaCategoria" => $datos["txtNuevaCategoria"],
							"txtmontoGastos" => str_replace('.','',$datos["txtmontoGastos"]),
							"cmbextraccion" =>$datos["cmbextraccion"],
							"txtusuario" => $datos["txtusuario"],
							"txtsucursal" => $datos["txtsucursal"],
							"txtapertura" => $datos["txtapertura"],
							"txtfecha" => $datos["txtfecha"].' '.$hora,
							"cmbIva" => $datos["cmbIva"],
							"metodopago" => $datos["metodopago"],
							"token"=>$token);

				    
				    $respuesta=ModeloGastos::mdlIngresarGastos($tabla, $datos);
				    
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
					EDITAR GASTOS
 		==============================================================*/
 		static public function ctrEditarGastos($datos){

			if(isset($datos["cod_gastos"])){
			
				if(preg_match('/^[0-9. ]+$/', $datos["cod_gastos"]))
				{

				date_default_timezone_set("America/Asuncion");
					$hora = date('H:i:s');

				$tabla="gastos";

				  $datos = array("cod_gastos" => $datos["cod_gastos"],
				  			"tipofactura" => $datos["tipofactura"],
							"nrofactura" => $datos["nrofactura"],
							"txtruc" => $datos["txtruc"],
							"txtempresa" => $datos["txtempresa"],
							"txtnuevoDescripcion" => $datos["txtnuevoDescripcion"],
							"txtNuevaCategoria" => $datos["txtNuevaCategoria"],
							"txtmontoGastos" => str_replace('.','',$datos["txtmontoGastos"]),
							"cmbextraccion" =>$datos["cmbextraccion"],
							"txtfecha" => $datos["txtfecha"].' '.$hora,
							"cmbIva" => $datos["cmbIva"],
							"metodopago" => $datos["metodopago"]);

				    
				    $respuesta=ModeloGastos::mdlEditarGastos($tabla, $datos);
				    
				    if ($respuesta=='ok'){

						$arrResponse=array('status'=>true,'msg'=> 'Datos Actualizado correctamente');

					}else{

						$arrResponse=array('status'=>false,'msg'=> 'No es posible actualizar los datos.');

					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die();

				}else{

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die();
				}
				
			}

		}

		/*============================================================
					BORRAR Aperturas
 		==============================================================*/

		static public function ctrBorrarGasto($item,$valor,$item1,$valor1){


				//echo'<script>alert("'.$_POST["idEliminar"].'");</script>';

				$tabla="gastos";
				
				$respuesta = ModeloVarios::mdlActualizarVario($tabla, $item,$valor,$item1,$valor1);;
				
				if ($respuesta=='ok'){

					$arrResponse=array('status'=>true,'msg'=> 'Datos Anulado Correctamente');

				}else{

					$arrResponse=array('status'=>false,'msg'=> 'No es posible Anular el dato, el mismo está siendo usado.');

				}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();
			
		}


	}
