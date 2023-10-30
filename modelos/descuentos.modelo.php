<?php 

	require_once "conexion.php";

	class ModeloDescuentos{
		
		/*============================================================
					MOSTRAR DESCUENTO
 		==============================================================*/

		static public function MdlMostrarDescuento($tabla, $item, $valor, $var, $order){

			if($valor != null && $var!=null){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

				$stmt -> execute();
				
				return $stmt -> fetch();

			}else if($valor != null && $var==null){

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
					MOSTRAR DESCUENTO Y CANAL CON INNER
 		==============================================================*/

		static public function MdlMostrarDescuentoCanal($tabla1, $tabla2, $item, $valor){

			if($item != null){

				$stmt = Conexion::conectar()->prepare("SELECT d.*, c.DESCRIPCION_CANAL, c.TOKEN_CANAL FROM $tabla1 AS d INNER JOIN $tabla2 c ON d.COD_CANAL = C.COD_CANAL	 WHERE $item = :$item");
	           			
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
					CREAR DESCUENTOS
 		==============================================================*/
		static public function mdlIngresarDescuento($tabla, $datos){

			// CONSULTAR SI YA HAY UN REGISTRO CON EL MISMO RUC

			$stmt = Conexion::conectar()->prepare("SELECT * FROM detcanal WHERE (((:Desde >= MONTO_DESDE AND :Desde <= MONTO_HASTA) OR (:Hasta >= MONTO_DESDE AND :Hasta <= MONTO_HASTA) OR (:Hasta >= MONTO_HASTA AND :Desde <= MONTO_DESDE)) AND (COD_CANAL = :cod_canal) AND(TOKEN != :Token) )");

			$stmt->bindParam(":cod_canal", $datos["Canal"], PDO::PARAM_INT);
			$stmt->bindParam(":Desde",$datos["Desde"],PDO::PARAM_INT);
			$stmt->bindParam(":Hasta",$datos["Hasta"],PDO::PARAM_INT);
			$stmt->bindParam(":Token",$datos["Token"],PDO::PARAM_STR);		

			$stmt -> execute();

			$cuenta = $stmt->rowCount();

			// var_dump($datos);

			// return;

			if($cuenta <= 0){

				$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(COD_CANAL, DESC_CANAL, MONTO_DESDE, MONTO_HASTA, TOKEN,FECHA_REGISTRO) VALUES (:Canal, :Descuento, :Desde, :Hasta, :Token,:registro_fecha)");

				$stmt->bindParam(":Canal",($datos["Canal"]),PDO::PARAM_INT);
				$stmt->bindParam(":Descuento",($datos["Descuento"]),PDO::PARAM_STR);
				$stmt->bindParam(":Desde",($datos["Desde"]),PDO::PARAM_INT);
				$stmt->bindParam(":Hasta",$datos["Hasta"],PDO::PARAM_INT);
				$stmt->bindParam(":Token",$datos["Token"],PDO::PARAM_STR);
				$stmt->bindParam(":registro_fecha",$datos["registro_fecha"],PDO::PARAM_STR);
			 	// var_dump($stmt);

			   if ($stmt-> execute()){

					return "ok";

			   }else{

			   		return "error";
			   }
				
			}else{

				return "exist";

			}

		}

		/*=============================================
					EDITAR DESCUENTO
		=============================================*/

		static public function mdlEditarDescuento($tabla, $datos){

			// var_dump($datos);
			// return;
			// $cuenta = 0;

			// if($datos["estado"] == 1){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM detcanal WHERE (((:Desde >= MONTO_DESDE AND :Desde <= MONTO_HASTA) OR (:Hasta >= MONTO_DESDE AND :Hasta <= MONTO_HASTA) OR (:Hasta >= MONTO_HASTA AND :Desde <= MONTO_DESDE)) AND (COD_CANAL = :cod_canal) AND(TOKEN != :Token) )");

				$stmt->bindParam(":cod_canal", $datos["Canal"], PDO::PARAM_INT);
				$stmt->bindParam(":Desde",$datos["Desde"],PDO::PARAM_INT);
				$stmt->bindParam(":Hasta",$datos["Hasta"],PDO::PARAM_INT);
				$stmt->bindParam(":Token",$datos["Token"],PDO::PARAM_STR);		

				$stmt -> execute();

				$cuenta = $stmt->rowCount();

			// }

			// var_dump($cuenta);
			// return;

			if($cuenta <= 0){
				
				$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET COD_CANAL = :Canal, DESC_CANAL = :Descuento, MONTO_DESDE = :Desde, MONTO_HASTA = :Hasta, FECHA_MODIFICACION = :FechaMod WHERE TOKEN = :Token");
					
				$stmt->bindParam(":Canal",($datos["Canal"]),PDO::PARAM_INT);
				$stmt->bindParam(":Descuento",($datos["Descuento"]),PDO::PARAM_STR);
				$stmt->bindParam(":Desde",($datos["Desde"]),PDO::PARAM_INT);
				$stmt->bindParam(":Hasta",$datos["Hasta"],PDO::PARAM_INT);
				$stmt->bindParam(":FechaMod",$datos["FechaMod"],PDO::PARAM_STR);
				$stmt->bindParam(":Token",$datos["Token"],PDO::PARAM_STR);

			
				if($stmt -> execute()){
					
					return "ok";
				
				}else{

					return "error";	

				}

				$stmt -> close();

				$stmt = null;

			}else{
				
				return "exist";

			}

		}

		/*=============================================
					ELIMINAR DESCUENTO
		=============================================*/

		static public function mdlEliminarDescuento($tabla, $item, $valor){

			// var_dump($tabla, $item, $valor);
			// return;

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
