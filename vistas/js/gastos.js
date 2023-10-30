/*==========================================================
      CARGAR LOS DATOS EN LA TABLA Y DARLE FORMATO
============================================================*/

const formGastos = document.getElementById("formularioGastos");


var generales = document.getElementById('tokenapertura');

var tablaGasto = $(".tablaGastos").DataTable({

  "ajax": "ajax/tablaGastos.ajax.php?apertura=" + $("#codigoapertura").val()+ " &estado=" + generales.getAttribute("estado"),
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

  },
  'dom': 'lBfrtip',
  'buttons': [{
    "extend": "copyHtml5",
    "text": "<i class='far fa-copy'></i> Copiar",
    "titleAttr": "Copiar",
    "className": "btn btn-secondary",
    "exportOptions": {
      "columns": [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
    }
  }, {
    "extend": "excelHtml5",
    "text": "<i class='fas fa-file-excel'></i> Excel",
    "titleAttr": "Esportar a Excel",
    "className": "btn btn-success",
    "exportOptions": {
      "columns": [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
    }
  }, {
    "extend": "pdfHtml5",
    "text": "<i class='fas fa-file-pdf'></i> PDF",
    "titleAttr": "Esportar a PDF",
    "className": "btn btn-danger",
    "exportOptions": {
      "columns": [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
    }
  }, {
    "extend": "csvHtml5",
    "text": "<i class='fas fa-file-csv'></i> CSV",
    "titleAttr": "Esportar a CSV",
    "className": "btn btn-info",
    "exportOptions": {
      "columns": [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
    }
  }]


})

$(document).on("click", "#btnAgregarCategoria", function() {

  if ($('.CategoriaNuevo').is(':visible')) {
    $(".CategoriaNuevo").addClass("notblock");

  } else {
    $(".CategoriaNuevo").removeClass("notblock");

  }

});

$("#cmbCategoria").change(function() {
  $("#txtNuevaCategoria").val($(this).val());
});


$("#cmbTipoMovimiento").change(function() {

  if ($(this).val() == "FACTURA") {
    $(".Factura").removeClass("notblock");

  } else {
    $(".Factura").addClass("notblock");

  }
});

$("#txtMontoGastos").change(function() {
  $("#txtentregaEfectivo").val($(this).val());

});


$("#txtRuc").change(function() {

  let ruc = $(this).val();

  var datos = new FormData();

  datos.append("ruc", ruc);

  $.ajax({
    url: "ajax/gastos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,

    success: function(respuesta) {

      $("#txtNombreEmpresa").val(respuesta["EMPRESA"]);


    }


  });

})



$("#txtentregaEfectivo").change(function() {
  let entrega = $("#txtentregaEfectivo").val().replace(/\./g, '');
  var total = $("#txtMontoGastos").val().replace(/\./g, '');
  let id_metodo = "";
  let nrotransaccion = "";

  EntregaEfectivo(entrega, total, id_metodo, nrotransaccion);
  // if (Number(entrega) != "" || Number(entrega) > 0) {
  //   if (Number(entrega) > Number(total)) {


  //     mensajeEmergente("ERROR: ", "La entrega no puede ser mayor al gastos!", "fa fa-check", "info");
  //     $('#btnagregarMetodopago').prop('disabled', true);
  //     $("#txtentregaEfectivo").val($("#txtMontoGastos").val());
  //     return false;


  //   } else {

  //     if (Number(entrega) < Number(total)) {

  //       $('#btnagregarMetodopago').prop('disabled', false);
  //       crearBotonesEntrega(entrega,id_metodo,nrotransaccion);

  //     }

  //   }
  // } else {
  //   $("#txtentregaEfectivo").val(total);
  //   $("#txtentregaEfectivo").number(true, 0);
  //   $('#btnagregarMetodopago').prop('disabled', true);
  //   return false;
  // }


})

contadornuevo = 0;

function crearBotonesEntrega(entrega, id_metodo, nrotransaccion) {

  var m;
  contadornuevo++;
  CombosPagos();
  m = `<div class="metodo` + contadornuevo + `">
        <div class="card-header">
         
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
                       <input class="form-control txtentregaEfectivo txtentregaEfectivo` + contadornuevo + `" name="txtentregaEfectivo" type="text" onkeyup="format(this)" onchange="format(this)" value="` + entrega + `"> 

                    </div>

                       <div class="form-group col-md-6">
                  
                        <div class="form-group">
                        <label class="NroMovimiento NroMovimiento` + contadornuevo + `" for="txtnroRecibo">Nº Movimiento</label>
                       <input class="form-control txtnroRecibo txtnroRecibo` + contadornuevo + `" type="text" placeholder="Nº transacción" value="` + nrotransaccion + `">
                      </div>

                    </div>

                 
                </div>
          
      </div>
    </div>`;



  $(".metodopago").append(m);

  //  console.log("contadornuevo", contadornuevo);

  if (contadornuevo > 1) {

    var cant = contadornuevo - 1;
    $('.btnagregarEliminar' + cant).prop('disabled', true);
    $('.txtentregaEfectivo' + cant).prop('disabled', true);

  } else if (contadornuevo = 1) {

    if (entrega == 0) {
      var resto = $("#txtMontoGastos").val().replace(/\./g, '') - Number($("#txtentregaEfectivo").val().replace(/\./g, ''))
      $(".txtentregaEfectivo" + contadornuevo).val(resto);

    }


    $('#txtentregaEfectivo').prop('disabled', true);
    $('#btnagregarMetodopago').prop('disabled', true);
  }

  $(".txtentregaEfectivo" + contadornuevo).number(true, 0);


  cargarMetodoPago(contadornuevo, id_metodo);


}



//const entregaDinamico;


$(document).on("click", ".EditarGastos", function() {

  document.querySelector("#titulo").innerHTML = "Editar gastos";
  document.querySelector("#btnGuardar").innerHTML = "Actualizar";
  LimpiarText();


  var token_gastos = $(this).attr("codgastos") + "/" + $(this).attr("TOKEN_GASTOS");

  var datos = new FormData();

  datos.append("token_gastos", token_gastos);

  $.ajax({

    url: "ajax/gastos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      //console.log("respuesta", respuesta);

      $("#codigogastos").val(respuesta["COD_GASTO"] + "/" + respuesta["TOKEN_GASTOS"]);

      $("#cmbTipoMovimiento").val(respuesta["TIPO_GASTO"]);

      $("#txtNroFactura").val(respuesta["NROFACTURA"]);

      $("#txtRuc").val(respuesta["RUC"]);

      $("#txtNombreEmpresa").val(respuesta["EMPRESA"]);

      $("#txtNuevaDescripcion").val(respuesta["DESCRIPCION"]);

      $("#txtNuevaCategoria").val(respuesta["CATEGORIA"]);

      $("#cmbCategoria").val(respuesta["CATEGORIA"]);
      $("#cmbCategoria").select2().trigger('change');

      $("#txtMontoGastos").val(respuesta["TOTAL"]);
      $("#txtMontoGastos").number(true, 0);

      $("#cmbExtraccion").val(respuesta["VER_CAJA"]);



      $("#cmbIva").val(respuesta["IVA"]);

      if (respuesta["TIPO_GASTO"] == "FACTURA") {

        $(".Factura").removeClass("notblock");

      } else {
        $(".Factura").addClass("notblock");

      }


      var fecha = respuesta["FECHA"].split("-");
      var ano = fecha[0];
      var mes = fecha[1];
      var dias = fecha[2].split(" ");
      var dia = dias[0];
      //var fechavencimiento=new Date();
      var fechavencimiento = ano + '-' + mes + '-' + dia
      $("#txtFechaGastos").val(fechavencimiento);

      if(respuesta["FORMAPAGO"]!="" || respuesta["FORMAPAGO"]!=null){
      
        var listasPagosGastos="[]";
        listasPagosGastos = JSON.parse(respuesta["FORMAPAGO"]);
   
      let entrega = 0;
      let total = respuesta["TOTAL"];

      for (var i = 0; i < listasPagosGastos.length; i++) {

        entrega = listasPagosGastos[i]["entrega"];
   
        let id_metodo = listasPagosGastos[i]["id_metodo"];
        let nrotransaccion = listasPagosGastos[i]["nrotransaccion"];

        if (i == 0) {

          $("#nuevoMetodoPago").val(id_metodo);

          $("#txtentregaEfectivo").val(entrega);

          $("#txtentregaEfectivo").number(true, 0);

          $("#txtnroRecibo").val(nrotransaccion);
          CombosPagos();
          // recorrerSuma(id_metodo,nrotransaccion)

        } else {
          // entrega+=$("#txtentregaEfectivo").val();
          $('#txtentregaEfectivo').prop('disabled', true);
          EntregaEfectivo(entrega, total, id_metodo, nrotransaccion);
        }



      }
      }
      



    }

  })


})

function EntregaEfectivo(entrega, total, id_metodo, nrotransaccion) {
  //console.log("entrega", entrega);

  if (Number(entrega) != "" || Number(entrega) > 0) {
    if (Number(entrega) > Number(total)) {

      $("#txtentregaEfectivo").val(total);
      $('#btnagregarMetodopago').prop('disabled', true);
      mensajeEmergente("ERROR: ", "La entrega no puede ser mayor al total!", "fa fa-check", "info");

    } else {

      if (Number(entrega) < Number(total)) {

        $('#btnagregarMetodopago').prop('disabled', false);
        crearBotonesEntrega(entrega, id_metodo, nrotransaccion);


      }

    }
  } else {
    $("#txtentregaEfectivo").val(total);
    $("#txtentregaEfectivo").number(true, 0);
    $('#btnagregarMetodopago').prop('disabled', true);
  }

}

/*==========================================================
      Guardar Caja
============================================================*/

function guardarFormulario() {

  var cod_gastos = $("#codigogastos").val();

  var tipofactura = $("#cmbTipoMovimiento").val();

  var nrofactura = $("#txtNroFactura").val();

  var txtruc = $("#txtRuc").val();

  var txtempresa = $("#txtNombreEmpresa").val();

  var txtnuevoDescripcion = $("#txtNuevaDescripcion").val();

  var txtNuevaCategoria = $("#txtNuevaCategoria").val();

  var txtmontoGastos = $("#txtMontoGastos").val();

  var cmbextraccion = $("#cmbExtraccion").val();

  var txtusuario = $("#idUsuario").val();

  var txtsucursal = $("#idSucursal").val();

  var txtapertura = $("#codigoapertura").val();

  var txtfecha = $("#txtFechaGastos").val();

  var cmbIva = $("#cmbIva").val();


  if (tipofactura == "FACTURA") {

    if (nrofactura == "") {
      swal({
        title: "Cargue un N° factura",
        type: "error",
        confirmButtonText: "¡Cerrar!"

      })

    } else if (txtruc == "") {
      swal({
        title: "Cargue un N° ruc",
        type: "error",
        confirmButtonText: "¡Cerrar!"

      })
      return false;

    } else if (txtempresa == "") {
      swal({
        title: "Cargue el nombre de la empresa",
        type: "error",
        confirmButtonText: "¡Cerrar!"

      })
      return false;

    } else if (cmbIva == "") {

      swal({
        title: "Cargue la iva",
        type: "error",
        confirmButtonText: "¡Cerrar!"

      })
      return false;

    }

  }

  if (txtNuevaCategoria == "") {
    swal({
      title: "Seleccione una categoria o agregue uno nuevo",
      type: "error",
      confirmButtonText: "¡Cerrar!"

    })
    return false;
  }

  divLoading.style.display = "flex";

  var datos = new FormData();

  datos.append("cod_gastos", cod_gastos);
  datos.append("tipofactura", tipofactura);
  datos.append("nrofactura", nrofactura);
  datos.append("txtruc", txtruc);
  datos.append("txtempresa", txtempresa);
  datos.append("txtnuevoDescripcion", txtnuevoDescripcion);
  datos.append("txtNuevaCategoria", txtNuevaCategoria);
  datos.append("txtmontoGastos", txtmontoGastos);
  datos.append("cmbextraccion", cmbextraccion);
  datos.append("txtusuario", txtusuario);
  datos.append("txtsucursal", txtsucursal);
  datos.append("txtapertura", txtapertura);
  datos.append("txtfecha", txtfecha);
  datos.append("cmbIva", cmbIva);
  datos.append("metodopago", nuevaListaModoPagos);


  $.ajax({
    url: "ajax/gastos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,

    success: function(respuesta) {

      var objData = JSON.parse(respuesta);

      if (objData.status) {

        $('#ModalGastos').modal('hide');
        divLoading.style.display = "none";
        swal({


          title: "success",
          text: objData.msg,
          type: "success",
          confirmButtonColor: '#3085d6',

        }, function(isConfirm) {

          if (isConfirm) {

            window.location.reload();

            LimpiarText();

          }

        })

      } else {

        swal("Error", objData.msg, "error");

      }

    }

  })

  return (false);

}


/*=============================================
Eliminar Caja
=============================================*/

$(document).on("click", ".eliminarGastos", function() {

  var token_gastos = $(this).attr("token_gastos");
  var codgastos = $(this).attr("codgastos");
  var estado = $(this).attr("estado");

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
        divLoading.style.display = "flex";
        var datos = new FormData();

        datos.append("idEliminar", codgastos + "/" + token_gastos);
        datos.append("estado",estado);

        $.ajax({

          url: "ajax/gastos.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta) {

            var objData = JSON.parse(respuesta);

            if (objData.status) {
              divLoading.style.display = "none";
              swal({

                title: "success",
                text: objData.msg,
                type: "success",
                confirmButtonColor: '#3085d6',

              }, function(isConfirm) {

                if (isConfirm) {

                  window.location.reload();
                  LimpiarText();

                }

              })

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
        divLoading.style.display = "flex";
        var datos = new FormData();

        datos.append("idEliminar", codgastos + "/" + token_gastos);
        datos.append("estado",estado);

        $.ajax({

          url: "ajax/gastos.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta) {

            var objData = JSON.parse(respuesta);

            if (objData.status) {
              divLoading.style.display = "none";
              swal({

                title: "success",
                text: objData.msg,
                type: "success",
                confirmButtonColor: '#3085d6',

              }, function(isConfirm) {

                if (isConfirm) {

                  window.location.reload();
                  LimpiarText();

                }

              })

            }

          }

        })

      }


    });
  }

})


