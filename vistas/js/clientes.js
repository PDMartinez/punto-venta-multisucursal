//const formCliente=document.getElementById("formProveedor");

/*==========================================================
      CARGAR LOS DATOS EN LA TABLA Y DARLE FORMATO
============================================================*/

var tablaClientes = $(".tablaClientes").DataTable({

  "ajax": "ajax/tablaClientes.ajax.php",
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

})

// var tablaDescuentos = $(".tablaDescuentos").DataTable({

//   "ajax": "ajax/tablaDescuentos.ajax.php",
//   "deferRender": true,
//   "retrieve": true,
//   "processing": true,
//   "language": {

//     "sProcessing": "Procesando...",
//     "sLengthMenu": "Mostrar _MENU_ registros",
//     "sZeroRecords": "No se encontraron resultados",
//     "sEmptyTable": "Ningún dato disponible en esta tabla",
//     "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
//     "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
//     "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
//     "sInfoPostFix": "",
//     "sSearch": "Buscar:",
//     "sUrl": "",
//     "sInfoThousands": ",",
//     "sLoadingRecords": "Cargando...",
//     "oPaginate": {
//       "sFirst": "Primero",
//       "sLast": "Último",
//       "sNext": "Siguiente",
//       "sPrevious": "Anterior"
//     },
//     "oAria": {
//       "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
//       "sSortDescending": ": Activar para ordenar la columna de manera descendente"
//     }

//   },

// })

//variables globales
var mapa;
var marcador;

localStorage.setItem('tipoBoton', 'editar'); //para verificar si se oprimio el boton nuevo o editar

//Geolocalizacion
var watchId;
var geoloc;

function iniciarMapa() {

  const coordenadas = {
    lat: -25.391039,
    lng: -57.074432
  };
  //const coordenadas = {lat: -25.242887, lng: -56.888118};

  generarMapa(coordenadas);
}

function generarMapa(coordenadas) {

  if (localStorage.getItem('tipoBoton') == "nuevo") {
    console.log("nuevo");

    mapa = new google.maps.Map(document.getElementById('mapa'), {
      zoom: 15,
      center: new google.maps.LatLng(coordenadas.lat, coordenadas.lng)
    });

    //VERIFICAMOS EL BOTON QUE SE OPRIMIO Y FILTRAMOS DE ACUERDO A ESO

    marcador = new google.maps.Marker({

      map: mapa,
      draggable: true,
      position: new google.maps.LatLng(coordenadas.lat, coordenadas.lng),
      title: "Estás aquí"

    })

    getPosition();

    marcador.addListener('dragend', function(event) {

      $("#txtLatitud").val(this.getPosition().lat());
      $("#txtLongitud").val(this.getPosition().lng());
      navigator.geolocation.clearWatch(watchId);

    })

  }

  if (localStorage.getItem('tipoBoton') == "editar") {
    //console.log("editar");

    navigator.geolocation.clearWatch(watchId);

    mapa = new google.maps.Map(document.getElementById('mapa'), {
      zoom: 15,
      center: new google.maps.LatLng(coordenadas.lat, coordenadas.lng)
    });

    marcador = new google.maps.Marker({

      map: mapa,
      draggable: true,
      position: new google.maps.LatLng(coordenadas.lat, coordenadas.lng),
      title: coordenadas.cliente

    })

    // getPosition();

    marcador.addListener('dragend', function(event) {

      $("#txtLatitud").val(this.getPosition().lat());
      $("#txtLongitud").val(this.getPosition().lng());

    })

  }


}

function getPosition() {

  navigator.geolocation.clearWatch(watchId);

  if (navigator.geolocation) {

    //ejecuta cada 6000 milisegundos (60 segundos, 1 minuto)
    var options = {
      enableHighAccuracy: false,
      timeout: 1000,
      maximumAge: 0
    };

    geoloc = navigator.geolocation;
    watchId = geoloc.watchPosition(showLocationOnMap, errorHandler, options);

    //navigator.geolocation.clearWatch(watchId);

  } else {

    alert("Los sentimos, el explorador no soporta geolocalización");

  }

}

function showLocationOnMap(position) {

  var latitud = position.coords.latitude;
  var longitud = position.coords.longitude;
  console.log("latitud: " + latitud + " Longitud: " + longitud);

  const myLatLng = {
    lat: latitud,
    lng: longitud
  };
  marcador.setPosition(myLatLng);
  mapa.setCenter(myLatLng);

  document.getElementById("txtLatitud").value = latitud;
  document.getElementById("txtLongitud").value = longitud;

}

function errorHandler(err) {

  if (err.code == 1) {

    alert("Error: Acceso denegado!");

  } else if (err.code == 2) {

    alert("Error: Position no existe o no se encuentra!");

  }

}

/*==========================================================
      Guardar Clientes
============================================================*/

// ES PARA GUARDAR LOS DATOS EN LA CATEGORIA//

// ES PARA GUARDAR LOS DATOS EN LA BASE DE DATOS//
function GuardarformularioCiudad() {



  var idCiudad = "";
  var tokenCiudad = "";

  let txtCiudad = "";

  txtCiudad = prompt("¡Ingese la ciudad!", "");


  if (txtCiudad != null) {

    while (txtCiudad == "") {
      txtCiudad = prompt("¡Ingese la ciudad!", "");
    };
    if (txtCiudad != null) {

    } else {
      return false;
    }

  } else {

    return false;
  }

  if (txtCiudad == '') {
    swal("Atennción", "El campo nombre es obligatorio.", "error");
    return false;
  }
  divLoading.style.display = "flex";
  var datos = new FormData();
  datos.append("txtCiudad", txtCiudad);
  datos.append("idCiudadEditar", idCiudad);
  datos.append("tokenCiudad", tokenCiudad);
  $.ajax({
    url: "ajax/ciudades.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,

    success: function(respuesta) {

      var objData = JSON.parse(respuesta);

      if (objData.status) {

        swal("success", objData.msg, "success");
        var datos = new FormData();

        datos.append("descripcion", txtCiudad);

        $.ajax({

          url: "ajax/ciudades.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function(respuesta) {

            // console.log("respuesta", respuesta);

            var combo = document.getElementById("cmbCiudad");
            var option = document.createElement('option');

            // añadir el elemento option y sus valores
            combo.options.add(option, 1);
            combo.options[1].value = respuesta["COD_CIUDAD"] + "/" + respuesta["TOKEN_CIUDAD"];
            combo.options[1].innerText = respuesta["DESCRIPCION_CIUDAD"];

            $("#cmbCiudad").val(respuesta["COD_CIUDAD"] + "/" + respuesta["TOKEN_CIUDAD"]);



          }

        })

      } else {
        swal("Error", objData.msg, "error");
      }

      divLoading.style.display = "none";
    }

  })
  return (false);

}

