/*=============================================
Tabla Perfiles
=============================================*/

// $.ajax({

//     "url":"ajax/tablaUsuarios.ajax.php",
//     success: function(respuesta){

//      console.log("respuesta", respuesta);

//     }

// })

//const formUsuario=document.getElementById("formSucursal");


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
 

const formUsuario=document.getElementById("formUsuario");

var tablaUsuario = $(".tablaUsuarios").DataTable({
   // dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
   //    buttons: [              
   //              'copyHtml5',
   //              'excelHtml5',
   //              'csvHtml5',
   //              'pdf'
   //          ],
  "ajax": "ajax/tablaUsuarios.ajax.php",
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
    if( data[11] =="P" ){
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

function bloquear(count) {
var cantidadveces=0;
  $.ajax({
    url: "ajax/cantidades.ajax.php",
    method: "POST",
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function(respuesta) {

      var cantidad = respuesta["CANT_USUARIOS"];
      if (parseInt(count)>= parseInt(cantidad)) {
      
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


$("#btnGuardar").click(function(){

// DESDE ESTA PARTE EMPESAMOS A GUARDAR LOS DATOS

  var cmbFuncionario = $("#cmbFuncionario").val();
  var txtUsuario = document.querySelector('input[name="txtUsuario"]').value;

  var txtPassword = document.querySelector('input[name="txtPassword"]').value;

  var cmbPerfil = $("#cmbPerfil").val();
   
  var cmbSucursal = $("#cmbSucursal").val();
  //var cmbCiudad=document.querySelector('input[name="cmbCiudad"]').value;
  //console.log(cmbCiudad);
  //return(false);

  var txtHorad = document.querySelector('input[name="txtHorad"]').value;
  var txtHorah = document.querySelector('input[name="txtHorah"]').value;
 // var chkActivo=document.querySelector('input[name="nuevoActivo"]').value;
 
  //return(false);
  var cmbEstado = $("#cmbEstado").val();
  // console.log(cmbEstado);
  // return false;
  // var cmbEstado=document.querySelector('input[name="cmbEstado"]').value;

  var galeria = $(".inputGaleria").val();
  
  var galeriaAntigua = $(".inputAntiguaGaleria").val();
  var galeriaAntiguaEstatica = $(".inputAntiguaGaleriaEstatica").val();

  var idUsuario = document.querySelector('input[name="idUsuario"]').value;
  var TokenUsuario = document.querySelector('input[name="TokenUsuario"]').value;
  var intento = document.querySelector('input[name="txtintento"]').value;
// console.log("archivosTemporales", archivosTemporales);
divLoading.style.display = "flex";
  var datos = new FormData();
  datos.append("cmbFuncionario", cmbFuncionario);
  datos.append("txtUsuario", txtUsuario);
  datos.append("txtPassword", txtPassword);
  datos.append("idUsuarioEditar", idUsuario);
  datos.append("tokenUsuario", TokenUsuario);
  datos.append("intento", intento);
  datos.append("cmbPerfil", cmbPerfil);
  datos.append("perfil", perfil);
  datos.append("cmbSucursal", cmbSucursal);
  datos.append("txtHorad", txtHorad);
  datos.append("txtHorah", txtHorah);
  datos.append("cmbEstado", cmbEstado);
  datos.append("imgGaleria", galeria);
  datos.append("imgGaleriaAntigua", galeriaAntigua);
  datos.append("imgGaleriaAntiguaEstatica", galeriaAntiguaEstatica);

 // datos.append("principal", chkActivo);

  $.ajax({
    url: "ajax/usuarios.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,

    success: function(respuesta) {


      var objData = JSON.parse(respuesta);
    //  console.log("objData", objData);

      if (objData.status) {

           agregarImagen(archivosTemporales,objData.token,galeria,galeriaAntigua,galeriaAntiguaEstatica);

            swal("success", objData.msg, "success");

     

        tablaUsuario.ajax.reload(function() {

          var count = $('.tablaUsuarios > * > tr').length - 1;
            $('#ModalUsuario').modal('hide');

        formUsuario.reset();

             
          // bloquear(count);
          // LimpiarText();

        });

      } else {
        swal("Error", objData.msg, "error");
      }
      divLoading.style.display = "none";
    }

  })
  


})


function agregarImagen(imagen,token,ruta,rutavieja,rutacompleta){
 

 /*=============================================
  PREGUNTAMOS SI LOS CAMPOS OBLIGATORIOS ESTÁN LLENOS
  =============================================*/
    
   
  if(imagen != "" ){
  
    /*=============================================
      PREGUNTAMOS SI VIENEN IMÁGENES PARA MULTIMEDIA O LINK DE YOUTUBE
      =============================================*/

    if(imagen.length > 0 || rutavieja.length > 0){

      let form = $("#formUsuario"),
      progres_bar= $(".progress-bar"),
      divprogres_bar=$(".bs-component"),
      datosMultimedia = new FormData(form.get(0));
       
      for(var i = 0; i < imagen.length; i++){

       // document.getElementById('galeria').dataTransfer.files[i]=imagen[i];
     // var img= document.getElementById('galeria').files[i];
     //   $("#galeria").val(imagen[i]);
        var img= document.getElementById('galeria').files[i];
        console.log("img",img);
        return;
        // var longitud = JSON.parse(ruta);
        // RutaImg =longitud[i];
        // console.log("RutaImg", RutaImg);

        progres_bar.removeClass('bg-success bg-danger').addClass('bg-info');
        progres_bar.css('width','0%');
        progres_bar.html('Preparando...');
        divprogres_bar.fadeIn();
        
          datosMultimedia.append("tabla", "usuarios");
          datosMultimedia.append("token", token);
          datosMultimedia.append("token_columna", "TOKEN_USUARIO");
          datosMultimedia.append("rutavieja", rutavieja);
           datosMultimedia.append("rutacompleta", rutacompleta);
          datosMultimedia.append("foto_columna", "FOTO_USUARIO");
          datosMultimedia.append("file", img);
          datosMultimedia.append("carpeta", "usuarios");
          datosMultimedia.append("ruta", ruta);

          $.ajax({
        
            type: "POST",
            url:"ajax/multimedia.ajax.php",
            dataType:"json",
            contentType: false,
            processData: false,
            cache: false,
            data: datosMultimedia,

            xhr: function(){
          
          var xhr = $.ajaxSettings.xhr();

          xhr.onprogress = function(evt){ 

            var porcentaje = Math.floor((evt.loaded/evt.total*100));

           progres_bar.css('width',porcentaje+'%');
            progres_bar.html(porcentaje+'%');

          };

          return xhr;
              
        },
            beforeSend: () =>{

              $("button",form).attr('disabled',true);

             }         

          }).done(res=>{
            if(res.status===200){
              progres_bar.removeClass('bg-info').addClass('bg-success');
              progres_bar.html("!Completado¡");
              form.trigger('reset');

              // setTimeout(()=>{
              //   divprogres_bar.fadeOut();
              //   progres_bar.removeClass('bg-success bg-danger').addClass('bg-info');
              //   progres_bar.css('width','0%');
              // },1500);

            }else{
              alert(res.msg);
              progres_bar.css('width','100%');
              progres_bar.html(res.msg);
            }
          }).fail(err=>{
            progres_bar.removeClass('bg-success bg-info').addClass('bg-danger');
            progres_bar.html('!Hubo un error¡');
          }).always(()=>{
            $('button',form).attr('disabled',false);
          });

          }

         

        }

        

  }


}

/*=============================================
Editar Carrera
=============================================*/

$(document).on("click", ".editarUsuario", function() {

  document.querySelector("#titulo").innerHTML = "Editar usuario";
  document.querySelector("#btnGuardar").innerHTML = "Actualizar";
  LimpiarText();
  
  var token_usuario = $(this).attr("tokenUsuario");
  
  var datos = new FormData();

  datos.append("token_usuario", token_usuario);

  $.ajax({

    url: "ajax/usuarios.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {
    
    
      $('input[name="idUsuario"]').val(respuesta["COD_USUARIO"]);
      $('input[name="TokenUsuario"]').val(respuesta["TOKEN_USUARIO"]);

      $('input[name="txtUsuario"]').val(respuesta["USUARIO"]);

      $("#cmbFuncionario").val(respuesta["COD_FUNCIONARIO"]+'/'+respuesta["TOKEN_FUNCIONARIO"])
     $("#cmbFuncionario").select2().trigger('change');
    
      //$('label[name="editarPerfil"]').text(respuesta["NOMBRE_PERFIL"]);
      $('input[name="editarPerfil"]').val(respuesta["NOMBRE_PERFIL"]);
      $('input[name="editarPerfil"]').prop('disabled', 'disabled');

      $("#cmbPerfil").val(respuesta["COD_PERFIL"] + '/' + respuesta["TOKEN_PERFIL"]);
      $("#cmbPerfil").select2().trigger('change');

      $("#cmbSucursal").val(respuesta["COD_SUCURSAL"] + '/' + respuesta["TOKEN_SUCURSAL"]);
      $("#cmbSucursal").select2().trigger('change');
  
      $('input[name="txtHorad"]').val(respuesta["HORA_DESDE"]);
      $('input[name="txtHorah"]').val(respuesta["HORA_HASTA"]);
     
      $(".inputAntiguaGaleriaEstatica").val((respuesta["FOTO_USUARIO"]));
      $("#cmbEstado").val(respuesta["ESTADO_USUARIO"]);

      $('input[name="txtPassword"]').val("Admin123");
      $('input[name="repetirPassword"]').val("Admin123");
       
      // COLOCAR LAS IMAGENES

      if (respuesta["FOTO_USUARIO"] != '[""]' && respuesta["FOTO_USUARIO"] != null && respuesta["FOTO_USUARIO"] != '') {
        // ======================================
        multiplesArchivosAntiguos(respuesta["FOTO_USUARIO"]);
       
      }

      var intento = document.getElementById("txtintento");
      var labelintento = document.getElementById("lblintento");
      var clave = document.getElementById("divclave");
      var clave1 = document.getElementById("divclave2");
     
      intento.style.display = "block";
      labelintento.style.display = "block";
      clave.style.display = "none";
      clave1.style.display = "none";
           
      $('input[name="txtintento"]').val(respuesta["NRO_INTENTO"]);
      //  validarPrincipal();

    }

  })

})

/*=============================================
Eliminar PERFIL
=============================================*/

$(document).on("click", ".eliminarUsuario", function() {

  var principal = $(this).attr("principal");
 
  if (principal == 1) {

    swal({
      title: "Error",
      text: "El usuario con perfil administrador no se puede eliminar",
      type: "error",
      confirmButtonText: "¡Cerrar!"
    });

    return;

  }

  var token = $(this).attr("tokenUsuario");
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

        url: "ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {



          var objData = JSON.parse(respuesta);

          if (objData.status) {

            swal("success", objData.msg, "success");
            tablaUsuario.ajax.reload(function() {
              var count = $('.tablaSucursales > * > tr').length - 1;
              bloquear(count);
              LimpiarText();

            });

          } else {
            swal("Error", objData.msg, "error");

            if (objData.msg == "No es posible Eliminar el dato, el mismo está siendo usado.") {

              swal({
                title: 'No es posible Eliminar el dato, el mismo está siendo usado. ¿Deseas dar de baja?',
                text: "¡Si no lo está puede cancelar la acción!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, dar de baja!',
                closeOnConfirm: false,
                closeOnCancel: true
              }, function(isConfirm) {

                if (isConfirm) {
                    //descactivar usuarios

                }

              });

            }
          }

        }

      })

    }

  });

})



$(document).on("click", ".btnNuevo", function() {
  document.querySelector("#titulo").innerHTML = "Nuevo usuario";
  document.querySelector("#btnGuardar").innerHTML = "Guardar";
  LimpiarText();

   var intento = document.getElementById("txtintento");
      var labelintento = document.getElementById("lblintento");
      var clave = document.getElementById("divclave");
      var clave1 = document.getElementById("divclave2");
      intento.style.display = "none";
      labelintento.style.display = "none";
      clave.style.display = "block";
      clave1.style.display = "block";

// validarPrincipal();

})

function LimpiarText() {

  $(".quitarFotoNueva").parent().parent().remove();
  $(".quitarFotoAntigua").parent().parent().remove();
  formUsuario.reset();
  $("#idUsuario").val("");
  $("#TokenUsuario").val("");
  $(".inputNuevaGaleria").val("");
  $(".inputGaleria").val("");
  $(".inputAntiguaGaleria").val("");
  $(".inputAntiguaGaleriaEstatica").val("");
  imagenPermitidoNuevo.splice(0, imagenPermitidoNuevo.length);
  imagenPermitidoAntiguo.splice(0, imagenPermitidoAntiguo.length);
  archivosTemporales.splice(0, archivosTemporales.length);
  archivosTemporalesAntiguo.splice(0, archivosTemporalesAntiguo.length);
   // document.getElementById("nuevoActivo").checked = false;
   $(".alert").remove();
  $("#cmbFuncionario").select2().trigger('change');
  $("#cmbPerfil").select2().trigger('change');
  $("#cmbSucursal").select2().trigger('change');
 
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

 //var archivos = e.originalEvent.dataTransfer.files;
 document.getElementById('galeria').files=e.originalEvent.dataTransfer.files;
 var archivos = document.getElementById('galeria').files;
 //document.getElementById('galeria').files[i]=
   multiplesArchivos(archivos);

})

