<?php 
 require_once "conexion.php";
/**
 * 
 */
class ModeloVarios
{
			const METHOD="AES-256-CBC";
			const SECRET_KEY='$marcos@2020';
			const SECRET_IV='101712';
	/*============================================================
		MODELO PERFIL PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlMostrarVario($tabla,$item,$valor,$order)
 	{
 		
 		if($item != null)
 		{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
            // $nuevo=Conexion::decryption($valor);
			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
			
			return $stmt -> fetch();

		}else
 		{
 			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $order ");
 			$stmt->execute();
 			return $stmt-> fetchAll();
 		}
 		$stmt-> close();
		$stmt= null;
 	}

 	static function mdlExtraerMaximo($tabla,$item)
 	{
 		
 		//$stmt = Conexion::conectar()->prepare("SELECT if(MAX($item) != '', MAX($item)+1, 1) AS maximo FROM $tabla");
 		$stmt = Conexion::conectar()->prepare("SELECT `AUTO_INCREMENT` AS maximo FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '$tabla'");
				//$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);
		$stmt -> execute();	
		return $stmt -> fetch();
 	}

	

 	/*============================================================
		MODELO PERFIL PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlMostrarCantidad($tabla,$item,$valor,$order)
 	{
 		
 			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $order ");
 			$stmt->execute();
 			return $stmt-> fetch();
 		
 	}


	/*=============================================
	BORRAR
	=============================================*/

	static public function mdlEliminarVario($tabla,$item, $datos){
//try {
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :id");

			$stmt -> bindParam(":id",$datos, PDO::PARAM_STR);
	 		 
	 	//throw new ConfigFileNotFoundException($stmt -> execute());

			
			if($stmt -> execute()){

				return "ok";
			
			}else{
			
				 "\nPDO::errorInfo():\n";
   				return ($stmt->errorInfo());

			}



	}

	/*=============================================
	ACTUALIZAR ESTADO
	=============================================*/

	static public function mdlActualizarVario($tabla, $item1,$valor1,$item2,$valor2)
	{

	$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1=:$item1 WHERE $item2=:$item2");
		
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

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

// VALIDAR DATOS SI YA EXISTE O NO
	static public function MdlValidarDatos($tabla,$item,$valor)
		{

			$stmt=Conexion::conectar()->prepare("SELECT $tabla.$item FROM $tabla WHERE $item= :$item");
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			 $stmt-> execute();
					//echo var_dump($stmt);
			$cuenta = $stmt->rowCount();
			// var_dump($cuenta);
			if($cuenta>0){

				 return true;
			}else{

				return false;
		
			}

		}


		// VALIDAR DATOS SI YA EXISTE O NO
	static public function MdlValidarDatosInner($tabla,$tabla1,$columna,$item,$valor,$item1,$valor1)
		{

			$stmt=Conexion::conectar()->prepare("SELECT $tabla.$item FROM $tabla INNER JOIN $tabla1 ON $tabla.$columna=$tabla1.$columna WHERE $item= :$item and $item1=:$item1");
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
			 $stmt-> execute();
			//echo var_dump($stmt);
			$cuenta = $stmt->rowCount();
			// var_dump($cuenta);
			if($cuenta>0){

				 return true;
			}else{

				return false;
		
			}

		}



		static public function mdlConsultarColumnas($tabla,$item,$valor,$select,$where){

			if ($where!=null){
				$stmt=Conexion::conectar()->prepare("SELECT $select FROM $tabla WHERE $item=:$item ");
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt-> execute();
			return $stmt -> fetch(PDO::FETCH_CLASS);

			}else{

				$stmt=Conexion::conectar()->prepare("SELECT $select FROM $tabla ");
	
			$stmt-> execute();
			return $stmt -> fetch();
			}

		

	}




	
}
