<?php 

require_once "conexion.php";


class ModeloCuentasCobrar{


	/*============================================================
		MOSTRAR DATOS DE LA TABLA CUENTAS A COBRAR
 	==============================================================*/

	static public function MdlMostrarCuentaCobrarInner($item1, $valor1, $item2, $valor2, $item3, $valor3, $tabla1, $tabla2, $order){

		// var_dump($item1);
		// var_dump($valor1);
		// var_dump($item2);
		// var_dump($valor2);
		// var_dump($tabla1);
		// var_dump($tabla2);
		// var_dump($order);

		if($item1 != null){

			$stmt = Conexion::conectar()->prepare("SELECT cc.COD_CUENTA, v.NRO_MOVIMIENTO, v.TIPO_MOVIMIENTO, cc.TOKEN_CTASCOBRAR, cc.COD_FACTURA, cc.FECHA_VENC_PROXIMO, v.FECHA_VENTA, cc.CANT_CUOTA, cc.MONTO_CUOTA, cc.TOTAL_CUENTA, dcc.PAGO, (((SUM(dcc.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, (((SUM(dcc.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA_DECIMAL, SUM(dcc.PAGO) AS MONTO_PAGADO, ((cc.TOTAL_CUENTA - SUM(dcc.PAGO))) AS SALDO, FECHA_VENC, FECHA_PAGO FROM ctascobrar AS cc INNER JOIN ventas AS v ON cc.COD_FACTURA = v.COD_FACTURA LEFT JOIN detctascobrar dcc ON cc.COD_CUENTA = dcc.COD_CUENTA WHERE COD_SUCURSAL = :$item1 AND COD_CLIENTE = :$item2 AND cc.ESTADO_CUENTA = :$item3 GROUP BY COD_CUENTA ORDER BY $order");

			// $stmt = Conexion::conectar()->prepare("SELECT cc.COD_CUENTA, v.NRO_MOVIMIENTO, v.TIPO_MOVIMIENTO, cc.TOKEN_CTASCOBRAR, cc.COD_FACTURA, cc.FECHA_VENC_PROXIMO, v.FECHA_VENTA, cc.CANT_CUOTA, cc.MONTO_CUOTA, cc.TOTAL_CUENTA FROM $tabla1 AS cc INNER JOIN $tabla2 AS v ON cc.COD_FACTURA = v.COD_FACTURA WHERE $item1 = :$item1 AND $item2 = :$item2 AND $item3 = :$item3 ORDER BY $order");
	           			
			$stmt -> bindParam(":$item1",  $valor1, PDO::PARAM_STR);
			$stmt -> bindParam(":$item2",  $valor2, PDO::PARAM_STR);
			$stmt -> bindParam(":$item3",  $valor3, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;
	 		
	}

	/*============================================================
		MOSTRAR DATOS DE LA TABLA CUENTAS A COBRAR
 	==============================================================*/

	static public function mdlMostrarClienteCuentaCobrar($item, $valor, $where){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT c.COD_CLIENTE, c.TOKEN_CLIENTE, c.RUC, c.CLIENTE, c.CELULAR, cc.TOTAL_CUENTA, cc.OBSERVACIONES FROM clientes AS c INNER JOIN ventas AS v ON c.COD_CLIENTE = v.COD_CLIENTE INNER JOIN ctascobrar AS cc ON v.COD_FACTURA = cc.COD_FACTURA $where");

			// $stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM clientes");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt = null;

	 		
	}

	/*============================================================
		MOSTRAR DATOS DE CUENTAS A COBRAR PARA EL LISTADO PRINCIPAL
 	==============================================================*/

	static public function mdlMostrarCuentasCobrarListado($valor1, $valor2, $item3, $valor3, $valor4, $item5, $valor5){

		date_default_timezone_set("America/Asuncion");

		// var_dump($valor1);
		// var_dump($valor2);
		// var_dump($valor3);
		// var_dump($valor4);
		// var_dump($valor5);

		if($valor5 == 0){

			if($valor1 != 0){;

				$fechaini=$valor1.' '.'00:00:00';
				$fechafi= $valor2.' '.'23:59:59';	

			}else{

				$fechaini=date('Y-m-d').' '.'00:00:00';
				$fechafi=date('Y-m-d').' '.'23:59:59';
				
			}

			$stmt = Conexion::conectar()->prepare("SELECT v.NRO_MOVIMIENTO, v.TIPO_MOVIMIENTO, c.COD_CLIENTE, c.COD_CLIENTE, c.TOKEN_CLIENTE, c.CLIENTE, c.RUC, v.FECHA_VENTA, cc.FECHA_VENC_PROXIMO, cc.COD_CUENTA, cc.TOTAL_CUENTA, cc.MONTO_CUOTA, cc.CANT_CUOTA, cc.TIPO_VENTA, cc.ESTADO_CUENTA, cc.TOKEN_CTASCOBRAR, dcc.PAGO, (((SUM(dcc.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, SUM(dcc.PAGO) AS MONTO_PAGADO FROM clientes AS c INNER JOIN ventas AS v ON c.COD_CLIENTE = v.COD_CLIENTE INNER JOIN ctascobrar AS cc ON v.COD_FACTURA = cc.COD_FACTURA LEFT JOIN detctascobrar AS dcc ON cc.COD_CUENTA = dcc.COD_CUENTA WHERE cc.FECHA BETWEEN '$fechaini' AND '$fechafi' AND cc.ESTADO_CUENTA = '$valor4' AND v.COD_SUCURSAL = :$item3 GROUP BY cc.COD_CUENTA;");

			$stmt -> bindParam(":$item3",  $valor3, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

			if($valor1 != 0){;

				$fechaini=$valor1.' '.'00:00:00';
				$fechafi= $valor2.' '.'23:59:59';

				$stmt = Conexion::conectar()->prepare("SELECT v.NRO_MOVIMIENTO, v.TIPO_MOVIMIENTO, c.COD_CLIENTE, c.COD_CLIENTE, c.TOKEN_CLIENTE, c.CLIENTE, c.RUC, v.FECHA_VENTA, cc.FECHA_VENC_PROXIMO, cc.COD_CUENTA, cc.TOTAL_CUENTA, cc.MONTO_CUOTA, cc.CANT_CUOTA, cc.TIPO_VENTA, cc.ESTADO_CUENTA, cc.TOKEN_CTASCOBRAR, dcc.PAGO, (((SUM(dcc.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, SUM(dcc.PAGO) AS MONTO_PAGADO FROM clientes AS c INNER JOIN ventas AS v ON c.COD_CLIENTE = v.COD_CLIENTE INNER JOIN ctascobrar AS cc ON v.COD_FACTURA = cc.COD_FACTURA LEFT JOIN detctascobrar AS dcc ON cc.COD_CUENTA = dcc.COD_CUENTA WHERE cc.FECHA BETWEEN '$fechaini' AND '$fechafi' AND cc.ESTADO_CUENTA = '$valor4' AND v.COD_SUCURSAL = :$item3 AND c.COD_CLIENTE = :$item5 GROUP BY cc.COD_CUENTA;");

		 		$stmt -> bindParam(":$item3",  $valor3, PDO::PARAM_STR);
				$stmt -> bindParam(":$item5",  $valor5, PDO::PARAM_STR);

				$stmt -> execute();
					
				return $stmt -> fetchAll();	

			}else{

			 	$fechaini=date('Y-m-d').' '.'00:00:00';
				$fechafi=date('Y-m-d').' '.'23:59:59';

				// var_dump($item3);
				// var_dump($item5);
				// var_dump($valor4);

				$stmt = Conexion::conectar()->prepare("SELECT v.NRO_MOVIMIENTO, v.TIPO_MOVIMIENTO, c.COD_CLIENTE, c.COD_CLIENTE, c.TOKEN_CLIENTE, c.CLIENTE, c.RUC, v.FECHA_VENTA, cc.FECHA_VENC_PROXIMO, cc.COD_CUENTA, cc.TOTAL_CUENTA, cc.MONTO_CUOTA, cc.CANT_CUOTA, cc.TIPO_VENTA, cc.ESTADO_CUENTA, cc.TOKEN_CTASCOBRAR, dcc.PAGO, (((SUM(dcc.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, SUM(dcc.PAGO) AS MONTO_PAGADO FROM clientes AS c INNER JOIN ventas AS v ON c.COD_CLIENTE = v.COD_CLIENTE INNER JOIN ctascobrar AS cc ON v.COD_FACTURA = cc.COD_FACTURA LEFT JOIN detctascobrar AS dcc ON cc.COD_CUENTA = dcc.COD_CUENTA WHERE cc.ESTADO_CUENTA = '$valor4' AND v.COD_SUCURSAL = :$item3 AND c.COD_CLIENTE = :$item5 GROUP BY cc.COD_CUENTA;");

		 		$stmt -> bindParam(":$item3",  $valor3, PDO::PARAM_STR);
				$stmt -> bindParam(":$item5",  $valor5, PDO::PARAM_STR);

				$stmt -> execute();
					
				return $stmt -> fetchAll();
				
			}

	 	}

	 	$stmt-> close();
		$stmt = null;

	 		
	}

	/*============================================================
		MOSTRAR CANTIDAD DE COBROS DE CUENTAS
 	==============================================================*/

	static public function mdlMostrarCantPagoCuenta($tabla, $item, $valor, $order){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT TOTAL_CUENTA, CANT_CUOTA, PAGO, FLOOR(((SUM(dcc.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, SUM(dcc.PAGO) AS MONTO_PAGADO FROM ctascobrar cc INNER JOIN detctascobrar dcc ON cc.COD_CUENTA = dcc.COD_CUENTA WHERE $item = $valor ORDER BY $order");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;
	}

	/*============================================================
		MOSTRAR CUENTAS A COBRAR
 	==============================================================*/

	static public function mdlMostrarCuentasCobrar($tabla, $item, $valor, $order){

		// var_dump($tabla);
		// var_dump($item);
		// var_dump($valor);
		// var_dump($order);

		if($item != null){

			// $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
			$stmt = Conexion::conectar()->prepare("SELECT cc.CANT_CUOTA, cc.FECHA_VENC_PROXIMO, cc.TIPO_VENTA, cc.MONTO_CUOTA, cc.TOTAL_CUENTA, dcc.PAGO, dcc.SALDO, FLOOR(((SUM(dcc.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, (((SUM(dcc.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA_DECIMAL, SUM(dcc.PAGO) AS MONTO_PAGADO, ((cc.TOTAL_CUENTA - SUM(dcc.PAGO))) AS SALDO FROM ctascobrar AS cc INNER JOIN detctascobrar AS dcc ON cc.COD_CUENTA=dcc.COD_CUENTA WHERE cc.COD_CUENTA = :$item");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetch();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}



	static public function mdlMostrarCuentasCobrarProductos($item, $valor, $order){

	
		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT PRECIO_UNI,PRECIO_NETO,CANTIDAD,STOCK_ANTERIOR,DESCUENTO,DESCRIPCION,CODBARRA FROM ventas v INNER JOIN detventas dt ON v.COD_FACTURA=dt.COD_FACTURA INNER JOIN clientes c ON c.COD_CLIENTE =v.COD_CLIENTE  INNER JOIN productos pro ON pro.COD_PRODUCTO=dt.COD_PRODUCTO INNER JOIN ctascobrar ct ON ct.COD_FACTURA=v.COD_FACTURA WHERE $item = :$item ORDER BY $order ");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
			
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}

	/*============================================================
		MOSTRAR DETALLES DE CUENTAS A COBRAR
 	==============================================================*/

	static public function mdlMostrarDetCuentasCobrar($tabla, $item, $valor, $order){

		// var_dump($tabla);
		// var_dump($item);
		// var_dump($valor);
		// var_dump($order);

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT TOTAL_CUENTA, CANT_CUOTA, MONTO_CUOTA, PAGO, FLOOR(((SUM(dcC.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, (((SUM(dcc.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA_DECIMAL, SUM(dcc.PAGO) AS MONTO_PAGADO, ((cc.TOTAL_CUENTA - SUM(dcc.PAGO))) AS SALDO, FECHA_VENC, FECHA_PAGO FROM ctascobrar cc INNER JOIN detctascobrar dcc ON cc.COD_CUENTA = dcc.COD_CUENTA WHERE $item = $valor ORDER BY $order");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}

	/*============================================================
		MOSTRAR DIFERENCIA FECHA
 	==============================================================*/

	static public function mdlMostrarDiferenciaFecha($item, $valor, $where, $order){

		// var_dump($item);
		// var_dump($valor);
		// var_dump($order);
		// var_dump($where);

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT c.CLIENTE, c.RUC, c.CELULAR, cc.TOTAL_CUENTA, cc.OBSERVACIONES, dcc.FECHA_VENC, dcc.FECHA_PAGO, dcc.DET_MOVIMIENTO FROM clientes AS c INNER JOIN ventas AS v ON c.COD_CLIENTE = v.COD_CLIENTE INNER JOIN ctascobrar AS cc  ON v.COD_FACTURA = cc.COD_FACTURA LEFT JOIN detctascobrar AS dcc ON cc.COD_CUENTA = dcc.COD_CUENTA $where");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}


	/*============================================================
		MOSTRAR NUMERO DE RECIBO
 	==============================================================*/

	// static public function mdlMostrarNroRecibo($tabla, $item, $valor, $order){

	// 	if($item != null){

	// 		$stmt = Conexion::conectar()->prepare("SELECT MAX(NRO_RECIBO) AS NRO_RECIBO FROM $tabla WHERE $item = :$item;");
	           			
	// 		$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

	// 		$stmt -> execute();
				
	// 		return $stmt -> fetchAll();

	// 	}else{

	//  		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	//  		$stmt->execute();

	//  		return $stmt-> fetchAll();
	//  	}

	//  	$stmt-> close();
	// 	$stmt= null;
	// }

	/*============================================================
		MOSTRAR DETALLES DE CUENTAS A COBRAR
 	==============================================================*/

	static public function mdlMostrarDetCuentasCobrar1($tabla, $item, $valor, $order){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetch();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}

	/*============================================================
		GUARDAR COBRO
 	==============================================================*/
	static public function mdlGuardarCobro($tabla, $dato){

		// var_dump(json_decode($dato["pago"]), true);
		// return;

		$array = array();
		$array1 = array();

		$listaCuenta = json_decode($dato["pago"], true);

		foreach ($listaCuenta as $key => $datos) {

			/*=======================================================================
			CONSULTAMOS LA FECHA DE VECIMIENTO PARA AUMENTARLE SEGUN EL TIPO DE VENTA
	 		========================================================================*/
			$consultarVenc = Conexion::conectar()->prepare("SELECT * FROM ctascobrar WHERE COD_CUENTA = :codCuenta");
			$consultarVenc->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);
			$consultarVenc -> execute();
			$fechaVenc = $consultarVenc -> fetch(PDO::FETCH_ASSOC);

			// var_dump($fechaVenc["TOTAL_CUENTA"]);
			// var_dump($fechaVenc["FECHA_VENCIMIENTO"]);
			// return;

			$totalCuenta = intval($fechaVenc["TOTAL_CUENTA"]);
			$fecha = new DateTime($fechaVenc["FECHA_VENCIMIENTO"]);
			$fechaAdd;

			/*=======================================================================
			CONSULTAMOS EL TOTAL PAGADO DE LA CUENTA PARA CALCULAR SALDO
	 		========================================================================*/
			$consultarSaldo = Conexion::conectar()->prepare("SELECT SUM(pago) AS PAGO_TOTAL FROM detctascobrar WHERE COD_CUENTA = :codCuenta");	
			$consultarSaldo->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);
			$consultarSaldo -> execute();
			$saldoConsultado = $consultarSaldo -> fetch(PDO::FETCH_ASSOC);
			$saldo = intval($saldoConsultado["PAGO_TOTAL"]);
			$saldoFinal;
			$estadoCuenta = "CREDITO";


			// var_dump($saldo);
			// var_dump(intval($datos["pago"]));
			// return;

			if($datos["tipoRecibo"] == "AUTOMATICO"){

				/*=======================================================================
				CONSULTAMOS EL NUMERO DE RECIBO
		 		========================================================================*/
				$consultarRecibo = Conexion::conectar()->prepare("SELECT MAX(NRO_RECIBO) AS NRO_RECIBO FROM detctascobrar WHERE TIPO_RECIBO = 'AUTOMATICO'");
				$consultarRecibo->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);
				$consultarRecibo -> execute();
				$nroRecibo = $consultarRecibo -> fetch(PDO::FETCH_ASSOC);
				$nroRecibo = intval($nroRecibo["NRO_RECIBO"])+1;

				$datos["nroRecibo"] = $nroRecibo;

			}

			/*============================================================
			SI OBTENEMOS LOS REGISTROS PROCEDEMOS A REALIZAR EL INSERT
	 		==============================================================*/
			if($totalCuenta > 0){

				// var_dump($datos["tipoVenta"]);
				// return;

				/*============================================================
				PRIMERO: CALCULAMOS EL SALDO POR CADA PAGO QUE SE VA REALIZANDO
		 		==============================================================*/

				if($saldo > 0 ){

					// CALCULAMOS EL SALDO
					$saldoFinal = ($totalCuenta - ($saldo + intval($datos["pago"])));
					
					if($saldoFinal < 1){

						$estadoCuenta = "CANCELADO";

					}

				}else{

					$saldoFinal = ($totalCuenta - intval($datos["pago"]));

					// var_dump($saldoFinal);
					// return;

					if($saldoFinal < 1){

						$estadoCuenta = "CANCELADO";

					}

				}

				// var_dump($saldoFinal);
				// return;

				$connection = Conexion::conectar();

			    $connection->beginTransaction();

			    $rollback = true;

			    $ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_DETCUENTAS");
				// var_dump($ValorMaximo["maximo"]);
				// return;
				$token=bin2hex(random_bytes(16));
				$token=$token.$ValorMaximo["maximo"];

				/*=======================================================================
					CONSULTAMOS EL MAXIMO ID DE AGRUPAR_PAGOS
			 	========================================================================*/

			 // 	if($key == 0){

				// 	$consultarAgruparPago = $connection->prepare("SELECT (MAX(AGRUPAR_PAGADO)+1) AS AGRUPAR_PAGADO FROM detctascobrar");

				// 	$consultarAgruparPago -> execute();
				// 	$agruparPago = $consultarAgruparPago -> fetch(PDO::FETCH_ASSOC);

				// 	if($agruparPago["AGRUPAR_PAGADO"] == NULL){
				// 		$agruparPago["AGRUPAR_PAGADO"] = 1;
				// 	}

				// }

				// var_dump($agruparPago["AGRUPAR_PAGADO"]);
				// return;

			    /*============================================================
				SEGUNDO: INSERTAMOS EL REGISTRO DE PAGO DE LA CUENTA
		 		==============================================================*/

				$insert=$connection->prepare("INSERT INTO $tabla(COD_CUENTA, COD_USUARIO, COD_CAJA, COD_APERTURA, PAGO, FECHA_VENC, SALDO, FECHA_PAGO, ESTADO_CUENTA, NRO_MOVIMIENTO, FORMAPAGO, NRO_RECIBO, TIPO_RECIBO, DET_MOVIMIENTO, AGRUPAR_ANULADO, TOKEN_DETCTASCOBRAR) VALUES (:codCuenta, :codUsuario, :codCaja, :codApertura, :pago, :fechaVenc, :saldo, :fechaPago, :estadoCuenta, '0', :formaPago, :nroRecibo, :tipoRecibo, 'PAGO', :agruparAnulado, :token)");
						
				$insert->bindParam(":codCuenta", ($datos["codCuenta"]), PDO::PARAM_STR);
				$insert->bindParam(":codUsuario", ($datos["codUsuario"]), PDO::PARAM_STR);
				$insert->bindParam(":codCaja", ($datos["codCaja"]), PDO::PARAM_STR);
				$insert->bindParam(":codApertura", ($datos["codApertura"]), PDO::PARAM_STR);
				$insert->bindParam(":pago", $datos["pago"], PDO::PARAM_STR);
				$insert->bindParam(":fechaVenc",$fechaVenc["FECHA_VENC_PROXIMO"], PDO::PARAM_STR);
				$insert->bindParam(":saldo", $saldoFinal, PDO::PARAM_STR);
				$insert->bindParam(":fechaPago", $datos["fechaPago"], PDO::PARAM_STR);
				$insert->bindParam(":estadoCuenta", $estadoCuenta, PDO::PARAM_STR);
				// $insert->bindParam(":nroMovimiento",'0', PDO::PARAM_STR);
				$insert->bindParam(":nroRecibo", $datos["nroRecibo"], PDO::PARAM_STR);
				$insert->bindParam(":tipoRecibo", $datos["tipoRecibo"], PDO::PARAM_STR);
				$insert->bindParam(":formaPago", $datos["formaPago"], PDO::PARAM_STR);
				$insert->bindParam(":agruparAnulado", $ValorMaximo["maximo"], PDO::PARAM_INT);
				$insert->bindParam(":token", $token, PDO::PARAM_STR);

				if ($insert-> execute()){

					$id = $connection->lastInsertId();

					array_push($array, $id);
					array_push($array1, $datos["codCuenta"]);

					/*=======================================================================
					  TERCERO: CONSULTAMOS SI SE COMPLETAN LOS PAGOS PARCIALES
			 		========================================================================*/
					$consultarPagoParcial = $connection->prepare("SELECT FLOOR(((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, (((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA_DECIMAL, SUM(dcp.PAGO) AS MONTO_PAGADO, ((cp.TOTAL_CUENTA - SUM(dcp.PAGO))) AS SALDO FROM ctascobrar cp INNER JOIN detctascobrar dcp ON cp.COD_CUENTA=dcp.COD_CUENTA WHERE dcp.COD_CUENTA = :codCuenta");

					$consultarPagoParcial->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);
					$consultarPagoParcial -> execute();
					$pagoParcial = $consultarPagoParcial -> fetch(PDO::FETCH_ASSOC);

					/*============================================================
					CUARTO: PREGUNTAMOS EL TIPO DE VENTA PARA AUMENTAR LA FECHA
				 	==============================================================*/

					if($datos["tipoVenta"] == "MENSUAL"){

						$fecha->add(new DateInterval('P'.$pagoParcial["CUOTA_PAGADA"].'M'));
						$fechaAdd = date_format($fecha, "Y-m-d");

					}else if($datos["tipoVenta"] == "QUINCENAL"){

						$fecha->add(new DateInterval('P'.(intval($pagoParcial["CUOTA_PAGADA"])*2).'W'));
						$fechaAdd = date_format($fecha, "Y-m-d");

					}else if($datos["tipoVenta"] == "SEMANAL"){

						$fecha->add(new DateInterval('P'.$pagoParcial["CUOTA_PAGADA"].'W'));
						$fechaAdd = date_format($fecha, "Y-m-d");

					}else if($datos["tipoVenta"] == "DIARIO"){

						$fecha->add(new DateInterval('P'.$pagoParcial["CUOTA_PAGADA"].'D'));
						$fechaAdd = date_format($fecha, "Y-m-d");

					}

					/*=============================================================================================
						 QUINTO: SI SE REALIZA EL INSERT PROCEDEMOS A REALIZAR LA MODIFICACION DE LA FECHA DE VENC
				 	==============================================================================================*/

					$modificar=$connection->prepare("UPDATE ctascobrar SET FECHA_VENC_PROXIMO = :fecha, ESTADO_CUENTA = :estadoCuenta WHERE COD_CUENTA = :codCuenta");

					$modificar->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);
					$modificar->bindParam(":fecha", $fechaAdd, PDO::PARAM_STR);
					$modificar->bindParam(":estadoCuenta", $estadoCuenta, PDO::PARAM_STR);

					if($modificar -> execute()){

						$connection->commit();

						if($key == (intval($datos["cantidad"]) - 1) ){
			
							return "ok/".json_encode($array, JSON_UNESCAPED_UNICODE)."/".json_encode($array1, JSON_UNESCAPED_UNICODE);
						
						}
					
					}else{

						$connection->rollBack();

						return "error";

					}

				}else{

					// var_dump("aqui");

					return "error";

				}

			}else{

				return "error";

			}

		}

	}

	/*============================================================
		MOSTRAR DETALLES DE LA CUENTA CON USUARIO
 	==============================================================*/

	static public function mdlMostrarHistorialPago($tabla1, $tabla2, $tabla3, $item, $valor, $order){

		if($item != null){

			// $stmt = Conexion::conectar()->prepare("SELECT dcc.COD_DETCUENTAS, dcc.COD_CUENTA, dcc.NRO_RECIBO, dcc.TIPO_RECIBO, dcc.PAGO, dcc.FECHA_VENC, dcc.FECHA_PAGO, dcc.SALDO, dcc.FORMAPAGO, dcc.DET_MOVIMIENTO, dcc.NRO_MOVIMIENTO, dcc.TOKEN_DETCTASCOBRAR, f.NOMBRE_FUNC, v.TIPO_MOVIMIENTO FROM $tabla1 AS dcc INNER JOIN $tabla2 AS u ON dcc.COD_USUARIO = u.COD_USUARIO INNER JOIN $tabla3 AS f ON f.COD_FUNCIONARIO = u.COD_FUNCIONARIO INNER JOIN ctascobrar  AS cc ON cc.COD_CUENTA = dcc.COD_CUENTA INNER JOIN ventas AS v ON cc.COD_FACTURA = v.COD_FACTURA WHERE $item = $valor ORDER BY $order");

			$stmt = Conexion::conectar()->prepare("SELECT dcc.*, f.NOMBRE_FUNC FROM $tabla1 AS dcc INNER JOIN $tabla2 AS u ON dcc.COD_USUARIO = u.COD_USUARIO INNER JOIN $tabla3 AS f ON f.COD_FUNCIONARIO = u.COD_FUNCIONARIO WHERE $item = $valor ORDER BY $order");
	           			
	           			
			$stmt -> bindParam(":$item",$valor,PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}


	/*============================================================
		MOSTRAR CUENTA CABECERA
 	==============================================================*/

	static public function mdlMostrarCuentasCabecera($tabla, $item, $valor, $order){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT c.CLIENTE, f.NOMBRE_FUNC, s.SUCURSAL, v.NRO_MOVIMIENTO, v.TIPO_MOVIMIENTO, v.FECHA_VENTA, v.FORMA_PAGO, v.TOTAL_VENTA FROM ventas AS v INNER JOIN clientes AS c ON v.COD_CLIENTE = c.COD_CLIENTE INNER JOIN sucursales AS s ON v.COD_SUCURSAL = s.COD_SUCURSAL INNER JOIN usuarios AS u ON v.COD_USUARIO = u.COD_USUARIO INNER JOIN funcionarios AS f ON u.COD_FUNCIONARIO = f.COD_FUNCIONARIO INNER JOIN ctascobrar AS cc ON cc.COD_FACTURA = v.COD_FACTURA WHERE $item = :$item ORDER BY $order");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetch();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}

	/*============================================================
		ANULAR COBRO
 	==============================================================*/
	static public function mdlAnularCobro($tabla, $datos){

		// var_dump($datos);
		// return;

		$consultarPagoParcialPre = Conexion::conectar()->prepare("SELECT FLOOR(((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, (((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA_DECIMAL, SUM(dcp.PAGO) AS MONTO_PAGADO, ((cp.TOTAL_CUENTA - SUM(dcp.PAGO))) AS SALDO, cp.FECHA_VENC_PROXIMO, cp.TIPO_VENTA FROM ctascobrar cp INNER JOIN detctascobrar dcp ON cp.COD_CUENTA=dcp.COD_CUENTA WHERE dcp.COD_CUENTA = :codCuenta");
		
		$consultarPagoParcialPre->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);

		if($consultarPagoParcialPre -> execute()){

			$pagoParcialPre = $consultarPagoParcialPre -> fetch(PDO::FETCH_ASSOC);

			// var_dump($pagoParcialPre["CUOTA_PAGADA"]);
			// return;

			/*=======================================================================
			CONSULTAMOS LA FECHA DE VENCIMIENTO Y EL TOTAL DE ESA CUENTA
	 		========================================================================*/
			$consultarTipoVenta = Conexion::conectar()->prepare("SELECT * FROM ctascobrar WHERE COD_CUENTA = :codCuenta");
			$consultarTipoVenta->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);

			if($consultarTipoVenta -> execute()){

				$venta = $consultarTipoVenta -> fetch(PDO::FETCH_ASSOC);
				$fechaVenc = $venta["FECHA_VENCIMIENTO"];
				$totalCuenta = intval($venta["TOTAL_CUENTA"]);
				$montoCuota = intval($venta["MONTO_CUOTA"]);

				// var_dump(intval($datos["pago"])*-1);
				// return;

				/*=======================================================================
				INICIAMOS EN ROLLBACK
		 		========================================================================*/

				$connection = Conexion::conectar();
				$connection->beginTransaction();
				$rollback = true;

				/*=======================================================================
				INSERTAMOS NUESTRO REGISTRO
		 		========================================================================*/

				$insert=$connection->prepare("INSERT INTO $tabla(COD_CUENTA, COD_USUARIO, COD_CAJA, COD_APERTURA, PAGO, FECHA_VENC, SALDO, FECHA_PAGO, ESTADO_CUENTA, FORMAPAGO ,NRO_MOVIMIENTO, NRO_RECIBO, TIPO_RECIBO, DET_MOVIMIENTO, AGRUPAR_ANULADO, TOKEN_DETCTASCOBRAR) VALUES (:codCuenta, :codUsuario, :codCaja, :codApertura, :pago, :fechaVenc, :saldo, :fechaPago, :estadoCuenta, :formaPago, :nroMovimiento, :nroRecibo, :tipoRecibo, :detMovimiento, :agruparAnulado, :token)");
							
				$insert->bindParam(":codCuenta", ($datos["codCuenta"]), PDO::PARAM_STR);
				$insert->bindParam(":codUsuario", ($datos["codUsuario"]), PDO::PARAM_STR);
				$insert->bindParam(":codCaja", ($datos["codCaja"]), PDO::PARAM_STR);
				$insert->bindParam(":codApertura", ($datos["codApertura"]), PDO::PARAM_STR);
				$insert->bindParam(":pago", $datos["pago"], PDO::PARAM_STR);
				$insert->bindParam(":fechaVenc",$datos["fechaVenc"], PDO::PARAM_STR);
				$insert->bindParam(":saldo", $datos["saldo"], PDO::PARAM_STR);
				$insert->bindParam(":fechaPago", $datos["fechaPago"], PDO::PARAM_STR);
				$insert->bindParam(":estadoCuenta", $datos["estadoCuenta"], PDO::PARAM_STR);
				$insert->bindParam(":formaPago", $datos["formaPago"], PDO::PARAM_STR);
				$insert->bindParam(":nroMovimiento",$datos["nroMovimiento"], PDO::PARAM_STR);
				$insert->bindParam(":nroRecibo", $datos["nroRecibo"], PDO::PARAM_STR);
				$insert->bindParam(":tipoRecibo", $datos["tipoRecibo"], PDO::PARAM_STR);
				$insert->bindParam(":detMovimiento", $datos["detMovimiento"], PDO::PARAM_STR);
				$insert->bindParam(":agruparAnulado", $datos["agruparAnulado"], PDO::PARAM_STR);
				$insert->bindParam(":token", $datos["token"], PDO::PARAM_STR);

				/*===================================================================================
				SI SE REALIZA EL INSERT PROCEDEMOS A REALIZAR LA CONSULTA DEL PAGO TOTAL DE LA CUENTA
		 		====================================================================================*/
				if ($insert -> execute()){

					$consultarPagoParcial = $connection->prepare("SELECT FLOOR(((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, (((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA_DECIMAL, SUM(dcp.PAGO) AS MONTO_PAGADO, ((cp.TOTAL_CUENTA - SUM(dcp.PAGO))) AS SALDO, cp.FECHA_VENC_PROXIMO, cp.TIPO_VENTA FROM ctascobrar cp INNER JOIN detctascobrar dcp ON cp.COD_CUENTA=dcp.COD_CUENTA WHERE dcp.COD_CUENTA = :codCuenta");
		
					$consultarPagoParcial->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);

					/*===================================================================================
					SI SE OBTIENE LOS DATOS PROCEDEMOS A COMPARAR LOS DATOS
			 		====================================================================================*/

					if($consultarPagoParcial -> execute()){

						$pagoParcial = $consultarPagoParcial -> fetch(PDO::FETCH_ASSOC);
						$tipoVenta = $pagoParcial["TIPO_VENTA"];
						$fechaVenc = $pagoParcial["FECHA_VENC_PROXIMO"];
						$saldo = intval($pagoParcial["SALDO"]);

						$fecha = new DateTime($fechaVenc);
						$fechaDiff;

						// var_dump($pagoParcial["CUOTA_PAGADA"]);
						// var_dump($pagoParcial["CUOTA_PAGADA_DECIMAL"]);
						// return;

						$cuotaRestar = intval($pagoParcialPre["CUOTA_PAGADA"]) - intval($pagoParcial["CUOTA_PAGADA"]);
						// var_dump($cuotaRestar);
						// return;

							/*============================================================
							PREGUNTAMOS EL TIPO DE VENTA PARA DISMINUIR LA FECHA
							==============================================================*/

							if($tipoVenta == "MENSUAL"){

								$fecha->sub(new DateInterval('P'.$cuotaRestar.'M'));
								$fechaDiff = date_format($fecha, "Y-m-d");

							}else if($tipoVenta == "QUINCENAL"){

								$fecha->sub(new DateInterval('P'.(intval($cuotaRestar)*2).'W'));
								$fechaDiff = date_format($fecha, "Y-m-d");

							}else if($tipoVenta == "SEMANAL"){

								$fecha->sub(new DateInterval('P'.$cuotaRestar.'W'));
								$fechaDiff = date_format($fecha, "Y-m-d");

							}else if($tipoVenta == "DIARIO"){

								$fecha->sub(new DateInterval('P'.$cuotaRestar.'D'));
								$fechaDiff = date_format($fecha, "Y-m-d");

							}


						$estadoCuenta = "CANCELADO";

						if($saldo > 0){

							$estadoCuenta = "CREDITO";

						}

						/*============================================================
							REALIZAMOS LA MODIFICACION
						==============================================================*/
						$modificar=$connection->prepare("UPDATE ctascobrar SET FECHA_VENC_PROXIMO = :fecha, ESTADO_CUENTA = :estadoCuenta WHERE COD_CUENTA = :codCuenta");

						$modificar->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);
						$modificar->bindParam(":fecha", $fechaDiff, PDO::PARAM_STR);
						$modificar->bindParam(":estadoCuenta", $estadoCuenta, PDO::PARAM_STR);

						if($modificar -> execute()){

							$modificarEstado=$connection->prepare("UPDATE detctascobrar SET DET_MOVIMIENTO = 'ANULADO' WHERE COD_DETCUENTAS = :tokenCuentaDet");

							$modificarEstado->bindParam(":tokenCuentaDet", $datos["tokenCuentaDet"], PDO::PARAM_STR);

							if ($modificarEstado -> execute()) {
								
								$connection->commit();

								return "ok";
							}else{

								$connection->rollBack();

								return "error";

							}
							
						}else{

							$connection->rollBack();

							return "error";

						}

					}

				}else{

					return "error";

				}

			}else{

				return "error";

			}

		}
	}

	/*============================================================
		MOSTRAR VENTAS
 	==============================================================*/

	static public function mdlMostrarVentas($item, $valor, $tabla, $order){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}

	/*============================================================
		MODELO MOSTRAR PRODUCTOS
 	==============================================================*/
 	static function mdlMostrarProductos($tabla, $item, $valor){
 		
 		if($valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
			
			return $stmt -> fetch();

		}else{

 			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");
 			$stmt->execute();
 			return $stmt-> fetchAll();
 		}
 		
 	}

 	/*============================================================
		MODIFICAR COMENTARIO
 	==============================================================*/
	static public function mdlModificarComentario($item1, $valor1, $item2, $valor2){

			$modificar=Conexion::conectar()->prepare("UPDATE ctascobrar SET OBSERVACIONES = :comentario WHERE COD_CUENTA = :codCuenta");
					
			$modificar->bindParam(":codCuenta", $valor1, PDO::PARAM_STR);
			$modificar->bindParam(":comentario", $valor2, PDO::PARAM_STR);

			if ($modificar-> execute()){

				return "ok";

			}else{

			   	return "error";
			   		
			}

	}

	/*============================================================
		MOSTRAR CABECERA TICKET
 	==============================================================*/

	static public function mdlMostrarCabeceraTicket($item, $valor){

		// var_dump($item);
		// var_dump($valor);

		if($valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT (SELECT NOMBRE_EMPRESA FROM empresas) AS NOMBRE_EMPRESA,(SELECT RUC_EMPRESA FROM empresas) AS RUC_EMPRESA,(SELECT PROPIETARIO_EMPRESA FROM empresas) AS PROPIETARIO_EMPRESA, s.SUCURSAL, s.ENCARGADO, s.RUC AS RUC_CLIENTE, s.TELEFONO_SUC, s.DIRECCION, f.NOMBRE_FUNC, c.CLIENTE, c.RUC AS RUC_SUCURSAL, v.NRO_MOVIMIENTO, dcc.NRO_RECIBO, date_format(dcc.FECHA_PAGO, '%d-%m-%Y %H:%i:%s') AS FECHA_PAGO FROM ctascobrar AS cc INNER JOIN ventas AS v ON cc.COD_FACTURA = v.COD_FACTURA INNER JOIN usuarios AS u ON u.COD_USUARIO = v.COD_USUARIO INNER JOIN funcionarios AS f ON f.COD_FUNCIONARIO = u.COD_FUNCIONARIO INNER JOIN sucursales AS s ON s.COD_SUCURSAL = v.COD_SUCURSAL INNER JOIN clientes AS c ON c.COD_CLIENTE = v.COD_CLIENTE INNER JOIN detctascobrar AS dcc ON dcc.COD_CUENTA = cc.COD_CUENTA WHERE dcc.COD_DETCUENTAS = $valor");
           			
			// $stmt -> bindParam(":$item",  $valor, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetch();

		}else{

 			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");
 			$stmt->execute();
 			return $stmt-> fetchAll();
 		}

	}

	/*============================================================
		MOSTRAR CUENTAS A COBRADAS
 	==============================================================*/

	static public function mdlMostrarDetalleTicket($item, $valor, $valor1){

		// var_dump($valor);
		// var_dump($valor1);

		// $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
		$stmt = Conexion::conectar()->prepare("SELECT GROUP_CONCAT(p.DESCRIPCION SEPARATOR '||') AS DESCRIPCION, cc.TOTAL_CUENTA, 
		(SELECT SUM(PAGO) FROM detctascobrar WHERE COD_CUENTA = $valor1) AS MONTO_PAGADO, date_format(dcc.FECHA_PAGO, '%d-%m-%Y') AS FECHA_PAGO, date_format(dcc.FECHA_VENC, '%d-%m-%Y') AS FECHA_VENC, cc.CANT_CUOTA, (SELECT ((SUM(dcc.PAGO)*cc.CANT_CUOTA)/cc.TOTAL_CUENTA) FROM ctascobrar AS cc INNER JOIN detctascobrar AS dcc ON cc.COD_CUENTA = dcc.COD_CUENTA WHERE cc.COD_CUENTA = $valor1) AS CUOTA_PAGADA, cc.MONTO_CUOTA, (SELECT (cc.MONTO_CUOTA+(dcc.SALDO)) FROM ctascobrar AS cc INNER JOIN detctascobrar AS dcc ON cc.COD_CUENTA = dcc.COD_CUENTA WHERE dcc.COD_DETCUENTAS = $valor) AS SALDO_ANT, dcc.PAGO, dcc.SALDO, dcc.NRO_RECIBO, ((cc.TOTAL_CUENTA - dcc.SALDO) / CC.MONTO_CUOTA) AS CUOTA_PAGADA_REIMP, (cc.TOTAL_CUENTA - dcc.SALDO) AS MONTO_PAGADO_REIMP FROM detctascobrar AS dcc INNER JOIN ctascobrar AS cc ON dcc.COD_CUENTA = cc.COD_CUENTA INNER JOIN ventas AS v ON cc.COD_FACTURA = v.COD_FACTURA INNER JOIN detventas AS dv ON v.COD_FACTURA = dv.COD_FACTURA INNER JOIN productos AS p ON dv.COD_PRODUCTO = p.COD_PRODUCTO WHERE dcc.COD_DETCUENTAS = $valor;");
	           			
		$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

		$stmt -> execute();
				
		return $stmt -> fetch();

	 	$stmt-> close();
		$stmt= null;

	}


}