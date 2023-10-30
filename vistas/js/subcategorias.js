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
 var tablasubCategoria=$(".tablasubCategoria").DataTable({
  // "data":datos,
  "ajax":"ajax/tablasubCategorias.ajax.php",
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

var txtSubCategoria=document.querySelector('input[name="txtSubCategoria"]').value;
var idSubCategoria=document.querySelector('input[name="idSubCategoria"]').value;
var tokenSubCategoria=document.querySelector('input[name="TokenSubCategoria"]').value;
 
 if (txtSubCategoria==''){
swal("Atennción","El campo es obligatorio.","error");
  return false;
}

    var datos = new FormData();
    datos.append("txtSubCategoria", txtSubCategoria);
    datos.append("idSubCategoriaEditar", idSubCategoria);
    datos.append("tokenSubCategoria", tokenSubCategoria);
     $.ajax({
      url:"ajax/subcategorias.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,

      success: function(respuesta){

       var objData = JSON.parse(respuesta);
       
        if(objData.status){
          $('#ModalSubCategoria').modal('hide');

           formSubCategoria.reset();
            swal("success",objData.msg,"success");
           tablasubCategoria.ajax.reload(function() {
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

$(document).on("click", ".editarSubCategoria", function(){

document.querySelector("#titulo").innerHTML="Editar sub categoria";
document.querySelector("#btnGuardar").innerHTML="Actualizar";
LimpiarText();

  var token_subcategoria = $(this).attr("tokenSubCategoria");
  console.log(token_subcategoria);
  var datos = new FormData();

  datos.append("token_subcategoria", token_subcategoria);

  $.ajax({

    url:"ajax/subcategorias.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success:function(respuesta){

        //console.log("respuesta", respuesta);

        $('input[name="idSubCategoria"]').val(respuesta["COD_SUBCATEGORIA"]);
        $('input[name="TokenSubCategoria"]').val(respuesta["TOKEN_SUBCATEGORIA"]);
        $('input[name="txtSubCategoria"]').val(respuesta["NOMBRE_SUBCATEGORIA"]);
      
      }

  })  

})

/*=============================================
Eliminar PERFIL
=============================================*/

$(document).on("click", ".eliminarSubCategoria", function(){

  var token = $(this).attr("tokenSubCategoria");
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

          url:"ajax/subcategorias.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success:function(respuesta){
            var objData = JSON.parse(respuesta);
                
              if(objData.status){
                swal("success",objData.msg,"success");
                  tablaSubCategoria.ajax.reload(function() {
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
document.querySelector("#titulo").innerHTML="Nueva sub categoria";
document.querySelector("#btnGuardar").innerHTML="Guardar";
LimpiarText();

})

function LimpiarText(){
  document.querySelector('input[name="txtSubCategoria"]').value="";
  document.querySelector('input[name="idSubCategoria"]').value="";
  document.querySelector('input[name="TokenSubCategoria"]').value="";

}