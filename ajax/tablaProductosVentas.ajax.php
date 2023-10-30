<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

class TablaProductos{

	/*=============================================
	Tabla Categorías
	=============================================*/ 
	public $activo;
	public $sucursal;

	public function mostrarTablaCompelto(){
		
		$item="p.EST_ARTICULOS";
		$valor=$this->activo;

		$item1="TIPO_PRODUCTO";
		$valor1=$this->tipo_producto;

		$nombres = explode("/",$this->sucursal);
		$TOKEN_SUCURSAL=$nombres[1];
		$CODIGO_SUCURSAL=$nombres[0];
		$item2="s.COD_SUCURSAL";
		$valor2=$CODIGO_SUCURSAL;


		$item3=null;
		$valor3=null;

		$var=null;
        $Productos = ControladorVentas::ctrMostrarProducto($item, $valor,$item1, $valor1,$item2,$valor2,$item3,$valor3,$var);
       
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

  			if ($galeria!="" && $galeria!=[""] && $galeria!=NULL){
	  			
	  			//var_dump($galeria);
				foreach ($galeria as $indice => $valor) {
				
				$imagen = "<img src='".$valor."'width='40px'>";
						}
			}else{

				$imagen = "<td><img src='vistas/img/productos/default/anonymous.png'class='img-thumbnail'width='40px'></td>";

				//var_dump($imagen);
	
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

  			$estadoOferta;
  			$precio_venta;
  			if ($value["ESTADO_OFERTA"] == 1){
  				$estadoOferta="OFERTA";
  				$precio_venta=$value["PRECIO_OFERTA"];
  			}else{
  				$estadoOferta="SIN OFERTA";
  				$precio_venta=$value["PRECIO_CONTADO"];
  			}


				  	
			/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 

  	if ($_GET["stock"]=="0" && $TOKEN_SUCURSAL==$value["TOKEN_SUCURSAL"]){
  		// if($TOKEN_SUCURSAL==$value["TOKEN_SUCURSAL"]){

  		// }

		  	$botones =  "<div class='btn-group'><button class='btn btn-success btnAgregarProducto btnrecuperarBoton' id='demoNotify' idProducto='".$value["COD_PRODUCTO"]."' tokenProducto='".$value["TOKEN_PRODUCTO"]."' idStock='".$value["COD_STOCK"]."'><i class='fas fa-plus-square'></i></button></div>"; 
	
				$datosJson.= '[
							
						"'.($key+1).'",
						"'.$botones.'",
						"'.$value["CODBARRA"].'",
						"'.$value["DESCRIPCION"].' '.$value["NOMBRE_MARCA"].' '.$value["NOMBRE_CATEGORIA"].'",
						"'.$stock.'",
						"'.number_format($precio_venta,0,',','.').'",
						"'.$estadoOferta.'",
						"'.$imagen.'",
						"'.$value["PORCENTAJE"].'",
						"'.$value["TIPO_PRODUCTO"].'",
						"'.$value["COMBOS"].'"
						
				],';

			}elseif($_GET["stock"]=="1" && $TOKEN_SUCURSAL!=$value["TOKEN_SUCURSAL"]){

				$datosJson.= '[
							
						"'.($key+1).'",
						"'.$value["CODBARRA"].'",
						"'.$value["DESCRIPCION"].' '.$value["NOMBRE_MARCA"].' '.$value["NOMBRE_CATEGORIA"].'",
						"'.$stock.'",
						"'.$imagen.'",
						"'.$value["SUCURSAL"].'"
				],';
			}

				
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

// $tabla = new TablaProductos();
// $tabla -> mostrarTabla();

if(isset($_GET["sucursal"]))
{

	$tabla = new TablaProductos();
	$tabla -> sucursal = $_GET["sucursal"];
	$tabla -> activo = $_GET["activo"];
	$tabla -> tipoproducto = $_GET["tipoproducto"];
	$tabla -> mostrarTablaCompelto();
	
}

