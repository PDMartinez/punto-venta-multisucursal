// const boton = document.getElementById("botonFlotante");
// boton.style = "bottom:10px;right:10px;position:fixed;z-index:9999;"
// document.body.appendChild(boton);

let movimiento;
let codigoBarraComparar;
let clonar;
let sucursal;
let insertar;

window.addEventListener('load', function() {
		cargarProductos();

	$('.btncancelar').prop('disabled', true);

	if (localStorage.getItem("listaProductosCombos") != null) {
		var sucursal = $("#idSucursales").val();

		var listasCombos = JSON.parse(localStorage.getItem("listaProductosCombos"));

		for (var i = 0; i < listasCombos.length; i++) {
			var separador = listasCombos[i]["id"].split("/");
			var idProducto = separador[1];
			var token_producto = listasCombos[i]["id"];
			var cantidadProducto = listasCombos[i]["cantidad"];

			var botones = $("button.btnAgregarProducto[idProducto='" + idProducto + "']");

			agregarProductos(token_producto, idProducto, sucursal, cantidadProducto, botones);


			if (i == 0) {

				$("#txtDescripcion").val(listasCombos[i]["nombreCombos"]);
				$("#txtPrecioVenta").val(listasCombos[i]["precioventa"]);
				$("#txtGanancia").val(listasCombos[i]["ganancia"]);
				$("#txtCodigoBarra").val(listasCombos[i]["codigobarra"]);
				$("#txtUbicacion").val(listasCombos[i]["ubicacions"]);

			}


		}

	
	}

});
/*=============================================
VARIABLE LOCAL STORAGE
=============================================*/

document.write(`<script src="assets/js/JsBarcode.all.min.js"></script>`);


var generales = document.getElementById('idSucursal');
var tablasCombos = $(".tablasCombos").DataTable({

	"ajax": "ajax/tablaCombos.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + " &stock=" + generales.getAttribute("stockers") + " &tipo_producto=" + generales.getAttribute("tipo_productos"),
	"deferRender": true,
	"retrieve": true,
	"processing": true,
	"bAutoWidth": false,
	"language": {

		"sProcessing": "Procesando...",
		"sLengthMenu": "Mostrar _MENU_ registros",
		"sZeroRecords": "No se encontraron resultados",
		"sEmptyTable": "Ningún dato disponible en esta tabla",
		"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
		"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix": "",
		"sSearch": "Buscar:",
		"sUrl": "",
		"sInfoThousands": ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
			"sFirst": "Primero",
			"sLast": "Último",
			"sNext": "Siguiente",
			"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}

	},
	'dom': 'lBfrtip',
	'buttons': [{
		"extend": "copyHtml5",
		"text": "<i class='far fa-copy'></i> Copiar",
		"titleAttr": "Copiar",
		"className": "btn btn-secondary",
		"exportOptions": {
			"columns": [2, 3, 4, 5, 8, 9]
		}
	}, {
		"extend": "excelHtml5",
		"text": "<i class='fas fa-file-excel'></i> Excel",
		"titleAttr": "Esportar a Excel",
		"className": "btn btn-success",
		"exportOptions": {
			"columns": [2, 3, 4, 5, 8, 9]
		}
	}, {
		"extend": "pdfHtml5",
		"text": "<i class='fas fa-file-pdf'></i> PDF",
		"titleAttr": "Esportar a PDF",
		"className": "btn btn-danger",
		"exportOptions": {
			"columns": [2, 3, 4, 5, 8, 9]
		}
	}, {
		"extend": "csvHtml5",
		"text": "<i class='fas fa-file-csv'></i> CSV",
		"titleAttr": "Esportar a CSV",
		"className": "btn btn-info",
		"exportOptions": {
			"columns": [2, 3, 4, 5, 8, 9]
		}

	}]

});



// idQuitarProducto.push({
// 	"idProducto": idProducto
// });

//localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));

/*=============================================
 Clonar productos
 =============================================*/

$(document).on("click", ".ClonarProducto", function() {

	var token_producto = $(this).attr("tokenProductos");
	clonar = $(this).attr("clonar");

	$(".seleccioneSucursal").removeClass("notblock");
	$(".ListarContenido").addClass("notblock");

	$('#tokenproducto').val(token_producto);
	$('#clonarnuevo').val(clonar);

})

/*=============================================
Clonar productos
=============================================*/

$(document).on("click", "#btnCargar", function() {

	var token_producto = $('#tokenproducto').val();
	clonar = $('#clonarnuevo').val();

	$(".seleccioneSucursal").addClass("notblock");
	$(".ListarContenido").addClass("notblock");
	$(".CargarCombos").removeClass("notblock");
	$("#divBarCode").addClass("notblock");

	Editarformulario(token_producto, clonar);

})

/*=============================================
cerra venta clonacion
=============================================*/

$(document).on("click", "#CerrarVentaClonar", function() {

	$(".ListarContenido").removeClass("notblock");
	$(".seleccioneSucursal").addClass("notblock");
	$(".CargarCombos").addClass("notblock");

})


/*=============================================
Editar productos
=============================================*/

$(document).on("click", ".editarProductos", function() {

	var token_producto = $(this).attr("tokenProductos");

	clonar = $(this).attr("clonar");

	Editarformulario(token_producto, clonar);
	

})

