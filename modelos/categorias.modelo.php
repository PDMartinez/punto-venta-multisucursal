<?php 
 require_once "conexion.php";

 /**
  * 
  */
 class ModeloCategorias
 {
 	/*============================================================
		MODELO CATEGORIA PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlIngresarCategoria($tabla,$datos,$item)
 	{
 	
 		$stmt = Conexion::conectar()->prepare("SELECT $item FROM $tabla WHERE $item = :$item");
           			
		$stmt -> bindParam(":$item",$datos["categoria"], PDO::PARAM_STR);
		$stmt -> execute();
		$cuenta = $stmt->rowCount();
		// var_dump($cuenta);
		if($cuenta<=0){
	 		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(NOMBRE_CATEGORIA,FECHA_CATEGORIA,TOKEN_CATEGORIA) VALUES (:categoria,:fecha_registro,:token)");
		   $stmt->bindParam(":categoria",$datos["categoria"],PDO::PARAM_STR);
		   $stmt->bindParam(":fecha_registro",$datos["fecha_registro"],PDO::PARAM_STR);
		   $stmt->bindParam(":token",$datos["token"],PDO::PARAM_STR);
		  
			   if ($stmt-> execute())
			   {

					return "ok";
			   }
					else

			   {
			   	return "error";
			   		
			   }


		}else
		{
				return "exist";
		}
	
	
}


	/*============================================================
		MODELO CIUDADES PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlMostrarCategoria($tabla,$item,$valor,$order)
 	{
 		
 		if($item != null)
 		{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
           			
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


 		/*=============================================
	EDITAR CIUDADES
	=============================================*/

	static public function mdlEditarCategoria($tabla, $datos,$item){

		$consulta = Conexion::conectar()->prepare("SELECT $item FROM $tabla WHERE $item = :$item");
           			
		$consulta -> bindParam(":$item", $datos["categoria"], PDO::PARAM_STR);
		$consulta -> execute();
		$cuenta = $consulta->rowCount();
		// var_dump($cuenta);
		if($cuenta<=0){

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET NOMBRE_CATEGORIA = :categoria WHERE TOKEN_CATEGORIA = :token");
			//var_dump($stmt);
			$stmt -> bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);
			$stmt -> bindParam(":token", $datos["token"], PDO::PARAM_STR);
	
				if($stmt->execute()){

					return "ok";

				}else{

					return "error";
				
				}
			
		}else{
		
			return "exist";
		}
		

	}

	

 }