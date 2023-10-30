/*=============================================
Tabla Perfiles
=============================================*/

// $.ajax({

//     "url":"ajax/tablaPerfiles.ajax.php",
//     success: function(respuesta){

//      console.log("respuesta", respuesta);

//     }

// })

//const formSucursal=document.getElementById("formSucursal");


// $(document).on("click", "#btnActivo", function(){

// window.location="sucursalesDesactivo";


// })

// $(document).on("click", "#btnActivoInactivo", function(){
//      window.location="sucursales";
// })
// "ajax":"ajax/tablaSucursales.ajax.php?activo="+$("#btnActivo").attr("activo"),
// $(".tablaSucursales").DataTable({
//    "ajax": "ajax/tablaSucursales.ajax.php",
//    "createdRow": function(row,data,index){
//     if( data[6] == 0  ){
//       $('td',row).css({
//         'background-color':'#464775',
//         'color':'white',
//       });
//      // $(row).css('background-color', '#464775');
//   }
//   }
// })

var tablaSucursal = $(".tablaSucursales").DataTable({
  "ajax": "ajax/tablaSucursales.ajax.php",
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
    "createdRow": function(row,data,index){
    if( data[13] =="P" ){
      $('td',row).css({
        'background-color':'#1F7246',
        'color':'white',
      });
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

function bloquear(count) {

  $.ajax({
    url: "ajax/cantidades.ajax.php",
    method: "POST",
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function(respuesta) {

      var cantidad = respuesta["CANT_SUCURSALES"];
 
       if (parseInt(count) >= parseInt(cantidad)) {
        
        $('.btnNuevo').hide();
        $('.texto').show();


      } else {
        $('.btnNuevo').show();
        $('.texto').hide();

      }
    }
  })
}

// ES PARA GUARDAR LOS DATOS EN LA BASE DE DATOS//


function Guardarformulario() {
//validarPrincipal();

// if (variablePrin==true){
  // DESDE ESTA PARTE EMPESAMOS A GUARDAR LOS DATOS

  var txtSucursal = document.querySelector('input[name="txtSucursal"]').value;

  var txtEncargado = document.querySelector('input[name="txtEncargado"]').value;
   var txtRuc = document.querySelector('input[name="txtRuc"]').value;
  

  var txtDireccion = document.querySelector('input[name="txtDireccion"]').value;
  var cmbCiudad = $("#cmbCiudad").val();
  //var cmbCiudad=document.querySelector('input[name="cmbCiudad"]').value;
  //console.log(cmbCiudad);
  //return(false);

  var txtVerificador = document.querySelector('input[name="txtNroVerficador"]').value;
  var txtpedidos = document.querySelector('input[name="txtnroPedidos"]').value;
  var txtRemision = document.querySelector('input[name="txtnroRemision"]').value;
  var txtTelefono = document.querySelector('input[name="txtTelefono"]').value;
  var chkActivo=document.querySelector('input[name="nuevoActivo"]').value;
 
  //return(false);
  var cmbEstado = $("#cmbEstado").val();
  // console.log(cmbEstado);
  // return false;
  // var cmbEstado=document.querySelector('input[name="cmbEstado"]').value;

  var galeria = $(".inputNuevaGaleria").val();
  var galeriaAntigua = $(".inputAntiguaGaleria").val();
  var galeriaAntiguaEstatica = $(".inputAntiguaGaleriaEstatica").val();

  var idSucursal = document.querySelector('input[name="idSucursal"]').value;
  var tokenSucursal = document.querySelector('input[name="TokenSucursal"]').value;

  if (txtSucursal == '' || txtEncargado == '' || txtVerificador == '' || txtpedidos == '' || txtRemision == '' || cmbCiudad == '') {
    swal("Atennción", "Los campos con * es obligatorio.", "error");
    return false;
  }



  var datos = new FormData();
  datos.append("txtSucursal", txtSucursal);
  datos.append("txtEncargado", txtEncargado);
  datos.append("txtDireccion", txtDireccion);
  datos.append("idSucursalEditar", idSucursal);
  datos.append("tokenSucursal", tokenSucursal);
  datos.append("txtRuc", txtRuc);
  datos.append("cmbCiudad", cmbCiudad);
  datos.append("txtVerificador", txtVerificador);
  datos.append("txtpedidos", txtpedidos);
  datos.append("txtRemision", txtRemision);
  datos.append("txtTelefono", txtTelefono);
  datos.append("cmbEstado", cmbEstado);
  datos.append("imgGaleria", galeria);
  datos.append("imgGaleriaAntigua", galeriaAntigua);
  datos.append("imgGaleriaAntiguaEstatica", galeriaAntiguaEstatica);
  datos.append("principal", chkActivo);

  $.ajax({
    url: "ajax/sucursales.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,

    success: function(respuesta) {


      var objData = JSON.parse(respuesta);

      if (objData.status) {
        $('#ModalSucursal').modal('hide');

        formSucursal.reset();
        swal("success", objData.msg, "success");
        tablaSucursal.ajax.reload(function() {

          var count = $('.tablaSucursales > * > tr').length - 1;
          bloquear(count);
          LimpiarText();

        });

      } else {
        swal("Error", objData.msg, "error");
      }
    }

  })
  
  return (false);

  // }else{
  //        swal("Error","Debes seleccionar una sucursal como principal", "error");

  //       return (false);
  // }



}




/*=============================================
Editar Carrera
=============================================*/

$(document).on("click", ".editarSucursal", function() {

  document.querySelector("#titulo").innerHTML = "Editar sucursal";
  document.querySelector("#btnGuardar").innerHTML = "Actualizar";
  LimpiarText();
  
  var token_sucursal = $(this).attr("tokenSucursal");

  var datos = new FormData();

  datos.append("token_sucursal", token_sucursal);

  $.ajax({

    url: "ajax/sucursales.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      //console.log("respuesta", respuesta);
//validarPrincipal();

      $('input[name="idSucursal"]').val(respuesta["COD_SUCURSAL"]);
      $('input[name="TokenSucursal"]').val(respuesta["TOKEN_SUCURSAL"]);
      $('input[name="txtSucursal"]').val(respuesta["SUCURSAL"]);
      $('input[name="txtDireccion"]').val(respuesta["DIRECCION"]);

      $('input[name="txtEncargado"]').val(respuesta["ENCARGADO"]);
      $('input[name="txtNroVerficador"]').val(respuesta["NROVERIFICADOR"]);
      $('input[name="txtnroPedidos"]').val(respuesta["NROPEDIDO"]);
      $('input[name="txtnroRemision"]').val(respuesta["NROREMISION"]);
      $('input[name="txtRuc"]').val(respuesta["RUC"]);
      $('input[name="txtTelefono"]').val(respuesta["TELEFONO_SUC"]);
      $("#cmbCiudad").val(respuesta["COD_CIUDAD"] + '-' + respuesta["TOKEN_CIUDAD"]);
      $("#cmbCiudad").select2().trigger('change');
      $(".inputAntiguaGaleriaEstatica").val((respuesta["IMAGEN_SUC"]));
      $("#nuevoActivo").val(respuesta["PRINCIPAL"]);
      $("#cmbEstado").val(respuesta["ESTADO_SUCURSAL"]);
       if (respuesta["PRINCIPAL"]==1){
            document.getElementById("nuevoActivo").checked = true;
        $("#cmbEstado").prop('disabled', 'disabled');
        }else{
             $("#cmbEstado").removeAttr('disabled');
            document.getElementById("nuevoActivo").checked = false;
          }


      // COLOCAR LAS IMAGENES

      if (respuesta["IMAGEN_SUC"] != '[""]' && respuesta["IMAGEN_SUC"] != null && respuesta["IMAGEN_SUC"] != '') {


        // ======================================
        multiplesArchivosAntiguos(respuesta["IMAGEN_SUC"]);

      }
     

    }

  })

})

/*=============================================
Eliminar PERFIL
=============================================*/

$(document).on("click", ".eliminarSucursal", function() {

  var principal = $(this).attr("principal");

  if (principal == 1) {

    swal({
      title: "Error",
      text: "La sucursal principal no se puede eliminar",
      type: "error",
      confirmButtonText: "¡Cerrar!"
    });

    return;

  }

  var token = $(this).attr("tokenSucursal");
  var galeria = $(this).attr("galeria");
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
      datos.append("idEliminar", token);

      datos.append("galeria", galeria);

      $.ajax({

        url: "ajax/sucursales.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {

          var objData = JSON.parse(respuesta);

          if (objData.status) {

            swal("success", objData.msg, "success");
            tablaSucursal.ajax.reload(function() {
              var count = $('.tablaSucursales > * > tr').length - 1;
              bloquear(count);
              LimpiarText();

            });

          } else {
            swal("Error", objData.msg, "error");

            if (objData.msg == "No es posible Eliminar el dato, el mismo está siendo usado.") {

              // swal({
              //   title: 'No es posible Eliminar el dato, el mismo está siendo usado. ¿Deseas dar de baja?',
              //   text: "¡Si no lo está puede cancelar la acción!",
              //   type: 'warning',
              //   showCancelButton: true,
              //   confirmButtonColor: '#3085d6',
              //   cancelButtonColor: '#d33',
              //   cancelButtonText: 'Cancelar',
              //   confirmButtonText: 'Si, dar de baja!',
              //   closeOnConfirm: false,
              //   closeOnCancel: true
              // }, function(isConfirm) {

              //   if (isConfirm) {


              //   }

              // });

            }
          }

        }

      })

    }

  });

})



