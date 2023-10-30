
/*=============================================
  CARGAR LA TABLA CUENTAS A PAGAR Y DARLE FORMATO
=============================================*/

var tablaCuentasPagar = $('.tablaCuentasPagar').DataTable({
    // "ajax": "ajax/tablaCuentasPagar.ajax.php?sucursal="+$("#idSucursal").val()+"&proveedor="+0,
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
                "columns": [1, 2, 3, 4, 5, 6, 7] 
            }
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Exportar a Excel",
            "className": "btn btn-success",
            "exportOptions": { 
                "columns": [1, 2, 3, 4, 5, 6, 7]  
            }
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Exportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": { 
                "columns": [1, 2, 3, 4, 5, 6, 7] 
            }
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Exportar a CSV",
            "className": "btn btn-info",
            "exportOptions": { 
                "columns": [1, 2, 3, 4, 5, 6, 7]  
            }
          }
        ],

})


/*=============================================
  BOTÓN NUEVO
=============================================*/

var estadoNuevo = false;

$(document).on("click", ".btnNuevo", function() {

  $(".cargarCuentasPagar").removeClass("notblock");
  $(".listarCuentasPagar").addClass("notblock");

  // formularioPago.reset();

  agregarFecha();


})

/*=============================================
  BOTÓN LISTAR
=============================================*/

$(document).on("click", ".btnListar", function() {

  // console.log("ingresa");

  $(".listarCuentasPagar").removeClass("notblock");
  $(".cargarCuentasPagar").addClass("notblock");


  // if (localStorage.getItem("listaCuentasPagar") != null) {

  //   var sucursal = $("#idSucursal").val();

  //   var listasCuentasPagar = JSON.parse(localStorage.getItem("listaCuentasPagar"));

  //   obtenerCuentaLocalStorage(listasCuentasPagar);


  // }

  // $(".tablaCuentasPagar").DataTable().ajax.url("ajax/tablaCuentasPagar.ajax.php?sucursal="+$("#idSucursal").val()+"&proveedor="+0).load();


})

/*=============================================
  RECARGAR LA TABLA SEGUN PROVEEDOR
=============================================*/

$(document).on("change", "#cmbProveedorCuentas", function() {
  
  consultarProveedorCuentas($(this).val())

  // alert(idProveedor);
  
})

/*=============================================
  RECARGAR LA TABLA LISTADO PRINCIPAL SEGUN PROVEEDOR
=============================================*/

$(document).on("change", ".cmbProveedorCuenta", function() {

    var proveedor = $(this).val();

    if(proveedor == ""){
        proveedor = 0;
    }
  
  $(".tablaListadoCuentas").DataTable().ajax.url("ajax/tablaListadoCuentas.ajax.php?sucursal=" + $("#idSucursal").val() + " &proveedor=" + proveedor + " &fechaInicio=" + fechaInicial + "&fechaFin=" + fechaFinal).load();

  // alert($(this).val());
  
})

/*=============================================
  FUNCION PARA RECARGAR LA TABLA SEGUN PROVEEDOR
=============================================*/

function consultarProveedorCuentas(idProveedor){

    // alert(idProveedor);
    // return;

    $(".tablaCuentasPagar").DataTable().ajax.url("ajax/tablaCuentasPagar.ajax.php?sucursal="+$("#idSucursal").val()+"&proveedor="+idProveedor).load();

    quitarAgregarCuenta();

}
/*=============================================
  CARGAR LA TABLA CUENTAS CANCELADAS Y DARLE FORMATO
=============================================*/

var tablaCuentasCanceladas = $('.tablaCuentasCanceladas').DataTable({
    // "ajax": "ajax/tablaCuentasCanceladas.ajax.php?sucursal="+$("#idSucursal").val()+"&proveedor="+0,
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
                "columns": [1, 2, 3, 4, 5, 6, 7, 8] 
            }
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Exportar a Excel",
            "className": "btn btn-success",
            "exportOptions": { 
                "columns": [1, 2, 3, 4, 5, 6, 7, 8]  
            }
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Exportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": { 
                "columns": [1, 2, 3, 4, 5, 6, 7, 8] 
            }
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Exportar a CSV",
            "className": "btn btn-info",
            "exportOptions": { 
                "columns": [1, 2, 3, 4, 5, 6, 7, 8]  
            }
          }
        ],

})

/*=============================================
  RECARGAR LA TABLA SEGUN PROVEEDOR
=============================================*/

$(document).on("change", "#cmbProveedorCuentaCancelada", function() {
  
  var idProveedor = $(this).val();

  // alert(idProveedor);

  $(".tablaCuentasCanceladas").DataTable().ajax.url("ajax/tablaCuentasCanceladas.ajax.php?sucursal="+$("#idSucursal").val()+"&proveedor="+idProveedor).load();

  // quitarAgregarCuenta();
  
})

/*=============================================
  CARGAR LISTADO DE CUENTAS PAGADAS
=============================================*/

var tablaListadoCuentas = $('.tablaListadoCuentas').DataTable({
    "ajax": "ajax/tablaListadoCuentas.ajax.php?sucursal="+ $("#idSucursal").val()+"&proveedor="+0 +"&fechaInicio="+0+"&fechaFin="+0,
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "async": false,
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

        "createdRow": function(row, data, index){

          var parser = new DOMParser();
          var doc = parser.parseFromString(data[14], 'text/html');

          // console.log(parseInt(data[10]) + "-" + parseInt(data[9]));

          var cuotasPagada = data[10].split("/", 1);//se puede recuperar asi el primer caracter
          var totalCuotas = (data[10].split("/", -1)[1]);//tambien se puede recuperar asi mediante la posicion

          // console.log(cuotasPagada + " - " + totalCuotas);
    
          if(parseInt(cuotasPagada) >= parseInt(totalCuotas)){

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

          if(parseInt(cuotasPagada) < parseInt(totalCuotas) && parseInt(cuotasPagada) > 0){

            // $(row).addClass("table-warning");//rojo

          }

          if(parseInt(cuotasPagada) == 0){

            // $(row).addClass("table-danger");//amarillo

          }

        },

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
  RECARGAR EL HISTORIAL EN LA TABLA SEGUN LA CUENTA
=============================================*/

$(document).on("click", ".historialCuenta", function() {
  
  var idCuenta = $(this).attr("idCuenta");
  $('#agregarComentario').attr("idCuenta", idCuenta);

  // mostrarDatosProveedor(idCuenta);

  mostrarCabeceraHistorial(idCuenta);

  $(".tablaCuentaHistorial").DataTable().ajax.url("ajax/tablaHistorialCuentasPagar.ajax.php?codCuentaHistorialPago="+idCuenta).load();
  
})

/*=============================================
  CARGAR DETALLES DE CUENTAS PAGADAS
=============================================*/
// let datos_nuevos;
var tablaCuentaDetalle = $('.tablaCuentaDetalle').DataTable({
    // "ajax": "ajax/tablaDetallesCuentasPagar.ajax.php?codCuentaHistorialPago="+0,
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    // "data": {
    //     "sucursal": datos_nuevos
    // }, 
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
                "columns": [1, 2, 3, 4, 5, 6, 7] 
            }
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Exportar a Excel",
            "className": "btn btn-success",
            "exportOptions": { 
                "columns": [1, 2, 3, 4, 5, 6, 7]  
            }
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Exportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": { 
                "columns": [1, 2, 3, 4, 5, 6, 7] 
            }
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Exportar a CSV",
            "className": "btn btn-info",
            "exportOptions": { 
                "columns": [1, 2, 3, 4, 5, 6, 7]  
            }
          }
        ],

})

/*=============================================
  RECARGAR LOS DETALLES EN LA TABLA SEGUN LA CUENTA
=============================================*/

// $(document).on("click", ".verDetallesCuenta", function() {
  
//   var idCuenta = $(this).attr("idCuenta");

//   mostrarDatosProveedor(idCuenta);

//   $(".tablaCuentaDetalle").DataTable().ajax.url("ajax/tablaDetallesCuentasPagar.ajax.php?codCuentaDetPago="+idCuenta).load();
  
// })

/*=============================================
  MOSTRAR Y OCULTAR TABS
=============================================*/

$(document).on("click", ".editarUsuario", function() {

  $("#ventasCredito").removeClass('active show');
  $("#ventasCred").removeClass('active');
  $("#ventasCreditoDetalle").tab('show');
  $("#ventasCreditoDet").addClass('active');
  
});

