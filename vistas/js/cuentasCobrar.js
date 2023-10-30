/*=============================================
  BOTÓN NUEVO
=============================================*/

var estadoNuevo = false;

$(document).on("click", ".btnNuevo", function() {

    $(".cargarCuentasCobrar").removeClass("notblock");
    $(".listarCuentasCobrar").addClass("notblock");

    // formularioCobro.reset();
    agregarFecha();

})

/*=============================================
  BOTÓN LISTAR
=============================================*/

$(document).on("click", ".btnListar", function() {

    // console.log("ingresa");

    $(".listarCuentasCobrar").removeClass("notblock");
    $(".cargarCuentasCobrar").addClass("notblock");

    // if (localStorage.getItem("listaCuentasCobrar") != null) {

    //     var sucursal = $("#idSucursal").val();

    //     var listasCuentasCobrar = JSON.parse(localStorage.getItem("listaCuentasCobrar"));

    //     obtenerCuentaLocalStorage(listasCuentasCobrar);


    // }

    // $(".tablaCuentasCobrar").DataTable().ajax.url("ajax/tablaCuentasCobrar.ajax.php?sucursal=" + $("#idSucursal").val() + "&cliente=" + 0).load();


})


/*=============================================
  CARGAR LISTADO DE CUENTAS PAGADAS
=============================================*/

