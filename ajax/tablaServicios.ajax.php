<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";
require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursales.modelo.php";

class TablaProductosCombos{

	/*=============================================
	Tabla Categorías
	=============================================*/ 
	public $activo;
	public $sucursal;

	public function mostrarTablaCompelto(){

		$item=null;
		$valor=null;
		$item1="EST_ARTICULOS";
		$valor1=$this->activo;
				//var_dump($valor);
		$nombres = explode("/",$this->sucursal);
		$TOKEN_SUCURSAL=$nombres[1];
		$item2="TOKEN_SUCURSAL";
		$valor2=$TOKEN_SUCURSAL;
		

		$item3="TIPO_PRODUCTO";
		$valor3=$this->tipo_producto;
		// echo '<pre>'; print_r($valor3); echo '</pre>';

		// echo '<pre>'; print_r($_GET["stock"]); echo '</pre>';
	
        $Productos = ControladorProductos::ctrMostrarProducto($item, $valor,$item1, $valor1,$item2, $valor2,$item3,$valor3);
       // echo '<pre>'; print_r($Productos); echo '</pre>';
		
		if(count($Productos)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 			$item="ESTADO_SUCURSAL";
            $valor=1;
            $SucursalHasta= ControladorSucursales::ctrMostrarSucursal($item, $valor,null);
            $cantidadSucursal=count($SucursalHasta);

 		$conteo=0;

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Productos as $key => $value) {

	 			 		
			 $botonesEstado= "<div class='btn btn-danger btn-sm btnActivarProducto' token_stock='".$value["COD_STOCK"].'/'.$value["TOKEN_STOCK"]."' estadoProducto='0'>Desactivar</div>";
			 $productosCombos="";
				 
			/*=============================================
			ACCIONES
			=============================================*/

	// PARA HACER EL TEMA DEL FLETE
			
				
			if($cantidadSucursal<=1)
			{

				$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm editarProductos'  clonar=1 title='Clonar producto' data-toggle='modal' data-target='#ModalProductos' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."'><i class='fas fa-clone'></i></button><button class='btn btn-warning btn-sm editarProductos'   clonar=0 title='Editar producto' data-toggle='modal' data-target='#ModalProductos' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarProductos'  title='Eliminar servicios' IdProductos='".$value["COD_PRODUCTO"]."' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."' token_stock='".$value["COD_STOCK"].'/'.$value["TOKEN_STOCK"]."'><i class='fas fa-trash-alt'></i></button></div>";
			}else{
				$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm ClonarProducto' clonar=1 title='Clonar producto' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."'><i class='fas fa-clone'></i></button><button class='btn btn-warning btn-sm editarProductos'   clonar=0 title='Editar producto' data-toggle='modal' data-target='#ModalProductos' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarProductos'  title='Eliminar servicios' IdProductos='".$value["COD_PRODUCTO"]."' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."' token_stock='".$value["COD_STOCK"].'/'.$value["TOKEN_STOCK"]."'><i class='fas fa-trash-alt'></i></button></div>";
			}

			
				$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["CODBARRA"].'",
						"'.$value["DESCRIPCION"].'",
						"'.number_format($value["PRECIO_CONTADO"],0,',','.').'",
						"'.$value["TIPO_PRODUCTO"].'",
						"'.$botonesEstado.'"
						
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

// $tabla = new TablaProductos();
// $tabla -> mostrarTabla();

if(isset($_GET["sucursal"]))
{

	$tabla = new TablaProductosCombos();
	$tabla -> sucursal = $_GET["sucursal"];
	$tabla -> activo = $_GET["activo"];
	$tabla -> tipo_producto = $_GET["tipo_producto"];
	$tabla -> mostrarTablaCompelto();

}