$(document).on("click", "#btnAgregarCiudad", function() {
  GuardarformularioCiudad();

})

var mensajeFinal = "ninguno";

function GuardarFormulario() {

  // OBTENEMOS LOS DATOS

  var txtCliente = $("#txtCliente").val();

  var txtRuc = $("#txtRUC").val();

  var cmbCiudad = $("#cmbCiudad").val();

  var txtDireccion = $("#txtDireccion").val();

  var pClavesCelular = $("#pClavesCelular").val();

  var txtEmail = $("#txtEmail").val();

  //var celular = dividirCadena(pClavesCelular, coma);

  var txtFechaNac = $("#txtFechaNac").val();

  var cmbTipoCliente = $("#cmbTipoCliente").val();

  var cmbCategoria = $("#cmbCategoria").val();

  var txtGarante = $("#txtGarante").val();

  var txtCedulaGarante = $("#txtCedulaGarante").val();

  var pClavesRefLaboral = $("#pClavesRefLaboral").val();

  var pClavesRefPersonal = $("#pClavesRefPersonal").val();

  var cmbEstado = $("#cmbEstado").val();

  var galeria = $(".inputGaleria").val();
  var galeriaAntigua = $(".inputAntiguaGaleria").val();
  var galeriaAntiguaEstatica = $(".inputAntiguaGaleriaEstatica").val();

  var cedulaFrontal = $(".inputCedulaFrontal").val();
  var cedulaFrontalAntigua = $(".inputAntiguaCedulaFrontal").val();
  var cedulaFrontalAntiguaEstatica = $(".inputAntiguaCedulaFrontalEstatica").val();

  var cedulaTrasera = $(".inputCedulaTrasera").val();
  var cedulaTraseraAntigua = $(".inputAntiguaCedulaTrasera").val();
  var cedulaTraseraAntiguaEstatica = $(".inputAntiguaCedulaTraseraEstatica").val();

  var txtLatitud = $("#txtLatitud").val();
  var txtLongitud = $("#txtLongitud").val();

  var txtTokenCliente = $("#tokenCliente").val();

  //mostrarLoading();

  // alert("Empresa:"+txtCliente + " RUC:"+txtRuc + " Ciudad:"+cmbCiudad + " Direccion:"+txtDireccion + " Celular:"+pClavesCelular + " FechaNac:"+txtFechaNac + " TipoCliente:"+cmbTipoCliente + " Categoria:"+cmbCategoria + " Garante:"+txtGarante + " Ced Garante:"+txtCedulaGarante + " Ref Lab:"+pClavesRefLaboral + " Ref Per:"+pClavesRefPersonal + " Estado:"+cmbEstado + " Lat:"+txtLatitud + " Long:"+txtLongitud + " Token:"+txtTokenCliente + " Galeria: " + galeria);
  // return (false);

    if (txtCliente == "") {
    swal({
      title: "Cargue el nombre del cliente",
      type: "error",
      confirmButtonText: "¡Cerrar!"

    })
    return false;
  }



  if (txtRuc == "") {
    swal({
      title: "Cargue el ruc o cédula del cliente",
      type: "error",
      confirmButtonText: "¡Cerrar!"

    })
    return false;
  }


  if (cmbCiudad == "") {
    swal({
      title: "Seleccione la ciudad del cliente",
      type: "error",
      confirmButtonText: "¡Cerrar!"

    })
    return false;
  }


  if (cmbTipoCliente == "") {
    swal({
      title: "Seleccione un canal para el cliente",
      type: "error",
      confirmButtonText: "¡Cerrar!"

    })
    return false;
  }
 divLoading.style.display = "flex";

  var datos = new FormData();

  datos.append("txtCliente", txtCliente);

  datos.append("txtRuc", txtRuc);

  datos.append("cmbCiudad", cmbCiudad);

  datos.append("txtDireccion", txtDireccion);

  datos.append("pClavesCelular", pClavesCelular);

  datos.append("txtEmail", txtEmail);

  datos.append("txtFechaNac", txtFechaNac);

  datos.append("cmbTipoCliente", cmbTipoCliente);

  datos.append("cmbCategoria", cmbCategoria);

  datos.append("txtGarante", txtGarante);

  datos.append("txtCedulaGarante", txtCedulaGarante);

  datos.append("pClavesRefLaboral", pClavesRefLaboral);

  datos.append("pClavesRefPersonal", pClavesRefPersonal);

  datos.append("cmbEstado", cmbEstado);

  datos.append("imgGaleria", galeria);

  datos.append("imgGaleriaAntigua", galeriaAntigua);

  datos.append("imgGaleriaAntiguaEstatica", galeriaAntiguaEstatica);

  datos.append("cedulaFrontal", cedulaFrontal);

  datos.append("cedulaFrontalAntigua", cedulaFrontalAntigua);

  datos.append("cedulaFrontalAntiguaEstatica", cedulaFrontalAntiguaEstatica);

  datos.append("cedulaTrasera", cedulaTrasera);

  datos.append("cedulaTraseraAntigua", cedulaTraseraAntigua);

  datos.append("cedulaTraseraAntiguaEstatica", cedulaTraseraAntiguaEstatica);

  datos.append("txtLatitud", txtLatitud);

  datos.append("txtLongitud", txtLongitud);

  datos.append("tokenCliente", txtTokenCliente);


  $.ajax({

    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,

    success: function(respuesta) {

      var objData = JSON.parse(respuesta);

      // verificarLoading();

         // alert(mensajeFinal + " /imagen: " + archivosTemporales.length + " Frontal: " + archivosTemporalesFrontal.length + " Trasera: " + archivosTemporalesTrasera.length);
      // return;

      if (objData.status) {

        // console.log("Imagen: "+archivosTemporales + "Frontal: " + archivosTemporalesFrontal + "Trasera: "+archivosTemporalesTrasera);
        // console.log(objData.token);
        // return;

        agregarImagen(archivosTemporales, objData.token, galeria, galeriaAntigua, galeriaAntiguaEstatica);

        agregarCedulaFrontal(archivosTemporalesFrontal, objData.token, cedulaFrontal, cedulaFrontalAntigua, cedulaFrontalAntiguaEstatica);

        agregarCedulaTrasera(archivosTemporalesTrasera, objData.token, cedulaTrasera, cedulaTraseraAntigua, cedulaTraseraAntiguaEstatica);


        if (mensajeFinal === "ninguno") {

         
          // cerrarLoading();
          $('#ModalClientes').modal('hide');

          swal("success", objData.msg, "success");

          tablaClientes.ajax.reload(function() {

            LimpiarText();

          });

        }


      } else {
  

        // cerrarLoading();

        swal("Error", objData.msg, "error");

      }

      divLoading.style.display = "none";

    }

  })

  return (false);

}



/*=============================================
      Editar Cliente
=============================================*/

