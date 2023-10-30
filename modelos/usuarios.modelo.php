<?php 

require_once "conexion.php";


class ModelosUsuarios
{
	
			/**
	 PARA SELECCIONAR EL USUARIO DEL LOGIN
	 */

	static public function MdlMostrarUsuarioInner($tabla,$item,$valor,$order)
		{

			if($item != null)
			{
				$stmt=Conexion::conectar()->prepare("SELECT u.COD_USUARIO,p.COD_PERFIL,s.COD_SUCURSAL,f.COD_FUNCIONARIO,USUARIO,HORA_DESDE,HORA_HASTA, FOTO_USUARIO,NRO_INTENTO,ESTADO_USUARIO,SUCURSAL,NOMBRE_PERFIL,NOMBRE_FUNC,ULTIMO_LOGIN,CEDULA_FUNC,TOKEN_USUARIO,TOKEN_SUCURSAL,TOKEN_FUNCIONARIO,TOKEN_PERFIL,NRO_INTENTO,CLAVE,IMAGEN_SUC,SUPER_PERFIL,ESTADO_SUCURSAL FROM $tabla as u INNER JOIN perfiles as p ON p.COD_PERFIL=u.COD_PERFIL INNER JOIN sucursales as s ON s.COD_SUCURSAL=u.COD_SUCURSAL INNER JOIN funcionarios AS f ON f.COD_FUNCIONARIO=u.COD_FUNCIONARIO WHERE $item= :$item ORDER BY $order");
				$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
				$stmt-> execute();
				//echo var_dump($stmt);
				return $stmt -> fetch();

			}else{
 			$stmt=Conexion::conectar()->prepare("SELECT  u.COD_USUARIO,p.COD_PERFIL,s.COD_SUCURSAL,f.COD_FUNCIONARIO,USUARIO,HORA_DESDE,HORA_HASTA, FOTO_USUARIO,NRO_INTENTO,ESTADO_USUARIO,SUCURSAL,NOMBRE_PERFIL,NOMBRE_FUNC,ULTIMO_LOGIN,CEDULA_FUNC,TOKEN_USUARIO,TOKEN_SUCURSAL,TOKEN_FUNCIONARIO,TOKEN_PERFIL,NRO_INTENTO,CLAVE,IMAGEN_SUC,SUPER_PERFIL,ESTADO_SUCURSAL FROM $tabla as u INNER JOIN perfiles as p ON p.COD_PERFIL=u.COD_PERFIL INNER JOIN sucursales as s ON s.COD_SUCURSAL=u.COD_SUCURSAL INNER JOIN funcionarios AS f ON f.COD_FUNCIONARIO=u.COD_FUNCIONARIO ORDER BY $order");
 			$stmt->execute();
 			return $stmt-> fetchAll();
 		}
	 		$stmt-> close();
			$stmt= null;
		}


