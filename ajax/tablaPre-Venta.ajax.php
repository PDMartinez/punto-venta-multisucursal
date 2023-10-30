<?php

require_once "../controladores/preventas.controlador.php";
require_once "../modelos/preventas.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";


class TablaProductosPreventa{

	/*=============================================
	Tabla Categorías
	=============================================*/ 
	public $activo;
	public $sucursal;

		public function mostrarTablaCompelto(){

		$item="EST_ARTICULOS";
		$valor=$this->activo;
			
		$nombres = explode("/",$this->sucursal);
		$CODIGO_SUCURSAL=$nombres[0];
		$TOKEN_SUCURSAL=$nombres[1];

		$item1="TIPO_PRODUCTO";
		$valor1=$this->tipo_producto;

		$item2="COD_SUCURSAL";
		$valor2=$CODIGO_SUCURSAL;

		$item3=null;
		$valor3=null;
		$cantiSucursal =0;
		$cantiOtrosur=0;
		$var=$this->simbolo;
		
        $Productos = ControladorPreVentas::ctrMostrarProducto($item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3,$var);
     //   echo '<pre>'; print_r($Productos); echo '</pre>';
       
		if(count($Productos)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Productos as $key => $value) {
	 		
	 	//var_dump($TOKEN_SUCURSAL,$value["TOKEN_SUCURSAL"]);


		  	/*=============================================
 	 		TRAEMOS LA IMAGEN
  			=============================================*/ 
  			$galeria = json_decode($value["IMAGEN_PRODUCTO"], true);

  			if ($galeria!="" && $galeria!=null){
	  			
	  			//var_dump($galeria);
				foreach ($galeria as $indice => $valor) {
				
				$imagen = "<img src='".$valor."'width='40px'>";
				
						}
			}else{

				$galeria = json_decode("[]", true);

				$imagen = "<td><img src='vistas/img/productos/default/anonymous.png'class='img-thumbnail'width='40px'></td>";

				//var_dump($imagen);
	
			}
			
				 
			$estadoOferta;
  			$precio_venta;
  			$precio_SinOferta;
  			$Productos;
  			$descuentoNuevo;

  			if($value["TIPO_PRODUCTO"] == "SOLITARIO"){

	  			if ($value["ESTADO_OFERTA"] == 1){
	  				$estadoOferta= "<div class='card text-white bg-danger mb-3'> <p class='card-text text-center'>OFERTA</p></div>";
	  				$precio_venta=$value["PRECIO_OFERTA"];
	  				$precio_SinOferta=$value["PRECIO_CONTADO"];
	  				$descuentoNuevo=$precio_SinOferta-$precio_venta;
	  			}else{
	  				$estadoOferta="<div class='card text-white bg-success mb-3'> <p class='card-text text-center'>SIN OFERTA</p></div>";
	  				$precio_venta=$value["PRECIO_CONTADO"];
	  				$precio_SinOferta=$value["PRECIO_CONTADO"];
	  				$descuentoNuevo=$precio_SinOferta-$precio_venta;
	  			}
	

		  			/*=============================================
	 	 		STOCK
	  			=============================================*/ 

	  			if( $value["EXISTENCIA"] <= 0){

	  				$stock = "<div class='card text-white bg-danger mb-3'> <p class='card-text text-center'>". $value["EXISTENCIA"]."</p></div>";

	  			}elseif( $value["EXISTENCIA"] <= $value["STOCKMINIMO"]){

	  				$stock = "<div class='card text-white bg-warning mb-3'> <p class='card-text text-center'>".$value["EXISTENCIA"]."</p></div>";

	  			}else{

	  				$stock = "<div class='card text-white bg-success mb-3'> <p class='card-text text-center'>".$value["EXISTENCIA"]."</p></div>";

	  			}

	  			// $Productos=str_replace(' ','"',$value["PRODUCTOS"]);
	  			$Productos = str_replace(array(',', '"'), '', $value["PRODUCTOS"]);
 	
  			}else{

  				if($value["TIPO_PRODUCTO"] == "COMBOS"){

						$Productos ="<a class='btnVerDetalleCombos' combos='".$value["COD_PRODUCTO"]."' href='#' data-dismiss='modal' data-toggle='modal' data-target='#ModalDetCombos'>". str_replace(array(',', '"'), '', $value["PRODUCTOS"])."</a>";
  							  		
  					}else if ($value["TIPO_PRODUCTO"] == "FLETES") {
  						$Productos = str_replace(array(',', '"'), '', $value["PRODUCTOS"]);
  					}
  				//$Productos = str_replace(array(',', '"'), '', $value["PRODUCTOS"]);
  				$estadoOferta= "<div class='card text-white bg-danger mb-3'> <p class='card-text text-center'>OFERTA</p></div>";
	  			$precio_venta=$value["PRECIO_CONTADO"];
	  			$precio_SinOferta=$value["PRECIO_CONTADO"];
	  			$descuentoNuevo=$precio_SinOferta-$precio_venta;
	  			$stock = "<div class='card text-white bg-success mb-3'> <p class='card-text text-center'>0</p></div>";
  			}
  		
			/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 

  	if ($TOKEN_SUCURSAL==$value["TOKEN_SUCURSAL"]){
  		// if($TOKEN_SUCURSAL==$value["TOKEN_SUCURSAL"]){

  		// }
  		$cantiSucursal++;

		  	$botones =  "<div class='btn-group'><button class='btn btn-success btnAgregarProducto btnAgregarProducto".$value["COD_PRODUCTO"]."'  title='Agregar producto' id='demoNotify' idProducto='".$value["COD_PRODUCTO"]."' tokenProducto='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."' tipoproducto='".$value["TIPO_PRODUCTO"]."' idStock='".$value["COD_STOCK"]."'><i class='btnAgregarProductoIcono fas fa-plus-square'></i></button></div>"; 
				$datosJson.= '[
							
						"'.($cantiSucursal).'",
						"'.$botones.'",
						"'.$value["CODBARRA"].'",
						"'.$Productos.'",
						"'.$stock.'",
						"'.number_format($precio_venta,0,',','.').'",
						"'.$estadoOferta.'",
						"'.$imagen.'",
						"'.$value["TIPO_PRODUCTO"].'",
						"'.$value["SUCURSAL"].'",
						"'.$value["PORCENTAJE"].'",
						"'.number_format($precio_SinOferta,0,',','.').'",
						"'.number_format($descuentoNuevo,0,',','.').'",
						"'.$value["TOKEN_PRODUCTO"].'",
						"'.$value["COD_CANAL"].'"
						
						
				],';

			}else{
				$cantiOtrosur++;

					$botones =  "<div class='btn-group'><button class='btn btn-danger disabled' title='No es posible agregar'><i class='fas fa-plus-square'></i></button></div>"; 

				$datosJson.= '[
							
						"'.($cantiOtrosur).'",
						"'.$botones.'",
						"'.$value["CODBARRA"].'",
						"'.$Productos.'",
						"'.$stock.'",
						"'.number_format($precio_venta,0,',','.').'",
						"'.$estadoOferta.'",
						"'.$imagen.'",
						"'.$value["TIPO_PRODUCTO"].'",
						"'.$value["SUCURSAL"].'",
						"'.$value["PORCENTAJE"].'",
						"'.number_format($precio_SinOferta,0,',','.').'",
						"'.number_format($descuentoNuevo,0,',','.').'",
						"'.$value["TOKEN_PRODUCTO"].'",
						"'.$value["COD_CANAL"].'"
				],';
			}

				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;
							
	}




