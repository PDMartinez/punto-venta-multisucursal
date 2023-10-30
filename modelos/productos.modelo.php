<?php 

require_once "conexion.php";


class ModelosProductos
{
	
			/**
	 PARA SELECCIONAR 
	 */

	 	/*============================================================
		MODELO PERFIL PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlMostrarSoloProducto($tabla, $item, $valor,$order)
 	{
 		
 		if($valor != null)
 		{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER by $order");
           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
			
			return $stmt -> fetch();

		}else

 		{
 			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");
 			$stmt->execute();
 			return $stmt-> fetchAll();
 		}
 		
 	}


 	/*============================================================
		MODELO PERFIL PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlMostrarSoloStock($tabla,$item,$valor,$item1,$valor1)
 	{
 		
 		if($valor != null)
 		{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item1 = :$item1");
           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":$item1",  $valor1, PDO::PARAM_STR);

			$stmt -> execute();
			
			return $stmt -> fetch();

		}else

 		{
 			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");
 			$stmt->execute();
 			return $stmt-> fetchAll();
 		}
 		
 	}



	static public function MdlMostrarProductosInner($tabla,$tabla1,$tabla2,$tabla3,$tabla4,$tabla5,$tabla6,$item,$valor,$item1,$valor1,$item2,$valor2,$item3,$valor3,$order)
		{
			
			if($item != null)
			{
				$stmt=Conexion::conectar()->prepare("SELECT $tabla.COD_PRODUCTO,$tabla.COD_CATEGORIA, $tabla.COD_SUBCATEGORIA, $tabla.COD_MARCA,CODBARRA, DESCRIPCION,PRECIO_COMPRA, IMAGEN_PRODUCTO, UNIDAD_MEDIDA, DIMENSION,CANTIDAD_PAQUETE,TIPO_PRODUCTO, IVA, TOKEN_PRODUCTO,$tabla1. COD_STOCK, EXISTENCIA, STOCKMINIMO,FECHA_CARGA,PRECIO_CONTADO, PRECIO_OFERTA, ESTADO_OFERTA, ESTANTE, MOVIMIENTO_PRODUCTO, TOKEN_STOCK,EST_ARTICULOS,$tabla2.NOMBRE_SUBCATEGORIA,$tabla3.NOMBRE_CATEGORIA,$tabla4.NOMBRE_MARCA,$tabla6.DESCRIPCION_CANAL,$tabla6.COD_CANAL,TOKEN_CANAL,CAST(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100 AS DECIMAL(6,2)) PORCENTAJEGANNACIA,CASE WHEN ESTADO_OFERTA = 1 THEN CAST(((PRECIO_OFERTA *100)/PRECIO_COMPRA)-100 AS DECIMAL(6,2)) ELSE 0 END PORCENTAJEOFERTA,TOKEN_CATEGORIA,TOKEN_SUBCATEGORIA,TOKEN_MARCA,COMBOS FROM $tabla INNER JOIN $tabla1 ON $tabla.COD_PRODUCTO=$tabla1.COD_PRODUCTO INNER JOIN $tabla2 ON $tabla2.COD_SUBCATEGORIA=$tabla.COD_SUBCATEGORIA INNER JOIN $tabla3 ON $tabla3.COD_CATEGORIA=$tabla.COD_CATEGORIA INNER JOIN $tabla4 ON $tabla4.COD_MARCA=$tabla.COD_MARCA INNER JOIN $tabla5 ON $tabla1.COD_SUCURSAL=$tabla5.COD_SUCURSAL INNER JOIN $tabla6 ON $tabla6.COD_CANAL=$tabla.COD_CANAL WHERE $tabla.$item= :$item AND $tabla1.$item1= :$item1 AND $tabla5.$item2= :$item2 ORDER BY $order");
				$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
				$stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
				$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);
				$stmt-> execute();
				return $stmt -> fetch();

			}else if($item == null && $item2!=null && $item3==null){
				$stmt=Conexion::conectar()->prepare("SELECT $tabla.COD_PRODUCTO,CODBARRA, DESCRIPCION,PRECIO_COMPRA, IMAGEN_PRODUCTO, UNIDAD_MEDIDA, DIMENSION,CANTIDAD_PAQUETE,TIPO_PRODUCTO, IVA, TOKEN_PRODUCTO,$tabla1. COD_STOCK, EXISTENCIA, STOCKMINIMO,FECHA_CARGA,PRECIO_CONTADO, PRECIO_OFERTA, ESTADO_OFERTA, ESTANTE, MOVIMIENTO_PRODUCTO, TOKEN_STOCK,EST_ARTICULOS,$tabla2.NOMBRE_SUBCATEGORIA,$tabla3.NOMBRE_CATEGORIA,$tabla4.NOMBRE_MARCA,CAST(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100 AS DECIMAL(6,2)) PORCENTAJEGANNACIA,CASE WHEN ESTADO_OFERTA = 1 THEN CAST(((PRECIO_OFERTA *100)/PRECIO_COMPRA)-100 AS DECIMAL(6,2)) ELSE 0 END PORCENTAJEOFERTA,COMBOS FROM $tabla INNER JOIN $tabla1 ON $tabla.COD_PRODUCTO=$tabla1.COD_PRODUCTO INNER JOIN $tabla2 ON $tabla2.COD_SUBCATEGORIA=$tabla.COD_SUBCATEGORIA INNER JOIN $tabla3 ON $tabla3.COD_CATEGORIA=$tabla.COD_CATEGORIA INNER JOIN $tabla4 ON $tabla4.COD_MARCA=$tabla.COD_MARCA 
					INNER JOIN $tabla5 ON $tabla1.COD_SUCURSAL=$tabla5.COD_SUCURSAL
					WHERE $tabla1.$item1= :$item1 AND $tabla5.$item2= :$item2 ORDER BY $order");
				$stmt->bindParam(":$item2",$valor2,PDO::PARAM_STR);
				$stmt->bindParam(":$item1",$valor1,PDO::PARAM_STR);
			//	var_dump($stmt);
 				$stmt->execute();
	 			return $stmt-> fetchAll();
			}else if($item == null && $item2!=null && $item3!=null){
				$stmt=Conexion::conectar()->prepare("SELECT $tabla.COD_PRODUCTO,CODBARRA, DESCRIPCION,PRECIO_COMPRA, IMAGEN_PRODUCTO, UNIDAD_MEDIDA, DIMENSION,CANTIDAD_PAQUETE,TIPO_PRODUCTO, IVA, TOKEN_PRODUCTO,$tabla1. COD_STOCK, EXISTENCIA, STOCKMINIMO,FECHA_CARGA,PRECIO_CONTADO, PRECIO_OFERTA, ESTADO_OFERTA, ESTANTE, MOVIMIENTO_PRODUCTO, TOKEN_STOCK,EST_ARTICULOS,$tabla2.NOMBRE_SUBCATEGORIA,$tabla3.NOMBRE_CATEGORIA,$tabla4.NOMBRE_MARCA,CAST(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100 AS DECIMAL(6,2)) PORCENTAJEGANNACIA,CASE WHEN ESTADO_OFERTA = 1 THEN CAST(((PRECIO_OFERTA *100)/PRECIO_COMPRA)-100 AS DECIMAL(6,2)) ELSE 0 END PORCENTAJEOFERTA,COMBOS FROM $tabla INNER JOIN $tabla1 ON $tabla.COD_PRODUCTO=$tabla1.COD_PRODUCTO INNER JOIN $tabla2 ON $tabla2.COD_SUBCATEGORIA=$tabla.COD_SUBCATEGORIA INNER JOIN $tabla3 ON $tabla3.COD_CATEGORIA=$tabla.COD_CATEGORIA INNER JOIN $tabla4 ON $tabla4.COD_MARCA=$tabla.COD_MARCA 
					INNER JOIN $tabla5 ON $tabla1.COD_SUCURSAL=$tabla5.COD_SUCURSAL WHERE $tabla1.$item1= :$item1 AND $tabla5.$item2= :$item2 AND $tabla.$item3=:$item3 ORDER BY $order");
				$stmt->bindParam(":$item3",$valor3,PDO::PARAM_STR);
				$stmt->bindParam(":$item2",$valor2,PDO::PARAM_STR);
				$stmt->bindParam(":$item1",$valor1,PDO::PARAM_STR);
				// var_dump($stmt);
 				$stmt->execute();
	 			return $stmt-> fetchAll();
			}else{

 			$stmt=Conexion::conectar()->prepare("SELECT $tabla.*,$tabla1.*,$tabla2.*,$tabla3.*,$tabla4.*,$tabla6.*,CAST(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100 AS DECIMAL(6,2)) PORCENTAJEGANNACIA,CASE WHEN ESTADO_OFERTA = 1 THEN CAST(((PRECIO_OFERTA *100)/PRECIO_COMPRA)-100 AS DECIMAL(6,2)) ELSE 0 END PORCENTAJEOFERTA,COMBOS FROM $tabla INNER JOIN $tabla1 ON $tabla.COD_PRODUCTO=$tabla1.COD_PRODUCTO INNER JOIN $tabla2 ON $tabla2.COD_SUBCATEGORIA=$tabla.COD_SUBCATEGORIA INNER JOIN $tabla3 ON $tabla3.COD_CATEGORIA=$tabla.COD_CATEGORIA INNER JOIN $tabla4 ON $tabla4.COD_MARCA=$tabla.COD_MARCA 
					INNER JOIN $tabla5 ON $tabla1.COD_SUCURSAL=$tabla5.COD_SUCURSAL INNER JOIN $tabla6 ON $tabla6.COD_CANAL=$tabla.COD_CANAL ORDER BY $order");
 				
	 			$stmt->execute();
	 			return $stmt-> fetchAll();
 		}
	 		
		}


		/**
	 REGISTRO DE USUARIO
	 */
	static public function mdlIngresarProducto($tabla,$tabla1,$tabla2,$datos)
	{

		
		date_default_timezone_set('America/Asuncion');

		$fecha = date('Y-m-d');
		$hora = date('H:i:s');

		$fechaActual = $fecha.' '.$hora;

		$connection = Conexion::conectar();

		$connection->beginTransaction();

		$rollback = true;

		$guardarProductos = $connection->prepare("INSERT INTO $tabla(COD_CATEGORIA,COD_SUBCATEGORIA,COD_MARCA,CODBARRA,DESCRIPCION,UNIDAD_MEDIDA,DIMENSION,CANTIDAD_PAQUETE,TIPO_PRODUCTO,IVA, TOKEN_PRODUCTO,COD_CANAL,COMBOS) VALUES (:cmbCategoria,:cmbSubCategoria,:cmbmarca,:txtcodigobarra,:txtDescripcion,:cmbMedida,:txtdimension,:txtcantPaquete,:txttipoProducto,:cmbiva,:tokenProducto,:codcanal,:combos)");
		
		$guardarProductos->bindParam(":cmbCategoria",($datos["cmbCategoria"]),PDO::PARAM_STR);
	   	$guardarProductos->bindParam(":cmbSubCategoria",($datos["cmbSubCategoria"]),PDO::PARAM_STR);
	  	$guardarProductos->bindParam(":cmbmarca",$datos["cmbmarca"],PDO::PARAM_STR);
	   	$guardarProductos->bindParam(":txtcodigobarra",$datos["txtcodigobarra"],PDO::PARAM_STR);
	   	$guardarProductos->bindParam(":txtDescripcion",$datos["txtDescripcion"],PDO::PARAM_STR);
	   	$guardarProductos->bindParam(":cmbMedida",$datos["cmbMedida"],PDO::PARAM_STR);
	   	$guardarProductos->bindParam(":txtdimension",$datos["txtdimension"],PDO::PARAM_STR);
	   	$guardarProductos->bindParam(":txtcantPaquete",$datos["txtcantPaquete"],PDO::PARAM_STR);
	   	$guardarProductos->bindParam(":txttipoProducto",$datos["txttipoProducto"],PDO::PARAM_STR);
	   	$guardarProductos->bindParam(":cmbiva",$datos["cmbiva"],PDO::PARAM_STR);
	   	$guardarProductos->bindParam(":tokenProducto",$datos["tokenProducto"],PDO::PARAM_STR);
	   	$guardarProductos->bindParam(":codcanal",$datos["codcanal"],PDO::PARAM_STR);
	    $guardarProductos->bindParam(":combos",$datos["combos"],PDO::PARAM_STR);
	 //  var_dump($stmt);
	   if ($guardarProductos-> execute())
	   {
	   		$codigoProducto = $connection->lastInsertId();
	   		// echo '<pre>'; print_r($codigoProducto); echo '</pre>';
	   		//return $codigoProducto;

			  $stmt=$connection->prepare("INSERT INTO $tabla1(COD_SUCURSAL,COD_PRODUCTO,COD_USUARIO,EXISTENCIA,STOCKMINIMO,PRECIO_CONTADO,PRECIO_COMPRA,PRECIO_OFERTA,ESTADO_OFERTA,ESTANTE,TOKEN_STOCK, EST_ARTICULOS,MOVIMIENTO_PRODUCTO,FECHA_CARGA) VALUES (:sucursal,:codigoProducto,:usuario,:txtstock,:txtstockminimo,:txtprecioventa,:txtpreciocompra,:txtOferta,:chkoferta,:txtUbicacion,:tokenStock,:estado,:movimiento,:fechacarga)");
				
			$stmt->bindParam(":sucursal",($datos["sucursal"]),PDO::PARAM_STR);
			$stmt->bindParam(":codigoProducto",$codigoProducto,PDO::PARAM_STR);
			$stmt->bindParam(":usuario",$datos["usuario"],PDO::PARAM_STR);
			$stmt->bindParam(":txtstock",$datos["txtstock"],PDO::PARAM_STR);
			$stmt->bindParam(":txtstockminimo",$datos["txtstockminimo"],PDO::PARAM_STR);
			$stmt->bindParam(":txtprecioventa",$datos["txtprecioventa"],PDO::PARAM_STR);
			$stmt->bindParam(":txtpreciocompra",$datos["txtpreciocompra"],PDO::PARAM_STR);
			$stmt->bindParam(":txtOferta",$datos["txtOferta"],PDO::PARAM_STR);
			$stmt->bindParam(":chkoferta",$datos["chkoferta"],PDO::PARAM_STR);
			$stmt->bindParam(":txtUbicacion",$datos["txtUbicacion"],PDO::PARAM_STR);
			$stmt->bindParam(":tokenStock",$datos["tokenStock"],PDO::PARAM_STR);
			$stmt->bindParam(":estado",$datos["estado"],PDO::PARAM_STR);
			$stmt->bindParam(":movimiento",$datos["movimiento"],PDO::PARAM_STR);
			$stmt->bindParam(":fechacarga",$fechaActual,PDO::PARAM_STR);
			
			//echo '<pre>'; print_r($datos); echo '</pre>';

			  if ($stmt-> execute())
			   {
					$connection->commit();

					return "ok";

			   }else

			   {

			   	$connection->rollBack();
			   	"\nPDO::errorInfo():\n";
			   				return ($stmt->errorInfo());
			   }

		   
			
	   }else{
				$connection->rollBack();

			"\nPDO::errorInfo():\n";
			   				return ($stmt->errorInfo());

		}
	 }

