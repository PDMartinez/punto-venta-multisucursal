 // var proveedor = $("#cmbProveedorCuenta").val();

 //    if(proveedor == ""){
 //        proveedor = 0;
 //    }
  
  // $(".tablaListadoCuentas").DataTable().ajax.url("ajax/tablaListadoCuentas.ajax.php?sucursal=" + $("#idSucursal").val() + " &proveedor=" + 0 + " &fechaInicio=" + fechaInicial + "&fechaFin=" + fechaFinal).load();
/*=============================================
  CARGAR LISTADO DE CUENTAS CANCELADAS
=============================================*/
var tablaListadoCuentas = $('.tablaListadoCuentasCanceladas').DataTable({
    "ajax": "ajax/tablaListadoCuentasCanceladas.ajax.php?sucursal="+ $("#idSucursal").val() + " &proveedor=" + 0 + "&fechaInicio="+0+"&fechaFin="+0,
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
          "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
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
                "columns": [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] 
            }
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Exportar a Excel",
            "className": "btn btn-success",
            "exportOptions": { 
                "columns": [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]  
            }
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Exportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": { 
                "columns": [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] 
            }
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Exportar a CSV",
            "className": "btn btn-info",
            "exportOptions": { 
                "columns": [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]  
            }
          }
        ],

})

/*=============================================
  CARGAR HISTORIAL DE CUENTAS PAGADAS
=============================================*/

var tablaHistorialPago = $('.tablaCuentaHistorial').DataTable({
    // "ajax": "ajax/tablaHistorialCuentasPagar.ajax.php?codCuentaHistorialPago="+0,
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
          "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }

      },

      'dom': 'lBfrtip',
      'buttons': [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i>Copiar",
            "titleAttr":"Copiar",
            "className": "btn btn-secondary",
            "exportOptions": { 
                "columns": [2, 4, 5, 6, 7, 8, 9, 10] 
            }
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Exportar a Excel",
            "className": "btn btn-success",
            "exportOptions": { 
                "columns": [2, 4, 5, 6, 7, 8, 9, 10]  
            }
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Exportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": { 
                "columns": [2, 4, 5, 6, 7, 8, 9, 10] 
            }
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Exportar a CSV",
            "className": "btn btn-info",
            "exportOptions": { 
                "columns": [2, 4, 5, 6, 7, 8, 9, 10]  
            }
          },
        ],

        "createdRow": function(row, data, index) {
          
          // if (data[1] == "ANULADO") {
          //   $(row).addClass("table-danger");
          // }
          if (data[1][1] == "i") {
            $(row).addClass("table-danger");
          }

        }

})

/*=============================================
  CARGAR DETALLE DE CUENTAS CANCELADAS
=============================================*/
var tablaCuentaDetalle = $('.tablaCuentaDetalle').DataTable({
    // "ajax": "ajax/tablaDetallesCuentasPagar.ajax.php?codCuentaHistorialPago="+0,
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

    'dom': 'lBfrtip',
    'buttons': [{
        "extend": "copyHtml5",
        "text": "<i class='far fa-copy'></i> Copiar",
        "titleAttr": "Copiar",
        "className": "btn btn-secondary",
        "exportOptions": {
            "columns": [1, 2, 3, 4, 5, 6, 7]
        }
    }, {
        "extend": "excelHtml5",
        "text": "<i class='fas fa-file-excel'></i> Excel",
        "titleAttr": "Exportar a Excel",
        "className": "btn btn-success",
        "exportOptions": {
            "columns": [1, 2, 3, 4, 5, 6, 7]
        }
    }, {
        "extend": "pdfHtml5",
        "text": "<i class='fas fa-file-pdf'></i> PDF",
        "titleAttr": "Exportar a PDF",
        "className": "btn btn-danger",
        "exportOptions": {
            "columns": [1, 2, 3, 4, 5, 6, 7]
        }
    }, {
        "extend": "csvHtml5",
        "text": "<i class='fas fa-file-csv'></i> CSV",
        "titleAttr": "Exportar a CSV",
        "className": "btn btn-info",
        "exportOptions": {
            "columns": [1, 2, 3, 4, 5, 6, 7]
        }
    }],

})

/*=============================================
CALENDARIO DE RANGO DE FECHAS
=============================================*/
var fechaInicial;
var fechaFinal;

