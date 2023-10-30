<?php

	#RECIBIR ARCHIVOS MULTIMEDIA
#-----------------------------------------------------------
	if(isset($_FILES["file"])){
		//var_dump($_FILES["file"]);

			/*=============================================
	SUBIR MULTIMEDIA
	=============================================*/
		
		if(isset($_FILES["file"]["tmp_name"]) && !empty($_FILES["file"]["tmp_name"])){
			
			/*=============================================
			DEFINIMOS LAS MEDIDAS
			=============================================*/
			$aleatorio = mt_rand(100,999);
			list($ancho, $alto) = getimagesize($_FILES["file"]["tmp_name"]);	

			if($ancho>$alto){
				$nuevoAncho = 980;
				$nuevoAlto = 740;
			}elseif($ancho<$alto){
				$nuevoAncho = 740;
				$nuevoAlto = 980;
			}else{
				$nuevoAncho = 740;
				$nuevoAlto = 740;
				}

			/*=============================================
			CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DE LA MULTIMEDIA
			=============================================*/
			// $Rutagaleria = json_decode($_POST['ruta'], true);
			// $directorio = implode(",", $Rutagaleria[0]);
			$RutaGeneral=explode("/",$_POST['ruta']);
			$directorio="../".$RutaGeneral[0]."/".$RutaGeneral[1]."/".$RutaGeneral[2];
			$nombres = $RutaGeneral[3];
			
			/*=============================================
			PRIMERO PREGUNTAMOS SI EXISTE UN DIRECTORIO DE MULTIMEDIA CON ESTA RUTA
			=============================================*/

			if (!file_exists($directorio)){

				mkdir($directorio, 0755);
			
			}

			/*=============================================
			DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
			=============================================*/

			if($_FILES["file"]["type"] == "image/jpeg"){

				/*=============================================
				GUARDAMOS LA IMAGEN EN EL DIRECTORIO
				=============================================*/

				$rutaMultimedia = $directorio."/".$nombres;

				$origen = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);						

				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagejpeg($destino, $rutaMultimedia);

			}

			if($_FILES["file"]["type"] == "image/png"){

				/*=============================================
				GUARDAMOS LA IMAGEN EN EL DIRECTORIO
				=============================================*/

				$rutaMultimedia = $directorio;

				$origen = imagecreatefrompng($_FILES["file"]["tmp_name"]);						

				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagealphablending($destino, FALSE);
		
				imagesavealpha($destino, TRUE);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagepng($destino, $rutaMultimedia);

			}

		//	$rutaMultimedia=(substr($directorio, 3))
			//echo substr($rutaMultimedia, 3);

			//echo $rutaMultimedia;	

		}

	

	}
	