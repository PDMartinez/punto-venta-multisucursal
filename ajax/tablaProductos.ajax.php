<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";
require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursales.modelo.php";

class TablaProductos{

	/*=============================================
	Tabla Categorías
	=============================================*/ 
	public $activo;
	public $sucursal;

	public function mostrarTablaCompelto(){

		
		$btnEditar="";
		$btnClonar="";
		$btnAjustar="";
		$btnagregarImagen="";
		$btnEliminar="";

		$item=null;
		$valor=null;
		$item1="EST_ARTICULOS";
		$valor1=$this->activo;
		$nombres = explode("/",$this->sucursal);
		$TOKEN_SUCURSAL=$nombres[1];
		$item2="TOKEN_SUCURSAL";
		$valor2=$TOKEN_SUCURSAL;

		$item3="TIPO_PRODUCTO";
		$valor3=$this->tipo_producto;

		//echo '<pre>'; print_r($_GET["stock"]); echo '</pre>';
	
        $Productos = ControladorProductos::ctrMostrarProducto($item, $valor,$item1, $valor1,$item2, $valor2,$item3,$valor3);
		
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
		  	// STOCK

			$Productos = str_replace(array(',', '"'), '', $value["DESCRIPCION"]);
			/*=============================================
			ACCIONES
			=============================================*/



			if($cantidadSucursal<=1)
			{
			
			$btnClonar="<button class='btn btn-primary btn-sm editarProductos'  clonar=1 title='Clonar producto' data-toggle='modal' data-target='#ModalProductos' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."'><i class='fas fa-clone'></i></button>";
			$btnEditar="<button class='btn btn-warning btn-sm editarProductos'   clonar=0 title='Editar producto' data-toggle='modal' data-target='#ModalProductos' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."'><i class='fas fa-pencil-alt text-white'></i></button>";

			$btnagregarImagen="<button class='btn btn-info btn-sm verProductos'  title='Agregar Imagen' data-toggle='modal' data-target='#modalGaleria' IdProductos='".$value["COD_PRODUCTO"]."' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."' token_stock='".$value["COD_STOCK"].'/'.$value["TOKEN_STOCK"]."'><i class='fa fa-camera'></i></button>";
			
			$btnEliminar="<button class='btn btn-danger btn-sm eliminarProductos'  title='Eliminar producto' galeria='".implode(",", $galeria)."' IdProductos='".$value["COD_PRODUCTO"]."' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."' token_stock='".$value["COD_STOCK"].'/'.$value["TOKEN_STOCK"]."'><i class='fas fa-trash-alt'></i></button>";


			}else{

			$btnClonar="<button class='btn btn-primary btn-sm ClonarProducto' clonar=1 title='Clonar producto' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."'><i class='fas fa-clone'></i></button>";	

			$btnEditar="<button class='btn btn-warning btn-sm editarProductos'   clonar=0 title='Editar producto' data-toggle='modal' data-target='#ModalProductos' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."'><i class='fas fa-pencil-alt text-white'></i></button>";

			$btnagregarImagen="<button class='btn btn-info btn-sm verProductos'  title='Agregar Imagen' data-toggle='modal' data-target='#modalGaleria' IdProductos='".$value["COD_PRODUCTO"]."' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."' token_stock='".$value["COD_STOCK"].'/'.$value["TOKEN_STOCK"]."'><i class='fa fa-camera'></i></button>";

					
			$btnEliminar="<button class='btn btn-danger btn-sm eliminarProductos'  title='Eliminar producto' galeria='".implode(",", $galeria)."' IdProductos='".$value["COD_PRODUCTO"]."' tokenProductos='".$value["COD_PRODUCTO"].'/'.$value["TOKEN_PRODUCTO"]."' token_stock='".$value["COD_STOCK"].'/'.$value["TOKEN_STOCK"]."'><i class='fas fa-trash-alt'></i></button>";

			
			}

			$acciones = "<div class='btn-group'> ".$btnClonar.$btnEditar.$btnagregarImagen.$btnEliminar." </div>";

			if ($_GET["stock"]==1){
			
				
				if ($value["EXISTENCIA"]>0){
						$conteo =$conteo+1;
		
			$datosJson.= '[
							
						"'.($conteo).'",
						"'.$acciones.'",
						"'.$value["CODBARRA"].'",
						"'.$Productos.'",
						"'.number_format($value["PRECIO_COMPRA"],0,',','.').'",
						"'.number_format($value["PRECIO_CONTADO"],0,',','.').'",
						"'.$value["PORCENTAJEGANNACIA"].'",
						"'.$value["EXISTENCIA"].'",
						"'.$value["STOCKMINIMO"].'",
						"'.$value["NOMBRE_CATEGORIA"].'",
						"'.$value["NOMBRE_SUBCATEGORIA"].'",
						"'.$value["NOMBRE_MARCA"].'",
						"'.$value["UNIDAD_MEDIDA"].'",
						"'.$value["DIMENSION"].'",
						"'.$value["CANTIDAD_PAQUETE"].'",
						"'.$value["ESTANTE"].'",
						"'.$value["TIPO_PRODUCTO"].'",
						"'.number_format($value["PRECIO_OFERTA"],0,',','.').'",
						"'.$value["PORCENTAJEOFERTA"].'",
						"'.$estadoOferta.'",
						"'.$value["MOVIMIENTO_PRODUCTO"].'",
						"'.$imagen.'",
						"'.$botonesEstado.'"
						
				],';

				} 
			}elseif($_GET["stock"]==2){
				
				if ($value["EXISTENCIA"]<=0){
					$conteo =$conteo+1;
					$datosJson.= '[
							
						"'.($conteo).'",
						"'.$acciones.'",
						"'.$value["CODBARRA"].'",
						"'.$Productos.'",
						"'.number_format($value["PRECIO_COMPRA"],0,',','.').'",
						"'.number_format($value["PRECIO_CONTADO"],0,',','.').'",
						"'.$value["PORCENTAJEGANNACIA"].'",
						"'.$value["EXISTENCIA"].'",
						"'.$value["STOCKMINIMO"].'",
						"'.$value["NOMBRE_CATEGORIA"].'",
						"'.$value["NOMBRE_SUBCATEGORIA"].'",
						"'.$value["NOMBRE_MARCA"].'",
						"'.$value["UNIDAD_MEDIDA"].'",
						"'.$value["DIMENSION"].'",
						"'.$value["CANTIDAD_PAQUETE"].'",
						"'.$value["ESTANTE"].'",
						"'.$value["TIPO_PRODUCTO"].'",
						"'.number_format($value["PRECIO_OFERTA"],0,',','.').'",
						"'.$value["PORCENTAJEOFERTA"].'",
						"'.$estadoOferta.'",
						"'.$value["MOVIMIENTO_PRODUCTO"].'",
						"'.$imagen.'",
						"'.$botonesEstado.'"
						
				],';

				}

			}elseif($_GET["stock"]==3){

				if ($value["EXISTENCIA"]<=$value["STOCKMINIMO"]){
					$conteo =$conteo+1;
					$datosJson.= '[
							
						"'.($conteo).'",
						"'.$acciones.'",
						"'.$value["CODBARRA"].'",
						"'.$Productos.'",
						"'.number_format($value["PRECIO_COMPRA"],0,',','.').'",
						"'.number_format($value["PRECIO_CONTADO"],0,',','.').'",
						"'.$value["PORCENTAJEGANNACIA"].'",
						"'.$value["EXISTENCIA"].'",
						"'.$value["STOCKMINIMO"].'",
						"'.$value["NOMBRE_CATEGORIA"].'",
						"'.$value["NOMBRE_SUBCATEGORIA"].'",
						"'.$value["NOMBRE_MARCA"].'",
						"'.$value["UNIDAD_MEDIDA"].'",
						"'.$value["DIMENSION"].'",
						"'.$value["CANTIDAD_PAQUETE"].'",
						"'.$value["ESTANTE"].'",
						"'.$value["TIPO_PRODUCTO"].'",
						"'.number_format($value["PRECIO_OFERTA"],0,',','.').'",
						"'.$value["PORCENTAJEOFERTA"].'",
						"'.$estadoOferta.'",
						"'.$value["MOVIMIENTO_PRODUCTO"].'",
						"'.$imagen.'",
						"'.$botonesEstado.'"
						
				],';

				}
			}else{
				$datosJson.= '[
							
						"'.($key+1).'",
						"'.$acciones.'",
						"'.$value["CODBARRA"].'",
						"'.$Productos.'",
						"'.number_format($value["PRECIO_COMPRA"],0,',','.').'",
						"'.number_format($value["PRECIO_CONTADO"],0,',','.').'",
						"'.$value["PORCENTAJEGANNACIA"].'",
						"'.$value["EXISTENCIA"].'",
						"'.$value["STOCKMINIMO"].'",
						"'.$value["NOMBRE_CATEGORIA"].'",
						"'.$value["NOMBRE_SUBCATEGORIA"].'",
						"'.$value["NOMBRE_MARCA"].'",
						"'.$value["UNIDAD_MEDIDA"].'",
						"'.$value["DIMENSION"].'",
						"'.$value["CANTIDAD_PAQUETE"].'",
						"'.$value["ESTANTE"].'",
						"'.$value["TIPO_PRODUCTO"].'",
						"'.number_format($value["PRECIO_OFERTA"],0,',','.').'",
						"'.$value["PORCENTAJEOFERTA"].'",
						"'.$estadoOferta.'",
						"'.$value["MOVIMIENTO_PRODUCTO"].'",
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

	$tabla = new TablaProductos();
	$tabla -> sucursal = $_GET["sucursal"];
	$tabla -> activo = $_GET["activo"];
	$tabla -> tipo_producto = $_GET["tipo_producto"];
	$tabla -> mostrarTablaCompelto();

}