$(document).on("click", ".btnNuevo", function() {
  document.querySelector("#titulo").innerHTML = "Nueva Sucursal";
  document.querySelector("#btnGuardar").innerHTML = "Guardar";
  LimpiarText();
 //validarPrincipal();

})

function LimpiarText() {

  $(".quitarFotoNueva").parent().parent().remove();
  $(".quitarFotoAntigua").parent().parent().remove();
  formSucursal.reset();
  $("#idSucursal").val("");
  $("#TokenSucursal").val("");
  $(".inputNuevaGaleria").val("");
  $(".inputAntiguaGaleria").val("");
  $(".inputAntiguaGaleriaEstatica").val("");
  imagenPermitido.splice(0, imagenPermitido.length);
  archivosTemporales.splice(0, archivosTemporales.length);
  archivosTemporalesAntiguo.splice(0, archivosTemporalesAntiguo.length);
   document.getElementById("nuevoActivo").checked = false;
   $(".alert").remove();
  $("#cmbEstado").removeAttr('disabled');
   $("#cmbCiudad").select2().trigger('change');
}



/*=============================================
ARRASTRAR VARIAS IMAGENES GALERÍA
=============================================*/

var archivosTemporales = [];

$(".subirGaleria").on("dragenter", function(e) {

  e.preventDefault();
  e.stopPropagation();

  $(".subirGaleria").css({
    "background": "url(vistas/img/plantilla/pattern.jpg)"
  })

})