var tablaListadoCuentas = $('.tablaListadoCuentas').DataTable({
    "ajax": "ajax/tablaListadoCuentasCobrar.ajax.php?sucursal=" + $("#idSucursal").val() + "&cliente=" + 0 + "&fechaInicio=" + 0 + "&fechaFin=" + 0,
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "async": false,
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
            "columns": [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
        }
    }, {
        "extend": "excelHtml5",
        "text": "<i class='fas fa-file-excel'></i> Excel",
        "titleAttr": "Exportar a Excel",
        "className": "btn btn-success",
        "exportOptions": {
            "columns": [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
        }
    }, {
        "extend": "pdfHtml5",
        "text": "<i class='fas fa-file-pdf'></i> PDF",
        "titleAttr": "Exportar a PDF",
        "className": "btn btn-danger",
        "exportOptions": {
            "columns": [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
        }
    }, {
        "extend": "csvHtml5",
        "text": "<i class='fas fa-file-csv'></i> CSV",
        "titleAttr": "Exportar a CSV",
        "className": "btn btn-info",
        "exportOptions": {
            "columns": [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
        }
    }],

    "createdRow": function(row, data, index) {

        var parser = new DOMParser();
        var doc = parser.parseFromString(data[14], 'text/html');

        // console.log(parseInt(data[10]) + "-" + parseInt(data[9]));

        var cuotasPagada = data[10].split("/", 1); //se puede recuperar asi el primer caracter
        var totalCuotas = (data[10].split("/", -1)[1]); //tambien se puede recuperar asi mediante la posicion

        // console.log(cuotasPagada + " - " + totalCuotas);

        if (parseInt(cuotasPagada) >= parseInt(totalCuotas)) {

            // $(row).addClass("table-success");//verde

            // $(row).addClass("table-warning");//amarillo
            // $(row).addClass("table-primary");//azul
            // $(row).addClass("table-danger");//rojo
            // $(row).addClass("table-info");//celeste
            // $(row).addClass("table-active");//gris
            // $(row).addClass("table-secondary");//gris oscuro
            // $(row).addClass("table-light");//blanco
            // $(row).addClass("table-dark text-dark");//gris con contorno negro

        }

        if (parseInt(cuotasPagada) < parseInt(totalCuotas) && parseInt(cuotasPagada) > 0) {

            // $(row).addClass("table-warning");//rojo

        }

        if (parseInt(cuotasPagada) == 0) {

            // $(row).addClass("table-danger");//amarillo

        }

    },

})

/*=============================================
  FORMATO DE TABLAS DEL FORMULARIO
=============================================*/

var tablaCuentasCobrar = $('.tablaCuentasCobrar').DataTable({
    // "ajax": "ajax/tablaCuentasPagar.ajax.php?sucursal="+$("#idSucursal").val()+"&proveedor="+0,
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

var tablaCuentasCobrar = $('.tablaCuentasCanceladas').DataTable({
    // "ajax": "ajax/tablaCuentasPagar.ajax.php?sucursal="+$("#idSucursal").val()+"&proveedor="+0,
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

var tablaHistorialPago = $('.tablaCuentaHistorial').DataTable({
    // "ajax": "ajax/tablaHistorialCuentasPagar.ajax.php?codCuentaHistorialPago="+0,
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
        "text": "<i class='far fa-copy'></i>Copiar",
        "titleAttr": "Copiar",
        "className": "btn btn-secondary",
        "exportOptions": {
            "columns": [2, 4, 5, 6, 7, 8, 9, 10]
        }
    }, {
        "extend": "excelHtml5",
        "text": "<i class='fas fa-file-excel'></i> Excel",
        "titleAttr": "Exportar a Excel",
        "className": "btn btn-success",
        "exportOptions": {
            "columns": [2, 4, 5, 6, 7, 8, 9, 10]
        }
    }, {
        "extend": "pdfHtml5",
        "text": "<i class='fas fa-file-pdf'></i> PDF",
        "titleAttr": "Exportar a PDF",
        "className": "btn btn-danger",
        "exportOptions": {
            "columns": [2, 4, 5, 6, 7, 8, 9, 10]
        }
    }, {
        "extend": "csvHtml5",
        "text": "<i class='fas fa-file-csv'></i> CSV",
        "titleAttr": "Exportar a CSV",
        "className": "btn btn-info",
        "exportOptions": {
            "columns": [2, 4, 5, 6, 7, 8, 9, 10]
        }
    }],

    "createdRow": function(row, data, index) {

        if (data[1][1] == "i") {
            $(row).addClass("table-danger");
        }

    }

})

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

    var cliente;

    consultarRango(0, 0);

})

/*=============================================
FUNCIÓN PARA CONSULTAR RANGO DE FECHAS
=============================================*/

function consultarRango(fechaInicial, fechaFinal) {

    // console.log($("#idSucursal").val());
    var cliente = $("#cmbClienteCuenta").val();

    if (cliente == "") {
        cliente = 0;
    }

    // alert(cliente);
    // return;

    $(".tablaListadoCuentas").DataTable().ajax.url("ajax/tablaListadoCuentasCobrar.ajax.php?sucursal=" + $("#idSucursal").val() + " &cliente=" + cliente + " &fechaInicio=" + fechaInicial + "&fechaFin=" + fechaFinal).load();

}

/*=================================================
  RECARGAR LA TABLA LISTADO PRINCIPAL SEGUN CLIENTE
=================================================*/

$(document).on("change", ".cmbClienteCuenta", function() {

    var cliente = $(this).val();

    if (cliente == "") {
        cliente = 0;
    }

    $(".tablaListadoCuentas").DataTable().ajax.url("ajax/tablaListadoCuentasCobrar.ajax.php?sucursal=" + $("#idSucursal").val() + " &cliente=" + cliente + " &fechaInicio=" + fechaInicial + "&fechaFin=" + fechaFinal).load();

    // alert($(this).val());

})

/*=============================================
  RECARGAR LA TABLA SEGUN EL CLIENTE
=============================================*/

$(document).on("change", "#cmbClienteCuentas", function() {

    consultarClienteCuentas($(this).val())

    // alert($(this).val());

})

/*=============================================
  RECARGAR LA TABLA SEGUN CLIENTE
=============================================*/

$(document).on("change", "#cmbClienteCuentaCancelada", function() {

    var idCliente = $(this).val();

    // alert(idCliente);
    // return;

    $(".tablaCuentasCanceladas").DataTable().ajax.url("ajax/tablaCuentasCobrarCanceladas.ajax.php?sucursal=" + $("#idSucursal").val() + "&cliente=" + idCliente).load();

})

/*=============================================
  FUNCION PARA RECARGAR LA TABLA SEGUN EL CLIENTE
=============================================*/

function consultarClienteCuentas(idCliente) {

    // alert(idCliente);
    // return;

    $(".tablaCuentasCobrar").DataTable().ajax.url("ajax/tablaCuentasCobrar.ajax.php?sucursal=" + $("#idSucursal").val() + "&cliente=" + idCliente).load();

    quitarAgregarCuenta();

}

/*=============================================
  AGREGAR CUENTA A COBRAR A LA GRILLA
=============================================*/

var idCuenta = 0;

$(document).on("click", ".agregarCuenta", function() {

    var cod_cuenta = $(this).attr("idCuenta");

    agregarCuenta(cod_cuenta);

});

/*=============================================
  AGREGAR CUENTA DESDE EL LISTADO PRINCIPAL
=============================================*/

$(document).on("click", ".agregarCuentaListado", function() {

    var cod_cuenta = $(this).attr("idCuenta");
    var saldo = $(this).attr("saldo");
    var codCli = $(this).attr("idCliente");

    // alert(codCli);
    // return;

    $(".cargarCuentasCobrar").removeClass("notblock");
    $(".listarCuentasCobrar").addClass("notblock");
    // formularioPago.reset();

    if (parseInt(saldo) > 0) {

        // window.location = "index.php?ruta=crearCuentasPagar&id="+cod_cuenta+"&m="+montoCuota+"&t="+totalCuenta+"&s="+saldo+"&p="+codCli;

        // $("#cmbClienteCuentas").val(codCli);
        // $("#cmbClienteCuentas").select2().trigger('change'); //aplicar la seleccion


        if (cod_cuenta != null) {

            agregarCuenta(cod_cuenta);

        }

    } else {

        swal("Error", "Esta cuenta ya está cancelada", "error");
        return;

    }

});

/*=============================================
  AGREGAR CUENTA A COBRAR A LA GRILLA
=============================================*/

function agregarCuenta(cod_cuenta) {

    /*=============================================
    OBTENEMOS LOS DATOS DE CUENTA A COBRAR
    =============================================*/

    idCuenta = idCuenta + 1; //CONTADOS POR CADA CUENTA AGREGADA

    var datos = new FormData();
    datos.append("codCuenta", cod_cuenta);

    // alert(cod_cuenta);
    // return;

    $.ajax({

        url: "ajax/cuentasCobrar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

            var cant = respuesta["CANT_CUOTA"];//CANTIDAD DE CUOTAS EN QUE SE FINANCIÓ
            var fechaVenc = respuesta["FECHA_VENCIMIENTO"];//CAPTURAMOS FECHA DE VENCIMIENTO PARA AGREGAR COMO ATRR
            var tipoVenta = respuesta["TIPO_VENTA"];
            var montoCuota = respuesta["MONTO_CUOTA"];
            var totalCuenta = respuesta["TOTAL_CUENTA"];

            var cuotaPagada;
            var saldo;
            var pagoTotal;

            if(respuesta) {

                if (respuesta["PAGO"] == null) {

                    cuotaPagada = 0;
                    saldo = parseInt(respuesta["TOTAL_CUENTA"]);
                    pago = parseInt(0);

                } else {

                    cuotaPagada = respuesta["CUOTA_PAGADA_DECIMAL"];
                    saldo = parseInt(respuesta["SALDO"]);
                    pago = parseInt(respuesta["PAGO"]);

                }

            }else{

                saldo=totalCuenta;

            }

            var cuotaRestante = cant - cuotaPagada;

        /*=======================================================
        SOLICITAMOS EL INGRESO DE LA CANTIDAD DE CUOTAS A PAGAR
        ========================================================*/

        var cantidad="";

        if(parseInt(saldo) < parseInt(montoCuota)){

            cantidad = 0;

        }else{

            cantidad = prompt("¡Ingrese la cantidad!", 1);
                              
            if (cantidad != null && cantidad != ""){//REALIZAMOS LA VALIDACION

                // console.log(Math.round(cantidad.replace(',','.').replace(' ','')));
                cantidad = Math.round(cantidad.replace(',','.').replace(' ',''));//REDONDEAMOS SI ES DECIMAL

                // alert(cantidad);

                while (isNaN(cantidad) || cantidad <= 0 ) {

                    cantidad = prompt("¡Ingrese la cantidad!", 1);
                    cantidad = Math.round(cantidad.replace(',','.').replace(' ',''));//REDONDEAMOS SI ES DECIMAL

                };

                $(".recuperarBoton" + cod_cuenta.split("/", 2)[1]).attr('disabled', 'disabled');

            }else{

                return;

            }

        }

        /*=======================================================================================
          VALIDAMOS QUE LA CANTIDAD DE CUOTAS INGRESADA NO SEA MAYOR A LA CANTIDAD PENDIENTE A PAGAR
        ========================================================================================*/

        if(cantidad > cuotaRestante){

            cantidad = cuotaRestante;//si es mayor asignamos la cantidad de cuotas pendientes real

            swal({
              title: "Cantidad de cuotas a pagar excedida",
              text: "¡Cuotas pendientes a agregar: "+cuotaRestante+" !",
              type: "warning",
              confirmButtonText: "¡Aceptar!"
            });

        }

          /*=======================================================================================
          VALIDAMOS SI HAY PAGOS PARCIALES DE CUENTAS
          ========================================================================================*/

        if(parseInt(cantidad) == 0){

            var montoTotal = new Intl.NumberFormat("de-DE").format(saldo);

        }else{

            var montoTotal = new Intl.NumberFormat("de-DE").format(montoCuota.replace(/\./g,'') * cantidad);

        }

        /*=======================================================================================
        CARGAMOS LA TABLA
        ========================================================================================*/

        $("#tablaCuentaCobrar").append(

            '<tr class="rowNuevo">' +

                '<!-- BOTON PARA QUITAR -->' +

                '<td class="tdNuevoQuitar' + idCuenta + '">' +

                    '<div class="form-group nuevoQuitar' + idCuenta + '">' +

                        '<div class="input-group">' +

                        '<span class="input-group-addon">' +

                        '<button type="button" class="btn btn-danger btn-xs quitarCuenta" style="width:35px" idCuenta="' + idCuenta + '" idCuentaCobrar="' + cod_cuenta + '"><i class="fa fa-times"></i></button>' +

                        '</span>' +

                        '</div>' +

                    '</div>' +

                '</td>' +

                '<!-- Codigo de la cuenta -->' +

                '<td class="tdNuevoCodigo' + idCuenta + ' notblock">' +

                    '<div class="form-group nuevoCodigo' + idCuenta + '">' +

                        '<div class="input-group" style="width: 100px">' +

                        '<input type="text" class="form-control nuevoCodigoCuenta" idCuenta="' + idCuenta + '" fechaVenc="' + fechaVenc + '" tipoVenta="' + tipoVenta + '" value="' + cod_cuenta.split("/", 2)[0] + '" readonly required>' +

                        '</div>' +

                    '</div>' +

                '</td>' +

                '<!-- CANTIDAD DE CUOTAS -->' +

                '<td class="tdNuevoCantidad' + idCuenta + ' notblock">' +

                    '<div class="form-group nuevoCantidad' + idCuenta + '">' +

                        '<div class="input-group" style="width: 70px">' +

                        '<input type="text" class="form-control nuevaCantidadCuenta quitarCantidad' + idCuenta + '" idCuenta="' + idCuenta + '" cuotaPendiente="' + cuotaRestante + '" name="" value="' + cantidad + '" onkeyup="format(this)" onchange="format(this)" required>' +

                        '</div>' +

                    '</div>' +

                '</td>' +

                '<!-- N° RECIBO -->' +

                '<td class="tdNuevoRecibo' + idCuenta + '">' +

                    '<div class="form-group nuevoRecibo' + idCuenta + '">' +

                        '<div class="input-group" style="width: 70px">' +

                        '<input type="text" class="form-control inputRecibo' + idCuenta + ' nuevoRecibo' + idCuenta + '" idCuenta="' + idCuenta + '" name="" value="" readonly required>' +

                        '</div>' +

                    '</div>' +

                '</td>' +

                '<!-- AUTOMATICO -->' +

                '<td class="tdNuevoAutomatico' + idCuenta + '">' +

                    '<div class="form-group nuevoAutomatico' + idCuenta + '">' +

                        '<div class="animated-checkbox">' +

                        '<label id="lblFactura" class="control-label" style="margin-top: 8px">' +

                        '<input type="checkbox" class="chkAutomatico" checked value=1  name="chkOferta" idCuenta="' + idCuenta + '""><span class="label-text"></span>' +

                        '</label>' +

                        '</div>' +

                    '</div>' +

                '</td>' +

                '<!-- TIPO DE PAGO-->' +

                '<td class="tdNuevoPago' + idCuenta + '">' +

                    '<div class="form-group nuevoPago' + idCuenta + '" style="width: 200px">' +

                        '<div class="input-group">' +

                        '<select class="form-control selectPago" id="nuevoMetodoPago' + idCuenta + '" name="nuevoMetodoPago" required>' +

                        '<option value="">Seleccionar</option>' +

                        '</select>' +

                        '<div class="btn-group">' +

                        '<button type="button" class="btn btn-success btn-sm agregarCobro" style="width:35px" idCuenta="' + idCuenta + '" montoTotal="' + montoTotal + '"><i class="fa fa-plus"></i></button>' +
                        // '<button type="button" class="btn btn-danger btn-sm quitarCobro" style="width:35px" idCuenta="'+idCuenta+'"><i class="fa fa-trash"></i></button>'+

                        '</div>' +

                        '</div>' +

                    '</div>' +

                '</td>' +

                '<!-- N° COMPROBANTE -->' +

                '<td class="tdNuevoComprobante' + idCuenta + '">' +

                    '<div class="form-group nuevoComprobante' + idCuenta + '">' +

                        '<div class="input-group" style="width: 100px">' +

                        '<input type="text" class="form-control nuevoComprobante' + idCuenta + '" idCuenta="' + idCuenta + '" name="" value="">' +

                        '</div>' +

                    '</div>' +

                '</td>' +

                '<!-- Monto de Cuota -->' +

                '<td class="tdNuevoMonto' + idCuenta + '">' +

                    '<div class="form-group nuevoMonto' + idCuenta + '">' +

                        '<div class="input-group" style="width: 100px">' +

                        '<input type="text" class="form-control inputNuevoMonto' + idCuenta + '" idCuenta="' + idCuenta + '" name="" value="' + Intl.NumberFormat("de-DE").format(montoCuota) + '" readonly required>' +

                        '</div>' +

                    '</div>' +

                '</td>' +

                '<!-- Monto parcial -->' +

                '<td class="tdNuevoMontoParcial' + idCuenta + '">' +

                    '<div class="form-group nuevoMontoParcial' + idCuenta + '">' +

                        '<div class="input-group" style="width: 100px">' +

                        '<input type="text" class="form-control inputNuevoMontoParcial inputMultiple' + idCuenta + '" idCuenta="' + idCuenta + '" name="" value="' + montoTotal + '" onkeyup="format(this)" onchange="format(this)" required>' +

                        '</div>' +

                    '</div>' +

                '</td>' +

                '<!-- Saldo -->' +

                '<td class="tdNuevoMontoSaldo' + idCuenta + '">' +

                    '<div class="form-group nuevoMontoSaldo' + idCuenta + '">' +

                        '<div class="input-group" style="width: 100px">' +

                        '<input type="text" class="form-control nuevoMontoSaldoCuenta inputNuevoMontoSaldo' + idCuenta + '" idCuenta="' + idCuenta + '" name="" value="' + Intl.NumberFormat("de-DE").format(saldo) + '" readonly required>' +

                        '</div>' +

                    '</div>' +

                '</td>' +

            '</tr>'

        );

        cargarMetodoPago(idCuenta);

        /*=======================================================================================
            VALIDAMOS SI HAY PAGOS PARCIALES DE CUENTAS
        ========================================================================================*/

        if(parseInt(cantidad) == 0){

            $.notify({

                title: "Atención: ",
                message: "Cuenta parcial agregado correctamente!!!",
                icon: 'fa fa-check'

            },{
                      
                type: "warning"

            });

        }else{

            $.notify({

                title: "Éxito: ",
                message: "Cuenta agregado correctamente!!!",
                icon: 'fa fa-check'

            },{
                      
                type: "success"

            });

        }

        // SUMAR TOTAL DE PRECIOS

        sumarTotalCuentas();

        cargarLocalStorage();

        cantidadItems();

        }

    })

}

/*=============================================
  CARGAR METOOD DE PAGO
=============================================*/

function cargarMetodoPago(selectValue) {

    var item = null;
    var valor = null;
    var option = "";
    var selectOption = [];

    // console.log(idCuenta);
    // return;

    var datos = new FormData();

    datos.append("item", item);
    datos.append("valor", valor);


    $.ajax({

        url: "ajax/cuentasCobrar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

            // console.log(respuesta);

            $.each(respuesta, function(i, value) {

                $("#nuevoMetodoPago" + idCuenta).append(

                    '<option value="' + value["COD_FORMAPAGO"] + '/' + value["TOKEN_FORMAPAGO"] + '">' + value["DESCRIPCION_FORMA"] + '</option>'

                );

                selectOption.push(option);

            });

        }

    })

};

/*=============================================
  CARGAR METOOD DE PAGO
=============================================*/

