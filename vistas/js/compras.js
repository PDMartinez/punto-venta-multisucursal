/*=============================================
 CUANDO SE TERMINE DE CARGAR LA PAGINA INGRESA
=============================================*/

window.addEventListener('load', function() {

  $('#btnagregarMetodopago').prop('disabled', true);
  $('.btncancelar').prop('disabled', true);

});

// function mensajeEmergente(titulo, mensaje, icono, tipo) {
//   $.notify({
//     title: titulo,
//     message: mensaje,
//     icon: icono
//   }, {
//     type: tipo
//   });
// }

$("#txtentregaEfectivo").change(function() {

  if (Number($("#txtentregaEfectivo").val()) != "" || Number($("#txtentregaEfectivo").val()) > 0) {
    if (Number($("#txtentregaEfectivo").val()) > Number($("#txtTotal").val())) {
      $("#txtentregaEfectivo").val($("#txtTotal").val());
      $('#btnagregarMetodopago').prop('disabled', true);
      mensajeEmergente("ERROR: ", "La entrega no puede ser mayor al total!", "fa fa-check", "info");

    } else {

      if (Number($("#txtentregaEfectivo").val()) < Number($("#txtTotal").val())) {

        $('#btnagregarMetodopago').prop('disabled', false);
        crearBotonesEntrega();

      }

    }
  } else {
    $("#txtentregaEfectivo").val($("#txtTotal").val());
    $("#txtentregaEfectivo").number(true, 0);
    $('#btnagregarMetodopago').prop('disabled', true);
  }


})

contadornuevo = 0;
$(document).on("click", "#btnagregarMetodopago", function() {
  crearBotonesEntrega();

})

function crearBotonesEntrega() {
  var m;
  contadornuevo++;
  CombosPagos();
  m = `<div class="metodo` + contadornuevo + `">
        <div class="card-body">
          <blockquote class="card-blockquote"> 
            <label>Seleccione método de pago</label>
            <div class="input-group mb-auto">
                <select class="form-control Metodonuevopago Metodonuevopago` + contadornuevo + `">
                  <option value="">Seleccione método de pago</option>
                                      
                  </select>   

              <div class="input-group-append">
                  <button class='btn btn-danger btn-sm btnagregarEliminar btnagregarEliminar` + contadornuevo + `' type="button"> <i class="fas fa-trash-alt"></i></button>
              </div> 

            </div>
                <div class="form-row">           
                    
                     <div  class="form-group col-md-6 Efectivo">

                       <label for="txtentregaEfectivo">Entrega gs.</label>
                       <input class="form-control txtentregaEfectivo txtentregaEfectivo` + contadornuevo + `" name="txtentregaEfectivo" type="text" onkeyup="format(this)" onchange="format(this)" > 

                    </div>

                       <div class="form-group col-md-6">
                  
                        <div class="form-group">
                        <label class="NroMovimiento NroMovimiento` + contadornuevo + `" for="txtnroRecibo">Nº Movimiento</label>
                       <input class="form-control txtnroRecibo txtnroRecibo` + contadornuevo + `" type="text" placeholder="Nº transacción">
                      </div>

                    </div>

                 
                </div>
            </blockquote>
      </div>
    </div>`;



  $(".metodopago").append(m);

  //  console.log("contadornuevo", contadornuevo);

  if (contadornuevo > 1) {

    var cant = contadornuevo - 1;
    $('.btnagregarEliminar' + cant).prop('disabled', true);
    $('.txtentregaEfectivo' + cant).prop('disabled', true);

  } else if (contadornuevo = 1) {

    var resto = $("#txtTotal").val().replace(/\./g, '') - Number($("#txtentregaEfectivo").val().replace(/\./g, ''))
    $(".txtentregaEfectivo" + contadornuevo).val(resto);
    $(".txtentregaEfectivo" + contadornuevo).number(true, 0);
    $('#txtentregaEfectivo').prop('disabled', true);
    $('#btnagregarMetodopago').prop('disabled', true);
  }


  cargarMetodoPago(contadornuevo);
}

//const entregaDinamico;

/*=============================================
  CARGAR METOOD DE PAGO
=============================================*/

function cargarMetodoPago(selectValue) {

  var item = null;
  var valor = null;
  var option = "";
  var selectOption = [];

  // console.log("token_caja");
  // return;

  var datos = new FormData();

  datos.append("item", item);
  datos.append("valor", valor);


  $.ajax({

    url: "ajax/compras.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      // console.log(respuesta);

      $.each(respuesta, function(i, value) {

        $(".Metodonuevopago" + selectValue).append(

          '<option value="' + value["COD_FORMAPAGO"] + '/' + value["TOKEN_FORMAPAGO"] + '">' + value["DESCRIPCION_FORMA"] + '</option>'

        );


      });

    }

  })

};

function CombosPagos() {
  var listaMetodoPagos = [];
  //    for (let i = 1; i <= contadornuevo; i++) {

  // }

  var metodopago = $(".Metodonuevopago");
  var entrega = $(".txtentregaEfectivo");
  var nrotransaccion = $(".txtnroRecibo");
  for (var i = 0; i < metodopago.length; i++) {


    listaMetodoPagos.push({
      "id_metodo": $(metodopago[i]).val(),
      "entrega": $(entrega[i]).val(),
      "nrotransaccion": $(nrotransaccion[i]).val()
    })


  }

  nuevaListaModoPagos = JSON.stringify(listaMetodoPagos);
 
}