/*=============================================
LLAMAR A PARA BUSCAR PRE VENTAS
=============================================*/	


public function ajaxBuscarVenta(){


			$nombres = explode("/",$this->sucursal);
			$TOKEN_SUCURSAL=$nombres[1];

			$item="TOKEN_SUCURSAL";
			$valor=$TOKEN_SUCURSAL;
			
			$fechaInicial =  $this->txtfechaInicial;
			
			$fechaFinal=  $this->txtfechaFinal;       

		 	$valor1 = $this->activo;
			$UsuarioAnulo="";
			$valor2="PRE-VENTAS";


			$eliminar="";
			$imprimirPreventa="";
			$clonar="";
			$verDetalle="";
		
        $pre_Venta = ControladorPreVentas::ctrRangoFechasVenta( $item,$valor, $fechaInicial, $fechaFinal,$valor1,$valor2);
       
		if(count($pre_Venta)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($pre_Venta as $key => $value) {

	 			  	
	 	
			/*=============================================
			ACCIONES
			=============================================*/

		$imprimirPreventa="<button class='btn btn-primary btn-sm imprimirPreVenta' title='Imprimir Pre-Venta' tokenVenta='".$value["COD_PEDIDO"]."/".$value["TOKEN_PEDIDO"]."' CodigoVenta='".$value["COD_PEDIDO"]."' ><i class='fa-solid fa-print'></i></button>";

		if($valor1==1){
				$eliminar="<button class='btn btn-danger btn-sm eliminarVenta' title='Anular Pre- Venta' tokenVenta='".$value["TOKEN_PEDIDO"]."' tokenSucursal='".$value["tokenSucursal"]."' CodigoVenta='".$value["COD_PEDIDO"]."' estado='".$value["ESTADO_PEDIDO"]."'><i class='fa-solid fa-ban'></i></button>";
			}else{
				$eliminar="<button class='btn btn-success btn-sm eliminarVenta' title='Anular Pre- Venta' tokenVenta='".$value["TOKEN_PEDIDO"]."' tokenSucursal='".$value["tokenSucursal"]."' CodigoVenta='".$value["COD_PEDIDO"]."' estado='".$value["ESTADO_PEDIDO"]."'><i class='fa fa-recycle'></i></button>";
			}

	

		$clonar="<button class='btn btn-primary btn-sm clonarVenta' title='Clonar Pre- venta' tokenVenta='".$value["TOKEN_PEDIDO"]."' CodigoVenta='".$value["COD_PEDIDO"]."' ><i class='fa-solid fa-clone'></i></button>";

		$verDetalle="<button class='btn btn-info btn-sm detalleVenta' data-toggle='modal' data-target='#ModalDetVenta' title='Ver Detalle Pre- venta'  tokenVenta='".$value["TOKEN_PEDIDO"]."'CodigoVenta='".$value["COD_PEDIDO"]."' ><i class='fa-solid fa-info'></i></button>";

			$acciones = "<div class='btn-group'> ".$clonar.$verDetalle.$eliminar.$imprimirPreventa." </div>";


			if($valor1==1){
				
			

				$datosJson.= '[
								
							"'.($key+1).'",
							"'.$acciones.'",
							"'.$value["FECHA_PEDIDO"].'",
							"'.number_format($value["TOTAL_PEDIDO"],0,',','.').'",
							"'.$value["CLIENTE"].'",
							"'.$value["SUCURSAL"].'",
							"'.$value["USUARIO"].'"
							
					],';
				

			}else{

				$item = "COD_USUARIO";
				$valor = $value["USUARIO_ANULADO"];

				$respuesta = ControladorUsuarios::ctrMostrarUsuario($item, $valor);
				$UsuarioAnulo=$respuesta["USUARIO"];
					$datosJson.= '[
								
							"'.($key+1).'",
							"'.$acciones.'",
							"'.$value["FECHA_PEDIDO"].'",
							"'.number_format($value["TOTAL_PEDIDO"],0,',','.').'",
							"'.$value["CLIENTE"].'",
							"'.$value["SUCURSAL"].'",
							"'.$value["USUARIO"].'",
							"'.$value["FECHA_ANULADA"].'",
							"'.$respuesta["USUARIO"].'",
							"'.$value["DESCRIPCION_ANULACION"].'"
							

							
					],';

				
			}


				
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;


}



