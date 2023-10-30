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
 var tablaCategoria=$(".tablaCategoria").DataTable({
  "ajax":"ajax/tablaCategorias.ajax.php",
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

   },
    'dom': 'lBfrtip',
    'buttons': [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr":"Copiar",
            "className": "btn btn-secondary",
            "exportOptions": { 
                "columns": [ 0, 2, 3] 
            }
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Esportar a Excel",
            "className": "btn btn-success",
            "exportOptions": { 
                "columns": [ 0, 2, 3] 
            }
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Esportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": { 
                "columns": [ 0,  2, 3] 
            }
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Esportar a CSV",
            "className": "btn btn-info",
            "exportOptions": { 
                "columns": [ 0,  2, 3] 
            }
          }
        ]

})



// ES PARA GUARDAR LOS DATOS EN LA BASE DE DATOS//
function Guardarformulario(){

var txtCategoria=document.querySelector('input[name="txtCategoria"]').value;
var idCategoria=document.querySelector('input[name="idCategoria"]').value;
var tokenCategoria=document.querySelector('input[name="TokenCategoria"]').value;
 
 if (txtCategoria==''){
swal("Atennción","El campo es obligatorio.","error");
  return false;
}

    var datos = new FormData();
    datos.append("txtCategoria", txtCategoria);
    datos.append("idCategoriaEditar", idCategoria);
    datos.append("tokenCategoria", tokenCategoria);
     $.ajax({
      url:"ajax/categorias.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,

      success: function(respuesta){

       var objData = JSON.parse(respuesta);
       
        if(objData.status){
          $('#ModalCategoria').modal('hide');

           formCategoria.reset();
            swal("success",objData.msg,"success");
           tablaCategoria.ajax.reload(function() {
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

$(document).on("click", ".editarCategoria", function(){

document.querySelector("#titulo").innerHTML="Editar categoria";
document.querySelector("#btnGuardar").innerHTML="Actualizar";
LimpiarText();

  var token_categoria = $(this).attr("tokenCategoria");
  
  var datos = new FormData();

  datos.append("token_categoria", token_categoria);

  $.ajax({

    url:"ajax/categorias.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success:function(respuesta){

        //console.log("respuesta", respuesta);

        $('input[name="idCategoria"]').val(respuesta["COD_CATEGORIA"]);
        $('input[name="TokenCategoria"]').val(respuesta["TOKEN_CATEGORIA"]);
        $('input[name="txtCategoria"]').val(respuesta["NOMBRE_CATEGORIA"]);
      
      }

  })  

})

/*=============================================
Eliminar PERFIL
=============================================*/

$(document).on("click", ".eliminarCategoria", function(){

  var token = $(this).attr("tokenCategoria");
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

          url:"ajax/categorias.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success:function(respuesta){
            var objData = JSON.parse(respuesta);
                
              if(objData.status){
                swal("success",objData.msg,"success");
                  tablaCategoria.ajax.reload(function() {
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
document.querySelector("#titulo").innerHTML="Nueva categoria";
document.querySelector("#btnGuardar").innerHTML="Guardar";
LimpiarText();

})

function LimpiarText(){
  document.querySelector('input[name="txtCategoria"]').value="";
  document.querySelector('input[name="idCategoria"]').value="";
  document.querySelector('input[name="TokenCategoria"]').value="";

}