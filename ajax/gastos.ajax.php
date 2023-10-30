<?php

require_once "../controladores/gastos.controlador.php";
require_once "../modelos/gastos.modelo.php";
require_once "../modelos/actualizarVarios.modelo.php";

class AjaxGastos{

	/*=============================================
	Guardar Gastos
	=============================================*/	

	public function ajaxGuardarGasto(){

		$nombres = explode("/", $this->cod_gastos);
		$COD_Gasto=$nombres[0];


		if($this->cod_gastos==null){
			// GUARDAR
	
			$datos = array("tipofactura" => $this->tipofactura,
							"nrofactura" => $this->nrofactura,
							"txtruc" => $this->txtruc,
							"txtempresa" => $this->txtempresa,
							"txtnuevoDescripcion" => $this->txtnuevoDescripcion,
							"txtNuevaCategoria" => $this->txtNuevaCategoria,
							"txtmontoGastos" =>$this->txtmontoGastos,
							"cmbextraccion" => $this->cmbextraccion,
							"txtusuario" => $this->txtusuario,
							"txtsucursal" => $this->txtsucursal,
							"txtapertura" => $this->txtapertura,
							"txtfecha" => $this->txtfecha,
							"cmbIva" => $this->cmbIva,
							"metodopago" => $this->metodopago);
			
			// var_dump($datos);
			// return;

			$respuesta = ControladorGastos::ctrGuardarGastos($datos);
				
			echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

			die();


		}else{


			// EDITAR

			$datos = array("cod_gastos" => $COD_Gasto,
							"tipofactura" => $this->tipofactura,
							"nrofactura" => $this->nrofactura,
							"txtruc" => $this->txtruc,
							"txtempresa" => $this->txtempresa,
							"txtnuevoDescripcion" => $this->txtnuevoDescripcion,
							"txtNuevaCategoria" => $this->txtNuevaCategoria,
							"txtmontoGastos" =>$this->txtmontoGastos,
							"cmbextraccion" => $this->cmbextraccion,
							"txtfecha" => $this->txtfecha,
							"cmbIva" => $this->cmbIva,
							"metodopago" => $this->metodopago);
			
			
			$respuesta = ControladorGastos::ctrEditarGastos($datos);
				
			echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

			die();
		}


	}


	/*=============================================
	EDITAR Gastos
	=============================================*/	

	public function ajaxVerGastos(){

		$nombres = explode("/", $this->token_gastos);
		$CodGastos=$nombres[0];

		$item = "COD_GASTO";
		$valor = $CodGastos;
		
		$tabla="gastos";
        $columna="*";
        $order="EMPRESA ASC";
        $where="WHERE ";

		  $consultar= ControladorGastos::ctrMostrarCategoria($tabla,$columna,$where,$item,$valor,$order);

		header('Content-type:application/json;charset=utf-8');

		echo json_encode($consultar, JSON_PRETTY_PRINT);
		

	}


	/*=============================================
	CONSULTAR RUC GASTOS
	=============================================*/	

	public function ajaxConsultarRuc(){

		$tabla="gastos";
        $columna="DISTINCT(EMPRESA) EMPRESA";
        $order="EMPRESA ASC";
        $item="RUC";
        $valor=$this->ruc;
        $where="WHERE ";
                        
        $consultar= ControladorGastos::ctrMostrarCategoria($tabla,$columna,$where,$item,$valor,$order);

		header('Content-type:application/json;charset=utf-8');

		echo json_encode($consultar, JSON_PRETTY_PRINT);
		

	}






	/*=============================================
	Eliminar Gasto
	=============================================*/	

	public function ajaxEliminarGastos(){

		$nombres = explode("/", $this->idEliminar);
		$codigoGastos=$nombres[0];

		if( $this->estado==1){
			$estado=0;
		}else{
			$estado=1;
		}

		$item = "ESTADO_GASTOS";
		$valor = $estado;
		$item1 = "COD_GASTO";
		$valor1 = $codigoGastos;
		//var_dump($valor1);
		$respuesta = ControladorGastos::ctrBorrarGasto($item,$valor,$item1,$valor1);

		echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

		die();
	}

	

}



/*=============================================
	GUARDAR
=============================================*/	

if(isset($_POST["tipofactura"])){

	$Guardar = new AjaxGastos();
	$Guardar -> cod_gastos = $_POST["cod_gastos"];
	$Guardar -> tipofactura = $_POST["tipofactura"];
	$Guardar -> nrofactura = $_POST["nrofactura"];
	$Guardar -> txtruc = $_POST["txtruc"];
	$Guardar -> txtempresa = $_POST["txtempresa"];
	$Guardar -> txtnuevoDescripcion = $_POST["txtnuevoDescripcion"];
	$Guardar -> txtNuevaCategoria = $_POST["txtNuevaCategoria"];
	$Guardar -> txtmontoGastos = $_POST["txtmontoGastos"];
	$Guardar -> cmbextraccion = $_POST["cmbextraccion"];
	$Guardar -> txtusuario = $_POST["txtusuario"];
	$Guardar -> txtsucursal = $_POST["txtsucursal"];
	$Guardar -> txtapertura = $_POST["txtapertura"];
	$Guardar -> txtfecha = $_POST["txtfecha"];
	$Guardar -> cmbIva = $_POST["cmbIva"];
	$Guardar -> metodopago = $_POST["metodopago"];
	
	$Guardar -> ajaxGuardarGasto();

}

/*================================================
	EDITAR/MOSTRAR Gasto
==================================================*/
if(isset($_POST["token_gastos"])){

	$ver = new AjaxGastos();
	$ver -> token_gastos = $_POST["token_gastos"];
	$ver -> ajaxVerGastos();

}

/*=============================================
	Eliminar Apertura
=============================================*/	

if(isset($_POST["idEliminar"])){

	// var_dump($_POST["idEliminar"]);

	$eliminar = new AjaxGastos();
	$eliminar -> idEliminar = $_POST["idEliminar"];
		$eliminar -> estado = $_POST["estado"];
	$eliminar -> ajaxEliminarGastos();

}

/*=============================================
	CONSULTAR DATOS
=============================================*/	

if(isset($_POST["ruc"])){

	
	$consultarRuc = new AjaxGastos();
	$consultarRuc -> ruc = $_POST["ruc"];
	$consultarRuc -> ajaxConsultarRuc();

}



