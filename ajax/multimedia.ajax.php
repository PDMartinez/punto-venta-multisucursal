<?php

require_once "../modelos/actualizarVarios.modelo.php";

/*=============================================
	#RECIBIR ARCHIVOS MULTIMEDIA
=============================================*/
	

if(isset($_FILES["file"])){
		
	// var_dump($_FILES["file"]);

	/*=============================================
	SUBIR MULTIMEDIA
	=============================================*/

	if(isset($_FILES["file"]["tmp_name"]) && $_FILES["file"]["tmp_name"] !="" ){
			$guardarRuta=[];
		
		// var_dump($_POST['tabla'], $_POST['token_columna'], $_POST['token'], $_POST['token_columna']);


	//	if($actualizar=="ok"){
					
			/*=====================================================================
			PRIMERO PREGUNTAMOS SI EXISTE UN DIRECTORIO DE MULTIMEDIA CON ESTA RUTA
			======================================================================*/
		$directorio = "../vistas/img/".$_POST["carpeta"];

			if (!file_exists($directorio)){

				mkdir($directorio, 0755);
					
			}
			$aleatorio = md5(uniqid(rand(),true));
			$destino=strtolower($directorio."/".$aleatorio.".jpg");

			$tamaño=filesize($_FILES["file"]["tmp_name"]);
			$comprimir;

			if($tamaño>10 and $tamaño<=207200){

				$comprimir=100;

			}elseif($tamaño>207200 and $tamaño<=507200){

				$comprimir=70;

			}elseif($tamaño>507200 and $tamaño<=1048576){

				$comprimir=60;

			}elseif($tamaño>1048576 and $tamaño<=3145728){

				$comprimir=60;

			}elseif($tamaño>3145728){

				$comprimir=40;

			}else{

				$comprimir=30;

			}

			$ruta = compress($_FILES["file"]["tmp_name"], $destino, $comprimir);

			if(file_exists($ruta)){


		$consultar=ModeloVarios::mdlMostrarVario($_POST['tabla'], $_POST['token_columna'], $_POST['token'], $_POST['token_columna']);
		//echo '<pre>'; print_r($consultar); echo '</pre>';
		// var_dump($consultar["IMAGEN_PRODUCTO"]);
		
		/*=============================================
		SI YA EXISTE IMAGEN EN LA BASE DE DATOS INGRESA
		=============================================*/

		if($consultar[$_POST['foto_columna']]!=null || $consultar[$_POST['foto_columna']]!=""){

			// var_dump("Ya existe en la base de datos");
			// return;

			$galeriaAntigua = json_decode($consultar[$_POST['foto_columna']], true);
			// if ($galeriaAntigua==null){
			// 	$galeriaAntigua = json_decode("[]", true);
			// }
			
		 

			foreach ($galeriaAntigua as $key => $value) {

				//if($value!=""){

					array_push($guardarRuta, $value);
					//var_dump($value);
				//}

			}

			//var_dump("datosexiententes",$guardarRuta);
			// return;
		}else{
			$guardarRuta= json_decode("[]", true);

		}

		/*=============================================
		SE CREA EL DIRECTORIO DE IMAGENES
		=============================================*/
					
	
	//	$destino;

		
		
		//if($_FILES["file"]["tmp_name"] != ""){

			$ruta = array();
			array_push($ruta, $destino);
			array_push($guardarRuta, substr($ruta[0], 3));
			//echo '<pre>'; print_r($guardarRuta); echo '</pre>';

	//	}

	//	var_dump($_POST['tabla'], $_POST['foto_columna'], json_encode($guardarRuta), $_POST['token_columna'], $_POST['token']);
		// return;
			
		$actualizar=ModeloVarios::mdlActualizarVario($_POST['tabla'], $_POST['foto_columna'], json_encode($guardarRuta), $_POST['token_columna'],$_POST['token']);

					
				$mensaje=array('status'=>200,'msg'=> 'Imagen subido con Éxito');
						
				echo json_encode($mensaje,JSON_UNESCAPED_UNICODE);
				die();

			}else{

				$mensaje=array('status'=>400,'msg'=> 'Hubo un error al subir la imagen');
				echo json_encode($mensaje,JSON_UNESCAPED_UNICODE);
				die();
					
			}


	//	}
				
			
	}


}else{

	//SI NO EXISTE ARCHIVOS ENTRA PARA ELIMINAR 

	$guardarRuta=[];

	$consultar=ModeloVarios::mdlMostrarVario($_POST['tabla'],$_POST['token_columna'],$_POST['token'],$_POST['token_columna']);

	//SI EXISTE ALGUNA IMAGEN ANTERIOR

	if($_POST["rutavieja"] != "" ){

		$galeriaBD = json_decode($consultar[$_POST['foto_columna']], true);
				
		$galeriaAntigua = explode("," , $_POST["rutavieja"]);

		// var_dump("galeria antigua",	$galeriaAntigua);
		// var_dump("galeria estatica",	$galeriaBD);
		// return;
		$guardarRuta = $galeriaAntigua;
		
		$borrarFoto = array_diff($galeriaBD, $galeriaAntigua);
			
		foreach ($borrarFoto as $key => $valueFoto){

			if($valueFoto!=[""]){
							
				if (!file_exists($valueFoto)) {

					unlink("../".$valueFoto);

				}
			}

		}

		$actualizar=ModeloVarios::mdlActualizarVario($_POST['tabla'],$_POST['foto_columna'],json_encode($guardarRuta),$_POST['token_columna'],$_POST['token']);


		if($actualizar=="ok"){
					
			$mensaje=array('status'=>200,'msg'=> 'Imagen eliminado con Éxito');
						
			echo json_encode($mensaje,JSON_UNESCAPED_UNICODE);
			die();

		}else{

			$mensaje=array('status'=>400,'msg'=> 'Hubo un error al eliminar la imagen');
			echo json_encode($mensaje,JSON_UNESCAPED_UNICODE);
			die();
					
		}


	}else{

		if($consultar[$_POST['foto_columna']] != '[]' && $consultar[$_POST['foto_columna']] != ""){

			$galeriaBD = json_decode($consultar[$_POST['foto_columna']], true);
				
			foreach ($galeriaBD as $key => $valueFoto){

				if($valueFoto!='[]'){

					if (!file_exists($valueFoto)) {

						unlink("../".$valueFoto);

					}
						
				}

			}

		}

		$actualizar=ModeloVarios::mdlActualizarVario($_POST['tabla'],$_POST['foto_columna'],json_encode($guardarRuta),$_POST['token_columna'],$_POST['token']);


		if($actualizar=="ok"){
					
			$mensaje=array('status'=>200,'msg'=> 'Imagen eliminado con Éxito');
						
			echo json_encode($mensaje,JSON_UNESCAPED_UNICODE);
			die();

		}else{

			$mensaje=array('status'=>400,'msg'=> 'Hubo un error al eliminar una imagen');
			echo json_encode($mensaje,JSON_UNESCAPED_UNICODE);
			die();
					
		}

				
	}

}


	/*TAMAÑO DE IMAGEN
=============================================*/
function compress($source, $destination, $quality) {

	$info = getimagesize($source);

	if ($info['mime'] == 'image/jpeg')

		$image = imagecreatefromjpeg($source);

	elseif ($info['mime'] == 'image/gif') 

		$image = imagecreatefromgif($source);

	elseif ($info['mime'] == 'image/png') 
						    	
		$image = imagecreatefrompng($source);

		imagejpeg($image, $destination, $quality);

		return $destination;
}

/*=============================================*/
