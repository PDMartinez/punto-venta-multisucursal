/*=============================================
Tabla Perfiles
=============================================*/

// $.ajax({

//     "url":"ajax/tablaPerfiles.ajax.php",
//     success: function(respuesta){
      
//      console.log("respuesta", respuesta);

//     }

// })

 
var tablaPerfil=$(".tablaPerfiles").DataTable({
  "ajax":"ajax/tablaPerfiles.ajax.php",
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
    "createdRow": function(row,data,index){
    if( data[6] =="A" ){
      $(row).addClass("table-success");
      // $('td',row).css({
      //   'background-color':'#1F7246',
      //   'color':'white',
      // });
     // $(row).css('background-color', '#464775');
    }
    //else if(data[10] =="Activo"){
    //    $('td',row).eq(10).css({
    //     // 'background-color':'#27A644',
    //     'color':'#27A644',
    //   });
    // }
    // else if(data[10] =="Inactivo"){
    //    $('td',row).eq(10).css({
    //     'background-color':'#FF0101',
    //     'color':'white',
    //   });
    // }
  }

})



// ES PARA GUARDAR LOS DATOS EN LA BASE DE DATOS//
function Guardarformulario(){

var txtNombre=document.querySelector('input[name="nuevoPerfil"]').value;
var txtDescripcion=document.querySelector('#nuevoDescripcion').value;
var chkActivo=document.querySelector('input[name="nuevoActivo"]').value;
var idPerfil=document.querySelector('input[name="idPerfil"]').value;
var tokenPerfil=document.querySelector('input[name="TokenPerfil"]').value;
var estado=document.querySelector('#cmbEstado').value;

 if (txtNombre==''){
swal("Atennción","El campo nombre es obligatorio.","error");
  return false;
}

var datos = new FormData();
    datos.append("txtNombre", txtNombre);
    datos.append("txtDescripcion", txtDescripcion);
    datos.append("chkActivo", chkActivo);
    datos.append("idPerfilEditar", idPerfil);
    datos.append("tokenPerfil", tokenPerfil);
    datos.append("estado", estado);
    datos.append("principal", chkActivo);

     $.ajax({
      url:"ajax/perfiles.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,

      success: function(respuesta){

       var objData = JSON.parse(respuesta);
       
        if(objData.status){
          $('#ModalPerfil').modal('hide');

           formPerfil.reset();
            swal("success",objData.msg,"success");
           tablaPerfil.ajax.reload(function() {
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

$(document).on("click", ".editarPerfil", function(){

document.querySelector("#titulo").innerHTML="Editar Perfil";
document.querySelector("#btnGuardar").innerHTML="Actualizar";
LimpiarText();

  var token_perfil = $(this).attr("tokenPerfil");
  
  var datos = new FormData();

  datos.append("token_perfil", token_perfil);

  $.ajax({

    url:"ajax/perfiles.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success:function(respuesta){

        //console.log("respuesta", respuesta);

        $('input[name="idPerfil"]').val(respuesta["COD_PERFIL"]);
        $('input[name="TokenPerfil"]').val(respuesta["TOKEN_PERFIL"]);
        $('input[name="nuevoPerfil"]').val(respuesta["NOMBRE_PERFIL"]);
        $("#nuevoDescripcion").val(respuesta["DESCRIPCION_PERFIL"]);
        $("#cmbEstado").val(respuesta["ESTADO_PERFIL"]);
        $("#nuevoActivo").val(respuesta["SUPER_PERFIL"]);
          
          if (respuesta["SUPER_PERFIL"]==1){
            document.getElementById("nuevoActivo").checked = true;
                $("#cmbEstado").prop('disabled', 'disabled');
          }else{
            document.getElementById("nuevoActivo").checked = false;
            $("#cmbEstado").removeAttr('disabled');
          }

      }

  })  

})

/*=============================================
Eliminar PERFIL
=============================================*/

$(document).on("click", ".eliminarPerfil", function(){

  var token = $(this).attr("tokenPerfil");
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

          url:"ajax/perfiles.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success:function(respuesta){
            var objData = JSON.parse(respuesta);
                
              if(objData.status){
                swal("success",objData.msg,"success");
                  tablaPerfil.ajax.reload(function() {
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

function Activarcheck(){
						
	if($("#nuevoActivo").is(':checked')) {
		$("#nuevoActivo").val(1);
	}else{
		$("#nuevoActivo").val(0);
	}


}


$(document).on("click", "#btnNuevo", function(){
document.querySelector("#titulo").innerHTML="Nuevo Perfil";
document.querySelector("#btnGuardar").innerHTML="Guardar";
LimpiarText();

})

function LimpiarText(){
   document.querySelector('input[name="nuevoPerfil"]').value="";
  document.querySelector("#nuevoDescripcion").value="";
  document.querySelector('input[name="idPerfil"]').value="";
 document.querySelector('input[name="TokenPerfil"]').value="";
  document.querySelector('input[name="nuevoActivo"]').checked=false;
  document.querySelector('input[name="nuevoActivo"]').value=0;
    $("#cmbEstado").val(1);
   $("#cmbEstado").removeAttr('disabled');

}