/*=============================================
  AGREGAR CUENTA A PAGAR A LA GRILLA
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
  var montoCuota = $(this).attr("montoCuota");
  var totalCuenta = $(this).attr("totalCuenta");
  var saldo = $(this).attr("saldo");
  var codProv = $(this).attr("idProv");

  $(".cargarCuentasPagar").removeClass("notblock");
  $(".listarCuentasPagar").addClass("notblock");
  // formularioPago.reset();

  if(parseInt(saldo) > 0){

    // window.location = "index.php?ruta=crearCuentasPagar&id="+cod_cuenta+"&m="+montoCuota+"&t="+totalCuenta+"&s="+saldo+"&p="+codProv;
    
    // $("#cmbProveedorCuentas").val(codProv);
    // $("#cmbProveedorCuentas").select2().trigger('change');//aplicar la seleccion

    // console.log(cod_cuenta);

    if(cod_cuenta != null){

      // alert(cod_cuenta + " " + montoCuot  + " " + totalCuenta + " " + saldo);
      agregarCuenta(cod_cuenta, montoCuota, totalCuenta, saldo);

    }

  }else{

    swal("Error", "Esta cuenta ya está cancelada", "error");
    return;

  }
  
});

/*=============================================
  AGREGAR CUENTA A PAGAR A LA GRILLA
=============================================*/