$('#daterange-btn').daterangepicker({
    ranges: {
      'Hoy': [moment(), moment()],
      'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
      'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
      'Este mes': [moment().startOf('month'), moment().endOf('month')],
      'Últimos mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate: moment()
  },

  function(start, end) {

    $('#daterange-btn span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));

    fechaInicial = start.format('YYYY-MM-DD');

    fechaFinal = end.format('YYYY-MM-DD');

    consultarRango(fechaInicial, fechaFinal);


  })

/*=============================================
RANGO DE FECHAS
=============================================*/

$(document).on("click", ".cancelBtn", function() {

    // alert("cancela");
    // alert($("#cmbProveedorCuenta").val());
    // return;

    $("#daterange-btn span").html('<i class="fa fa-calendar"></i>Movimiento de hoy');

    var proveedor;

    consultarRango(0, 0);

})

/*=============================================
FUNCIÓN PARA CONSULTAR RANGO DE FECHAS
=============================================*/

function consultarRango(fechaInicial, fechaFinal) {

    // console.log($("#idSucursal").val());
    var proveedor = $("#cmbProveedorCuenta").val();

    if(proveedor == ""){
        proveedor = 0;
    }


    $(".tablaListadoCuentasCanceladas").DataTable().ajax.url("ajax/tablaListadoCuentasCanceladas.ajax.php?sucursal=" + $("#idSucursal").val() + " &proveedor=" + proveedor + " &fechaInicio=" + fechaInicial + "&fechaFin=" + fechaFinal).load();

}

/*=============================================
  RECARGAR EL HISTORIAL EN LA TABLA SEGUN LA CUENTA CANCELADA
=============================================*/

$(document).on("click", ".historialCuentaCancelada", function() {
  
    var idCuenta = $(this).attr("idCuenta");

    // console.log(idCuenta);
    // return;

    // mostrarDatosProveedor(idCuenta);

    mostrarCabeceraHistorial(idCuenta);

    $(".tablaCuentaHistorial").DataTable().ajax.url("ajax/tablaHistorialCuentasPagar.ajax.php?codCuentaHistorialPago="+idCuenta).load();
  
})


/*=================================================
 FUNCION PARA MOSTRAR HISTORIAL DE PAGO DE LA CUENTA
==================================================*/

function mostrarCabeceraHistorial(idCuenta){

  var datos = new FormData();

  datos.append("codCuentaFecha", idCuenta);

      $.ajax({

        url: "ajax/cuentasPagar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

          // console.log(respuesta);
          // return;

            $("#txtProveedor").val(respuesta[0]["NOMBRE"]);
            $("#txtRuc").val(respuesta[0]["RUC"]);
            $("#txtTelefono").val(respuesta[0]["CELULAR"]);
            $("#txtTotal").val(new Intl.NumberFormat("de-DE").format(respuesta[0]["TOTAL_CUENTA"]));
            $("#txtComentario").val(respuesta[0]["OBSERVACIONES"]);

            /*================================================
            CALCULAR DIFERENCIA DE FECHAS PARA DIAS DE ADELANTO
            =================================================*/

            var diasAdelanto = 0

            for (var i = 0; i < respuesta.length ; i++) {

                if(respuesta[i]["DET_MOVIMIENTO"] == "PAGO"){

                    diasAdelanto += parseInt(calcularDiferenciaFecha(respuesta[i]["FECHA_VENC"], respuesta[i]["FECHA_PAGO"].split(" ", 1), respuesta[i]["PAGO"]));

                }

            // console.log(diasAdelanto);

            }

            $("#txtDiasAdelanto").text(diasAdelanto);

            if(diasAdelanto > 0){

                $("#txtDiasAdelanto").css("color", "green");

            }else if (diasAdelanto < 0){

                $("#txtDiasAdelanto").css("color", "red");

            }else{

                $("#txtDiasAdelanto").css("color", "orange");

            }

        }

      })

}

/*================================================
FUNCION PARA CALCULAR LA DIFERENCIA ENTRE 2 FECHAS
=================================================*/

function calcularDiferenciaFecha(fechaVenc, fechaPago, pago){

  // console.log(pago);

  var fechaVen = new Date(fechaVenc).getTime();
  var fechaPag = new Date(fechaPago[0]).getTime();

  var diff = fechaVen - fechaPag;

  if(parseInt(pago) < 0){

    // console.log((diff/(1000*60*60*24))*(-1));

    return((diff/(1000*60*60*24))*(-1));


  }else{

    // console.log(diff/(1000*60*60*24));

    return(diff/(1000*60*60*24));

  }

}

/*=============================================
  ANULAR PAGO
=============================================*/

$(".tablaCuentaHistorial").on("click", "button.anularPago", function(){

  var idCuenta = $(this).attr("idCuenta");
  var idCuentaCab = $(this).attr("idCuentaCab");

  // alert(idCuenta);
  // return;

  var datos = new FormData();

  datos.append("codCuentaDet1", idCuenta);

      $.ajax({

        url: "ajax/cuentasPagar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        async:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

          // console.log(respuesta);
          // return;

          var hoy = new Date();;
          var fecha = hoy.getFullYear() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getDate();
          var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
          var fechaYHora = fecha + ' ' + hora;
          // console.log($("#txtFechaPago").val());
          // console.log(fechaYHora);
          // return;

          var codCuenta = respuesta["COD_CUENTA"];
          var codUsuario = Number($("#idUsuario").val().split("/", 1));
          var pago = "-"+respuesta["PAGO"];
          var fechaVenc = respuesta["FECHA_VENC"];
          var saldo = respuesta["SALDO"];
          var fechaPago = fechaYHora;
          var estadoCuenta = respuesta["ESTADO_CUENTA"];
          var formaPago = (pagosNegativo(JSON.parse(respuesta["FORMAPAGO"])));
          var nroMovimiento = respuesta["NRO_MOVIMIENTO"];
          var nroRecibo = respuesta["NRO_RECIBO"];
          var tipoRecibo = respuesta["TIPO_RECIBO"];
          var agruparAnulado = respuesta["AGRUPAR_ANULADO"];
          var detMovimiento = "ANULADO";

          // console.log(" COD_CUENTA: " + codCuenta + " COD_USUARIO: "+ codUsuario + " PAGO: " + pago + " FECHA_VENC: " + fechaVenc + " SALDO: " + saldo + " FECHA_PAGO: " + fechaPago + " ESTADO_CUENTA: " + estadoCuenta + " NRO_MOVIMIENTO: " + nroMovimiento + " NRO_RECIBO: " + nroRecibo + " TIPO_RECIBO: " + tipoRecibo + " DET_MOVIMIENTO: " + detMovimiento + " AGRUPAR_ANULADO: " + agruparAnulado);
          // return;
          if(Object.keys(respuesta).length > 0){

            swal({

              title: '¿Está seguro de anular este registro?',
              text: "¡Si no lo está puede cancelar la acción!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              cancelButtonText: 'Cancelar',
              confirmButtonText: 'Si, anular pago!',
              closeOnConfirm: false,
              closeOnCancel: true

            }, function(isConfirm) {

              if (isConfirm) {

                anularPago(codCuenta, codUsuario, pago, fechaVenc, saldo, fechaPago, estadoCuenta, formaPago, nroMovimiento, nroRecibo, tipoRecibo, agruparAnulado, detMovimiento, idCuentaCab, idCuenta);

              }

            })

          }else{

            // alert("NO SE OBTUVIERON LOS DATOS" + Object.keys(respuesta).length);
            swal("Error", "NO SE OBTUVIERON LOS DATOS", "error");

          }

        }

      })

      return(false);

})

