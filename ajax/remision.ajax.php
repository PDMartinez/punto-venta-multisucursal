<?php
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
require_once "../controladores/remision.controlador.php";
require_once "../modelos/remision.modelo.php";
require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursales.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxRemisiones{

	public $txtremision;
	public $txtUsuario;
	public $txtidSucursal;
	public $txtproductos;
	public $txtObservaciones;
	public $txtpreciototal;
	public $cmbSucursalhasta;

	public function ajaxCrearRemision(){

			$datos = array("txtremision" => $this->txtremision,
							"txtUsuario"=>$this->txtUsuario,
							"txtidSucursal"=>$this->txtidSucursal,
							"txtproductos"=> $this->txtproductos,
							"txtObservaciones"=> $this->txtObservaciones,
						    "txtpreciototal" =>$this->txtpreciototal,
							"cmbSucursalhasta"=>$this->cmbSucursalhasta);

					 // var_dump($datos);
				  // return;
				$guardar = ControladorRemisiones::ctrCrearRemision($datos);
				
				echo json_encode($guardar,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

	}

	public function ajaxMostrarDatos(){

		$item="EST_ARTICULOS";
		$valor=$this->activo;
			
		$nombres = explode("/",$this->sucursal);
		$TOKEN_SUCURSAL=$nombres[1];

		$item1="TIPO_PRODUCTO";
		$valor1=$this->tipo_producto;

		$item2="TOKEN_SUCURSAL";
		$valor2=$TOKEN_SUCURSAL;

		$nombres = explode("/",$this->token_producto);
		
		$item3="TOKEN_PRODUCTO";
		$valor3=$nombres[1];

		$var=0;
        $respuesta = ControladorRemisiones::ctrMostrarProducto($item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3,$var);

		echo json_encode($respuesta);
}


public function ajaxClonarRemision(){

			$nombres = explode("/",$this->sucursal);
			$TOKEN_SUCURSAL=$nombres[1];

			$item="TOKEN_SUCURSAL";
			$valor=$TOKEN_SUCURSAL;

			$item1="TOKEN_REMISION";
			$valor1=$this->token_remision;   

		 	$valor2 = $this->activo;
		
        $Remision = ControladorRemisiones::ctrBuscarRemision($item,$valor, $item1, $valor1,$valor2);

		echo json_encode($Remision);

      }


public function ajaxBuscarRemision(){


			$nombres = explode("/",$this->sucursal);
			$TOKEN_SUCURSAL=$nombres[1];

			$item="TOKEN_SUCURSAL";
			$valor=$TOKEN_SUCURSAL;
			
			$fechaInicial =  $this->txtfechaInicial;
			
			$fechaFinal=  $this->txtfechaFinal;       

		 	$valor1 = $this->activo;
			$UsuarioAnulo="";
		
        $Remision = ControladorRemisiones::ctrRangoFechasRemision( $item,$valor, $fechaInicial, $fechaFinal,$valor1);
       
		if(count($Remision)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Remision as $key => $value) {		
		  	
			/*=============================================
			ACCIONES
			=============================================*/

			if ($this->activo==1){
					$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm clonarRemision' title='Clonar remision' tokenRemision='".$value["TOKEN_REMISION"]."' CodigoRemision='".$value["COD_REMISION"]."' ><i class='fas fa-clone text-white'></i></button><button class='btn btn-info btn-sm detalleRemision' data-toggle='modal' data-target='#ModalDetRemision' title='Ver Detalle remision' tokenRemision='".$value["TOKEN_REMISION"]."' CodigoRemision='".$value["COD_REMISION"]."' ><i class='fa fa-info text-white'></i></button><button class='btn btn-danger btn-sm eliminarRemision' title='Anular remision' tokenRemision='".$value["TOKEN_REMISION"]."' tokenSucursal='".$value["tokenSucursal"]."' CodigoRemision='".$value["COD_REMISION"]."' estado='".$value["ESTADO_REMISION"]."'><i class='fa fa-ban'></button></div>";	

			}else{
					$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm clonarRemision' title='Clonar remision' tokenRemision='".$value["TOKEN_REMISION"]."' CodigoRemision='".$value["COD_REMISION"]."' ><i class='fas fa-clone text-white'></i></button><button class='btn btn-info btn-sm detalleRemision' data-toggle='modal' data-target='#ModalDetRemision' title='Ver Detalle remision' tokenRemision='".$value["TOKEN_REMISION"]."' CodigoRemision='".$value["COD_REMISION"]."' ><i class='fa fa-info text-white'></i></button><button class='btn btn-success btn-sm eliminarRemision' title='Recuperar remision' tokenRemision='".$value["TOKEN_REMISION"]."' tokenSucursal='".$value["tokenSucursal"]."' CodigoRemision='".$value["COD_REMISION"]."' estado='".$value["ESTADO_REMISION"]."'><i class='fa fa-recycle'></i></button></div>";

					$item = "COD_USUARIO";
					$valor = $value["COD_USUARIO_ANULADO"];

					$respuesta = ControladorUsuarios::ctrMostrarUsuario($item, $valor);

					$UsuarioAnulo=$respuesta["USUARIO"];

			}

			if ($this->activo==1){
			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["NROREMISION"].'",
						"'.$value["FECHA_REMISION"].'",
						"'.$value["SUCURSAL"].'",
						"'.$value["SUCURSAL_A"].'",
						"'.$value["USUARIO"].'",
						"'.$value["OBSERVACION"].'"
						
				],';
				}else{
						$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["NROREMISION"].'",
						"'.$value["FECHA_REMISION"].'",
						"'.$value["FECHA_ANULACION"].'",
						"'.$value["SUCURSAL"].'",
						"'.$value["SUCURSAL_A"].'",
						"'.$value["USUARIO"].'",
						"'.$UsuarioAnulo.'",
						"'.$value["DESCRIPCION_ANULACION"].'",
						"'.$value["OBSERVACION"].'"
						
				],';

				}
				
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}


	public function ajaxBuscarRemisionAnulada(){


			$nombres = explode("/",$this->sucursal);
			$TOKEN_SUCURSAL=$nombres[1];

			$item="TOKEN_SUCURSAL";
			$valor=$TOKEN_SUCURSAL;
			
			$fechaInicial =  $this->txtfechaInicial;
			
			$fechaFinal=  $this->txtfechaFinal;       

		 	$valor1 = $this->activo;
	
		
        $Remision = ControladorRemisiones::ctrRangoFechasRemision( $item,$valor, $fechaInicial, $fechaFinal,$valor1);
       
		if(count($Remision)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Remision as $key => $value) {		
		  	
			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm clonarRemision' title='Clonar remision' tokenRemision='".$value["TOKEN_REMISION"]."' CodigoRemision='".$value["COD_REMISION"]."' ><i class='fas fa-clone text-white'></i></button><button class='btn btn-info btn-sm detalleRemision' data-toggle='modal' data-target='#ModalDetRemision' title='Ver Detalle remision' tokenRemision='".$value["TOKEN_REMISION"]."' CodigoRemision='".$value["COD_REMISION"]."' ><i class='fa fa-info text-white'></i></button><button class='btn btn-danger btn-sm eliminarRemision' title='Recuperar remision' tokenRemision='".$value["TOKEN_REMISION"]."' tokenSucursal='".$value["tokenSucursal"]."' CodigoRemision='".$value["COD_REMISION"]."' estado='".$value["ESTADO_REMISION"]."'><i class='fa fa-ban'></i></button></div>";	

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["NROREMISION"].'",
						"'.$value["FECHA_REMISION"].'",
						"'.$value["SUCURSAL"].'",
						"'.$value["SUCURSAL_A"].'",
						"'.$value["USUARIO"].'",
						"'.$value["OBSERVACION"].'"
						
				],';
				

		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}
	


public function ajaxBuscarDetRemision(){


			$nombres = explode("/",$this->sucursal);
			$TOKEN_SUCURSAL=$nombres[1];

			$item="TOKEN_SUCURSAL";
			$valor=$TOKEN_SUCURSAL;

			$item1="TOKEN_REMISION";
			$valor1=$this->token_remision;   

		 	$valor2 = $this->activo;
		
        $Remision = ModelosRemisiones::mdlBusquedaDetalle($item,$valor, $item1, $valor1,$valor2);
		if(count($Remision)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Remision as $key => $value) {		
		  	
			/*=============================================
			ACCIONES
			=============================================*/

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$value["NROREMISION"].'",
						"'.$value["FECHA_REMISION"].'",
						"'.$value["SUCURSAL"].'",
						"'.$value["SUCURSAL_A"].'",
						"'.$value["CODBARRA"].'",
						"'.$value["DESCRIPCION"].'",
						"'.$value["CANTIDAD"].'",
						"'.$value["STOCK_ANTERIOR"].'",
						"'.$value["STOCK_ANTERIOR_A"].'",
						"'.$value["USUARIO"].'",
						"'.$value["OBSERVACION"].'"
						
				],';
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}


	

		public function ajaxAnularRemision(){

			$nombres = explode("/",$this->tokenSucursal);
			$CODIGO_SUCURSAL=$nombres[0];

			$usuarios = explode("/",$this->usuario);
			$usuario=$usuarios[0];

		
					$datos = array("token_remision" => $this->token_remision,
							"estado"=>$this->estado,
							"usuario"=>$usuario,
							"descripcion"=> $this->descripcion,
							"codigoSucursal"=> $CODIGO_SUCURSAL);



				$respuesta = ControladorRemisiones::ctrAnularRemision($datos);
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();
			}

	
}


