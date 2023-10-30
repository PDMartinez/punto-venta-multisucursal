
// const formCanal= $("#formCanal").val();

/*==========================================================
      CARGAR LOS DATOS EN LA TABLA Y DARLE FORMATO
============================================================*/

var tablaCanales = $(".tablaCanales").DataTable({

  "ajax": "ajax/tablaCanalesProductos.ajax.php",
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
      Guardar Canal
============================================================*/

function guardarFormulario(){

  var txtCanal = $("#txtCanal").val();

  var cmbEstado = $("#cmbEstado").val();

  var tokenCanal = $("#tokenCanal").val();

  // alert(" -txtCanal: "+ txtCanal + " -cmbEstado: "+ cmbEstado + " -tokenCanal: "+ tokenCanal);

  // return;

  var datos = new FormData();

    datos.append("txtCanal", txtCanal);
    datos.append("cmbEstado", cmbEstado);
    datos.append("tokenCanal", tokenCanal);


    $.ajax({
    url: "ajax/canalesProductos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,

    success: function(respuesta) {

      var objData = JSON.parse(respuesta);

      if (objData.status) {

        $('#ModalCanales').modal('hide');

        swal("success", objData.msg, "success");

        tablaCanales.ajax.reload(function() {

        // LimpiarText();

        });

      } else {

        swal("Error", objData.msg, "error");

      }

    }

  })
  
  return (false);

}

/*==========================================================
      Guardar canales de clientes descuentos
============================================================*/

function guardarFormularioDescuento(){

  var cmbCanal = $("#idCanalProductos").val()+"/"+$("#tokenCanalProductos").val();

  var txtDescuento = $("#txtDescuento").val();

  var txtDesde = $("#txtDesde").val();

  var txtHasta = $("#txtHasta").val();

  var tokenDescuento="";

  // var desde = $("#desde").val();
  // var hasta = $("#hasta").val();

  // var estado = 0;

  if(parseInt(txtDesde) >= parseInt(txtHasta)){

    swal("Error", "Favor corregir el intérvalo de montos antes de continuar", "error");
    $( "#txtHasta" ).focus();
    // return;

  }else{

    // alert("txtDesde: " + txtDescuento + " txtHasta: "+ txtHasta + "codcanal: " + cmbCanal);
    // return;

    var datos = new FormData();

      datos.append("cmbCanal", cmbCanal);
      datos.append("txtDescuento", txtDescuento);
      datos.append("txtDesde", txtDesde);
      datos.append("txtHasta", txtHasta);
      datos.append("tokenDescuento", tokenDescuento);
      // datos.append("estado", estado);


      $.ajax({
      url: "ajax/descuentosProductos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,

      success: function(respuesta) {

        var objData = JSON.parse(respuesta);

        if (objData.status) {

          $('#ModalDescuento').modal('hide');

          formDescuento.reset();

          swal("success",objData.msg,"success");

        } else {

          swal("Error", objData.msg, "error");

        }

      }

    })

  }
  
  return (false);

}


/*=============================================
      Asignar Canal
=============================================*/


$(document).on("click", ".AsiganarCanal", function() {
  var id_canal = $(this).attr("IdCanal")+"/"+$(this).attr("tokenCanal");
  var token_canal = $(this).attr("tokenCanal");
  var nombre_canal = $(this).attr("nombrecanal");

  $("#TablaDescuento td").remove();
  $("#idCanalProductos").val(id_canal);
  $("#tokenCanalProductos").val(token_canal);
  $("#txtCanalDescuento").val(nombre_canal);

   var datos = new FormData();

      datos.append("canal", id_canal);

      $.ajax({

        url: "ajax/descuentosProductos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
         
        var f ;
        var can =0;
        var monto=0;
        for (var i = 0; i < respuesta.length ; i++) {
          can+=1;
         
         f+= `<tr>
         <td class="text-center">`+can+`</td>
         <td class="text-center" >`+respuesta[i]["CANTIDAD_DESDE"]+`</td>
         <td class="text-center">`+respuesta[i]["CANTIDAD_HASTA"]+`</td>
         <td class="text-center">`+new Intl.NumberFormat("de-DE").format(respuesta[i]["DESC_CANAL"])+' %'+`</td>'
         </tr>`;
         }
     $("#TablaDescuento").append(f);

        }
      })
})

/*=============================================
      Editar Canal
=============================================*/

$(document).on("click", ".editarCanal", function() {

  $("#titulo").html("Editar canal");
  $("#btnGuardar").html("Actualizar");

  LimpiarText();

  var token_canal = $(this).attr("tokenCanal");

  // console.log(token_canal);

  // return;
  
  var datos = new FormData();

  datos.append("token_canal", token_canal);

  $.ajax({

    url: "ajax/canalesProductos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      // console.log(respuesta);

      $("#txtCanal").val(respuesta["DESCRIPCION_CANAL"]);

      $("#cmbEstado").val(respuesta["ESTADO"]);
      $("#cmbEstado").select2().trigger('change');//aplicar la seleccion

      $("#tokenCanal").val(respuesta["TOKEN_CANAL"]);

    }

  })

})


/*=============================================
Eliminar Canal
=============================================*/

$(document).on("click", ".eliminarCanal", function() {

  var tokenCanal = $(this).attr("tokenCanal");

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

      datos.append("idEliminar", tokenCanal);

      $.ajax({

        url: "ajax/canalesProductos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {

          var objData = JSON.parse(respuesta);

          if (objData.status) {

            swal("success", objData.msg, "success");
            
            tablaCanales.ajax.reload(function() {

              LimpiarText();

            });

          }else{
             swal("Error", objData.msg, "error");
          }

        }

      })

    }

  });

})

var txtEquipo;

$(document).on("click", ".btnNuevo", function() {

  $("#titulo").html("Nuevo canal");
  $("#btnGuardar").html("Guardar");

  LimpiarText();

})

function LimpiarText() {

  formCanal.reset();

  $("#idCanal").val("");

  $("#tokenCanal").val("");

  $("#txtCanal").val("");

  $("#cmbEstado").select2().trigger('change');

}