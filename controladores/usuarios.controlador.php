<?php 
class ControladorUsuarios

{

				/**
	 LOGIN DE USUARIO PARA INGRESO DEL SISTEMA 
	 */
	static public function ctrIngresoUsuario()
	{
		if(isset($_POST["ingUsuario"]))
		{
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) && 
		       preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"]))
			{
					
				$encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$tabla="usuarios";
				$item="usuario";
				$order="USUARIO";
				$valor=$_POST["ingUsuario"];
				$respuesta=ModelosUsuarios::MdlMostrarUsuarioInner($tabla,$item,$valor,$order);

				//obtengo la hora actual
				date_default_timezone_set("America/Asuncion");
				$hora_actual=date("H:i");
				
				$Sucursales = ControladorSucursales::ctrMostrarSucursal("ESTADO_SUCURSAL", "1",null);
          		$SucursalCantidad=count($Sucursales);
          	
			if($respuesta["USUARIO"]==$_POST["ingUsuario"] && 
							$respuesta["CLAVE"]==$encriptar)
				{


				if($hora_actual >= $respuesta["HORA_DESDE"] && $hora_actual <= $respuesta["HORA_HASTA"]|| $respuesta["SUPER_PERFIL"]!=0)
				{
					
						if($respuesta["ESTADO_USUARIO"]==1 && $respuesta["ESTADO_SUCURSAL"]==1 || $respuesta["SUPER_PERFIL"]!=0 )
						{

							$_SESSION["iniciarSesion"]="ok";
							$_SESSION["id_usu"]=$respuesta["COD_USUARIO"];
							$_SESSION["tokenUsuario"]=$respuesta["TOKEN_USUARIO"];
							$_SESSION["usuario"]=$respuesta["USUARIO"];
							$_SESSION["foto"]=$respuesta["FOTO_USUARIO"];
							$_SESSION["funcionario"]=$respuesta["NOMBRE_FUNC"];
							$_SESSION["perfil"]=$respuesta["NOMBRE_PERFIL"];
							$_SESSION["superperfil"]=$respuesta["SUPER_PERFIL"];
							$_SESSION["nroverificadorSucural"]="";
							$_SESSION["idsucursal"]="";
							$_SESSION["sucursal"]="";
							$_SESSION["fotosucursal"]="";
							$_SESSION["id_apertura"]= null;
  							$_SESSION["gastos"]=null;
							
							/*=============================================
							REGISTRAR FECHA PARA SABER EL ÚLTIMO LOGIN
							=============================================*/
							
							//reseteamos en caso de que entre bien 
							//cuando el valor sea mayor a cero
							$item1="NRO_INTENTO";
							$valor1=0;
							$item2="COD_USUARIO";
							$valor2=$respuesta["COD_USUARIO"];
							$actulizarintentos=ModelosUsuarios::mdlActualizarUsuario($tabla,$item1,$valor1,$item2,$valor2);

							$fecha = date('Y-m-d');
							$hora = date('H:i:s');

							$fechaActual = $fecha.' '.$hora;

							$item1 = "ULTIMO_LOGIN";
							$valor1 = $fechaActual;

							$item2 = "COD_USUARIO";
							$valor2 = $respuesta["COD_USUARIO"];

							$ultimoLogin = ModelosUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

								if($ultimoLogin == "ok")
								{


								 if($respuesta["SUPER_PERFIL"]==1){

									// EN ESTE IF ENTRA LOS SUPER USUARIO
									
								 	if($SucursalCantidad>1){
								 		// var_dump($SucursalCantidad);

								 		$_SESSION["var_sucursal"]=1;

										echo '<script type="text/javascript">

										window.location = "seleccionSucursal";

										</script>';
								 	}else{
								 		$_SESSION["var_sucursal"]=0;
									foreach ($Sucursales as $indice => $value) {

										$_SESSION["var_sucursal"]=0;
					                    $_SESSION["idsucursal"]=$value["COD_SUCURSAL"]."/".$value["TOKEN_SUCURSAL"];
										$_SESSION["sucursal"]=$value["SUCURSAL"];
										$_SESSION["fotosucursal"]=$value["IMAGEN_SUC"];
										$_SESSION["nroverificadorSucural"]=$value["NROVERIFICADOR"];
											
					                   
					                      echo '<script type="text/javascript">

													window.location = "inicio";

												</script>';
									}
							

								 	}
								 	

								 

			                      
			                    }else{
			                    	$_SESSION["var_sucursal"]=0;
			                    	if($SucursalCantidad>1){
			                    		$_SESSION["var_sucursal"]=1;
			                    	}
			                    	
			                    $_SESSION["idsucursal"]=$respuesta["COD_SUCURSAL"]."/".$respuesta["TOKEN_SUCURSAL"];
								$_SESSION["sucursal"]=$respuesta["SUCURSAL"];
								$_SESSION["fotosucursal"]=$respuesta["IMAGEN_SUC"];
								$_SESSION["nroverificadorSucural"]=$respuesta["NROVERIFICADOR"];
			                   
			                      echo '<script type="text/javascript">

											window.location = "inicio";

										</script>';
			                      }

									

								}				

						}else
							{

						echo '<div class="row">
				          <div class="col-lg-12">
				           <div class="bs-component">
				              <div class="alert alert-dismissible alert-primary">
				              
				                <h4>Error!</h4>

				                <p> El usuario está bloqueado, o la sucursal al cual pertenece este usuario, ha sido desactivada</p>
				              </div>
				            </div>
				        </div>';

							}

					}else{

						echo '<div class="row">
				          <div class="col-lg-12">
				           <div class="bs-component">
				              <div class="alert alert-dismissible alert-primary">
				              
				                <h4>Error!</h4>

				                <p> El uso del sistema está permitido en este horario de '

								.$respuesta["HORA_DESDE"]." a " .$respuesta["HORA_HASTA"].'	
				                </p>
				              </div           
				             </div>
				        </div>';

			
				}


								
					}else
						{
							//actualizar numeros de intentos
							$intentos=$respuesta["NRO_INTENTO"]+1;
							$tabla="usuarios";
							$item1="NRO_INTENTO";
							$valor1=$intentos;
							$item2="COD_USUARIO";
							$valor2=$respuesta["COD_USUARIO"];
							$actulizarintentos=ModelosUsuarios::mdlActualizarUsuario($tabla,$item1,$valor1,$item2,$valor2);
							//en caso de pasar la cantidad se desactiva
							if ($intentos>2) {

							$item1="ESTADO_USUARIO";
							$valor1=0;
							$item2="COD_USUARIO";
							$valor2=$respuesta["COD_USUARIO"];

							$bloquear=ModelosUsuarios::mdlActualizarUsuario($tabla,$item1,$valor1,$item2,$valor2);

								echo '<div class="row">
				          <div class="col-lg-12">
				           <div class="bs-component">
				              <div class="alert alert-dismissible alert-primary">
				              
				                <h4>Error!</h4>

				                <p> Por seguridad la cuenta ha sido bloqueada. Póngase en contacto con el administrador del sistema	
				                </p>
				              </div           
				             </div>
				        </div>';

							
							}else{
								echo '<div class="row">
				          <div class="col-lg-12">
				           <div class="bs-component">
				              <div class="alert alert-dismissible alert-primary">
				              
				                <h4>Error!</h4>

				                <p> Error al ingresar, vuelve a intentar, tienes hasta 3 intentos ' .$intentos. '/3'; '</div>
				                </p>
				              </div           
				             </div>
				        </div>';

								
							}
							
						}
				

			}
		}
	}
		


		/**
	 GUARDAR USUARIO 
	 */
	static public function ctrCrearUsuario($datos)
	{
		if(isset($datos["usuario"]))
		{
			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["usuario"]) && 
			   preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["clave"]))
			{

				$guardarRuta=[];

				//PREGUNTAR SI ESTAS ENVIANDO FOTO O NO 
				date_default_timezone_set("America/Asuncion");
				$fecha = date('Y-m-d');
				$hora = date('H:i:s');

				$fechaActual = $fecha.' '.$hora;
												
				if($datos["imgGaleria"] != ""){

			   	$ruta = array();
			  
				$galeria = json_decode($datos["imgGaleria"], true);

				for($i = 0; $i < count($galeria); $i++){

				
					// =============================================
					// Creamos el directorio donde vamos a guardar la imagen
					// =============================================

					$directorio = "../vistas/img/usuarios";	
					$aleatorio = md5(uniqid(rand(),true));
					
					array_push($ruta, strtolower($directorio."/".$aleatorio.".jpg"));

					array_push($guardarRuta, substr($ruta[$i], 3));

				}

			}
				
			    $tabla="usuarios";
			    $item="SUPER_PERFIL";

			    $ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_USUARIO");
				$token=bin2hex(random_bytes(16));//se genera el token
				$token=$token.$ValorMaximo["maximo"];

			    $encriptar = crypt($datos["clave"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
				
			    $datos= array("usuario"=>$datos["usuario"],
			    "clave"=>$encriptar,
			    "horadesde"=>$datos["horadesde"],
			    "horahasta"=>$datos["horahasta"],
			    "sucursal"=>$datos["sucursal"],
			    "perfil"=>$datos["perfil"],
			    "funcionario"=>$datos["funcionario"],
			    "estado"=> $datos["estado"],
			    "fecha_registro"=> $fechaActual,
				"foto"=> "[]",
			    "token"=>$token,
				"perfilDesc"=>$datos["perfilDesc"]);
			  //  var_dump($datos);

			    $respuesta=ModelosUsuarios::mdlIngresarUsuario($tabla,$datos,$item);
			    
			    if ($respuesta=='ok'){
						$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente','token'=>$token);
					}else if($respuesta=='principal'){
						$arrResponse=array('status'=>false,'msg'=> '¡Atención! No hay ningún usuario como super Administrador, por favor seleccione uno');
					}else{
						$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');
					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die(); //para parar la aplicacion


			}else
			{

				$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en ninguno de los campos!');
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
			}
			
		}
	}


		/**
		 MOSTAR USUARIOS 
		 */
	static public function ctrMostrarUsuario($item,$valor)
	{

		$tabla="usuarios";
		$order="USUARIO";
		//$valor=decryption($valor);
		$respuesta=ModelosUsuarios::MdlMostrarUsuarioInner($tabla,$item,$valor,$order);
		return $respuesta;
	}


	/**
	 EDITAR USUARIOS 
	 */
	static public function ctrEditarUsuario($datos)
	{

		if(isset($datos["usuario"]))
		{

			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["usuario"]))
			{

	
		$tabla="usuarios";
		$item="SUPER_PERFIL";

		if($datos["imgGaleria"]==""){

			//Eliminar las fotos de la galería de la carpeta
			$guardarRuta=[];
				
			if($datos["imgGaleriaAntigua"] != "" ){	

				$galeriaBD = json_decode($datos["imgGaleriaAntiguaEstatica"], true);
				
				$galeriaAntigua = explode("," , $datos["imgGaleriaAntigua"]);

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

			if($datos["imgGaleriaAntiguaEstatica"] != '[""]' && $datos["imgGaleriaAntiguaEstatica"] != ""){	

					$galeriaBD = json_decode($datos["imgGaleriaAntiguaEstatica"], true);
				
					foreach ($galeriaBD as $key => $valueFoto){
						if($valueFoto!='[""]'){

							if (!file_exists($valueFoto)) {
								unlink("../".$valueFoto);

							}
						
						}
					}


				}

				
				}



		$actualizar=ModeloVarios::mdlActualizarVario($tabla,"FOTO_USUARIO",json_encode($guardarRuta),"TOKEN_USUARIO",$datos["token"]);


	
			}	

				// Agregamos las fotos antiguas

				// if($datos["imgGaleriaAntigua"] != ""){

				// 	foreach ($galeriaAntigua as $key => $value) {
						
				// 		array_push($guardarRuta, $value);
				// 	}

				// }

		   	
		 
				
				

				$datos= array("usuario"=>$datos["usuario"],
			    "horadesde"=>$datos["horadesde"],
			    "horahasta"=>$datos["horahasta"],
			    "sucursal"=>$datos["sucursal"],
			    "perfil"=>$datos["perfil"],
			    "funcionario"=>$datos["funcionario"],
			    "estado"=> $datos["estado"],
			    "token"=>$datos["token"],
			   
			    "perfilDesc"=>$datos["perfilDesc"]);
			    // var_dump($datos);

				$respuesta=ModelosUsuarios::mdlEditarUsuario($tabla,$datos,$item);
				
					
					if ($respuesta=='ok'){

						$arrResponse=array('status'=>true,'msg'=> 'Datos Actualizado correctamente','token'=>$datos["token"]);

					}else if($respuesta=='principal'){

						$arrResponse=array('status'=>false,'msg'=> '¡Atención! No hay ningún usuario como super Administrador, por favor seleccione uno');

					}else{
						$arrResponse=array('status'=>false,'msg'=> 'No es posible Actualizar los datos.');
					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
				
			}else
			{

				$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en ninguno de los campos!');
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
			}

		}

	}



		/**
		 BORRAR USUARIOS 
		 */

	static public function ctrBorrarUsuario($datos){

		if(isset($datos["idEliminar"])){

			$tabla ="usuarios";
			$valor = $datos["idEliminar"];
			$item = "TOKEN_USUARIO";
			
			$respuesta = ModeloVarios::mdlEliminarVario($tabla,$item, $valor);
			
			if ($respuesta=='ok'){

						// Eliminamos fotos de la galería
				if($datos["galeria"]!=""){
						$galeria = explode("," , $datos["galeria"]);
						
						foreach ($galeria as $key => $value) {
						if($value!=[""]){
							
							if (!file_exists($value)) {
								unlink("../".$value);

							}

						}	
						
						
						}
					}
						$arrResponse=array('status'=>true,'msg'=> 'Datos Eliminado Correctamente');
					}else if($respuesta[0]==23000){

						$arrResponse=array('status'=>false,'msg'=> 'No es posible Eliminar el dato, el mismo está siendo usado.');
					}
					else{
						$arrResponse=array('status'=>false,'msg'=> $respuesta[2]);
					}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
		}
		
	}


}