$(".subirGaleria").on("dragleave", function(e) {

  e.preventDefault();
  e.stopPropagation();

  $(".subirGaleria").css({
    "background": ""
  })

})

$(".subirGaleria").on("dragover", function(e) {

  e.preventDefault();
  e.stopPropagation();

})

$("#galeria").change(function() {

  var archivos = this.files;
  multiplesArchivos(archivos);

})

$(".subirGaleria").on("drop", function(e) {

  e.preventDefault();
  e.stopPropagation();

  $(".subirGaleria").css({
    "background": ""
  })

  var archivos = e.originalEvent.dataTransfer.files;

  multiplesArchivos(archivos);

})

var imagenPermitido = [];

function multiplesArchivos(archivos) {

  for (var i = 0; i < archivos.length; i++) {

    if (imagenPermitido.length < 1 && i < 1) {

      var imagen = archivos[i];

      if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {

        swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

        return;

      } else if (imagen["size"] > 2000000) {

        swal({
          title: "Error al subir la imagen",
          text: "¡La imagen no debe pesar más de 2MB!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

        return;

      } else {

        var datosImagen = new FileReader;
        datosImagen.readAsDataURL(imagen);

        $(datosImagen).on("load", function(event) {

          var rutaImagen = event.target.result;

          $(".vistaGaleria").append(`

               <li class="col-12 col-md-6 col-lg-3 card px-3 rounded-0 shadow-none">
                      
                      <img class="card-img-top" src="` + rutaImagen + `">

                      <div class="card-img-overlay p-0 pr-3">
                        
                         <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoNueva" temporal>
                           
                           <i class="fas fa-times"></i>

                         </button>

                      </div>

                  </li>

            `)


          // if(archivosTemporales.length != 0){

          //    archivosTemporales = JSON.parse($(".inputNuevaGaleria").val());
          //    imagenPermitido=archivosTemporales;
          // }

          archivosTemporales.push(rutaImagen);
          imagenPermitido.push(rutaImagen);

          $(".inputNuevaGaleria").val(JSON.stringify(archivosTemporales))

        })

      }

    } //Termina el if
    else {
      swal({
        title: "Error al subir la imagen",
        text: "¡Esta permitodo como máximo 1 imagenes",
        type: "error",
        confirmButtonText: "¡Cerrar!"
      });

      return;
    }

  } // termina el for



}



/*=============================================
QUITAR IMAGEN DE LA GALERÍA
=============================================*/

$(document).on("click", ".quitarFotoNueva", function() {

  var listaFotosNuevas = $(".quitarFotoNueva");

  var listaTemporales = JSON.parse($(".inputNuevaGaleria").val());
  // console.log(listaTemporales);

  for (var i = 0; i < listaFotosNuevas.length; i++) {

    $(listaFotosNuevas[i]).attr("temporal", listaTemporales[i]);

    var quitarImagen = $(this).attr("temporal");

    if (quitarImagen == listaTemporales[i]) {

      listaTemporales.splice(i, 1);
      imagenPermitido = listaTemporales;

      $(".inputNuevaGaleria").val(JSON.stringify(listaTemporales));

      $(this).parent().parent().remove();

    }
    imagenPermitido = listaTemporales;

  }

})

/*=============================================
QUITAR IMAGEN VIEJA GALERÍA
=============================================*/

$(document).on("click", ".quitarFotoAntigua", function() {

  var listaFotosAntiguas = $(".quitarFotoAntigua");

  var listaTemporales = $(".inputAntiguaGaleria").val().split(",");

  for (var i = 0; i < listaFotosAntiguas.length; i++) {

    quitarImagen = $(this).attr("temporal");


    if (quitarImagen == listaTemporales[i]) {

      listaTemporales.splice(i, 1);

      $(".inputAntiguaGaleria").val(listaTemporales.toString());

      $(this).parent().parent().remove();

    }
    imagenPermitido = listaTemporales;
  }
})


// ARCHIVOS ANTIGUOS
archivosTemporalesAntiguo = [];

function multiplesArchivosAntiguos(archivos) {
  var longitud = JSON.parse(archivos);
  //console.log(longitud.length);
  for (var i = 0; i < longitud.length; i++) {
    var imagen = longitud[i];


    //   $(imagen).on("load", function(event){

    var rutaImagen = imagen;

    $(".vistaGaleria").append(`

               <li class="col-12 col-md-6 col-lg-3 card px-3 rounded-0 shadow-none">
                      
                      <img class="card-img-top" src="` + rutaImagen + `">

                      <div class="card-img-overlay p-0 pr-3">
                        
                         <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoAntigua" temporal="` + rutaImagen + `">
                           
                           <i class="fas fa-times"></i>

                         </button>

                      </div>

                  </li>

            `)

    archivosTemporalesAntiguo.push(rutaImagen.split(','));
    imagenPermitido = archivosTemporalesAntiguo;
    $(".inputAntiguaGaleria").val(archivosTemporalesAntiguo);

    //  })


  } // termina el for

} // termina la clase


/*=============================================
FORMATEAR LOS IPUNT
=============================================*/

$('input[name="txtSucursal"]').change(function() {

  $(".alert").remove();

})

/*=============================================
VALIDAR EMAIL REPETIDO
=============================================*/

$('input[name="txtSucursal"]').change(function() {

  var sucursal = $(this).val();

  var datos = new FormData();
  datos.append("validarSucursal", sucursal);

  $.ajax({

    url: "ajax/sucursales.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      if (respuesta) {

       $('input[name="txtSucursal"]').val("");

        $('input[name="txtSucursal"]').after(`

        <div class="alert alert-warning">
          <strong>ERROR:</strong>
          La sucursal ya esta registrada, por favor ingrese otro diferente
        </div>

        `);

      return;

      }

    }

  })

})


function Activarcheck() {

  if ($("#nuevoActivo").is(':checked')) {
    $("#nuevoActivo").val(1);
   // variablePrin=true;
   // cantidad=1;
 //  validarPrincipal();
  } else {
    $("#nuevoActivo").val(0);
 // variablePrin=false;
 // cantidad=0;
// validarPrincipal();
  }
  //validarPrincipal();

}

function init(){
  var cant=$(".btnNuevo").attr("CantSucursal");
  bloquear(cant);
 }

 init();