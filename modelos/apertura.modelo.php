<?php 

	require_once "conexion.php";

	class ModeloAperturas{
		
			/*============================================================
					MOSTRAR Apertura Y SUCURSAL CON INNER
 		==============================================================*/

		static public function MdlMostrarAperturasucursalCaja($tabla1,$tabla2,$tabla3, $item, $valor,$item1, $valor1, $item2, $valor2,$order,$var){

						
				if($valor!=null && $var!=null){

					if($valor1!=null){
						$stmt = Conexion::conectar()->prepare("SELECT c.*, s.SUCURSAL, s.TOKEN_SUCURSAL,a.* FROM $tabla1 as c INNER JOIN $tabla2 s ON c.COD_SUCURSAL = s.COD_SUCURSAL INNER JOIN $tabla3 as a ON a.COD_CAJA=c.COD_CAJA  WHERE c.COD_SUCURSAL=:$item2 AND a.$item=:$item AND c.EST_CAJA=1 AND a.$item1=:$item1 and ESTADO=1 ORDER BY a.$order");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);
				$stmt -> bindParam(":$item1",  $valor1, PDO::PARAM_STR);
				$stmt -> bindParam(":$item2",  $valor2, PDO::PARAM_STR);
				$stmt -> execute();
			
				return $stmt -> fetch();
					}else{
						$stmt = Conexion::conectar()->prepare("SELECT c.*, s.SUCURSAL, s.TOKEN_SUCURSAL,a.* FROM $tabla1 as c INNER JOIN $tabla2 s ON c.COD_SUCURSAL = s.COD_SUCURSAL INNER JOIN $tabla3 as a ON a.COD_CAJA=c.COD_CAJA  WHERE c.COD_SUCURSAL=:$item2 AND a.$item=:$item AND c.EST_CAJA=1 AND ESTADO=1 ORDER BY a.$order");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);
				$stmt -> bindParam(":$item2",  $valor2, PDO::PARAM_STR);
				$stmt -> execute();
			
				return $stmt -> fetch();
					}
					
				
				}elseif($valor!=null && $var==null){
					$stmt = Conexion::conectar()->prepare("SELECT c.*, s.SUCURSAL, s.TOKEN_SUCURSAL,a.* FROM $tabla1 as c INNER JOIN $tabla2 s ON c.COD_SUCURSAL = s.COD_SUCURSAL INNER JOIN $tabla3 as a ON a.COD_CAJA=c.COD_CAJA  WHERE c.COD_SUCURSAL=:$item2 AND a.$item1 =:$item1 AND a.$item=:$item AND c.EST_CAJA=1  and ESTADO=1 ORDER BY a.$order");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);
				$stmt -> bindParam(":$item1",  $valor1, PDO::PARAM_STR);
				$stmt -> bindParam(":$item2",  $valor2, PDO::PARAM_STR);
				

				$stmt -> execute();
					return $stmt -> fetchAll();
				}else{

				$stmt = Conexion::conectar()->prepare("SELECT c.*, s.SUCURSAL, s.TOKEN_SUCURSAL,a.* FROM $tabla1 as c INNER JOIN $tabla2 s ON c.COD_SUCURSAL = s.COD_SUCURSAL INNER JOIN $tabla3 as a ON a.COD_CAJA=c.COD_CAJA  WHERE c.$item1=$valor1 AND a.$item2=$valor2 AND c.EST_CAJA=1  and ESTADO=1 ORDER BY a.$order");
	           			
				// $stmt -> bindParam(":$item1",  $valor, PDO::PARAM_STR);
				// $stmt -> bindParam(":$item2",  $valor2, PDO::PARAM_STR);
			
				$stmt -> execute();
				return $stmt -> fetchAll();
				}
			
				
			
			}


			/*============================================================
					MOSTRAR Apertura Y SUCURSAL CON INNER
 		==============================================================*/

		static public function MdlMostrarAperturaDetalle($tabla1,$tabla2,$item, $valor,$order,$var){

						
				if($valor!=null && $var!=null){
					$stmt = Conexion::conectar()->prepare("SELECT $tabla1.*,$tabla2.* FROM $tabla1 INNER JOIN $tabla2 ON $tabla2.COD_APERTURA  = $tabla1.COD_APERTURA WHERE $tabla1.$item=:$item AND ESTADO=1 ORDER BY $tabla1.$order");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);
				$stmt -> execute();
				// echo '<pre>'; print_r($stmt); echo '</pre>';

				if( $var==1){
					return $stmt -> fetchall();
				}else{
					return $stmt -> fetch();
				}

				
				
				}elseif($valor!=null && $var==null){
					$stmt = Conexion::conectar()->prepare("SELECT SUM(MONTO_APERTURA) AS TOTAL FROM $tabla1 INNER JOIN $tabla2 ON $tabla2.COD_APERTURA  = $tabla1.COD_APERTURA WHERE $tabla1.$item=$valor AND ESTADO=1 AND EST_APERTURA ='APERTURA' ORDER BY $tabla1.$order");
	           			
				//$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);
				$stmt -> execute();
				
					return $stmt -> fetch();
				}else{

				$stmt = Conexion::conectar()->prepare("SELECT $tabla1.*,$tabla2.* FROM $tabla1 INNER JOIN $tabla2 ON $tabla2.COD_APERTURA  = $tabla1.COD_APERTURA WHERE ESTADO=1 ORDER BY $order");
				

				$stmt -> execute();
				
					return $stmt -> fetchAll();
				}
			
				
			
			}


					

		/*============================================================
					CREAR Aperturas
 		==============================================================*/
		static public function mdlIngresarApertura_cab($tabla, $datos){

				$connection = Conexion::conectar();
				$stmt = $connection->prepare("INSERT INTO $tabla(COD_CAJA,COD_USUARIO,FECHA_APERTURA, ESTADO_APERTURA,TOKEN_APERTURA)VALUES(:caja,:idUsuario,:fecha_apertura,:Estado,:token)");
				
				$stmt->bindParam(":caja",($datos["caja"]),PDO::PARAM_INT);
				$stmt->bindParam(":idUsuario",($datos["idUsuario"]),PDO::PARAM_INT);
				$stmt->bindParam(":fecha_apertura",($datos["fecha_apertura"]),PDO::PARAM_STR);
				$stmt->bindParam(":token",($datos["token"]),PDO::PARAM_STR);
				$stmt->bindParam(":Estado",($datos["Estado"]),PDO::PARAM_STR);
				
			 	// var_dump($stmt);

			   if ($stmt-> execute()){

					$id = $connection->lastInsertId();
					return $id;

			   }else{

			   		return "error";
			   }
				
			}



		static public function mdlIngresarAperturaDet($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(COD_APERTURA,HORA_APERTURA,MONTO_APERTURA,EST_APERTURA) VALUES (:codigo,:hora_apertura,:monto_apertura,:estado)");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":hora_apertura", $datos["hora_apertura"], PDO::PARAM_STR);
		$stmt->bindParam(":monto_apertura", $datos["monto_apertura"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}


		/*=============================================
					EDITAR cierre
		=============================================*/

		static public function mdlEditarCierre($tabla, $datos){

			// var_dump($datos);

			// return;

			$stmt=Conexion::conectar()->prepare("UPDATE $tabla SET FECHA_CIERRE=:fecha_hora,MONTO_CIERRE=:montoCierre,DIFERENCIA=:Diferencia,ESTADO_APERTURA=:estado,OBSERVACION=:Observaciones WHERE COD_APERTURA=:codigo");
				
				$stmt->bindParam(":fecha_hora",($datos["fecha_hora"]),PDO::PARAM_STR);
				$stmt->bindParam(":montoCierre",($datos["montoCierre"]),PDO::PARAM_STR);
				$stmt->bindParam(":Diferencia",($datos["Diferencia"]),PDO::PARAM_INT);
				$stmt->bindParam(":estado",$datos["estado"],PDO::PARAM_STR);
				$stmt->bindParam(":Observaciones",$datos["Observaciones"],PDO::PARAM_STR);
				$stmt->bindParam(":codigo",$datos["codigo"],PDO::PARAM_STR);
			

			if($stmt -> execute())
			{
				$detalleApertura = Conexion::conectar()->prepare("INSERT INTO aperturas_det(COD_APERTURA,HORA_APERTURA,MONTO_APERTURA,EST_APERTURA) VALUES (:codigo,:hora_apertura,:monto_apertura,:estado)");

						$detalleApertura->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
						$detalleApertura->bindParam(":hora_apertura", $datos["hora_apertura"], PDO::PARAM_STR);
						$detalleApertura->bindParam(":monto_apertura", $datos["monto_apertura"], PDO::PARAM_STR);
						$detalleApertura->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
						
						if($detalleApertura->execute()){

							return "ok";

						}else{

							return "error";
						
						}
			
			}else{

				return "error";	

			}

		
		}



		/*=============================================
					EDITAR Apertura
		=============================================*/

		static public function mdlEditarApertura($tabla, $datos){

			// var_dump($datos);

			// return;

			$stmt=Conexion::conectar()->prepare("UPDATE $tabla SET COD_SUCURSAL = :Sucursal, NROApertura = :NroApertura, NRO_FACTURA = :NroFactura, TIMBRADO = :Timbrado, FECHA_DESDE = :InicioVigencia, FECHA_HASTA = :FinVigencia, NOMBRE_EQUIPO = :txtEquipo, NRO_VERIFICADOR = :Verificador, NROTICKET = :Ticket, NRONOTACREDITO = :NC, EST_Apertura = :Estado WHERE TOKEN_Apertura = :token");
				
				$stmt->bindParam(":Sucursal",($datos["Sucursal"]),PDO::PARAM_INT);
				$stmt->bindParam(":NroApertura",($datos["NroApertura"]),PDO::PARAM_STR);
				$stmt->bindParam(":NroFactura",($datos["NroFactura"]),PDO::PARAM_INT);
				$stmt->bindParam(":Timbrado",$datos["Timbrado"],PDO::PARAM_STR);
				$stmt->bindParam(":InicioVigencia",$datos["InicioVigencia"],PDO::PARAM_STR);
				$stmt->bindParam(":FinVigencia",$datos["FinVigencia"],PDO::PARAM_STR);
				$stmt->bindParam(":txtEquipo",$datos["txtEquipo"],PDO::PARAM_STR);
				$stmt->bindParam(":Verificador",$datos["Verificador"],PDO::PARAM_STR);
				$stmt->bindParam(":Ticket",$datos["Ticket"],PDO::PARAM_INT);
				$stmt->bindParam(":NC",$datos["NC"],PDO::PARAM_INT);
				$stmt->bindParam(":Estado",$datos["Estado"],PDO::PARAM_INT);
			    $stmt->bindParam(":token",$datos["token"],PDO::PARAM_STR);


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


		static public function mdlGastosApertura($select, $item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3){

			$stmt = Conexion::conectar()->prepare("SELECT $select FROM gastos g INNER JOIN aperturas_cab ac ON g.COD_APERTURA=ac.COD_APERTURA WHERE ac.$item=:item  AND $item1=:item1 AND $item2=:item2 AND $item3=:item3");
			$stmt -> bindParam(":item", $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":item1", $valor1, PDO::PARAM_STR);
			$stmt -> bindParam(":item2", $valor2, PDO::PARAM_STR);
			$stmt -> bindParam(":item3", $valor3, PDO::PARAM_STR);
			$stmt -> execute();		
			
			return $stmt -> fetchAll();
		}





	}
