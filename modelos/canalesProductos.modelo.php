<?php 

	require_once "conexion.php";

	class ModeloCanalesProductos{
		
		/*============================================================
					MOSTRAR CANALES
 		==============================================================*/

		static public function MdlMostrarCanal($tabla, $item, $valor,$var,$order){

			if($valor != null && $var!=null){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

				$stmt -> execute();

				// var_dump($stmt);
				// return;
				
				return $stmt -> fetch();


			}elseif($valor != null && $var==null){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

				$stmt -> execute();

				// var_dump($stmt);
				
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
					CREAR CANALES
 		==============================================================*/
		static public function mdlIngresarCanal($tabla, $datos){

			// CONSULTAR SI YA HAY UN REGISTRO CON EL MISMO NOMBRE
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE DESCRIPCION_CANAL = :Canal");

			$stmt->bindParam(":Canal", $datos["Canal"], PDO::PARAM_STR);		

			$stmt -> execute();

			$cuenta = $stmt->rowCount();

			// var_dump($datos);

			// return;

			if($cuenta <= 0){

				$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(DESCRIPCION_CANAL, ESTADO, TOKEN_CANAL) VALUES (:Canal, :Estado, :token)");
				
				$stmt->bindParam(":Canal",$datos["Canal"],PDO::PARAM_STR);
				$stmt->bindParam(":Estado",$datos["Estado"],PDO::PARAM_INT);
			    $stmt->bindParam(":token",$datos["token"],PDO::PARAM_STR);

			 	//var_dump($stmt);

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
					EDITAR CANAL
		=============================================*/

		static public function mdlEditarCanal($tabla, $datos){

			// var_dump($datos);
			// return;

			$stmt=Conexion::conectar()->prepare("UPDATE $tabla SET DESCRIPCION_CANAL = :Canal, ESTADO = :Estado WHERE TOKEN_CANAL = :token");
				
			$stmt->bindParam(":Canal",$datos["Canal"],PDO::PARAM_STR);
			$stmt->bindParam(":Estado",$datos["Estado"],PDO::PARAM_STR);
			$stmt->bindParam(":token",$datos["token"],PDO::PARAM_STR);

			// var_dump($stmt);


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
					ELIMINAR CANAL
		=============================================*/

		static public function mdlEliminarCanal($tabla, $item, $valor){

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
