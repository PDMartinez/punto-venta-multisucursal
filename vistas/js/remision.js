window.addEventListener('load', function() {

  $('.btncancelar').prop('disabled', true);

});

var generales = document.getElementById('idSucursal');

var tablaVerRemision = $(".tablasVerRemision").DataTable({

  "ajax": "ajax/remision.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + generales.getAttribute("activo") + " &txtfechaInicial=0&txtfechaFinal=0&var=0",
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

var contadortabladetalle = 1;

$(document).on("click", ".detalleRemision", function() {

  var token_remision = $(this).attr("tokenRemision");

  if (contadortabladetalle == 1) {

    var tablasDetRemision = $(".tablasDetRemision").DataTable({

      "ajax": "ajax/remision.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + generales.getAttribute("activo") + " &token_remisiones=" + token_remision,
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
    contadortabladetalle = 0;
  } else {
    $(".tablasDetRemision").DataTable().ajax.url("ajax/remision.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + generales.getAttribute("activo") + " &token_remisiones=" + token_remision).load();
  }

})



function consultarRango(fechaInicial, fechaFinal) {

  var general = document.getElementById('idSucursal');
  $(".tablasVerRemision").DataTable().ajax.url("ajax/remision.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + generales.getAttribute("activo") + " &txtfechaInicial=" + fechaInicial + "&txtfechaFinal=" + fechaFinal).load();

}



/*=============================================
CLONAR REMISION
=============================================*/

$(document).on("click", ".clonarRemision", function() {

  cargarProductos();

  var token_remision = $(this).attr("tokenRemision");

  ClonarRemision(token_remision);

})

function ClonarRemision(token_remision) {

  localStorage.removeItem("listaProductosRemision");

  document.querySelector("#titulo").innerHTML = "Clonar remision";
  document.querySelector("#btnGuardar").innerHTML = "Clonar remision";

  var general = document.getElementById('idSucursal');
  var sucursal = $('#idSucursal').val();
  var activo = generales.getAttribute("activo");


  var datos = new FormData();

  datos.append("token_remision", token_remision);
  datos.append("sucursal", sucursal);
  datos.append("activo", activo);

  $.ajax({

    url: "ajax/remision.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      for (var i = 0; i < respuesta.length; i++) {

        var idProducto = respuesta[i]["TOKEN_PRODUCTO"];
        var token_producto = respuesta[i]["COD_PRODUCTO"] + "/" + respuesta[i]["TOKEN_PRODUCTO"];
        var cantidadProducto = respuesta[i]["CANTIDAD"];
        var botones = $("button.btnAgregarProducto[idProducto='" + idProducto + "']");

        agregarProductos(token_producto, idProducto, sucursal, cantidadProducto, botones);


        if (i == 0) {
          var sucursal_a = respuesta[i]["SUCURSAL_A"] + "/" + respuesta[i]["TOKEN_SUCURSAL"];

          $("#txtObservacion").val(respuesta[i]["OBSERVACION"]);
          $("#cmbSucursalHasta").val(sucursal_a);

        }


      }

      $("#txtPrecioVenta").number(true, 0);



    }

  })

}



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
      localStorage.removeItem("listaProductosRemision");
      window.location = "remision"

    }

  });


})


// NUEVO BOTONES

$(document).on("click", ".btnNuevo", function() {

  document.querySelector("#titulo").innerHTML = "Nueva remisión";
  document.querySelector("#btnGuardar").innerHTML = "Guardar remisión";

  cargarProductos();


  if (localStorage.getItem("listaProductosRemision") != null) {
    var sucursal = $("#idSucursal").val();

    var listasRemision = JSON.parse(localStorage.getItem("listaProductosRemision"));

    for (var i = 0; i < listasRemision.length; i++) {
      var separador = listasRemision[i]["id"].split("/");
      var idProducto = separador[1];
      var token_producto = listasRemision[i]["id"];
      var cantidadProducto = listasRemision[i]["cantidad"];
      var botones = $("button.btnAgregarProducto" + idProducto);

      agregarProductos(token_producto, idProducto, sucursal, cantidadProducto, botones);


      if (i == 0) {

        $("#txtObservacion").val(listasRemision[i]["observacion"]);
        $("#cmbSucursalHasta").val(listasRemision[i]["sucursalDonde"]);


      }


    }

    // quitarAgregarProducto();

    $("#txtPrecioVenta").number(true, 0);


  }



})



$(document).on("click", ".btnListar", function() {

  if ($('.tablasVerRemision > * > tr').length - 1 > 0) {

    $(".tablasVerRemision").DataTable().ajax.reload();

  }

  $(".ListarContenido").removeClass("notblock");
  $(".CargarRemision").addClass("notblock");
  formRemision.reset();
  $("#tablaRemision td").remove();



})

