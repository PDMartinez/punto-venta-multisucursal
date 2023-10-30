/*=============================================
Tabla Perfiles
=============================================*/

// $.ajax({

//     "url":"ajax/tablaPerfiles.ajax.php",
//     success: function(respuesta){
      
//      console.log("respuesta", respuesta);

//     }

// })
 
  // "ajax":"ajax/tablaCategorias.ajax.php?txtCategoria="+txtCategoria,
 var tablaFormapagos=$(".tablaFormapagos").DataTable({
  // "data":datos,
  "ajax":"ajax/tablaFormapagos.ajax.php",
  "method":"GET",
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  "language": {

     "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
      "sFirst":    "Primero",
      "sLast":     "Último",
      "sNext":     "Siguiente",
      "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }

   }

})



// ES PARA GUARDAR LOS DATOS EN LA BASE DE DATOS//
function Guardarformulario(){

var txtFormaPagos=document.querySelector('input[name="txtFormaPagos"]').value;
var idFormaPagos=document.querySelector('input[name="idFormaPagos"]').value;
var TokenFormaPagos=document.querySelector('input[name="TokenFormaPagos"]').value;
var check= $("#chkEfectivo").val();

 
 if (txtFormaPagos==''){
swal("Atennción","El campo es obligatorio.","error");
  return false;
}

    var datos = new FormData();
    datos.append("txtFormaPagos", txtFormaPagos);
    datos.append("idFormaPagosEditar", idFormaPagos);
    datos.append("TokenFormaPagos", TokenFormaPagos);
     datos.append("activoefectivo", check);
     $.ajax({
      url:"ajax/formapagos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,

      success: function(respuesta){

       var objData = JSON.parse(respuesta);
       
        if(objData.status){
          $('#ModalFormapagos').modal('hide');

           formFormaPagos.reset();
            swal("success",objData.msg,"success");
           tablaFormapagos.ajax.reload(function() {
                     // body...
              });

        }else{
          swal("Error",objData.msg,"error");
        }
     }

    })
return(false);

} 


/*=============================================
Editar Carrera
=============================================*/

$(document).on("click", ".editarFormaPagos", function(){

document.querySelector("#titulo").innerHTML="Editar forma de pagos";
document.querySelector("#btnGuardar").innerHTML="Actualizar";
LimpiarText();

  var token_formapagos = $(this).attr("tokenFormaPagos");
  
  var datos = new FormData();

  datos.append("token_formapagos", token_formapagos);

  $.ajax({

    url:"ajax/formapagos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success:function(respuesta){

        //console.log("respuesta", respuesta);

        $('input[name="idFormaPagos"]').val(respuesta["COD_FORMAPAGO"]);
        $('input[name="TokenFormaPagos"]').val(respuesta["TOKEN_FORMAPAGO"]);
        $('input[name="txtFormaPagos"]').val(respuesta["DESCRIPCION_FORMA"]);
     
        if(respuesta["EFECTIVO"]==1){
          $("#chkEfectivo").prop("checked", true);
        }else{
          $("#chkEfectivo").prop("checked", false);
        }
        
      
      }

  })  

})

/*=============================================
Eliminar PERFIL
=============================================*/

$(document).on("click", ".eliminarFormaPagos", function(){

  var token = $(this).attr("tokenFormaPagos");
  swal({
    title: '¿Está seguro de eliminar este registro?',
    text: "¡Si elimina ya no podras recuperar, si no lo estas puedes anular",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, eliminar el dato!',
    closeOnConfirm: false,
    closeOnCancel: true
  },function(isConfirm){

    if(isConfirm){
      
        var datos = new FormData();
        datos.append("idEliminar", token);
      
        $.ajax({

          url:"ajax/formapagos.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success:function(respuesta){
            var objData = JSON.parse(respuesta);
                
              if(objData.status){
                swal("success",objData.msg,"success");
                  tablaFormapagos.ajax.reload(function() {
                                 // body...
                  });

              }else{
                  swal("Error",objData.msg,"error");
                }

              }

        })

      }

    });

})



/*=============================================
Anular forma de pagos
=============================================*/

$(document).on("click", ".AnularFormaPagos", function() {

  let  tokenFormaPagos = $(this).attr("tokenFormaPagos");
  let estado=$(this).attr("estado");

  if(estado==1){

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

      datos.append("idAnular", tokenFormaPagos);
      datos.append("estado", estado);

      $.ajax({

        url: "ajax/formapagos.ajax.php",
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

  }else{

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

      var datos = new FormData();

      datos.append("idAnular", tokenFormaPagos);
      datos.append("estado", estado);

      $.ajax({

        url: "ajax/formapagos.ajax.php",
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

  }



})



$(document).on("click", "#btnNuevo", function(){
document.querySelector("#titulo").innerHTML="Nueva forma de pagos";
document.querySelector("#btnGuardar").innerHTML="Guardar";
LimpiarText();

})

function LimpiarText(){
  document.querySelector('input[name="txtFormaPagos"]').value="";
  document.querySelector('input[name="idFormaPagos"]').value="";
  document.querySelector('input[name="TokenFormaPagos"]').value="";
  $("#chkEfectivo").prop("checked", false);

}

function Activarcheck(){
            
  if($("#chkEfectivo").is(':checked')) {
    $("#chkEfectivo").val(1);
  }else{
    $("#chkEfectivo").val(0);
  }


}