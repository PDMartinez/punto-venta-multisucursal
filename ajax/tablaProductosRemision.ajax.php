<?php

require_once "../controladores/remision.controlador.php";
require_once "../modelos/remision.modelo.php";

class TablaProductos{

	/*=============================================
	Tabla Categorías
	=============================================*/ 
	public $activo;
	public $sucursal;

	public function mostrarTablaCompelto(){

		$item="EST_ARTICULOS";
		$valor=$this->activo;
			
		$nombres = explode("/",$this->sucursal);
		$TOKEN_SUCURSAL=$nombres[1];

		$item1="TIPO_PRODUCTO";
		$valor1=$this->tipo_producto;

		$item2="TOKEN_SUCURSAL";
		$valor2=$TOKEN_SUCURSAL;

		$item3=null;
		$valor3=null;

		$cantiSucursal =0;
		$cantiOtrosur=0;
		$var=$this->actual;
        $Productos = ControladorRemisiones::ctrMostrarProducto($item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3,$var);
             
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

  			$Productos = str_replace(array(',', '"'), '', $value["PRODUCTOS"]);
				  	
			/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 

  	if ($var==0){
  		// if($TOKEN_SUCURSAL==$value["TOKEN_SUCURSAL"]){

  		// }
  		$cantiSucursal++;

		  	$botones =  "<div class='btn-group'><button class='btn btn-success btnAgregarProducto btnrecuperarBoton'  title='Agregar producto' id='demoNotify' idProducto='".$value["TOKEN_PRODUCTO"]."' tokenProducto='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."' idStock='".$value["COD_STOCK"]."'><i class='fas fa-plus-square'></i></button></div>"; 
	
				$datosJson.= '[
							
						"'.($cantiSucursal).'",
						"'.$botones.'",
						"'.$value["CODBARRA"].'",
						"'.$Productos.'",
						"'.$stock.'",
						"'.$imagen.'",
						"'.$value["SUCURSAL"].'"
						
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
	$tabla -> tipo_producto = $_GET["tipo_producto"];
	$tabla -> actual = $_GET["actual"];
	$tabla -> mostrarTablaCompelto();
	
}


