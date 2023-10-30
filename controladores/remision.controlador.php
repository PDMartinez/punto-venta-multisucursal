<?php 
/**
 * 
 */
/**
 * 
 */
class ControladorRemisiones
{
	
			/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/	

	static public function ctrMostrarProducto($item, $valor,$item1, $valor1,$item2,$valor2,$item3, $valor3,$var){

		$respuesta = ModelosRemisiones::mdlMostrarProducto($item, $valor,$item1, $valor1,$item2,$valor2,$item3, $valor3,$var);
		return $respuesta;
		
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasRemision($item,$valor, $fechaInicial, $fechaFinal,$valor1){

		if($valor1==1){
			$fechaColumna="FECHA_REMISION";
		}else{
			$fechaColumna="FECHA_ANULACION";
		}

		$respuesta = ModelosRemisiones::mdlRangoFechasRemision($item,$valor,$fechaInicial, $fechaFinal,$valor1,$fechaColumna);
			return $respuesta;
		
	}

		/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrBuscarRemision($item,$valor, $item1, $valor1,$valor2){

		

		$respuesta = ModelosRemisiones::mdlBusquedaClonar($item,$valor, $item1, $valor1,$valor2);
			return $respuesta;
		
	}

	/*=============================================
	CREAR VENTA
	=============================================*/


	static public function ctrCrearRemision($datos){



		if(isset($datos["txtremision"])){

	
			/*=============================================
			GUARDAR LA REMISION
			=============================================*/	
	
		 	  $nombres = explode("/",$datos["txtidSucursal"]);
              $CODIGO_SUCURSAL=$nombres[0];
              $item ="COD_SUCURSAL";
              $valor =  $CODIGO_SUCURSAL;



              $max =  ControladorSucursales::ctrMostrarSucursal($item, $valor,1);           
                          				
				$nro_Movimiento=0;
				$numeroVerifcador=$nombres = explode("-",$datos["txtremision"]);
				$numeroVerifcador= $nombres[1];
				
				if($max["NROREMISION"]!=$numeroVerifcador){
					$nro_Movimiento=$datos["txtremision"];				
				}else{	
					$nro_Movimiento= $max["NROREMISION"]+1;
					$numeroVerifcador=$max["NROREMISION"]+1;
				
				}

				$tabla="remision";

				$nro_Movimiento= "00".$max["NROVERIFICADOR"]."-".$numeroVerifcador;

				$nombres = explode("/",$datos["txtUsuario"]);
             	$CODIGO_USUARIO=$nombres[0];

              	$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_REMISION");
				$token=bin2hex(random_bytes(16));//se genera el token
				$token=$token.$ValorMaximo["maximo"];

              	$nombres = explode("/",$datos["cmbSucursalhasta"]);
             	$SUCURSAL_A=$nombres[0];
                	              
				$datos = array("id_usuario"=>$CODIGO_USUARIO,
					"id_sucursal"=>$CODIGO_SUCURSAL,
					"sucursal_a"=> $SUCURSAL_A,
					"preciototal"=>str_replace('.','',$datos["txtpreciototal"])
						   ,
					"observacion"=>$datos["txtObservaciones"],
					"nroremision"=>$nro_Movimiento,
					"token"=>$token,
					"listaProducto"=>$datos["txtproductos"],
					"numeroVerifcador"=>$numeroVerifcador,
					"estado"=>1);		
		
					$respuesta = ModelosRemisiones::mdlIngresarRemisionCab($tabla, $datos);
		
				  if ($respuesta=='ok'){
							$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente');
						}else if($respuesta=='exist'){
							$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');
						}else{
							$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');
						}

						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die(); //para parar la aplicacion



		
	}

}

/*=============================================
	ANULAR VENTAS
	=============================================*/

		static public function ctrAnularRemision($datos){

				if(isset($datos["token_remision"])){

						$respuesta=ModelosRemisiones::mdlAnularRemisionCab("remision",$datos);

						if ($respuesta=='ok'){
							if($datos["estado"]==1){
								$arrResponse=array('status'=>true,'msg'=> 'Registro Anulado Correctamente');
							}else{
								$arrResponse=array('status'=>true,'msg'=> 'Registro recuperado Correctamente');
							}
							
						}else if($respuesta=='exist'){
							$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');
						}else{
							$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');
						}

						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die(); //para parar la aplicacion

				

		 	}

		}





}