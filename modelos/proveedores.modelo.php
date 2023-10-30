<?php 

	require_once "conexion.php";

	class ModeloProveedores{
		
		/*============================================================
					MOSTRAR PROVEEDORES
 		==============================================================*/

		static public function MdlMostrarProveedor($tabla, $item, $valor,$var,$order){

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

	 			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 			$stmt->execute();

	 			return $stmt-> fetchAll();
	 		}

	 		$stmt-> close();
			$stmt= null;
		}


		/*============================================================
					MOSTRAR PROVEEDOR Y CLIENTE CON INNER
 		==============================================================*/

		static public function MdlMostrarProveedorCiudad($tabla1, $tabla2, $item, $valor){

			if($item != null){

				$stmt = Conexion::conectar()->prepare("SELECT p.*, c.DESCRIPCION_CIUDAD, c.TOKEN_CIUDAD FROM $tabla1 AS p INNER JOIN $tabla2 c ON p.COD_CIUDAD = c.COD_CIUDAD WHERE $item = :$item");
	           			
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
					CREAR PROVEEDORES
 		==============================================================*/
		static public function mdlIngresarProveedor($tabla, $datos){

			$insertar=false;

			// CONSULTAR SI YA HAY UN REGISTRO CON EL MISMO RUC
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE RUC = :ruc");

			$stmt->bindParam(":ruc", $datos["ruc"], PDO::PARAM_STR);		

			$stmt -> execute();

			$cuenta = $stmt->rowCount();

			//var_dump($cuenta);

			//return;

			if($cuenta <= 0){

				$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(COD_CIUDAD, RUC, NOMBRE, DIRECCION, EMAIL, LINEABAJA, CELULAR, ESTADO_PROVEEDOR, TOKEN_PROVEEDOR,FECHA_REGISTRO) VALUES (:ciudad, :ruc, :empresa, :direccion, :email, :telefono, :celular, :estado, :token,:fecha_registro)");
				
				$stmt->bindParam(":empresa",($datos["empresa"]),PDO::PARAM_STR);
				$stmt->bindParam(":ruc",($datos["ruc"]),PDO::PARAM_STR);
				$stmt->bindParam(":ciudad",$datos["ciudad"],PDO::PARAM_INT);
				$stmt->bindParam(":direccion",$datos["direccion"],PDO::PARAM_STR);
				$stmt->bindParam(":telefono",$datos["telefono"],PDO::PARAM_STR);
				$stmt->bindParam(":celular",$datos["celular"],PDO::PARAM_STR);
				$stmt->bindParam(":email",$datos["email"],PDO::PARAM_STR);
				$stmt->bindParam(":estado",$datos["estado"],PDO::PARAM_INT);
			    $stmt->bindParam(":token",$datos["token"],PDO::PARAM_STR);
			    $stmt->bindParam(":fecha_registro",$datos["fecha_registro"],PDO::PARAM_STR);
			    

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
					EDITAR USUARIO
		=============================================*/

		static public function mdlEditarProveedor($tabla, $datos){

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET COD_CIUDAD = :ciudad, RUC = :ruc, NOMBRE = :empresa, DIRECCION = :direccion, EMAIL = :email, LINEABAJA = :telefono, CELULAR = :celular, FECHA_ACTUALIZACION = :fechaMod,  ESTADO_PROVEEDOR = :estado WHERE TOKEN_PROVEEDOR = :token");

			$stmt->bindParam(":empresa",($datos["empresa"]),PDO::PARAM_STR);
			$stmt->bindParam(":ruc",($datos["ruc"]),PDO::PARAM_STR);
			$stmt->bindParam(":ciudad",$datos["ciudad"],PDO::PARAM_INT);
			$stmt->bindParam(":direccion",$datos["direccion"],PDO::PARAM_STR);
			$stmt->bindParam(":telefono",$datos["telefono"],PDO::PARAM_STR);
			$stmt->bindParam(":celular",$datos["celular"],PDO::PARAM_STR);
			$stmt->bindParam(":email",$datos["email"],PDO::PARAM_STR);
			$stmt->bindParam(":fechaMod",$datos["fechaMod"],PDO::PARAM_STR);
			$stmt->bindParam(":estado",$datos["estado"],PDO::PARAM_INT);
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
					ELIMINAR PROVEEDOR
		=============================================*/

		static public function mdlEliminarProveedor($tabla, $item, $valor){

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
			
			// $eliminar=true;

			// // PREGUNTA SI HAY ACTIVADAD EN LA VENTA PARA PODER ELIMINAR EL PRODUCTO
			// $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla INNER JOIN detventas ON detventas.COD_PRODUCTO=$tabla.COD_PRODUCTO WHERE $item = :$item");		
			// $stmt -> bindParam(":$item",  $datos["tokenProducto"], PDO::PARAM_STR);
			// $stmt -> execute();
			// $cuenta = $stmt->rowCount();
			// // var_dump($cuenta);

			// if($cuenta<=0){

			// 	$eliminar=false;


			// }else{

			// 	$eliminar=true;
			// }

				
			// if ($eliminar==false){

			// 	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla INNER JOIN $tabla1 ON $tabla1.COD_PRODUCTO=$tabla.COD_PRODUCTO WHERE $item = :$item");		
			// 	$stmt -> bindParam(":$item",  $datos["tokenProducto"], PDO::PARAM_STR);
			// 	$stmt -> execute();
			// 	$cuenta = $stmt->rowCount();

			// 	// var_dump($cuenta);
			// 	if($cuenta>1){

			// 		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla1 WHERE $item1 = :tokenStock");

			// 		$stmt -> bindParam(":tokenStock",$datos["tokenStock"], PDO::PARAM_STR);
			// 		if($stmt -> execute()){

			// 			return "ok";
								
			// 		}else{
								
			// 			"\nPDO::errorInfo():\n";
			// 		   	return ($stmt->errorInfo());

			// 		}

			//  	}else{

			//  		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla1 WHERE $item1 = :tokenStock");
			// 		$stmt -> bindParam(":tokenStock",$datos["tokenStock"], PDO::PARAM_STR);
			// 		$stmt -> execute();

			// 		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :id");

			// 		$stmt -> bindParam(":id",$datos["tokenProducto"], PDO::PARAM_STR);
			// 			if($stmt -> execute()){

			// 				return "ok";
								
			// 			}else{
								
			// 				"\nPDO::errorInfo():\n";
			// 		   		return ($stmt->errorInfo());

			// 			}

			//  		}
				

			// }else{

			// 	return "exist";

			// }
			
		//}