function cargarMetodoPagoLocalStorage(idCuentaSelect) {

    var item = null;
    var valor = null;
    var option = "";
    var selectOption = [];

    // console.log("token_caja");
    // return;

    var datos = new FormData();

    datos.append("item", item);
    datos.append("valor", valor);


    $.ajax({

        url: "ajax/cuentasCobrar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        async: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

            //console.log(respuesta);

            $.each(respuesta, function(i, value) {

                $("#nuevoMetodoPago" + idCuentaSelect).append(

                    '<option value="' + value["COD_FORMAPAGO"] + '/' + value["TOKEN_FORMAPAGO"] + '">' + value["DESCRIPCION_FORMA"] + '</option>'

                );

                selectOption.push(option);

            });

        }

    })

};

/*=============================================
CALCULAR EL TOTAL DE PAGOS INGRESADOS
=============================================*/

function sumarTotalCuentas() {

    let selects = $('.inputNuevoMontoParcial');
    let selectsSec = $('.inputNuevoMontoParcialSec');
    var sumaPagos = 0;

    selects.each(function() {

        let select = $(this);

        if (select.val() == "") {

            sumaPagos = sumaPagos + parseInt(0);

        } else {

            sumaPagos = sumaPagos + parseInt(select.val().replace(/\./g, ''));

        }


    });

    selectsSec.each(function() {

        let selectSec = $(this);
        // console.log("*" + select.val());

        if (selectSec.val() == "") {

            sumaPagos = sumaPagos + parseInt(0);

        } else {

            sumaPagos = sumaPagos + parseInt(selectSec.val().replace(/\./g, ''));

        }

    });

    $("#txtNuevoTotalCuenta").val(new Intl.NumberFormat("de-DE").format(sumaPagos));
    $("#txtTotalCuenta").val(sumaPagos);
    $("#txtNuevoTotalCuenta").attr("total", sumaPagos);

    // console.log("SUMA TOTAL: " + sumaPagos);
    return (sumaPagos);

}

/*==================================================================
  EXTRAER DATOS AGREGADOS A LA TABLA PARA CARGAR EN EL LOCAL STORAGE
===================================================================*/

function cargarLocalStorage() {

    // alert("INGRESA");

    const tableRows = $('#tablaCuentaCobrar tr');

    var codUsuario;
    var pago;
    var metodoPago;
    var fechaVenc;
    var saldo;
    var fechaPago;
    var estadoCuenta;
    var nroMovimiento;
    var nroRecibo;
    var tipoRecibo;
    var formaPago;
    var tipoVenta;

    var listaPago = [];

    /*=============================================
        DEVUELVE LAS FILAS DEL BODY DE LA TABLA
    =============================================*/

    var nfilas = $("#tablaCuentaCobrar").find("tr.rowNuevo");

    // alert(nfilas.length);
    // return;

    // console.log(nfilas.length);

    if (nfilas.length < 1) {

        // localStorage.setItem("listaCuentasCobrar", JSON.stringify("[]"));
        localStorage.removeItem("listaCuentasCobrar");

    } else {

        //Recorre las filas 1 a 1
        for (var i = 0; i < nfilas.length; i++) {

            // f++;

            //devolverá las celdas de una fila
            var celdas = $(nfilas[i]).find("td");


            /*=============================================
            RECUPERAMOS LOS DATOS DE CADA CELDA POR CADA FILA
            =============================================*/

            var hoy = new Date();
            var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();

            // codCuenta = cod_cuenta;
            codCuenta = $($(celdas[0]).children().children().children().children()).attr("idCuentaCobrar");
            codUsuario = Number($("#idUsuario").val().split("/", 1));
            pago = Number($($(celdas[8]).children().children().children()).val().replace(/\./g, ''));
            codSucursal = Number($("#idSucursal").val().split("/", 1));
            cantidad = Number($($(celdas[2]).children().children().children()).val());
            fechaVenc = $($(celdas[1]).children().children().children()).attr("fechaVenc");
            tipoVenta = $($(celdas[1]).children().children().children()).attr("tipoVenta");
            saldo = (Number($($(celdas[9]).children().children().children()).val().replace(/\./g, '')) - pago);
            fechaPago = $("#txtFechaPago").val() + " " + hora;
            estadoCuenta = "Pendiente";
            nroMovimiento = Number($($(celdas[6]).children().children().children()).val());
            nroRecibo = Number($($(celdas[3]).children().children().children()).val());

            /*=============================================
                VERIFICAMOS EL TIPO DE RECIBO
            =============================================*/

            if (Number($($(celdas[4]).children().children().children().children(".chkAutomatico")).val()) == 1) {

                tipoRecibo = "Automatico";

            } else {

                tipoRecibo = "Manual";

            }

            /*=============================================
            VERIFICAMOS SI ES LA ULTIMA CUENTA PENDIENTE POR PAGAR
            =============================================*/

            if (saldo == 0) {

                estadoCuenta = "Cancelado";

            }

            /*================================================
            ESTOS TRES DATOS SE VAN A GUARDAR EN FORMATO JSON
            =================================================*/

            metodoPago = $($(celdas[5]).children().children().children(".selectPago"));
            nroComprobante = $($(celdas[6]).children().children().children(".form-control"));
            montoPagar = $($(celdas[8]).children().children().children(".form-control"));

            formaPago = listarDetalleCuentaLocalStorage(metodoPago, nroComprobante, montoPagar);

            // console.log(pago);
            // return;

            listaPago.push({
                "codCuenta": codCuenta,
                "codUsuario": codUsuario,
                "pago": pago,
                "codSucursal": codSucursal,
                "cantidad": cantidad,
                "fechaVenc": fechaVenc,
                "tipoVenta": tipoVenta,
                "saldo": saldo,
                "fechaPago": fechaPago,
                "estadoCuenta": estadoCuenta,
                "nroMovimiento": nroMovimiento,
                "nroRecibo": nroRecibo,
                "tipoRecibo": tipoRecibo,
                "formaPago": formaPago
            })

            // console.log(JSON.stringify(listaPago));

            localStorage.setItem("listaCuentasCobrar", JSON.stringify(listaPago));

            // console.log(formaPago);

        }

    }

}

/*========================================================
  AGREGAR CUENTA A PAGAR A LA GRILLA DESDE EL LOCALSTORAGE
=========================================================*/

var idCuentaSelect = 0;

