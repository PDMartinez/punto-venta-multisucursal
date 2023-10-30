<?php 
 require_once "conexion.php";

 /**
  * 
  */
 class ModeloCiudades
 {
 	/*============================================================
		MODELO CATEGORIA PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlIngresarCiudad($tabla,$datos,$item)
 	{
 	
 		$stmt = Conexion::conectar()->prepare("SELECT $item FROM $tabla WHERE $item = :$item");
           			
		$stmt -> bindParam(":$item",  $datos["ciudad"], PDO::PARAM_STR);
		$stmt -> execute();
		$cuenta = $stmt->rowCount();
		// var_dump($cuenta);
		if($cuenta<=0){
	 		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(DESCRIPCION_CIUDAD,TOKEN_CIUDAD) VALUES (:ciudad,:token)");
		   $stmt->bindParam(":ciudad",$datos["ciudad"],PDO::PARAM_STR);
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
 	static function mdlMostrarCiudad($tabla,$item,$valor,$order)
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

	static public function mdlEditarCiudad($tabla, $datos,$item){

		$consulta = Conexion::conectar()->prepare("SELECT $item FROM $tabla WHERE $item = :$item");
           			
		$consulta -> bindParam(":$item", $datos["ciudad"], PDO::PARAM_STR);
		$consulta -> execute();
		$cuenta = $consulta->rowCount();
		// var_dump($cuenta);
		if($cuenta<=0){

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET DESCRIPCION_CIUDAD = :ciudad WHERE TOKEN_CIUDAD = :token");
			//var_dump($stmt);
			$stmt -> bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
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