var nuevaListaModoPagos = [];

$(document).on("change", ".Metodonuevopago", function() {
  CombosPagos();
})


$(document).on("click", ".btnagregarEliminar", function() {
  var valor = Number($('.txtentregaEfectivo' + contadornuevo).val());

  $("div").remove(".metodo" + contadornuevo);
  contadornuevo--;
  $('.btnagregarEliminar' + contadornuevo).prop('disabled', false);
  $('.txtentregaEfectivo' + contadornuevo).prop('disabled', false);

  if (contadornuevo <= 0) {
    $('#txtentregaEfectivo').prop('disabled', false);
    valor = valor + Number($('#txtentregaEfectivo').val());
    $('#txtentregaEfectivo').val(valor);
  } else {
    valor = valor + Number($('.txtentregaEfectivo' + contadornuevo).val());
    $('.txtentregaEfectivo' + contadornuevo).val(valor);
  }
  CombosPagos();
})

$(document).on("change", ".txtentregaEfectivo", function() {

  recorrerSuma();
})

$(document).on("change", ".txtnroRecibo", function() {

  CombosPagos();
})


function recorrerSuma() {
  var totalentrega = 0;
  var resto = 0;
  var valor = 0;
  if (contadornuevo > 0) {


    for (let i = 1; i <= contadornuevo; i++) {

      valor = Number($(".txtentregaEfectivo" + i).val().replace(/\./g, ''));
      if (valor > 0 || valor != "") {


        if (i == 1) {
          resto = Number($("#txtTotal").val().replace(/\./g, '')) - valor - Number($("#txtentregaEfectivo").val().replace(/\./g, ''));
        }

        if (i == 1 && contadornuevo == 1) {

          if (resto > 0) {
            $('#btnagregarMetodopago').prop('disabled', false);
            crearBotonesEntrega();
            $(".txtentregaEfectivo" + contadornuevo).val(resto);
            $(".txtentregaEfectivo" + contadornuevo).number(true, 0);
            $('#btnagregarMetodopago').prop('disabled', true);
            return false;

          } else if (resto == 0) {

            $('#btnagregarMetodopago').prop('disabled', true);

          } else {

            resto = valor + resto;
            $(".txtentregaEfectivo" + contadornuevo).val(resto);
            $(".txtentregaEfectivo" + contadornuevo).number(true, 0);
            $('#btnagregarMetodopago').prop('disabled', true);


          }

        }

        if (i == 2 && contadornuevo == 2) {
          resto -= valor;
          if (resto > 0) {
            $('#btnagregarMetodopago').prop('disabled', false);
            crearBotonesEntrega();
            $(".txtentregaEfectivo" + contadornuevo).val(resto);
            $(".txtentregaEfectivo" + contadornuevo).number(true, 0);
            $('#btnagregarMetodopago').prop('disabled', true);
            return false;
          } else if (resto == 0) {

            $('#btnagregarMetodopago').prop('disabled', true);

          } else {

            resto = valor + resto;
            $(".txtentregaEfectivo" + contadornuevo).val(resto);
            $(".txtentregaEfectivo" + contadornuevo).number(true, 0);
            $('#btnagregarMetodopago').prop('disabled', true);


          }

        } else if (i == 2 && contadornuevo > 2) {
          resto -= valor;
        }

        if (i == 3 && contadornuevo == 3) {
          resto -= valor;
          if (resto > 0) {
            $('#btnagregarMetodopago').prop('disabled', false);
            crearBotonesEntrega();
            $(".txtentregaEfectivo" + contadornuevo).val(resto);
            $(".txtentregaEfectivo" + contadornuevo).number(true, 0);
            $('#btnagregarMetodopago').prop('disabled', true);
            return false;
          } else if (resto == 0) {

            $('#btnagregarMetodopago').prop('disabled', true);

          } else {

            resto = valor + resto;
            $(".txtentregaEfectivo" + contadornuevo).val(resto);
            $(".txtentregaEfectivo" + contadornuevo).number(true, 0);
            $('#btnagregarMetodopago').prop('disabled', true);


          }

        } else if (i == 3 && contadornuevo > 3) {
          resto -= valor;
        }


        if (i == 4 && contadornuevo == 4) {
          resto -= valor;
          if (resto > 0) {
            $('#btnagregarMetodopago').prop('disabled', false);
            crearBotonesEntrega();
            $(".txtentregaEfectivo" + contadornuevo).val(resto);
            $(".txtentregaEfectivo" + contadornuevo).number(true, 0);
            $('#btnagregarMetodopago').prop('disabled', true);
            return false;
          } else if (resto == 0) {

            $('#btnagregarMetodopago').prop('disabled', true);

          } else {

            resto = valor + resto;
            $(".txtentregaEfectivo" + contadornuevo).val(resto);
            $(".txtentregaEfectivo" + contadornuevo).number(true, 0);
            $('#btnagregarMetodopago').prop('disabled', true);


          }

        } else if (i == 4 && contadornuevo > 4) {
          resto -= valor;
        }

        if (i == 5 && contadornuevo == 5) {
          resto -= valor;
          if (resto > 0) {
            $('#btnagregarMetodopago').prop('disabled', false);
            crearBotonesEntrega();
            $(".txtentregaEfectivo" + contadornuevo).val(resto);
            $(".txtentregaEfectivo" + contadornuevo).number(true, 0);
            $('#btnagregarMetodopago').prop('disabled', true);
            $(".txtentregaEfectivo" + contadornuevo).prop('disabled', true);
            return false;
          } else if (resto == 0) {

            $('#btnagregarMetodopago').prop('disabled', true);

          } else {

            resto = valor + resto;
            $(".txtentregaEfectivo" + contadornuevo).val(resto);
            $(".txtentregaEfectivo" + contadornuevo).number(true, 0);
            $('#btnagregarMetodopago').prop('disabled', true);


          }

        }


      } else {
        mensajeEmergente("ERROR: ", "La entrega debe ser mayor a cero! o no debe estar vacio", "fa fa-money", "info");
        return false;
      }

    }


  } else {
    $("#txtentregaEfectivo").val($("#txtTotal").val());
    $('#btnagregarMetodopago').prop('disabled', true);
  }



}

