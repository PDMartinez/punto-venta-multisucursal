<?php 

	require_once "conexion.php";

	class ModeloClientes{


		/*============================================================
					MOSTRAR CLIENTES
 		==============================================================*/

		static public function MdlMostrarCliente($tabla, $item, $valor,$var,$order){

			if($valor != null && $var!=null){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

				$stmt -> execute();
				
				return $stmt -> fetch();


			}else if($valor != null && $var==null){

				$stmt = Conexion::conectar()->prepare("SELECT  COD_CLIENTE,COD_CIUDAD, RUC, CLIENTE, DIRECCION, EMAIL,CELULAR, ULTIMACOMPRA, IMAGEN_CLIENTE, IMAGEN_CEDULA, IMAGEN_CEDULAATRAS, TIPO_CLIENTE, CATEGORIA_CLIENTE, ESTADO_CLIENTE, TOKEN_CLIENTE FROM $tabla WHERE $item = :$item ORDER BY $order ");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

				$stmt -> execute();
				
				return $stmt -> fetchAll();
			
			}else{

	 			$stmt=Conexion::conectar()->prepare("SELECT  COD_CLIENTE,COD_CIUDAD, RUC, CLIENTE, DIRECCION, EMAIL,CELULAR, ULTIMACOMPRA, IMAGEN_CLIENTE, IMAGEN_CEDULA, IMAGEN_CEDULAATRAS, TIPO_CLIENTE, CATEGORIA_CLIENTE, ESTADO_CLIENTE, TOKEN_CLIENTE FROM $tabla");

	 			$stmt->execute();

	 			return $stmt-> fetchAll();
	 		}

	 		$stmt-> close();
			$stmt= null;
		}

		/*============================================================
					MOSTRAR CLIENTE Y CIUDAD CON INNER
 		==============================================================*/

		static public function MdlMostrarClienteCiudad($tabla1, $tabla2, $tabla3, $item, $valor,$var){

			
				$stmt = Conexion::conectar()->prepare("SELECT cl.*, ci.DESCRIPCION_CIUDAD, ci.TOKEN_CIUDAD,ca.* FROM $tabla1 AS cl INNER JOIN $tabla2 AS ci ON cl.COD_CIUDAD = ci.COD_CIUDAD INNER JOIN $tabla3 AS ca ON cl.TIPO_CLIENTE = ca.COD_CANAL WHERE $item = :$item");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

				$stmt -> execute();

		if($item != null && $var!=null){
				
				return $stmt -> fetch();

			}else{

					
	 			return $stmt-> fetchAll();
	 		}

	 		
		}


		/*============================================================
					CREAR CLIENTES
 		==============================================================*/
		static public function mdlIngresarCliente($tabla, $datos){

			// CONSULTAR SI YA HAY UN REGISTRO CON EL MISMO RUC
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE RUC = :ruc");

			$stmt->bindParam(":ruc", $datos["Ruc"], PDO::PARAM_STR);		

			$stmt -> execute();

			$cuenta = $stmt->rowCount();

			// var_dump($datos);

			// return;

			if($cuenta <= 0){

				$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(COD_CIUDAD, RUC, CLIENTE, DIRECCION, EMAIL, EMAIL_ENCRYTADO, CELULAR, FECHA_NACIMIENTO, LATITUD, LONGITUD, IMAGEN_CEDULA, IMAGEN_CEDULAATRAS, IMAGEN_CLIENTE, GARANTE, CED_GARANTE, REFERENCIA_LABORAL, REFERENCIA_PERSONAL, TIPO_CLIENTE, CATEGORIA_CLIENTE, ESTADO_CLIENTE, TOKEN_CLIENTE, USUARIO, CLAVE,FECHA_REGISTRO) VALUES (:ciudad, :ruc, :cliente, :direccion, :email, :emailEncyptado, :celular, :fechaNac, :latitud, :longitud, :cedulaFrontal, :cedulaTrasera, :galeria, :garante, :cedulaGarante, :refLaboral, :refPersonal, :tipoCliente, :categoria, :estado, :tokenCliente, :usuario, :clave,:fecha_registro)");
				
				$stmt->bindParam(":ciudad",($datos["Ciudad"]),PDO::PARAM_STR);
				$stmt->bindParam(":cliente",($datos["Cliente"]),PDO::PARAM_STR);
				$stmt->bindParam(":ruc",$datos["Ruc"],PDO::PARAM_STR);
				$stmt->bindParam(":direccion",$datos["Direccion"],PDO::PARAM_STR);
				$stmt->bindParam(":celular",$datos["ClavesCelular"],PDO::PARAM_STR);
				$stmt->bindParam(":email",$datos["Email"],PDO::PARAM_STR);
				$stmt->bindParam(":emailEncyptado",$datos["EmailEncyptado"],PDO::PARAM_STR);
				$stmt->bindParam(":fechaNac",$datos["FechaNac"],PDO::PARAM_STR);
				$stmt->bindParam(":tipoCliente",$datos["TipoCliente"],PDO::PARAM_STR);
				$stmt->bindParam(":categoria",$datos["Categoria"],PDO::PARAM_STR);
				$stmt->bindParam(":garante",$datos["Garante"],PDO::PARAM_STR);
			    $stmt->bindParam(":cedulaGarante",$datos["CedulaGarante"],PDO::PARAM_STR);
			    $stmt->bindParam(":refLaboral",($datos["ClavesRefLaboral"]),PDO::PARAM_STR);
				$stmt->bindParam(":refPersonal",($datos["ClavesRefPersonal"]),PDO::PARAM_STR);
				$stmt->bindParam(":estado",$datos["Estado"],PDO::PARAM_INT);
				$stmt->bindParam(":galeria",$datos["Galeria"],PDO::PARAM_STR);
				$stmt->bindParam(":cedulaFrontal",$datos["CedulaFrontal"],PDO::PARAM_STR);
				$stmt->bindParam(":cedulaTrasera",$datos["CedulaTrasera"],PDO::PARAM_STR);
				$stmt->bindParam(":latitud",$datos["Latitud"],PDO::PARAM_STR);
				$stmt->bindParam(":longitud",$datos["Longitud"],PDO::PARAM_STR);
			    $stmt->bindParam(":tokenCliente",$datos["TokenCliente"],PDO::PARAM_STR);
			    $stmt->bindParam(":usuario",$datos["Usuario"],PDO::PARAM_STR);
				$stmt->bindParam(":clave",$datos["Clave"],PDO::PARAM_STR);
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
					EDITAR CLIENTE
		=============================================*/

		static public function mdlEditarCliente($tabla, $datos){


			$stmt=Conexion::conectar()->prepare("UPDATE $tabla SET COD_CIUDAD = :ciudad, RUC = :ruc, CLIENTE = :cliente, DIRECCION = :direccion, EMAIL =:email, EMAIL_ENCRYTADO = :emailEncyptado , CELULAR = :celular, FECHA_NACIMIENTO = :fechaNac, LATITUD = :latitud, LONGITUD = :longitud, GARANTE = :garante, CED_GARANTE = :cedulaGarante, REFERENCIA_LABORAL = :refLaboral, REFERENCIA_PERSONAL = :refPersonal, TIPO_CLIENTE = :tipoCliente, CATEGORIA_CLIENTE = :categoria, ESTADO_CLIENTE = :estado, USUARIO =  :usuario, CLAVE =  :clave WHERE TOKEN_CLIENTE = :tokenCliente");
				
				$stmt->bindParam(":ciudad",($datos["Ciudad"]),PDO::PARAM_STR);
				$stmt->bindParam(":cliente",($datos["Cliente"]),PDO::PARAM_STR);
				$stmt->bindParam(":ruc",$datos["Ruc"],PDO::PARAM_STR);
				$stmt->bindParam(":direccion",$datos["Direccion"],PDO::PARAM_STR);
				$stmt->bindParam(":celular",$datos["ClavesCelular"],PDO::PARAM_STR);
				$stmt->bindParam(":email",$datos["Email"],PDO::PARAM_STR);
				$stmt->bindParam(":emailEncyptado",$datos["EmailEncyptado"],PDO::PARAM_STR);
				$stmt->bindParam(":fechaNac",$datos["FechaNac"],PDO::PARAM_STR);
				$stmt->bindParam(":tipoCliente",$datos["TipoCliente"],PDO::PARAM_STR);
				$stmt->bindParam(":categoria",$datos["Categoria"],PDO::PARAM_STR);
				$stmt->bindParam(":garante",$datos["Garante"],PDO::PARAM_STR);
			    $stmt->bindParam(":cedulaGarante",$datos["CedulaGarante"],PDO::PARAM_STR);
			    $stmt->bindParam(":refLaboral",($datos["ClavesRefLaboral"]),PDO::PARAM_STR);
				$stmt->bindParam(":refPersonal",($datos["ClavesRefPersonal"]),PDO::PARAM_STR);
				$stmt->bindParam(":estado",$datos["Estado"],PDO::PARAM_INT);
				// $stmt->bindParam(":galeria",$datos["Galeria"],PDO::PARAM_STR);
				// $stmt->bindParam(":cedulaFrontal",$datos["CedulaFrontal"],PDO::PARAM_STR);
				// $stmt->bindParam(":cedulaTrasera",$datos["CedulaTrasera"],PDO::PARAM_STR);
				$stmt->bindParam(":latitud",$datos["Latitud"],PDO::PARAM_STR);
				$stmt->bindParam(":longitud",$datos["Longitud"],PDO::PARAM_STR);
			    $stmt->bindParam(":tokenCliente",$datos["TokenCliente"],PDO::PARAM_STR);
			    $stmt->bindParam(":usuario",$datos["Usuario"],PDO::PARAM_STR);
				$stmt->bindParam(":clave",$datos["Clave"],PDO::PARAM_STR);

			if($stmt -> execute()){

				return "ok";
			
			}else{

				return "error";	

			}

			$stmt -> close();
			$stmt = null;

		}

		/*=============================================
					ELIMINAR CLIENTE
		=============================================*/

		static public function mdlEliminarCliente($tabla, $item, $valor){

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

		/*============================================================
					ACTUALIZAR CLIENTES
 		==============================================================*/

		static public function mdlActualizarCliente($tabla, $item, $valor){

			// var_dump($tabla, $item, $valor);
			// return;

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET ESTADO_CLIENTE = 0 WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			if($stmt -> execute()){

				return "ok";
			
			}else{

				return "error";	

			}

			$stmt -> close();

			$stmt = null;

		}

	}