function Editarformulario(token_producto, clonar) {

	if (clonar == 1) {
		// document.getElementById("agregarGaleria").style.display = "none";
		document.querySelector("#titulo").innerHTML = "Clonar combos";
		document.querySelector("#btnGuardar").innerHTML = "Clonar combos";
		$('input[name="txtStock"]').removeAttr('disabled', 'disabled');
		movimiento = "CLONACION DIRECTA";
	} else {
		// document.getElementById("agregarGaleria").style.display = "block";

		document.querySelector("#titulo").innerHTML = "Editar combos";
		document.querySelector("#btnGuardar").innerHTML = "Actualizar";
		$('input[name="txtStock"]').prop('disabled', 'disabled');

	}

	$(".ListarContenido").addClass("notblock");
	$(".CargarCombos").removeClass("notblock");


	var sucursal = $('#idSucursales').val();
	var activo = $('#activo').val();

	var datos = new FormData();

	datos.append("token_producto", token_producto);
	datos.append("sucursal", sucursal);
	datos.append("tipo_producto", "COMBOS");
	datos.append("activo", activo);

	$.ajax({

		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {
			// console.log("respuesta", respuesta);

			$('input[name="txtCodigoBarra"]').val(respuesta["CODBARRA"]);
			codigoBarraComparar = respuesta["CODBARRA"];
			var valor = respuesta["CODBARRA"];
			var valor1 = $("#cmbSucursalHasta").val();

			if (clonar == 1) {
				validarRepetido("CODBARRA", valor, valor1, "txtCodigoBarra");
				if ($('#idSucursales').val() === $("#cmbSucursalHasta").val()) {
					$('input[name="idProducto"]').val("");
					$('input[name="TokenProducto"]').val("");
					insertar = 1;
					sucursal = $("#cmbSucursalHasta").val();
				} else {
					$('input[name="idProducto"]').val(respuesta["COD_PRODUCTO"]);
					$('input[name="TokenProducto"]').val(respuesta["TOKEN_PRODUCTO"]);
					insertar = 0;
					sucursal = $('#idSucursales').val();
				}
			} else {

				$('input[name="idProducto"]').val(respuesta["COD_PRODUCTO"]);
				$('input[name="TokenProducto"]').val(respuesta["TOKEN_PRODUCTO"]);
				insertar = 0;
				sucursal = $('#idSucursales').val();

			}


			if ($('input[name="txtCodigoBarra"]').val() != "") {
				generadorCodigoBarra(respuesta["CODBARRA"]);

			}



			$('input[name="txtDescripcion"]').val(respuesta["DESCRIPCION"]);

			var listasCombos = JSON.parse(respuesta["COMBOS"]);

			for (var i = 0; i < listasCombos.length; i++) {
				var separador = listasCombos[i]["id"].split("/");
				var idProducto = separador[1];
				var token_producto = listasCombos[i]["id"];
				var cantidadProducto = listasCombos[i]["cantidad"];
				var botones = $("button.btnAgregarProducto[idProducto='" + idProducto + "']");

				agregarProductos(token_producto, idProducto, sucursal, cantidadProducto, botones);


				// $("button.btnAgregarProducto[idProducto='" + idProducto + "']").removeClass("btn-success btnAgregarProducto");
				// $("button.btnAgregarProducto[idProducto='" + idProducto + "']").addClass("btn-secondary");


			}


			$('input[name="txtPrecioVenta"]').val(respuesta["PRECIO_CONTADO"]);
			$('input[name="txtPrecioVenta"]').number(true, 0);

			$('input[name="txtTotal"]').val(respuesta["PRECIO_COMPRA"]);
			$('input[name="txtTotal"]').number(true, 0);


			$('input[name="txtUbicacion"]').val(respuesta["ESTANTE"]);

			$("#idStock").val(respuesta["COD_STOCK"] + "/" + respuesta["TOKEN_STOCK"]);


			if ($('#txtPrecioVenta').val() != "" && $('#txtPrecioVenta').val() > 0) {

				$('#txtGanancia').val(calcularPorcentaje($('#txtPrecioVenta').val(), $('#txtTotal').val()));
			}


		}


	})

}


function Guardarformulario() {

	var txtcodigobarra = document.querySelector('input[name="txtCodigoBarra"]').value;
	var sucursal = $("#idsucursal").val();
	var insertar = 0;

	if (clonar == 0) {
		sucursal = sucursal = $('#idSucursales').val();
		insertar = 0;
	} else {
		sucursal = $("#cmbSucursalHasta").val();
		insertar = 1;
	}

	var usuario = $("#idUsuario").val();

	var txtcodProducto = document.querySelector('input[name="idProducto"]').value;
	var txtTokenProducto = document.querySelector('input[name="TokenProducto"]').value;

	var txtDescripcion = document.querySelector('input[name="txtDescripcion"]').value;
	var cmbCategoria = 1;
	var cmbSubCategoria = 1;
	var cmbMarca = 1;

	var txtcodigobarra = document.querySelector('input[name="txtCodigoBarra"]').value;

	var txtpreciocompra = document.querySelector('input[name="txtTotalArticulos"]').value;

	var txtprecioventa = document.querySelector('input[name="txtPrecioVenta"]').value;

	var txtstock = "0";
	var cmbiva = "0";

	var cmbcanal = 1;

	var txtstockminimo = "0";
	var txtdimension = "SIN DETALLE";
	var txtcantPaquete = "0";
	var cmbMedida = "SIN MEDIDA";

	var txtUbicacion = document.querySelector('input[name="txtUbicacion"]').value;
	var txttipoProducto = "COMBOS";
	var txtOferta = "0";
	var chkoferta = "0";
	var txtproductos = $("#listaProductos").val();

	var idstock = $("#idStock").val();

	var totalTalba = txtproductos.length;

	if (txtproductos.length <= 2) {
		swal({
			title: "Cargue un producto",
			type: "error",
			confirmButtonText: "¡Cerrar!"

		})
		return false;
	}

	divLoading.style.display = "flex";
	var datos = new FormData();

	datos.append("txtcodProducto", txtcodProducto);
	datos.append("txtTokenProducto", txtTokenProducto);
	datos.append("txtDescripcion", txtDescripcion);

	datos.append("cmbCategoria", cmbCategoria);
	datos.append("cmbSubCategoria", cmbSubCategoria);
	datos.append("cmbMarca", cmbMarca);
	datos.append("txtcodigobarra", txtcodigobarra);
	datos.append("txtpreciocompra", txtpreciocompra);
	datos.append("txtprecioventa", txtprecioventa);
	datos.append("cmbcanal", cmbcanal);
	datos.append("txtstock", txtstock);
	datos.append("cmbiva", cmbiva);

	datos.append("txtstockminimo", txtstockminimo);
	datos.append("txtdimension", txtdimension);
	datos.append("txtcantPaquete", txtcantPaquete);
	datos.append("cmbMedida", cmbMedida);
	datos.append("txtUbicacion", txtUbicacion);
	datos.append("txttipoProducto", txttipoProducto);
	datos.append("txtOferta", txtOferta);
	datos.append("chkoferta", chkoferta);
	datos.append("sucursal", sucursal);
	datos.append("usuario", usuario);
	datos.append("idstock", idstock);
	datos.append("txtproductos", txtproductos);
	datos.append("insertar", insertar);
	datos.append("movimiento", movimiento);



	$.ajax({
		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,

		success: function(respuesta) {

			var objData = JSON.parse(respuesta);

			if (objData.status) {
				//   $('#ModalProductos').modal('hide');


				swal("success", objData.msg, "success");


				tablasCombos.ajax.reload(function() {
					$(".ListarContenido").removeClass("notblock");
					$(".CargarCombos").addClass("notblock");
					formCombos.reset();
					$("#TablaCombos td").remove();
					localStorage.removeItem("listaProductosCombos");
				});

				//	window.location = "combos";

			} else {
				swal("Error", objData.msg, "error");
			}
			divLoading.style.display = "none";
		}

	})

	return (false);


}


