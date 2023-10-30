<?php 
 require_once "conexion.php";

 /**
  * 
  */
 class ModeloSubCategorias
 {
 	/*============================================================
		MODELO SUB CATEGORIAS PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlIngresarSubCategoria($tabla,$datos,$item)
 	{
 	
 		$stmt = Conexion::conectar()->prepare("SELECT $item FROM $tabla WHERE $item = :$item");
           			
		$stmt -> bindParam(":$item",$datos["subcategoria"], PDO::PARAM_STR);
		$stmt -> execute();
		$cuenta = $stmt->rowCount();
		// var_dump($cuenta);
		if($cuenta<=0){
	 		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(NOMBRE_SUBCATEGORIA,TOKEN_SUBCATEGORIA,FECHA_SUBCATEGORIA) VALUES (:subcategoria,:token,:fecha_registro)");
		   $stmt->bindParam(":subcategoria",$datos["subcategoria"],PDO::PARAM_STR);
		   $stmt->bindParam(":token",$datos["token"],PDO::PARAM_STR);
		   $stmt->bindParam(":fecha_registro",$datos["fecha_registro"],PDO::PARAM_STR);
		   
		  
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
		MODELO SUB CATEGORIAS PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlMostrarSubCategoria($tabla,$item,$valor,$order)
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
	EDITAR SUB CATEGORIAS
	=============================================*/

	static public function mdlEditarSubCategoria($tabla, $datos,$item){

		$consulta = Conexion::conectar()->prepare("SELECT $item FROM $tabla WHERE $item = :$item");
           			
		$consulta -> bindParam(":$item", $datos["subcategoria"], PDO::PARAM_STR);
		$consulta -> execute();
		$cuenta = $consulta->rowCount();
		// var_dump($cuenta);
		if($cuenta<=0){

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET NOMBRE_SUBCATEGORIA = :subcategoria WHERE TOKEN_SUBCATEGORIA = :token");
			//var_dump($stmt);
			$stmt -> bindParam(":subcategoria", $datos["subcategoria"], PDO::PARAM_STR);
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