/*=============================================
  MOSTRAR DETALLES DE LA CUENTA
=============================================*/

$(document).on("click", ".verDetallesCuenta", function() {

  var idCuenta = $(this).attr("idCuenta");

  $(".tablaCuentaDetalle").DataTable().ajax.url("ajax/tablaDetallesCuentasPagar.ajax.php?codCuentaDetPago="+idCuenta).load();

  var datos = new FormData();

  datos.append("codCuentaCabecera", idCuenta);

      $.ajax({

        url: "ajax/cuentasPagar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

          // console.log(respuesta);

          $("#txtProv").val(respuesta["NOMBRE"]);
          $("#txtUsuario").val(respuesta["NOMBRE_FUNC"]);
          $("#txtSucursal").val(respuesta["SUCURSAL"]);
          $("#txtNroCompra").val(respuesta["NROCOMPRA"]+ "   " + respuesta["TIPO_PAGO"]);
          $("#txtFechaCompra").val(respuesta["FECHA_COMPRA"]);
          $("#txtTipoPago").val(respuesta["FORMA_PAGO"]);
          $("#txtTotalCompra").val(new Intl.NumberFormat("de-DE").format(parseInt(respuesta["TOTAL_COMPRA"])));


        }

      })

})

/*=============================================
  MOSTRAR DATOS DEL PROVEEDOR SEGÚN CUENTA
=============================================*/