// ES PARA GUARDAR LOS DATOS EN LA BASE DE DATOS//


function Guardarformulario() {

  var txtremision = document.querySelector('input[name="nuevaRemision"]').value;
  var txtUsuario = document.querySelector('input[name="idUsuario"]').value;
  var txtidSucursal = document.querySelector('input[name="idSucursal"]').value;
  var cmbSucursalhasta = $("#cmbSucursalHasta").val();
  var txtproductos = $("#listaProductos").val();
  var txtObservaciones = document.querySelector('textarea[name="txtObservacion"]').value;
  var txtpreciototal = document.querySelector('input[name="txtTotal"]').value;

  var totalTalba = txtproductos.length;

  if (txtproductos.length <= 2) {
    swal({
      title: "Cargue un producto",
      type: "error",
      confirmButtonText: "¡Cerrar!"

    })
    return false;
  }
  var datos = new FormData();
  datos.append("txtremision", txtremision);
  datos.append("txtUsuario", txtUsuario);
  datos.append("txtidSucursal", txtidSucursal);
  datos.append("cmbSucursalhasta", cmbSucursalhasta);
  datos.append("txtproductos", txtproductos);
  datos.append("txtObservaciones", txtObservaciones);
  datos.append("txtpreciototal", txtpreciototal);

  $.ajax({
    url: "ajax/remision.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,

    success: function(respuesta) {

      var objData = JSON.parse(respuesta);

      if (objData.status) {
        //   $('#ModalProductos').modal('hide');

        formRemision.reset();
        swal("success", objData.msg, "success");
        if ($('input[name="idRemision"]').val() == "") {
          localStorage.removeItem("listaProductosRemision");
        }

        recargarDatatable();

        window.location = "remision";

      } else {
        swal("Error", objData.msg, "error");
      }
    }

  })

  return (false);


}

$(document).on("change", "#cmbSucursalHasta", function() {
  var sucursalactual = $('#idSucursal').val();
  var sucursalotros = $('#cmbSucursalHasta').val();

  if (sucursalactual == sucursalotros) {
    swal({
      title: "Seleccione una sucursal diferente!!!",
      type: "error",
      confirmButtonText: "¡Cerrar!"
    })
    document.getElementById("cmbSucursalHasta").selectedIndex = 0;

  }


  listarProductosRemision();

})


