<?php

require_once "../controladores/preventas.controlador.php";
require_once "../modelos/preventas.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxPreventas{

	public function ajaxCrearVentas(){

		$datos = array(	"txtUsuario"=>$this->txtUsuario,
						"txtidSucursal"=>$this->txtidSucursal,
						"cmbClientes"=> $this->cmbClientes,
						"txtproductos"=> $this->txtproductos,
						"txtFechaVenta" =>$this->txtFechaVenta,
						"tipomovimiento" =>$this->tipomovimiento);

			
					 // var_dump($datos);
				  // return;
				$guardar = ControladorPreVentas::ctrCrearVenta($datos);
				
				echo json_encode($guardar,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();

	}



public function ajaxMostrarDatos(){

		$item="EST_ARTICULOS";
		$valor=$this->activo;
			
		$nombres = explode("/",$this->sucursal);
		$TOKEN_SUCURSAL=$nombres[1];
		$CODIGO_SUCURSAL=$nombres[0];

		$item1="TIPO_PRODUCTO";
		$valor1=$this->tipo_producto;

		$item2="COD_SUCURSAL";
		$valor2=$CODIGO_SUCURSAL;


		$nombres = explode("/",$this->token_producto);
		
		$item3="TOKEN_PRODUCTO";
		$valor3=$nombres[1];

		$var=$this->simbolo;
        $respuesta = ControladorPreVentas::ctrMostrarProducto($item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3,$var);
        //echo '<pre>'; print_r($respuesta); echo '</pre>';
  	
        echo json_encode($respuesta);
   
      
		
}

public function ajaxBuscarCombos (){

   
    $combosnuevos = json_decode($this->combosProductos, true);

    $Subproductos="";
  					// echo '<pre>'; print_r($combosnuevos); echo '</pre>';

		if ($combosnuevos!="" && $combosnuevos!=null){
				  			
				  			//var_dump($galeria);
			foreach ($combosnuevos as $indice => $valor) {

				$nombres = explode("/",$valor["id"]);
				$cant=$valor["cantidad"];
								
				$codigoproducto=$nombres[0];

				$item="COD_PRODUCTO";
				$valor=$codigoproducto;

				$tabla="productos";
				$select="DESCRIPCION";
		
        		$combos = ControladorVentas::ctrMostrarCombos($tabla,$item, $valor,$select);

				$Subproductos.="<p class='dropdown-item'>".$combos["DESCRIPCION"].'- CANT.: '.$cant."</p>";
								//echo '<pre>'; print_r($Subproductos); echo '</pre>';

							
									}
						}


						echo $Subproductos;



        	
	
}

public function ajaxDatosSeleccion(){

		
		$item=null;
		$valor=null;

		$tabla="canti_uso";
		if($this->cantidad==1){
			$select="CUOTA";
		}elseif($this->cantidad==2){
			$select="CUOTA,DESCUENTO";
		}elseif($this->cantidad==3){
			$select="CUOTA,DESCUENTO,AVISO_STOCK";
		}elseif($this->cantidad==4){
			$select="CUOTA,DESCUENTO,AVISO_STOCK,CANT_USUARIOS";

		}else{
			$select="*";
		}
		$select="CUOTA,DESCUENTO,AVISO_STOCK";
		$where=null;
		
        $respuesta = ModeloVarios::mdlConsultarColumnas($tabla,$item, $valor,$select,$where);

		echo json_encode($respuesta);
}

public function ajaxClonarVenta(){

			$nombres = explode("/",$this->sucursal);
			$TOKEN_SUCURSAL=$nombres[1];

			$item="TOKEN_SUCURSAL";
			$valor=$TOKEN_SUCURSAL;

			$item1="TOKEN_PEDIDO";
			$valor1=$this->TokenPedidos;   
		 	$valor2 = $this->activo;
		 		
        $Venta = ControladorPreVentas::ctrBuscarVenta($item,$valor, $item1, $valor1,$valor2);

		echo json_encode($Venta);

      }

	

		public function ajaxAnularVenta(){

			$nombres = explode("/",$this->tokenSucursal);
			$CODIGO_SUCURSAL=$nombres[0];

			$usuarios = explode("/",$this->usuario);
			$usuario=$usuarios[0];

		
					$datos = array("token_pedido" => $this->token_venta,
							"estado"=>$this->estado,
							"usuario"=>$usuario,
							"descripcion"=> $this->descripcion,
							"codigoSucursal"=> $CODIGO_SUCURSAL);



				$respuesta = ControladorPreVentas::ctrAnularVenta($datos);
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();
			}



			
	/*=============================================
	MOSTRAR METODO DE PAGO
	=============================================*/	

	public function ajaxMostrarMetodoPago(){

		$item = null;
		$valor = null;

		$metodoPago = ControladorFormaPagos::ctrMostrarFormapago($item, $valor,"ESTADO_FORMA",1);

		echo json_encode($metodoPago);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}


	/*=============================================
	MOSTRAR VENTA CABECERA TICKET
	=============================================*/	

	public function ajaxMostrarCabeceraTicket(){

		$item = "COD_PEDIDO";
		$valor = $this->codVenta;

		// var_dump($valor);
		// return;

		$cabeceraTicket = ControladorPreVentas::ctrMostrarCabeceraTicket($item, $valor);

		echo json_encode($cabeceraTicket);//se imprime para que se pueda ver en el js

	}

	
}