function obtenerCuentaLocalStorage(listasCuentasCobrar) {

    /*========================================================
      RECORREMOS LA CANTIDAD DE CUENTAS A PAGAR PRECARGADOS
    =========================================================*/

    for (var i = 0; i < listasCuentasCobrar.length; i++) {

        // console.log(listasCuentasCobrar);
        // return;

        var formaPago = listasCuentasCobrar[i]["formaPago"];

        var cod_cuenta = listasCuentasCobrar[i]["codCuenta"];
        var montoCuota = listasCuentasCobrar[i]["pago"];
        var cantidad = listasCuentasCobrar[i]["cantidad"];
        var nroRecibo = parseInt(listasCuentasCobrar[i]["nroRecibo"]);
        var tipoRecibo = listasCuentasCobrar[i]["tipoRecibo"]
        var saldo = listasCuentasCobrar[i]["saldo"];
        var readOnly = "";
        var check = "";

        // console.log(nroRecibo);

        if (tipoRecibo == "Manual") {

            check = "0";

            if (nroRecibo == 0) {

                readOnly = "";
                nroRecibo = "";

            }

        } else {

            check = "1";

            if (nroRecibo == 0) {

                readOnly = "readonly = true";
                nroRecibo = "";

            }

        }

        /*=============================================
        OBTENEMOS LOS DATOS DE CUENTA A PAGAR
        =============================================*/

        idCuenta = idCuenta + 1; //CONTADOS POR CADA CUENTA AGREGADA

        var datos = new FormData();
        datos.append("codCuenta", cod_cuenta);

        // console.log(cod_cuenta);
        // return;

        $.ajax({

            url: "ajax/cuentasCobrar.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            async: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {

                // console.log(cantidad);
                // return;

                var cant = respuesta["CANT_CUOTA"];//CANTIDAD DE CUOTAS EN QUE SE FINANCIÓ
                var fechaVenc = respuesta["FECHA_VENCIMIENTO"];//CAPTURAMOS FECHA DE VENCIMIENTO PARA AGREGAR COMO ATRR
                var tipoVenta = respuesta["TIPO_VENTA"];
                var cuotaPagada = respuesta["CUOTA_PAGADA_DECIMAL"];
                var saldoFinal = respuesta["SALDO"];

                var cuotaRestante = cant - cuotaPagada;

                /*=======================================================================================
                VALIDAMOS QUE LA CANTIDAD DE CUOTAS INGRESADA NO SEA MAYOR A LA CANTIDAD PENDIENTE A PAGAR
                ========================================================================================*/

                if(cantidad > cuotaRestante){

                    cantidad = cuotaRestante;//si es mayor asignamos la cantidad de cuotas pendientes real

                    swal({
                      title: "Cantidad de cuotas a pagar excedida",
                      text: "¡Cuotas pendientes a agregar: "+cantidad+" !",
                      type: "warning",
                      confirmButtonText: "¡Aceptar!"
                    });

                }

                if(cantidad > 0){

                    var montoTotal = new Intl.NumberFormat("de-DE").format(montoCuota * cantidad);

                    /*=======================================================================================
                        AGREGAMOS LAS CUENTAS A LA TABLA
                    ========================================================================================*/

                    $("#tablaCuentaCobrar").append(

                        '<tr class="rowNuevo" id="row' + idCuenta + '">' +

                            '<!-- BOTON PARA QUITAR -->' +

                            '<td class="tdNuevoQuitar' + idCuenta + '">' +

                                '<div class="form-group nuevoQuitar' + idCuenta + '">' +

                                '<div class="input-group">' +

                                '<span class="input-group-addon">' +

                                '<button type="button" class="btn btn-danger btn-xs quitarCuenta" style="width:35px" idCuenta="' + idCuenta + '" idCuentaCobrar="' + cod_cuenta + '"><i class="fa fa-times"></i></button>' +

                                '</span>' +

                                '</div>' +

                                '</div>' +

                            '</td>' +

                            '<!-- Codigo de la cuenta -->' +

                            '<td class="tdNuevoCodigo' + idCuenta + ' notblock">' +

                                '<div class="form-group nuevoCodigo' + idCuenta + '">' +

                                '<div class="input-group" style="width: 100px">' +

                                '<input type="text" class="form-control nuevoCodigoCuenta" idCuenta="' + idCuenta + '" fechaVenc="' + fechaVenc + '" tipoVenta="' + tipoVenta + '" value="' + cod_cuenta.split("/", 2)[0] + '" readonly required>' +

                                '</div>' +

                                '</div>' +

                            '</td>' +

                            '<!-- CANTIDAD DE CUOTAS -->' +

                            '<td class="tdNuevoCantidad' + idCuenta + ' notblock">' +

                                '<div class="form-group nuevoCantidad' + idCuenta + ' notblock">' +

                                '<div class="input-group" style="width: 70px">' +

                                '<input type="text" class="form-control nuevaCantidadCuenta quitarCantidad' + idCuenta + '" idCuenta="' + idCuenta + '" cuotaPendiente="' + cantidad + '" name="" value="' + cantidad + '" onkeyup="format(this)" onchange="format(this)" readonly required>' +

                                '</div>' +

                                '</div>' +

                            '</td>' +

                            '<!-- N° RECIBO -->' +

                            '<td class="tdNuevoRecibo' + idCuenta + '">' +

                                '<div class="form-group nuevoRecibo' + idCuenta + '">' +

                                '<div class="input-group" style="width: 70px">' +

                                '<input type="text" class="form-control inputRecibo' + idCuenta + ' nuevoRecibo' + idCuenta + '" idCuenta="' + idCuenta + '" name="" value="' + nroRecibo + '"' + readOnly + ' required>' +

                                '</div>' +

                                '</div>' +

                            '</td>' +

                            '<!-- AUTOMATICO -->' +

                            '<td class="tdNuevoAutomatico' + idCuenta + '">' +

                                '<div class="form-group nuevoAutomatico' + idCuenta + '">' +

                                '<div class="animated-checkbox">' +

                                '<label id="lblFactura" class="control-label" style="margin-top: 8px">' +

                                '<input type="checkbox" class="chkAutomatico" value="' + check + '" name="chkOferta" id="chkAutomatico' + idCuenta + '" idCuenta="' + idCuenta + '""><span class="label-text"></span>' +

                                '</label>' +

                                '</div>' +

                                '</div>' +

                            '</td>' +

                        '</tr>');

                        if (tipoRecibo == "Manual") {

                            $("#chkAutomatico" + idCuenta).attr('checked', false);

                        } else {

                            $("#chkAutomatico" + idCuenta).attr('checked', true);

                        }

                        /*=======================================================================================
                            RECORREMOS LOS DETALLES DE LOS TIPOS DE PAGOS AGREGADOS POR CADA CUENTA
                        ========================================================================================*/

                        for (var i = 0; i < formaPago.length; i++) {

                                idCuentaSelect++;

                                if (i == 0) {

                                    // console.log(idCuenta);

                                    $("#row" + idCuenta).append(

                                        '<!-- TIPO DE PAGO-->' +

                                        '<td class="tdNuevoPago' + idCuenta + '">' +

                                        '<div class="form-group nuevoPago' + idCuenta + '" style="width: 200px">' +

                                        '<div class="input-group">' +

                                        '<select class="form-control selectPago" id="nuevoMetodoPago' + idCuentaSelect + '" name="nuevoMetodoPago" required>' +

                                        '<option value="">Seleccionar</option>' +

                                        '</select>' +

                                        '<div class="btn-group">' +

                                        '<button type="button" class="btn btn-success btn-sm agregarCobro" style="width:35px" idCuenta="' + idCuenta + '" montoTotal="' + montoTotal + '"><i class="fa fa-plus"></i></button>' +
                                        // '<button type="button" class="btn btn-danger btn-sm quitarCobro" style="width:35px" idCuenta="'+idCuenta+'"><i class="fa fa-trash"></i></button>'+

                                        '</div>' +

                                        '</div>' +

                                        '</div>' +

                                        '</td>' +

                                        '<!-- N° COMPROBANTE -->' +

                                        '<td class="tdNuevoComprobante' + idCuenta + '">' +

                                        '<div class="form-group nuevoComprobante' + idCuenta + '">' +

                                        '<div class="input-group" style="width: 100px">' +

                                        '<input type="text" class="form-control nuevoComprobante' + idCuenta + '" idCuenta="' + idCuenta + '" name="" value="' + formaPago[i]["nrotransaccion"] + '">' +

                                        '</div>' +

                                        '</div>' +

                                        '</td>' +

                                        '<!-- Monto de Cuota -->' +

                                        '<td class="tdNuevoMonto' + idCuenta + '">' +

                                        '<div class="form-group nuevoMonto' + idCuenta + '">' +

                                        '<div class="input-group" style="width: 100px">' +

                                        '<input type="text" class="form-control inputNuevoMonto' + idCuenta + '" idCuenta="' + idCuenta + '" name="" value="' + Intl.NumberFormat("de-DE").format(montoCuota) + '" readonly required>' +

                                        '</div>' +

                                        '</div>' +

                                        '</td>' +

                                        '<!-- Monto parcial -->' +

                                        '<td class="tdNuevoMontoParcial' + idCuenta + '">' +

                                        '<div class="form-group nuevoMontoParcial' + idCuenta + '">' +

                                        '<div class="input-group" style="width: 100px">' +

                                        '<input type="text" class="form-control inputNuevoMontoParcial inputMultiple' + idCuenta + '" idCuenta="' + idCuenta + '" name="" value="' + montoTotal + '" onkeyup="format(this)" onchange="format(this)" required>' +

                                        '</div>' +

                                        '</div>' +

                                        '</td>' +

                                        '<!-- Saldo -->' +

                                        '<td class="tdNuevoMontoSaldo' + idCuenta + '">' +

                                        '<div class="form-group nuevoMontoSaldo' + idCuenta + '">' +

                                        '<div class="input-group" style="width: 100px">' +

                                        '<input type="text" class="form-control nuevoMontoSaldoCuenta inputNuevoMontoSaldo' + idCuenta + '" idCuenta="' + idCuenta + '" name="" value="' + Intl.NumberFormat("de-DE").format((saldo + montoCuota)) + '" readonly required>' +

                                        '</div>' +

                                        '</div>' +

                                        '</td>'

                                    );

                                    /*=============================================
                                      CARGAR METODO DE PAGO
                                    =============================================*/

                                    cargarMetodoPagoLocalStorage(idCuentaSelect);

                                    $("#nuevoMetodoPago" + idCuentaSelect).val(formaPago[i]["id_metodo"]);

                                } else {

                                    // console.log(idCuenta);

                                    idPago = idCuenta;

                                    $(".tdNuevoPago" + idPago + "").append(

                                        '<!-- METODO DE PAGO -->' +

                                        '<div class="form-group nuevoPago' + idCuentaSelect + '" style="width: 200px">' +

                                        '<div class="input-group">' +

                                        '<select class="form-control selectPago" id="nuevoMetodoPago' + idCuentaSelect + '" name="nuevoMetodoPago" required>' +

                                        '<option value="">Seleccionar</option>' +

                                        '</select>' +

                                        '<div class="btn-group">' +

                                        // '<button type="button" class="btn btn-success btn-sm agregarCobro" style="width:35px" idCuenta="'+idCuenta+'"><i class="fa fa-plus"></i></button>'+
                                        '<button type="button" class="btn btn-danger btn-sm quitarCobro" style="width:35px" idCuenta="' + idCuentaSelect + '" idPago="' + idPago + '"><i class="fa fa-trash"></i></button>' +

                                        '</div>' +

                                        '</div>' +

                                        '</div>'

                                    );

                                    $(".tdNuevoComprobante" + idPago + "").append(

                                        '<div class="form-group nuevoComprobante' + idCuentaSelect + '">' +

                                        '<div class="input-group" style="width: 100px">' +

                                        '<input type="text" class="form-control nuevoComprobante' + idCuenta + '" idCuenta="' + idCuenta + '" name="" value="' + formaPago[i]["nrotransaccion"] + '">' +

                                        '</div>' +

                                        '</div>'

                                    );

                                    $(".tdNuevoMonto" + idPago + "").append(

                                        '<div class="form-group nuevoMonto' + idCuentaSelect + '">' +

                                        '<div class="input-group" style="width: 100px">' +

                                        '<input type="text" class="form-control inputNuevoMonto" idCuenta="' + idCuenta + '" name="agregarProducto" value="' + Intl.NumberFormat("de-DE").format(montoCuota) + '" readonly required>' +

                                        '</div>' +

                                        '</div>'

                                    );

                                    $(".tdNuevoMontoParcial" + idPago + "").append(

                                        '<div class="form-group nuevoMontoParcial' + idCuentaSelect + '">' +

                                        '<div class="input-group" style="width: 100px">' +

                                        '<input type="text" class="form-control inputNuevoMontoParcialSec inputMultiple' + idPago + '"" idCuenta="' + idCuenta + '" idPago="' + idPago + '" value="' + Intl.NumberFormat("de-DE").format(formaPago[i]["entrega"]) + '" onkeyup="format(this)" onchange="format(this)" required>' +

                                        '</div>' +

                                        '</div>'

                                    );

                                    $(".tdNuevoMontoSaldo" + idPago + "").append(

                                        '<div class="form-group nuevoMontoSaldo' + idCuentaSelect + '">' +

                                        '<div class="input-group" style="width: 100px">' +

                                        '<input type="text" class="form-control nuevoMontoSaldoCuenta inputNuevoMontoSaldo' + idCuenta + '" idCuenta="' + idCuenta + '" name="" value="' + Intl.NumberFormat("de-DE").format((saldo + montoCuota)) + '" readonly required>' +

                                        '</div>' +

                                        '</div>'

                                    );

                                    /*=============================================
                                      CARGAR METODO DE PAGO
                                    =============================================*/

                                    cargarMetodoPagoLocalStorage(idCuentaSelect);

                                    // console.log(formaPago[i]["metodoPago"]);

                                    $("#nuevoMetodoPago" + idCuentaSelect).val(formaPago[i]["id_metodo"]);

                                }


                        }

                            idCuenta = idCuentaSelect;

                            /*=============================================
                              SUMAR TOTAL DE PRECIOS
                            =============================================*/

                            sumarTotalCuentas();

            
                }

            }

        })

    }

}

/*==============================================================
LISTAR TODOS LOS DETALLES DE PAGO DE CUENTA PARA EL LOCALSTORAGE
===============================================================*/

function listarDetalleCuentaLocalStorage(pago, nroComprobante, montoPagar) {

    var listaDetalleCuentaLocalStorage = [];

    // console.log(pago.length);
    // return;

    for (var i = 0; i < pago.length; i++) {

        if ($(pago[i]).val() == "") {

            // console.log("VACIO");
            listaDetalleCuentaLocalStorage.push({
                "id_metodo": "",
                "entrega": $(montoPagar[i]).val().replace(/\./g, ''),
                "nrotransaccion": $(nroComprobante[i]).val()
            })

        } else {

            // console.log($(pago[i]).val().split("/", 0));

            listaDetalleCuentaLocalStorage.push({
                "id_metodo": $(pago[i]).val().split("/", 3)[0] + "/" + $(pago[i]).val().split("/", 3)[1],
                "entrega": $(montoPagar[i]).val().replace(/\./g, ''),
                "nrotransaccion": $(nroComprobante[i]).val()
            })

        }

    }

    return (listaDetalleCuentaLocalStorage);

}

/*=============================================
FUNCIÓN PARA CONSULTAR RANGO DE FECHAS
=============================================*/

