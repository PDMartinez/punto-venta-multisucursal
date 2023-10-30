
// const formCaja= $("#formCaja").val();

/*==========================================================
      CARGAR LOS DATOS EN LA TABLA Y DARLE FORMATO
============================================================*/

var tablaCajas = $(".tablaCajas").DataTable({

  "ajax": "ajax/tablaCajas.ajax.php",
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

var tipoBoton = "";


/*==========================================================
      Guardar Caja
============================================================*/

function guardarFormulario(){

  var cmbSucursal = $("#cmbSucursal").val();

  var txtNroCaja = $("#txtNroCaja").val();

  var txtNroFactura = $("#txtNroFactura").val();

  var txtTimbrado = $("#txtTimbrado").val();

  var txtInicioVigencia = $("#txtInicioVigencia").val();

  var txtFinVigencia = $("#txtFinVigencia").val();

  var txtVerificador = $("#txtVerificador").val();

  var txtTicket = $("#txtTicket").val();

  var txtNC = $("#txtNC").val();

  var cmbEstado = $("#cmbEstado").val();

  var tokenCaja = $("#tokenCaja").val();

  // alert("cmbSucursal: " + cmbSucursal + " -txtNroCaja: "+ txtNroCaja + " -txtNroFactura: "+ txtNroFactura + " -txtTimbrado: "+ txtTimbrado + " -txtInicioVigencia: "+ txtInicioVigencia + " -txtFinVigencia: "+ txtFinVigencia + " -txtEquipo: "+ txtEquipo + " -txtVerificador: "+ txtVerificador + " -txtTicket: "+ txtTicket + " -txtNC: "+ txtNC + " -cmbEstado: "+ cmbEstado + " -txtTicket: "+ txtTicket + " -tokenCaja: "+ tokenCaja);
  // return;

  var datos = new FormData();

    datos.append("cmbSucursal", cmbSucursal);
    datos.append("txtNroCaja", txtNroCaja);
    datos.append("txtNroFactura", txtNroFactura);
    datos.append("txtTimbrado", txtTimbrado);
    datos.append("txtInicioVigencia", txtInicioVigencia);
    datos.append("txtFinVigencia", txtFinVigencia);
    datos.append("txtEquipo", txtEquipo);
    datos.append("txtVerificador", txtVerificador);
    datos.append("txtTicket", txtTicket);
    datos.append("txtNC", txtNC);
    datos.append("cmbEstado", cmbEstado);
    datos.append("tokenCaja", tokenCaja);


    $.ajax({
    url: "ajax/cajas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,

    success: function(respuesta) {

      var objData = JSON.parse(respuesta);

      if (objData.status) {

        $('#ModalCaja').modal('hide');

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

      } else {

        swal("Error", objData.msg, "error");

      }

    }

  })
  
  return (false);

}


/*=============================================
      Editar Caja
=============================================*/

$(document).on("click", ".editarCaja", function() {

  tipoBoton = "editar";

  $("#titulo").html("Editar caja");
  $("#btnGuardar").html("Actualizar");

  LimpiarText();

  $.getJSON('https://api.ipify.org?format=json', function(data){

    // console.log(data.ip);

    txtEquipo = String(data.ip);

  });
  
  var token_caja = $(this).attr("tokenCaja");

  // console.log(token_caja);

  // return;
  
  var datos = new FormData();

  datos.append("token_caja", token_caja);

  $.ajax({

    url: "ajax/cajas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      // console.log(respuesta);

      $("#cmbSucursal").val(respuesta["COD_SUCURSAL"]+"/"+respuesta["TOKEN_SUCURSAL"]);
      $("#cmbSucursal").select2().trigger('change');//aplicar la seleccion

      $("#txtNroCaja").val(respuesta["NROCAJA"]);

      $("#txtNroFactura").val(respuesta["NRO_FACTURA"]);

      $("#txtTimbrado").val(respuesta["TIMBRADO"]);

      // var fechaInicio = respuesta["FECHA_DESDE"].split('-');
      // var nuevaFechaInicio = fechaInicio[0]+'-'+fechaInicio[1]+'-'+fechaInicio[2];

      // $("#txtInicioVigencia").val(nuevaFechaInicio);

      // var fechaFin = respuesta["FECHA_HASTA"].split('-');
      // var nuevaFechaFin = fechaFin[0]+'-'+fechaFin[1]+'-'+fechaFin[2];

      // $("#txtFinVigencia").val(nuevaFechaFin);

      $("#txtInicioVigencia").val(respuesta["FECHA_DESDE"]);

      $("#txtFinVigencia").val(respuesta["FECHA_HASTA"]);

      $("#txtVerificador").val(respuesta["NRO_VERIFICADOR"]);

      $("#txtTicket").val(respuesta["NROTICKET"]);

      $("#txtNC").val(respuesta["NRONOTACREDITO"]);

      $("#cmbEstado").val(respuesta["EST_CAJA"]);
      $("#cmbEstado").select2().trigger('change');//aplicar la seleccion

      $("#tokenCaja").val(respuesta["TOKEN_CAJA"]);

    }

  })

})


/*=============================================
Eliminar Caja
=============================================*/

$(document).on("click", ".eliminarCaja", function() {

  var tokenCaja = $(this).attr("tokenCaja");

  // alert(tokenCaja);

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
   divLoading.style.display = "flex";
      var datos = new FormData();

      datos.append("idEliminar", tokenCaja);

      $.ajax({

        url: "ajax/cajas.ajax.php",
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

          }else{

              swal("ERROR", objData.msg, "error");
          }

             divLoading.style.display = "none";

        }

      })

    }

  });

})

