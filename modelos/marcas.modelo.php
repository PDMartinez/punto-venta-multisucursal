<?php 
 require_once "conexion.php";

 /**
  * 
  */
 class ModeloMarcas
 {
 	/*============================================================
		MODELO MARCAS PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlIngresarMarca($tabla,$datos)
 	{
 	
 			$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(NOMBRE_MARCA,FECHA_MARCA,TOKEN_MARCA) VALUES (:marcas,:fecha_registro,:token)");
		   $stmt->bindParam(":marcas",$datos["marcas"],PDO::PARAM_STR);
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
	
}


	/*============================================================
		MODELO MARCAS PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlMostrarMarca($tabla,$item,$valor,$order)
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
	EDITAR MARCAS
	=============================================*/

	static public function mdlEditarMarca($tabla, $datos,$item){
		
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET NOMBRE_MARCA = :Marca WHERE TOKEN_MARCA = :token");
			//var_dump($stmt);
			$stmt -> bindParam(":Marca", $datos["Marca"], PDO::PARAM_STR);
			$stmt -> bindParam(":token", $datos["token"], PDO::PARAM_STR);
	
				if($stmt->execute()){

					return "ok";

				}else{

					return "error";
				
				}

	}

	

 }