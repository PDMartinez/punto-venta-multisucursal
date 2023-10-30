<?php 
 require_once "conexion.php";

 /**
  * 
  */
 class ModeloPerfiles
 {
 	/*============================================================
		MODELO CATEGORIA PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlIngresarPerfil($tabla,$datos,$item)
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
	 		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(NOMBRE_PERFIL,TOKEN_PERFIL,SUPER_PERFIL,DESCRIPCION_PERFIL,ESTADO_PERFIL) VALUES (:perfil,:token,:activo,:descripcion,:estado)");
		   $stmt->bindParam(":perfil",$datos["perfil"],PDO::PARAM_STR);
		   $stmt->bindParam(":token",$datos["token"],PDO::PARAM_STR);
		   $stmt->bindParam(":activo",$datos["activo"],PDO::PARAM_INT);
		   $stmt->bindParam(":descripcion",$datos["descripcion"],PDO::PARAM_STR);
		   $stmt->bindParam(":estado",$datos["estado"],PDO::PARAM_STR);
		
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
 	static function mdlMostrarPerfil($tabla,$item,$valor,$var,$order)
 	{
 		
 		if($valor != null && $var!=null)
 		{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
			
			return $stmt -> fetch();

		}else if($valor != null && $var==null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
           			
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


 		/*=============================================
	EDITAR PERFILES
	=============================================*/

	static public function mdlEditarPerfil($tabla, $datos,$item){

		$validar=false;
		$consulta = Conexion::conectar()->prepare("SELECT $item FROM $tabla WHERE $item = 1");
      	$consultaToken = Conexion::conectar()->prepare("SELECT SUPER_PERFIL FROM $tabla WHERE TOKEN_PERFIL =:token");
      	$consultaToken -> bindParam(":token", $datos["token"], PDO::PARAM_STR);
		//$consulta -> bindParam(":$item", $datos["sucursal"], PDO::PARAM_STR);
		$consulta -> execute();
		$consultaToken -> execute();
		$retistro=$consultaToken -> fetch();	
		//var_dump($retistro);
		$cuenta = $consulta->rowCount();
	//var_dump($retistro["SUPER_PERFIL"]);

		if($cuenta==0 && $datos["principal"]==0 ){
        $validar=false;
       
        }else if($cuenta==0 && $datos["principal"]==1) {
          $validar=true;
        
        }else if($cuenta==1 && $datos["principal"]==0 && $retistro["SUPER_PERFIL"]==0) {
          $validar=true;
         // var_dump($validar);
  		
        }else if($cuenta==1 && $datos["principal"]==0 && $retistro["SUPER_PERFIL"]==1) {
          $validar=false;
        // var_dump($validar);
        }else if ($cuenta==1 && $datos["principal"]==1){
           $validar=true;
          
        }else if($cuenta>1){
          $validar=true;
         
        }



		if($validar==true){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET NOMBRE_PERFIL = :perfil,SUPER_PERFIL=:activo,DESCRIPCION_PERFIL=:descripcion,ESTADO_PERFIL=:estado WHERE TOKEN_PERFIL = :token");
		//var_dump($stmt);
		$stmt -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":token", $datos["token"], PDO::PARAM_STR);
		$stmt -> bindParam(":activo", $datos["activo"], PDO::PARAM_INT);
		$stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		 $stmt->bindParam(":estado",$datos["estado"],PDO::PARAM_STR);

			if($stmt->execute()){

				return "ok";

			}else{

				return "error";
			
			}

		}else{
			return "principal";
		}
		

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function mdlBorrarPerfil($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE COD_PERFIL = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

 }