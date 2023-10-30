<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

class TablaProductosVentas{

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
		
        $Productos = ControladorVentas::ctrMostrarProducto($item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3,$var);
       
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
  							  		
  					}else  {
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
						"'.$value["NOMBRE_MARCA"].'",
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
						"'.$value["NOMBRE_MARCA"].'",
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


public function ajaxBuscarPreVenta(){


			$nombres = explode("/",$this->sucursal);
			$TOKEN_SUCURSAL=$nombres[1];

			$item="s.TOKEN_SUCURSAL";
			$valor=$TOKEN_SUCURSAL;
			
		 	$valor1 = $this->activo;
		 	$item1 = "p.ESTADO_PEDIDO";
		 	

			$valor2= $this->tipo;
			$item2="p.TIPO_PEDIDO";
			$order="p.COD_PEDIDO DESC";

					$clonar="";
			$verDetalle="";
		
        $pre_Venta = ControladorVentas::ctrConsultarPreVenta($item,$valor,$item1,$valor1,$item2,$valor2,$order);
       
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
			

		$clonar="<button class='btn btn-primary btn-sm CargarPedidos CargarPedidos".$value["COD_PEDIDO"]."' title='Cargar Pre- venta' tokenPedidos='".$value["TOKEN_PEDIDO"]."' CodigoPedidos='".$value["COD_PEDIDO"]."' ><i class='fa-solid fa-file-import'></i></button>";

		$verDetalle="<button class='btn btn-info btn-sm detallePedidos' data-toggle='modal' data-target='#ModalDetPedidos' title='Ver Detalle Pre- venta'  tokenPedidos='".$value["TOKEN_PEDIDO"]."'CodigoPedidos='".$value["COD_PEDIDO"]."' ><i class='fa-solid fa-info'></i></button>";

			$acciones = "<div class='btn-group'> ".$verDetalle.$clonar." </div>";


				$datosJson.= '[
								
							"'.($key+1).'",
							"'.$acciones.'",
							"'.$value["RUC"].'",
							"'.$value["CLIENTE"].'",
							"'.$value["FECHA_PEDIDO"].'",
							"'.number_format($value["TOTAL_PEDIDO"],0,',','.').'",
							"'.$value["SUCURSAL"].'",
							"'.$value["USUARIO"].'"
							
					],';
				
			
				
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;


}


	public function ajaxBuscarCombos (){

				$item="COD_PRODUCTO";
				$valor=$this->combosProductos;

				$tabla="productos";
				$select="COMBOS";
		
        		$combos = ControladorVentas::ctrMostrarCombos($tabla,$item, $valor,$select);
        	
       
		if ($combos!="" && $combos!=null){

			$combosnuevos = json_decode($combos["COMBOS"], true);
			
			$datosJson = '{

	 	"data": [ ';

				  			
				  			//var_dump($galeria);
			foreach ($combosnuevos as $key => $value) {

				$nombres = explode("/",$value["id"]);
				
				$cant=$value["cantidad"];
								
				$codigoproducto=$nombres[0];

				$item="COD_PRODUCTO";
				$valor=$codigoproducto;

				$tabla="productos";
				$select=" DESCRIPCION,CODBARRA ";
		
        		$combos = ControladorVentas::ctrMostrarCombos($tabla,$item, $valor,$select);

					
			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$combos["CODBARRA"].'",
						"'.$combos["DESCRIPCION"].'",
						"'.$cant.'"
						
						
				],';
				

							
									}

			$datosJson = substr($datosJson, 0, -1);

				$datosJson.=  ']

				}';

				echo $datosJson;

		
			}


	
        	
	
	}




}

/*=============================================
Tabla Sucursales
=============================================*/ 

// $tabla = new TablaProductosVentas();
// $tabla -> mostrarTabla();

if(isset($_GET["sucursal"]))
{

	$tabla = new TablaProductosVentas();
	$tabla -> sucursal = $_GET["sucursal"];
	$tabla -> activo = $_GET["activo"];
	$tabla -> tipo_producto = $_GET["tipo_producto"];
	$tabla -> simbolo = $_GET["simbolo"];
	$tabla -> mostrarTablaCompelto();
	
}

if(isset($_GET["sucursalPedidos"]))
{

	$tabla = new TablaProductosVentas();
	$tabla -> sucursal = $_GET["sucursalPedidos"];
	$tabla -> activo = $_GET["activo"];
	$tabla -> tipo = $_GET["tipo"];
	$tabla -> ajaxBuscarPreVenta();
	
}

/*================================================
	MOSTRAR METODO DE PAGO
==================================================*/
if(isset($_GET["combosProductos"])){

	$mostrar = new TablaProductosVentas();
	$mostrar -> combosProductos = $_GET["combosProductos"];
	$mostrar -> ajaxBuscarCombos();

}