	 // GUARDAR EL STOCK DEL PRODUCTO
static public function mdlIngresarStock($tabla,$datos)
	{
		
	$stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(COD_SUCURSAL,COD_PRODUCTO,COD_USUARIO,EXISTENCIA,STOCKMINIMO,PRECIO_CONTADO,PRECIO_OFERTA,ESTADO_OFERTA,ESTANTE,TOKEN_STOCK, EST_ARTICULOS) VALUES (:sucursal,:codigoProducto,:usuario,:txtstock,:txtstockminimo,:txtprecioventa,:txtOferta,:chkoferta,:txtUbicacion,:tokenStock,:estado)");
		
	$stmt->bindParam(":sucursal",($datos["sucursal"]),PDO::PARAM_STR);
	$stmt->bindParam(":codigoProducto",($datos["codigoProducto"]),PDO::PARAM_STR);
	$stmt->bindParam(":usuario",$datos["usuario"],PDO::PARAM_STR);
	$stmt->bindParam(":txtstock",$datos["txtstock"],PDO::PARAM_STR);
	$stmt->bindParam(":txtstockminimo",$datos["txtstockminimo"],PDO::PARAM_STR);
	$stmt->bindParam(":txtprecioventa",$datos["txtprecioventa"],PDO::PARAM_STR);
	$stmt->bindParam(":txtOferta",$datos["txtOferta"],PDO::PARAM_STR);
	$stmt->bindParam(":chkoferta",$datos["chkoferta"],PDO::PARAM_STR);
	$stmt->bindParam(":txtUbicacion",$datos["txtUbicacion"],PDO::PARAM_STR);
	$stmt->bindParam(":tokenStock",$datos["tokenStock"],PDO::PARAM_STR);
	$stmt->bindParam(":estado",$datos["estado"],PDO::PARAM_STR);
	
			    if ($stmt-> execute())
			   {
					return "ok";

			   }else

			   {
			   		"\nPDO::errorInfo():\n";
			   				return ($stmt->errorInfo());
			   }
		}


	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function mdlEditarProducto($tabla,$tabla1, $datos){

		// var_dump($datos);
		// return;
		date_default_timezone_set('America/Asuncion');

		$fecha = date('Y-m-d');
		$hora = date('H:i:s');

		$fechaActual = $fecha.' '.$hora;
		$connection = Conexion::conectar();

		$connection->beginTransaction();

		$rollback = true;


				if($datos["insertar"]==1){
					

					  $stmt=$connection->prepare("INSERT INTO $tabla1(COD_SUCURSAL,COD_PRODUCTO,COD_USUARIO,EXISTENCIA,STOCKMINIMO,PRECIO_CONTADO,PRECIO_COMPRA,PRECIO_OFERTA,ESTADO_OFERTA,ESTANTE,TOKEN_STOCK,MOVIMIENTO_PRODUCTO,EST_ARTICULOS) VALUES (:sucursal,:codigoProducto,:usuario,:txtstock,:txtstockminimo,:txtprecioventa,:txtpreciocompra,:txtOferta,:chkoferta,:txtUbicacion,:tokenStock,:movimiento,1)");
				
							$stmt->bindParam(":sucursal",($datos["sucursal"]),PDO::PARAM_STR);
							$stmt->bindParam(":codigoProducto",$datos["txtcodProducto"],PDO::PARAM_STR);
							$stmt->bindParam(":usuario",$datos["usuario"],PDO::PARAM_STR);
							$stmt->bindParam(":txtstock",$datos["txtstock"],PDO::PARAM_STR);
							$stmt->bindParam(":txtstockminimo",$datos["txtstockminimo"],PDO::PARAM_STR);
							$stmt->bindParam(":txtprecioventa",$datos["txtprecioventa"],PDO::PARAM_STR);
							$stmt->bindParam(":txtpreciocompra",$datos["txtpreciocompra"],PDO::PARAM_STR);
							$stmt->bindParam(":txtOferta",$datos["txtOferta"],PDO::PARAM_STR);
							$stmt->bindParam(":chkoferta",$datos["chkoferta"],PDO::PARAM_STR);
							$stmt->bindParam(":txtUbicacion",$datos["txtUbicacion"],PDO::PARAM_STR);
							$stmt->bindParam(":tokenStock",$datos["tokenstock"],PDO::PARAM_STR);
							$stmt->bindParam(":movimiento",$datos["movimiento"],PDO::PARAM_STR);
			
						   
						    if ($stmt-> execute())
						   {
								$connection->commit();

								return "sucursal";

						   }else

						   {

						   		$connection->rollBack();
						   		"\nPDO::errorInfo():\n";
						   				return ($stmt->errorInfo());
						   }

				}else{

					$editar = $connection->prepare("UPDATE $tabla SET COD_CATEGORIA = :cmbCategoria, COD_SUBCATEGORIA = :cmbSubCategoria, COD_MARCA = :cmbmarca, CODBARRA = :txtcodigobarra, DESCRIPCION = :txtDescripcion, UNIDAD_MEDIDA = :cmbMedida, DIMENSION = :txtdimension, CANTIDAD_PAQUETE = :txtcantPaquete, TIPO_PRODUCTO = :txttipoProducto, IVA = :cmbiva,COD_CANAL=:codcanal,COMBOS=:combos WHERE COD_PRODUCTO =:txtcodProducto");
					
					$editar->bindParam(":cmbCategoria",($datos["cmbCategoria"]),PDO::PARAM_STR);
				   	$editar->bindParam(":cmbSubCategoria",($datos["cmbSubCategoria"]),PDO::PARAM_STR);
				   	$editar->bindParam(":cmbmarca",$datos["cmbmarca"],PDO::PARAM_STR);
				   	$editar->bindParam(":txtcodigobarra",$datos["txtcodigobarra"],PDO::PARAM_STR);
				   	$editar->bindParam(":txtDescripcion",$datos["txtDescripcion"],PDO::PARAM_STR);
				   	$editar->bindParam(":codcanal",$datos["codcanal"],PDO::PARAM_STR);
				   	$editar->bindParam(":cmbMedida",$datos["cmbMedida"],PDO::PARAM_STR);
				   	$editar->bindParam(":txtdimension",$datos["txtdimension"],PDO::PARAM_STR);
				   	$editar->bindParam(":txtcantPaquete",$datos["txtcantPaquete"],PDO::PARAM_STR);
				   	$editar->bindParam(":txttipoProducto",$datos["txttipoProducto"],PDO::PARAM_STR);
				   	$editar->bindParam(":cmbiva",$datos["cmbiva"],PDO::PARAM_STR);
				   	$editar->bindParam(":combos",$datos["combos"],PDO::PARAM_STR);
				   	$editar->bindParam(":txtcodProducto",$datos["txtcodProducto"],PDO::PARAM_STR);

					if($editar -> execute()){

							$stmt=$connection->prepare("UPDATE $tabla1 SET STOCKMINIMO=:txtstockminimo,PRECIO_CONTADO=:txtprecioventa, PRECIO_COMPRA = :txtpreciocompra,PRECIO_OFERTA=:txtOferta,ESTADO_OFERTA=:chkoferta,ESTANTE=:txtUbicacion,EXISTENCIA=:txtstock,FECHA_MODIFICACION=:fecha_actualizacion WHERE COD_STOCK=:idstock");
							$stmt->bindParam(":txtstockminimo",$datos["txtstockminimo"],PDO::PARAM_STR);
							$stmt->bindParam(":txtprecioventa",$datos["txtprecioventa"],PDO::PARAM_STR);
							$stmt->bindParam(":txtpreciocompra",$datos["txtpreciocompra"],PDO::PARAM_STR);
							$stmt->bindParam(":txtOferta",$datos["txtOferta"],PDO::PARAM_STR);
							$stmt->bindParam(":chkoferta",$datos["chkoferta"],PDO::PARAM_STR);
							$stmt->bindParam(":txtUbicacion",$datos["txtUbicacion"],PDO::PARAM_STR);
							$stmt->bindParam(":idstock",$datos["idstock"],PDO::PARAM_STR);
							$stmt->bindParam(":txtstock",$datos["txtstock"],PDO::PARAM_STR);
							$stmt->bindParam(":fecha_actualizacion",$fechaActual,PDO::PARAM_STR);


						    if ($stmt-> execute())
						   {
								$connection->commit();

								return "ok";

						   }else

						   {

						   		$connection->rollBack();
						   		"\nPDO::errorInfo():\n";
						   				return ($stmt->errorInfo());
						   }
				  
							

							
				
					
					}else{
							$connection->rollBack();
						"\nPDO::errorInfo():\n";
						   				return ($stmt->errorInfo());

					}

		}

		
	}



