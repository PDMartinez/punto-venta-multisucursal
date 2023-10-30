<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

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
        //echo '<pre>'; print_r($Productos); echo '</pre>';
		
		if(count($Productos)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$conteo=0;

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($Productos as $key => $value) {

	 		// if($value["PRECIO_CONTADO"]!="" && $value["PRECIO_CONTADO"]>0){
	 		// $porcentajeGanancia=(($value["PRECIO_CONTADO"]*100)/$value["PRECIO_COMPRA"])-100;
	 		// $porcentajeGanancia=number_format($porcentajeGanancia, 2, ',', '');
	 		// }else{
	 		// 	$porcentajeGanancia=0;
	 		// }
	 	
	 		// if($value["ESTADO_OFERTA"]==1 && $value["PRECIO_OFERTA"]!="" && $value["PRECIO_OFERTA"]>0){
	 		// $porcentajeOferta=(($value["PRECIO_OFERTA"]*100)/$value["PRECIO_COMPRA"])-100;
	 		// $porcentajeOferta=number_format($porcentajeOferta, 2, ',', '');
	 		// }else{
	 		// 	$porcentajeOferta=0;
	 		// }
	 		
	 		// $item="ESTADO_SUCURSAL";
    //         $valor=1;
    //         $SucursalHasta= ControladorSucursales::ctrMostrarSucursal($item, $valor,null);
    //         $cantidadSucursal=count($SucursalHasta);

	 		$cantidadSucursal=2;

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
				$galeria = json_decode("[]", true);
				$imagen = "<td><img src='vistas/img/usuarios/default/anonymous.png'class='img-thumbnail'width='40px'></td>";

				//var_dump($imagen);
	
			}
			
			if ($value["ESTADO_OFERTA"]==1){
				$estadoOferta="EN OFERTA";
			}else{
				$estadoOferta="SIN OFERTA";
			}
		  	
			 $botonesEstado= "<div class='btn btn-danger btn-sm btnActivarProducto' token_stock='".$value["COD_STOCK"].'/'.$value["TOKEN_STOCK"]."' estadoProducto='0'>Desactivar</div>";
			 $productosCombos="";

			 $Productos = str_replace(array(',', '"'), '', $value["DESCRIPCION"]);
			
			if($value["COMBOS"]!=null){

			 $combos = json_decode($value["COMBOS"], true);
			 
			 foreach ($combos as $key => $valores) {
			 	$nombres = explode("/",$valores["id"]);
			 
				$Codigoproductos=$nombres[0];
                  $item = "COD_PRODUCTO";
                  $valor = $Codigoproductos;
                  $orden = "COD_PRODUCTO";

                  $respuesta = ControladorProductos::ctrMostrarSoloProducto($item, $valor, $orden);

                 // $productosCombos .="<div class='alert alert-dismissible alert-dark'>".$valores["cantidad"].' - '.$respuesta["DESCRIPCION"]."</div <br>";

                  $productosCombos .= "<div class='badge badge-secondary mx-1'>".$valores["cantidad"].' - '.str_replace(array(',', '"'), '',$respuesta["DESCRIPCION"])."</div>";
                 
              }

			 }else{
			 	$productosCombos= "<div class='badge badge-secondary mx-1'>No hay productos agregados</div>";
			 }

					/*=============================================
			ACCIONES
			=============================================*/

	// PARA HACER EL TEMA DEL FLETE
		if ($_GET["stock"]==0){
  		// if($TOKEN_SUCURSAL==$value["TOKEN_SUCURSAL"]){

  		// }
			if($this->tipo_producto!="COMBOS"){
 				$botones =  "<div class='btn-group'><button class='btn btn-success btnAgregarProducto btnrecuperarBoton' id='demoNotify' idProducto='".$value["TOKEN_PRODUCTO"]."' tokenProducto='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."' idStock='".$value["COD_STOCK"]."'><i class='fas fa-plus-square'></i></button></div>"; 
			}else{
				$botones =  "<div class='btn-group'><button class='btn btn-secondary'><i class='fa fa-ban'></i></button></div>"; 
			}

			 $Productos1 = str_replace(array(',', '"'), '', $value["DESCRIPCION"]);
		 
	
				$datosJson.= '[
							
						"'.($key+1).'",
						"'.$botones.'",
						"'.$value["CODBARRA"].'",
						"'.$Productos1.'",
						"'.$imagen.'"
						
				],';

			}elseif($_GET["stock"]==1){

				if($cantidadSucursal<=1)
			{

				$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm editarProductos'  clonar=1 title='Clonar producto' data-toggle='modal' data-target='#ModalProductos' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."'><i class='fas fa-clone'></i></button><button class='btn btn-warning btn-sm editarProductos'   clonar=0 title='Editar producto' data-toggle='modal' data-target='#ModalProductos' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-info btn-sm verProductos'  title='Agregar Imagen' data-toggle='modal' data-target='#modalGaleria' IdProductos='".$value["COD_PRODUCTO"]."' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."' token_stock='".$value["COD_STOCK"].'/'.$value["TOKEN_STOCK"]."'><i class='fa fa-camera'></i></button><button class='btn btn-danger btn-sm eliminarProductos'  title='Eliminar producto' galeria='".implode(",", $galeria)."' IdProductos='".$value["COD_PRODUCTO"]."' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."' token_stock='".$value["COD_STOCK"].'/'.$value["TOKEN_STOCK"]."'><i class='fas fa-trash-alt'></i></button></div>";

			}else{
				$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm ClonarProducto' clonar=1 title='Clonar producto' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."'><i class='fas fa-clone'></i></button><button class='btn btn-warning btn-sm editarProductos'   clonar=0 title='Editar producto' data-toggle='modal' data-target='#ModalProductos' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-info btn-sm verProductos'  title='Agregar Imagen' data-toggle='modal' data-target='#modalGaleria' IdProductos='".$value["COD_PRODUCTO"]."' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."' token_stock='".$value["COD_STOCK"].'/'.$value["TOKEN_STOCK"]."'><i class='fa fa-camera'></i></button><button class='btn btn-danger btn-sm eliminarProductos'  title='Eliminar producto' galeria='".implode(",", $galeria)."' IdProductos='".$value["COD_PRODUCTO"]."' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."' token_stock='".$value["COD_STOCK"].'/'.$value["TOKEN_STOCK"]."'><i class='fas fa-trash-alt'></i></button></div>";
			}
			
				$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["CODBARRA"].'",
						"'.$Productos.'",
						"'.$productosCombos.'",
						"'.number_format($value["PRECIO_COMPRA"],0,',','.').'",
						"'.number_format($value["PRECIO_CONTADO"],0,',','.').'",
						"'.$value["PORCENTAJEGANNACIA"].'",
						"'.$value["ESTANTE"].'",
						"'.$value["TIPO_PRODUCTO"].'",
						"'.$imagen.'",
						"'.$botonesEstado.'"
						
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

	$tabla = new TablaProductosCombos();
	$tabla -> sucursal = $_GET["sucursal"];
	$tabla -> activo = $_GET["activo"];
	$tabla -> tipo_producto = $_GET["tipo_producto"];
	$tabla -> mostrarTablaCompelto();

}