$(document).on("click", ".editarCliente", function() {

  LimpiarText();

  localStorage.setItem('tipoBoton', 'editar')

  document.querySelector("#titulo").innerHTML = "Editar cliente";
  document.querySelector("#btnGuardar").innerHTML = "Actualizar";

  var token_cliente = $(this).attr("tokenCliente");

  //alert(token_cliente);
  divLoading.style.display = "flex";
  var datos = new FormData();

  datos.append("token_cliente", token_cliente);

  $.ajax({

    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      $("#txtCanal").val(respuesta["DESCRIPCION_CANAL"]);

      $("#cmbEstado").val(respuesta["ESTADO"]);
      $("#cmbEstado").select2().trigger('change'); //aplicar la seleccion


      $("#idCliente").val(respuesta["COD_CLIENTE"]);

      $("#tokenCliente").val(respuesta["TOKEN_CLIENTE"]);

      $("#txtCliente").val(respuesta["CLIENTE"]);

      $("#txtRUC").val(respuesta["RUC"]);

      $("#cmbCiudad").val(respuesta["COD_CIUDAD"] + "/" + respuesta["TOKEN_CIUDAD"]);
      $("#cmbCiudad").select2().trigger('change'); //aplicar la seleccion

      $("#txtDireccion").val(respuesta["DIRECCION"]);

      // $("#pClavesCelular").tagsinput('add', respuesta["CELULAR"]);
      $("#pClavesCelular").val(respuesta["CELULAR"]);

      $("#txtEmail").val(respuesta["EMAIL"]);

      $("#txtFechaNac").val(respuesta["FECHA_NACIMIENTO"]);

      $("#cmbTipoCliente").val(respuesta["COD_CANAL"] + "/" + respuesta["TOKEN_CANAL"]);
      $("#cmbTipoCliente").select2().trigger('change'); //aplicar la seleccion

      $("#cmbCategoria").val(respuesta["CATEGORIA_CLIENTE"]);
      $("#cmbCategoria").select2().trigger('change'); //aplicar la seleccion

      $("#txtGarante").val(respuesta["GARANTE"]);

      $("#txtCedulaGarante").val(respuesta["CED_GARANTE"]);

      // $("#pClavesRefLaboral").tagsinput('add', respuesta["REFERENCIA_LABORAL"]);
      $("#pClavesRefLaboral").val(respuesta["REFERENCIA_LABORAL"]);

      // $("#pClavesRefPersonal").tagsinput('add', respuesta["REFERENCIA_PERSONAL"]);
      $("#pClavesRefPersonal").val(respuesta["REFERENCIA_PERSONAL"]);

      $("#cmbEstado").val(respuesta["ESTADO_CLIENTE"]);
      $("#cmbEstado").select2().trigger('change'); //aplicar la seleccion

      $(".inputAntiguaGaleriaEstatica").val((respuesta["IMAGEN_CLIENTE"]));

      // COLOCAR LAS IMAGENES

      if (respuesta["IMAGEN_CLIENTE"] != '[""]' && respuesta["IMAGEN_CLIENTE"] != null && respuesta["IMAGEN_CLIENTE"] != '') {

        multiplesArchivosAntiguos(respuesta["IMAGEN_CLIENTE"]);

      }

      $(".inputAntiguaCedulaFrontalEstatica").val((respuesta["IMAGEN_CEDULA"]));

      // COLOCAR LAS IMAGENES

      if (respuesta["IMAGEN_CEDULA"] != '[""]' && respuesta["IMAGEN_CEDULA"] != null && respuesta["IMAGEN_CEDULA"] != '') {

        multiplesArchivosAntiguosFrontal(respuesta["IMAGEN_CEDULA"]);

      }

      $(".inputAntiguaCedulaTraseraEstatica").val((respuesta["IMAGEN_CEDULAATRAS"]));

      // COLOCAR LAS IMAGENES

      if (respuesta["IMAGEN_CEDULAATRAS"] != '[""]' && respuesta["IMAGEN_CEDULAATRAS"] != null && respuesta["IMAGEN_CEDULAATRAS"] != '') {

        multiplesArchivosAntiguosTrasera(respuesta["IMAGEN_CEDULAATRAS"]);

      }

      $("#txtLatitud").val(respuesta["LATITUD"]);

      $("#txtLongitud").val(respuesta["LONGITUD"]);

      const coordenada = {
        lat: respuesta["LATITUD"],
        lng: respuesta["LONGITUD"],
        cliente: respuesta["CLIENTE"]
      };

      generarMapa(coordenada);


      archivosTemporales = [];
      archivosTemporalesFrontal = [];
      archivosTemporalesTrasera = [];

      divLoading.style.display = "none";

    }

  })

})

/*=============================================
Eliminar Clientes
=============================================*/

$(document).on("click", ".eliminarCliente", function() {

  var idCliente = $(this).attr("idCliente");
  var galeria = $(this).attr("galeria");
  var cedulaFrontal = $(this).attr("cedulaFrontal");
  var cedulaTrasera = $(this).attr("cedulaTrasera");

  // alert(galeria + "  " + cedulaFrontal  + " " + cedulaTrasera);
  // return;

  swal({
    title: '¿Está seguro de eliminar?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, eliminar Cliente!',
    closeOnConfirm: false,
    closeOnCancel: true
  }, function(isConfirm) {

    if (isConfirm) {

      var datos = new FormData();

      datos.append("idEliminar", idCliente);
      datos.append("galeria", galeria);
      datos.append("cedulaFrontal", cedulaFrontal);
      datos.append("cedulaTrasera", cedulaTrasera);

      $.ajax({

        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {

          var objData = JSON.parse(respuesta);

          if (objData.status) {

            swal("success", objData.msg, "success");

            tablaClientes.ajax.reload(function() {

              // var count = $('.tablaClientes > * > tr').length - 1;

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
                  //descactivar cliente

                  var datos = new FormData();
                  datos.append("inactivarId", idCliente);

                  $.ajax({

                    url: "ajax/clientes.ajax.php",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function(respuesta) {

                      var objData = JSON.parse(respuesta);

                      if (objData.status) {

                        var objData = JSON.parse(respuesta);

                        if (objData.status) {

                          swal("success", objData.msg, "success");

                          tablaClientes.ajax.reload(function() {

                            // var count = $('.tablaClientes > * > tr').length - 1;

                            LimpiarText();

                          });

                        }


                      }

                    }

                  });

                }

              });

            }
          }


        }

      })

    }

  })

})


$(document).on("click", ".btnNuevo", function() {

  LimpiarText();

  document.querySelector("#titulo").innerHTML = "Nuevo cliente";
  document.querySelector("#btnGuardar").innerHTML = "Guardar";

  localStorage.setItem('tipoBoton', 'nuevo')

  iniciarMapa();

})