// // ES PARA GUARDAR LOS DATOS EN LA BASE DE DATOS//
var colorText = "text-primary";
var tipos = "SOLITARIO";
$(document).on("click", ".TodosProductos", function() {
	var general = document.getElementById('idSucursales');

	$(".tablaProductos").DataTable().ajax.url("ajax/tablaCombos.ajax.php?sucursal=" + $("#idSucursales").val() + "&activo=" + 1 + " &stock=" + general.getAttribute("stockers") + " &tipo_producto=" + general.getAttribute("tipo_productos")).load();
	$(".plataforma").html("Buscar productos");
	$(".plataforma").removeClass(colorText);
	$(".plataforma").addClass("text-primary");
	colorText = "text-primary";
	tipos = "SOLITARIO";

})

$(document).on("click", ".btncancelar", function() {

	swal({
		title: '¿Estas seguro de cancelar la carga?',
		text: "¡Si no lo está puede cancelar la acción!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, cancelar!',
		closeOnConfirm: false,
		closeOnCancel: true
	}, function(isConfirm) {

		if (isConfirm) {
			localStorage.removeItem("listaProductosCombos");
			window.location = "combos"

		}

	});


})

$(document).on("click", ".btnListar", function() {
	//$("#TablaCombos td").remove();
	tablasCombos.ajax.reload(function() {
		$(".ListarContenido").removeClass("notblock");
		$(".CargarCombos").addClass("notblock");
		formCombos.reset();


	});


})

$(document).on("click", ".combos", function() {
	var general = document.getElementById('idSucursales');

	$(".tablaProductos").DataTable().ajax.url("ajax/tablaCombos.ajax.php?sucursal=" + $("#idSucursales").val() + "&activo=" + 1 + " &stock=" + general.getAttribute("stockers") + " &tipo_producto=" + "COMBOS").load();
	$(".plataforma").html("Buscar combos de productos");
	$(".plataforma").removeClass(colorText);
	$(".plataforma").addClass("text-success");
	colorText = "text-success";
	tipos = "COMBOS";

})


$(document).on("click", ".flete", function() {

	var general = document.getElementById('idSucursales');

	$(".tablaProductos").DataTable().ajax.url("ajax/tablaCombos.ajax.php?sucursal=" + $("#idSucursales").val() + "&activo=" + 1 + " &stock=" + general.getAttribute("stockers") + " &tipo_producto=" + "FLETES").load();
	$(".plataforma").html("Buscar fletes");
	$(".plataforma").removeClass(colorText);
	$(".plataforma").addClass("text-info");
	colorText = "text-info";
	tipos = "FLETE"
})



var tipoprducto = document.getElementById('idSucursales');


$(document).on("click", ".btnNuevo", function() {
	$('input[name="idProducto"]').val("");
	$('input[name="TokenProducto"]').val("");
	$(".ListarContenido").addClass("notblock");
	$(".CargarCombos").removeClass("notblock");
		quitarAgregarProducto();

		$("#txtPrecioVenta").number(true, 0);

	cantidadItems();

})



function cargarProductos() {
	
	$('.tablaProductos').DataTable({
		"ajax": "ajax/tablaCombos.ajax.php?sucursal=" + $("#idSucursales").val() + "&activo=" + 1 + " &stock=" + tipoprducto.getAttribute("stockers") + " &tipo_producto=" + tipoprducto.getAttribute("tipo_productos"),
		"deferRender": true,
		"retrieve": true,
		"processing": true,
		"language": {

			"sProcessing": "Procesando...",
			"sLengthMenu": "Mostrar _MENU_ registros",
			"sZeroRecords": "No se encontraron resultados",
			"sEmptyTable": "Ningún dato disponible en esta tabla",
			"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix": "",
			"sSearch": "Buscar:",
			"sUrl": "",
			"sInfoThousands": ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst": "Primero",
				"sLast": "Último",
				"sNext": "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}

		}

	});

}



/*=============================================
 VALIDAR EMAIL REPETIDO
 =============================================*/

$('input[name="txtCodigoBarra"]').change(function() {

	var valor = $(this).val();
	var valor1 = $("#idsucursal").val();
	validarRepetido("CODBARRA", valor, valor1, "txtCodigoBarra");
	listarProductosCombos();

})

/*=============================================
VALIDAR EMAIL REPETIDO
=============================================*/

$('input[name="txtDescripcion"]').change(function() {
	var valor = $(this).val();

	validarRepetido("DESCRIPCION", valor, "txtDescripcion");
	listarProductosCombos()


})

/*=============================================
AGREGANDO CALCULANDO PORCENTAJE AL ESCRIBIR EN PRECIO VENTA
=============================================*/
$('input[name="txtPrecioVenta"]').change(function() {
	$('#txtGanancia').val(calcularPorcentaje($('#txtPrecioVenta').val(), $('#txtTotal').val(), "txtPrecioVenta", "txtGanancia"))
	listarProductosCombos();

})


/*=============================================
AGREGANDO CALCULANDO PORCENTAJE AL ESCRIBIR EN PRECIO COMPRA Y GANANCIA
=============================================*/
$('input[name="txtGanancia"]').change(function() {
	$('#txtPrecioVenta').val(calcularVenta($('#txtTotal').val(), $('#txtGanancia').val()))
	$("#txtPrecioVenta").number(true, 0);
	listarProductosCombos();
})


$('input[name="txtUbicacion"]').change(function() {

	listarProductosCombos();
})



function calcularPorcentaje(precio, precio1, nombre1, nombre2) {

	$(".alertas").remove();
	var precioventa = (precio.replace(/\./g, ''));
	var preciocompra = (precio1.replace(/\./g, ''));
	if (precioventa != "" && preciocompra != "") {

		if (parseInt(precioventa) < parseInt(preciocompra)) {

			$('#' + nombre1).val("");
			$('#' + nombre2).val("");

			$('#' + nombre1).after(`

                <div class="alertas alert-warning">
                  <strong>ERROR:</strong>
                  Precio contado no puede ser menor al precio de compra, evite perdida!!!
                </div>

                `);
		} else {

			var porcentaje = (((precioventa * 100) / (preciocompra)) - 100);
			return porcentaje.toFixed(2).replace(/\./g, ',');
		}


	}
}

function calcularVenta(precio, gananciaprecio) {

	var preciocompra = (precio.replace(/\./g, ''));
	var ganancia = gananciaprecio.replace(/\,/g, '.');
	
	if (preciocompra != "" && ganancia != "") {

		var porcentaje = Number((preciocompra * ganancia / 100));
		var precioventa = Number(preciocompra) + Number(porcentaje);
		
		return Math.round(precioventa);



	}

}