var txtEquipo;

$(document).on("click", ".btnNuevo", function() {

  tipoBoton = "nuevo";

  $("#titulo").html("Nueva caja");
  $("#btnGuardar").html("Guardar");
  LimpiarText();
  // getIpClient();
  $.getJSON('https://api.ipify.org?format=json', function(data){

    console.log(data.ip);

    txtEquipo = String(data.ip);

  });
  

})

function LimpiarText() {

  formCaja.reset();

  $("#idCaja").val("");

  $("#tokenCaja").val("");

  $("#cmbSucursal").select2().trigger('change');

  // $("#txtNroCaja").val("");

  $("#txtNroFactura").val("");

  $("#txtTimbrado").val("");

  $("#txtInicioVigencia").val("");

  $("#txtFinVigencia").val("");

  // $("#txtVerificador").val("");

  $("#txtTicket").val("");

  $("#txtNC").val("");

  $("#cmbEstado").select2().trigger('change');

  $('#btnGuardar').removeAttr('disabled');

}

$("#txtInicioVigencia").change(function() {

  var txtInicioVigencia = $("#txtInicioVigencia").val();

  var fechaInicio = txtInicioVigencia.split('-');

  var nuevaFecha = (parseInt(fechaInicio[0])+1)+'-'+fechaInicio[1]+'-'+fechaInicio[2];

  $("#txtFinVigencia").val(nuevaFecha);


})

$("#txtFinVigencia").change(function() {

  $(".alert").remove();

  var txtInicioVigencia = $("#txtInicioVigencia").val();
  var fechaInicio = txtInicioVigencia.split('-');
  var nuevaFechaInicio = fechaInicio[2]+'-'+fechaInicio[1]+'-'+fechaInicio[0];
  var inicioVigencia = new Date(nuevaFechaInicio);

  var txtFinVigencia = $("#txtFinVigencia").val();
  var fechaFin = txtFinVigencia.split('-');
  var nuevaFechaFin = fechaFin[2]+'-'+fechaFin[1]+'-'+fechaFin[0];
  var finVigencia = new Date(nuevaFechaFin);

  if(finVigencia < inicioVigencia){

    // swal("Atención", "La fecha final de vegencia es menor!", "error");

    $('#txtFinVigencia').val("");

        $('#txtFinVigencia').after(`

        <div class="alert alert-warning">
          <strong>ERROR:</strong>
          La fecha final de vegencia es menor!
        </div>

        `);

  }


})

// $(document).ready(function(){
$("#cmbSucursal").change(function() {

  var cmbSucursal = $("#cmbSucursal").val();

    // console.log(cmbSucursal);
    // return;

  if(tipoBoton == "nuevo"){

    if(cmbSucursal != ""){
    
      var datos = new FormData();

      datos.append("sucursal", cmbSucursal);

      $.ajax({

        url: "ajax/cajas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

          if(respuesta > 0){

            $("#txtNroCaja").val("Caja "+respuesta);

            $("#txtVerificador").val(respuesta);

          }else{

          }

        }

      });

    }else{

      $('#btnGuardar').removeAttr('disabled');

    }

  }

});

$(document).ready(function(){

  var cmbSucursal = "";

    // alert("Ingresa");

    // if(cmbSucursal != ""){
    
      var datos = new FormData();

      datos.append("sucursal", cmbSucursal);

      $.ajax({

        url: "ajax/cajas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

          // alert(respuesta);
          // return;

          if(respuesta > 0){

            $(".textoDetalle").remove();

            $('.btnNuevo').show();

          }else{

            $('.btnNuevo').hide();

            $(".textoDetalle").remove();

            $('.texto').after(`

              <div class="alert alert-danger" id="textoDetalle">
                <strong>ATENCIÓN:</strong>
                Alcanzó la cantidad límite de cajas habilitado, puede actualizar su plan llamando al:
                <br> 0982-203.704 (Ing. Marcos Contrera) o al 0972-905.218 (Ing. Danilo Martínez)
              </div>

              `);

            $("#txtNroCaja").val("");

            $('#btnGuardar').attr('disabled','disabled');

          }

        }

      });

    // }else{

    //   $('#btnGuardar').removeAttr('disabled');

    // }

});