function LimpiarText() {

  formClientes.reset();

  $("#idCliente").val("");

  $("#tokenCliente").val("");

  $("#txtCliente").val("");

  $("#txtRUC").val("");

  $("#validarRuc").remove();

  $("#cmbCiudad").select2().trigger('change');

  $("#txtDireccion").val("");

  // $("#pClavesCelular").tagsinput('removeAll');
  $("#pClavesCelular").val("");

  $('#txtEmail').val("");

  $("#validarEmail").remove();

  $("#txtFechaNac").val("");

  $("#cmbTipoCliente").select2().trigger('change');

  $("#txtGarante").val("");

  $("#txtCedulaGarante").val("");

  // $("#pClavesRefLaboral").tagsinput('removeAll');
  $("#pClavesRefLaboral").val("")

  // $("#pClavesRefPersonal").tagsinput('removeAll');
  $("#pClavesRefPersonal").val("");

  $("#cmbCategoria").select2().trigger('change');

  $("#cmbEstado").select2().trigger('change');

  $("#txtLatitud").val("");

  $("#txtLongitud").val("");

  $(".quitarFotoNueva").parent().parent().remove();
  $(".quitarFotoAntigua").parent().parent().remove();

  $(".quitarFotoFrontalNueva").parent().parent().remove();
  $(".quitarFotoAntiguaFrontal").parent().parent().remove();

  $(".quitarFotoTraseraNueva").parent().parent().remove();
  $(".quitarFotoAntiguaTrasera").parent().parent().remove();

  $(".inputNuevaGaleria").val("");
  $(".inputGaleria").val("");
  $(".inputAntiguaGaleria").val("");
  $(".inputAntiguaGaleriaEstatica").val("");

  $(".inputNuevaCedulaFrontal").val("");
  $(".inputCedulaFrontal").val("");
  $(".inputAntiguaCedulaFrontal").val("");
  $(".inputAntiguaCedulaFrontalEstatica").val("");

  $(".inputNuevaCedulaTrasera").val("");
  $(".inputCedulaTrasera").val("");
  $(".inputAntiguaCedulaTrasera").val("");
  $(".inputAntiguaCedulaTraseraEstatica").val("");

  archivosTemporales.splice(0, archivosTemporales.length);
  archivosTemporalesAntiguo.splice(0, archivosTemporalesAntiguo.length);

  archivosTemporalesFrontal = [];
  archivosTemporalesAntiguoFrontal = [];

  archivosTemporalesTrasera = [];
  archivosTemporalesAntiguoTrasera = [];

  imagenPermitidoNuevo = [];
  imagenPermitidoAntiguo = [];
  ubicacion = [];

  imagenFrontalPermitidoNuevo = [];
  imagenFrontalPermitidoAntiguo = [];
  ubicacionFrontal = [];

  imagenTraseraPermitidoNuevo = [];
  imagenTraseraPermitidoAntiguo = [];
  ubicacionTrasera = [];

}

function verificarLoading() {

  if (archivosTemporales.length > 0 && archivosTemporalesFrontal.length > 0 && archivosTemporalesTrasera.length > 0) {

    mensajeFinal = "trasera";

  }

  if (archivosTemporales.length == 0 && archivosTemporalesFrontal.length > 0 && archivosTemporalesTrasera.length > 0) {

    mensajeFinal = "trasera";

  }

  if (archivosTemporales.length == 0 && archivosTemporalesFrontal.length == 0 && archivosTemporalesTrasera.length > 0) {

    mensajeFinal = "trasera";

  }

  if (archivosTemporales.length > 0 && archivosTemporalesFrontal.length > 0 && archivosTemporalesTrasera.length == 0) {

    mensajeFinal = "frontal";

  }

  if (archivosTemporales.length == 0 && archivosTemporalesFrontal.length > 0 && archivosTemporalesTrasera.length == 0) {

    mensajeFinal = "frontal";

  }

  if (archivosTemporales.length > 0 && archivosTemporalesFrontal.length == 0 && archivosTemporalesTrasera.length == 0) {

    mensajeFinal = "imagen";

  }

  if (archivosTemporales.length == 0 && archivosTemporalesFrontal.length == 0 && archivosTemporalesTrasera.length == 0) {

    mensajeFinal = "ninguno";

  }

}

//============================================IMAGEN DEL USUARIO===========================================================

/*=============================================
ARRASTRAR VARIAS IMAGENES GALERÍA
=============================================*/

var archivosTemporales = [];

$(".subirGaleria").on("dragenter", function(e) {

  // alert("dragenter");

  e.preventDefault();
  e.stopPropagation();

  $(".subirGaleria").css({
    "background": "url(vistas/img/plantilla/pattern.jpg)"
  })

})

$(".subirGaleria").on("dragleave", function(e) {

  // alert("dragleave");

  e.preventDefault();
  e.stopPropagation();

  $(".subirGaleria").css({
    "background": ""
  })

})

$(".subirGaleria").on("dragover", function(e) {

  // alert("dragover");

  e.preventDefault();
  e.stopPropagation();

})

$("#galeria").change(function() {

  // alert("change");

  var archivos = this.files;
  multiplesArchivos(archivos);

})

$(".subirGaleria").on("drop", function(e) {

  // alert("drop");

  e.preventDefault();
  e.stopPropagation();

  $(".subirGaleria").css({
    "background": ""
  })

  // var archivos = e.originalEvent.dataTransfer.files;
  // multiplesArchivos(archivos);
  document.getElementById('galeria').files = e.originalEvent.dataTransfer.files;
  var archivos = document.getElementById('galeria').files;
  multiplesArchivos(archivos);

})


