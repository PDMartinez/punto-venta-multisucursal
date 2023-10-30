
// const formCaja= $("#formCaja").val();

/*==========================================================
      CARGAR LOS DATOS EN LA TABLA Y DARLE FORMATO
============================================================*/

var tablaDescuentos = $(".tablaDescuentos").DataTable({

  "ajax": "ajax/tablaDescuentosProductos.ajax.php",
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
      Guardar Caja
============================================================*/

function guardarFormulario(){

  var cmbCanal = $("#cmbCanal").val();

  var txtDescuento = $("#txtDescuento").val();

  var txtDesde = $("#txtDesde").val();

  var txtHasta = $("#txtHasta").val();

  var tokenDescuento = $("#tokenDescuento").val();

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

          tablaDescuentos.ajax.reload(function() {
            
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

$(document).on("click", ".editarDescuento", function() {

  $("#titulo").html("Editar descuento");
  $("#btnGuardar").html("Actualizar");

  LimpiarText();

  
  var token_descuento = $(this).attr("tokenDescuento");

  // console.log(token_descuento);

  // return;
  
  var datos = new FormData();

  datos.append("token_descuento", token_descuento);

  $.ajax({

    url: "ajax/descuentosProductos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

       //console.log(respuesta);

      $("#cmbCanal").val(respuesta["COD_CANAL"]+"/"+respuesta["TOKEN_CANAL"]);
      $("#cmbCanal").select2().trigger('change');//aplicar la seleccion

      $("#txtDescuento").val(new Intl.NumberFormat("de-DE").format(respuesta["DESC_CANAL"]));

      $("#txtDesde").val(respuesta["CANTIDAD_DESDE"]);
      $("#txtDesde").number(true,0);

      $("#txtHasta").val(respuesta["CANTIDAD_HASTA"]);
      $("#txtHasta").number(true,0);

      $("#tokenDescuento").val(respuesta["TOKEN"]);
      $("#idDescuento").val(respuesta["COD_DETCANAL"]);


      $("#desde").val(respuesta["CANTIDAD_DESDE"]);
      $("#hasta").val(respuesta["CANTIDAD_HASTA"]);

    }

  })

})


/*=============================================
Eliminar Descuento
=============================================*/

$(document).on("click", ".eliminarDescuento", function() {

  var tokenDescuento = $(this).attr("tokenDescuento");

  // alert(tokenDescuento);
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

      datos.append("idEliminar", tokenDescuento);

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

            tablaDescuentos.ajax.reload(function() {
              
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

  $("#titulo").html("Nuevo descuento");
  $("#btnGuardar").html("Guardar");

  LimpiarText();
  
})

function LimpiarText() {

  formDescuento.reset();

  $("#idDescuento").val("");

  $("#tokenDescuento").val("");

  $("#cmbCanal").select2().trigger('change');

  $("#txtDescuento").val("");

  $("#txtDesde").val("");

  $("#txtHasta").val("");

  $(".tituloDescuento").remove();
  $(".tablaDesc").remove();

}

$(document).ready(function(){

  $( "#cmbCanal" ).change(function() {


    var cmbCanal = $("#cmbCanal").val();

    // console.log(cmbCanal);
    // return;

    if(cmbCanal != ""){
    
      var datos = new FormData();

      datos.append("canal", cmbCanal);

      $.ajax({

        url: "ajax/descuentosProductos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

          // console.log($(this).parent().parent());
          $(".tituloDescuento").remove();
          $(".tablaDesc").remove();

          var longitud = Object.keys(respuesta).filter((v) => {return respuesta[v] !== undefined}).length;



          $(".tablaDescuento").append(

            '<div class="card-header pl-2 pl-sm-3 tituloDescuento">'+

              '<h5>Descuentos registrados para este canal:</h5>'+

            '</div>'+

            '<div class="table-responsive tablaDesc">'+

              '<table class="table table-sm">'+

                '<thead>'+

                  '<tr>'+

                    '<th><center>#</center></th>'+
                    '<th><center>Cantidad Desde</center></th>'+
                    '<th><center>Cantidad Hasta</center></th>'+
                    '<th><center>Descuento %</center></th>'+

                  '</tr>'+

                '</thead>'+

                '<tbody>'+

                  '<!-- Numero-->'+

                  '<td class="tdNumero">'+


                  '</td>'+

                                             
                  '<!-- Monto Desde-->'+

                  '<td class="tdDesde" style="">'+


                  '</td>'+

                  '<!-- Monto Hasta -->'+

                  '<td class="tdHasta" style="">'+


                  '</td>'+

                  '<!-- Fecha Registro -->'+

                  '<td class="tdDescuento" style="">'+


                  '</td>'+
                                         

                '</tbody>'+

              '</table>'+

            '</div>'

          );

          if(longitud > 0){

            $.each(respuesta, function(key,value) {

          //    console.log("Desde: "+value[3] + " Hasta: "+value[4]);

              $(".tdNumero").append(

                '<!-- # -->'+

                  '<div class="form-group '+(key+1)+'">'+

                    '<div class="input-group" style="width: 40px"">'+
                
                      '<input type="text" class="form-control text-center nuevoDesde" idDesde="'+(key+1)+'" name="nuevoDesde" value="'+(key+1)+'" readonly>'+
                      // '<label class="control-label">"'+value[3]+'" <span style="color:red">*</span></label>'+

                    '</div>'+

                  '</div>'

              );

              $(".tdDesde").append(

                '<!-- MONTO DESDE -->'+

                  '<div class="form-group '+value[3]+'">'+

                    '<div class="input-group"">'+
                
                      '<input type="text" class="form-control text-center nuevoDesde" idDesde="'+value[3]+'" name="nuevoDesde" value="'+ new Intl.NumberFormat("de-DE").format(value[3]) +'" readonly>'+
                      // '<label class="control-label">"'+value[3]+'" <span style="color:red">*</span></label>'+

                    '</div>'+

                  '</div>'

              );


              $(".tdHasta").append(

                '<!-- MONTO HASTA -->'+

                  '<div class="form-group '+value[4]+'">'+

                    '<div class="input-group">'+
                
                      '<input type="text" class="form-control text-center nuevoHasta" idHasta="'+value[4]+'" name="nuevoHasta" value="'+ new Intl.NumberFormat("de-DE").format(value[4]) +'" readonly>'+
                      // '<label class="control-label">"'+value[4]+'" <span style="color:red">*</span></label>'+

                    '</div>'+

                  '</div>'

              );

              $(".tdDescuento").append(

                '<!-- DESCUENTO -->'+

                  '<div class="form-group '+value[2]+'">'+

                    '<div class="input-group">'+
                
                      '<input type="text" class="form-control text-center fechaReg" idFechaReg="'+value[2]+'" name="fechaReg" value="'+ new Intl.NumberFormat("de-DE").format(value[2]) +' %" readonly>'+
                      // '<label class="control-label">"'+value[5]+'" <span style="color:red">*</span></label>'+

                    '</div>'+

                  '</div>'

              );


            }); 

          }

        }

      })

    }else{

      $(".tituloDescuento").remove();
      $(".tablaDesc").remove();

    }

  });

});