function agregarCuenta(cod_cuenta){

  /*=============================================
  OBTENEMOS LOS DATOS DE CUENTA A PAGAR
  =============================================*/

  idCuenta=idCuenta+1;//CONTADOS POR CADA CUENTA AGREGADA

  var datos = new FormData();
  datos.append("codCuenta", cod_cuenta);

  // alert(cod_cuenta);
  // return;

  $.ajax({

    url:"ajax/cuentasPagar.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success:function(respuesta){

        var cant = respuesta["CANT_CUOTA"];//CANTIDAD DE CUOTAS EN QUE SE FINANCIÓ
        var fechaVenc = respuesta["FECHA_VENCIMIENTO"];//CAPTURAMOS FECHA DE VENCIMIENTO PARA AGREGAR COMO ATRR
        var tipoVenta = respuesta["TIPO_VENTA"];
        var montoCuota = respuesta["MONTO_CUOTA"];
        var totalCuenta = respuesta["TOTAL_CUENTA"];

        // console.log(montoCuota);

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

        $("#tablaCuentaPagar").append(

              '<tr class="rowNuevo">'+

                '<!-- BOTON PARA QUITAR -->'+

                '<td class="tdNuevoQuitar'+idCuenta+'">'+

                    '<div class="form-group nuevoQuitar'+idCuenta+'">'+

                      '<div class="input-group">'+
                              
                        '<span class="input-group-addon">'+

                          '<button type="button" class="btn btn-danger btn-xs quitarCuenta" style="width:35px" idCuenta="'+idCuenta+'" idCuentaPagar="'+cod_cuenta+'"><i class="fa fa-times"></i></button>'+

                        '</span>'+

                      '</div>'+

                    '</div>'+

                '</td>'+

                '<!-- Codigo de la cuenta -->'+

                '<td class="tdNuevoCodigo'+idCuenta+' notblock">'+

                  '<div class="form-group nuevoCodigo'+idCuenta+'">'+

                    '<div class="input-group" style="width: 100px">'+
                          
                      '<input type="text" class="form-control nuevoCodigoCuenta" idCuenta="'+idCuenta+'" fechaVenc="'+fechaVenc+'" tipoVenta="'+tipoVenta+'" value="'+cod_cuenta.split("/", 2)[0]+'" readonly required>'+

                    '</div>'+

                  '</div>'+

                '</td>'+

                '<!-- CANTIDAD DE CUOTAS -->'+

                '<td class="tdNuevoCantidad'+idCuenta+' notblock">'+

                  '<div class="form-group nuevoCantidad'+idCuenta+'">'+

                    '<div class="input-group" style="width: 70px">'+
                             
                        '<input type="text" class="form-control nuevaCantidadCuenta quitarCantidad'+idCuenta+'" idCuenta="'+idCuenta+'" cuotaPendiente="'+cuotaRestante+'" name="" value="'+cantidad+'" onkeyup="format(this)" onchange="format(this)" required>'+

                    '</div>'+

                  '</div>'+

                '</td>'+

                '<!-- N° RECIBO -->'+

                '<td class="tdNuevoRecibo'+idCuenta+'">'+

                  '<div class="form-group nuevoRecibo'+idCuenta+'">'+

                    '<div class="input-group" style="width: 70px">'+
                             
                        '<input type="text" class="form-control inputRecibo'+idCuenta+' nuevoRecibo'+idCuenta+'" idCuenta="'+idCuenta+'" name="" value="" readonly required>'+

                    '</div>'+

                  '</div>'+

                '</td>'+

                '<!-- AUTOMATICO -->'+

                '<td class="tdNuevoAutomatico'+idCuenta+'">'+

                  '<div class="form-group nuevoAutomatico'+idCuenta+'">'+

                    '<div class="animated-checkbox">'+

                      '<label id="lblFactura" class="control-label" style="margin-top: 8px">'+

                        '<input type="checkbox" class="chkAutomatico" value=1 checked name="chkOferta" idCuenta="'+idCuenta+'""><span class="label-text"></span>'+

                      '</label>'+

                    '</div>'+

                  '</div>'+

                '</td>'+

                '<!-- TIPO DE PAGO-->'+

                '<td class="tdNuevoPago'+idCuenta+'">'+

                  '<div class="form-group nuevoPago'+idCuenta+'" style="width: 200px">'+

                    '<div class="input-group">'+

                      '<select class="form-control selectPago" id="nuevoMetodoPago'+idCuenta+'" name="nuevoMetodoPago" required>'+

                        '<option value="">Seleccionar</option>'+                       
                          
                      '</select>'+
                                
                          '<div class="btn-group">'+

                            '<button type="button" class="btn btn-success btn-sm agregarPago" style="width:35px" idCuenta="'+idCuenta+'" montoTotal="'+montoTotal+'"><i class="fa fa-plus"></i></button>'+
                            // '<button type="button" class="btn btn-danger btn-sm quitarPago" style="width:35px" idCuenta="'+idCuenta+'"><i class="fa fa-trash"></i></button>'+

                      '</div>'+

                    '</div>'+

                  '</div>'+

                '</td>'+

                '<!-- N° COMPROBANTE -->'+

                '<td class="tdNuevoComprobante'+idCuenta+'">'+

                  '<div class="form-group nuevoComprobante'+idCuenta+'">'+

                    '<div class="input-group" style="width: 100px">'+
                             
                        '<input type="text" class="form-control nuevoComprobante'+idCuenta+'" idCuenta="'+idCuenta+'" name="" value="">'+

                    '</div>'+

                  '</div>'+

                '</td>'+

                '<!-- Monto de Cuota -->'+

                '<td class="tdNuevoMonto'+idCuenta+'">'+

                  '<div class="form-group nuevoMonto'+idCuenta+'">'+
                              
                      '<div class="input-group" style="width: 100px">'+
                          
                        '<input type="text" class="form-control inputNuevoMonto'+idCuenta+'" idCuenta="'+idCuenta+'" name="" value="'+Intl.NumberFormat("de-DE").format(montoCuota)+'" readonly required>'+

                      '</div>'+

                  '</div>'+

                '</td>'+

                '<!-- Monto parcial -->'+

                '<td class="tdNuevoMontoParcial'+idCuenta+'">'+

                  '<div class="form-group nuevoMontoParcial'+idCuenta+'">'+
                              
                      '<div class="input-group" style="width: 100px">'+
                          
                        '<input type="text" class="form-control inputNuevoMontoParcial inputMultiple'+idCuenta+'" idCuenta="'+idCuenta+'" name="" value="'+montoTotal+'" onkeyup="format(this)" onchange="format(this)" required>'+

                      '</div>'+

                  '</div>'+

                '</td>'+

                '<!-- Saldo -->'+

                '<td class="tdNuevoMontoSaldo'+idCuenta+'">'+

                  '<div class="form-group nuevoMontoSaldo'+idCuenta+'">'+
                              
                      '<div class="input-group" style="width: 100px">'+
                          
                        '<input type="text" class="form-control nuevoMontoSaldoCuenta inputNuevoMontoSaldo'+idCuenta+'" idCuenta="'+idCuenta+'" name="" value="'+Intl.NumberFormat("de-DE").format(saldo)+'" readonly required>'+

                      '</div>'+

                  '</div>'+

                '</td>'+

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

/*========================================================
  AGREGAR CUENTA A PAGAR A LA GRILLA DESDE EL LOCALSTORAGE
=========================================================*/

var idCuentaSelect = 0;

function obtenerCuentaLocalStorage(listasCuentasPagar){

    /*========================================================
      RECORREMOS LA CANTIDAD DE CUENTAS A PAGAR PRECARGADOS
    =========================================================*/

    for (var i = 0; i < listasCuentasPagar.length ; i++) {

        // console.log(listasCuentasPagar);
        // return;

        var formaPago = listasCuentasPagar[i]["formaPago"];

        var cod_cuenta = listasCuentasPagar[i]["codCuenta"];
        var montoCuota = listasCuentasPagar[i]["pago"];
        var cantidad = listasCuentasPagar[i]["cantidad"];
        var nroRecibo = parseInt(listasCuentasPagar[i]["nroRecibo"]);
        var tipoRecibo = listasCuentasPagar[i]["tipoRecibo"]
        var saldo = listasCuentasPagar[i]["saldo"];
        var readOnly = "";
        var check = "";

        // console.log(nroRecibo);

        if(tipoRecibo == "Manual"){

          check = "0";

          if(nroRecibo == 0){

            readOnly = "";
            nroRecibo = "";

          }

        }else{

          check = "1";

          if(nroRecibo == 0){

            readOnly = "readonly = true";
            nroRecibo = "";

          }

        }

        /*=============================================
        OBTENEMOS LOS DATOS DE CUENTA A PAGAR
        =============================================*/

        idCuenta=idCuenta+1;//CONTADOS POR CADA CUENTA AGREGADA

        var datos = new FormData();
        datos.append("codCuenta", cod_cuenta);

        $.ajax({

            url:"ajax/cuentasPagar.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            async: false,
            contentType: false,
            processData: false,
            dataType:"json",
            success:function(respuesta){

                // console.log(cantidad);
                // return;

                var cant = respuesta["CANT_CUOTA"];//CANTIDAD DE CUOTAS EN QUE SE FINANCIÓ
                var fechaVenc = respuesta["FECHA_VENCIMIENTO"];//CAPTURAMOS FECHA DE VENCIMIENTO PARA AGREGAR COMO ATRR
                var tipoVenta = respuesta["TIPO_VENTA"];
                var cuotaPagada = respuesta["CUOTA_PAGADA_DECIMAL"];
                var saldoFinal = respuesta["SALDO"];

                var cuotaRestante = cant - cuotaPagada;
                // var cantidad;

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

                // alert(cant);
                // return

                if(cantidad > 0){

                    var montoTotal = new Intl.NumberFormat("de-DE").format(montoCuota * cantidad);

                    /*=======================================================================================
                    AGREGAMOS LAS CUENTAS A LA TABLA
                    ========================================================================================*/

                    $("#tablaCuentaPagar").append(

                                  '<tr class="rowNuevo" id="row'+idCuenta+'">'+

                                    '<!-- BOTON PARA QUITAR -->'+

                                    '<td class="tdNuevoQuitar'+idCuenta+'">'+

                                        '<div class="form-group nuevoQuitar'+idCuenta+'">'+

                                          '<div class="input-group">'+
                                                  
                                            '<span class="input-group-addon">'+

                                              '<button type="button" class="btn btn-danger btn-xs quitarCuenta" style="width:35px" idCuenta="'+idCuenta+'" idCuentaPagar="'+cod_cuenta+'"><i class="fa fa-times"></i></button>'+

                                            '</span>'+

                                          '</div>'+

                                        '</div>'+

                                    '</td>'+

                                    '<!-- Codigo de la cuenta -->'+

                                    '<td class="tdNuevoCodigo'+idCuenta+' notblock">'+

                                      '<div class="form-group nuevoCodigo'+idCuenta+'">'+

                                        '<div class="input-group" style="width: 100px">'+
                                              
                                          '<input type="text" class="form-control nuevoCodigoCuenta" idCuenta="'+idCuenta+'" fechaVenc="'+fechaVenc+'" tipoVenta="'+tipoVenta+'" value="'+cod_cuenta.split("/", 2)[0]+'" readonly required>'+

                                        '</div>'+

                                      '</div>'+

                                    '</td>'+

                                    '<!-- CANTIDAD DE CUOTAS -->'+

                                    '<td class="tdNuevoCantidad'+idCuenta+' notblock">'+

                                      '<div class="form-group nuevoCantidad'+idCuenta+' notblock">'+

                                        '<div class="input-group" style="width: 70px">'+
                                                 
                                            '<input type="text" class="form-control nuevaCantidadCuenta quitarCantidad'+idCuenta+'" idCuenta="'+idCuenta+'" cuotaPendiente="'+cantidad+'" name="" value="'+cantidad+'" onkeyup="format(this)" onchange="format(this)" readonly required>'+

                                        '</div>'+

                                      '</div>'+

                                    '</td>'+

                                    '<!-- N° RECIBO -->'+

                                    '<td class="tdNuevoRecibo'+idCuenta+'">'+

                                      '<div class="form-group nuevoRecibo'+idCuenta+'">'+

                                        '<div class="input-group" style="width: 70px">'+
                                                 
                                            '<input type="text" class="form-control inputRecibo'+idCuenta+' nuevoRecibo'+idCuenta+'" idCuenta="'+idCuenta+'" name="" value="'+nroRecibo+'"'+readOnly+' required>'+

                                        '</div>'+

                                      '</div>'+

                                    '</td>'+

                                    '<!-- AUTOMATICO -->'+

                                    '<td class="tdNuevoAutomatico'+idCuenta+'">'+

                                      '<div class="form-group nuevoAutomatico'+idCuenta+'">'+

                                        '<div class="animated-checkbox">'+

                                          '<label id="lblFactura" class="control-label" style="margin-top: 8px">'+

                                            '<input type="checkbox" class="chkAutomatico" value="'+check+'" name="chkOferta" id="chkAutomatico'+idCuenta+'" idCuenta="'+idCuenta+'""><span class="label-text"></span>'+

                                          '</label>'+

                                        '</div>'+

                                      '</div>'+

                                    '</td>'+

                    '</tr>');

                    if(tipoRecibo == "Manual"){

                        $("#chkAutomatico"+idCuenta).attr('checked', false);

                    }else{

                        $("#chkAutomatico"+idCuenta).attr('checked', true);

                    }

                    // console.log(idCuenta);

                    // console.log(formaPago.length);
                    // return;

                    /*=======================================================================================
                    RECORREMOS LOS DETALLES DE LOS TIPOS DE PAGOS AGREGADOS POR CADA CUENTA
                    ========================================================================================*/

                    for (var i = 0; i < formaPago.length; i++) {

                                idCuentaSelect ++;

                                if(i == 0){

                                    // console.log(idCuenta);

                                    $("#row"+idCuenta).append(

                                        '<!-- TIPO DE PAGO-->'+

                                        '<td class="tdNuevoPago'+idCuenta+'">'+

                                          '<div class="form-group nuevoPago'+idCuenta+'" style="width: 200px">'+

                                            '<div class="input-group">'+

                                              '<select class="form-control selectPago" id="nuevoMetodoPago'+idCuentaSelect+'" name="nuevoMetodoPago" required>'+

                                                '<option value="">Seleccionar</option>'+                       
                                                  
                                              '</select>'+
                                                        
                                                  '<div class="btn-group">'+

                                                    '<button type="button" class="btn btn-success btn-sm agregarPago" style="width:35px" idCuenta="'+idCuenta+'" montoTotal="'+montoTotal+'"><i class="fa fa-plus"></i></button>'+
                                                    // '<button type="button" class="btn btn-danger btn-sm quitarPago" style="width:35px" idCuenta="'+idCuenta+'"><i class="fa fa-trash"></i></button>'+

                                              '</div>'+

                                            '</div>'+

                                          '</div>'+

                                        '</td>'+

                                        '<!-- N° COMPROBANTE -->'+

                                        '<td class="tdNuevoComprobante'+idCuenta+'">'+

                                          '<div class="form-group nuevoComprobante'+idCuenta+'">'+

                                            '<div class="input-group" style="width: 100px">'+
                                                     
                                                '<input type="text" class="form-control nuevoComprobante'+idCuenta+'" idCuenta="'+idCuenta+'" name="" value="'+formaPago[i]["nrotransaccion"]+'">'+

                                            '</div>'+

                                          '</div>'+

                                        '</td>'+

                                        '<!-- Monto de Cuota -->'+

                                        '<td class="tdNuevoMonto'+idCuenta+'">'+

                                          '<div class="form-group nuevoMonto'+idCuenta+'">'+
                                                      
                                              '<div class="input-group" style="width: 100px">'+
                                                  
                                                '<input type="text" class="form-control inputNuevoMonto'+idCuenta+'" idCuenta="'+idCuenta+'" name="" value="'+Intl.NumberFormat("de-DE").format(montoCuota)+'" readonly required>'+

                                              '</div>'+

                                          '</div>'+

                                        '</td>'+

                                        '<!-- Monto parcial -->'+

                                        '<td class="tdNuevoMontoParcial'+idCuenta+'">'+

                                          '<div class="form-group nuevoMontoParcial'+idCuenta+'">'+
                                                      
                                              '<div class="input-group" style="width: 100px">'+
                                                  
                                                '<input type="text" class="form-control inputNuevoMontoParcial inputMultiple'+idCuenta+'" idCuenta="'+idCuenta+'" name="" value="'+ montoTotal +'" onkeyup="format(this)" onchange="format(this)" required>'+

                                              '</div>'+

                                          '</div>'+

                                        '</td>'+

                                        '<!-- Saldo -->'+

                                        '<td class="tdNuevoMontoSaldo'+idCuenta+'">'+

                                          '<div class="form-group nuevoMontoSaldo'+idCuenta+'">'+
                                                      
                                              '<div class="input-group" style="width: 100px">'+
                                                  
                                                '<input type="text" class="form-control nuevoMontoSaldoCuenta inputNuevoMontoSaldo'+idCuenta+'" idCuenta="'+idCuenta+'" name="" value="'+Intl.NumberFormat("de-DE").format((saldo+montoCuota))+'" readonly required>'+

                                              '</div>'+

                                          '</div>'+

                                        '</td>'
                                    
                                    );

                                    /*=============================================
                                      CARGAR METODO DE PAGO
                                    =============================================*/

                                    cargarMetodoPagoLocalStorage(idCuentaSelect);

                                    $("#nuevoMetodoPago"+idCuentaSelect).val(formaPago[i]["id_metodo"]);

                                }else{

                                    // console.log(idCuenta);

                                    idPago = idCuenta;

                                    $(".tdNuevoPago"+idPago+"").append(

                                      '<!-- METODO DE PAGO -->'+

                                      '<div class="form-group nuevoPago'+idCuentaSelect+'" style="width: 200px">'+

                                        '<div class="input-group">'+

                                          '<select class="form-control selectPago" id="nuevoMetodoPago'+idCuentaSelect+'" name="nuevoMetodoPago" required>'+

                                            '<option value="">Seleccionar</option>'+                       
                                              
                                          '</select>'+
                                                    
                                              '<div class="btn-group">'+

                                                // '<button type="button" class="btn btn-success btn-sm agregarPago" style="width:35px" idCuenta="'+idCuenta+'"><i class="fa fa-plus"></i></button>'+
                                                '<button type="button" class="btn btn-danger btn-sm quitarPago" style="width:35px" idCuenta="'+idCuentaSelect+'" idPago="'+idPago+'"><i class="fa fa-trash"></i></button>'+

                                          '</div>'+

                                        '</div>'+

                                      '</div>'

                                    );

                                    $(".tdNuevoComprobante"+idPago+"").append(

                                        '<div class="form-group nuevoComprobante'+idCuentaSelect+'">'+

                                          '<div class="input-group" style="width: 100px">'+
                                                       
                                              '<input type="text" class="form-control nuevoComprobante'+idCuenta+'" idCuenta="'+idCuenta+'" name="" value="'+formaPago[i]["nrotransaccion"]+'">'+

                                          '</div>'+

                                        '</div>'

                                    );

                                    $(".tdNuevoMonto"+idPago+"").append(

                                        '<div class="form-group nuevoMonto'+idCuentaSelect+'">'+
                                                      
                                              '<div class="input-group" style="width: 100px">'+
                                                  
                                                '<input type="text" class="form-control inputNuevoMonto" idCuenta="'+idCuenta+'" name="agregarProducto" value="'+Intl.NumberFormat("de-DE").format(montoCuota)+'" readonly required>'+

                                              '</div>'+

                                          '</div>'

                                    );

                                    $(".tdNuevoMontoParcial"+idPago+"").append(

                                        '<div class="form-group nuevoMontoParcial'+idCuentaSelect+'">'+
                                                    
                                            '<div class="input-group" style="width: 100px">'+
                                                
                                              '<input type="text" class="form-control inputNuevoMontoParcialSec inputMultiple'+idPago+'"" idCuenta="'+idCuenta+'" idPago="'+idPago+'" value="'+Intl.NumberFormat("de-DE").format(formaPago[i]["entrega"])+'" onkeyup="format(this)" onchange="format(this)" required>'+

                                            '</div>'+

                                        '</div>'

                                    );

                                    $(".tdNuevoMontoSaldo"+idPago+"").append(

                                      '<div class="form-group nuevoMontoSaldo'+idCuentaSelect+'">'+
                                                              
                                          '<div class="input-group" style="width: 100px">'+
                                                          
                                              '<input type="text" class="form-control nuevoMontoSaldoCuenta inputNuevoMontoSaldo'+idCuenta+'" idCuenta="'+idCuenta+'" name="" value="'+Intl.NumberFormat("de-DE").format((saldo+montoCuota))+'" readonly required>'+

                                            '</div>'+

                                        '</div>'

                                    );

                                    /*=============================================
                                      CARGAR METODO DE PAGO
                                    =============================================*/

                                    cargarMetodoPagoLocalStorage(idCuentaSelect);

                                    // console.log(formaPago[i]["metodoPago"]);

                                    $("#nuevoMetodoPago"+idCuentaSelect).val(formaPago[i]["id_metodo"]);

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


/*=============================================
  CARGAR METOOD DE PAGO
=============================================*/

function cargarMetodoPago(selectValue){
  
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

    url: "ajax/cuentasPagar.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      // console.log(respuesta);

      $.each(respuesta, function(i, value) {

        $("#nuevoMetodoPago"+idCuenta).append(

          '<option value="'+value["COD_FORMAPAGO"]+'/'+value["TOKEN_FORMAPAGO"]+'">'+value["DESCRIPCION_FORMA"]+'</option>'

        );

        selectOption.push(option);

      });

    }

  })

};

/*=============================================
  CARGAR METOOD DE PAGO
=============================================*/

function cargarMetodoPagoLocalStorage(idCuentaSelect){
  
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

    url: "ajax/cuentasPagar.ajax.php",
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

        $("#nuevoMetodoPago"+idCuentaSelect).append(

          '<option value="'+value["COD_FORMAPAGO"]+'/'+value["TOKEN_FORMAPAGO"]+'">'+value["DESCRIPCION_FORMA"]+'</option>'

        );

        selectOption.push(option);

      });

    }

  })

};

/*=============================================
  AGREGAR OTRO METODO DE PAGO A LA CUENTA
=============================================*/

$(document).on("click", ".agregarPago", function() {

    // $(this).attr('disabled','disabled');

    agregarPago($(this).attr("idCuenta"));

    cargarMetodoPago(idCuenta);

    sumarTotalCuentas();
  
});

/*=============================================
FUNCION AGREGAR ENTRADA PARA PAGOS
=============================================*/

function agregarPago(idPago){

    var montoCuota = new Intl.NumberFormat("de-DE").format($(".tdNuevoMonto"+idPago).children(".nuevoMonto"+idPago).children().children().val().replace(/\./g,''));
    var montoPagar = $(".tdNuevoMontoParcial"+idPago).children(".nuevoMontoParcial"+idPago).children().children().val().replace(/\./g,'');
    // var montoTotal = parseInt($(".tdNuevoMontoTotal"+idPago).children(".nuevoMontoTotal"+idPago).children().children().val().replace(/\./g,''));
    var montoSaldo = parseInt($(".tdNuevoMontoSaldo"+idPago).children(".nuevoMontoSaldo"+idPago).children().children().val().replace(/\./g,''));
    // var diferencia = new Intl.NumberFormat("de-DE").format(parseInt(montoSaldo - recuperarSumaTotalxCuenta(idPago)));

    // console.log(diferencia);

    $(".quitarCantidad"+idPago).attr('readonly', true);

    idCuenta=idCuenta+1;

    $(".tdNuevoPago"+idPago+"").append(

      '<!-- METODO DE PAGO -->'+

      '<div class="form-group nuevoPago'+idCuenta+'" style="width: 200px">'+

        '<div class="input-group">'+

          '<select class="form-control selectPago" id="nuevoMetodoPago'+idCuenta+'" name="nuevoMetodoPago" required>'+

            '<option value="">Seleccionar</option>'+                       
              
          '</select>'+
                    
              '<div class="btn-group">'+

                // '<button type="button" class="btn btn-success btn-sm agregarPago" style="width:35px" idCuenta="'+idCuenta+'"><i class="fa fa-plus"></i></button>'+
                '<button type="button" class="btn btn-danger btn-sm quitarPago" style="width:35px" idCuenta="'+idCuenta+'" idPago="'+idPago+'"><i class="fa fa-trash"></i></button>'+

          '</div>'+

        '</div>'+

      '</div>'

    );

    $(".tdNuevoComprobante"+idPago+"").append(

        '<div class="form-group nuevoComprobante'+idCuenta+'">'+

          '<div class="input-group" style="width: 100px">'+
                       
              '<input type="text" class="form-control nuevoComprobante'+idCuenta+'" idCuenta="'+idCuenta+'" name="" value="">'+

          '</div>'+

        '</div>'

    );

    $(".tdNuevoMonto"+idPago+"").append(

        '<div class="form-group nuevoMonto'+idCuenta+'">'+
                      
              '<div class="input-group" style="width: 100px">'+
                  
                '<input type="text" class="form-control inputNuevoMonto" idCuenta="'+idCuenta+'" name="agregarProducto" value="'+montoCuota+'" readonly required>'+

              '</div>'+

          '</div>'

    );

    $(".tdNuevoMontoParcial"+idPago+"").append(

        '<div class="form-group nuevoMontoParcial'+idCuenta+'">'+
                    
            '<div class="input-group" style="width: 100px">'+
                
              '<input type="text" class="form-control inputNuevoMontoParcialSec inputMultiple'+idPago+'"" idCuenta="'+idCuenta+'" idPago="'+idPago+'" value="" onkeyup="format(this)" onchange="format(this)" required>'+

            '</div>'+

        '</div>'

    );

    $(".tdNuevoMontoSaldo"+idPago+"").append(

      '<div class="form-group nuevoMontoSaldo'+idCuenta+'">'+
                              
          '<div class="input-group" style="width: 100px">'+
                          
              '<input type="text" class="form-control nuevoMontoSaldoCuenta inputNuevoMontoSaldo'+idCuenta+'" idCuenta="'+idCuenta+'" name="" value="'+new Intl.NumberFormat("de-DE").format(montoSaldo)+'" readonly required>'+

            '</div>'+

        '</div>'

    );

}

/*=============================================
QUITAR CUENTAS DE LA TABLA Y RECUPERAR BOTÓN
=============================================*/
var idQuitarCuenta = [];

localStorage.removeItem("quitarCuenta");

$(".formularioPago").on('click', 'button.quitarCuenta', function(event) {

  var idCuenta = $(this).attr("idCuentaPagar");

  /*=============================================
  ALMACENAR EN EL LOCALSTORAGE EL ID DE LA CUENTA A QUITAR
  =============================================*/

  if(localStorage.getItem("quitarCuenta") == null){

    idQuitarCuenta = [];
  
  }else{

    idQuitarCuenta.concat(localStorage.getItem("quitarCuenta"))

  }

  idQuitarCuenta.push({"quitarCuenta":idCuenta});

  localStorage.setItem("quitarCuenta", JSON.stringify(idQuitarCuenta));

  $("button.recuperarBoton[idCuenta='"+idCuenta+"']").removeAttr('disabled');

  /*=============================================
  QUITAR LA FILA DE LA TABLA
  =============================================*/

  event.preventDefault();

  $(this).closest('tr').remove();

  sumarTotalCuentas();

  cargarLocalStorage();

  cantidadItems();

});


/*=============================================
  QUITAR METODO DE PAGO DE UNA CUENTA
=============================================*/

$(".formularioPago").on("click", "button.quitarPago", function(){

    var idPago = $(this).attr("idPago");
    var idCuenta = $(this).attr("idCuenta");

    // console.log(idPago);
    // console.log(idCuenta);
    // return;

    var montoInicial = parseInt($(".tdNuevoMontoParcial"+idPago).children().children().children().val().replace(/\./g,''));
    var montoPagar = parseInt($(this).parent().parent().parent().parent().parent().children(".tdNuevoMontoParcial"+idPago).children(".nuevoMontoParcial"+idCuenta).children().children().val().replace(/\./g,''));
    var montoTotal = parseInt($(".tdNuevoMontoTotal"+idPago).children(".nuevoMontoTotal"+idPago).children().children().val());

    var montoAjuste = new Intl.NumberFormat("de-DE").format(reajustarSumaPagos(montoPagar, montoInicial, idPago));

    // console.log(restaPagos);

    $(".nuevoAutomatico"+idCuenta).remove();
    $(".nuevoRecibo"+idCuenta).remove();
    $(".nuevoComprobante"+idCuenta).remove();

    $(".nuevoMontoParcial"+idCuenta).remove();//SE QUITA ASI
    $(".nuevoMonto"+idCuenta).remove();
    $(".nuevoMontoTotal"+idCuenta).remove();
    $(".nuevoMontoSaldo"+idCuenta).remove();
    $(this).parent().parent().parent().remove()

    $(".tdNuevoMontoParcial"+idPago).children(".nuevoMontoParcial"+idPago).children().children().val(montoAjuste);
    $(".tdNuevoPago"+idPago).children(".nuevoPago"+idPago).children().children(".btn-group").children().attr("montoCuota", new Intl.NumberFormat("de-DE").format(montoPagar));

    cargarLocalStorage();
});

/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/

$('.tablaCuentasPagar').on( 'draw.dt', function(){

  quitarAgregarCuenta();

})

/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/

$('.tablaListadoCuentas').on( 'draw.dt', function(){

    // console.log("ingresa");

    quitarAgregarCuentaListadoPrincipal();

})

/*===================================================================================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO LA CUENTA YA HABÍA SIDO SELECCIONADO EN LA CARPETA
====================================================================================================*/

function quitarAgregarCuenta(){

  //Capturamos todos los id de las cuentas que fueron elegidos en la venta
  var idCuenta = $(".quitarCuenta");

  //Capturamos todos los botones de agregar que aparecen en la tabla
  var botonesTabla = $(".tablaCuentasPagar tbody button.agregarCuenta");

  // console.log(idCuenta);
  // console.log(botonesTabla);

  //Recorremos en un ciclo para obtener los diferentes idCuentas que fueron agregados a la tabla de pagos
  for(var i = 0; i < idCuenta.length; i++){

    //Capturamos los Id de las cuentas agregados a la tabla
    var boton = $(idCuenta[i]).attr("idCuentaPagar");
    
    //Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
    for(var j = 0; j < botonesTabla.length; j++){

      if($(botonesTabla[j]).attr("idCuenta") == boton){

        // $(botonesTabla[j]).removeClass("btn-primary agregarProducto");
        $(botonesTabla[j]).attr('disabled','disabled');

      }
    }

  }
  
}

/*===================================================================================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO LA CUENTA YA HABÍA SIDO SELECCIONADO EN LA CARPETA
====================================================================================================*/

function quitarAgregarCuentaListadoPrincipal(){

  //Capturamos todos los id de las cuentas que fueron elegidos en la venta
  var idCuenta = $(".quitarCuenta");

  //Capturamos todos los botones de agregar que aparecen en la tabla
  var botonesTabla = $(".tablaListadoCuentas tbody button.agregarCuentaListado");

  // console.log(idCuenta);
  // console.log(botonesTabla);

  //Recorremos en un ciclo para obtener los diferentes idCuentas que fueron agregados a la tabla de pagos
  for(var i = 0; i < idCuenta.length; i++){

    //Capturamos los Id de las cuentas agregados a la tabla
    var boton = $(idCuenta[i]).attr("idCuentaPagar");
    
    //Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
    for(var j = 0; j < botonesTabla.length; j++){

      if($(botonesTabla[j]).attr("idCuenta") == boton){

        // $(botonesTabla[j]).removeClass("btn-primary agregarProducto");
        $(botonesTabla[j]).attr('disabled','disabled');

      }
    }

  }
  
}

/*=====================================================
  EVENTO PARA ACTUALIZAR MONTO SEGUN CANTIDAD DE CUOTAS
======================================================*/

$(".formularioPago").on("keyup", "input.nuevaCantidadCuenta", function(){

  var idCuenta = $(this).attr("idCuenta");
  var cuotaPendiente = Number($(this).attr("cuotaPendiente"));
  var cantidad = Number($(this).val());

  if($(this).val() < 1){

    var monto = $(".inputNuevoMonto"+idCuenta).val().replace(/\./g,'');
    var total = new Intl.NumberFormat("de-DE").format(1 * monto);

    $(this).parent().parent().parent().parent().children(".tdNuevoMontoParcial"+idCuenta).children(".nuevoMontoParcial"+idCuenta).children().children().val(total);

  }else{

    // alert(cantidad + " - " + cuotaPendiente);

    if(cantidad > cuotaPendiente){

      swal({
        title: "Cantidad de cuotas a pagar excedida",
        text: "¡Cuotas pendientes a agregar: "+cuotaPendiente+" !",
        type: "warning",
        confirmButtonText: "¡Aceptar!"
      });

      $(this).val(cuotaPendiente);

      var monto = $(".inputNuevoMonto"+idCuenta).val().replace(/\./g,'');
      var total = new Intl.NumberFormat("de-DE").format(cuotaPendiente * monto);

      $(this).parent().parent().parent().parent().children(".tdNuevoMontoParcial"+idCuenta).children(".nuevoMontoParcial"+idCuenta).children().children().val(total);


    }else{

      var monto = $(".inputNuevoMonto"+idCuenta).val().replace(/\./g,'');
      var total = new Intl.NumberFormat("de-DE").format(cantidad * monto);

      // alert(idCuenta + " - " + cantidad + " - " + monto);

      $(this).parent().parent().parent().parent().children(".tdNuevoMontoParcial"+idCuenta).children(".nuevoMontoParcial"+idCuenta).children().children().val(total);

    }

  }

  // SUMAR TOTAL DE PRECIOS

  sumarTotalCuentas();

  cargarLocalStorage();

});

/*=====================================================
  EVENTO PARA OBTENER EL MONTO PARCIAL DE PAGO
======================================================*/

$(".formularioPago").on("keyup", "input.inputNuevoMontoParcial", function(){

  var idCuenta = parseInt($(this).attr("idCuenta"));//obtenemos el id de la cuenta
  var montoCuota = parseInt($(".nuevoMonto"+idCuenta).children().children().val().replace(/\./g,''));//obtenemos el monto de la cuota minima
  var montoPagar = parseInt($(this).val().replace(/\./g,''));//obtenemos el monto a pagar que se ingresa
  // var cantidad = Number($($(celdas[2]).children().children().children()).val());
  var montoSaldo = parseInt($(".inputNuevoMontoSaldo"+idCuenta).val().replace(/\./g,''));//obtenemos el monto de la cuota total
  var diferencia = parseInt(montoSaldo - recuperarSumaTotalxCuenta(idCuenta));

  // console.log(diferencia);

  if(diferencia == 0){

    $(this).parent().parent().parent().parent().children(".tdNuevoPago"+idCuenta).children(".nuevoPago"+idCuenta).children().children(".btn-group").children().attr('disabled','disabled');

  }else if(diferencia < 0){

    $(this).val("0");

    diferencia = parseInt(montoSaldo - recuperarSumaTotalxCuenta(idCuenta));

    // $(this).val($(".inputNuevoMontoSaldo"+idCuenta).val());
    $(this).val(new Intl.NumberFormat("de-DE").format(diferencia));
    $(this).parent().parent().parent().parent().children(".tdNuevoPago"+idCuenta).children(".nuevoPago"+idCuenta).children().children(".btn-group").children().attr('disabled','disabled');
    
  }else{

    $(this).parent().parent().parent().parent().children(".tdNuevoPago"+idCuenta).children(".nuevoPago"+idCuenta).children().children(".btn-group").children().removeAttr('disabled');
  
  }

  cargarLocalStorage();
  sumarTotalCuentas();


});

/*=====================================================
EVENTO PARA OBTENER EL MONTO PARCIAL DE PAGO SECUNDARIO
======================================================*/

$(".formularioPago").on("keyup", "input.inputNuevoMontoParcialSec", function(){

  var idCuenta = parseInt($(this).attr("idCuenta"));//obtenemos el id de la cuenta
  var idPago = parseInt($(this).attr("idPago"));//obtenemos el id de pago de la cuenta
  var montoSaldo = parseInt($(".inputNuevoMontoSaldo"+idCuenta).val().replace(/\./g,''));//obtenemos el saldo de la cuenta
  var diferencia = parseInt(montoSaldo - recuperarSumaTotalxCuenta(idPago));//calculamos el total de pagos parciales y restamos del saldo

  // console.log(idCuenta);
  // console.log(idPago);
  // console.log("SALDO: "+montoSaldo);
  // console.log("TOTAL: "+recuperarSumaTotalxCuenta(idPago));
  // console.log("DIFERENCIA: "+diferencia);
  // return;

  if(diferencia == 0){

    $(this).parent().parent().parent().parent().children(".tdNuevoPago"+idPago).children(".nuevoPago"+idPago).children().children(".btn-group").children().attr('disabled','disabled');

  }else if(diferencia < 0){

    $(this).val("0");

    diferencia = parseInt(montoSaldo - recuperarSumaTotalxCuenta(idPago));

    $(this).val(new Intl.NumberFormat("de-DE").format(diferencia));
    $(this).parent().parent().parent().parent().children(".tdNuevoPago"+idPago).children(".nuevoPago"+idPago).children().children(".btn-group").children().attr('disabled','disabled');
  
  }else{

    $(this).parent().parent().parent().parent().children(".tdNuevoPago"+idPago).children(".nuevoPago"+idPago).children().children(".btn-group").children().removeAttr('disabled');
  
  }

  sumarTotalCuentas();

});

/*=============================================
  METODOS PARA VALIDAR EL INGRESO DE PAGOS (2)
=============================================*/

function recuperarSumaTotalxCuenta(id) {

    let selects = $('.inputMultiple'+id);
    var c=0;
    var sumaPagos= 0;
  
    selects.each(function () {

        let select = $(this);

        // console.log("*" + select.val());
        sumaPagos = sumaPagos + parseInt(select.val().replace(/\./g,''));


    });

    // console.log("SUMA TOTAL: " + sumaPagos);
    return (sumaPagos);

}

function reajustarSumaPagos(montoPagar, montoInicial, id) {

  let selects = $('.inputMultiple'+id);
  var c=0;
  var sumaPagos= 0;
  
  selects.each(function () {

    let select = $(this);

    if(parseInt(select.val().replace(/\./g,'')) == montoPagar && c < 1){

      // console.log("*" + select.val());
      sumaPagos = sumaPagos + parseInt(select.val().replace(/\./g,''));
      c = c+1;

    }

  });

    // console.log("SUMA: " + sumaPagos);
    return (montoInicial + sumaPagos);

}

/*=============================================
  FIN DE METODOS PARA VALIDAR EL INGRESO DE PAGOS (2)
=============================================*/


/*=============================================
  METODO PARA ACTIVAR O DESACTIVAR AUTOMATICO
=============================================*/

$(".formularioPago").on("click", "input.chkAutomatico", function(){


  var idCuenta = $(this).attr("idCuenta");

  // alert("ingresa" + idCuenta);

  if($(this).is(':checked')) {

    // alert("checked");
    $(this).val("1");
    $('.nuevoRecibo'+idCuenta).attr('readonly', true);
    $('.nuevoRecibo'+idCuenta).val("");


  }else{

    // alert("no checked");

    $(this).val("0");
    $('.nuevoRecibo'+idCuenta).attr('readonly', false);
    $('.nuevoRecibo'+idCuenta).val("");
    $('.nuevoRecibo'+idCuenta).focus();

  }

  cargarLocalStorage();

});

/*=============================================
CALCULAR EL TOTAL DE PAGOS INGRESADOS
=============================================*/

function sumarTotalCuentas(){

    let selects = $('.inputNuevoMontoParcial');
    let selectsSec = $('.inputNuevoMontoParcialSec');
    var sumaPagos= 0;
  
    selects.each(function () {

        let select = $(this);
        // console.log("*" + select.val());
        sumaPagos = sumaPagos + parseInt(select.val().replace(/\./g,''));


    });

    selectsSec.each(function () {

        let selectSec = $(this);
        // console.log("*" + select.val());
        sumaPagos = sumaPagos + parseInt(selectSec.val().replace(/\./g,''));


    });

    $("#txtNuevoTotalCuenta").val(new Intl.NumberFormat("de-DE").format(sumaPagos));
    $("#txtTotalCuenta").val(sumaPagos);
    $("#txtNuevoTotalCuenta").attr("total",sumaPagos);

    // console.log("SUMA TOTAL: " + sumaPagos);
    return (sumaPagos);

}

function agregarFecha(){

  var now = new Date();

  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);

  var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

  $("#txtFechaPago").val(today);

}

/*=============================================
  RECORRER LA TABLA Y GUARDAR FORMULARIO
=============================================*/
// var c = 0;
// var f = 0;
// var finFila = false;

function guardarFormulario(){

    // alert($("#tablaCuentaPagar").find("tr.rowNuevo").length);
    // return;

    if ($("#tablaCuentaPagar").find("tr.rowNuevo").length < 1) {
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
    confirmButtonText: 'Si, guardar pago!',
    closeOnConfirm: false,
    closeOnCancel: true

  }, function(isConfirm) {

    if (isConfirm) {

        divLoading.style.display = "flex";

        const tableRows = $('#tablaCuentaPagar tr');

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

        /*=============================================
          DEVUELVE LAS FILA DEL BODY DE LA TABLA
        =============================================*/

        var nfilas = $("#tablaCuentaPagar").find("tr.rowNuevo");

        // alert(nfilas.length);
        // return;

        //Recorre las filas 1 a 1
        for (var i = 0; i < nfilas.length ; i++) {

            // f++;

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
            // pago = Number($($(celdas[8]).children().children().children()).val().replace(/\./g,'') / cantidad);
            codSucursal = Number($("#idSucursal").val().split("/", 1));
            // cantidad = Number($($(celdas[2]).children().children().children()).val());
            fechaVenc = $($(celdas[1]).children().children().children()).attr("fechaVenc");
            tipoVenta = $($(celdas[1]).children().children().children()).attr("tipoVenta");
            // saldo = (Number($($(celdas[9]).children().children().children()).val().replace(/\./g,'')) - pago);
            fechaPago = $("#txtFechaPago").val() + " " + hora;
            estadoCuenta = "Pendiente";
            nroMovimiento = Number($($(celdas[6]).children().children().children()).val());
            nroRecibo = Number($($(celdas[3]).children().children().children()).val());

            // console.log(pago);
            // return;

            /*=============================================
              VERIFICAMOS EL TIPO DE RECIBO
            =============================================*/

            if(Number($($(celdas[4]).children().children().children().children(".chkAutomatico")).val()) == 1){

                tipoRecibo = "AUTOMATICO";

            }else{

                tipoRecibo = "MANUAL";

            }

            /*================================================
              ESTOS TRES DATOS SE VA A GUARDAR EN FORMATO JSON
            =================================================*/

            metodoPago = $($(celdas[5]).children().children().children(".selectPago"));
            nroComprobante = $($(celdas[6]).children().children().children(".form-control"));
            montoPagar = $($(celdas[8]).children().children().children(".form-control"));

            pago = sumarCuenta(metodoPago, montoPagar);
            saldo = (Number($($(celdas[9]).children().children().children()).val().replace(/\./g,'')));


            formaPago = JSON.stringify(listarDetalleCuenta(metodoPago, nroComprobante, montoPagar, cantidad));
            // console.log(pago);
            // return;
           
            guardarPago(codCuenta, codUsuario, pago, fechaVenc, saldo, fechaPago, estadoCuenta, nroMovimiento, nroRecibo, tipoRecibo, formaPago, tipoVenta, cantidad);

            divLoading.style.display = "none";

            // console.log("CANTIDAD: " +  cantidad + " COD_CUENTA: " + codCuenta + " COD_USUARIO: "+ codUsuario + " PAGO: " + pago + " FECHA_VENC: " + fechaVenc + " SALDO: " + saldo + " FECHA_PAGO: " + fechaPago + " ESTADO_CUENTA: " + estadoCuenta + " NRO_MOVIMIENTO: " + nroMovimiento + " NRO_RECIBO: " + nroRecibo + " TIPO_RECIBO: " + tipoRecibo + " formaPago: " + formaPago + " TIPO_VENTA: " + tipoVenta);
            
        // }

    }

}

})

  return (false);

}


/*==================================================================
  EXTRAER DATOS AGREGADOS A LA TABLA PARA CARGAR EN EL LOCAL STORAGE
===================================================================*/

function cargarLocalStorage(){

    // alert("INGRESA");

    const tableRows = $('#tablaCuentaPagar tr');

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

    var nfilas = $("#tablaCuentaPagar").find("tr.rowNuevo");

    // alert(nfilas.length);
    // return;

    // console.log(nfilas.length);

    if(nfilas.length < 1){

        // localStorage.setItem("listaCuentasPagar", JSON.stringify("[]"));
        localStorage.removeItem("listaCuentasPagar");

    }else{

        //Recorre las filas 1 a 1
        for (var i = 0; i < nfilas.length ; i++) {

            // f++;

            //devolverá las celdas de una fila
            var celdas = $(nfilas[i]).find("td");

                
            /*=============================================
            RECUPERAMOS LOS DATOS DE CADA CELDA POR CADA FILA
            =============================================*/

            var hoy = new Date();
            var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();

            // codCuenta = cod_cuenta;
            codCuenta = $($(celdas[0]).children().children().children().children()).attr("idCuentaPagar");
            codUsuario = Number($("#idUsuario").val().split("/", 1));
            pago = Number($($(celdas[8]).children().children().children()).val().replace(/\./g,''));
            codSucursal = Number($("#idSucursal").val().split("/", 1));
            cantidad = Number($($(celdas[2]).children().children().children()).val());
            fechaVenc = $($(celdas[1]).children().children().children()).attr("fechaVenc");
            tipoVenta = $($(celdas[1]).children().children().children()).attr("tipoVenta");
            saldo = (Number($($(celdas[9]).children().children().children()).val().replace(/\./g,'')) - pago);
            fechaPago = $("#txtFechaPago").val() + " " + hora;
            estadoCuenta = "Pendiente";
            nroMovimiento = Number($($(celdas[6]).children().children().children()).val());
            nroRecibo = Number($($(celdas[3]).children().children().children()).val());

            /*=============================================
                VERIFICAMOS EL TIPO DE RECIBO
            =============================================*/

            if(Number($($(celdas[4]).children().children().children().children(".chkAutomatico")).val()) == 1){

                tipoRecibo = "Automatico";

            }else{

                tipoRecibo = "Manual";

            }

            /*=============================================
            VERIFICAMOS SI ES LA ULTIMA CUENTA PENDIENTE POR PAGAR
            =============================================*/

            if(saldo == 0){

                estadoCuenta = "Cancelado";

            }

            /*================================================
            ESTOS TRES DATOS SE VAN A GUARDAR EN FORMATO JSON
            =================================================*/

            metodoPago = $($(celdas[5]).children().children().children(".selectPago"));
            nroComprobante = $($(celdas[6]).children().children().children(".form-control"));
            montoPagar = $($(celdas[8]).children().children().children(".form-control"));

            formaPago = listarDetalleCuentaLocalStorage(metodoPago, nroComprobante, montoPagar);

            // console.log(formaPago);
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

            localStorage.setItem("listaCuentasPagar", JSON.stringify(listaPago));

            // console.log(formaPago);

        }

    }

}

/*=============================================
LISTAR TODOS LOS DETALLES DE PAGO DE CUENTA
=============================================*/

function listarDetalleCuenta(pago, nroComprobante, montoPagar, cantidad){

  var listaDetalleCuenta = [];

  // console.log(pago.length);

  for(var i = 0; i < pago.length; i++){

    // console.log($(pago[i]).val().split("/", 2)[1]);

    if(cantidad > 1){

        // console.log($(pago[i]).val().split("/", 0));

        listaDetalleCuenta.push({ "id_metodo" : $(pago[i]).val().split("/", 3)[0]+"/"+$(pago[i]).val().split("/", 3)[1],
                    "entrega" : (parseInt($(montoPagar[i]).val().replace(/\./g,''))),
                    "nrotransaccion" : $(nroComprobante[i]).val()})

    }else{

        // console.log("VACIO");
        listaDetalleCuenta.push({ "id_metodo" : $(pago[i]).val().split("/", 3)[0]+"/"+$(pago[i]).val().split("/", 3)[1],
                    "entrega" : $(montoPagar[i]).val().replace(/\./g,''),
                    "nrotransaccion" : $(nroComprobante[i]).val()})

    }

  }

  // $("#listaDetalleCuenta").val(JSON.stringify(listaDetalleCuenta));

  return(listaDetalleCuenta);

}

/*=============================================
    SUMAR EL TOTAL A PAGAR DE CADA CUENTA
=============================================*/

function sumarCuenta(metodoPago, montoPagar){

    var total=0;

    for(var i = 0; i < metodoPago.length; i++){

    // console.log($(metodoPago[i]).val().split("/", 2)[1]);

        if(cantidad > 1){

            // console.log(parseInt($(montoPagar[i]).val().replace(/\./g,'')) / parseInt(cantidad));

            total = total + parseInt($(montoPagar[i]).val().replace(/\./g,''));

        }else{

            // console.log($(montoPagar[i]).val().replace(/\./g,''));

            total = total + parseInt($(montoPagar[i]).val().replace(/\./g,''));

        }

    }

  return(total);

}

/*==============================================================
LISTAR TODOS LOS DETALLES DE PAGO DE CUENTA PARA EL LOCALSTORAGE
===============================================================*/

function listarDetalleCuentaLocalStorage(pago, nroComprobante, montoPagar){

  var listaDetalleCuentaLocalStorage = [];

  // console.log(pago.length);
  // return;

  for(var i = 0; i < pago.length; i++){

    if($(pago[i]).val() == ""){

        // console.log("VACIO");
        listaDetalleCuentaLocalStorage.push({ "id_metodo" : "",
                "entrega" : $(montoPagar[i]).val().replace(/\./g,''),
                "nrotransaccion" : $(nroComprobante[i]).val()})

    }else{

        // console.log($(pago[i]).val().split("/", 0));

        listaDetalleCuentaLocalStorage.push({ "id_metodo" : $(pago[i]).val().split("/", 3)[0]+"/"+$(pago[i]).val().split("/", 3)[1],
                "entrega" : $(montoPagar[i]).val().replace(/\./g,''),
                "nrotransaccion" : $(nroComprobante[i]).val()})

    }

  }

  return(listaDetalleCuentaLocalStorage);

}

/*====================================================
  OBTENEMOS LOS DATOS DE CUENTA A PAGAR Y LO GUARDAMOS
=====================================================*/

function guardarPago(codCuenta, codUsuario, pago, fechaVenc, saldo, fechaPago, estadoCuenta, nroMovimiento, nroRecibo, tipoRecibo, formaPago, tipoVenta, cantidad){

  // alert(cantidad);
  // alert(finFila + " - " + c);

  var datos = new FormData();
  datos.append("txtCodCuenta", codCuenta);
  datos.append("txtCodUsuario", codUsuario);
  datos.append("txtPago", pago);
  datos.append("txtFechaVenc", fechaVenc);
  datos.append("txtSaldo", saldo);
  datos.append("txtFechaPago", fechaPago);
  datos.append("txtEstadoCuenta", estadoCuenta);
  datos.append("txtNroMovimiento", nroMovimiento);
  datos.append("txtNroRecibo", nroRecibo);
  datos.append("txtTipoRecibo", tipoRecibo);
  datos.append("txtFormaPago", formaPago);
  datos.append("txtTipoVenta", tipoVenta);


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

      // alert(objData.msg);

      if (objData.status) {

        // if(c == cantidad && finFila == true){

          swal({

            title: "success", 
            text: objData.msg, 
            type: "success",
            confirmButtonColor: '#3085d6',

          }, function(isConfirm) {

            if (isConfirm) {

              // c = 0;
              // finFila = false;

              // localStorage.setItem("listaCuentasPagar", JSON.stringify("[]"));
              localStorage.removeItem("listaCuentasPagar");

              location.reload();

              // window.location = "cuentasPagar";

            }

          })

        // }

      } else {

        swal("Error", objData.msg, "error");

      }

    }

  })

  return (false);

}