var cont = 0;
// Agregar productos en la tablas
$(".tablaProductos tbody").on("click", "button.btnAgregarProducto", function() {

	var token_producto = $(this).attr("tokenProducto");
	var idProducto = $(this).attr("idProducto");
	var sucursal = $("#idSucursales").val();

	let cantidadProducto = "";
	cantidadProducto = prompt("¡Ingese la cantidad!", 1);

	if (cantidadProducto != null) {

		cantidadProducto = cantidadProducto.replace(/,/g, '.');

		while (isNaN(cantidadProducto) || cantidadProducto == "" || cantidadProducto <= 0) {
			cantidadProducto = prompt("¡Ingese la cantidad!", 1);
		};

		// $(this).removeClass("btn-success btnAgregarProducto");
		// console.log("$(this)", $(this));
		// $(this).addClass("btn-secondary");

	} else {
		// $(this).removeClass("btn-secondary");
		// $(this).addClass("btn-success btnAgregarProducto");
		return false;
	}

	agregarProductos(token_producto, idProducto, sucursal, cantidadProducto, $(this));


});


function agregarProductos(token_producto, idProducto, sucursal, cantidadProducto, botones) {

	var tipo_productos = tipos;

	var activo = 1;

	var datos = new FormData();
	datos.append("token_producto", token_producto);
	datos.append("sucursal", sucursal);
	datos.append("activo", activo);
	datos.append("tipo_producto", tipos);
	$.ajax({

		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {
			// console.log("respuesta", respuesta);
			var precioNeto = 0;
			var codigobarra = respuesta["CODBARRA"]
			var descripcion = respuesta["DESCRIPCION"];
			var precio = respuesta["PRECIO_COMPRA"];
			// console.log("precio", precio);
			precioNeto = cantidadProducto * precio;
			// console.log("precioNeto", precioNeto);
			// console.log("cantidadProducto", cantidadProducto);

			cont++;
			token_producto = token_producto.replace(/'\'/g, '');
			var f;

			botones.removeClass("btn-success btnAgregarProducto");
			botones.addClass("btn-secondary");

			

			f += `<tr class="rowNuevo">

         <td class="tdQuitar` + idProducto + `">

				<!-- BOTON PARA QUITAR --> 

				<div class="form-group nuevoQuitar` + idProducto + `"> 

				<div class="input-group"> 
				<span class="input-group-addon"> 

				<button type="button" class="btn btn-danger btn-xs quitarProducto" style="width:35px" idProducto="` + idProducto + `"><i class="fa fa-times"></i></button

				</span> 

				</div> 

				</div>


		 <td class="tdNuevoCantidad` + idProducto + `">

				<!-- Cantidad del producto -->

				<div class="form-group nuevoCantidad` + idProducto + `">

				<div class="input-group" style="width: 80px">

				<input type="text" class="form-control nuevaCantidadProducto" idProducto="` + idProducto + ` " name="nuevaCantidadProducto" value="` + cantidadProducto + `" required>

				</div>

				</div>


			 <td class="tdNumero` + idProducto + `">

				<!-- BOTON PARA QUITAR -->

				<div class="form-group nuevoNumero` + idProducto + `"> 

				<div class="input-group">

				<label class="form-control nuevaNumero" idNumero="` + idProducto + `"> ` + codigobarra + ` </label>

				</div>

				</div>


			 <td class="tdNuevoProducto` + idProducto + `">

				<!-- Descripción del producto -->

				<div class="form-group nuevoProducto` + idProducto + `">

				<div class="input-group" style="width: 200px">

				<input type="text" class="form-control nuevaDescripcionProducto" idProducto="` + token_producto + `" name="agregarProducto" value="` + descripcion + ` " readonly required>

				</div>

				</div>



			 <td class="tdNuevoPrecio` + idProducto + `"> 

				<!-- Impuesto del producto -->

				<div class="form-group nuevoPrecio` + idProducto + ` ">

				<div class="input-group" style="width: 150px">


				<input type="text" class="form-control text-right nuevoPrecioProducto" precioReal="` + precio + `" name="nuevoPrecioProducto" value="` + precio + `"  readonly required>

				</div>

				</div>


			 <td class="tdNuevoSubTotal` + idProducto + `">

				<!--SubTotal-->

				<div class="form-group nuevoSubTotal` + idProducto + `">

				<div class="input-group" style="width: 150px"> 

				<input type="text" class="form-control text-right nuevoSubTotal" precioNeto="` + precioNeto + `" name="nuevoSubTotal" value="` + precioNeto + `" readonly required>

				</div>

				</div>

			  </tr>`;

			$("#TablaCombos").append(f);


			localStorage.removeItem("quitarProducto");

			//SUMAR LOS PRECIOS
			sumarTotalPrecios();
			// PONER FORMATO AL PRECIO DE LOS PRODUCTOS

			$(".nuevoPrecioProducto").number(true, 0);
			$(".nuevoSubTotal").number(true, 0);

			//listar producto en formato json

			listarProductosCombos();
			cantidadItems();

			// $.notify({
			// 	title: "Combos: ",
			// 	message: "Operación exitosa!!!",
			// 	icon: 'fa fa-check'
			// }, {
			// 	type: "success"
			// });

		}
	});
}

function cantidadItems() {
	$('.Can').text(0);
	const tableRows = document.querySelectorAll('#TablaCombos tr.rowNuevo');
	$('.Can').text(tableRows.length);
	$('.btncancelar').prop('disabled', false);
}

/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/

$(".tablaProductos").on("draw.dt", function() {
	quitarAgregarProducto();

})


/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/

var idQuitarProducto = [];

localStorage.removeItem("quitarProducto");

$(document).on('click', 'button.quitarProducto', function(event) {
	event.preventDefault();
	var idProducto = $(this).attr('idProducto');
	var token_producto = $(this).attr('token_productos');

	// console.log("idProducto", idProducto);
	$(this).closest('tr').remove();

	if (localStorage.getItem("quitarProducto") == null) {

		idQuitarProducto = [];

	} else {

		idQuitarProducto.concat(localStorage.getItem("quitarProducto"))

	}

	idQuitarProducto.push({
		"idProducto": idProducto
	});

	localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));


	$("button.btnrecuperarBoton[idProducto='" + idProducto + "']").removeClass("btn-secondary");
	$("button.btnrecuperarBoton[idProducto='" + idProducto + "']").addClass("btn-success btnAgregarProducto");

	//listar producto en formato json
	listarProductosCombos();

	if ($("#listaProductos").val().length <= 2) {
		$("#txtTotal").val("");
		$("#txtTotalArticulos").val("");
	} else {
		//SUMAR LOS PRECIOS
		sumarTotalPrecios();

	}

	cantidadItems();



});

