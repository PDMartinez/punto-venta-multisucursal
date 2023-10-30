<?php 
 require_once "conexion.php";

 /**
  * 
  */
 class ModeloFormaPagos
 {
 	/*============================================================
		MODELO CATEGORIA PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlIngresarFormaPago($tabla,$datos,$item)
 	{
 	
 		$stmt = Conexion::conectar()->prepare("SELECT $item FROM $tabla WHERE $item = :$item");
           			
		$stmt -> bindParam(":$item",$datos["formapagos"], PDO::PARAM_STR);
		$stmt -> execute();
		$cuenta = $stmt->rowCount();
		// var_dump($cuenta);
		if($cuenta<=0){
	 		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(DESCRIPCION_FORMA,EFECTIVO,TOKEN_FORMAPAGO) VALUES (:formapagos,:activoefectivo,:token)");
		   $stmt->bindParam(":formapagos",$datos["formapagos"],PDO::PARAM_STR);
		    $stmt->bindParam(":activoefectivo",$datos["activoefectivo"],PDO::PARAM_STR);
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
 	static function mdlMostrarFormapago($tabla,$item,$valor,$item1,$valor1,$order)
 	{
 		
 		if($item != null && $item1 != null)
 		{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND  $item1 = :$item1  ORDER BY $order ");
           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":$item1",  $valor1, PDO::PARAM_STR);


			$stmt -> execute();
						
			return $stmt -> fetch();

		}else if($item1 != null){
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item1 = :$item1 ORDER BY $order ");
            // $nuevo=Conexion::decryption($valor);
			
			$stmt -> bindParam(":$item1",  $valor1, PDO::PARAM_STR);

			$stmt -> execute();
			
			return $stmt -> fetchAll();

		}else if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
            // $nuevo=Conexion::decryption($valor);
			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
			
			return $stmt -> fetch();
			
		}else
 		{
 			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $order ");
 			$stmt->execute();
 			// echo '<pre>'; print_r($stmt); echo '</pre>';
 			return $stmt-> fetchAll();
 		}
 		$stmt-> close();
		$stmt= null;
 	}


 		/*=============================================
	EDITAR CIUDADES
	=============================================*/

	static public function mdlEditarFormapago($tabla, $datos,$item){

		$consulta = Conexion::conectar()->prepare("SELECT $item FROM $tabla WHERE $item = :$item");
           			
		$consulta -> bindParam(":$item", $datos["formapagos"], PDO::PARAM_STR);
		$consulta -> execute();
		$cuenta = $consulta->rowCount();
		// var_dump($cuenta);
		if($cuenta>0){

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET EFECTIVO=:activoefectivo WHERE TOKEN_FORMAPAGO = :token");
			//var_dump($stmt);
			
			$stmt -> bindParam(":activoefectivo", $datos["activoefectivo"], PDO::PARAM_STR);
			$stmt -> bindParam(":token", $datos["token"], PDO::PARAM_STR);
	
				if($stmt->execute()){

					return "ok";

				}else{

					return "error";
				
				}
			
		}else{

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET DESCRIPCION_FORMA = :formapagos,EFECTIVO=:activoefectivo WHERE TOKEN_FORMAPAGO = :token");
			//var_dump($stmt);
			$stmt -> bindParam(":formapagos", $datos["formapagos"], PDO::PARAM_STR);
			$stmt -> bindParam(":activoefectivo", $datos["activoefectivo"], PDO::PARAM_STR);
			$stmt -> bindParam(":token", $datos["token"], PDO::PARAM_STR);
	
				if($stmt->execute()){

					return "ok";

				}else{

					return "error";
				
				}
		
			
		}
		

	}

	

 }