/*=============================================
Tabla Perfiles
=============================================*/

// $.ajax({

//     "url":"ajax/tablaPerfiles.ajax.php",
//     success: function(respuesta){
      
//      console.log("respuesta", respuesta);

//     }

// })


var tablaCiudad=$(".tablaCiudad").DataTable({
  "ajax":"ajax/tablaCiudades.ajax.php",
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

var txtCiudad=document.querySelector('input[name="txtCiudad"]').value;
var idCiudad=document.querySelector('input[name="idCiudad"]').value;
var tokenCiudad=document.querySelector('input[name="TokenCiudad"]').value;
 
 if (txtCiudad==''){
swal("Atennción","El campo nombre es obligatorio.","error");
  return false;
}

var datos = new FormData();
    datos.append("txtCiudad", txtCiudad);
    datos.append("idCiudadEditar", idCiudad);
    datos.append("tokenCiudad", tokenCiudad);
     $.ajax({
      url:"ajax/ciudades.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,

      success: function(respuesta){

       var objData = JSON.parse(respuesta);
       
        if(objData.status){
          $('#ModalCiudad').modal('hide');

           formCiudad.reset();
            swal("success",objData.msg,"success");
           tablaCiudad.ajax.reload(function() {
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

$(document).on("click", ".editarCiudad", function(){

document.querySelector("#titulo").innerHTML="Editar Ciudad";
document.querySelector("#btnGuardar").innerHTML="Actualizar";
LimpiarText();

  var token_ciudad = $(this).attr("tokenCiudad");
  
  var datos = new FormData();

  datos.append("token_ciudad", token_ciudad);

  $.ajax({

    url:"ajax/ciudades.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success:function(respuesta){

        //console.log("respuesta", respuesta);

        $('input[name="idCiudad"]').val(respuesta["COD_CIUDAD"]);
        $('input[name="TokenCiudad"]').val(respuesta["TOKEN_CIUDAD"]);
        $('input[name="txtCiudad"]').val(respuesta["DESCRIPCION_CIUDAD"]);
      
      }

  })  

})

/*=============================================
Eliminar PERFIL
=============================================*/

$(document).on("click", ".eliminarCiudad", function(){

  var token = $(this).attr("tokenCiudad");
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
  },function(isConfirm){

    if(isConfirm){
      
        var datos = new FormData();
        datos.append("idEliminar", token);
      
        $.ajax({

          url:"ajax/ciudades.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success:function(respuesta){
            var objData = JSON.parse(respuesta);
                
              if(objData.status){
                swal("success",objData.msg,"success");
                  tablaCiudad.ajax.reload(function() {
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



$(document).on("click", "#btnNuevo", function(){
document.querySelector("#titulo").innerHTML="Nueva ciudad";
document.querySelector("#btnGuardar").innerHTML="Guardar";
LimpiarText();

})

function LimpiarText(){
   document.querySelector('input[name="txtCiudad"]').value="";
   document.querySelector('input[name="idCiudad"]').value="";
 document.querySelector('input[name="TokenCiudad"]').value="";

}