<?php 

	require_once "conexion.php";

	class ModeloGastos{
		
			/*============================================================
					MOSTRAR CATEGORIA
 		==============================================================*/

		static public function MdlMostrarCategoria($tabla,$columna,$where,$item,$valor,$order){

			if($where==null){
				$stmt = Conexion::conectar()->prepare("SELECT $columna FROM $tabla ORDER BY $order");
				$stmt -> execute();			
				return $stmt -> fetchAll();
					
				
			}else{

				$stmt = Conexion::conectar()->prepare("SELECT $columna FROM $tabla $where $item = :$item ORDER BY $order");
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);
				$stmt -> execute();			
				return $stmt -> fetch();
					
			}
			
			
				
			
			}


			/*============================================================
					MOSTRAR Apertura Y SUCURSAL CON INNER
 		==============================================================*/

		static public function MdlMostrarGastosSucursal($item, $valor,$item1, $valor1,$item2, $valor2,$order){

						
				if($valor==null){

					$stmt = Conexion::conectar()->prepare("SELECT COD_GASTO, FORMAPAGO,gastos.FECHA,TOTAL,VER_CAJA, NROFACTURA,TIPO_GASTO, IVA, gastos.RUC,gastos.EMPRESA,CATEGORIA,DESCRIPCION,TOKEN_GASTOS,USUARIO,SUCURSAL,NROCAJA,gastos.	COD_APERTURA,	ESTADO_GASTOS FROM gastos INNER JOIN usuarios ON usuarios.COD_USUARIO=gastos.COD_USUARIO INNER JOIN sucursales ON sucursales.COD_SUCURSAL=gastos.COD_SUCURSAL INNER JOIN aperturas_cab ON aperturas_cab.COD_APERTURA= gastos.COD_APERTURA INNER JOIN cajas ON cajas.COD_CAJA=aperturas_cab.COD_CAJA WHERE gastos.COD_APERTURA=:$item1 AND ESTADO_GASTOS=:$item2 ORDER BY gastos.$order");
			           			
						$stmt -> bindParam(":$item1",  $valor1, PDO::PARAM_STR);
						$stmt -> bindParam(":$item2",  $valor2, PDO::PARAM_STR);
						
						$stmt -> execute();
					
						return $stmt -> fetchAll();

					}else{
						
						$stmt = Conexion::conectar()->prepare("SELECT COD_GASTO, FORMAPAGO,gastos.FECHA,TOTAL,VER_CAJA, NROFACTURA,TIPO_GASTO, IVA, gastos.RUC,gastos.EMPRESA,CATEGORIA,DESCRIPCION,TOKEN_GASTOS,USUARIO,SUCURSAL,NROCAJA,gastos.	COD_APERTURA,	ESTADO_GASTOS FROM gastos INNER JOIN usuarios ON usuarios.COD_USUARIO=gastos.COD_USUARIO INNER JOIN sucursales ON sucursales.COD_SUCURSAL=gastos.COD_SUCURSAL INNER JOIN aperturas_cab ON aperturas_cab.COD_APERTURA= gastos.COD_APERTURA INNER JOIN cajas ON cajas.COD_CAJA=aperturas_cab.COD_CAJA WHERE gastos.COD_APERTURA=:$item1 AND ESTADO_GASTOS=:$item2 ORDER BY gastos.$order");
			           			
						$stmt -> bindParam(":$item1",  $valor1, PDO::PARAM_STR);
						$stmt -> bindParam(":$item2",  $valor2, PDO::PARAM_STR);
						
						
						$stmt -> execute();
					
						return $stmt -> fetch();
					}
	
			
			}


		// INSERTAR GASTOS VARIOS
		static public function mdlIngresarGastos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(COD_APERTURA,COD_SUCURSAL,COD_USUARIO,FORMAPAGO,FECHA,TOTAL,VER_CAJA,NROFACTURA,TIPO_GASTO,IVA,RUC,EMPRESA,CATEGORIA,DESCRIPCION,TOKEN_GASTOS) VALUES (:txtapertura,:txtsucursal,:txtusuario,:metodopago,:txtfecha,:txtmontoGastos,:cmbextraccion,:nrofactura,:tipofactura,:cmbIva,:txtruc,:txtempresa,:txtNuevaCategoria,:txtnuevoDescripcion,:token)");

		$stmt->bindParam(":txtapertura", $datos["txtapertura"], PDO::PARAM_STR);
		$stmt->bindParam(":txtsucursal", $datos["txtsucursal"], PDO::PARAM_STR);
		$stmt->bindParam(":txtusuario", $datos["txtusuario"], PDO::PARAM_STR);
		$stmt->bindParam(":metodopago", $datos["metodopago"], PDO::PARAM_STR);

		$stmt->bindParam(":txtfecha", $datos["txtfecha"], PDO::PARAM_STR);
		$stmt->bindParam(":txtmontoGastos", $datos["txtmontoGastos"], PDO::PARAM_STR);
		$stmt->bindParam(":cmbextraccion", $datos["cmbextraccion"], PDO::PARAM_STR);
		$stmt->bindParam(":nrofactura", $datos["nrofactura"], PDO::PARAM_STR);
		$stmt->bindParam(":tipofactura", $datos["tipofactura"], PDO::PARAM_STR);

		$stmt->bindParam(":cmbIva", $datos["cmbIva"], PDO::PARAM_STR);
		$stmt->bindParam(":txtruc", $datos["txtruc"], PDO::PARAM_STR);
		$stmt->bindParam(":txtempresa", $datos["txtempresa"], PDO::PARAM_STR);
		$stmt->bindParam(":txtNuevaCategoria", $datos["txtNuevaCategoria"], PDO::PARAM_STR);

		$stmt->bindParam(":txtnuevoDescripcion", $datos["txtnuevoDescripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":token", $datos["token"], PDO::PARAM_STR);
		
				
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}



		/*=============================================
					EDITAR Apertura
		=============================================*/

		static public function mdlEditarGastos($tabla, $datos){

			// var_dump($datos);

			// return;

			$stmt=Conexion::conectar()->prepare("UPDATE $tabla SET FORMAPAGO=:metodopago,FECHA=:txtfecha,TOTAL=:txtmontoGastos,VER_CAJA=:cmbextraccion,NROFACTURA=:nrofactura,TIPO_GASTO=:tipofactura,IVA=:cmbIva,RUC=:txtruc,EMPRESA=:txtempresa,CATEGORIA=:txtNuevaCategoria,DESCRIPCION=:txtnuevoDescripcion WHERE COD_GASTO=:cod_gastos");
				
		
			$stmt->bindParam(":metodopago", $datos["metodopago"], PDO::PARAM_STR);

			$stmt->bindParam(":txtfecha", $datos["txtfecha"], PDO::PARAM_STR);
			$stmt->bindParam(":txtmontoGastos", $datos["txtmontoGastos"], PDO::PARAM_STR);
			$stmt->bindParam(":cmbextraccion", $datos["cmbextraccion"], PDO::PARAM_STR);
			$stmt->bindParam(":nrofactura", $datos["nrofactura"], PDO::PARAM_STR);
			$stmt->bindParam(":tipofactura", $datos["tipofactura"], PDO::PARAM_STR);

			$stmt->bindParam(":cmbIva", $datos["cmbIva"], PDO::PARAM_STR);
			$stmt->bindParam(":txtruc", $datos["txtruc"], PDO::PARAM_STR);
			$stmt->bindParam(":txtempresa", $datos["txtempresa"], PDO::PARAM_STR);
			$stmt->bindParam(":txtNuevaCategoria", $datos["txtNuevaCategoria"], PDO::PARAM_STR);

			$stmt->bindParam(":txtnuevoDescripcion", $datos["txtnuevoDescripcion"], PDO::PARAM_STR);
			$stmt->bindParam(":cod_gastos", $datos["cod_gastos"], PDO::PARAM_STR);


			if($stmt -> execute())
			{
				return "ok";
			
			}else
			{

				return "error";	

			}

			$stmt -> close();

			$stmt = null;

		}



		/*=============================================
					ELIMINAR Apertura
		=============================================*/

		static public function mdlEliminarApertura($tabla, $item, $valor){

			$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :valor");
			$stmt -> bindParam(":valor", $valor, PDO::PARAM_STR);
			$stmt -> execute();

			if($stmt -> execute()){

				return "ok";
								
			}else{
								
				"\nPDO::errorInfo():\n";
				return ($stmt->errorInfo());
			}

		}




		/*=============================================
					CONSULTAR VENTAS POR APERTURA DEL LOCAL
		=============================================*/

		static public function mdlVentasApertura($tabla,$tabla1,$select, $item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3){

			$stmt = Conexion::conectar()->prepare("SELECT $select FROM $tabla INNER JOIN $tabla1 ON $tabla.$item=$tabla1.$item WHERE $tabla1.$item=:item  AND $item1=:item1 AND $item2=:item2 AND $item3=:item3");
			$stmt -> bindParam(":item", $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":item1", $valor1, PDO::PARAM_STR);
			$stmt -> bindParam(":item2", $valor2, PDO::PARAM_STR);
			$stmt -> bindParam(":item3", $valor3, PDO::PARAM_STR);
			$stmt -> execute();
				
			return $stmt -> fetchAll();
		}


		static public function mdlCobrosApertura($select, $item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3){

			$stmt = Conexion::conectar()->prepare("SELECT $select FROM ventas INNER JOIN ctascobrar ON ventas.COD_FACTURA=ctascobrar.COD_FACTURA INNER JOIN detctascobrar ON ctascobrar.COD_CUENTA=detctascobrar.COD_CUENTA INNER JOIN aperturas_cab ON detctascobrar.COD_APERTURA=aperturas_cab.COD_APERTURA WHERE aperturas_cab.$item=:item  AND $item1=:item1 AND $item2=:item2 AND $item3=:item3");
			$stmt -> bindParam(":item", $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":item1", $valor1, PDO::PARAM_STR);
			$stmt -> bindParam(":item2", $valor2, PDO::PARAM_STR);
			$stmt -> bindParam(":item3", $valor3, PDO::PARAM_STR);
			$stmt -> execute();		
			return $stmt -> fetchAll();
		}





	}