var generales = document.getElementById('idSucursal');

var tablaVerCompra = $(".tablasVerCompra").DataTable({

  "ajax": "ajax/compras.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + generales.getAttribute("activo") + " &txtfechaInicial=0&txtfechaFinal=0&var=0",
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

function montocuota(cuota) {

  var total = $("#txtTotal").val();
  var cuotas = cuota;
  var montocuota = total / cuotas

  if (total <= 0) {
    $("#txtMontoCuota").val(0);

  } else {

    $("#txtMontoCuota").val(Math.round(montocuota));
    $("#txtMontoCuota").number(true, 0)
  }


}

$("#txtCantidadCuota").change(function() {
  montocuota($(this).val());
})


$("#txtdescuentoTotal").change(function() {

  descuentoTotal();


})



function descuentoTotal() {
  const tableRows = document.querySelectorAll('#tablaCompra tr.rowNuevo');
  // console.log("tableRows", tableRows);
  // console.log("tableRows", tableRows.length);

 
  if ($("#txtdescuentoTotal").val() != "" && $("#txtdescuentoTotal").val() > 0 && Number($("#txtdescuentoTotal").val().replace(/\./g, '')) <= Number($("#txtTotalArticulos").val())) {
    // console.log("totalproducto", $("#txtTotalArticulos").val());
    // console.log("descuento", $("#txtdescuentoTotal").val());


    // console.log("tableRows.length", tableRows.length);
    for (let o = 0; o < tableRows.length; o++) {

      const row = tableRows[o];
      const Precio = row.querySelector('.nuevoPrecioProducto').value;
      Preciocompra = Precio.replace(/\./g, '');

      const IdProductoD = row.querySelector('.nuevoDescuentoProducto');
      idProducto = IdProductoD.getAttribute('idProducto');
      const cantidad = row.querySelector('.nuevaCantidadProducto').value;
      var PrecioNeto = (cantidad * Preciocompra);
      var total = Sumaproductos;
      var Descuentototal = $("#txtdescuentoTotal").val().replace(/\./g, '');
      var restoPorcentaje = (Preciocompra * 100) / total;
      //console.log("restoPorcentaje", restoPorcentaje);
      var descuentoUni = (Descuentototal * restoPorcentaje) / 100;
      //console.log("descuentoUni", descuentoUni);
      var NuevoPrecio = PrecioNeto - descuentoUni;
      // console.log("NuevoPrecio", NuevoPrecio);

      $(".nuevoDescuentoProducto" + idProducto).val(Math.round(descuentoUni));
      $(".nuevoDescuentoProducto").number(true, 0);
      $(".nuevoSubTotal" + idProducto).val(Math.round(NuevoPrecio));
      $(".nuevoSubTotal").number(true, 0);
      $(".txtdescuentoTotal").number(true, 0);

    }


  } else {

    // console.log("tableRows.length", tableRows.length);
    for (let o = 0; o < tableRows.length; o++) {

      const row = tableRows[o];
      // console.log("row", row);
      const Precio = row.querySelector('.nuevoPrecioProducto').value;
      //console.log("Precio", Precio);
      Preciocompra = Precio.replace(/\./g, '');
      const cantidad = row.querySelector('.nuevaCantidadProducto').value;


      //  cantidadnuevo = cantidad.getElementsByClassName("domTextElement").value;
      //console.log("PrecioNeto", PrecioNeto);
      const IdProductoD = row.querySelector('.nuevoDescuentoProducto');
      idProducto = IdProductoD.getAttribute('idProducto');
      row.querySelector('.nuevoDescuentoProducto').value=0;
      const descuentoN = row.querySelector('.nuevoDescuentoProducto').value;
      descuento = descuentoN.replace(/\./g, '');
      // console.log("descuento", descuento);
      // console.log("idProducto", idProducto);

      var totalneto = (cantidad * Preciocompra);
      var total = totalneto - descuento;
      $(".nuevoSubTotal" + idProducto).val(Math.round(total));
      $(".nuevoDescuentoProducto").number(true, 0);
       $(".txtdescuentoTotal").number(true, 0);
      
    }
  }

  sumarTotalPrecios();
  listarProductosCompras();
}


$("#cmbFormaPago").change(function() {


  mostrarcredito($(this).val());

})

function mostrarcredito(cmbforma) {

  if (cmbforma == "CREDITO") {

    $("#Credito").removeClass("notblock");
    $("#Vencimiento").removeClass("notblock");
    $("#cantidadCuota").removeClass("notblock");
    $("#montocuota").removeClass("notblock");
    $("#Entrega").removeClass("notblock");
    $(".metodopago").addClass("notblock");
    //  $("#recibo").addClass("notblock");



  } else {

    $("#Credito").addClass("notblock");
    $("#Vencimiento").addClass("notblock");
    $("#cantidadCuota").addClass("notblock");
    $("#montocuota").addClass("notblock");
    $("#Entrega").addClass("notblock");
    $(".metodopago").removeClass("notblock");
    //$("#recibo").removeClass("notblock");

  }
}

var contadortabladetalle = 1;

$(document).on("click", ".detalleCompra", function() {

  var token_Compra = $(this).attr("tokenCompra");

  if (contadortabladetalle == 1) {

    $(".tablasDetCompra").DataTable({

      "ajax": "ajax/compras.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + generales.getAttribute("activo") + " &token_compras=" + token_Compra,
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

    $(".tablasDetCompra").DataTable().ajax.url("ajax/compras.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + generales.getAttribute("activo") + " &token_compras=" + token_Compra).load();

  }


})



function consultarRango(fechaInicial, fechaFinal) {

  var general = document.getElementById('idSucursal');
  $(".tablasVerCompra").DataTable().ajax.url("ajax/compras.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + generales.getAttribute("activo") + " &txtfechaInicial=" + fechaInicial + "&txtfechaFinal=" + fechaFinal).load();

}



/*=============================================
CLONAR COMPRAS
=============================================*/

$(document).on("click", ".clonarCompra", function() {

  var token_Compra = $(this).attr("tokenCompra");
  var formapgo = $(this).attr("formapago");

  ClonarCompras(token_Compra, formapgo);

})

function ClonarCompras(token_Compra, formapago) {
  valorNuevo = 1;
  localStorage.removeItem("listaProductosCompras");
  $("#listaProductos").val("");

  document.querySelector("#titulo").innerHTML = "Clonar compra";
  document.querySelector("#btnGuardar").innerHTML = "Clonar compra";
  cargarProductos();

  var general = document.getElementById('idSucursal');
  var sucursal = $('#idSucursal').val();
  var activo = generales.getAttribute("activo");


  var datos = new FormData();

  datos.append("token_Compra", token_Compra);
  datos.append("sucursal", sucursal);
  datos.append("activo", activo);
  datos.append("forma", formapago);

  $.ajax({

    url: "ajax/compras.ajax.php",
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
        var descuento = respuesta[i]["DESCUENTO"];
        //var botones=$("button.btnAgregarProducto[idProducto='" + idProducto + "']");
        var botones = $(".btnAgregarProducto[idProducto='" + idProducto + "']");

        agregarProductos(token_producto, idProducto, sucursal, cantidadProducto, descuento, botones);


        if (i == 0) {
          mostrarcredito(respuesta[i]["FORMA_PAGO"]);

          $("#nuevaCompra").val("");
          $("#cmbProveedor").val(respuesta[i]["tokenProveedores"]);
          $("#cmbProveedor").select2().trigger('change');

          $("#cmbTipoPago").val(respuesta[i]["TIPO_PAGO"]);
          $("#cmbTipoPago").select2().trigger('change');
          $("#cmbFormaPago").val(respuesta[i]["FORMA_PAGO"]);
          $("#cmbFormaPago").select2().trigger('change');

          $("#cmbTipoMovimiento").val(respuesta[i]["TIPO_VENTA"]);
          $("#cmbTipoMovimiento").select2().trigger('change');
          //document.getElementById('txtFechaVencimiento').value=ano +'-' + mes +'-'+ dia

          if (respuesta[i]["FORMA_PAGO"] == "CREDITO") {
            var fecha = respuesta[i]["FECHA_VENCIMIENTO"].split("-");
            var ano = fecha[0];
            var mes = fecha[1];
            var dias = fecha[2].split(" ");
            var dia = dias[0];
            //var fechavencimiento=new Date();
            var fechavencimiento = ano + '-' + mes + '-' + dia
            $("#txtFechaVencimiento").val(fechavencimiento);
            $("#txtMontoCuota").val(respuesta[i]["MONTO_CUOTA"]);
            $("#nuevoMetodoPago").val(respuesta[i]["METODO_PAGO"]);
            $("#nuevoMetodoPago").select2().trigger('change');

            $("#txtCantidadCuota").val(respuesta[i]["CANT_CUOTA"]);
          }



        }


      }

      $("#txtPrecioVenta").number(true, 0);
      $("#txtMontoCuota").number(true, 0);


    }

  })

}



$(document).on("click", ".btncancelar", function() {
  const tableRows = document.querySelectorAll('#tablaCompra tr.rowNuevo');
  if (tableRows.length > 0) {
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
        localStorage.removeItem("listaProductosCompras");
        $("#listaProductos").val("");
        window.location = "compras"

      }

    });
  }



})

// NUEVO BOTONES
var valorNuevo = 0;
$(document).on("click", ".btnNuevo", function() {
  valorNuevo = 0;
  document.querySelector("#titulo").innerHTML = "Nueva compra";
  document.querySelector("#btnGuardar").innerHTML = "Guardar compra";

  $(".btnAgregarProducto").addClass("btn-success btnAgregarProducto");

  cargarProductos();


  if (localStorage.getItem("listaProductosCompras") != null) {
    var sucursal = $("#idSucursal").val();
    // quitarAgregarProducto();

    var listasCompra = JSON.parse(localStorage.getItem("listaProductosCompras"));

    for (var i = 0; i < listasCompra.length; i++) {
      var separador = listasCompra[i]["id"].split("/");
      var idProducto = separador[1];
      var token_producto = listasCompra[i]["id"];
      var cantidadProducto = listasCompra[i]["cantidad"];
      var descuento = listasCompra[i]["descuento"];
      var botones = $(".btnAgregarProducto[idProducto='" + idProducto + "']");


      agregarProductos(token_producto, idProducto, sucursal, cantidadProducto, descuento, botones);


      if (i == 0) {

        mostrarcredito(listasCompra[i]["cmbFormaPago"]);

        $("#nuevaCompra").val(listasCompra[i]["nuevaCompra"]);
        $("#cmbProveedor").val(listasCompra[i]["proveedores"]);
        $("#cmbProveedor").select2().trigger('change');

        $("#cmbTipoPago").val(listasCompra[i]["cmbTipoPago"]);
        $("#cmbTipoPago").select2().trigger('change');

        $("#cmbFormaPago").val(listasCompra[i]["cmbFormaPago"]);
        $("#cmbFormaPago").select2().trigger('change');

        $("#cmbTipoMovimiento").val(listasCompra[i]["cmbTipoMovimiento"]);
        $("#cmbTipoMovimiento").select2().trigger('change');


        if (listasCompra[i]["cmbFormaPago"] == "CREDITO") {

          if (listasCompra[i]["txtFechaVencimiento"] != "") {
            var fecha = listasCompra[i]["txtFechaVencimiento"].split("-");
            var ano = fecha[0];
            var mes = fecha[1];
            var dias = fecha[2].split(" ");
            var dia = dias[0];
            //var fechavencimiento=new Date();
            var fechavencimiento = ano + '-' + mes + '-' + dia
            $("#txtFechaVencimiento").val(fechavencimiento);
          }

          $("#txtMontoCuota").val(listasCompra[i]["txtMontoCuota"]);
          $("#nuevoMetodoPago").val(listasCompra[i]["nuevoMetodoPago"]);
          $("#nuevoMetodoPago").select2().trigger('change');

          $("#txtCantidadCuota").val(listasCompra[i]["txtCantidadCuota"]);

        }



      }


    }

    // quitarAgregarProducto();

    $("#txtPrecioVenta").number(true, 0);


  }



})



$(document).on("click", ".btnListar", function() {
  // $("#tablaCompra td").remove();

  $(".rowNuevo").closest('tr').remove();
  // window.location = "compras";

  if ($('.tablasVerCompra > * > tr').length - 1 > 0) {

    $(".tablasVerCompra").DataTable().ajax.reload();

  }

  $(".ListarContenido").removeClass("notblock");
  $(".CargarCompra").addClass("notblock");
  formCompra.reset();

  // quitarAgregarProducto();


})

// ES PARA GUARDAR LOS DATOS EN LA BASE DE DATOS//


function Guardarformulario() {

  var txtnrocompra = document.querySelector('input[name="nuevaCompra"]').value;

  var txtnrorecibo = document.querySelector('input[name="txtnroRecibo"]').value;

  var txtUsuario = document.querySelector('input[name="idUsuario"]').value;

  var txtidSucursal = document.querySelector('input[name="idSucursal"]').value;

  var cmbproveedor = $("#cmbProveedor").val();

  var cmbFormapago = $("#cmbFormaPago").val();

  var cmbTipoMovimiento = $("#cmbTipoMovimiento").val();

  var cmbTipoPago = $("#cmbTipoPago").val();

  var txtcantidadCuota = document.querySelector('input[name="txtCantidadCuota"]').value;

  var txtFechaVencimiento = document.querySelector('input[name="txtFechaVencimiento"]').value;

  var txtFechaCompra = document.querySelector('input[name="txtFechaCompra"]').value;

  var txtMontoCuota = document.querySelector('input[name="txtMontoCuota"]').value;

  var txtproductos = $("#listaProductos").val();

  var cmbMetodopago = nuevaListaModoPagos;

  var txtpreciototal = document.querySelector('input[name="txtTotal"]').value;

  var totalTalba = txtproductos.length;

  if (txtnrocompra == "") {
    swal({
      title: "Cargue un N° compra",
      type: "error",
      confirmButtonText: "¡Cerrar!"

    })
    return false;
  }

  if (txtFechaCompra == "") {
    swal({
      title: "Seleccione una fecha de compra",
      type: "error",
      confirmButtonText: "¡Cerrar!"

    })
    return false;
  }

  if (txtproductos.length <= 2) {
    swal({
      title: "Cargue un producto",
      type: "error",
      confirmButtonText: "¡Cerrar!"

    })
    return false;
  }

  if (cmbFormapago == "CREDITO") {
    if (cmbTipoPago == "") {

      swal({
        title: "Seleccione el tipo de pago",
        type: "error",
        confirmButtonText: "¡Cerrar!"

      })
      return false;
    } else if (txtcantidadCuota == "") {

      swal({
        title: "Cargue la cantidad cuota",
        type: "error",
        confirmButtonText: "¡Cerrar!"

      })
      return false;
    } else if (txtFechaVencimiento == "") {
      swal({
        title: "Seleccione la fecha vencimiento",
        type: "error",
        confirmButtonText: "¡Cerrar!"

      })
      return false;
    } else if (txtMontoCuota == "") {
      swal({
        title: "Cargue el monto de cuota",
        type: "error",
        confirmButtonText: "¡Cerrar!"

      })
      return false;
    }

  } else {
    if (cmbMetodopago == "") {

      swal({
        title: "Seleccione el método de pago",
        type: "error",
        confirmButtonText: "¡Cerrar!"

      })
      return false;
    } else if (txtnrorecibo == "") {
      swal({
        title: "Cargue el N° transacción",
        type: "error",
        confirmButtonText: "¡Cerrar!"

      })
    }
  }

  //   return false;
  var datos = new FormData();
  datos.append("txtnrocompra", txtnrocompra);
  datos.append("txtUsuario", txtUsuario);
  datos.append("txtidSucursal", txtidSucursal);
  datos.append("cmbproveedor", cmbproveedor);
  datos.append("txtproductos", txtproductos);
  datos.append("cmbFormapago", cmbFormapago);
  datos.append("cmbTipoMovimiento", cmbTipoMovimiento);
  datos.append("cmbTipoPago", cmbTipoPago);
  datos.append("txtcantidadCuota", txtcantidadCuota);
  datos.append("txtFechaVencimiento", txtFechaVencimiento);
  datos.append("txtMontoCuota", txtMontoCuota);
  datos.append("cmbMetodopago", cmbMetodopago);
  datos.append("txtpreciototal", txtpreciototal);
  datos.append("txtFechaCompra", txtFechaCompra);

  $.ajax({
    url: "ajax/compras.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,

    success: function(respuesta) {

      var objData = JSON.parse(respuesta);

      if (objData.status) {

        swal("success", objData.msg, "success");
        localStorage.removeItem("listaProductosCompras");
        window.location = "compras";


      } else {
        swal("Error", objData.msg, "error");
      }
    }

  })

  return (false);



}


$(document).on("click", "#ProductoSucursalActual", function() {
  $(".tablaProductos").DataTable().ajax.url("ajax/tablaCompras.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + "&actual=" + 0 + "&tipo_producto=SOLITARIO").load();

});

$(document).on("click", "#ProductoActivoOtros", function() {

  $(".tablaProductos").DataTable().ajax.url("ajax/tablaCompras.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + "&actual=" + 1 + "&tipo_producto=SOLITARIO").load();

});

var botonnuevo = 0;

function cargarProductos() {

  $(".ListarContenido").addClass("notblock");
  $(".CargarCompra").removeClass("notblock");

  if (botonnuevo == 0) {



    $('.tablaProductos').DataTable({
      "ajax": "ajax/tablaCompras.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + "&actual=" + 0 + " &tipo_producto=SOLITARIO",
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
    botonnuevo = 1;
  } else {
    $(".tablaProductos").DataTable().ajax.reload();
  }



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
  // console.log($(this));
  // console.log("button.btnAgregarProducto", $(".btnAgregarProducto"));

  agregarProductos(token_producto, idProducto, sucursal, cantidadProducto, 0, $(this));

});

var tipos = "SOLITARIO";

function agregarProductos(token_producto, idProducto, sucursal, cantidadProducto, descuento, botones) {

  var tipo_productos = tipos;

  var activo = 1;

  var datos = new FormData();
  datos.append("token_producto", token_producto);
  datos.append("sucursal", sucursal);
  datos.append("activo", activo);
  datos.append("tipo_producto", tipos);
  $.ajax({

    url: "ajax/compras.ajax.php",
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

         <td class="tdQuitar">

        <!-- BOTON PARA QUITAR --> 

        <div class="form-group nuevoQuitar` + idProducto + `"> 

        <div class="input-group"> 
        <span class="input-group-addon"> 

        <button type="button" class="btn btn-danger btn-xs quitarProducto" style="width:35px" idProducto="` + idProducto + `"><i class="fa fa-times"></i></button

        </span> 

        </div> 

        </div>

        </td>


      <td class="tdNuevoCantidad` + idProducto + `">

        <!-- Cantidad del producto -->

        <div class="form-group nuevoCantidad` + idProducto + `">

        <div class="input-group" style="width: 80px">

        <input type="text" class="form-control nuevaCantidadProducto nuevaCantidadProducto` + idProducto + `" idProducto="` + idProducto + ` " name="nuevaCantidadProducto" value="` + cantidadProducto + `" required>

        </div>

        </div>
      </td>

      

       <td class="tdNuevoPrecio` + idProducto + `"> 

        <!-- Impuesto del producto -->

        <div class="form-group nuevoPrecio` + idProducto + ` ">

        <div class="input-group" style="width: 150px">


        <input type="text" class="form-control text-right nuevoPrecioProducto nuevoPrecioProducto` + idProducto + `" name="nuevoPrecioProducto" value="` + precio + `" required>

        </div>

        </div>

        </td>

        <td class="tdNuevoDescuento` + idProducto + `"> 

        <!-- Impuesto del producto -->

        <div class="form-group nuevoDescuento` + idProducto + `">

        <div class="input-group" style="width: 150px">

        <input type="text" class="form-control text-right nuevoDescuentoProducto nuevoDescuentoProducto` + idProducto + `" idProducto="` + idProducto + `" name="nuevoDescuentoProducto" value="` + descuento + `">
                         
        </div>

        </div>

        </td>

       <td class="tdNuevoSubTotal` + idProducto + `">

        <!--SubTotal-->

        <div class="form-group DivnuevoSubTotal` + idProducto + `">

        <div class="input-group" style="width: 150px"> 

        <input type="text" class="form-control text-right nuevoSubTotal nuevoSubTotal` + idProducto + `" precioNeto="` + precioNeto + `" name="nuevoSubTotal" value="` + precioNeto + `" readonly required>

        </div>

        </div>

        </td>

       <td class="tdNumero` + idProducto + `">

        <!-- BOTON PARA QUITAR -->

        <div class="form-group nuevoNumero` + idProducto + `"> 

        <div class="input-group">

        <label class="form-control nuevaNumero" idNumero="` + idProducto + `"> ` + codigobarra + ` </label>

        </div>

        </div>

          </td>

        <td class = "tdNuevoProducto` + idProducto + `" >

        <!-- Descripción del producto -->

        <div class="form-group nuevoProducto` + idProducto + `">

        <div class="input-group" style="width: 200px">

        <input type="text" class="form-control nuevaDescripcionProducto" idProducto="` + token_producto + `" name="agregarProducto" value="` + descripcion + ` " readonly required>

        </div>

        </div>
        
        </td>


        </tr>`;

      $("#tablaCompra").append(f);


      localStorage.removeItem("quitarProducto");

      //SUMAR LOS PRECIOS

      sumarTotalPrecios();
      // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
      descuentoTotal();
      $(".nuevoPrecioProducto").number(true, 0);
      $(".nuevoSubTotal").number(true, 0);

      //listar producto en formato json

      listarProductosCompras();

      cantidadItems();

    }
  });
}

function cantidadItems() {
  const tableRows = document.querySelectorAll('#tablaCompra tr.rowNuevo');
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
  listarProductosCompras();

  if ($("#listaProductos").val().length <= 2) {
    $("#txtTotal").val("");
    $("#txtTotalArticulos").val("");
    for (let i = contadornuevo; i >= 1; i--) {

      $("div").remove(".metodo" + i);

    }
    $("#txtentregaEfectivo").val("");
    $('#txtentregaEfectivo').prop('disabled', false);
    nuevaListaModoPagos = [];
    console.log("nuevaListaModoPagos", nuevaListaModoPagos);
    $('.Metodonuevopago').val("");
    contadornuevo = 0;
  } else {
    //SUMAR LOS PRECIOS
    sumarTotalPrecios();

  }

   cantidadItems();




});


/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioCompra").on("change", "input.nuevaCantidadProducto,input.nuevoDescuentoProducto,input.nuevoPrecioProducto", function() {
  const IdProductoD = document.querySelector('.nuevoDescuentoProducto');
  idProducto = $(this).attr("idProducto");

  var precio = $(".nuevoPrecioProducto" + idProducto).val();

  var descuento = $(".nuevoDescuentoProducto" + idProducto).val();


  var stockCargada = $(".nuevaCantidadProducto" + idProducto).val();


  if (isNaN(stockCargada) || stockCargada == "" || stockCargada <= 0) {
    stockCargada = 1;

  }

  if (isNaN(descuento) || descuento == "" || descuento <= 0) {
    descuento = 0;

  }

  if (isNaN(precio) || precio == "" || precio <= 0) {
    precio = 0;

  }

  var precioNeto = stockCargada * precio;
  
  var precioFinal = precioNeto - descuento;

  $(".nuevaCantidadProducto" + idProducto).val(stockCargada);
  $(".nuevoDescuentoProducto" + idProducto).val(descuento);
  $(".nuevoSubTotal" + idProducto).val(precioFinal);
  $(".nuevoDescuentoProducto").number(true, 0);


  sumarTotalPrecios()
  //descuentoTotal();
  listarProductosCompras()

})

/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/
var Sumaproductos;

function sumarTotalPrecios() {

  var precioItem = $(".nuevoSubTotal");
  var precioItemNuevo = $(".nuevoPrecioProducto");
  var precioItemDescuento = $(".nuevoDescuentoProducto");

  var arraySumaPrecio = [];
  var arraySumaPrecioNuevo = [];
  var arraySumaDescuento = [];

  for (var i = 0; i < precioItem.length; i++) {

    arraySumaPrecio.push(Number($(precioItem[i]).val()));
    arraySumaPrecioNuevo.push(Number($(precioItemNuevo[i]).val()));
    arraySumaDescuento.push(Number($(precioItemDescuento[i]).val()));

  }

  function sumaArrayPrecios(total, numero) {

    return total + numero;

  }


  var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
  var sumaTotalPrecioNuevo = arraySumaPrecioNuevo.reduce(sumaArrayPrecios);
  var sumaDescuento = arraySumaDescuento.reduce(sumaArrayPrecios);

  Sumaproductos = sumaTotalPrecioNuevo;


  if ($("#txtentregaEfectivo").val() == $("#txtTotal").val()) {
    $("#txtentregaEfectivo").val(sumaTotalPrecio);
    $("#txtentregaEfectivo").number(true, 0)
  } else {
    for (let i = contadornuevo; i >= 1; i--) {

      $("div").remove(".metodo" + i);

      // contadornuevo--;
      CombosPagos();
    }
    $("#txtentregaEfectivo").val(sumaTotalPrecio);
    $('#txtentregaEfectivo').prop('disabled', false);
    contadornuevo = 0;
  }


  $("#txtTotal").val(sumaTotalPrecio);
  $("#txtTotalArticulos").val(sumaTotalPrecio);
  $("#txtdescuentoTotal").val(sumaDescuento);

  $("#txtTotal").attr("total", sumaTotalPrecio);
  $("#txtTotal").number(true, 0)
  $("#txtTotalArticulos").number(true, 0)



}



/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/


function listarProductosCompras() {

  var listaProductosStore = [];

  var listaProductos = [];

  var descripcion = $(".nuevaDescripcionProducto");
  var cantidad = $(".nuevaCantidadProducto");
  var precio = $(".nuevoPrecioProducto");
  var precioNeto = $(".nuevoSubTotal");
  var nuevaCompra = $("#nuevaCompra");
  var proveedores = $("#cmbProveedor");
  var txtFechaCompra = $("#txtFechaCompra");
  var cmbFormaPago = $("#cmbFormaPago");
  var cmbTipoPago = $("#cmbTipoPago");
  var txtCantidadCuota = $("#txtCantidadCuota");
  var txtFechaVencimiento = $("#txtFechaVencimiento");
  var txtMontoCuota = $("#txtMontoCuota");
  var nuevoMetodoPago = $("#nuevoMetodoPago");
  var txtdescuentoTotal = $("#txtdescuentoTotal");
  var txtnroRecibo = $("#txtnroRecibo");
  var cmbTipoMovimiento = $("#cmbTipoMovimiento");
  var idProducto = $(".nuevaDescripcionProducto").attr("idProducto");

  var descuento = $(".nuevoDescuentoProducto");


  for (var i = 0; i < descripcion.length; i++) {

    listaProductosStore.push({
      "id": $(descripcion[i]).attr("idProducto"),
      "cantidad": $(cantidad[i]).val(),
      "proveedores": $(proveedores[i]).val(),
      "nuevaCompra": $(nuevaCompra[i]).val(),
      "txtFechaCompra": $(txtFechaCompra[i]).val(),
      "cmbFormaPago": $(cmbFormaPago[i]).val(),
      "cmbTipoPago": $(cmbTipoPago[i]).val(),
      "txtCantidadCuota": $(txtCantidadCuota[i]).val(),
      "txtFechaVencimiento": $(txtFechaVencimiento[i]).val(),
      "txtMontoCuota": $(txtMontoCuota[i]).val(),
      "nuevoMetodoPago": $(nuevoMetodoPago[i]).val(),
      "txtdescuentoTotal": $(txtdescuentoTotal[i]).val(),
      "txtnroRecibo": $(txtnroRecibo[i]).val(),
      "cmbTipoMovimiento": $(cmbTipoMovimiento[i]).val(),
      "descuento": $(descuento[i]).val()
    })


    listaProductos.push({
      "id": $(descripcion[i]).attr("idProducto"),
      "precio": $(precio[i]).val(),
      "total": $(precioNeto[i]).val(),
      "cantidad": $(cantidad[i]).val(),
      "descuento": $(descuento[i]).val()
    })

  }

  $("#listaProductos").val(JSON.stringify(listaProductos));
  if (valorNuevo == 0) {
    localStorage.setItem("listaProductosCompras", JSON.stringify(listaProductosStore));
  }

  
}

/*=============================================
ANULAR PEDIDOS
=============================================*/
$(".tablasVerCompra").on("click", ".eliminarCompra", function() {

  var tokenCompra = $(this).attr("tokenCompra");
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

        datos.append("tokenCompra", tokenCompra);
        datos.append("estado", estado);
        datos.append("usuario", usuario);
        datos.append("descripcion", descripcion);
        datos.append("tokenSucursal", tokenSucursal);

        $.ajax({

          url: "ajax/compras.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta) {
            var objData = JSON.parse(respuesta);

            if (objData.status) {
              swal("success", objData.msg, "success");
              tablaVerCompra.ajax.reload(function() {

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
        datos.append("tokenCompra", tokenCompra);
        datos.append("estado", estado);
        datos.append("usuario", usuario);
        datos.append("descripcion", descripcion);
        datos.append("tokenSucursal", tokenSucursal);

        $.ajax({

          url: "ajax/compras.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta) {
            var objData = JSON.parse(respuesta);

            if (objData.status) {
              swal("success", objData.msg, "success");
              tablaVerCompra.ajax.reload(function() {

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

// function recargarDatatable() {

//   if ($('.tablasVerCompra > * > tr').length - 1 > 0) {
//     $(".tablasVerCompra").DataTable().ajax.reload();
//     $(".ListarContenido").removeClass("notblock");
//     $(".CargarCompra").addClass("notblock");
//     formCompra.reset();
//     $("#tablaCompra td").remove();
//   }


// }



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

 
setInterval(function() {
  if ($('.CargarCompra').is(':visible')) {
 
    if (localStorage.getItem("listaProductosCompras") != null) {
      listarProductosCompras();
    }

      }

}, 4000);

