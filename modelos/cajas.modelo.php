<?php 

	require_once "conexion.php";

	class ModeloCajas{
		
		/*============================================================
					MOSTRAR CAJAS
 		==============================================================*/

		static public function MdlMostrarCaja($tabla, $item, $valor,$var,$order){

			if($valor != null && $var!=null){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

				$stmt -> execute();
				
				return $stmt -> fetch();


			}elseif($valor != null && $var==null){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

				$stmt -> execute();
				
				return $stmt -> fetchAll();
			
			}else{

	 			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $order");

	 			$stmt->execute();

	 			// var_dump($stmt);

	 			return $stmt-> fetchAll();
	 		}

	 		$stmt-> close();
			$stmt= null;

		}

		/*============================================================
					MOSTRAR CANTIDAD DE USO
 		==============================================================*/

		static public function MdlMostrarCantidadUso($tabla, $item, $valor){

			if($item != null){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

				$stmt -> execute();
				
				return $stmt -> fetch();

			}else{

	 			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 			$stmt->execute();
	 		
	 			return $stmt-> fetchall();
	 		}

	 		$stmt-> close();
			$stmt= null;
		}


		/*============================================================
					MOSTRAR CAJA Y SUCURSAL CON INNER
 		==============================================================*/

		static public function MdlMostrarCajaSucursal($tabla1, $tabla2, $item, $valor,$item1, $valor1,$var,$order){

			if($valor != null && $var!=null){

				if($var==1){
					$stmt = Conexion::conectar()->prepare("SELECT c.*, s.SUCURSAL, s.TOKEN_SUCURSAL FROM $tabla1 AS c INNER JOIN $tabla2 s ON c.COD_SUCURSAL = s.COD_SUCURSAL WHERE $item = :$item AND c.$item1=:$item1");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);
				$stmt -> bindParam(":$item1",  $valor1, PDO::PARAM_STR);

				$stmt -> execute();
				
				return $stmt -> fetch();
			}else{
				$stmt = Conexion::conectar()->prepare("SELECT c.*, s.SUCURSAL, s.TOKEN_SUCURSAL FROM $tabla1 AS c INNER JOIN $tabla2 s ON c.COD_SUCURSAL = s.COD_SUCURSAL WHERE $item = :$item");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);
				
				$stmt -> execute();
				
				return $stmt -> fetch();
			}

				


			}elseif($valor != null && $var==null){

			$stmt = Conexion::conectar()->prepare("SELECT c.*, s.SUCURSAL, s.TOKEN_SUCURSAL FROM $tabla1 AS c INNER JOIN $tabla2 s ON c.COD_SUCURSAL = s.COD_SUCURSAL WHERE $item = :$item AND s.$item1=:$item1");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);
				$stmt -> bindParam(":$item1",  $valor1, PDO::PARAM_STR);

			$stmt -> execute();
						
			return $stmt -> fetchAll();

			}else{

	 			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $order");

	 			$stmt->execute();

	 			return $stmt-> fetchAll();
	 		}

	 		$stmt-> close();
			$stmt= null;
		}


		/*============================================================
					CREAR CAJAS
 		==============================================================*/
		static public function mdlIngresarCaja($tabla, $datos){

			$insertar=false;

			// CONSULTAR SI YA HAY UN REGISTRO CON EL MISMO NRO CAJA PARA ESA SUCURSAL
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE NROCAJA = :NroCaja AND COD_SUCURSAL = :Sucursal AND EST_CAJA = 1");

			$stmt->bindParam(":NroCaja", $datos["NroCaja"], PDO::PARAM_STR);
			$stmt->bindParam(":Sucursal",($datos["Sucursal"]),PDO::PARAM_INT);		

			$stmt -> execute();

			$cuenta = $stmt->rowCount();

			// var_dump($cuenta);
			// return;

			if($cuenta <= 0){

				$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(COD_SUCURSAL, NROCAJA, NRO_FACTURA, TIMBRADO, FECHA_DESDE, FECHA_HASTA, NOMBRE_EQUIPO, NRO_VERIFICADOR, NROTICKET, NRONOTACREDITO, EST_CAJA, TOKEN_CAJA) VALUES (:Sucursal, :NroCaja, :NroFactura, :Timbrado, :InicioVigencia, :FinVigencia, :txtEquipo, :Verificador, :Ticket, :NC, :Estado, :token)");
				
				$stmt->bindParam(":Sucursal",($datos["Sucursal"]),PDO::PARAM_INT);
				$stmt->bindParam(":NroCaja",($datos["NroCaja"]),PDO::PARAM_STR);
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

			 	// var_dump($stmt);

			   if ($stmt-> execute()){

					return "ok";

			   }else{

			   		return "error";
			   }
				
			}else{

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE EST_CAJA = 1 ORDER BY NROCAJA DESC LIMIT 1");

				$stmt->bindParam(":NroCaja", $datos["NroCaja"], PDO::PARAM_STR);		

				$stmt -> execute();


				$ultimaCaja = $stmt -> fetch(PDO::FETCH_ASSOC);

				$porciones = explode(" ", $ultimaCaja["NROCAJA"]);

				$caja = ($porciones[1]+1);

				$nuevaCaja = "Caja ".strval($caja);

				// echo $nuevaCaja;


				$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(COD_SUCURSAL, NROCAJA, NRO_FACTURA, TIMBRADO, FECHA_DESDE, FECHA_HASTA, NOMBRE_EQUIPO, NRO_VERIFICADOR, NROTICKET, NRONOTACREDITO, EST_CAJA, TOKEN_CAJA) VALUES (:Sucursal, :NroCaja, :NroFactura, :Timbrado, :InicioVigencia, :FinVigencia, :txtEquipo, :Verificador, :Ticket, :NC, :Estado, :token)");
				
				$stmt->bindParam(":Sucursal",($datos["Sucursal"]),PDO::PARAM_INT);
				$stmt->bindParam(":NroCaja",($nuevaCaja),PDO::PARAM_STR);
				$stmt->bindParam(":NroFactura",($datos["NroFactura"]),PDO::PARAM_INT);
				$stmt->bindParam(":Timbrado",$datos["Timbrado"],PDO::PARAM_STR);
				$stmt->bindParam(":InicioVigencia",$datos["InicioVigencia"],PDO::PARAM_STR);
				$stmt->bindParam(":FinVigencia",$datos["FinVigencia"],PDO::PARAM_STR);
				$stmt->bindParam(":txtEquipo",$datos["txtEquipo"],PDO::PARAM_STR);
				$stmt->bindParam(":Verificador",$caja,PDO::PARAM_INT);
				$stmt->bindParam(":Ticket",$datos["Ticket"],PDO::PARAM_INT);
				$stmt->bindParam(":NC",$datos["NC"],PDO::PARAM_INT);
				$stmt->bindParam(":Estado",$datos["Estado"],PDO::PARAM_INT);
			    $stmt->bindParam(":token",$datos["token"],PDO::PARAM_STR);

			 	// var_dump($stmt);

			   if ($stmt-> execute()){

					return "ok";

			   }else{

			   		return "error";
			   }

			}

		}

		/*=============================================
					EDITAR CAJA
		=============================================*/

		static public function mdlEditarCaja($tabla, $datos){

			// var_dump($datos);

			// return;

			$stmt=Conexion::conectar()->prepare("UPDATE $tabla SET COD_SUCURSAL = :Sucursal, NROCAJA = :NroCaja, NRO_FACTURA = :NroFactura, TIMBRADO = :Timbrado, FECHA_DESDE = :InicioVigencia, FECHA_HASTA = :FinVigencia, NOMBRE_EQUIPO = :txtEquipo, NRO_VERIFICADOR = :Verificador, NROTICKET = :Ticket, NRONOTACREDITO = :NC, EST_CAJA = :Estado WHERE TOKEN_CAJA = :token");
				
				$stmt->bindParam(":Sucursal",($datos["Sucursal"]),PDO::PARAM_INT);
				$stmt->bindParam(":NroCaja",($datos["NroCaja"]),PDO::PARAM_STR);
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
					ELIMINAR CAJA
		=============================================*/

		static public function mdlEliminarCaja($tabla, $item, $valor){

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

	}