/*=============================================
AGREGAR IMAGEN EN LA GALERÍA
=============================================*/
function multiplesArchivos(archivos) {

  for (var i = 0; i < archivos.length; i++) {


    if ((imagenPermitidoNuevo.length + i + imagenPermitidoAntiguo.length) < 1) {

      var imagen = archivos[i];

      if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {

        swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

        return;

      } else if (imagen["size"] > 150000000) {

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
                         <div class="progress-bar mb-2" id="progress-bar` + i + `" role="progressbar" style="width:0%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>

                </li>

            `)


          if (archivosTemporales.length != 0) {

            archivosTemporales = JSON.parse($(".inputNuevaGaleria").val());
            ubicacion = JSON.parse($(".inputGaleria").val());
            imagenPermitidoNuevo = archivosTemporales;
          }

          archivosTemporales.push(rutaImagen);
          ubicacion.push(imagen["name"]);

          imagenPermitidoNuevo = archivosTemporales;


          $(".inputNuevaGaleria").val(JSON.stringify(archivosTemporales));
          $(".inputGaleria").val(JSON.stringify(ubicacion));


        })

      }

    } else {
      swal({
        title: "Error al subir la imagen",
        text: "¡Está permitido como máximo 1 imagen!",
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

      $(".inputNuevaGaleria").val(JSON.stringify(listaTemporales));
      $(".inputGaleria").val(JSON.stringify(ubicacionTemporales));
      imagenPermitidoNuevo = listaTemporales;

      $(this).parent().parent().remove();

    }


  }

})

/*=============================================
AGREGAR IMAGENES ANTIGUOS
=============================================*/

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

}

/*=============================================
QUITAR IMAGEN ANTIGUO
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

  }

})

/*=============================================
AGREGAR EN LA BASE DE DATOS LA IMAGEN
=============================================*/

function agregarImagen(imagen, token, ruta, rutavieja, rutacompleta) {

  /*=============================================
   PREGUNTAMOS SI LOS CAMPOS OBLIGATORIOS ESTÁN LLENOS
   =============================================*/

  if (imagen != "") {

    /*=============================================
      PREGUNTAMOS SI VIENEN IMÁGENES PARA MULTIMEDIA O LINK DE YOUTUBE
      =============================================*/

    if (imagen.length > 0 || rutavieja.length > 0) {

      datosMultimedia = new FormData();

      for (var i = 0; i < imagen.length; i++) {

        document.getElementById('galeria').files[i] = imagen[i];
        var img = document.getElementById('galeria').files[i];

        datosMultimedia.append("tabla", "clientes");
        datosMultimedia.append("token", token);
        datosMultimedia.append("token_columna", "TOKEN_CLIENTE");
        datosMultimedia.append("rutavieja", rutavieja);
        datosMultimedia.append("rutacompleta", rutacompleta);
        datosMultimedia.append("foto_columna", "IMAGEN_CLIENTE");
        datosMultimedia.append("file", img);
        datosMultimedia.append("carpeta", "clientes");
        datosMultimedia.append("ruta", ruta);

        $.ajax({

          type: "POST",
          url: "ajax/multimedia.ajax.php",
          dataType: "json",
          contentType: false,
          processData: false,
          cache: false,
          data: datosMultimedia,

          xhr: function() {

            var xhr = $.ajaxSettings.xhr();

            xhr.onprogress = function(evt) {

              var porcentaje = Math.floor((evt.loaded / evt.total * 100));

            };

            return xhr;

          },
          beforeSend: () => {

            $("#btnGuardar").prop('disabled', true);
            document.getElementById("mostrar_loading").style.display = "block";

          }

        }).done(res => {

          if (res.status === 200) {

            if (mensajeFinal === "imagen") {

              cerrarLoading();
              $('#ModalClientes').modal('hide');

              swal("success", res.msg, "success");

              tablaClientes.ajax.reload(function() {

                LimpiarText();

              });

            }

          } else {

            alert(res.msg);

          }

        }).fail(err => {

          swal("Error", err.msg, "error");

        })

      }


    }

  }


}

//============================================FIN IMAGEN DE USUARIO===========================================================


//============================================IMAGEN FRONTAL CEDULA===========================================================

/*=============================================
ARRASTRAR VARIAS IMAGENES CEDULA FRONTAL
=============================================*/

var archivosTemporalesFrontal = [];

$(".subirCedulaFrontal").on("dragenter", function(e) {

  // alert("dragenter");

  e.preventDefault();
  e.stopPropagation();

  $(".subirCedulaFrontal").css({
    "background": "url(vistas/img/plantilla/pattern.jpg)"
  })

})

$(".subirCedulaFrontal").on("dragleave", function(e) {

  // alert("dragleave");

  e.preventDefault();
  e.stopPropagation();

  $(".subirCedulaFrontal").css({
    "background": ""
  })

})

$(".subirCedulaFrontal").on("dragover", function(e) {

  // alert("dragover");

  e.preventDefault();
  e.stopPropagation();

})

$("#cedulaFrontal").change(function() {

  // alert("change");

  var archivos = this.files;
  multiplesArchivosFrontal(archivos);

})

$(".subirCedulaFrontal").on("drop", function(e) {

  // alert("drop");

  e.preventDefault();
  e.stopPropagation();

  $(".subirCedulaFrontal").css({
    "background": ""
  })

  // var archivos = e.originalEvent.dataTransfer.files;
  // multiplesArchivosFrontal(archivos);

  document.getElementById('cedulaFrontal').files = e.originalEvent.dataTransfer.files;
  var archivos = document.getElementById('cedulaFrontal').files;
  multiplesArchivosFrontal(archivos);


})

var imagenFrontalPermitidoNuevo = [];
var imagenFrontalPermitidoAntiguo = [];
var ubicacionFrontal = [];


/*=============================================
AGREGAR IMAGEN DE CEDULA FRONTAL
=============================================*/
function multiplesArchivosFrontal(archivos) {

  for (var i = 0; i < archivos.length; i++) {

    if ((imagenFrontalPermitidoNuevo.length + i + imagenFrontalPermitidoAntiguo.length) < 1) {

      var imagen = archivos[i];

      if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {

        swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

        return;

      } else if (imagen["size"] > 150000000) {

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

          $(".vistaCedulaFrontal").append(`

                <li class="col-12 col-md-6 col-lg-3 card px-0 rounded-10 shadow-none img-fluid">
                      
                      <img class="card-img-top" src="` + rutaImagen + `">

                        <div class="card-img-overlay p-0 pr-0">
                          
                           <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoFrontalNueva" temporal>
                             
                             <i class="fas fa-times"></i>

                           </button>

                        </div>
                  
                  <div class="bs-component" Style="display:none">
                    <div class="progress">
                         <div class="progress-bar mb-2" id="progress-bar` + i + `" role="progressbar" style="width:0%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>

                </li>

            `)


          if (archivosTemporalesFrontal.length != 0) {

            archivosTemporalesFrontal = JSON.parse($(".inputNuevaCedulaFrontal").val());
            ubicacionFrontal = JSON.parse($(".inputCedulaFrontal").val());
            imagenFrontalPermitidoNuevo = archivosTemporalesFrontal;
          }

          archivosTemporalesFrontal.push(rutaImagen);
          ubicacionFrontal.push(imagen["name"]);

          imagenFrontalPermitidoNuevo = archivosTemporalesFrontal;


          $(".inputNuevaCedulaFrontal").val(JSON.stringify(archivosTemporalesFrontal));
          $(".inputCedulaFrontal").val(JSON.stringify(ubicacionFrontal));


        })

      }

    } //Termina el if
    else {
      swal({
        title: "Error al subir la imagen",
        text: "¡Está permitido como máximo 1 imagen!",
        type: "error",
        confirmButtonText: "¡Cerrar!"
      });

      return;
    }

  } // termina el for

}


/*=============================================
QUITAR IMAGEN DE CEDULA FRONTAL
=============================================*/

$(document).on("click", ".quitarFotoFrontalNueva", function() {

  var listaFotosNuevas = $(".quitarFotoFrontalNueva");

  var listaTemporales = JSON.parse($(".inputNuevaCedulaFrontal").val());
  var ubicacionTemporales = JSON.parse($(".inputCedulaFrontal").val());
  // console.log(listaTemporales);

  for (var i = 0; i < listaFotosNuevas.length; i++) {

    $(listaFotosNuevas[i]).attr("temporal", listaTemporales[i]);

    var quitarImagen = $(this).attr("temporal");

    if (quitarImagen == listaTemporales[i]) {

      listaTemporales.splice(i, 1);
      ubicacionTemporales.splice(i, 1);
      //  imagenPermitidoNuevo = listaTemporales;

      $(".inputNuevaCedulaFrontal").val(JSON.stringify(listaTemporales));
      $(".inputCedulaFrontal").val(JSON.stringify(ubicacionTemporales));
      imagenFrontalPermitidoNuevo = listaTemporales;

      $(this).parent().parent().remove();

    }


  }

})

/*=============================================
AGREGAR IMAGENES ANTIGUOS DE CEDULA FRONTAL
=============================================*/

archivosTemporalesAntiguoFrontal = [];

function multiplesArchivosAntiguosFrontal(archivos) {
  var longitud = JSON.parse(archivos);
  //console.log(longitud.length);
  for (var i = 0; i < longitud.length; i++) {

    var imagen = longitud[i];

    var rutaImagen = imagen;

    $(".vistaCedulaFrontal").append(`

               <li class="col-12 col-md-6 col-lg-3 card px-0 rounded-10 shadow-none img-fluid">
                      
                      <img class="card-img-top" src="` + rutaImagen + `">

                      <div class="card-img-overlay p-0 pr-0">
                        
                         <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoAntiguaFrontal" temporal="` + rutaImagen + `">
                           
                           <i class="fas fa-times"></i>

                         </button>

                      </div>

                  </li>

            `)

    archivosTemporalesAntiguoFrontal.push(rutaImagen.split(','));
    imagenFrontalPermitidoAntiguo = archivosTemporalesAntiguoFrontal;

    $(".inputAntiguaCedulaFrontal").val(archivosTemporalesAntiguoFrontal);

    //  })


  } // termina el for

}

/*=============================================
QUITAR IMAGEN ANTIGUO FRONTAL
=============================================*/

$(document).on("click", ".quitarFotoAntiguaFrontal", function() {

  var listaFotosAntiguas = $(".quitarFotoAntiguaFrontal");

  var listaTemporales = $(".inputAntiguaCedulaFrontal").val().split(",");

  for (var i = 0; i < listaFotosAntiguas.length; i++) {

    quitarImagen = $(this).attr("temporal");


    if (quitarImagen == listaTemporales[i]) {

      listaTemporales.splice(i, 1);

      $(".inputAntiguaCedulaFrontal").val(listaTemporales.toString());
      imagenFrontalPermitidoAntiguo = listaTemporales;

      $(this).parent().parent().remove();

    }

  }

})

/*=============================================
AGREGAR EN LA BASE DE DATOS LA IMAGEN
=============================================*/

function agregarCedulaFrontal(imagen, token, ruta, rutavieja, rutacompleta) {

  /*=============================================
   PREGUNTAMOS SI LOS CAMPOS OBLIGATORIOS ESTÁN LLENOS
   =============================================*/

  if (imagen != "") {

    /*=============================================
      PREGUNTAMOS SI VIENEN IMÁGENES PARA MULTIMEDIA O LINK DE YOUTUBE
      =============================================*/

    if (imagen.length > 0 || rutavieja.length > 0) {

      datosMultimedia = new FormData();

      for (var i = 0; i < imagen.length; i++) {

        document.getElementById('cedulaFrontal').files[i] = imagen[i];
        var img = document.getElementById('cedulaFrontal').files[i];

        datosMultimedia.append("tabla", "clientes");
        datosMultimedia.append("token", token);
        datosMultimedia.append("token_columna", "TOKEN_CLIENTE");
        datosMultimedia.append("rutavieja", rutavieja);
        datosMultimedia.append("rutacompleta", rutacompleta);
        datosMultimedia.append("foto_columna", "IMAGEN_CEDULA");
        datosMultimedia.append("file", img);
        datosMultimedia.append("carpeta", "clientes");
        datosMultimedia.append("ruta", ruta);

        $.ajax({

          type: "POST",
          url: "ajax/multimedia.ajax.php",
          dataType: "json",
          contentType: false,
          processData: false,
          cache: false,
          data: datosMultimedia,

          xhr: function() {

            var xhr = $.ajaxSettings.xhr();

            xhr.onprogress = function(evt) {

              var porcentaje = Math.floor((evt.loaded / evt.total * 100));

            };

            return xhr;

          },
          beforeSend: () => {

            $("#btnGuardar").prop('disabled', true);
            document.getElementById("mostrar_loading").style.display = "block";

          }

        }).done(res => {

          if (res.status === 200) {

            if (mensajeFinal === "frontal") {

              cerrarLoading();
              $('#ModalClientes').modal('hide');

              swal("success", res.msg, "success");

              tablaClientes.ajax.reload(function() {

                LimpiarText();

              });

            }

          } else {

            alert(res.msg);

          }

        }).fail(err => {

          swal("Error", err.msg, "error");

        })

      }

    }

  }


}


//============================================FIN IMAGEN FRONTAL CEDULA===========================================================

//============================================IMAGEN TRASERA CEDULA===========================================================

/*=============================================
ARRASTRAR VARIAS IMAGENES CEDULA TRASERA
=============================================*/

var archivosTemporalesTrasera = [];

$(".subirCedulaTrasera").on("dragenter", function(e) {

  // alert("dragenter");

  e.preventDefault();
  e.stopPropagation();

  $(".subirCedulaTrasera").css({
    "background": "url(vistas/img/plantilla/pattern.jpg)"
  })

})

$(".subirCedulaTrasera").on("dragleave", function(e) {

  // alert("dragleave");

  e.preventDefault();
  e.stopPropagation();

  $(".subirCedulaTrasera").css({
    "background": ""
  })

})

$(".subirCedulaTrasera").on("dragover", function(e) {

  // alert("dragover");

  e.preventDefault();
  e.stopPropagation();

})

$("#cedulaTrasera").change(function() {

  // alert("change");

  var archivos = this.files;
  multiplesArchivosTrasera(archivos);

})

$(".subirCedulaTrasera").on("drop", function(e) {

  // alert("drop");

  e.preventDefault();
  e.stopPropagation();

  $(".subirCedulaTrasera").css({
    "background": ""
  })

  // var archivos = e.originalEvent.dataTransfer.files;
  // multiplesArchivosTrasera(archivos);

  document.getElementById('cedulaTrasera').files = e.originalEvent.dataTransfer.files;
  var archivos = document.getElementById('cedulaTrasera').files;
  multiplesArchivosTrasera(archivos);


})

var imagenTraseraPermitidoNuevo = [];
var imagenTraseraPermitidoAntiguo = [];
var ubicacionTrasera = [];


/*=============================================
AGREGAR IMAGEN DE CEDULA TRSERA
=============================================*/
function multiplesArchivosTrasera(archivos) {

  for (var i = 0; i < archivos.length; i++) {

    if ((imagenTraseraPermitidoNuevo.length + i + imagenTraseraPermitidoAntiguo.length) < 1) {

      var imagen = archivos[i];

      if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {

        swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

        return;

      } else if (imagen["size"] > 150000000) {

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

          $(".vistaCedulaTrasera").append(`

                <li class="col-12 col-md-6 col-lg-3 card px-0 rounded-10 shadow-none img-fluid">
                      
                      <img class="card-img-top" src="` + rutaImagen + `">

                        <div class="card-img-overlay p-0 pr-0">
                          
                           <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoTraseraNueva" temporal>
                             
                             <i class="fas fa-times"></i>

                           </button>

                        </div>
                  
                  <div class="bs-component" Style="display:none">
                    <div class="progress">
                         <div class="progress-bar mb-2" id="progress-bar` + i + `" role="progressbar" style="width:0%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>

                </li>

            `)


          if (archivosTemporalesTrasera.length != 0) {

            archivosTemporalesTrasera = JSON.parse($(".inputNuevaCedulaTrasera").val());
            ubicacionTrasera = JSON.parse($(".inputCedulaTrasera").val());
            imagenTraseraPermitidoNuevo = archivosTemporalesTrasera;
          }

          archivosTemporalesTrasera.push(rutaImagen);
          ubicacionTrasera.push(imagen["name"]);

          imagenTraseraPermitidoNuevo = archivosTemporalesTrasera;


          $(".inputNuevaCedulaTrasera").val(JSON.stringify(archivosTemporalesTrasera));
          $(".inputCedulaTrasera").val(JSON.stringify(ubicacionTrasera));


        })

      }

    } //Termina el if
    else {
      swal({
        title: "Error al subir la imagen",
        text: "¡Está permitido como máximo 1 imagen!",
        type: "error",
        confirmButtonText: "¡Cerrar!"
      });

      return;
    }

  } // termina el for

}


/*=============================================
QUITAR IMAGEN DE CEDULA TRASERA
=============================================*/

$(document).on("click", ".quitarFotoTraseraNueva", function() {

  var listaFotosNuevas = $(".quitarFotoTraseraNueva");

  var listaTemporales = JSON.parse($(".inputNuevaCedulaTrasera").val());
  var ubicacionTemporales = JSON.parse($(".inputCedulaTrasera").val());
  // console.log(listaTemporales);

  for (var i = 0; i < listaFotosNuevas.length; i++) {

    $(listaFotosNuevas[i]).attr("temporal", listaTemporales[i]);

    var quitarImagen = $(this).attr("temporal");

    if (quitarImagen == listaTemporales[i]) {

      listaTemporales.splice(i, 1);
      ubicacionTemporales.splice(i, 1);
      //  imagenPermitidoNuevo = listaTemporales;

      $(".inputNuevaCedulaTrasera").val(JSON.stringify(listaTemporales));
      $(".inputCedulaTrasera").val(JSON.stringify(ubicacionTemporales));
      imagenTraseraPermitidoNuevo = listaTemporales;

      $(this).parent().parent().remove();

    }


  }

})

/*=============================================
AGREGAR IMAGENES ANTIGUOS DE CEDULA TRASERA
=============================================*/

archivosTemporalesAntiguoTrasera = [];

function multiplesArchivosAntiguosTrasera(archivos) {
  var longitud = JSON.parse(archivos);
  //console.log(longitud.length);
  for (var i = 0; i < longitud.length; i++) {

    var imagen = longitud[i];

    var rutaImagen = imagen;

    $(".vistaCedulaTrasera").append(`

               <li class="col-12 col-md-6 col-lg-3 card px-0 rounded-10 shadow-none img-fluid">
                      
                      <img class="card-img-top" src="` + rutaImagen + `">

                      <div class="card-img-overlay p-0 pr-0">
                        
                         <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoAntiguaTrasera" temporal="` + rutaImagen + `">
                           
                           <i class="fas fa-times"></i>

                         </button>

                      </div>

                  </li>

            `)

    archivosTemporalesAntiguoTrasera.push(rutaImagen.split(','));
    imagenTraseraPermitidoAntiguo = archivosTemporalesAntiguoTrasera;

    $(".inputAntiguaCedulaTrasera").val(archivosTemporalesAntiguoTrasera);

    //  })


  } // termina el for

}

/*=============================================
QUITAR IMAGEN ANTIGUO DE CEDULA TRASERA
=============================================*/

$(document).on("click", ".quitarFotoAntiguaTrasera", function() {

  var listaFotosAntiguas = $(".quitarFotoAntiguaTrasera");

  var listaTemporales = $(".inputAntiguaCedulaTrasera").val().split(",");

  for (var i = 0; i < listaFotosAntiguas.length; i++) {

    quitarImagen = $(this).attr("temporal");


    if (quitarImagen == listaTemporales[i]) {

      listaTemporales.splice(i, 1);

      $(".inputAntiguaCedulaTrasera").val(listaTemporales.toString());
      imagenTraseraPermitidoAntiguo = listaTemporales;

      $(this).parent().parent().remove();

    }

  }

})


/*=============================================
AGREGAR EN LA BASE DE DATOS LA IMAGEN DE CEDULA TRASERA
=============================================*/

function agregarCedulaTrasera(imagen, token, ruta, rutavieja, rutacompleta) {

  /*=============================================
   PREGUNTAMOS SI LOS CAMPOS OBLIGATORIOS ESTÁN LLENOS
   =============================================*/

  if (imagen != "") {

    /*=============================================
      PREGUNTAMOS SI VIENEN IMÁGENES PARA MULTIMEDIA O LINK DE YOUTUBE
      =============================================*/

    if (imagen.length > 0 || rutavieja.length > 0) {

      datosMultimedia = new FormData();

      for (var i = 0; i < imagen.length; i++) {

        document.getElementById('cedulaTrasera').files[i] = imagen[i];
        var img = document.getElementById('cedulaTrasera').files[i];

        datosMultimedia.append("tabla", "clientes");
        datosMultimedia.append("token", token);
        datosMultimedia.append("token_columna", "TOKEN_CLIENTE");
        datosMultimedia.append("rutavieja", rutavieja);
        datosMultimedia.append("rutacompleta", rutacompleta);
        datosMultimedia.append("foto_columna", "IMAGEN_CEDULAATRAS");
        datosMultimedia.append("file", img);
        datosMultimedia.append("carpeta", "clientes");
        datosMultimedia.append("ruta", ruta);

        $.ajax({

          type: "POST",
          url: "ajax/multimedia.ajax.php",
          dataType: "json",
          contentType: false,
          processData: false,
          cache: false,
          data: datosMultimedia,

          xhr: function() {

            var xhr = $.ajaxSettings.xhr();

            xhr.onprogress = function(evt) {

              var porcentaje = Math.floor((evt.loaded / evt.total * 100));

            };

            return xhr;

          },
          beforeSend: () => {

            $("#btnGuardar").prop('disabled', true);
            document.getElementById("mostrar_loading").style.display = "block";

          }

        }).done(res => {

          if (res.status === 200) {

            if (mensajeFinal === "trasera") {

              cerrarLoading();
              $('#ModalClientes').modal('hide');

              swal("success", res.msg, "success");

              tablaClientes.ajax.reload(function() {

                LimpiarText();

              });

            }

          } else {

            alert(res.msg);

          }

        }).fail(err => {

          swal("Error", err.msg, "error");

        })

      }

    }

  }


}

//============================================FIN IMAGEN FRONTAL CEDULA===========================================================

var montrar = 0;

$(document).on("click", "#ver", function() {

  var id_canal = $("#cmbTipoCliente").val();
  // console.log("id_canal", id_canal);

  if (id_canal != "") {
    if (montrar == 0) {
      document.querySelector('#Verdescuento').classList.add("notblock");
      document.querySelector('#nodescuento').classList.remove("notblock");
      document.querySelector('#tablaOcultar').classList.remove("notblock");
      montrar = 1;
    } else {
      document.querySelector('#Verdescuento').classList.remove("notblock");
      document.querySelector('#nodescuento').classList.add("notblock");
      document.querySelector('#tablaOcultar').classList.add("notblock");
      montrar = 0;

    }

  } else {
    swal("error", "Seleccione un canal para ver", "error");
  }


})


$(document).on("change", "#cmbTipoCliente", function() {

  var cmbCanal = $("#cmbTipoCliente").val();
  $("#TablaDescuento td").remove();
  // alert(cmbCanal);
  // return;   

  var datos = new FormData();

  datos.append("canal", cmbCanal);

  $.ajax({

    url: "ajax/descuentos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      // document.querySelector('#tablaOcultar').classList.remove("notblock");
      var f;
      var can = 0;
      var monto = 0;
      for (var i = 0; i < respuesta.length; i++) {
        can += 1;

        f += `<tr>
                 <td class="text-center">` + can + `</td>
                 <td class="text-center" >` + new Intl.NumberFormat().format(respuesta[i]["MONTO_DESDE"]) + `</td>
                 <td class="text-center">` + new Intl.NumberFormat().format(respuesta[i]["MONTO_HASTA"]) + `</td>
                 <td class="text-center">` + new Intl.NumberFormat("de-DE").format(respuesta[i]["DESC_CANAL"]) + ' %' + `</td>'
                 </tr>`;
      }
      $("#TablaDescuento").append(f);

    }
  })

});


/*=============================================
VALIDAR TITULO RUC REPETIDO
=============================================*/

$('#txtRUC').change(function() {

  var ruc = $(this).val();

  // alert(ruc);

  var datos = new FormData();
  datos.append("validarRuc", ruc);

  $.ajax({

    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      if (respuesta) {

        $('#txtRUC').val("");

        $("#validarRuc").remove();

        $('#txtRUC').after(`

        <div class="alert alert-warning" id="validarRuc">
          <strong>ERROR:</strong>
          El RUC ya está registrado, por favor ingrese otro diferente
        </div>

        `);

        return;

      } else {

        $("#validarRuc").remove();

      }

    }

  })

})

/*=============================================
VALIDAR TITULO EMAIL REPETIDO
=============================================*/

$('#txtEmail').change(function() {

  var email = $(this).val();

  // alert(email);

  var datos = new FormData();
  datos.append("validarEmail", email);

  $.ajax({

    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      if (respuesta) {

        $('#txtEmail').val("");

        $("#validarEmail").remove();

        $('#txtEmail').after(`

        <div class="alert alert-warning" id="validarEmail">
          <strong>ERROR:</strong>
          El EMAIL ya está registrado, por favor ingrese otro diferente
        </div>

        `);

        return;

      } else {

        $("#validarEmail").remove();

      }

    }

  })

})


/*=============================================
QUITAR LA TABLA DE DESCUENTOS
=============================================*/

$(document).on("click", ".quitarDescuento", function() {

  $(".tituloDescuento").remove();
  $(".tablaDesc").remove();

})

// function mostrarLoading(){

//   document.getElementById("mostrar_loading").style.display="block";
//   document.getElementById("modalBody").style.display="none";

//   $("#titulo").html("Guardando...");

//   $('#btnGuardar').hide();
//   $('#btnCerrar').hide();

// }


// function cerrarLoading(){

//   document.getElementById("mostrar_loading").style.display="none";
//   document.getElementById("modalBody").style.display="block";

//   $("#btnGuardar").prop('disabled', false);
//   $("#btnCerrar").prop('disabled', false);

//   $('#btnGuardar').show();
//   $('#btnCerrar').show();

//   $('#formClientes').trigger("reset");

//   // $('#ModalClientes').modal('hide');

// }



// /*=============================================
// VALIDAR TITULO REPETIDO
// =============================================*/

// $('#cmbTipoCliente').change(function() {

//   var cmbTipoCliente = $("#cmbTipoCliente").val();

//   // alert(cmbTipoCliente);

//   if(cmbTipoCliente != 0){

//     $("#mostrarDescuento").remove();

//     $('#mensajeTipoCliente').after(`

//           <div class="alert alert-info" id="mostrarDescuento" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tooltip on top">
//             <strong>DESCUENTO:</strong>
//             10%
//           </div>

//           `);

//     // var titulo = $(this).val();

//     // alert(titulo);

//     // var datos = new FormData();
//     // datos.append("validarTitulo", titulo);


//     // $.ajax({

//     //   url: "ajax/guias.ajax.php",
//     //   method: "POST",
//     //   data: datos,
//     //   cache: false,
//     //   contentType: false,
//     //   processData: false,
//     //   dataType: "json",
//     //   success: function(respuesta) {

//     //     if (respuesta) {

//     //       $('#txtTitulo').val("");

//     //       $("#validarTitulo").remove();

//     //       $('#txtTitulo').after(`

//     //       <div class="alert alert-warning" id="validarTitulo">
//     //         <strong>ERROR:</strong>
//     //         El título ya está registrado, por favor ingrese otro diferente
//     //       </div>

//     //       `);

//     //     return;

//     //     }else{

//     //       $("#validarTitulo").remove();

//     //     }

//     //   }

//     // })

//   }

// })