/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioCombos").on("change", "input.nuevaCantidadProducto", function(event) {
	event.preventDefault();
	var idProducto = $(this).attr("idProducto");
	//console.log("idProducto", idProducto);
	//var cantidadcargada = $(this).val();

	// var nav = $(this).parent().parent().parent().parent().children(".tdNuevoSubTotal").children().children().children(".nuevoSubTotal");
	//  console.log("Navegacion: ", nav);

	var precio = $(this).parent().parent().parent().parent().children(".tdNuevoPrecio" + idProducto).children(".nuevoPrecio" + idProducto).children().children(".nuevoPrecioProducto").val();
	//console.log("precio", precio);
	var precioNeto = $(this).parent().parent().parent().parent().children(".tdNuevoSubTotal" + idProducto).children(".nuevoSubTotal" + idProducto).children().children(".nuevoSubTotal");
	//console.log("precioNeto", precioNeto);
	//var stock = $(this).parent().parent().parent().parent().children(".tdNuevoCantidad").children(".nuevoCantidad"+idProducto).children().children(".nuevaCantidadProducto");
	//var stock = $(this).attr("stock");

	var stockCargada = $(this).val();
	stockCargada = stockCargada.replace(/,/g, '.');
	//console.log("stockCargada", stockCargada);

	var precioFinal = stockCargada * precio;
	//	console.log("precioFinal", precioNeto);
	//$(this).parent().parent().parent().parent().children(".tdNuevoSubTotal").children(".nuevoSubTotal"+idProducto).children().children(".nuevoSubTotal").val(precioFinal);

	precioNeto.val(precioFinal);

	// // SUMAR TOTAL DE PRECIOS

	sumarTotalPrecios()

	// // AGREGAR IMPUESTO

	//    agregarImpuesto()

	//    // AGRUPAR PRODUCTOS EN FORMATO JSON

	listarProductosCombos()

})

/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/

function sumarTotalPrecios() {

	var precioItem = $(".nuevoSubTotal");
	var arraySumaPrecio = [];

	for (var i = 0; i < precioItem.length; i++) {

		arraySumaPrecio.push(Number($(precioItem[i]).val()));

	}

	function sumaArrayPrecios(total, numero) {

		return total + numero;

	}

	var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);

	$("#txtTotal").val(sumaTotalPrecio);
	$("#txtTotalArticulos").val(sumaTotalPrecio);

	$("#totalVenta").val(sumaTotalPrecio);
	$("#txtTotal").attr("total", sumaTotalPrecio);

	// if($('#txtPrecioVenta').val()!=""){
	// 			$('#txtGanancia').val(calcularPorcentaje($('#txtPrecioVenta').val(), $('#txtTotal').val(), "txtPrecioVenta", "txtGanancia"));
	// }

	if ($('#txtGanancia').val() != "") {
		$('#txtPrecioVenta').val(calcularVenta($('#txtTotal').val(), $('#txtGanancia').val()));
	}



	$("#txtTotal").number(true, 0)
	$("#txtTotalArticulos").number(true, 0)
}



/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductosCombos() {

	var listaProductosStore = [];
	var listaProductos = [];
	var descripcion = $(".nuevaDescripcionProducto");

	var nombreCombos = $("#txtDescripcion");

	var cantidad = $(".nuevaCantidadProducto");
	var ganancia = $("#txtGanancia");
	var codigobarra = $("#txtCodigoBarra");
	var precioventa = $("#txtPrecioVenta");
	var ubicacion = $("#txtUbicacion");


	for (var i = 0; i < descripcion.length; i++) {

		listaProductosStore.push({
			"id": $(descripcion[i]).attr("idProducto"),
			"nombreCombos": $(nombreCombos[i]).val(),
			"cantidad": $(cantidad[i]).val(),
			"ganancia": $(ganancia[i]).val(),
			"codigobarra": $(codigobarra[i]).val(),
			"ubicacion": $(ubicacion[i]).val(),
			"precioventa": $(precioventa[i]).val()
		})

		listaProductos.push({
			"id": $(descripcion[i]).attr("idProducto"),

			"cantidad": $(cantidad[i]).val()
		})

	}

	$("#listaProductos").val(JSON.stringify(listaProductos));
	if ($('input[name="idProducto"]').val() == "") {
		localStorage.setItem("listaProductosCombos", JSON.stringify(listaProductosStore));
	}


	//console.log((JSON.stringify(listaProductos))); 

}



/*=============================================
ANULAR PEDIDOS
=============================================*/
$(".tablas").on("click", ".btnEliminarVenta", function() {

	var idVenta = $(this).attr("idVenta");
	var estado = $(this).attr("estado");
	var usuario = $(this).attr("usuario");


	if (estado == "EMITIDO") {

		swal({
			title: '¿Está seguro de anular el venta?',
			text: "¡Si no lo está puede cancelar la acción!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'Cancelar',
			confirmButtonText: 'Si, anular venta!'
		}).then(function(result) {
			if (result.value) {

				window.location = "index.php?ruta=ventas&idVenta=" + idVenta + "&estado=" + estado + "&usuario=" + usuario;
			}

		})

	} else {
		swal({
			title: '¿Está seguro de recuperar el venta?',
			text: "¡Si no lo está puede cancelar la acción!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'Cancelar',
			confirmButtonText: 'Si, recuperar venta!'
		}).then(function(result) {
			if (result.value) {

				window.location = "index.php?ruta=ventas&idVenta=" + idVenta + "&estado=" + estado + "&usuario=" + usuario;
			}

		})
	}

	//}
})



//FORMATEAR NUMERO DE DECIMAL
//================================

function formatNegativos(input) {

	var num = input.value.replace(/\./g, '');
	if (!isNaN(num)) {
		num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
		num = num.split('').reverse().join('').replace(/^[\.]/, '');
		input.value = num;
	}

}

function check(e) {
	tecla = (document.all) ? e.keyCode : e.which;

	//Tecla de retroceso para borrar, siempre la permite
	if (tecla == 8) {
		return true;
	}

	// Patron de entrada, en este caso solo acepta numeros y letras
	patron = /[0-9-]/;
	tecla_final = String.fromCharCode(tecla);
	return patron.test(tecla_final);
}



// console.log(getReminTime('Fri Jan 22 2021 06:36:23 GMT-0300'));