		/**
	 REGISTRO DE USUARIO
	 */
	static public function mdlIngresarUsuario($tabla,$datos,$item)
	{

		 $validar=false;

 		$consulta = Conexion::conectar()->prepare("SELECT $item FROM $tabla INNER JOIN perfiles ON $tabla.COD_PERFIL=perfiles.COD_PERFIL WHERE $item = 1");
           			
		//$stmt -> bindParam(":$item",  $datos["sucursal"], PDO::PARAM_STR);
		$consulta -> execute();
		$cuenta = $consulta->rowCount();
		// var_dump($cuenta);
		if($cuenta==0 && $datos["perfilDesc"]==0 ){
        $validar=false;
      
        }else if($cuenta==0 && $datos["perfilDesc"]==1) {
          $validar=true;
          
        }else if($cuenta==1 && $datos["perfilDesc"]==0) {
          $validar=true;
         
        }else if ($cuenta==1 && $datos["perfilDesc"]==1){
           $validar=true;
          
        }else if($cuenta>1){
          $validar=true;
         
        }



		if($validar==true){

		$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(COD_PERFIL,COD_SUCURSAL,COD_FUNCIONARIO, USUARIO,CLAVE,HORA_DESDE,HORA_HASTA,ESTADO_USUARIO,TOKEN_USUARIO,FECHA) VALUES (:perfil,:sucursal,:funcionario,:usuario,:clave,:horadesde,:horahasta,:estado,:token,:fecha_registro)");
		
		$stmt->bindParam(":perfil",($datos["perfil"]),PDO::PARAM_STR);
	   $stmt->bindParam(":sucursal",($datos["sucursal"]),PDO::PARAM_STR);
	   $stmt->bindParam(":funcionario",$datos["funcionario"],PDO::PARAM_STR);
	   $stmt->bindParam(":usuario",$datos["usuario"],PDO::PARAM_STR);
	   $stmt->bindParam(":clave",$datos["clave"],PDO::PARAM_STR);
	   $stmt->bindParam(":horadesde",$datos["horadesde"],PDO::PARAM_STR);
	   $stmt->bindParam(":horahasta",$datos["horahasta"],PDO::PARAM_STR);
	   $stmt->bindParam(":estado",$datos["estado"],PDO::PARAM_STR);
	   $stmt->bindParam(":token",$datos["token"],PDO::PARAM_STR);
	    $stmt->bindParam(":fecha_registro",$datos["fecha_registro"],PDO::PARAM_STR);

			 //  var_dump($stmt);
			   if ($stmt-> execute())
			   {
					return "ok";
			   }else

			   {
			   		return "error";
			   }
			
		}else
		{
				return "principal";
		}

	}


	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function mdlEditarUsuario($tabla, $datos,$item)
	{

		$validar=false;
		$consulta = Conexion::conectar()->prepare("SELECT $item FROM $tabla INNER JOIN perfiles ON $tabla.COD_PERFIL=perfiles.COD_PERFIL WHERE $item = 1");
		//var_dump($datos);
     $consultaToken = Conexion::conectar()->prepare("SELECT $item FROM $tabla INNER JOIN perfiles ON $tabla.COD_PERFIL=perfiles.COD_PERFIL WHERE TOKEN_USUARIO =:token");
      	$consultaToken -> bindParam(":token", $datos["token"], PDO::PARAM_STR);
		$consulta -> execute();
		$consultaToken -> execute();
		$retistro=$consultaToken -> fetch();	
		//var_dump($retistro);
		$cuenta = $consulta->rowCount();
	//var_dump($cuenta);

		if($cuenta==0 && $datos["perfilDesc"]=="Usuario" ){
        $validar=false;
      
        }else if($cuenta==0 && $datos["perfilDesc"]=="Administrador") {
          $validar=true;
          
        }else if($cuenta==1 && $datos["perfilDesc"]=="Usuario" && $retistro["SUPER_PERFIL"]==0) {
          $validar=true;

        }else if($cuenta==1 && $datos["perfilDesc"]=="Usuario" && $retistro["SUPER_PERFIL"]==1) {
          $validar=false;
         
        }else if ($cuenta==1 && $datos["perfilDesc"]=="Administrador"){
           $validar=true;
          
        }else if($cuenta>1){
          $validar=true;
         
        }



		if($validar==true){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET COD_PERFIL=:perfil,COD_SUCURSAL=:sucursal,COD_FUNCIONARIO=:funcionario,HORA_DESDE=:horadesde,HORA_HASTA=:horahasta,USUARIO=:usuario,ESTADO_USUARIO=:estado WHERE TOKEN_USUARIO = :token");

		$stmt -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":sucursal", $datos["sucursal"], PDO::PARAM_STR);
		$stmt -> bindParam(":funcionario", $datos["funcionario"], PDO::PARAM_STR);
		$stmt -> bindParam(":horadesde", $datos["horadesde"], PDO::PARAM_STR);
		$stmt -> bindParam(":horahasta", $datos["horahasta"], PDO::PARAM_STR);
		$stmt -> bindParam(":token", $datos["token"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
						
				if($stmt -> execute())
				{
					return "ok";
				
				}else
				{

					return "error";	

				}

			}else{
			return "principal";
		}

	}


	/*=============================================
	ACTUALIZAR ESTADO DE USUARIO
	=============================================*/

	static public function mdlActualizarUsuario($tabla, $item1,$valor1,$item2,$valor2)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

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

}