/*=============================================
LLAMAR A PARA BUSCAR PRE VENTAS DETALLES
=============================================*/	

public function ajaxBuscarDetVenta(){


			$nombres = explode("/",$this->sucursal);
			$TOKEN_SUCURSAL=$nombres[1];

			$item="TOKEN_SUCURSAL";
			$valor=$TOKEN_SUCURSAL;

			$item1="TOKEN_PEDIDO";
			$valor1=$this->token_venta;   

		 	$valor2 = $this->activo;
		
        $pre_Venta = ModelosPreVentas::mdlBusquedaDetalle($item,$valor, $item1, $valor1,$valor2);

		if(count($pre_Venta)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($pre_Venta as $key => $value) {		
		  	
			/*=============================================
			ACCIONES
			=============================================*/
			$Productos = str_replace(array(',', '"'), '', $value["DESCRIPCION"]);

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$value["FECHA_PEDIDO"].'",
						"'.$value["CLIENTE"].'",
						"'.$value["CODBARRA"].'",
						"'.$Productos.'",
						"'.$value["CANTIDAD"].'",
						"'.number_format($value["PRECIO_UNI"],0,',','.').'",
						"'.number_format($value["PRECIO_NETO"],0,',','.').'",
						"'.$value["USUARIO"].'",
						"'.$value["SUCURSAL"].'"
						
				],';
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}





}

/*=============================================
Tabla Sucursales
=============================================*/ 

// $tabla = new TablaProductosPreventa();
// $tabla -> mostrarTabla();

if(isset($_GET["tipo_producto"]))
{

	$tabla = new TablaProductosPreventa();
	$tabla -> sucursal = $_GET["sucursal"];
	$tabla -> activo = $_GET["activo"];
	$tabla -> tipo_producto = $_GET["tipo_producto"];
	$tabla -> simbolo = $_GET["simbolo"];
	$tabla -> mostrarTablaCompelto();
	
}

/*=============================================
LLAMAR A PARA BUSCAR PRE VENTAS
=============================================*/	

if(isset($_GET["txtfechaInicial"])){

	$consultar = new TablaProductosPreventa();
	$consultar -> txtfechaInicial = $_GET["txtfechaInicial"];
	$consultar -> txtfechaFinal = $_GET["txtfechaFinal"];
	$consultar -> activo = $_GET["activo"];
	$consultar -> sucursal = $_GET["sucursal"];
		$consultar -> ajaxBuscarVenta();

}


/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_GET["token_ventas"])){

	$consultar = new TablaProductosPreventa();
	$consultar -> token_venta = $_GET["token_ventas"];
	$consultar -> sucursal = $_GET["sucursal"];
	$consultar -> activo = $_GET["activo"];
	$consultar -> ajaxBuscarDetVenta();


}


