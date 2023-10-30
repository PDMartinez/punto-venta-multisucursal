<?php 

	class ControladorProveedores{

		/*============================================================
					MOSTRAR PROVEEDORES
 		==============================================================*/
		static public function ctrMostrarProveedor($item, $valor,$var){

			$tabla="proveedores";
			$order="NOMBRE ASC";
			$respuesta=ModeloProveedores::MdlMostrarProveedor($tabla, $item, $valor,$var,$order);
			return $respuesta;
		}

		/*============================================================
					CREAR PROVEEDORES Y CIUDADES
 		==============================================================*/

 		static public function ctrMostrarProveedorCiudad($item, $valor){

			$tabla1="proveedores";
			$tabla2="ciudades";
			$order="SUCURSAL ASC";
			$respuesta=ModeloProveedores::MdlMostrarProveedorCiudad($tabla1, $tabla2, $item, $valor);

			return $respuesta;
		}

		/*============================================================
					CREAR PROVEEDORES
 		==============================================================*/
		static public function ctrCrearProveedor($datos){

			if(isset($datos["Empresa"])){
				//validamos los datos nuevamente
				if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ. ]+$/', $datos["Empresa"]) && 
				   preg_match('/^[()\-0-9a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ. ]+$/', $datos["RUC"]) && 
				   preg_match('/^[0-9. ]+$/', $datos["Ciudad"]) && 
				   preg_match('/^[#\.\-a-zA-Z0-9. ]+$/', $datos["Direccion"]) && 
				   preg_match('/^[()\-0-9. ]+$/', $datos["Telefono"]) && 
				   preg_match('/^[()\-0-9. ]+$/', $datos["Celular"]) && 
				   preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $datos["Email"]) && 
				   preg_match('/^[0-9 ]+$/', $datos["Estado"]))
				{
					date_default_timezone_set("America/Asuncion");
					$fecha = date('Y-m-d');
					$hora = date('H:i:s');

					$fechaActual = $fecha.' '.$hora;

				    $tabla="proveedores";

					$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_PROVEEDOR");
					$token=bin2hex(random_bytes(16));//se genera el token
					$token=$token.$ValorMaximo["maximo"];

				    $datos= array("empresa"=>$datos["Empresa"],
				    "ruc"=>$datos["RUC"],
				    "ciudad"=>$datos["Ciudad"],
				    "direccion"=>$datos["Direccion"],
				    "telefono"=>$datos["Telefono"],
				    "celular"=>$datos["Celular"],
				    "email"=> $datos["Email"],
				    "estado"=> $datos["Estado"],
				    "token"=>$token,
					"fecha_registro"=>$fechaActual);
				    
				    $respuesta=ModeloProveedores::mdlIngresarProveedor($tabla, $datos);
				    
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
					EDITAR PROVEEDORES
 		==============================================================*/
 		static public function ctrEditarProveedor($datos){

			if(isset($datos["Empresa"])){
				//validamos los datos nuevamente
				if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ. ]+$/', $datos["Empresa"]) && 
				   preg_match('/^[()\-0-9a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ. ]+$/', $datos["RUC"]) && 
				   preg_match('/^[0-9. ]+$/', $datos["Ciudad"]) && 
				   preg_match('/^[#\.\-a-zA-Z0-9. ]+$/', $datos["Direccion"]) && 
				   preg_match('/^[()\-0-9. ]+$/', $datos["Telefono"]) && 
				   preg_match('/^[()\-0-9. ]+$/', $datos["Celular"]) && 
				   preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ@. ]+$/', $datos["Email"]) && 
				   preg_match('/^[0-9 ]+$/', $datos["Estado"]))
				{

				    $tabla="proveedores";

				    date_default_timezone_set('America/Asuncion');

					$fecha = date('Y-m-d');
					$hora = date('H:i:s');

					$fechaActual = $fecha.' '.$hora;

				    $datos= array("empresa"=>$datos["Empresa"],
				    "ruc"=>$datos["RUC"],
				    "ciudad"=>$datos["Ciudad"],
				    "direccion"=>$datos["Direccion"],
				    "telefono"=>$datos["Telefono"],
				    "celular"=>$datos["Celular"],
				    "email"=> $datos["Email"],
				    "estado"=> $datos["Estado"],
				    "fechaMod"=> $fechaActual,
				    "token"=>$datos["tokenProveedor"]);


				    
				    $respuesta=ModeloProveedores::mdlEditarProveedor($tabla, $datos);
				    
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
					BORRAR PROVEEDORES
 		==============================================================*/

		static public function ctrBorrarProveedor($item, $valor){


				//echo'<script>alert("'.$_POST["idEliminar"].'");</script>';

				$tabla ="proveedores";
				
				$respuesta = ModeloProveedores::mdlEliminarProveedor($tabla, $item, $valor);
				
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