	// static public function mdlEditarStock($tabla,$datos)
	// {
		
	// $stmt=Conexion::conectar()->prepare("UPDATE $tabla SET STOCKMINIMO=:txtstockminimo,PRECIO_CONTADO=:txtprecioventa,PRECIO_OFERTA=:txtOferta,ESTADO_OFERTA=:chkoferta,ESTANTE=:txtUbicacion WHERE COD_STOCK=:idstock");
	// 	$stmt->bindParam(":txtstockminimo",$datos["txtstockminimo"],PDO::PARAM_STR);
	// 	$stmt->bindParam(":txtprecioventa",$datos["txtprecioventa"],PDO::PARAM_STR);
	// 	$stmt->bindParam(":txtOferta",$datos["txtOferta"],PDO::PARAM_STR);
	// 	$stmt->bindParam(":chkoferta",$datos["chkoferta"],PDO::PARAM_STR);
	// 	$stmt->bindParam(":txtUbicacion",$datos["txtUbicacion"],PDO::PARAM_STR);
	// 	$stmt->bindParam(":idstock",$datos["idstock"],PDO::PARAM_STR);
	  
	
	// 		    if ($stmt-> execute())
	// 		   {
	// 				return "ok";

	// 		   }else

	// 		   {
	// 		   		"\nPDO::errorInfo():\n";
	// 		   				return ($stmt->errorInfo());
	// 		   }
	// 	}