function cantidadItems() {

    const tableRows = $('#tablaCuentaCobrar tr.rowNuevo');
    $('.Can').text(tableRows.length);
    $('.btncancelar').prop('disabled', false);

}

/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/

$('.tablaCuentasCobrar').on('draw.dt', function() {

    quitarAgregarCuenta();

})

/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/

$('.tablaListadoCuentas').on('draw.dt', function() {

    // console.log("ingresa");

    quitarAgregarCuentaListadoPrincipal();

})

/*===================================================================================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO LA CUENTA YA HABÍA SIDO SELECCIONADO EN LA CARPETA
====================================================================================================*/

function quitarAgregarCuenta() {

    //Capturamos todos los id de las cuentas que fueron elegidos en la venta
    var idCuenta = $(".quitarCuenta");

    //Capturamos todos los botones de agregar que aparecen en la tabla
    var botonesTabla = $(".tablaCuentasCobrar tbody button.agregarCuenta");

    //Recorremos en un ciclo para obtener los diferentes idCuentas que fueron agregados a la tabla de cobros
    for (var i = 0; i < idCuenta.length; i++) {

        //Capturamos los Id de las cuentas agregados a la tabla
        var boton = $(idCuenta[i]).attr("idCuentaCobrar");

        //Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
        for (var j = 0; j < botonesTabla.length; j++) {

            if ($(botonesTabla[j]).attr("idCuenta") == boton) {

                // $(botonesTabla[j]).removeClass("btn-primary agregarProducto");
                $(botonesTabla[j]).attr('disabled', 'disabled');

            }
        }

    }

}

/*===================================================================================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO LA CUENTA YA HABÍA SIDO SELECCIONADO EN LA CARPETA
====================================================================================================*/

function quitarAgregarCuentaListadoPrincipal() {

    //Capturamos todos los id de las cuentas que fueron elegidos en la venta
    var idCuenta = $(".quitarCuenta");

    //Capturamos todos los botones de agregar que aparecen en la tabla
    var botonesTabla = $(".tablaListadoCuentas tbody button.agregarCuentaListado");

    // console.log(idCuenta);
    // console.log(botonesTabla);

    //Recorremos en un ciclo para obtener los diferentes idCuentas que fueron agregados a la tabla de pagos
    for (var i = 0; i < idCuenta.length; i++) {

        //Capturamos los Id de las cuentas agregados a la tabla
        var boton = $(idCuenta[i]).attr("idCuentaCobrar");

        //Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
        for (var j = 0; j < botonesTabla.length; j++) {

            if ($(botonesTabla[j]).attr("idCuenta") == boton) {

                // $(botonesTabla[j]).removeClass("btn-primary agregarProducto");
                $(botonesTabla[j]).attr('disabled', 'disabled');

            }
        }

    }

}

/*=============================================
QUITAR CUENTAS DE LA TABLA Y RECUPERAR BOTÓN
=============================================*/
var idQuitarCuenta = [];

$(".formularioCobro").on('click', 'button.quitarCuenta', function(event) {

    var idCuenta = $(this).attr("idCuentaCobrar");

    /*=============================================
    ALMACENAR EN EL LOCALSTORAGE EL ID DE LA CUENTA A QUITAR
    =============================================*/

    if (localStorage.getItem("quitarCuenta") == null) {

        idQuitarCuenta = [];

    } else {

        idQuitarCuenta.concat(localStorage.getItem("quitarCuenta"))

    }

    idQuitarCuenta.push({
        "quitarCuenta": idCuenta
    });

    localStorage.setItem("quitarCuenta", JSON.stringify(idQuitarCuenta));

    $("button.recuperarBoton[idCuenta='" + idCuenta + "']").removeAttr('disabled');

    /*=============================================
    QUITAR LA FILA DE LA TABLA
    =============================================*/

    event.preventDefault();

    $(this).closest('tr').remove();

    sumarTotalCuentas();

    cargarLocalStorage();

    cantidadItems();

});

/*=====================================================
  EVENTO PARA OBTENER EL MONTO PARCIAL DE COBRO
======================================================*/

$(".formularioCobro").on("keyup", "input.inputNuevoMontoParcial", function() {

    var idCuenta = parseInt($(this).attr("idCuenta")); //obtenemos el id de la cuenta
    var montoSaldo = parseInt($(".inputNuevoMontoSaldo" + idCuenta).val().replace(/\./g, '')); //obtenemos el monto de la cuota total
    var diferencia = parseInt(montoSaldo - recuperarSumaTotalxCuenta(idCuenta));

    // console.log(diferencia);

    if (diferencia == 0) {

        $(this).parent().parent().parent().parent().children(".tdNuevoPago" + idCuenta).children(".nuevoPago" + idCuenta).children().children(".btn-group").children().attr('disabled', 'disabled');

    } else if (diferencia < 0) {

        $(this).val("0");

        diferencia = parseInt(montoSaldo - recuperarSumaTotalxCuenta(idCuenta));

        $(this).val(new Intl.NumberFormat("de-DE").format(diferencia));
        $(this).parent().parent().parent().parent().children(".tdNuevoPago" + idCuenta).children(".nuevoPago" + idCuenta).children().children(".btn-group").children().attr('disabled', 'disabled');

    } else {

        $(this).parent().parent().parent().parent().children(".tdNuevoPago" + idCuenta).children(".nuevoPago" + idCuenta).children().children(".btn-group").children().removeAttr('disabled');

    }

    cargarLocalStorage();
    sumarTotalCuentas();


});

/*=====================================================
EVENTO PARA OBTENER EL MONTO PARCIAL DE PAGO SECUNDARIO
======================================================*/

$(".formularioCobro").on("keyup", "input.inputNuevoMontoParcialSec", function() {

    var idCuenta = parseInt($(this).attr("idCuenta")); //obtenemos el id de la cuenta
    var idPago = parseInt($(this).attr("idPago")); //obtenemos el id de pago de la cuenta
    var montoSaldo = parseInt($(".inputNuevoMontoSaldo" + idCuenta).val().replace(/\./g, '')); //obtenemos el saldo de la cuenta
    var diferencia = parseInt(montoSaldo - recuperarSumaTotalxCuenta(idPago)); //calculamos el total de pagos parciales y restamos del saldo

    if (diferencia == 0) {

        $(this).parent().parent().parent().parent().children(".tdNuevoPago" + idPago).children(".nuevoPago" + idPago).children().children(".btn-group").children().attr('disabled', 'disabled');

    } else if (diferencia < 0) {

        $(this).val("0");

        diferencia = parseInt(montoSaldo - recuperarSumaTotalxCuenta(idPago));

        $(this).val(new Intl.NumberFormat("de-DE").format(diferencia));
        $(this).parent().parent().parent().parent().children(".tdNuevoPago" + idPago).children(".nuevoPago" + idPago).children().children(".btn-group").children().attr('disabled', 'disabled');

    } else {

        $(this).parent().parent().parent().parent().children(".tdNuevoPago" + idPago).children(".nuevoPago" + idPago).children().children(".btn-group").children().removeAttr('disabled');

    }

    sumarTotalCuentas();

});

/*=============================================
  METODOS PARA VALIDAR EL INGRESO DE PAGOS (2)
=============================================*/

function recuperarSumaTotalxCuenta(id) {

    let selects = $('.inputMultiple' + id);
    var c = 0;
    var sumaPagos = 0;

    selects.each(function() {

        let select = $(this);

        // console.log("*" + select.val());
        sumaPagos = sumaPagos + parseInt(select.val().replace(/\./g, ''));


    });

    // console.log("SUMA TOTAL: " + sumaPagos);
    return (sumaPagos);

}

/*=============================================
  AGREGAR OTRO METODO DE PAGO A LA CUENTA
=============================================*/

$(document).on("click", ".agregarCobro", function() {

    // $(this).attr('disabled', 'disabled');

    agregarCobro($(this).attr("idCuenta"));

    cargarMetodoPago(idCuenta);

    sumarTotalCuentas();

});

/*=============================================
FUNCION AGREGAR ENTRADA PARA PAGOS
=============================================*/

function agregarCobro(idPago) {

    var montoCuota = new Intl.NumberFormat("de-DE").format($(".tdNuevoMonto" + idPago).children(".nuevoMonto" + idPago).children().children().val().replace(/\./g, ''));
    var montoPagar = $(".tdNuevoMontoParcial" + idPago).children(".nuevoMontoParcial" + idPago).children().children().val().replace(/\./g, '');
    // var montoTotal = parseInt($(".tdNuevoMontoTotal"+idPago).children(".nuevoMontoTotal"+idPago).children().children().val().replace(/\./g,''));
    var montoSaldo = parseInt($(".tdNuevoMontoSaldo" + idPago).children(".nuevoMontoSaldo" + idPago).children().children().val().replace(/\./g, ''));
    // var diferencia = new Intl.NumberFormat("de-DE").format(parseInt(montoSaldo - recuperarSumaTotalxCuenta(idPago)));

    // console.log(diferencia);

    $(".quitarCantidad" + idPago).attr('readonly', true);

    idCuenta = idCuenta + 1;

    $(".tdNuevoPago" + idPago + "").append(

        '<!-- METODO DE PAGO -->' +

        '<div class="form-group nuevoPago' + idCuenta + '" style="width: 200px">' +

        '<div class="input-group">' +

        '<select class="form-control selectPago" id="nuevoMetodoPago' + idCuenta + '" name="nuevoMetodoPago" required>' +

        '<option value="">Seleccionar</option>' +

        '</select>' +

        '<div class="btn-group">' +

        '<button type="button" class="btn btn-danger btn-sm quitarCobro" style="width:35px" idCuenta="' + idCuenta + '" idPago="' + idPago + '"><i class="fa fa-trash"></i></button>' +

        '</div>' +

        '</div>' +

        '</div>'

    );

    $(".tdNuevoComprobante" + idPago + "").append(

        '<div class="form-group nuevoComprobante' + idCuenta + '">' +

        '<div class="input-group" style="width: 100px">' +

        '<input type="text" class="form-control nuevoComprobante' + idCuenta + '" idCuenta="' + idCuenta + '" name="" value="">' +

        '</div>' +

        '</div>'

    );

    $(".tdNuevoMonto" + idPago + "").append(

        '<div class="form-group nuevoMonto' + idCuenta + '">' +

        '<div class="input-group" style="width: 100px">' +

        '<input type="text" class="form-control inputNuevoMonto" idCuenta="' + idCuenta + '" name="agregarProducto" value="' + montoCuota + '" readonly required>' +

        '</div>' +

        '</div>'

    );

    $(".tdNuevoMontoParcial" + idPago + "").append(

        '<div class="form-group nuevoMontoParcial' + idCuenta + '">' +

        '<div class="input-group" style="width: 100px">' +

        '<input type="text" class="form-control inputNuevoMontoParcialSec inputMultiple' + idPago + '"" idCuenta="' + idCuenta + '" idPago="' + idPago + '" value="" onkeyup="format(this)" onchange="format(this)" required>' +

        '</div>' +

        '</div>'

    );

    $(".tdNuevoMontoSaldo" + idPago + "").append(

        '<div class="form-group nuevoMontoSaldo' + idCuenta + '">' +

        '<div class="input-group" style="width: 100px">' +

        '<input type="text" class="form-control nuevoMontoSaldoCuenta inputNuevoMontoSaldo' + idCuenta + '" idCuenta="' + idCuenta + '" name="" value="' + new Intl.NumberFormat("de-DE").format(montoSaldo) + '" readonly required>' +

        '</div>' +

        '</div>'

    );

}

