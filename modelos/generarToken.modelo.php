<?php 

	require_once "conexion.php";

	class ModeloGenerarToken{
		
			
					

		/*============================================================
					CREAR Aperturas
 		==============================================================*/
		static public function mdlIngresartoken($tabla, $columana,$columanaPrimari){
			$variable= false;
			
			$consulta = Conexion::conectar()->prepare("SELECT  $columanaPrimari FROM $tabla ");
           			
		//$stmt -> bindParam(":$item",  $datos["sucursal"], PDO::PARAM_STR);
			$consulta -> execute();
			//echo '<pre>'; print_r($consulta); echo '</pre>';
			//echo '<pre>'; print_r($cuenta); echo '</pre>';

			foreach ($consulta as $key => $value) {
					// echo '<pre>'; print_r($value[$columanaPrimari]); echo '</pre>';
					// return false;
			  	$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,$columanaPrimari);
				$token=bin2hex(random_bytes(16));//se genera el token
				$token=$token.$ValorMaximo["maximo"];
				//echo '<pre>'; print_r($token); echo '</pre>';
			
			
				$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  $columana=:token WHERE $columanaPrimari=:codigo");
				
				$stmt->bindParam(":token",$token,PDO::PARAM_STR);
				$stmt->bindParam(":codigo",$value[$columanaPrimari],PDO::PARAM_INT);
				
				// var_dump($stmt);

			   $stmt-> execute();
			   // echo '<pre>'; print_r($stmt); echo '</pre>';
			   // return false;
			   $variable=true;
			}

				if ($variable){
					return "ok";
				}else{

			   		return "error";
			   }
				
			}




	}