function quitarAgregarProducto() {

	//Capturamos todos los id de productos que fueron elegidos en la venta
	var idProductos = $(".quitarProducto");


	//Capturamos todos los botones de agregar que aparecen en la tabla
	var botonesTabla = $(".tablaProductos tbody button.btnAgregarProducto");

	//Recorremos en un ciclo para obtener los diferentes idProductos que fueron agregados a la venta
	for (var i = 0; i < idProductos.length; i++) {

		//Capturamos los Id de los productos agregados a la venta
		var boton = $(idProductos[i]).attr("idProducto");
		//Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
		for (var j = 0; j < botonesTabla.length; j++) {

			if ($(botonesTabla[j]).attr("idProducto") == boton) {
				$(botonesTabla[j]).removeClass("btn-success btnAgregarProducto");
				$(botonesTabla[j]).addClass("btn-secondary");

			}
		}

	}

}


if (document.querySelector("#txtCodigoBarra")) {
	let inputCodigo = document.querySelector("#txtCodigoBarra");
	inputCodigo.onkeyup = function() {
		if (inputCodigo.value.length >= 6) {
			document.querySelector('#divBarCode').classList.remove("notblock");
			fntBarcode();
		} else {
			document.querySelector('#divBarCode').classList.add("notblock");
		}
	};
}


function fntBarcode() {
	let codigo = $('input[name="txtCodigoBarra"]').val();
	JsBarcode("#barcode", codigo);
}

function fntPrintBarcode(area) {
	let elemntArea = document.querySelector(area);
	let vprint = window.open(' ', 'popimpr', 'height=400,width=600');
	vprint.document.write(elemntArea.innerHTML);
	vprint.document.close();
	vprint.print();
	vprint.close();
}


//Genera una cadena aleatoria según la longitud dada
function getRandomString(length) {
	var text = "";
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

	for (var i = 0; i < length; i++)
		text += possible.charAt(Math.floor(Math.random() * possible.length));

	return text;
}



/*=============================================
Editar productos
=============================================*/

$(document).on("click", ".GenerarCodigo", function() {
	var Barra = getRandomString(9);

	$('input[name="txtCodigoBarra"]').val(Barra);
	validarRepetido("CODBARRA", Barra, "txtCodigoBarra");
	if ($('input[name="txtCodigoBarra"]').val() == "") {
		var Barra = getRandomString(10);
		$('input[name="txtCodigoBarra"]').val(Barra);
	}
	generadorCodigoBarra($('input[name="txtCodigoBarra"]').val());

})

function generadorCodigoBarra(codigobarra) {

	if (codigobarra.length >= 6) {
		document.querySelector('#divBarCode').classList.remove("notblock");
		fntBarcode();
	} else {
		document.querySelector('#divBarCode').classList.add("notblock");
	}

}


function validarRepetido(item, valor, valor1, nombre) {
	$(".alert").remove();
	var datos = new FormData();
	datos.append("item", item);
	datos.append("valor", valor);
	datos.append("valor1", valor1);
	$.ajax({
		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta) {
			if (respuesta == "true") {

				$('#' + nombre).parent().after('<div class="alert alert-warning">  <strong>ERROR: </strong>Este registro ya existe en la base de datos</div>');

				$('#' + nombre).val("");
				return;

			}
		}

	})

}


/*=============================================
AGREGAR IMAGENES ANTIGUOS
=============================================*/

archivosTemporalesAntiguo = [];

function multiplesArchivosAntiguosProductos(archivos) {

	var longitud = JSON.parse(archivos);
	// console.log(longitud.length);

	$("#mostrarImagen").remove();

	$("#modalBodyProducto").append(

		'<div class="row" id="mostrarImagen"></div>'

	);

	if (longitud.length < 1) {

		$("#mostrarImagen").append(

			'<div class="col-lg-12 col-md-12 col-xs-12 rounded-10 shadow-none img-fluid" style="margin: 0 !important; padding: 20px;">' +

			'<img src="vistas/img/productos/default/anonymous.png" style="width: 100%; height: 100%;">' +

			'</div>'

		);

	}

	for (var i = 0; i < longitud.length; i++) {

		var imagen = longitud[i];

		var rutaImagen = imagen;


		$("#mostrarImagen").append(`

      <div class="col-lg-6 col-md-12 col-xs-12 rounded-10 shadow-none img-fluid" style=":hover {border: 5px solid #f7f7f7}; margin: 0 !important; padding: 10px;">

        <img src="` + rutaImagen + `" style="width: 100%; height: 100%;">

        <div class="card-img-overlay p-2 pr-2">
                        
          <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoAntiguaProducto" temporalProducto="` + rutaImagen + `">
                           
            <i class="fas fa-times"></i>

          </button>

        </div>

      </div>

    `);

		archivosTemporalesAntiguo.push(rutaImagen.split(','));
		imagenPermitidoAntiguo = archivosTemporalesAntiguo;

		$(".inputAntiguaGaleriaProducto").val(archivosTemporalesAntiguo);

	} // termina el for

}


/*=============================================
 QUITAR IMAGEN ANTIGUO VISTA DE PRODUCTOS
 =============================================*/

$(document).on("click", ".quitarFotoAntiguaProducto", function() {

	var listaFotosAntiguas = $(".quitarFotoAntiguaProducto");

	var listaTemporales = $(".inputAntiguaGaleriaProducto").val().split(",");

	for (var i = 0; i < listaFotosAntiguas.length; i++) {

		quitarImagen = $(this).attr("temporalProducto");


		if (quitarImagen == listaTemporales[i]) {

			listaTemporales.splice(i, 1);

			$(".inputAntiguaGaleriaProducto").val(listaTemporales.toString());
			imagenPermitidoAntiguo = listaTemporales;
			$(".inputGaleriaProducto").val("");
			$(this).parent().parent().remove();

		}

	}

	swal({
		title: '¿Está seguro de eliminar esta imagen?',
		text: "¡Si no lo está puede cancelar la acción!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, eliminar imagen!',
		closeOnConfirm: false,
		closeOnCancel: true
	}, function(isConfirm) {

		if (isConfirm) {

			var txtTokenProducto = document.querySelector('input[name="TokenProductoImagen"]').value;
			var rutavieja = $(".inputAntiguaGaleriaProducto").val();
			// var rutacompleta = $(".inputAntiguaGaleriaProductoEstatica").val();
			// console.log(txtTokenProducto, rutavieja, rutacompleta);
			// return;
			BorrarImagenProducto(txtTokenProducto, rutavieja);
		} else {
			var token_producto = "0/" + $('#TokenProductoImagen').val();
			verImagenProductos(token_producto);
		}

	});


})

/*=============================================
BORRAR IMAGEN VISTA DE PRODUCTOS
=============================================*/