$(document).on("click", "#ProductoSucursalActual", function() {
  $(".tablaProductos").DataTable().ajax.url("ajax/tablaProductosRemision.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + "&actual=" + 0 + "&tipo_producto=SOLITARIO").load();

});

$(document).on("click", "#ProductoActivoOtros", function() {

  $(".tablaProductos").DataTable().ajax.url("ajax/tablaProductosRemision.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + "&actual=" + 1 + "&tipo_producto=SOLITARIO").load();

});

$(document).on("change", "#txtObservacion", function() {

  listarProductosRemision();
});



function cargarProductos() {
  $(".ListarContenido").addClass("notblock");
  $(".CargarRemision").removeClass("notblock");

  $('.tablaProductos').DataTable({
    "ajax": "ajax/tablaProductosRemision.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + "&actual=" + 0 + " &tipo_producto=SOLITARIO",
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


var cont = 0;
// Agregar productos en la tablas
$(".tablaProductos tbody").on("click", "button.btnAgregarProducto", function() {

  var token_producto = $(this).attr("tokenProducto");
  var idProducto = $(this).attr("idProducto");
  var sucursal = $("#idSucursal").val();

  let cantidadProducto = "";
  cantidadProducto = prompt("¡Ingese la cantidad!", 1);

  if (cantidadProducto != null) {

    cantidadProducto = cantidadProducto.replace(/,/g, '.');

    while (isNaN(cantidadProducto) || cantidadProducto == "" || cantidadProducto <= 0) {
      cantidadProducto = prompt("¡Ingese la cantidad!", 1);
    };

    // $(this).removeClass("btn-success btnAgregarProducto");
    // $(this).addClass("btn-secondary");

  } else {
    // $(this).removeClass("btn-secondary");
    // $(this).addClass("btn-success btnAgregarProducto");
    return false;
  }

  agregarProductos(token_producto, idProducto, sucursal, cantidadProducto, $(this));

});

var tipos = "SOLITARIO";

function agregarProductos(token_producto, idProducto, sucursal, cantidadProducto, botones) {

  var tipo_productos = tipos;

  var activo = 1;

  var datos = new FormData();
  datos.append("token_producto", token_producto);
  datos.append("sucursal", sucursal);
  datos.append("activo", activo);
  datos.append("tipo_producto", tipos);
  $.ajax({

    url: "ajax/remision.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      botones.removeClass("btn-success btnAgregarProducto");
      botones.addClass("btn-secondary");
      var precioNeto = 0;
      var codigobarra = respuesta["CODBARRA"]
      var descripcion = respuesta["PRODUCTOS"];
      var precio = respuesta["PRECIO_COMPRA"];
      precioNeto = cantidadProducto * precio;

      cont++;
      token_producto = token_producto.replace(/'\'/g, '');
      var f;


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

      $("#tablaRemision").append(f);


      localStorage.removeItem("quitarProducto");

      //SUMAR LOS PRECIOS
      sumarTotalPrecios();
      // PONER FORMATO AL PRECIO DE LOS PRODUCTOS

      $(".nuevoPrecioProducto").number(true, 0);
      $(".nuevoSubTotal").number(true, 0);

      //listar producto en formato json

      listarProductosRemision();
      cantidadItems();
      // $.notify({
      //  title: "Combos: ",
      //  message: "Operación exitosa!!!",
      //  icon: 'fa fa-check'
      // }, {
      //  type: "success"
      // });

    }
  });
}

function cantidadItems() {
  const tableRows = document.querySelectorAll('#tablaRemision tr.rowNuevo');
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
  listarProductosRemision();

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

$(".formularioRemision").on("change", "input.nuevaCantidadProducto", function() {
  var idProducto = $(this).attr("idProducto");

  var precio = $(this).parent().parent().parent().parent().children(".tdNuevoPrecio" + idProducto).children(".nuevoPrecio" + idProducto).children().children(".nuevoPrecioProducto").val();

  var precioNeto = $(this).parent().parent().parent().parent().children(".tdNuevoSubTotal" + idProducto).children(".nuevoSubTotal" + idProducto).children().children(".nuevoSubTotal");

  var stock = $(this).attr("stock");

  var stockCargada = $(this).val();
  stockCargada = stockCargada.replace(/,/g, '.');

  var precioFinal = stockCargada * precio;

  precioNeto.val(precioFinal);

  if (Number(stockCargada) > Number(stock)) {

    /*=============================================
    SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
    =============================================*/

    stockCargada = 1
    $(this).val(stockCargada);
    var precioFinal = stockCargada * precio;


    precioNeto.val(precioFinal);
    //$(this).parent().parent().parent().parent().children(".tdNuevoSubTotal").children().children().children(".nuevoSubTotal").val(precioNeto);


    swal({
      title: "La cantidad supera el Stock",
      text: "¡Sólo hay " + $(this).attr("stock") + " unidades!",
      type: "error",
      confirmButtonText: "¡Cerrar!"
    });

    return;

  }


  sumarTotalPrecios()

  listarProductosRemision()

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

}

$("#txtTotal").number(true, 0)
$("#txtTotalArticulos").number(true, 0)


/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductosRemision() {

  var listaProductosStore = [];

  var listaProductos = [];
  var descripcion = $(".nuevaDescripcionProducto");
  var cantidad = $(".nuevaCantidadProducto");
  var sucusalDonde = $("#cmbSucursalHasta");
  var precio = $(".nuevoPrecioProducto");
  var precioNeto = $(".nuevoSubTotal");
  var observacion = $("#txtObservacion");
  var idProducto = $(".nuevaDescripcionProducto").attr("idProducto")


  for (var i = 0; i < descripcion.length; i++) {

    listaProductosStore.push({
      "id": $(descripcion[i]).attr("idProducto"),
      "cantidad": $(cantidad[i]).val(),
      "sucursalDonde": $(sucusalDonde[i]).val(),
      "observacion": $(observacion[i]).val()
    })


    listaProductos.push({
      "id": $(descripcion[i]).attr("idProducto"),
      "precio": $(precio[i]).val(),
      "total": $(precioNeto[i]).val(),
      "cantidad": $(cantidad[i]).val()
    })

  }

  $("#listaProductos").val(JSON.stringify(listaProductos));
  if ($('input[name="idRemision"]').val() == "") {
    localStorage.setItem("listaProductosRemision", JSON.stringify(listaProductosStore));
  }

  // $.notify({
  //   title: "Remision: ",
  //   message: "Operación exitosa!!!",
  //   icon: 'fa fa-check'
  // }, {
  //   type: "success"
  // });
  //console.log((JSON.stringify(listaProductos))); 

}

/*=============================================
ANULAR PEDIDOS
=============================================*/
$(".tablasVerRemision").on("click", ".eliminarRemision", function() {

  var tokenRemision = $(this).attr("tokenRemision");
  var tokenSucursal = $(this).attr("tokenSucursal");
  var estado = $(this).attr("estado");
  var usuario = $("#idUsuario").val();
  var sucursal = $("#idUsuario").val();

  if (estado == 1) {

    swal({
      title: '¿Está seguro de anular este registro?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, anular el dato!',
      closeOnConfirm: false,
      closeOnCancel: true
    }, function(isConfirm) {

      if (isConfirm) {

        let descripcion = "";
        descripcion = prompt("¡Ingese Una descripcion de la anulación!");

        if (descripcion != null) {

          while (descripcion == "") {
            descripcion = prompt("¡Ingese Una descripcion de la anulación!");
          };

        } else {

          return false;
        }

        var datos = new FormData();

        datos.append("tokenRemision", tokenRemision);
        datos.append("estado", estado);
        datos.append("usuario", usuario);
        datos.append("descripcion", descripcion);
        datos.append("tokenSucursal", tokenSucursal);

        $.ajax({

          url: "ajax/remision.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta) {
            var objData = JSON.parse(respuesta);

            if (objData.status) {
              swal("success", objData.msg, "success");
              tablaVerRemision.ajax.reload(function() {

              });

            } else {
              swal("Error", objData.msg, "error");
            }

          }

        })

      }

    });

  } else {
    swal({
      title: '¿Está seguro de recuperar este registro?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, recuperar el dato!',
      closeOnConfirm: false,
      closeOnCancel: true
    }, function(isConfirm) {

      if (isConfirm) {

        let descripcion = "";
        descripcion = prompt("¡Ingese Una descripcion de la recuperacion!");

        if (descripcion != null) {

          while (descripcion == "") {
            descripcion = prompt("¡Ingese Una descripcion de la recuperacion!");
          };

        } else {

          return false;
        }

        var datos = new FormData();
        datos.append("tokenRemision", tokenRemision);
        datos.append("estado", estado);
        datos.append("usuario", usuario);
        datos.append("descripcion", descripcion);
        datos.append("tokenSucursal", tokenSucursal);

        $.ajax({
          url: "ajax/remision.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta) {
            var objData = JSON.parse(respuesta);

            if (objData.status) {
              swal("success", objData.msg, "success");
              tablaVerRemision.ajax.reload(function() {

              });

            } else {
              swal("Error", objData.msg, "error");
            }

          }
        })

      }

    });
  }

  //}
})


$(document).on("click", ".cancelBtn", function() {
  $("#daterange-btn span").html('<i class="fa fa-calendar"></i> Movimiento hoy');

  consultarRango(0, 0);
})


/*=============================================
RANGO DE FECHAS
=============================================*/
$('#daterange-btn').daterangepicker({
    ranges: {
      'Hoy': [moment(), moment()],
      'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
      'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
      'Este mes': [moment().startOf('month'), moment().endOf('month')],
      'Últimos mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate: moment()
  },

  function(start, end) {

    $('#daterange-btn span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));

    var fechaInicial = start.format('YYYY-MM-DD');

    var fechaFinal = end.format('YYYY-MM-DD');

    consultarRango(fechaInicial, fechaFinal);


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

function recargarDatatable() {

  if ($('.tablaRemision > * > tr').length - 1 > 0) {
    $(".tablasVerRemision").DataTable().ajax.reload();
    $(".ListarContenido").removeClass("notblock");
    $(".CargarRemision").addClass("notblock");
    formRemision.reset();
    $("#tablaRemision td").remove();
  }


}



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


// const getReminTime=deadline=>{
// 	let now=new Date();
// 	remainTime=(new Date(deadline) - now+1000)/1000,
// 	remainSecounds=('0'+Math.floor(remainTime % 60)).slice(-2),
// 	remainMinutes=('0'+Math.floor(remainTime / 60 % 60)).slice(-2),
// 	remainHours=('0'+Math.floor(remainTime / 3600 % 24)).slice(-2),
// 	reaminDays=Math.floor(remainTime/(3600*24));

// 	return{
// 		remainTime,
// 		remainSecounds,
// 		remainMinutes,
// 		remainHours,
// 		reaminDays
// 	}
// };

// console.log(getReminTime('Fri Jan 22 2021 06:36:23 GMT-0300'));

setInterval(function() {
 if ($('.CargarRemision').is(':visible')) {
    if (localStorage.getItem("listaProductosRemision") != null) {
      listarProductosRemision();
    }

  }

}, 4000);