/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_POST["txtremision"])){

	$Guardar = new AjaxRemisiones();
	$Guardar -> txtremision = $_POST["txtremision"];
	$Guardar -> txtUsuario = $_POST["txtUsuario"];
	$Guardar -> txtidSucursal = $_POST["txtidSucursal"];
	$Guardar -> cmbSucursalhasta = $_POST["cmbSucursalhasta"];
	$Guardar -> txtproductos = $_POST["txtproductos"];
	$Guardar -> txtObservaciones = $_POST["txtObservaciones"];
	$Guardar -> txtpreciototal = $_POST["txtpreciototal"];
	$Guardar -> ajaxCrearRemision();


}

/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_GET["txtfechaInicial"])){

	$consultar = new AjaxRemisiones();
	$consultar -> txtfechaInicial = $_GET["txtfechaInicial"];
	$consultar -> txtfechaFinal = $_GET["txtfechaFinal"];
	$consultar -> activo = $_GET["activo"];
	$consultar -> sucursal = $_GET["sucursal"];
	$consultar -> ajaxBuscarRemision();

	


}

/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_POST["token_remision"])){

	$consultar = new AjaxRemisiones();
	$consultar -> token_remision = $_POST["token_remision"];
	$consultar -> sucursal = $_POST["sucursal"];
	$consultar -> activo = $_POST["activo"];
	$consultar -> ajaxClonarRemision();


}


/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_GET["token_remisiones"])){

	$consultar = new AjaxRemisiones();
	$consultar -> token_remision = $_GET["token_remisiones"];
	$consultar -> sucursal = $_GET["sucursal"];
	$consultar -> activo = $_GET["activo"];
	$consultar -> ajaxBuscarDetRemision();


}


/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_POST["tokenRemision"])){

	$consultar = new AjaxRemisiones();
	$consultar -> token_remision = $_POST["tokenRemision"];
	$consultar -> estado = $_POST["estado"];
	$consultar -> usuario = $_POST["usuario"];
	$consultar -> descripcion = $_POST["descripcion"];
	$consultar -> tokenSucursal = $_POST["tokenSucursal"];
	$consultar -> ajaxAnularRemision();


}

if(isset($_POST["token_producto"]))
{

	$editar = new AjaxRemisiones();
	$editar -> token_producto = $_POST["token_producto"];
	$editar -> sucursal =$_POST["sucursal"];
	$editar -> activo = $_POST["activo"];
	$editar -> tipo_producto = $_POST["tipo_producto"];
	$editar -> ajaxMostrarDatos();

}