/*====================================================
  CONSULTAR ULTIMO NUMERO DE RECIBO
=====================================================*/

function consultarRecibo(codCuenta){

  var nroRecibo = 1;

  // alert(codCuenta + " - " + codSucursal);

  var datos = new FormData();
  datos.append("tipoRecibo", "AUTOMATICO");


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

      // console.log(respuesta[0]["NRO_RECIBO"]);
      // return respuesta[0]["NRO_RECIBO"];

      if(respuesta[0]["NRO_RECIBO"] == null){

        nroRecibo = 1;

      }else{

        nroRecibo = parseInt(respuesta[0]["NRO_RECIBO"])+1;

      }

      // $.each(respuesta, function(i, value) {

      //   nroRecibo ++;

      // });

    }

  })

  return nroRecibo;

}

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
  MOSTRAR HISTORIAL DE PAGO DE LA CUENTA
=============================================*/

// $(document).on("click", ".historialCuenta", function() {

//   var idCuenta = $(this).attr("idCuenta");

//   mostrarCabeceraHistorial(idCuenta);
  
// })

/*==============================================================
 FUNCION PARA MOSTRAR CABECERA DEL HISTORIAL DE PAGO DE LA CUENTA
===============================================================*/

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
  MOSTRAR DATOS DEL PROVEEDOR SEGÚN CUENTA