	/*=============================================
	ACTUALIZAR ESTADO DE USUARIO
	=============================================*/

	static public function mdlActualizarProducto($tabla, $item1,$valor1,$item2,$valor2)
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


	/*=============================================
	BORRAR
	=============================================*/

	static public function mdlEliminarProducto($tabla,$tabla1,$datos,$item,$item1){
		
		// $eliminar=true;

		// 	// PREGUNTA SI HAY ACTIVADAD EN LA VENTA PARA PODER ELIMINAR EL PRODUCTO
		// 	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla INNER JOIN detventas ON detventas.COD_PRODUCTO=$tabla.COD_PRODUCTO WHERE $item = :$item");		
		// 	$stmt -> bindParam(":$item",  $datos["tokenProducto"], PDO::PARAM_STR);
		// 	$stmt -> execute();
		// 	$cuenta = $stmt->rowCount();
		// 	// var_dump($cuenta);
		// 	if($cuenta<=0){
		// 		$eliminar=false;


		// 	}else{
		// 		$eliminar=true;

		// 	}
			// ===============================================================================

			// PREGUNTA SI HAY ACTIVADAD EN LA COMPRA PARA PODER ELIMINAR EL PRODUCTO
			// $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla INNER JOIN detcompras ON detcompras.COD_PRODUCTO=$tabla.COD_PRODUCTO WHERE $item = :$item");		
			// $stmt -> bindParam(":$item",  $datos["tokenProducto"], PDO::PARAM_STR);
			// $stmt -> execute();
			// $cuenta = $stmt->rowCount();
			// // var_dump($cuenta);
			// if($cuenta<=0){
			// 	$eliminar=false;

			// }else{
			//	$eliminar=true;

			//}

			// ===========================================================================

			
		//	if ($eliminar==false){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla INNER JOIN $tabla1 ON $tabla.COD_PRODUCTO=$tabla1.COD_PRODUCTO WHERE $item = :$item");		
				$stmt -> bindParam(":$item",  $datos["tokenProducto"], PDO::PARAM_STR);
				$stmt -> execute();
				$cuenta = $stmt->rowCount();
				
				if($cuenta>1){
					
				$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla1 WHERE $item1 = :tokenStock");
				$stmt -> bindParam(":tokenStock",$datos["tokenStock"], PDO::PARAM_STR);

					if($stmt -> execute()){

							return "ok";
							
						}else{
							
							"\nPDO::errorInfo():\n";
				   				return ($stmt->errorInfo());

						} 		 
		 		}else{

		 			$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla1 WHERE $item1 = :tokenStock");
					$stmt -> bindParam(":tokenStock",$datos["tokenStock"], PDO::PARAM_STR);
					$stmt -> execute();

					$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :id");
					$stmt -> bindParam(":id",$datos["tokenProducto"], PDO::PARAM_STR);
						if($stmt -> execute()){

							return "ok";
							
						}else{
							
							"\nPDO::errorInfo():\n";
				   				return ($stmt->errorInfo());

						}

		 	}
			

	//	}else{
	//		return "exist";
	//	}

		

		
	}

	/*=============================================
	ACTUALIZAR ESTADO
	=============================================*/

	static public function mdlActualizar($tabla, $item,$valor,$item1,$valor1,$item2,$valor2)
	{

	$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item=:$item WHERE $item1=:$item1 AND $item2=:$item2");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
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