/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_POST["txtUsuario"])){

	$Guardar = new AjaxPreventas();
	$Guardar -> txtUsuario = $_POST["txtUsuario"];
	$Guardar -> txtidSucursal = $_POST["txtidSucursal"];
	$Guardar -> txtproductos = $_POST["txtproductos"];
	$Guardar -> cmbClientes = $_POST["cmbClientes"];
	$Guardar -> txtFechaVenta = $_POST["txtFechaVenta"];
	$Guardar -> tipomovimiento = $_POST["tipomovimiento"];
	$Guardar -> ajaxCrearVentas();



}



/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_POST["TokenPedidos"])){

	$consultar = new AjaxPreventas();
	$consultar -> TokenPedidos = $_POST["TokenPedidos"];
	$consultar -> sucursal = $_POST["sucursal"];
	$consultar -> activo = $_POST["activo"];
	$consultar -> ajaxClonarVenta();


}


/*=============================================
LLAMAR A REMISION PARA ALMACENAR
=============================================*/	

if(isset($_POST["tokenVenta"])){

	$consultar = new AjaxPreventas();
	$consultar -> token_venta = $_POST["tokenVenta"];
	$consultar -> estado = $_POST["estado"];
	$consultar -> usuario = $_POST["usuario"];
	$consultar -> descripcion = $_POST["descripcion"];
	$consultar -> tokenSucursal = $_POST["tokenSucursal"];
	$consultar -> ajaxAnularVenta();


}

if(isset($_POST["token_producto"]))
{

	$editar = new AjaxPreventas();
	$editar -> token_producto = $_POST["token_producto"];
	$editar -> sucursal =$_POST["sucursal"];
	$editar -> activo = $_POST["activo"];
	$editar -> simbolo = $_POST["simbolo"];
	$editar -> tipo_producto = $_POST["tipo_producto"];
	$editar -> ajaxMostrarDatos();

}


/*================================================
	MOSTRAR METODO DE PAGO
==================================================*/
if(isset($_POST["item"])){

	$mostrar = new AjaxPreventas();
	$mostrar -> item = $_POST["item"];
	$mostrar -> ajaxMostrarMetodoPago();

}


/*================================================
	MOSTRAR METODO DE PAGO
==================================================*/
if(isset($_POST["cant"])){

	$mostrar = new AjaxPreventas();
	$mostrar -> cantidad = $_POST["cant"];
	$mostrar -> ajaxDatosSeleccion();

}

/*================================================
	MOSTRAR METODO DE PAGO
==================================================*/
if(isset($_POST["combosProductos"])){

	$mostrar = new AjaxPreventas();
	$mostrar -> combosProductos = $_POST["combosProductos"];
	$mostrar -> ajaxBuscarCombos();

}

/*================================================
	MOSTRAR VENTA CABECERA TICKET
==================================================*/
if(isset($_POST["txtCodVenta"])){

	$mostrar = new AjaxPreventas();
	$mostrar -> codVenta = $_POST["txtCodVenta"];
	$mostrar -> ajaxMostrarCabeceraTicket();

}