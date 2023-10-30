const formApertura = $("#formularioApertura").val();

/*==========================================================
      CARGAR LOS DATOS EN LA TABLA Y DARLE FORMATO
============================================================*/

var tablaApertura = $(".tablaAperturas").DataTable({

  "ajax": "ajax/tablaAperturas.ajax.php?sucursal=" + $("#idSucursal").val() + " &usuario=" + $("#idUsuario").val(),
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
  //   "createdRow": function(row,data,index){
  //   if( data[11] == "P" ){
  //     $('td',row).css({
  //       'background-color':'#1F7246',
  //       'color':'white',
  //     });
  //   }

  // }

})



$(document).on("click", ".VerApertura", function() {

  var token_apertura = $(this).attr("token_apertura");
  var cod_apertura = $(this).attr("cod_apertura");
  var nombrecaja = $(this).attr("nombrecaja");

  // console.log(token_apertura,cod_apertura);

  // return;

  var datos = new FormData();

  datos.append("token_apertura", cod_apertura + "/" + token_apertura);

  $.ajax({

    url: "ajax/aperturas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      // console.log(respuesta);
      $("#TablaVerapertura td").remove();
      $("#txtfechaVerApertura").val(respuesta[0]["FECHA_APERTURA"]);
      $("#txtfechaCierreApertura").val(respuesta[0]["FECHA_CIERRE"]);
      $("#txtmontocierre").val(respuesta[0]["MONTO_CIERRE"]);
      $("#txtmontocierre").number(true, 0);
      $("#txtdiferenciacierre").val(respuesta[0]["DIFERENCIA"]);
      $("#txtdiferenciacierre").number(true, 0);
      $("#txtObservaciones").val(respuesta[0]["OBSERVACION"]);
      $("#txtVerCaja").val(nombrecaja);


      var f;
      var can = 0;
      var monto = 0;
      for (var i = 0; i < respuesta.length; i++) {
        can += 1;

        f += `<tr>
         <td>` + can + `</td>
         <td>` + respuesta[i]["HORA_APERTURA"] + `</td>
         <td>` + new Intl.NumberFormat().format(respuesta[i]["MONTO_APERTURA"]) + `</td>
         <td>` + respuesta[i]["EST_APERTURA"] + `</td>'
         </tr>`;
      }
      $("#TablaVerapertura").append(f);


    }

  })



});

$(document).on("click", ".editarApertura", function() {

  var token_apertura = $(this).attr("token_apertura");
  var cod_apertura = $(this).attr("cod_apertura");
  var nombrecaja = $(this).attr("nombrecaja");

  $("#txtNroCaja").val(nombrecaja);
  $("#codigoapertura").val(cod_apertura);
  $("#tokenapertura").val(token_apertura);


})

/*==========================================================
      Guardar Caja
============================================================*/

function guardarFormulario() {

  var cod_apertura = $("#codigoapertura").val() + '/' + $("#tokenapertura").val();

  var monto = $("#nuevoApertura").val();

  var datos = new FormData();

  datos.append("token", cod_apertura);
  datos.append("monto", monto);
  divLoading.style.display = "flex";
  $.ajax({

    url: "ajax/aperturas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,

    success: function(respuesta) {

      var objData = JSON.parse(respuesta);

      if (objData.status) {

        $('#ModalApertura').modal('hide');

        swal({

          title: "success",
          text: objData.msg,
          type: "success",
          confirmButtonColor: '#3085d6',

        }, function(isConfirm) {

          if (isConfirm) {
            divLoading.style.display = "none";
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


/*==========================================================
      Guardar Caja
============================================================*/

function guardarCierre() {

  var cod_apertura = $("#codigoapertura").val() + '/' + $("#tokenapertura").val();


  var montoCierre = $("#nuevoCierre").val();

  var Diferencia = $("#nuevoDiferencia").val();

  var Observaciones = $("#txtObservaciones").val();
  var totalcaja = $("#txtTotalCaja").val();
  
  swal({
    title: '¿Está seguro de realizar el cierre?, este proceso es irreversible',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, realizar el cierre!',
    closeOnConfirm: false,
    closeOnCancel: true
  }, function(isConfirm) {

    if (isConfirm) {
      divLoading.style.display = "flex";

      var datos = new FormData();

      datos.append("tokeneditar", cod_apertura);
      datos.append("montoCierre", montoCierre);
      datos.append("Diferencia", Diferencia);
      datos.append("Observaciones", Observaciones);
       datos.append("totalcaja", totalcaja);

      $.ajax({
        url: "ajax/aperturas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,

        success: function(respuesta) {

          var objData = JSON.parse(respuesta);

          if (objData.status) {

            swal({

              title: "success",
              text: objData.msg,
              type: "success",
              confirmButtonColor: '#3085d6',

            }, function(isConfirm) {

              if (isConfirm) {

                window.location = "inicio";

                LimpiarText();

              }

            })

          } else {

            swal("Error", objData.msg, "error");

          }
          divLoading.style.display = "none";

        }


      })



    }

  });

  return (false);


}


/*=============================================
Eliminar Caja
=============================================*/

$(document).on("click", ".eliminarApertura", function() {

  var token_apertura = $(this).attr("token_apertura");
  var cod_apertura = $(this).attr("cod_apertura");

  var tokenApertura = cod_apertura + '/' + token_apertura;

  //    alert(tokenApertura);
  // return;
  swal({
    title: '¿Está seguro de Anular este registro?',
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

      var datos = new FormData();

      datos.append("idEliminar", tokenApertura);

      $.ajax({

        url: "ajax/aperturas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {

          var objData = JSON.parse(respuesta);

          if (objData.status) {

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

})


$(document).on("click", ".btnNuevo", function() {

  $("#titulo").html("Nueva caja");
  $("#btnGuardar").html("Guardar");
  LimpiarText();
  // getIpClient();
  $.getJSON('https://api.ipify.org?format=json', function(data) {

    //  console.log(data.ip);

    txtEquipo = String(data.ip);

  });


})


$("#nuevoCierre").change(function() {

  let total = $("#txtTotalCaja").val().replace(/\./g, '');
  let montocierre = $(this).val().replace(/\./g, '');
  let resto = total - montocierre;
  $("#nuevoDiferencia").val(resto);

})



function LimpiarText() {

  formApertura.reset();

}