/*=============================================
  QUITAR METODO DE PAGO DE UNA CUENTA
=============================================*/

$(".formularioCobro").on("click", "button.quitarCobro", function() {

    var idPago = $(this).attr("idPago");
    var idCuenta = $(this).attr("idCuenta");

    // console.log(idPago);
    // console.log(idCuenta);
    // return;

    var montoInicial = parseInt($(".tdNuevoMontoParcial" + idPago).children().children().children().val().replace(/\./g, ''));
    var montoPagar = parseInt($(this).parent().parent().parent().parent().parent().children(".tdNuevoMontoParcial" + idPago).children(".nuevoMontoParcial" + idCuenta).children().children().val().replace(/\./g, ''));
    var montoTotal = parseInt($(".tdNuevoMontoTotal" + idPago).children(".nuevoMontoTotal" + idPago).children().children().val());

    var montoAjuste = new Intl.NumberFormat("de-DE").format(reajustarSumaPagos(montoPagar, montoInicial, idPago));

    // console.log(restaPagos);

    $(".nuevoAutomatico" + idCuenta).remove();
    $(".nuevoRecibo" + idCuenta).remove();
    $(".nuevoComprobante" + idCuenta).remove();

    $(".nuevoMontoParcial" + idCuenta).remove(); //SE QUITA ASI
    $(".nuevoMonto" + idCuenta).remove();
    $(".nuevoMontoTotal" + idCuenta).remove();
    $(".nuevoMontoSaldo" + idCuenta).remove();
    $(this).parent().parent().parent().remove()

    $(".tdNuevoMontoParcial" + idPago).children(".nuevoMontoParcial" + idPago).children().children().val(montoAjuste);
    $(".tdNuevoPago" + idPago).children(".nuevoPago" + idPago).children().children(".btn-group").children().attr("montoCuota", new Intl.NumberFormat("de-DE").format(montoPagar));

    cargarLocalStorage();
});

/*=============================================
  METODO PARA REAJUSTAR SUMA DE PAGOS
=============================================*/

function reajustarSumaPagos(montoPagar, montoInicial, id) {

    let selects = $('.inputMultiple' + id);
    var c = 0;
    var sumaPagos = 0;

    selects.each(function() {

        let select = $(this);

        if (parseInt(select.val().replace(/\./g, '')) == montoPagar && c < 1) {

            // console.log("*" + select.val());
            sumaPagos = sumaPagos + parseInt(select.val().replace(/\./g, ''));
            c = c + 1;

        }

    });

    // console.log("SUMA: " + sumaPagos);
    return (montoInicial + sumaPagos);

}
/*====================================================
  CARGAR REGISTROS DEL LOCALSTORAGE
=====================================================*/
$(document).ready(function() {

    agregarFecha();

    if (localStorage.getItem("listaCuentasCobrar") != null && estadoNuevo == false) {

        var sucursal = $("#idSucursal").val();

        var listasCuentasCobrar = JSON.parse(localStorage.getItem("listaCuentasCobrar"));

        obtenerCuentaLocalStorage(listasCuentasCobrar);

        quitarAgregarCuentaListadoPrincipal();

        cantidadItems();

        estadoNuevo = true;

    }

    setInterval(function() {

        if ($('.cargarCuentasCobrar').is(':visible')) {

            // console.log("ingresa");

            if (localStorage.getItem("listaCuentasCobrar") != null) {
                cargarLocalStorage();
            }

        }

    }, 4000);

    cantidadItems();

});

/*====================================================
  FUNCION PARA CARGAR FECHA
=====================================================*/
function agregarFecha() {

    var now = new Date();

    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var today = now.getFullYear() + "-" + (month) + "-" + (day);

    $("#txtFechaPago").val(today);

}

/*=============================================
  MOSTRAR DETALLES DE LA CUENTA
=============================================*/

$(document).on("click", ".verDetallesCuenta", function() {

    var idCuenta = $(this).attr("idCuenta");

    $(".tablaCuentaDetalle").DataTable().ajax.url("ajax/tablaDetallesCuentasCobrar.ajax.php?codCuentaDetCobro=" + idCuenta).load();

    var datos = new FormData();

    datos.append("codCuentaCabecera", idCuenta);

    $.ajax({

        url: "ajax/cuentasCobrar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

            // console.log(respuesta);
            // return;

            $("#txtCli").val(respuesta["CLIENTE"]);
            $("#txtUsuario").val(respuesta["NOMBRE_FUNC"]);
            $("#txtSucursal").val(respuesta["SUCURSAL"]);
            $("#txtNroFactura").val(respuesta["NRO_MOVIMIENTO"] + "   " + respuesta["TIPO_MOVIMIENTO"]);
            $("#txtFechaVenta").val(respuesta["FECHA_VENTA"]);
            $("#txtTipoPago").val(respuesta["FORMA_PAGO"]);
            $("#txtTotalVenta").val(new Intl.NumberFormat("de-DE").format(parseInt(respuesta["TOTAL_VENTA"])));

        }

    })

})

/*=============================================
  MOSTRAR HISTORIAL DE LA CUENTA
=============================================*/

$(document).on("click", ".historialCuenta", function() {

    var idCuenta = $(this).attr("idCuenta");
    $('#agregarComentario').attr("idCuenta", idCuenta);

    // mostrarDatosProveedor(idCuenta);

    mostrarCabeceraHistorial(idCuenta);

    $(".tablaCuentaHistorial").DataTable().ajax.url("ajax/tablaHistorialCuentasCobrar.ajax.php?codCuentaHistorialPago=" + idCuenta).load();

})

/*=============================================
  MOSTRAR DATOS DEL CLIENTE SEGÚN CUENTA
=============================================*/

function mostrarDatosProveedor(idCuenta) {

    var datos = new FormData();

    // console.log(idCuenta);

    datos.append("codCuentaCliente", idCuenta);

    $.ajax({

        url: "ajax/cuentasCobrar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

            // console.log(respuesta);
            // return;

            $("#txtCliente").val(respuesta[0]["CLIENTE"]);
            $("#txtRuc").val(respuesta[0]["RUC"]);
            $("#txtTelefono").val(respuesta[0]["CELULAR"]);
            $("#txtTotal").val(new Intl.NumberFormat("de-DE").format(respuesta[0]["TOTAL_CUENTA"]));
            $("#txtComentario").val(respuesta[0]["OBSERVACIONES"]);

        }

    })

}

/*=================================================
 FUNCION PARA MOSTRAR HISTORIAL DE COBRO DE LA CUENTA
==================================================*/

function mostrarCabeceraHistorial(idCuenta) {

    var datos = new FormData();

    datos.append("codCuentaFecha", idCuenta);

    $.ajax({

        url: "ajax/cuentasCobrar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

            // console.log(respuesta);
            // return;

            $("#txtCliente").val(respuesta[0]["CLIENTE"]);
            $("#txtRuc").val(respuesta[0]["RUC"]);
            $("#txtTelefono").val(respuesta[0]["CELULAR"]);
            $("#txtTotal").val(new Intl.NumberFormat("de-DE").format(respuesta[0]["TOTAL_CUENTA"]));
            $("#txtComentario").val(respuesta[0]["OBSERVACIONES"]);

            /*================================================
            CALCULAR DIFERENCIA DE FECHAS PARA DIAS DE ADELANTO
            =================================================*/

            var diasAdelanto = 0

            for (var i = 0; i < respuesta.length; i++) {

                if (respuesta[i]["DET_MOVIMIENTO"] == "PAGO") {

                    diasAdelanto += parseInt(calcularDiferenciaFecha(respuesta[i]["FECHA_VENC"], respuesta[i]["FECHA_PAGO"].split(" ", 1), respuesta[i]["PAGO"]));

                }

                // console.log(diasAdelanto);

            }

            $("#txtDiasAdelanto").text(diasAdelanto);

            if (diasAdelanto > 0) {

                $("#txtDiasAdelanto").css("color", "green");

            } else if (diasAdelanto < 0) {

                $("#txtDiasAdelanto").css("color", "red");

            } else {

                $("#txtDiasAdelanto").css("color", "orange");

            }

        }

    })

}

/*================================================
FUNCION PARA CALCULAR LA DIFERENCIA ENTRE 2 FECHAS
=================================================*/

function calcularDiferenciaFecha(fechaVenc, fechaPago, pago) {

    // console.log(pago);

    var fechaVen = new Date(fechaVenc).getTime();
    var fechaPag = new Date(fechaPago[0]).getTime();

    var diff = fechaVen - fechaPag;

    if (parseInt(pago) < 0) {

        // console.log((diff/(1000*60*60*24))*(-1));

        return ((diff / (1000 * 60 * 60 * 24)) * (-1));


    } else {

        // console.log(diff/(1000*60*60*24));

        return (diff / (1000 * 60 * 60 * 24));

    }

}

/*=============================================
MODIFICAR COMENTARIO DE LA CUENTA
=============================================*/

$(document).on("click", "#agregarComentario", function() {

    // alert("agregar comentario");
    // return;

    var idCuenta = $(this).attr("idCuenta");
    var comentario = $("#txtComentario").val();

    // console.log(idCuenta);
    // console.log(comentario);
    // return;

    var datos = new FormData();

    datos.append("codCuentaComentario", idCuenta);
    datos.append("comentario", comentario);

    $.ajax({

        url: "ajax/cuentasCobrar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        async: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

            objData = JSON.parse(JSON.stringify(respuesta));

            if (objData.status) {

                swal("success", objData.msg, "success");

            } else {

                swal("Error", objData.msg, "error");

            }

            // console.log(respuesta[""]);
            // return;


        }

    })

    return (false);

})

/*=============================================
  ANULAR PAGO
=============================================*/