function mostrarDatosProveedor(idCuenta){

  var datos = new FormData();

  datos.append("codCuentaProveedor", idCuenta);

      $.ajax({

        url: "ajax/cuentasPagar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

          // console.log(respuesta[0]["NOMBRE"]);
          $("#txtProveedor").val(respuesta[0]["NOMBRE"]);
          $("#txtRuc").val(respuesta[0]["RUC"]);
          $("#txtTelefono").val(respuesta[0]["CELULAR"]);
          $("#txtTotal").val(new Intl.NumberFormat("de-DE").format(respuesta[0]["TOTAL_CUENTA"]));

        }

      })

}

/*=============================================
PONER EN NEGATIVO LOS PAGOS
=============================================*/

function pagosNegativo(formaPago){

  var listaPagoNegativo = [];

  // console.log(formaPago);
  // return;

  for(var i = 0; i < formaPago.length; i++){

    listaPagoNegativo.push({ "id_metodo" : formaPago[i]["id_metodo"],
                "entrega" : "-" + formaPago[i]["entrega"], 
                "nrotransaccion" : formaPago[i]["nrotransaccion"]
    })

  }


  return(JSON.stringify(listaPagoNegativo));

}

/*====================================================
  FUNCION PARA ANULAR PAGO
=====================================================*/

function anularPago(codCuenta, codUsuario, pago, fechaVenc, saldo, fechaPago, estadoCuenta, formaPago, nroMovimiento, nroRecibo, tipoRecibo, agruparAnulado, detMovimiento, idCuentaCab, tokenCuentaDet){

  var datos = new FormData();
  datos.append("txtCodCuenta", codCuenta);
  datos.append("txtCodUsuario", codUsuario);
  datos.append("txtPagoAnular", pago);
  datos.append("txtFechaVenc", fechaVenc);
  datos.append("txtSaldo", saldo);
  datos.append("txtFechaPago", fechaPago);
  datos.append("txtEstadoCuenta", estadoCuenta);
  datos.append("txtFormaPago", formaPago);
  datos.append("txtNroMovimiento", nroMovimiento);
  datos.append("txtNroRecibo", nroRecibo);
  datos.append("txtTipoRecibo", tipoRecibo);
  datos.append("txtAgruparAnulado", agruparAnulado);
  datos.append("txtDetMovimiento", detMovimiento);
  datos.append("txtTokenCuentaDet", tokenCuentaDet);

  $.ajax({

    url:"ajax/cuentasPagar.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    async: false,
    dataType:"json",
    success:function(respuesta){

      var objData = JSON.parse(JSON.stringify(respuesta));

      if (objData.status) {

        swal("success", objData.msg, "success");

        $(".tablaCuentaHistorial").DataTable().ajax.url("ajax/tablaHistorialCuentasPagar.ajax.php?codCuentaHistorialPago="+idCuentaCab).load();

        mostrarCabeceraHistorial(idCuentaCab);

        // $(".tablaCuentasPagar").DataTable().ajax.url("ajax/tablaCuentasPagar.ajax.php?sucursal="+$("#idSucursal").val()+"&proveedor="+$("#cmbProveedorCuentas").val()).load();
        $('#tablaListadoCuentasCanceladas').DataTable().ajax.reload()

      }else {

        swal("Error", objData.msg, "error");

      }

    }

  })

  return (false);

}

/*=============================================
  RECARGAR LA TABLA LISTADO PRINCIPAL SEGUN PROVEEDOR
=============================================*/

$(document).on("change", "#cmbProveedorCuenta", function() {

  // alert($(this).val());

    var proveedor = $(this).val();

    if(proveedor == ""){
        proveedor = 0;
    }
  
  $(".tablaListadoCuentasCanceladas").DataTable().ajax.url("ajax/tablaListadoCuentasCanceladas.ajax.php?sucursal=" + $("#idSucursal").val() + " &proveedor=" + proveedor + " &fechaInicio=" + fechaInicial + "&fechaFin=" + fechaFinal).load();
  // alert($(this).val());
  
})