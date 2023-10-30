<?php 
 require_once "conexion.php";

 /**
  * 
  */
 class ModeloFuncionarios
 {
 	/*============================================================
		MODELO FUNCIONARIOS PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlIngresarFuncionario($tabla,$datos)
 	{
 		$stmt = Conexion::conectar()->prepare("INSERT INTO funcionarios(NOMBRE_FUNC,CEDULA_FUNC,DIRECCION,CIUDAD,TELEFONO_FUNC, SUELDO,TIPO_FUNC,EST_FUNCIONARIO,TOKEN_FUNCIONARIO) VALUES (:nombre,:documento,:direccion, :ciudad, :celular,:sueldo,:tipo,:estado,:token)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
		$stmt->bindParam(":sueldo", $datos["sueldo"], PDO::PARAM_STR);
		$stmt->bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
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
	EDITAR FUNCIONARIO
	=============================================*/

	static public function mdlEditarFuncionario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET NOMBRE_FUNC=:nombre ,CEDULA_FUNC=:documento ,DIRECCION=:direccion ,CIUDAD=:ciudad ,TELEFONO_FUNC=:celular,SUELDO=:sueldo ,TIPO_FUNC=:tipo  WHERE TOKEN_FUNCIONARIO= :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
		$stmt->bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
		$stmt->bindParam(":sueldo", $datos["sueldo"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static function mdlMostrarFuncionario($tabla,$item,$valor,$var,$order)
 	{
 		
 		if($valor != null && $var!=null)
 		{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
            // $nuevo=Conexion::decryption($valor);
			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
			
			return $stmt -> fetch();

		}else if ($valor != null && $var==null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
            // $nuevo=Conexion::decryption($valor);
			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
			
			return $stmt -> fetchAll();
		}
		else
 		{
 			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $order ");
 			$stmt->execute();
 			return $stmt-> fetchAll();
 		}
 		$stmt-> close();
		$stmt= null;
 	}


 }