=============================================*/

function mostrarDatosProveedor(idCuenta){

  var datos = new FormData();

  // console.log(idCuenta);

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

            // console.log(respuesta);

            // console.log(respuesta[0]["NOMBRE"]);
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
                divLoading.style.display = "flex";
                anularPago(codCuenta, codUsuario, pago, fechaVenc, saldo, fechaPago, estadoCuenta, formaPago, nroMovimiento, nroRecibo, tipoRecibo, agruparAnulado, detMovimiento, idCuentaCab, idCuenta);
                divLoading.style.display = "none";
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

        $(".tablaCuentasPagar").DataTable().ajax.url("ajax/tablaCuentasPagar.ajax.php?sucursal="+$("#idSucursal").val()+"&proveedor="+$("#cmbProveedorCuentas").val()).load();
        $('#tablaListadoCuentas').DataTable().ajax.reload();

      }else {

        swal("Error", objData.msg, "error");

      }

    }

  })

  return (false);

}

/*====================================================
  CARGAR REGISTROS DEL LOCALSTORAGE
=====================================================*/
$(document).ready(function(){

    agregarFecha();

    if (localStorage.getItem("listaCuentasPagar") != null && estadoNuevo == false) {

        var sucursal = $("#idSucursal").val();

        var listasCuentasPagar = JSON.parse(localStorage.getItem("listaCuentasPagar"));

        obtenerCuentaLocalStorage(listasCuentasPagar);

        quitarAgregarCuentaListadoPrincipal();

        cantidadItems();

        estadoNuevo = true;

      }

    setInterval(function() {

        if ($('.cargarCuentasPagar').is(':visible')) {

            // console.log("ingresa");

            if (localStorage.getItem("listaCuentasPagar") != null) {
                cargarLocalStorage();
            }

        }

    }, 4000);

    cantidadItems();
    
});

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


    $(".tablaListadoCuentas").DataTable().ajax.url("ajax/tablaListadoCuentas.ajax.php?sucursal=" + $("#idSucursal").val() + " &proveedor=" + proveedor + " &fechaInicio=" + fechaInicial + "&fechaFin=" + fechaFinal).load();

}

/*=============================================
FUNCIÓN PARA CONSULTAR RANGO DE FECHAS
=============================================*/

function cantidadItems() {

  const tableRows = $('#tablaCuentaPagar tr.rowNuevo');
  $('.Can').text(tableRows.length);
  $('.btncancelar').prop('disabled', false);

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

        url: "ajax/cuentasPagar.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        async:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {

           objData = JSON.parse(JSON.stringify(respuesta));

           if (objData.status) {

                swal("success", objData.msg, "success");

            }else {

                swal("Error", objData.msg, "error");

            }

          // console.log(respuesta[""]);
          // return;


        }

      })

      return(false);

})