var imagenPermitidoNuevo = [];
var imagenPermitidoAntiguo = [];
var ubicacion=[];

function multiplesArchivos(archivos) {

  for (var i = 0; i < archivos.length; i++) {


   if ((imagenPermitidoNuevo.length+i+imagenPermitidoAntiguo.length) < 5) {

      var imagen = archivos[i];

      if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {

        swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

        return;

      }  else if (imagen["size"] > 15000000) {

        swal({
          title: "Error al subir la imagen",
          text: "¡La imagen no debe pesar más de 15MB!",
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

               <li class="col-12 col-md-6 col-lg-3 card px-0 rounded-10 shadow-none img-fluid">
                      
                      <img class="card-img-top" src="` + rutaImagen + `">

                        <div class="card-img-overlay p-0 pr-0">
                          
                           <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoNueva" temporal>
                             
                             <i class="fas fa-times"></i>

                           </button>

                        </div>
                  
                  <div class="bs-component" Style="display:none">
                    <div class="progress">
                         <div class="progress-bar mb-2" role="progressbar" style="width:0%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>

                  </li>

            `)


          if(archivosTemporales.length != 0){

             archivosTemporales = JSON.parse($(".inputNuevaGaleria").val());
             ubicacion= JSON.parse($(".inputGaleria").val());
            imagenPermitidoNuevo=archivosTemporales;
          }

          archivosTemporales.push(rutaImagen);
          ubicacion.push(imagen["name"] );

        imagenPermitidoNuevo=archivosTemporales;

         
          $(".inputNuevaGaleria").val(JSON.stringify(archivosTemporales))
           $(".inputGaleria").val(JSON.stringify(ubicacion))
          

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
   var ubicacionTemporales = JSON.parse($(".inputGaleria").val());
  // console.log(listaTemporales);

  for (var i = 0; i < listaFotosNuevas.length; i++) {

    $(listaFotosNuevas[i]).attr("temporal", listaTemporales[i]);

    var quitarImagen = $(this).attr("temporal");

    if (quitarImagen == listaTemporales[i]) {

      listaTemporales.splice(i, 1);
       ubicacionTemporales.splice(i, 1);
    //  imagenPermitidoNuevo = listaTemporales;

      $(".inputNuevaGaleria").val(JSON.stringify(listaTemporales));
      $(".inputGaleria").val(JSON.stringify(ubicacionTemporales));
       imagenPermitidoNuevo = listaTemporales;
     
      $(this).parent().parent().remove();

    }
   

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
      imagenPermitidoAntiguo = listaTemporales;
  
      $(this).parent().parent().remove();

    }
   //imagenPermitidoAntiguo = listaTemporales;
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

               <li class="col-12 col-md-6 col-lg-3 card px-0 rounded-10 shadow-none img-fluid">
                      
                      <img class="card-img-top" src="` + rutaImagen + `">

                      <div class="card-img-overlay p-0 pr-0">
                        
                         <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoAntigua" temporal="` + rutaImagen + `">
                           
                           <i class="fas fa-times"></i>

                         </button>

                      </div>

                  </li>

            `)

    archivosTemporalesAntiguo.push(rutaImagen.split(','));
    imagenPermitidoAntiguo = archivosTemporalesAntiguo;
   
    $(".inputAntiguaGaleria").val(archivosTemporalesAntiguo);

    //  })


  } // termina el for

} // termina la clase


/*=============================================
FORMATEAR LOS IPUNT
=============================================*/

// $('input[name="txtUsuario"]').change(function() {

//   $(".alert").remove();

// })

/*=============================================
VALIDAR EMAIL REPETIDO
=============================================*/

$('input[name="txtUsuario"]').change(function() {
$(".alert").remove();
  var Usuario = $(this).val();
    var datos = new FormData();
  datos.append("validarUsuario", Usuario);

  $.ajax({

    url: "ajax/usuarios.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {
      
      if (respuesta) {

       $('input[name="txtUsuario"]').val("");

        $('input[name="txtUsuario"]').after(`

        <div class="alert alert-warning">
          <strong>ERROR:</strong>
          El usuario ya esta registrada, por favor ingrese otro diferente
        </div>

        `);

      return;

      }

    }

  })

})


 function OcultarMostrarP(){
      var txtPassword = document.getElementById("txtPassword");
      var passwordrepetir = document.getElementById("repetirPassword");
      var slash = document.getElementById("slash");
      var eye = document.getElementById("eye");
      
      if(txtPassword.type === 'password' || passwordrepetir.type === 'password') {
      txtPassword.type = "text";
      passwordrepetir.type = "text";
      slash.style.display = "none";
      eye.style.display = "block";

      }
      else{
        txtPassword.type = "password";
        passwordrepetir.type = "password";
        slash.style.display = "block";
        eye.style.display = "none";
      }

    }
 

// $('#repetirPassword').change(function() {

//   $(".alert").remove();

// })


//VERIFICAMOS QUE EL PASSWORD SEAN IGUALES

$('#repetirPassword').change(function(){
 
  $(".alert").remove();
  var usuario=$(this).val();
  // console.log("usuario", usuario);
  
  if (usuario.length > 7) {
    // Ontenemos los valores de los campos de contraseñas 
    pass1 = document.getElementById('txtPassword');
    pass2 = document.getElementById('repetirPassword');
    // var pass1=$(this).val();
    // var pass2=$("#nuevoPassword").val();
  // console.log(pass1.value,pass2.value);
    // Verificamos si las constraseñas no coinciden 

    if (pass1.value != pass2.value) {
 
        // Si las constraseñas no coinciden mostramos un mensaje 
       // document.getElementById("error").classList.add("mostrar");
        $("#repetirPassword").val("");
          
        $("#txtPassword").val("");

       $("#repetirPassword").after(`

        <div class="alert alert-warning" id="pw">
          <strong>ERROR:</strong>
          Las Contraseñas no coinciden, vuelve a intentar!!!
        </div>

        `);

      return;
   
   // document.getElementById('pw').innerHTML='<b>Las Contraseñas no coinciden, vuelve a intentar!!!</b>'; 
    
  
    } 
}else{

  $("#repetirPassword").val("");
  $("#txtPassword").val("");
    $("#repetirPassword").after(`

        <div class="alert alert-warning" id="pw">
          <strong>ERROR:</strong>
          Mínimo 8 caracteres que incluyen una letra mayúscula y minúscula, un número
        </div>

        `);
  //document.getElementById('pw').innerHTML='<b>Mínimo 8 caracteres que incluyen una letra mayúscula y minúscula, un número</b>'; 
  //setTimeout(function() {document.getElementById('pw').innerHTML='';},5000); 
  
}
 
})

$('#txtHorah').change(function() {

  $(".alert").remove();

})

/*CALCULAR QUE LA HORA NO SEA MAYOR Y MENOR AHORA HASTA*/

$("#txtHorah").change(function()
{

var horahasta = $(this).val();
var horadesde = $("#txtHorad").val()
if (horahasta.length>4){


  if(horadesde>=horahasta){

      $("#txtHorah").val("");
    $("#txtHorad").val("");

  $("#txtHorah").after(`

        <div class="alert alert-warning" id="hd">
          <strong>ERROR:</strong>
          El horario hasta no puede ser menor que el horario desde
        </div>

        `); 
   // document.getElementById('hd').innerHTML='<b>El horario hasta no puede ser menor que el horario desde</b>'; 
  //  setTimeout(function() {document.getElementById('hd').innerHTML='';},5000); 
     
  

  }

}

})

$('.bs-component [data-toggle="popover"]').popover();
$('.bs-component [data-toggle="tooltip"]').tooltip();

var perfil
$('#cmbPerfil').change(function() {

/* Para obtener el valor */
// var cod = document.getElementById("cmbPerfil").value;
// alert(cod);

/* Para obtener el texto */
var combo = document.getElementById("cmbPerfil");
var selected = combo.options[combo.selectedIndex].text;
perfil= selected.split("-");
perfil=perfil[1];
})

 function init(){
  var cant=$(".btnNuevo").attr("CantUsuario");
  bloquear(cant);
 }

 init();





