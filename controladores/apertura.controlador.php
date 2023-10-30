<?php 

	class ControladorAperturas{

			/*============================================================
					CREAR Apertura Y SUCURSAL
 		==============================================================*/

 		static public function ctrMostrarAperturasucursalCaja($item, $valor,$item1,$valor1,$item2,$valor2,$var){

			$tabla1="cajas";
			$tabla2="sucursales";
			$tabla3="aperturas_cab";
			$order="COD_APERTURA DESC";
			
			$respuesta=ModeloAperturas::MdlMostrarAperturasucursalCaja($tabla1,$tabla2,$tabla3, $item, $valor,$item1, $valor1, $item2, $valor2,$order,$var);
			
			return $respuesta;
		}


			/*============================================================
					CREAR Apertura Y SUCURSAL
 		==============================================================*/

 		static public function ctrMostrarAperturaDetalle($item, $valor,$var){

			$tabla1="aperturas_cab";
			$tabla2="aperturas_det";
			$order="COD_APERTURA DESC";
			
			$respuesta=ModeloAperturas::MdlMostrarAperturaDetalle($tabla1,$tabla2, $item, $valor,$order,$var);
			
			return $respuesta;
		}



			/*============================================================
					CREAR Apertura Y SUCURSAL VENTAS
 		==============================================================*/

 		static public function ctrMostrarVentaApertura($tabla,$tabla1,$select,$item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3){
	
			$respuesta=ModeloAperturas::mdlVentasApertura($tabla,$tabla1,$select, $item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3);
		
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
					CREAR Apertura Y SUCURSAL GASTOS
 		==============================================================*/

 		static public function ctrMostrarGastosApertura($select,$item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3){
	
			$respuesta=ModeloAperturas::mdlGastosApertura($select, $item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3);
		
			return $respuesta;
		}






		/*============================================================
					CREAR Aperturas
 		==============================================================*/
		static public function ctrCrearApertura(){

			if(isset($_POST["cmbCaja"])){
				// var_dump($datos);
				//validamos los datos nuevamente
				if(preg_match('/^[0-9. ]+$/',$_POST["nuevoApertura"]) && 
				   preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ. ]+$/', $_POST["cmbCaja"]))
				{

					date_default_timezone_set("America/Asuncion");
					$fecha = date('Y-m-d');
					$hora = date('H:i:s');
					$fechaActual = $fecha.' '.$hora;

				    $tabla="aperturas_cab";

				    $ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_APERTURA");
				    $token=bin2hex(random_bytes(16));//se genera el token
				     $token=$token.$ValorMaximo["maximo"];
				    $datos= array("caja"=>$_POST['cmbCaja'],
				    			"idUsuario"=>$_POST["idUsuario"],
				    			"fecha_apertura"=>$fechaActual,
				    			"token"=>$token,
								 "Estado"=>'APERTURA');
								    //		    
								    
				    $respuesta=ModeloAperturas::mdlIngresarApertura_cab($tabla, $datos);
				    
				    if ($respuesta >0){
						
				    	$tabla="aperturas_det";

				    	$datos= array("codigo"=>$respuesta,
				    	"hora_apertura"=>$hora,
				    	"monto_apertura"=>str_replace('.','',$_POST["nuevoApertura"]),
						"estado"=>'APERTURA');
								    //		    $hora = date('H:i:s');
								    
					    $respuesta=ModeloAperturas::mdlIngresarAperturaDet($tabla, $datos);

					    if ($respuesta =="ok"){

							if($_SESSION["gastos"]== 1){

								echo'<script>
											

										swal({
							      		title: "La apertura ha sido registrado con Éxito",
							      		type: "success",
							      		confirmButtonText: "Cerrar"
							      	}, function(isConfirm) {
							      		if (isConfirm) {
							      			window.location="gastos";
							      		} 
							      	});

										</script>';

							}else{
								echo '<script>

									swal({
							      		title: "La apertura ha sido registrado con Éxito",
							      		type: "success",
							      		confirmButtonText: "Cerrar"
							      	}, function(isConfirm) {
							      		if (isConfirm) {
							      			window.location="ventas";
							      		} 
							      	});

									</script>';
								}

							}
						}

				}else{

					echo '<script>

						swal
						({

							type: "error",
							title: "¡No puede llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"

						}).then(function(result)
							{

								if(result.value)
								{
								
									window.location = "apertura";

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