$(".tablaCuentaHistorial").on("click", "button.anularPago", function() {

    var idCuenta = $(this).attr("idCuenta");
    var idCuentaCab = $(this).attr("idCuentaCab");

    // alert(idCuenta);
    // return;

    var datos = new FormData();

    datos.append("codCuentaDet1", idCuenta);

    $.ajax({

        url: "ajax/cuentasCobrar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        async: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

            // console.log(respuesta);
            // return;

            var hoy = new Date();;
            var fecha = hoy.getFullYear() + '-' + (hoy.getMonth() + 1) + '-' + hoy.getDate();
            var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
            var fechaYHora = fecha + ' ' + hora;

            var codCuenta = respuesta["COD_CUENTA"];
            var codUsuario = Number($("#idUsuario").val().split("/", 1));
            var pago = "-" + respuesta["PAGO"];
            var fechaVenc = respuesta["FECHA_VENC"];
            var saldo = respuesta["SALDO"];
            var fechaPago = fechaYHora;
            var estadoCuenta = respuesta["ESTADO_CUENTA"];
            var formaPago = (pagosNegativo(JSON.parse(respuesta["FORMAPAGO"])));
            var nroMovimiento = "";
            var nroRecibo = respuesta["NRO_RECIBO"];
            var tipoRecibo = respuesta["TIPO_RECIBO"];
            var agruparAnulado = respuesta["AGRUPAR_ANULADO"];
            var detMovimiento = "ANULADO";
            var codCaja = respuesta["COD_CAJA"];
            var codApertura = respuesta["COD_APERTURA"];

            if (respuesta["NRO_MOVIMIENTO"] != null) {

                nroMovimiento = respuesta["NRO_MOVIMIENTO"];

            }

            // console.log(" COD_CUENTA: " + codCuenta + " COD_USUARIO: "+ codUsuario + " PAGO: " + pago + " FECHA_VENC: " + fechaVenc + " SALDO: " + saldo + " FECHA_PAGO: " + fechaPago + " ESTADO_CUENTA: " + estadoCuenta + " NRO_MOVIMIENTO: " + nroMovimiento + " NRO_RECIBO: " + nroRecibo + " TIPO_RECIBO: " + tipoRecibo + " DET_MOVIMIENTO: " + detMovimiento + " AGRUPAR_ANULADO: " + agruparAnulado);
            // return;
            if (Object.keys(respuesta).length > 0) {

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
                        divLoading.style.display = "flex";
                        anularPago(codCuenta, codUsuario, pago, fechaVenc, saldo, fechaPago, estadoCuenta, formaPago, nroMovimiento, nroRecibo, tipoRecibo, agruparAnulado, detMovimiento, idCuentaCab, idCuenta, codCaja, codApertura);
                        divLoading.style.display = "none";
                    }

                })

            } else {

                // alert("NO SE OBTUVIERON LOS DATOS" + Object.keys(respuesta).length);
                swal("Error", "NO SE OBTUVIERON LOS DATOS", "error");

            }

        }

    })

    return (false);

})

/*=============================================
PONER EN NEGATIVO LOS PAGOS
=============================================*/

function pagosNegativo(formaPago) {

    var listaPagoNegativo = [];

    // console.log(formaPago);
    // return;

    for (var i = 0; i < formaPago.length; i++) {

        listaPagoNegativo.push({
            "id_metodo": formaPago[i]["id_metodo"],
            "entrega": "-" + formaPago[i]["entrega"],
            "nrotransaccion": formaPago[i]["nrotransaccion"]
        })

    }


    return (JSON.stringify(listaPagoNegativo));

}

/*====================================================
  FUNCION PARA ANULAR PAGO
=====================================================*/

function anularPago(codCuenta, codUsuario, pago, fechaVenc, saldo, fechaPago, estadoCuenta, formaPago, nroMovimiento, nroRecibo, tipoRecibo, agruparAnulado, detMovimiento, idCuentaCab, tokenCuentaDet, codCaja, codApertura) {

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
    datos.append("txtCodCaja", codCaja);
    datos.append("txtCodApertura", codApertura);

    $.ajax({

        url: "ajax/cuentasCobrar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        async: false,
        dataType: "json",
        success: function(respuesta) {

            var objData = JSON.parse(JSON.stringify(respuesta));

            if (objData.status) {

                swal("success", objData.msg, "success");

                $(".tablaCuentaHistorial").DataTable().ajax.url("ajax/tablaHistorialCuentasCobrar.ajax.php?codCuentaHistorialPago=" + idCuentaCab).load();

                mostrarCabeceraHistorial(idCuentaCab);

                $(".tablaCuentasCobrar").DataTable().ajax.url("ajax/tablaCuentasCobrar.ajax.php?sucursal=" + $("#idSucursal").val() + "&cliente=" + $("#cmbClienteCuentas").val()).load();
                $('#tablaListadoCuentas').DataTable().ajax.reload();

            } else {

                swal("Error", objData.msg, "error");

            }

        }

    })

    return (false);

}

/*=============================================
  METODO PARA ACTIVAR O DESACTIVAR AUTOMATICO
=============================================*/

$(".formularioCobro").on("click", "input.chkAutomatico", function() {


    var idCuenta = $(this).attr("idCuenta");

    // alert("ingresa" + idCuenta);

    if ($(this).is(':checked')) {

        // alert("checked");
        $(this).val("1");
        $('.nuevoRecibo' + idCuenta).attr('readonly', true);
        $('.nuevoRecibo' + idCuenta).val("");


    } else {

        // alert("no checked");

        $(this).val("0");
        $('.nuevoRecibo' + idCuenta).attr('readonly', false);
        $('.nuevoRecibo' + idCuenta).val("");
        $('.nuevoRecibo' + idCuenta).focus();

    }

    cargarLocalStorage();

});

/*=============================================
  GUARDAR FORMULARIO
=============================================*/

var listaCuenta = [];

function guardarFormulario() {

    // imprimirTicket();
    // return false;

    // alert($("#tablaCuentaPagar").find("tr.rowNuevo").length);
    // return;

    if ($("#tablaCuentaCobrar").find("tr.rowNuevo").length < 1) {

        swal({

            title: "Cargue una cuenta",
            type: "error",
            confirmButtonText: "¡Cerrar!"

        })

        return false;

    }

    swal({

        title: '¿Está seguro de guardar este registro?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, guardar cobro!',
        closeOnConfirm: false,
        closeOnCancel: true

    }, function(isConfirm) {

        if (isConfirm) {

            // divLoading.style.display = "flex";

            const tableRows = $('#tablaCuentaCobrar tr');

            var codCuenta;
            var codUsuario;
            var pago;
            var metodoPago;
            var fechaVenc;
            var saldo;
            var fechaPago;
            var estadoCuenta;
            var nroMovimiento;
            var nroRecibo;
            var tipoRecibo;
            var detMovimiento;
            var tipoVenta;
            var codCaja;
            var codApertura;

            /*=============================================
              DEVUELVE LAS FILAS DEL BODY DE LA TABLA
            =============================================*/

            var nfilas = $("#tablaCuentaCobrar").find("tr.rowNuevo");
            listaCuenta = [];

            // alert(nfilas.length);
            // return;

            //Recorre las filas 1 a 1
            for (var i = 0; i < nfilas.length; i++) {

                //devolverá las celdas de una fila
                var celdas = $(nfilas[i]).find("td");

                cantidad = Number($($(celdas[2]).children().children().children()).val());

                /*===============================================
                RECUPERAMOS LOS DATOS DE CADA CELDA POR CADA FILA
                ===============================================*/

                var hoy = new Date();
                var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();

                codCuenta = $($(celdas[1]).children().children().children()).val();
                codUsuario = Number($("#idUsuario").val().split("/", 1));
                codSucursal = Number($("#idSucursal").val().split("/", 1));
                fechaVenc = $($(celdas[1]).children().children().children()).attr("fechaVenc");
                tipoVenta = $($(celdas[1]).children().children().children()).attr("tipoVenta");
                fechaPago = $("#txtFechaPago").val() + " " + hora;
                estadoCuenta = "Pendiente";
                nroMovimiento = Number($($(celdas[6]).children().children().children()).val());
                nroRecibo = Number($($(celdas[3]).children().children().children()).val());
                codCaja = $("#idCaja").val();
                codApertura = $("#idApertura").val()

                /*=============================================
                  VERIFICAMOS EL TIPO DE RECIBO
                =============================================*/

                if (Number($($(celdas[4]).children().children().children().children(".chkAutomatico")).val()) == 1) {

                    tipoRecibo = "AUTOMATICO";

                } else {

                    tipoRecibo = "MANUAL";

                }

                /*================================================
                  ESTOS TRES DATOS SE VA A GUARDAR EN FORMATO JSON
                =================================================*/

                metodoPago = $($(celdas[5]).children().children().children(".selectPago"));
                nroComprobante = $($(celdas[6]).children().children().children(".form-control"));
                montoPagar = $($(celdas[8]).children().children().children(".form-control"));

                pago = sumarCuenta(metodoPago, montoPagar);
                saldo = (Number($($(celdas[9]).children().children().children()).val().replace(/\./g, '')));

                formaPago = listarDetalleCuenta(metodoPago, nroComprobante, montoPagar, cantidad);
                // console.log(fechaVenc);
                // return;

                listaCuenta.push({
                        "codCuenta": codCuenta,
                        "codUsuario": codUsuario,
                        "pago": pago,
                        "fechaVenc": fechaVenc,
                        "saldo": saldo,
                        "fechaPago": fechaPago,
                        "estadoCuenta": estadoCuenta,
                        "nroMovimiento": nroMovimiento,
                        "nroRecibo": nroRecibo,
                        "tipoRecibo": tipoRecibo,
                        "formaPago": formaPago,
                        "tipoVenta": tipoVenta,
                        "cantidad": cantidad,
                        "codCaja": codCaja,
                        "codApertura": codApertura,
                        "cantidad": nfilas.length
                        
                })

                // guardarPago(codCuenta, codUsuario, pago, fechaVenc, saldo, fechaPago, estadoCuenta, nroMovimiento, nroRecibo, tipoRecibo, formaPago, tipoVenta, cantidad, codCaja, codApertura);

                // divLoading.style.display = "none";

                // console.log("CANTIDAD: " +  cantidad + " COD_CUENTA: " + codCuenta + " COD_USUARIO: "+ codUsuario + " PAGO: " + pago + " FECHA_VENC: " + fechaVenc + " SALDO: " + saldo + " FECHA_PAGO: " + fechaPago + " ESTADO_CUENTA: " + estadoCuenta + " NRO_MOVIMIENTO: " + nroMovimiento + " NRO_RECIBO: " + nroRecibo + " TIPO_RECIBO: " + tipoRecibo + " formaPago: " + formaPago + " TIPO_VENTA: " + tipoVenta);

            }

            guardarPago(JSON.stringify(listaCuenta));

            divLoading.style.display = "none";

        }

    })

    return (false);

}

/*=============================================
    SUMAR EL TOTAL A COBRAR DE CADA CUENTA
=============================================*/

