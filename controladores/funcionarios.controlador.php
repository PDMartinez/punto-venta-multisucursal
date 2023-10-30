<?php

class ControladorFuncionarios{

	/*=============================================
	CREAR CLIENTES
	=============================================*/

	static public function ctrCrearFuncionario(){

		if(isset($_POST["nuevoNombre"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ. ]+$/', $_POST["nuevoNombre"]) &&
			   preg_match('/^[-0-9]+$/', $_POST["nuevoCi"]) &&
			   preg_match('/^[()-\-0-9. ]+$/', $_POST["nuevoCelular"]) && 
			   preg_match('/^[\.\-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ. ]+$/', $_POST["nuevaDireccion"])&&
				preg_match('/^[\.\-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ. ]+$/', $_POST["nuevoCiudad"]) &&
				preg_match('/^[0-9.]+$/', $_POST["nuevoSueldo"])){

			   	$tabla = "funcionarios";

				$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_FORMAPAGO");
				$token=bin2hex(random_bytes(16));//se genera el token
				$token=$token.$ValorMaximo["maximo"];

			   	$datos = array("nombre"=>strtoupper($_POST["nuevoNombre"]),
					           "documento"=>$_POST["nuevoCi"],
					           "direccion"=>strtoupper($_POST["nuevaDireccion"]),
					           "celular"=>$_POST["nuevoCelular"],
					           "ciudad"=>strtoupper($_POST["nuevoCiudad"]),
					           "sueldo"=>str_replace('.', '', $_POST["nuevoSueldo"]),
					           "token"=>$token,
					       	   "tipo"=>strtoupper($_POST["nuevoTipo"]),
					       	   "estado"=>1);

			   	$respuesta = ModeloFuncionarios::mdlIngresarFuncionario($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El funcionario ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "funcionarios";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El funcionario no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "funcionarios";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/

	static public function ctrMostrarFuncionario($item, $valor,$var){

		$tabla = "funcionarios";
		$order = "NOMBRE_FUNC";
		$respuesta = ModeloFuncionarios::mdlMostrarFuncionario($tabla, $item, $valor,$var,$order);

		return $respuesta;

	}

	/*=============================================
	EDITAR FUNCIONARIO
	=============================================*/

	static public function ctrEditarFuncionario(){

		if(isset($_POST["editarNombre"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
			    preg_match('/^[-0-9]+$/', $_POST["editarCi"]) &&
			   preg_match('/^[()-\-0-9. ]+$/', $_POST["editarCelular"]) && 
			   preg_match('/^[\.\-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDireccion"])&&
				preg_match('/^[\.\-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ. ]+$/', $_POST["editarCiudad"]) &&
				preg_match('/^[0-9.]+$/', $_POST["editarSueldo"])){

			   	$tabla = "funcionarios";

			   	$datos = array("id"=>$_POST["idFuncionario"],
			   					"nombre"=>strtoupper($_POST["editarNombre"]),
					           "documento"=>$_POST["editarCi"],
					           "direccion"=>strtoupper($_POST["editarDireccion"]),
					           "celular"=>$_POST["editarCelular"],
					           "ciudad"=>strtoupper($_POST["editarCiudad"]),
					           "sueldo"=>str_replace('.', '', $_POST["editarSueldo"]),
					       	   "tipo"=>strtoupper($_POST["editarTipo"]));

				//var_dump($datos);
			   	$respuesta = ModeloFuncionarios::mdlEditarFuncionario($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El funcionario ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "funcionarios";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El funcionario no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "funcionarios";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/

	static public function ctrEliminarFuncionario(){

		if(isset($_GET["idFuncionario"])){

			$tabla ="funcionarios";
			$datos = $_GET["idFuncionario"];
			$item="TOKEN_FUNCIONARIO";
			$respuesta = ModeloVarios::mdlEliminarVario($tabla,$item, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El funcionario ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "funcionarios";

								}
							})

				</script>';

			}		

		}

	}
}
