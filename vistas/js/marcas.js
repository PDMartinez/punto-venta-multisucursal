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
 var tablaMarcas=$(".tablaMarcas").DataTable({
  // "data":datos,
  "ajax":"ajax/tablaMarcas.ajax.php",
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
  
var txtmarca=document.querySelector('input[name="txtmarca"]').value;

var idMarca=document.querySelector('input[name="idmarca"]').value;

var tokenMarca=document.querySelector('input[name="tokenMarca"]').value;


 if (txtmarca==''){
swal("Atennción","El campo es obligatorio.","error");
  return false;
}

    var datos = new FormData();
    datos.append("txtmarca", txtmarca);
    datos.append("idMarcaEditar", idMarca);
    datos.append("tokenMarcaEditar", tokenMarca);
     $.ajax({
      url:"ajax/marcas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,

      success: function(respuesta){

       var objData = JSON.parse(respuesta);
       
        if(objData.status){
          $('#ModalMarca').modal('hide');

            swal("success",objData.msg,"success");
           tablaMarcas.ajax.reload(function() {
                    LimpiarText();
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

$(document).on("click", ".editarMarca", function(){

document.querySelector("#titulo").innerHTML="Editar marca";
document.querySelector("#btnGuardar").innerHTML="Actualizar";
LimpiarText();

  var tokenMarca = $(this).attr("tokenMarca");
  
  var datos = new FormData();

  datos.append("tokenMarca", tokenMarca);

  $.ajax({

    url:"ajax/marcas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success:function(respuesta){

        //console.log("respuesta", respuesta);

        $('input[name="idmarca"]').val(respuesta["COD_MARCA"]);
        $('input[name="tokenMarca"]').val(respuesta["TOKEN_MARCA"]);
        $('input[name="txtmarca"]').val(respuesta["NOMBRE_MARCA"]);
      
      }

  })  

})

/*=============================================
Eliminar PERFIL
=============================================*/

$(document).on("click", ".eliminarMarca", function(){

  var token = $(this).attr("tokenMarca");
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

          url:"ajax/marcas.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success:function(respuesta){
            var objData = JSON.parse(respuesta);
                
              if(objData.status){
                swal("success",objData.msg,"success");
                  tablaMarcas.ajax.reload(function() {
                               LimpiarText();
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
document.querySelector("#titulo").innerHTML="Nueva marca";
document.querySelector("#btnGuardar").innerHTML="Guardar";
LimpiarText();

})

function LimpiarText(){
  document.querySelector('input[name="txtmarca"]').value="";
  document.querySelector('input[name="idmarca"]').value="";
  document.querySelector('input[name="tokenMarca"]').value="";

}


/*=============================================
VALIDAR EMAIL REPETIDO
=============================================*/

$('input[name="txtmarca"]').change(function() {
 $(".alert").remove();
  var marca = $(this).val();

  var datos = new FormData();
  datos.append("validarmarca", marca);

  $.ajax({

    url: "ajax/marcas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {
     // console.log("respuesta", respuesta);

      if (respuesta) {

        $('input[name="txtmarca"]').val("");

        $('input[name="txtmarca"]').after(`

        <div class="alert alert-warning">
          <strong>ERROR:</strong>
          La marca ya esta registrada, por favor ingrese otro diferente
        </div>

        `);

        return;

      }

    }

  })

})