function sumarCuenta(metodoPago, montoPagar) {

    var total = 0;

    for (var i = 0; i < metodoPago.length; i++) {

        total = total + parseInt($(montoPagar[i]).val().replace(/\./g, ''));

    }

    return (total);

}


/*=============================================
LISTAR TODOS LOS DETALLES DE COBRO DE CUENTA
=============================================*/

function listarDetalleCuenta(pago, nroComprobante, montoPagar, cantidad) {

    var listaDetalleCuenta = [];

    // console.log(montoPagar);

    for (var i = 0; i < pago.length; i++) {

        listaDetalleCuenta.push({
            "id_metodo": $(pago[i]).val().split("/", 3)[0] + "/" + $(pago[i]).val().split("/", 3)[1],
            "entrega": $(montoPagar[i]).val().replace(/\./g, ''),
            "nrotransaccion": $(nroComprobante[i]).val()
        })

    }

    // $("#listaDetalleCuenta").val(JSON.stringify(listaDetalleCuenta));

    return JSON.stringify(listaDetalleCuenta);

}

/*====================================================
  OBTENEMOS LOS DATOS DE CUENTA A PAGAR Y LO GUARDAMOS
=====================================================*/

function guardarPago(listaCuenta) {

    // console.log((listaCuenta));
    // return;

    var datos = new FormData();
    datos.append("txtPago", listaCuenta);
    // datos.append("txtCodUsuario", codUsuario);
    // datos.append("txtPago", pago);
    // datos.append("txtFechaVenc", fechaVenc);
    // datos.append("txtSaldo", saldo);
    // datos.append("txtFechaPago", fechaPago);
    // datos.append("txtEstadoCuenta", estadoCuenta);
    // datos.append("txtNroMovimiento", nroMovimiento);
    // datos.append("txtNroRecibo", nroRecibo);
    // datos.append("txtTipoRecibo", tipoRecibo);
    // datos.append("txtFormaPago", formaPago);
    // datos.append("txtTipoVenta", tipoVenta);
    // datos.append("txtCodCaja", codCaja);
    // datos.append("txtCodApertura", codApertura);


    $.ajax({

        url: "ajax/cuentasCobrar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        async: false,
        dataType: "json",
        success: function(respuesta) {

            var objData = JSON.parse(JSON.stringify(respuesta));

            if (objData.status) {

                swal("success", objData.msg, "success");

                localStorage.removeItem("listaCuentasCobrar");

                imprimirTicket(objData);

                divLoading.style.display = "none";
                location.reload();

            } else {

                swal("Error", objData.msg, "error");

            }

        }

    })

    return (false);

}

/*==========================================================
      IMPRIMIR TICKET
============================================================*/

function imprimirTicket(objData){

  /*==========================================================
      CONFIGURACIÓN DEL TAMAÑO DE PANTALLA
  ============================================================*/

    var mywindow = window.open('', 'PRINT', 'height=400, width=600');

    /*==========================================================
      CABECERA DEL TICKET
    ============================================================*/

    var detalleCuenta = JSON.parse(objData.CODIGO_DETALLE);
    var codCuenta = JSON.parse(objData.CODIGO_CUENTA);

    // console.log(detalleCuenta);
    // console.log(codCuenta);

    var objDataCab;
    var objDataDet;
    var totalDeuda;
    var totalPagado;
    var fechaPago;
    var fechaVenc;
    var montoCuota;
    var saldoAnt;
    var cantCuota;
    var cuotaPagada;
    var nroRecibo;

    var datos = new FormData();
    datos.append("txtCabeceraTicket", detalleCuenta[0]);

    $.ajax({

        url: "ajax/cuentasCobrar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        async: false,
        contentType: false,
        processData: false,

        success: function(respuesta) {

            objDataCab = JSON.parse(respuesta);

            // console.log(objDataCab);

        }

    })


    mywindow.document.write(

      '<FONT FACE="arial">'+

      '<table style="font-size:17px; text-align:center"'+
    
        '<tr>'+

            '<td>'+

                '<br>'+

                objDataCab["NOMBRE_EMPRESA"]+

                '<br>'+

                'De '+objDataCab["PROPIETARIO_EMPRESA"]+

                '<br>'+

                'RUC: '+objDataCab["RUC_EMPRESA"]+

                '<br>'+

                'Teléfonos: '+objDataCab["TELEFONO_SUC"]+

                '<br>'+

                'Dirección: '+objDataCab["DIRECCION"]+

                '<br>'+

                '============================================'+
                '<br>'+
                '<b>RECIBO DE DINERO</b>'+
                '<br>'+
                '============================================'+
              
                '<br>'+

                '<div style="font-size:17px; text-align:left">'+

                    'Cajero: '+objDataCab["NOMBRE_FUNC"]+

                    '<br>'+

                    'Fecha: '+objDataCab["FECHA_PAGO"]+

                    '<br>'+

                    'Cliente: '+objDataCab["CLIENTE"]+

                    '<br>'+

                    'RUC/C.I.N°: '+objDataCab["RUC_CLIENTE"]+

                    '<br>'+

                    'N° Factura: '+objDataCab["NRO_MOVIMIENTO"]+

                '</div>'+

            '</td>'+

        '</tr>'+

    '</table>'

    );


    for (var i = 0; i < detalleCuenta.length; i++) {

        mywindow.document.write(

    '<table style="font-size:17px">'+

        '<tr style="text-align:center">'+

            '<td>'+

                '============================================'+
                '<br>'+

                '<b>CONCEPTO DE PRODUCTOS</b>'+

            '</td>'+

        '</tr>'+

        '<tr>'+

            '<td>'+

                '<table>'

        );


        var datos = new FormData();
        datos.append("txtDetalleTicket", detalleCuenta[i]); 
        datos.append("txtCodCuentaCobrar", codCuenta[i]);

        $.ajax({

            url: "ajax/cuentasCobrar.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            async: false,
            contentType: false,
            processData: false,

            success: function(respuesta) {

                objDataProd = JSON.parse(respuesta);

                var productos = objDataProd["DESCRIPCION"].split('||');

                // console.log(objDataProd);

                totalDeuda = objDataProd["TOTAL_CUENTA"];
                totalPagado = objDataProd["MONTO_PAGADO"];
                fechaPago = objDataProd["FECHA_PAGO"];
                fechaVenc = objDataProd["FECHA_VENC"];
                montoCuota = objDataProd["MONTO_CUOTA"];
                saldoAnt = objDataProd["SALDO_ANT"];
                pagoCuota = objDataProd["PAGO"];
                saldoAct = objDataProd["SALDO"];
                cantCuota = objDataProd["CANT_CUOTA"];
                cuotaPagada = parseInt(objDataProd["CUOTA_PAGADA"]);
                nroRecibo =  objDataProd["NRO_RECIBO"];

                for (var i = 0; i < productos.length; i++) {

                    // console.log(objDataProd[i]["DESCRIPCION"]);

                    mywindow.document.write(

                        '<tr>'+

                            '<td style="text-align:left">'+

                                productos[i]+

                            '</td>'+

                        '</tr>'

                    );

                }


            }

        })


        mywindow.document.write(

                '</table>'+

                '============================================'+

              '</td>'+

            '</tr>'+

            '<tr>'+

                '<td>'+

                    '<table>'+

                       '<tr>'+
                            '<td style="text-align:left">TOTAL DEUDA:</td> <td style="text-align:right">'+new Intl.NumberFormat("de-DE").format(totalDeuda)+'</td>'+
                        '</tr>'+

                        '<tr>'+
                            '<td style="text-align:left">TOTAL PAGADO:</td> <td style="text-align:right">'+new Intl.NumberFormat("de-DE").format(totalPagado)+'</td>'+
                        '</tr>'+

                        '<tr>'+
                            '<td style="text-align:left" colspan="2">------------------------------------------------------------------------</td>'+
                        '</tr>'+

                        '<tr>'+
                            '<td style="text-align:left">N° recibo:</td> <td style="text-align:right">'+nroRecibo+'</td>'+
                        '</tr>'+

                        '<tr>'+
                            '<td style="text-align:left">Fecha pago:</td> <td style="text-align:right">'+fechaPago+'</td>'+
                        '</tr>'+

                        '<tr>'+
                            '<td style="text-align:left">Fecha vencimiento:</td> <td style="text-align:right">'+fechaVenc+'</td>'+
                        '</tr>'+

                        '<tr>'+
                            '<td style="text-align:left">N° cuota:</td> <td style="text-align:right">'+cuotaPagada+'/'+cantCuota+'</td>'+
                        '</tr>'+

                        '<tr>'+
                            '<td style="text-align:left">Monto cuota:</td> <td style="text-align:right">'+new Intl.NumberFormat("de-DE").format(montoCuota)+'</td>'+
                        '</tr>'+

                        '<tr>'+
                            '<td style="text-align:left">Saldo anterior:</td> <td style="text-align:right">'+new Intl.NumberFormat("de-DE").format(saldoAnt)+'</td>'+
                        '</tr>'+

                        '<tr>'+
                            '<td style="text-align:left">Pago de Cuota:</td> <td style="text-align:right">'+new Intl.NumberFormat("de-DE").format(pagoCuota)+'</td>'+
                        '</tr>'+

                        '<tr>'+
                            '<td style="text-align:left">Saldo Actual:</td> <td style="text-align:right">'+new Intl.NumberFormat("de-DE").format(saldoAct)+'</td>'+
                        '</tr>'+

                        '<tr>'+
                            '<td style="text-align:left" colspan="2">------------------------------------------------------------------------</td>'+
                        '</tr>'+

                    '</table>'+

                '</td>'+

            '</tr>'

        );


    }

    mywindow.document.write(

            '<tr>'+

                '<td style="text-align:center">'+

                    '<br><br><br><br>'+

                    '<label">.............................................</label>'+

                    '<br>'+

                    '<label">FIRMA DEL CAJERO </label>'+

                '</td>'+

            '</tr>'+

            '<tr>'+

                '<td style="text-align:center">'+

                    '<br><br>'+

                    '<label">MUCHAS GRACIAS POR SU PREFERENCIA!!! </label>'+

                '</td>'+

            '</tr>'+

          '</table>'+

        '</FONT>'

    );


    // --kiosk-printing

    mywindow.document.close();
    mywindow.focus();

    mywindow.print();
    mywindow.print();

    mywindow.close();

}

/*==========================================================
      REIMPRIMIR TICKET
============================================================*/
$(".tablaCuentaHistorial").on("click", "button.imprimirCobro", function() {

    var detalleCuenta = $(this).attr("idCuenta");
    var codCuenta = $(this).attr("idCuentaCab");

    console.log(detalleCuenta);
    console.log(codCuenta);

    window.open("extensiones/tcpdf/pdf/impCobro.php?detalleCuenta="+detalleCuenta+"&codCuenta="+codCuenta,"_blank");

    return (false);

})