<?php 

	require_once "conexion.php";

	class ModeloCuotas{
		
		/*============================================================
					MOSTRAR DESCUENTO
 		==============================================================*/

		static public function MdlMostrarCuota($tabla, $item, $valor, $var, $order){

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
					CREAR DESCUENTOS
 		==============================================================*/
		static public function mdlIngresarCuota($tabla, $datos){

			// CONSULTAR SI YA HAY UN REGISTRO CON EL MISMO RUC

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE (((:Desde >= 		MONTO_CUOTA AND :Desde <= MONTO_MAXIMA) OR (:Hasta >=	MONTO_CUOTA AND :Hasta <= MONTO_MAXIMA) OR (:Hasta >= MONTO_MAXIMA AND :Desde <=	MONTO_CUOTA)) AND(TOKEN_CUOTA != :Token) )");

			
			$stmt->bindParam(":Desde",$datos["Desde"],PDO::PARAM_INT);
			$stmt->bindParam(":Hasta",$datos["Hasta"],PDO::PARAM_INT);
			$stmt->bindParam(":Token",$datos["Token"],PDO::PARAM_STR);


			$stmt -> execute();

			$cuenta = $stmt->rowCount();

			// var_dump($datos);

			// return;

			if($cuenta <= 0){

				$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(COD_USUARIO,MONTO_CUOTA,MONTO_MAXIMA,RECARGO_CUOTA, ESTADO, TOKEN_CUOTA,FECHA_REGISTRO) VALUES (:idUsuario, :Desde, :Hasta,:Recargo,:estado,:Token,:fecha_registro)");

				$stmt->bindParam(":idUsuario",($datos["idUsuario"]),PDO::PARAM_INT);
				$stmt->bindParam(":Desde",($datos["Desde"]),PDO::PARAM_INT);
				$stmt->bindParam(":Hasta",$datos["Hasta"],PDO::PARAM_INT);
				$stmt->bindParam(":Recargo",($datos["Recargo"]),PDO::PARAM_STR);
				$stmt->bindParam(":estado",($datos["estado"]),PDO::PARAM_STR);
				$stmt->bindParam(":Token",$datos["Token"],PDO::PARAM_STR);
				$stmt->bindParam(":fecha_registro",$datos["fecha_registro"],PDO::PARAM_STR);

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

		static public function mdlEditarCuota($tabla, $datos){

			// var_dump($datos);
			// return;
			// $cuenta = 0;

			// if($datos["estado"] == 1){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE (((:Desde >= 		MONTO_CUOTA AND :Desde <= MONTO_MAXIMA) OR (:Hasta >=	MONTO_CUOTA AND :Hasta <= MONTO_MAXIMA) OR (:Hasta >= MONTO_MAXIMA AND :Desde <=	MONTO_CUOTA)) AND(TOKEN_CUOTA != :Token) )");

			
			$stmt->bindParam(":Desde",$datos["Desde"],PDO::PARAM_INT);
			$stmt->bindParam(":Hasta",$datos["Hasta"],PDO::PARAM_INT);
			$stmt->bindParam(":Token",$datos["Token"],PDO::PARAM_STR);	

				$stmt -> execute();

				$cuenta = $stmt->rowCount();

			// }

			// var_dump($cuenta);
			// return;

			if($cuenta <= 0){
				
				$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET MONTO_CUOTA=:Desde,MONTO_MAXIMA=:Hasta,RECARGO_CUOTA=:txtRecargo,FECHA_MODIFICACION=:FechaMod,ESTADO=:estado WHERE TOKEN_CUOTA = :Token");
					
				
				$stmt->bindParam(":txtRecargo",($datos["txtRecargo"]),PDO::PARAM_STR);
				$stmt->bindParam(":Desde",($datos["Desde"]),PDO::PARAM_INT);
				$stmt->bindParam(":Hasta",$datos["Hasta"],PDO::PARAM_INT);
				$stmt->bindParam(":FechaMod",$datos["FechaMod"],PDO::PARAM_STR);
				$stmt->bindParam(":Token",$datos["Token"],PDO::PARAM_STR);
				$stmt->bindParam(":estado",($datos["estado"]),PDO::PARAM_INT);
			
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

		static public function mdlEliminarCuota($tabla, $item, $valor){

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
