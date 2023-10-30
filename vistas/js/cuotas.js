
// const formCaja= $("#formCaja").val();

/*==========================================================
      CARGAR LOS DATOS EN LA TABLA Y DARLE FORMATO
============================================================*/

var tablaCuotero = $(".tablaCuotero").DataTable({

  "ajax": "ajax/tablaCuotas.ajax.php",
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


/*==========================================================
      Guardar Cuota
============================================================*/

function guardarFormulario(){

  var idCuotas= $("#idCuota").val()+"/"+$("#tokenCuota").val();

  var cmbEstado = $("#cmbEstado").val();

  var txtRecarga = $("#txtRecarga").val();

  var txtDesde = $("#txtDesde").val();

  var txtHasta = $("#txtHasta").val();

  var tokenCuotas = $("#tokenCuota").val();

  var idUsuario = $("#idUsuario").val();



  if(parseInt(txtDesde) >= parseInt(txtHasta)){

    swal("Error", "Favor corregir el intérvalo de montos antes de continuar", "error");
    $( "#txtHasta" ).focus();
    // return;

  }else{

    // alert("txtDesde: " + txtDescuento + " txtHasta: "+ txtHasta + "codcanal: " + cmbCanal);
    // return;

    var datos = new FormData();

      datos.append("cmbEstado", cmbEstado);
      datos.append("txtRecargo", txtRecarga);
      datos.append("txtDesde", txtDesde);
      datos.append("txtHasta", txtHasta);
      datos.append("tokenCuotas", tokenCuotas);
      datos.append("idCuotas", idCuotas);
      datos.append("idUsuario", idUsuario);


      $.ajax({
      url: "ajax/cuotas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,

      success: function(respuesta) {
        console.log("respuesta", respuesta);

        var objData = JSON.parse(respuesta);

        if (objData.status) {

          $('#ModalCuotas').modal('hide');

          formCuota.reset();

          swal("success",objData.msg,"success");

          tablaCuotero.ajax.reload(function() {
            
          });

        } else {

          swal("Error", objData.msg, "error");

        }

      }

    })

  }
  
  return (false);

}


/*=============================================
      Editar Descuento
=============================================*/

$(document).on("click", ".editarCuotas", function() {

  $("#titulo").html("Editar cuotas");
  $("#btnGuardar").html("Actualizar");

  LimpiarText();

  
  var token_cuotas = $(this).attr("tokenCuotas");

  // console.log(token_cuotas);

  // return;
  
  var datos = new FormData();

  datos.append("token_cuotas", token_cuotas);

  $.ajax({

    url: "ajax/cuotas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

       //console.log(respuesta);

      $("#idCuota").val(respuesta["COD_CUOTA"]);
      $("#tokenCuota").val(respuesta["TOKEN_CUOTA"]);
     
      $("#txtRecarga").val(new Intl.NumberFormat("de-DE").format(respuesta["RECARGO_CUOTA"]));

      $("#txtDesde").val(respuesta["MONTO_CUOTA"]);
      $("#txtDesde").number(true,0);

      $("#txtHasta").val(respuesta["MONTO_MAXIMA"]);
      $("#txtHasta").number(true,0);

      $("#tokenDescuento").val(respuesta["TOKEN"]);
  
      $("#desde").val(respuesta["MONTO_CUOTA"]);
      $("#hasta").val(respuesta["MONTO_MAXIMA"]);

    }

  })

})


/*=============================================
Eliminar Descuento
=============================================*/

$(document).on("click", ".eliminarCuotas", function() {

  var tokenCuotas = $(this).attr("tokenCuotas");

  // alert(tokenCuotas);
  // return;

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

      datos.append("idEliminar", tokenCuotas);

      $.ajax({

        url: "ajax/cuotas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {

          var objData = JSON.parse(respuesta);

          if (objData.status) {

           
            swal("success",objData.msg,"success");

            tablaCuotero.ajax.reload(function() {
              
            });

          } else {

            swal("Error", objData.msg, "error");

          }

        }

      })

    }

  });

})


$(document).on("click", ".btnNuevo", function() {

  $("#titulo").html("Nuevo cuotero");
  $("#btnGuardar").html("Guardar");

  LimpiarText();
  
})

function LimpiarText() {

  formCuota.reset();

}
