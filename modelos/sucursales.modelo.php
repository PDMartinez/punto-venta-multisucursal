<?php 
 require_once "conexion.php";

 /**
  * 
  */
 class ModeloSucursales
 {
 	/*============================================================
		MODELO CATEGORIA PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlIngresarSucursal($tabla,$datos,$item)
 	{
 $validar=false;

 		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = 1");
           			
		//$stmt -> bindParam(":$item",  $datos["sucursal"], PDO::PARAM_STR);
		$stmt -> execute();
		$cuenta = $stmt->rowCount();
		// var_dump($cuenta);
			if($cuenta==0 && $datos["principal"]==0 ){
        $validar=false;
      
        }else if($cuenta==0 && $datos["principal"]==1) {
          $validar=true;
          
        }else if($cuenta==1 && $datos["principal"]==0) {
          $validar=true;
         
        }else if ($cuenta==1 && $datos["principal"]==1){
           $validar=true;
          
        }else if($cuenta>1){
          $validar=true;
         
        }



		if($validar==true){

	 		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(COD_CIUDAD,SUCURSAL,DIRECCION,ENCARGADO,NROVERIFICADOR,NROPEDIDO,NROREMISION,TELEFONO_SUC,ESTADO_SUCURSAL,TOKEN_SUCURSAL,IMAGEN_SUC,PRINCIPAL,RUC) VALUES (:ciudad,:sucursal,:direccion,:encargado,:verificador,:pedidos,:remision,:telefono,:estado,:token,:imagen,:principal,:ruc)");
	 	   $stmt->bindParam(":ciudad",$datos["ciudad"],PDO::PARAM_STR);
		   $stmt->bindParam(":sucursal",$datos["sucursal"],PDO::PARAM_STR);
		   $stmt->bindParam(":direccion",$datos["direccion"],PDO::PARAM_STR);
		   $stmt->bindParam(":encargado",$datos["encargado"],PDO::PARAM_STR);
		   $stmt->bindParam(":verificador",$datos["verificador"],PDO::PARAM_INT);
		   $stmt->bindParam(":pedidos",$datos["pedidos"],PDO::PARAM_INT);
 		   $stmt->bindParam(":remision",$datos["remision"],PDO::PARAM_INT);
		   $stmt->bindParam(":telefono",$datos["telefono"],PDO::PARAM_STR);
		   $stmt->bindParam(":estado",$datos["estado"],PDO::PARAM_INT);
		   $stmt->bindParam(":token",$datos["token"],PDO::PARAM_STR);
		   $stmt->bindParam(":imagen",$datos["imagen"],PDO::PARAM_STR);
		    $stmt->bindParam(":ruc",$datos["ruc"],PDO::PARAM_STR);
		   $stmt->bindParam(":principal",$datos["principal"],PDO::PARAM_STR);
		

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
				return "principal";
		}
	
	
}


	/*============================================================
		MODELO PERFIL PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlMostrarSucursal($tabla,$item,$valor,$var,$order)
 	{
 		
 		if($valor != null && $var!=null)
 		{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
			
			return $stmt -> fetch();

		}elseif($valor != null && $var==null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
			
			return $stmt -> fetchAll();
		}else

 		{
 			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $order ");
 			$stmt->execute();
 			return $stmt-> fetchAll();
 		}
 		$stmt-> close();
		$stmt= null;
 	}


 	/*============================================================
		MODELO SUCURSAL PARA MOSTRAR DATOS CON INNER JOIN
 	==============================================================*/
 	static function mdlMostrarSucursalInner($tabla,$tabla1,$item,$valor,$order)
 	{
 		
 		if($valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT $tabla.*, $tabla1.* FROM $tabla INNER JOIN $tabla1 ON $tabla.COD_CIUDAD = $tabla1.COD_CIUDAD WHERE $item = :token");

			$stmt -> bindParam(":token", $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT $tabla.*, $tabla1.* FROM $tabla INNER JOIN $tabla1 ON $tabla.COD_CIUDAD = $tabla1.COD_CIUDAD ORDER BY $order DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;
 	}


 		/*=============================================
	EDITAR PERFILES
	=============================================*/

	static public function mdlEditarSucursal($tabla, $datos,$item){
		$validar=false;
		$consulta = Conexion::conectar()->prepare("SELECT $item FROM $tabla WHERE $item = 1");

     $consultaToken = Conexion::conectar()->prepare("SELECT $item FROM $tabla WHERE TOKEN_SUCURSAL =:token");
      	$consultaToken -> bindParam(":token", $datos["token"], PDO::PARAM_STR);
		$consulta -> execute();
		$consultaToken -> execute();
		$retistro=$consultaToken -> fetch();	
		//var_dump($retistro);
		$cuenta = $consulta->rowCount();
	// var_dump($consulta);

			if($cuenta==0 && $datos["principal"]==0 ){
        $validar=false;
      
        }else if($cuenta==0 && $datos["principal"]==1) {
          $validar=true;
          
        }else if($cuenta==1 && $datos["principal"]==0 && $retistro["PRINCIPAL"]==0) {
          $validar=true;

        }else if($cuenta==1 && $datos["principal"]==0 && $retistro["PRINCIPAL"]==1) {
          $validar=false;
         
        }else if ($cuenta==1 && $datos["principal"]==1){
           $validar=true;
          
        }else if($cuenta>1){
          $validar=true;
         
        }



		if($validar==true){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET COD_CIUDAD=:ciudad,SUCURSAL = :sucursal,DIRECCION=:direccion,ENCARGADO=:encargado,NROVERIFICADOR=:verificador,NROPEDIDO=:pedidos,NROREMISION=:remision,TELEFONO_SUC=:telefono,ESTADO_SUCURSAL=:estado,IMAGEN_SUC=:imagen,PRINCIPAL=:principal,RUC=:ruc WHERE TOKEN_SUCURSAL = :token");
		//var_dump($datos);
		   $stmt->bindParam(":ciudad",$datos["ciudad"],PDO::PARAM_STR);
		   $stmt->bindParam(":sucursal",$datos["sucursal"],PDO::PARAM_STR);
		   $stmt->bindParam(":direccion",$datos["direccion"],PDO::PARAM_STR);
		   $stmt->bindParam(":encargado",$datos["encargado"],PDO::PARAM_STR);
		   $stmt->bindParam(":verificador",$datos["verificador"],PDO::PARAM_INT);
		   $stmt->bindParam(":pedidos",$datos["pedidos"],PDO::PARAM_INT);
 		   $stmt->bindParam(":remision",$datos["remision"],PDO::PARAM_INT);
		   $stmt->bindParam(":telefono",$datos["telefono"],PDO::PARAM_STR);
		   $stmt->bindParam(":estado",$datos["estado"],PDO::PARAM_INT);
		  $stmt->bindParam(":token",$datos["token"],PDO::PARAM_STR);
		   $stmt->bindParam(":imagen",$datos["imagen"],PDO::PARAM_STR);
		   $stmt->bindParam(":ruc",$datos["ruc"],PDO::PARAM_STR);
		   $stmt->bindParam(":principal",$datos["principal"],PDO::PARAM_STR);

			if($stmt->execute()){

				return "ok";

			}else{

				return "error";
			
			}
			
		}else{
			return "principal";
		}
	}

	

 }