$(document).on("click", ".btnNuevo", function() {

  $("#titulo").html("Agregar nuevo gastos");

  $("#btnGuardar").html("Guardar");

  LimpiarText();

  $("#codigogastos").val("");
  $("#cmbCategoria").select2().trigger('change');


})

function LimpiarText() {

  formGastos.reset();

  for (var i = 1; i <= contadornuevo; i++) {

    $(".metodo" + i).remove();

  }

  $('#txtentregaEfectivo').prop('disabled', false);


}



/*=============================================
  CARGAR METOOD DE PAGO
=============================================*/

function cargarMetodoPago(selectValue, id_metodo) {

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

    url: "ajax/ventas.ajax.php",
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

      $(".Metodonuevopago" + selectValue).val(id_metodo);

    }

  })

}

function CombosPagos() {
  var listaMetodoPagos = [];
 
  var metodopago = $(".Metodonuevopago");
  var entrega = $(".txtentregaEfectivo");
  var nrotransaccion = $(".txtnroRecibo");

  for (var i = 0; i < metodopago.length; i++) {

    listaMetodoPagos.push({
   
     

      "id_metodo": $(metodopago[i]).val(),
      "entrega": $(entrega[i]).val().replace(/\./g, ''),
      "nrotransaccion": $(nrotransaccion[i]).val()
    })

   //console.log("listaMetodoPagos", listaMetodoPagos);
  }

  nuevaListaModoPagos = JSON.stringify(listaMetodoPagos);
  // console.log("nuevaListaModoPagos", nuevaListaModoPagos);

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
    valor = valor + Number($('#txtentregaEfectivo').val().replace(/\./g, ''));
    $('#txtentregaEfectivo').val(valor);
    $(".txtentregaEfectivo" + contadornuevo).number(true, 0);
    $("#txtentregaEfectivo").number(true, 0);
  } else {
    valor = valor + Number($('.txtentregaEfectivo' + contadornuevo).val());
    $('.txtentregaEfectivo' + contadornuevo).val(valor);
    $(".txtentregaEfectivo" + contadornuevo).number(true, 0);
    $("#txtentregaEfectivo").number(true, 0);
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
          resto = Number($("#txtMontoGastos").val().replace(/\./g, '')) - valor - Number($("#txtentregaEfectivo").val().replace(/\./g, ''));

        }

        if (i == 1 && contadornuevo == 1) {

          if (resto > 0) {

            $('#btnagregarMetodopago').prop('disabled', false);
            crearBotonesEntrega(0, "", "");
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
            crearBotonesEntrega(0, "", "");
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
            crearBotonesEntrega(0, "", "");
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
            crearBotonesEntrega(0, "", "");
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
            crearBotonesEntrega(0, "", "");
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
    $("#txtentregaEfectivo").val($("#txtMontoGastos").val());
    $('#btnagregarMetodopago').prop('disabled', true);
  }


}