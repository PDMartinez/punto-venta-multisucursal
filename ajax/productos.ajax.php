<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class AjaxProductos{

	
	public function ajaxValidar(){
		
		$nombres = explode("/",$this->validarValor1);
		
		
		
		$item =$this->validarItem;
		$valor = $this->validarValor;

		$item1="COD_SUCURSAL";
		$valor1=$nombres[0];
		$columna="COD_PRODUCTO";
		$tabla="productos";
		$tabla1="stocks";

		$respuesta = ModeloVarios::MdlValidarDatosInner($tabla,$tabla1,$columna,$item,$valor,$item1,$valor1);

		echo json_encode($respuesta);

	}



	/*=============================================
	EDITAR ProductoS
	=============================================*/	

	public $token_producto;
	public $sucursal;
	public $activo;

	public function ajaxEditarProducto()
	{

		$nombres = explode("/",$this->token_producto);
		
		$item="TOKEN_PRODUCTO";
		$valor=$nombres[1];

		$item1="EST_ARTICULOS";
		$valor1=$this->activo;

				//var_dump($valor);
		$nombres = explode("/",$this->sucursal);
		$TOKEN_SUCURSAL=$nombres[1];

		$item2="TOKEN_SUCURSAL";
		$valor2=$TOKEN_SUCURSAL;


		$item3="TIPO_PRODUCTO";
		$valor3=$this->tipo_producto;
	
        $respuesta = ControladorProductos::ctrMostrarProducto($item, $valor,$item1, $valor1,$item2, $valor2,$item3,$valor3);

		echo json_encode($respuesta);
		//var_dump($respuesta);
	}

	/*=============================================
	MOSTRAR IMAGENES
	=============================================*/

	public function ajaxMostrarImagenes(){

		$nombres = explode("/",$this->token);
		
		$item="TOKEN_PRODUCTO";
		$valor=$nombres[1];
		$order="TOKEN_PRODUCTO";
		// var_dump($valor);
	
        $respuesta = ControladorProductos::ctrMostrarImagen($item, $valor,$order);

		echo json_encode($respuesta);

	}



	/*=============================================
	Guardar Perfiles
	=============================================*/	

	public function ajaxGuardarProducto(){
		$codcategoria;
		$codsubcategoria;
		$codmarca;
		$sucursales;
		$codStock;
		$codCanal;

		//$TOKEN_CIUDAD;
		if(($this->cmbMarca)!=""){
			$nombres = explode("/", $this->cmbMarca);
			$codmarca=$nombres[0];
		//	$TOKEN_CIUDAD=$nombres[1];
		}

		if(($this->cmbSubCategoria)!=""){
			$nombres = explode("/", $this->cmbSubCategoria);
			$codsubcategoria=$nombres[0];
		//	$TOKEN_CIUDAD=$nombres[1];
		}

		if(($this->cmbCategoria)!=""){
			$nombres = explode("/", $this->cmbCategoria);
			$codcategoria=$nombres[0];
		//	$TOKEN_CIUDAD=$nombres[1];
		}

		if(($this->codSucursal)!=""){
			$nombres = explode("/", $this->codSucursal);
			$codsucursal=$nombres[0];
		//	$TOKEN_CIUDAD=$nombres[1];
		}

		if(($this->idstock)!=""){
			$nombres = explode("/", $this->idstock);
			$codStock=$nombres[0];
		//	$TOKEN_CIUDAD=$nombres[1];
		}

		if(($this->cmbcanal)!=""){
			$nombres = explode("/", $this->cmbcanal);
			$codCanal=$nombres[0];
		//	$TOKEN_CIUDAD=$nombres[1];
		}


		if(($this->txtTokenProducto)!=""){

			$datos = array("txtcodProducto" => $this->txtcodProducto,
							"txtTokenProducto"=>$this->txtTokenProducto,
							"txtDescripcion"=>$this->txtDescripcion,
							"cmbCategoria"=>$codcategoria,
							"cmbSubCategoria"=> $codsubcategoria,
							"cmbmarca"=> $codmarca,
						    "txtcodigobarra" =>$this->txtcodigobarra,
							"txtpreciocompra"=>$this->txtpreciocompra,
							"txtprecioventa"=> $this->txtprecioventa,
							"txtstock"=>$this->txtstock,
							"cmbiva"=> $this->cmbiva,
						    "txtstockminimo" =>$this->txtstockminimo,
							"txtdimension"=>$this->txtdimension,
							"txtcantPaquete"=> $this->txtcantPaquete,
							"cmbMedida"=>($this->cmbMedida),
							"txtUbicacion"=>$this->txtUbicacion,
							"txttipoProducto"=> $this->txttipoProducto,
						    "txtOferta" =>$this->txtOferta,
							"chkoferta"=>$this->chkoferta,
							"sucursal"=> $codsucursal,
							"usuario"=> $this->usuario,
							"combos"=>$this->combos,
							"movimiento"=>$this->movimiento,
							"codcanal"=>$codCanal,
							"idstock"=>$codStock,
							"insertar"=> $this->insertar);

				// var_dump($datos);
				// return;
				$editar = ControladorProductos::ctrEditarProducto($datos);
				
				echo json_encode($editar,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

		}else{

				$datos = array("txtDescripcion"=>$this->txtDescripcion,
							"cmbCategoria"=>$codcategoria,
							"cmbSubCategoria"=> $codsubcategoria,
							"cmbmarca"=> $codmarca,
						    "txtcodigobarra" =>$this->txtcodigobarra,
							"txtpreciocompra"=>$this->txtpreciocompra,
							"txtprecioventa"=> $this->txtprecioventa,
							"txtstock"=>$this->txtstock,
							"cmbiva"=> $this->cmbiva,
						    "txtstockminimo" =>$this->txtstockminimo,
							"txtdimension"=>$this->txtdimension,
							"txtcantPaquete"=> $this->txtcantPaquete,
							"cmbMedida"=>($this->cmbMedida),
							"txtUbicacion"=>$this->txtUbicacion,
							"txttipoProducto"=> $this->txttipoProducto,
						    "txtOferta" =>$this->txtOferta,
							"chkoferta"=>$this->chkoferta,
							"sucursal"=> $codsucursal,
							"usuario"=> $this->usuario,
							"combos"=>$this->combos,
							"movimiento"=>$this->movimiento,
							"codcanal"=>$codCanal);

				 //var_dump($datos);
				 // return;

				$respuesta = ControladorProductos::ctrCrearProducto($datos);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

		}
		
	}


	/*=============================================
	Eliminar PERFILES
	=============================================*/	

	public $idEliminar;
	public $galeria;
	public $token_stock;

	public function ajaxEliminarProducto(){
		$tokenStock;
		$tokenProducto;
		if(($this->token_stock)!=""){
			$nombres = explode("/", $this->token_stock);
			$tokenStock=$nombres[1];
		//	$TOKEN_CIUDAD=$nombres[1];
		}
		if(($this->idEliminar)!=""){
			$nombres = explode("/", $this->idEliminar);
			$tokenProducto=$nombres[1];
		//	$TOKEN_CIUDAD=$nombres[1];
		}
		$datos = array( "idEliminar" => $tokenProducto,
						"galeria" => $this->galeria,
						"tokenStock" => $tokenStock);
		//var_dump($datos);

		$respuesta = ControladorProductos::ctrBorrarProducto($datos);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
		die();
	}


/*=============================================
	DESACTIVAR PRODUCTOS
=============================================*/	

	public $desactivarToken;
	public $estado;
	
	public function ajaxDesactiarProducto(){
		$tokenStock;

		if(($this->desactivarToken)!=""){
			$nombres = explode("/", $this->desactivarToken);
			$tokenStock=$nombres[1];
		
		}
		
		$datos = array( "estado" => $this->estado,
						"tokenStock" => $tokenStock);
	

		$respuesta = ControladorProductos::ctrDesactivarProducto($datos);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
		die();
	}


}
	

/*=============================================
LLAMAR A LA FUNCIÓN EDITAR PREFILES QUE ESTA FUERA DE CLASE
=============================================*/
if(isset($_POST["token_producto"]))
{

	$editar = new AjaxProductos();
	$editar -> token_producto = $_POST["token_producto"];
	$editar -> sucursal =$_POST["sucursal"];
	$editar -> activo = $_POST["activo"];
	$editar -> tipo_producto = $_POST["tipo_producto"];
	$editar -> ajaxEditarProducto();

}

/*=============================================
MOSTRAR IMAGENES DE PRODUCTOS
=============================================*/
if(isset($_POST["token"]))
{

	$imagenes = new AjaxProductos();
	$imagenes -> token = $_POST["token"];
	$imagenes -> ajaxMostrarImagenes();

}

/*=============================================
GUARDAR y EDITAR PERFIL
=============================================*/	

if(isset($_POST["txtDescripcion"])){

	$Guardar = new AjaxProductos();
	$Guardar -> txtcodProducto = $_POST["txtcodProducto"];
	$Guardar -> txtTokenProducto = $_POST["txtTokenProducto"];
	$Guardar -> txtDescripcion = $_POST["txtDescripcion"];
	$Guardar -> cmbCategoria = $_POST["cmbCategoria"];
	$Guardar -> cmbSubCategoria = $_POST["cmbSubCategoria"];
	$Guardar -> cmbMarca = $_POST["cmbMarca"];
	$Guardar -> txtcodigobarra = $_POST["txtcodigobarra"];
	$Guardar -> txtpreciocompra = $_POST["txtpreciocompra"];
	$Guardar -> txtprecioventa = $_POST["txtprecioventa"];
	$Guardar -> txtstock = $_POST["txtstock"];
	$Guardar -> cmbiva = $_POST["cmbiva"];
	$Guardar -> txtstockminimo = $_POST["txtstockminimo"];
	$Guardar -> txtdimension = $_POST["txtdimension"];
	$Guardar -> txtcantPaquete = $_POST["txtcantPaquete"];
	$Guardar -> cmbMedida = $_POST["cmbMedida"];
	$Guardar -> txtUbicacion = $_POST["txtUbicacion"];
	$Guardar -> txttipoProducto = $_POST["txttipoProducto"];
	$Guardar -> txtOferta = $_POST["txtOferta"];
	$Guardar -> chkoferta = $_POST["chkoferta"];
	$Guardar -> codSucursal = $_POST["sucursal"];
	$Guardar -> usuario = $_POST["usuario"];
	$Guardar -> cmbcanal = $_POST["cmbcanal"];
	$Guardar -> idstock = $_POST["idstock"];
	$Guardar -> combos = $_POST["txtproductos"];
	$Guardar -> insertar = $_POST["insertar"];
	$Guardar -> movimiento = $_POST["movimiento"];
	

	$Guardar -> ajaxGuardarProducto();

}

/*=============================================
Eliminar Producto
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxProductos();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> galeria = $_POST["galeria"];
	$eliminar -> token_stock = $_POST["token_stock"];
	$eliminar -> ajaxEliminarProducto();

}

/*=============================================
 validar que no se repita el nombre
=============================================*/	

if(isset($_POST["item"])){

	$validar = new AjaxProductos();
	$validar -> validarItem = $_POST["item"];
	$validar -> validarValor = $_POST["valor"];
	$validar -> validarValor1 = $_POST["valor1"];
	
	$validar -> ajaxValidar();

}

/*=============================================
 DESACTIVAR EL PRODUCTO
=============================================*/	

if(isset($_POST["desactivarToken"])){

	$desactivar = new AjaxProductos();
	$desactivar -> desactivarToken = $_POST["desactivarToken"];
	$desactivar -> estado = $_POST["estadoProducto"];
	$desactivar -> ajaxDesactiarProducto();

}