function BorrarImagenProducto(token, rutavieja) {

	datosMultimedia = new FormData();

	datosMultimedia.append("tabla", "productos");
	datosMultimedia.append("token", token);
	datosMultimedia.append("token_columna", "TOKEN_PRODUCTO");
	datosMultimedia.append("rutavieja", rutavieja);
	datosMultimedia.append("foto_columna", "IMAGEN_PRODUCTO");
	datosMultimedia.append("carpeta", "productos");

	$.ajax({

		type: "POST",
		url: "ajax/multimedia.ajax.php",
		dataType: "json",
		contentType: false,
		processData: false,
		cache: false,
		data: datosMultimedia,

		xhr: function() {

			var xhr = $.ajaxSettings.xhr();

			xhr.onprogress = function(evt) {

				var porcentaje = Math.floor((evt.loaded / evt.total * 100));

			};

			return xhr;

		},
		beforeSend: () => {

			$("#btnGuardar").prop('disabled', true);
			//document.getElementById("mostrar_loading").style.display = "block";

		}

	}).done(res => {

		if (res.status === 200) {

			cerrarLoadingProducto();
			swal("success", res.msg, "success");
			var token_producto = "0/" + $('#TokenProductoImagen').val();
			tablasCombos.ajax.reload(function() {
				verImagenProductos(token_producto);
				formProductoImagen.reset();

			});



		} else {

			alert(res.msg);
			cerrarLoadingProducto();

		}

	}).fail(err => {

		swal("Error", err.msg, "error");
		cerrarLoadingProducto();
		return;

	})

}


function verImagenProductos(token_producto) {

	var cadena = token_producto.split("/");

	$("#idProductoImagen").val(cadena[0]);
	$("#TokenProductoImagen").val(cadena[1]);

	var datos = new FormData();

	datos.append("token", token_producto);

	$.ajax({

		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {

			archivosTemporalesAntiguo = [];

			// COLOCAR LAS IMAGENES

			// $(".inputAntiguaGaleriaProductoEstatica").val((respuesta["IMAGEN_PRODUCTO"]));

			if (respuesta["IMAGEN_PRODUCTO"] != '[""]' && respuesta["IMAGEN_PRODUCTO"] != null && respuesta["IMAGEN_PRODUCTO"] != '') {

				multiplesArchivosAntiguosProductos(respuesta["IMAGEN_PRODUCTO"]);

			}


		}


	})


}


var imagenPermitidoNuevo = [];
var imagenPermitidoAntiguo = [];

$(".subirGaleriaProducto").on("dragenter", function(e) {

	// alert("dragenter");

	e.preventDefault();
	e.stopPropagation();

	$(".subirGaleriaProducto").css({
		"background": "url(vistas/img/plantilla/pattern.jpg)"
	})

})

$(".subirGaleriaProducto").on("dragleave", function(e) {

	// alert("dragleave");

	e.preventDefault();
	e.stopPropagation();

	$(".subirGaleriaProducto").css({
		"background": ""
	})

})

$(".subirGaleriaProducto").on("dragover", function(e) {

	// alert("dragover");

	e.preventDefault();
	e.stopPropagation();

})

$("#galeriaProducto").change(function() {

	// alert("change");
	// LimpiarTextProductos();

	var archivos = this.files;
	document.getElementById('galeriaProducto').files = this.files;

	multiplesArchivosProductos(archivos);

})

$(".subirGaleriaProducto").on("drop", function(e) {

	// alert("drop");

	e.preventDefault();
	e.stopPropagation();

	$(".subirGaleriaProducto").css({
		"background": ""
	})

	document.getElementById('galeriaProducto').files = e.originalEvent.dataTransfer.files;
	var archivos = document.getElementById('galeriaProducto').files;

	multiplesArchivosProductos(archivos);


})



var imagenPermitido = [];
ubicacion = [];

mensajeFinal = "ninguno"

function multiplesArchivosProductos(archivos) {

	// alert(archivos.length);
	// return;

	if (archivos.length > 0) {

		for (var i = 0; i < archivos.length; i++) {

			//  if((archivos.length+archivosTemporales.length+archivosTemporalesAntiguo.length) <= 5){
			if (archivosTemporalesAntiguo.length + i < 5) {

				mostrarLoadingProducto(); //se muestra el mensaje de cargando

				var imagen = archivos[0];

				if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {

					swal({
						title: "Error al subir la imagen",
						text: "¡La imagen debe estar en formato JPG o PNG!",
						type: "error",
						confirmButtonText: "¡Cerrar!"
					});

					cerrarLoadingProducto();
					return;

				} else if (imagen["size"] > 15000000) {

					swal({
						title: "Error al subir la imagen",
						text: "¡La imagen no debe pesar más de 15MB!",
						type: "error",
						confirmButtonText: "¡Cerrar!"
					});
					cerrarLoadingProducto();

					return;

				} else {


					ubicacion.push(imagen["name"]);

					$(".inputGaleriaProducto").val(JSON.stringify(ubicacion));

					var txtcodProducto = document.querySelector('input[name="idProductoImagen"]').value;
					var txtTokenProducto = document.querySelector('input[name="TokenProductoImagen"]').value;

					// var galeria = $(".inputGaleriaProducto").val();

					// alert(galeriaAntigua);

					var galeriaAntigua = $(".inputAntiguaGaleriaProducto").val();
					//  var galeriaAntiguaEstatica = $(".inputAntiguaGaleriaProductoEstatica").val();
					var img = document.getElementById('galeriaProducto').files[i];
					var cantidad = ubicacion.length;
					agregarImagenProducto(img, txtTokenProducto, galeriaAntigua, cantidad);



				}

			} else {

				swal({
					title: "Error al subir la imagen",
					text: "¡Está permitido como máximo 5 imagenes!",
					type: "error",
					confirmButtonText: "¡Cerrar!"
				});

				cerrarLoading()

				return;

			}

		} // termina el for                


	}

}


function verificarLoading() {

	if (archivosTemporales.length > 0) {

		mensajeFinal = "imagen";

	}

}

function mostrarLoadingProducto() {

	document.getElementById("mostrar_loadingProducto").style.display = "block";
	document.getElementById("modalBodyProducto").style.display = "none";

	// $("#titulo").html("Guardando...");

	// $('#btnGuardar').hide();
	$('#btnCerrar').hide();

}

function cerrarLoadingProducto() {

	document.getElementById("mostrar_loadingProducto").style.display = "none";
	document.getElementById("modalBodyProducto").style.display = "block";

	// $("#btnGuardar").prop('disabled', false);
	// $("#btnCerrar").prop('disabled', false);

	// $('#btnGuardar').show();
	$('#btnCerrar').show();

}



