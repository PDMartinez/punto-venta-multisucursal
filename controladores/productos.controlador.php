<?php 
class ControladorProductos

{

				/**
			/**
	 GUARDAR PRODUCTOS 
	 */
	static public function ctrCrearProducto($datos){

		if(isset($datos["txtDescripcion"])){

			if(! preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\-,:.; ]+$/', $datos["txtDescripcion"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la descripción!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}

			if(! preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ]+$/', $datos["txtcodigobarra"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el codigo de barras!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}

			if(! preg_match('/^[0-9.]+$/', $datos["txtpreciocompra"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el precio de compra!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}

			if(! preg_match('/^[0-9.]+$/', $datos["txtprecioventa"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el precio de venta!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}

		
			if(! preg_match('/^[0-9,.-]+$/', $datos["txtstock"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el stock!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}

			if(! preg_match('/^[0-9,.]+$/', $datos["txtstockminimo"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el stock mínimo!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}
				
				$tabla="productos";
				$tabla1="stocks";
				$tabla2="ficha_stock";
							
				$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_PRODUCTO");
					$token=bin2hex(random_bytes(16));//se genera el token
					$token=$token.$ValorMaximo["maximo"];

					$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla1,"COD_STOCK");
					$tokenStock=bin2hex(random_bytes(16));//se genera el tokenStock
					$tokenStock=$tokenStock.$ValorMaximo["maximo"];


									
				$productos = array("txtDescripcion"=>strtoupper($datos["txtDescripcion"]),
							"cmbCategoria"=>$datos["cmbCategoria"],
							"cmbSubCategoria"=> $datos["cmbSubCategoria"],
							"cmbmarca"=> $datos["cmbmarca"],
						    "txtcodigobarra" =>$datos["txtcodigobarra"],
							"txtpreciocompra"=>str_replace('.','',$datos["txtpreciocompra"]),
							"cmbiva"=> $datos["cmbiva"],
						  	"txtdimension"=>strtoupper($datos["txtdimension"]),
							"txtcantPaquete"=>$datos["txtcantPaquete"],
							"cmbMedida"=>strtoupper($datos["cmbMedida"]),
							"txttipoProducto"=>$datos["txttipoProducto"],
							"codcanal"=>$datos["codcanal"],
							"combos"=>$datos["combos"],
							"tokenProducto"=>$token,
							"txtprecioventa"=> str_replace('.','',$datos["txtprecioventa"]),
							"txtstock"=>str_replace(',','.',$datos["txtstock"]),
						    "txtstockminimo" =>str_replace(',','.',$datos["txtstockminimo"]),
							"txtUbicacion"=>strtoupper($datos["txtUbicacion"]),
						    "txtOferta" =>str_replace('.','',$datos["txtOferta"]),
							"chkoferta"=>$datos["chkoferta"],
							"sucursal"=>$datos["sucursal"],
							"usuario"=> $datos["usuario"],
							"tokenStock"=>$tokenStock,
							"movimiento"=>$datos["movimiento"],
							"estado"=>1);

			    
			    $respuesta=ModelosProductos::mdlIngresarProducto($tabla,$tabla1,$tabla2,$productos);

	
				    if ($respuesta =='ok'){

						$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente');

					}else if($respuesta =='exist'){

						$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');

					}else{

						$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');

					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die(); //para parar la aplicacion

				//}

		}

	}


		/**
		 MOSTAR PRODUCTOS

		 */
	static public function ctrMostrarProducto($item,$valor,$item1,$valor1,$item2,$valor2,$item3,$valor3)
	{

		$tabla="productos";
		$tabla1="stocks";
		$tabla2="sub_categorias";
		$tabla3="categorias";
		$tabla4="marcas";
		$tabla5="sucursales";
		$tabla6="canal_productos";
		$order="DESCRIPCION";
		//$valor=decryption($valor);
	//	var_dump($item3,$valor3);

		$respuesta=ModelosProductos::MdlMostrarProductosInner($tabla,$tabla1,$tabla2,$tabla3,$tabla4,$tabla5,$tabla6,$item,$valor,$item1,$valor1,$item2,$valor2,$item3,$valor3,$order);
		return $respuesta;
	}


static public function ctrMostrarSoloProducto($item,$valor,$order)
	{

		$tabla="productos";
		
		$respuesta=ModelosProductos::mdlMostrarSoloProducto($tabla,$item,$valor,$order);
		return $respuesta;
	}







	static public function ctrMostrarImagen($item,$valor,$order){

		$tabla="productos";

		$respuesta=ModelosProductos::mdlMostrarSoloProducto($tabla, $item, $valor,$order);
		return $respuesta;
	}


	/**
	 EDITAR PRODUCTOS 
	 */
	static public function ctrEditarProducto($datos)
	{

		if(isset($datos["txtDescripcion"])){

			if(! preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\-,:.; ]+$/', $datos["txtDescripcion"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la descripción!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}

			if(! preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ]+$/', $datos["txtcodigobarra"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el codigo de barras!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}

			if(! preg_match('/^[0-9.]+$/', $datos["txtpreciocompra"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el precio de compra!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}

			if(! preg_match('/^[0-9.]+$/', $datos["txtprecioventa"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el precio de venta!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}


			if(! preg_match('/^[0-9,.-]+$/', $datos["txtstock"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el stock!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}

			if(! preg_match('/^[0-9,.-]+$/', $datos["txtstockminimo"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el stock mínimo!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}
	
			$tabla="productos";	
			 $tabla1="stocks";
			 	$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla1,"COD_STOCK");
					$tokenStock=bin2hex(random_bytes(16));//se genera el tokenStock
					$tokenStock=$tokenStock.$ValorMaximo["maximo"];
			$productos = array("txtDescripcion"=>strtoupper($datos["txtDescripcion"]),
							"cmbCategoria"=>$datos["cmbCategoria"],
							"cmbSubCategoria"=> $datos["cmbSubCategoria"],
							"cmbmarca"=> $datos["cmbmarca"],
						    "txtcodigobarra" =>$datos["txtcodigobarra"],
							"txtpreciocompra"=>str_replace('.','',$datos["txtpreciocompra"]),
							"cmbiva"=> $datos["cmbiva"],
						  	"txtdimension"=>strtoupper($datos["txtdimension"]),
							"txtcantPaquete"=>$datos["txtcantPaquete"],
							"cmbMedida"=>strtoupper($datos["cmbMedida"]),
							"txttipoProducto"=>$datos["txttipoProducto"],
							"txtstock"=>str_replace(',','.',$datos["txtstock"]),
							"codcanal"=>$datos["codcanal"],
							"combos"=>$datos["combos"],
							"sucursal"=>$datos["sucursal"],
							"usuario"=> $datos["usuario"],
							"movimiento"=>$datos["movimiento"],
							"txtcodProducto"=>$datos["txtcodProducto"],
							"txtprecioventa"=> str_replace('.','',$datos["txtprecioventa"]),
						    "txtstockminimo" =>str_replace(',','.',$datos["txtstockminimo"]),
							"txtUbicacion"=>strtoupper($datos["txtUbicacion"]),
						    "txtOferta" =>str_replace('.','',$datos["txtOferta"]),
							"chkoferta"=>$datos["chkoferta"],
							"idstock"=>$datos["idstock"],
							"insertar"=>$datos["insertar"],
							"tokenstock"=>$tokenStock);

				// var_dump($productos);
				// return;
			    
			    $respuesta=ModelosProductos::mdlEditarProducto($tabla,$tabla1,$productos);

			    // if($Producto=='ok'){

			    //   $tabla1="stocks";
			  
			    //   $stocks = array("txtprecioventa"=> str_replace('.','',$datos["txtprecioventa"]),
						 //    "txtstockminimo" =>str_replace(',','.',$datos["txtstockminimo"]),
							// "txtUbicacion"=>strtoupper($datos["txtUbicacion"]),
						 //    "txtOferta" =>str_replace('.','',$datos["txtOferta"]),
							// "chkoferta"=>$datos["chkoferta"],
							// "idstock"=>$datos["idstock"]);

				   // 	$respuesta=ModelosProductos::mdlEditarStock($tabla1,$stocks);
					
					if ($respuesta=='ok'){
						$arrResponse=array('status'=>true,'msg'=> 'Datos Actualizado Correctamente');
					}else if($respuesta=='sucursal'){
						$arrResponse=array('status'=>true,'msg'=> 'Almacenado correctamente en la sucursal');
					}else{
						$arrResponse=array('status'=>false,'msg'=> 'No es posible Actualizar los datos.');
					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();

				//}

		}

	}



		/**
		 BORRAR PRODUCTOS 
		 */

	static public function ctrBorrarProducto($datos){

		if(isset($datos["idEliminar"])){

			$tabla ="productos";
			$tabla1 ="stocks";
			// $tabla1 ="stocks";
			$item="TOKEN_PRODUCTO";
			$item1="TOKEN_STOCK";
			$dato= array("tokenProducto"=>$datos["idEliminar"],
			    "tokenStock"=>$datos["tokenStock"]);
			
			$respuesta = ModelosProductos::mdlEliminarProducto($tabla,$tabla1,$dato,$item,$item1);
			
			if ($respuesta=='ok'){

				// Eliminamos fotos de la galería
				if($datos["galeria"]!=""){

					$galeria = explode("," , $datos["galeria"]);
						
					foreach ($galeria as $key => $value) {

						if($value!=[]){
								
							if (!file_exists($value)) {

								unlink("../".$value);

							}

						}	
						
					}

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
		
	}


		/**
		 BORRAR PRODUCTOS 
		 */

	static public function ctrDesactivarProducto($datos){

		if(isset($datos["estado"])){

			$tabla ="stocks";
			$item="EST_ARTICULOS";
			$valor=$datos["estado"];
			$item1="TOKEN_STOCK";
			$valor1=$datos["tokenStock"];
						
			$respuesta = ModeloVarios::mdlActualizarVario($tabla,$item,$valor,$item1,$valor1);
			
				if ($respuesta=='ok'){

					$arrResponse=array('status'=>true,'msg'=> 'Datos desactivado Correctamente');
				}else if($respuesta[0]==23000){

					$arrResponse=array('status'=>false,'msg'=> 'No es posible desactivar el dato, el mismo está siendo usado.');
				}
				else{
					$arrResponse=array('status'=>false,'msg'=> $respuesta[2]);
				}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
		}
		
	}


	


}