/*=========================================================
AGREGAR EN LA BASE DE DATOS LA IMAGEN DE VISTA DE PRODUCTOS
===========================================================*/
var c = 0;

function agregarImagenProducto(img, token, rutavieja, cant) {

	datosMultimedia = new FormData();


	// console.log(document.getElementById('galeriaProducto').files.length);

	//   for(var i = 0; i < document.getElementById('galeriaProducto').files.length; i++){


	//   console.log("img", img);
	//  var ruta =document.getElementById('galeriaProducto').files[i]["name"];
	// console.log("ruta", ruta);
	// return;

	datosMultimedia.append("tabla", "productos");
	datosMultimedia.append("token", token);
	datosMultimedia.append("token_columna", "TOKEN_PRODUCTO");
	datosMultimedia.append("rutavieja", rutavieja);
	datosMultimedia.append("foto_columna", "IMAGEN_PRODUCTO");
	datosMultimedia.append("file", img);
	datosMultimedia.append("carpeta", "productos");

	$.ajax({

		type: "POST",
		url: "ajax/multimedia.ajax.php",
		dataType: "json",
		contentType: false,
		processData: false,
		cache: false,
		data: datosMultimedia,

		xhr: function() {

			var xhr = $.ajaxSettings.xhr();

			xhr.onprogress = function(evt) {

				var porcentaje = Math.floor((evt.loaded / evt.total * 100));

			};

			return xhr;

		},
		beforeSend: () => {

			$("#btnGuardar").prop('disabled', true);
			//   document.getElementById("mostrar_loading").style.display = "block";

		}

	}).done(res => {

		if (res.status === 200) {

			// cerrarLoading();

			c = cant - 1;
			//    console.log("cant", c);

			if (c == 0) {
				ubicacion = [];
				c = 0;
				cerrarLoadingProducto();
				swal("success", res.msg, "success");
				var token_producto = "0/" + $('#TokenProductoImagen').val();
				// LimpiarTextProductos();
				tablasCombos.ajax.reload(function() {
					verImagenProductos(token_producto);
					formProductoImagen.reset();

				});



			}

		} else {

			alert(res.msg);

		}

	}).fail(err => {

		// cerrarLoading();

		swal("Error", err.msg, "error");
		return;

	})

	//    }


}


/*=============================================
 MOSTRAR IMAGENES DE PRODUCTOS
 =============================================*/

$(document).on("click", ".verProductos", function() {


	var token_producto = $(this).attr("tokenProductos");
	verImagenProductos(token_producto);


})

function verImagenProductos(token_producto) {

	var cadena = token_producto.split("/");

	$("#idProductoImagen").val(cadena[0]);
	$("#TokenProductoImagen").val(cadena[1]);

	var datos = new FormData();

	datos.append("token", token_producto);

	$.ajax({

		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {

			archivosTemporalesAntiguo = [];

			// COLOCAR LAS IMAGENES

			// $(".inputAntiguaGaleriaProductoEstatica").val((respuesta["IMAGEN_PRODUCTO"]));

			if (respuesta["IMAGEN_PRODUCTO"] != '[""]' && respuesta["IMAGEN_PRODUCTO"] != null && respuesta["IMAGEN_PRODUCTO"] != '') {

				multiplesArchivosAntiguosProductos(respuesta["IMAGEN_PRODUCTO"]);

			}


		}


	})


}



/*=============================================
Eliminar PRODUCTOS
=============================================*/

$(document).on("click", ".eliminarProductos", function() {

	var tokenProductos = $(this).attr("tokenProductos");
	var galeria = $(this).attr("galeria");
	var token_stock = $(this).attr("token_stock");
	swal({
		title: '¿Está seguro de eliminar este registro?',
		text: "¡Si no lo está puede cancelar la acción!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, eliminar el dato!',
		closeOnConfirm: false,
		closeOnCancel: true
	}, function(isConfirm) {

		if (isConfirm) {

			var datos = new FormData();
			datos.append("idEliminar", tokenProductos);
			datos.append("galeria", galeria);
			datos.append("token_stock", token_stock);

			$.ajax({

				url: "ajax/productos.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function(respuesta) {

					var objData = JSON.parse(respuesta);

					if (objData.status) {

						swal("success", objData.msg, "success");
						tablasCombos.ajax.reload(function() {


						});


					} else {
						swal("Error", objData.msg, "error");

						if (objData.msg == "No es posible Eliminar el dato, el mismo está siendo usado.") {

							swal({
								title: 'No es posible Eliminar el dato, el mismo está siendo usado. ¿Deseas dar de baja?',
								text: "¡Si no lo está puede cancelar la acción!",
								type: 'warning',
								showCancelButton: true,
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								cancelButtonText: 'Cancelar',
								confirmButtonText: 'Si, dar de baja!',
								closeOnConfirm: false,
								closeOnCancel: true
							}, function(isConfirm) {

								if (isConfirm) {
									//descactivar productos

									var datos = new FormData();

									datos.append("desactivarToken", token_stock);
									datos.append("estadoProducto", 0);


									$.ajax({

										url: "ajax/productos.ajax.php",
										method: "POST",
										data: datos,
										cache: false,
										contentType: false,
										processData: false,
										success: function(respuesta) {



											var objData = JSON.parse(respuesta);

											if (objData.status) {

												swal("success", objData.msg, "success");
												tablasCombos.ajax.reload(function() {


												});


											}

										}

									})

								}

							});

						}
					}

				}

			})

		}

	});

})

/*=============================================
DESACTIVAR PRODUCTOS
=============================================*/

$(document).on("click", ".btnActivarProducto", function() {

	var token_stock = $(this).attr("token_stock");
	var estadoProducto = $(this).attr("estadoProducto");
	swal({
		title: '¿Está seguro de desactivar el combo?',
		text: "¡Si no lo está puede cancelar la acción!..¡Puedes volver a recuperar en el modulo dar de alta!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, desactiar el dato!',
		closeOnConfirm: false,
		closeOnCancel: true
	}, function(isConfirm) {

		if (isConfirm) {

			var datos = new FormData();

			datos.append("desactivarToken", token_stock);
			datos.append("estadoProducto", estadoProducto);


			$.ajax({

				url: "ajax/productos.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function(respuesta) {

					var objData = JSON.parse(respuesta);

					if (objData.status) {

						swal("success", objData.msg, "success");
						tablasCombos.ajax.reload(function() {


						});



					}

				}

			})

		}

	});

})


setInterval(function() {
	if ($('.CargarCombos').is(':visible')) {
		if (localStorage.getItem("listaProductosCombos") != null) {
			listarProductosCombos();
		}

	}

}, 4000);