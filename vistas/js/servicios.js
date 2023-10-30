 document.write(`<script src="assets/js/JsBarcode.all.min.js"></script>`);
 let movimiento;
 let codigoBarraComparar;
 let clonar;
 let sucursal;
 let insertar;

 const formProducto = document.getElementById("formProducto");


 tablaProducto = $(".tablaProductos").DataTable({

     "ajax": "ajax/tablaServicios.ajax.php?sucursal=" + $("#idsucursal").val() + " &activo=" + $("#activo").val() + " &tipo_producto=" + "SERVICIOS",
     "deferRender": true,
     "retrieve": true,
     "processing": true,
     "bAutoWidth": false,
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
             "columns": [2, 3, 4, 5, 8]
         }
     }, {
         "extend": "excelHtml5",
         "text": "<i class='fas fa-file-excel'></i> Excel",
         "titleAttr": "Esportar a Excel",
         "className": "btn btn-success",
         "exportOptions": {
             "columns": [2, 3, 4, 5, 8]
         }
     }, {
         "extend": "pdfHtml5",
         "text": "<i class='fas fa-file-pdf'></i> PDF",
         "titleAttr": "Esportar a PDF",
         "className": "btn btn-danger",
         "exportOptions": {
             "columns": [2, 3, 4, 5, 8]
         }
     }, {
         "extend": "csvHtml5",
         "text": "<i class='fas fa-file-csv'></i> CSV",
         "titleAttr": "Esportar a CSV",
         "className": "btn btn-info",
         "exportOptions": {
             "columns": [2, 3, 4, 5, 8]
         }
     }]



 })

 if (document.querySelector("#txtCodigoBarra")) {
     let inputCodigo = document.querySelector("#txtCodigoBarra");
     inputCodigo.onkeyup = function() {
         if (inputCodigo.value.length >= 6) {
             document.querySelector('#divBarCode').classList.remove("notblock");
             fntBarcode();
         } else {
             document.querySelector('#divBarCode').classList.add("notblock");
         }
     };
 }


 function fntBarcode() {
     let codigo = $('input[name="txtCodigoBarra"]').val();
     JsBarcode("#barcode", codigo);
 }

 function fntPrintBarcode(area) {
     let elemntArea = document.querySelector(area);
     let vprint = window.open(' ', 'popimpr', 'height=400,width=600');
     vprint.document.write(elemntArea.innerHTML);
     vprint.document.close();
     vprint.print();
     vprint.close();
 }


 //Genera una cadena aleatoria según la longitud dada
 function getRandomString(length) {
     var text = "";
     var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

     for (var i = 0; i < length; i++)
         text += possible.charAt(Math.floor(Math.random() * possible.length));

     return text;
 }



 /*=============================================
 Editar productos
 =============================================*/

 $(document).on("click", ".GenerarCodigo", function() {
     var Barra = getRandomString(9);

     $('input[name="txtCodigoBarra"]').val(Barra);
     validarRepetido("CODBARRA", Barra, "txtCodigoBarra");
     if ($('input[name="txtCodigoBarra"]').val() == "") {
         var Barra = getRandomString(10);
         $('input[name="txtCodigoBarra"]').val(Barra);
     }
     generadorCodigoBarra($('input[name="txtCodigoBarra"]').val());

 })

 function generadorCodigoBarra(codigobarra) {

     if (codigobarra.length >= 6) {
         document.querySelector('#divBarCode').classList.remove("notblock");
         fntBarcode();
     } else {
         document.querySelector('#divBarCode').classList.add("notblock");
     }

 }

 // ES PARA GUARDAR LOS DATOS EN LA BASE DE DATOS//
 function Guardarformulario() {

     var txtcodigobarra = document.querySelector('input[name="txtCodigoBarra"]').value;
     var sucursal = $("#idsucursal").val();
     var insertar = 0;

     if (clonar == 0) {
         sucursal = $("#idsucursal").val();
         insertar = 0;
     } else {
         sucursal = $("#cmbSucursalHasta").val();
         insertar = 1;
     }


     var usuario = $("#idusuario").val();

     var txtcodProducto = document.querySelector('input[name="idProducto"]').value;
     var txtTokenProducto = document.querySelector('input[name="TokenProducto"]').value;
     var txtDescripcion = document.querySelector('input[name="txtDescripcion"]').value;
     var cmbCategoria = 1;
     var cmbSubCategoria = 1;
     var cmbMarca = 1;


     var txtpreciocompra = 0;
     var txtprecioventa = document.querySelector('input[name="txtPrecioVenta"]').value;

     var txtstock = 0;
     var cmbiva = 10;

     var cmbcanal = 1;

     var txtstockminimo = 0;
     var txtdimension = 0;
     var txtcantPaquete = 0;
     var cmbMedida ="UNIDADES";

     var txtUbicacion = 0;
     var txttipoProducto = "SERVICIOS";
     var txtOferta = 0;
     var chkoferta = 0;

     var idstock = $("#idStock").val();

     var datos = new FormData();

     datos.append("txtcodProducto", txtcodProducto);
     datos.append("txtTokenProducto", txtTokenProducto);
     datos.append("txtDescripcion", txtDescripcion);

     datos.append("cmbCategoria", 1);
     datos.append("cmbSubCategoria", 1);
     datos.append("cmbMarca", 1);
     datos.append("txtcodigobarra", txtcodigobarra);
     datos.append("txtpreciocompra", txtpreciocompra);
     datos.append("txtprecioventa", txtprecioventa);
     datos.append("cmbcanal", 1);
     datos.append("txtstock", 0);
     datos.append("cmbiva", cmbiva);

     datos.append("txtstockminimo", 0);
     datos.append("txtdimension", txtdimension);
     datos.append("txtcantPaquete", txtcantPaquete);
     datos.append("cmbMedida", "UNIDADES");
     datos.append("txtUbicacion", txtUbicacion);
     datos.append("txttipoProducto", txttipoProducto);
     datos.append("txtOferta", txtOferta);
     datos.append("chkoferta", chkoferta);
     datos.append("sucursal", sucursal);
     datos.append("usuario", usuario);
     datos.append("idstock", idstock);
     datos.append("txtproductos", "");
     datos.append("insertar", insertar);
     datos.append("movimiento", movimiento);

     $.ajax({
         url: "ajax/productos.ajax.php",
         method: "POST",
         data: datos,
         cache: false,
         contentType: false,
         processData: false,

         success: function(respuesta) {

             var objData = JSON.parse(respuesta);

          
             if (objData.status) {

                
                 swal("success", objData.msg, "success");

                 $('#ModalProductos').modal('hide');

                 recargarDatatable();

             } else {

                 swal("Error", objData.msg, "error");

             }
             divLoading.style.display = "none";
         }

     })

     return (false);


 }

 function recargarDatatable() {

     tablaProducto.ajax.reload(function() {
         //tablaProductoAgotados.ajax.reload();
         var count = $('.tablaProductos > * > tr').length - 1;
         LimpiarText();

     });
 }
 /*=============================================
 Clonar productos
 =============================================*/

 $(document).on("click", ".ClonarProducto", function() {

     var token_producto = $(this).attr("tokenProductos");
     clonar = $(this).attr("clonar");

     $(".seleccioneSucursal").removeClass("notblock");
     $(".mostrarGrilla").addClass("notblock");

     $('#tokenproducto').val(token_producto);
     $('#clonarnuevo').val(clonar);

 })

 /*=============================================
 Clonar productos
 =============================================*/

 $(document).on("click", "#btnCargar", function() {

     var token_producto = $('#tokenproducto').val();
    clonar = $('#clonarnuevo').val();

     $(".seleccioneSucursal").removeClass("notblock");
     $(".mostrarGrilla").addClass("notblock");
     $("#divBarCode").addClass("notblock");


     Editarformulario(token_producto, clonar);

 })

 /*=============================================
 cerra venta clonacion
 =============================================*/

 $(document).on("click", "#CerrarVentaClonar", function() {

     $(".mostrarGrilla").removeClass("notblock");
     $(".seleccioneSucursal").addClass("notblock");


 })



 /*=============================================
 Editar productos
 =============================================*/

 $(document).on("click", ".editarProductos", function() {

     var token_producto = $(this).attr("tokenProductos");
     clonar = $(this).attr("clonar");

     $(".seleccioneSucursal").addClass("notblock");
     $(".mostrarGrilla").removeClass("notblock");

     Editarformulario(token_producto, clonar);

 })

 function Editarformulario(token_producto, clonar) {

     LimpiarText();

     if (clonar == 1) {

         document.querySelector("#titulo").innerHTML = "Clonar servicios";
         document.querySelector("#btnGuardar").innerHTML = "Clonar servicios";
         $('input[name="txtStock"]').removeAttr('disabled', 'disabled');
         movimiento = "CLONACION DIRECTA";

     } else {
  
         document.querySelector("#titulo").innerHTML = "Editar servicios";
         document.querySelector("#btnGuardar").innerHTML = "Actualizar";
         $('input[name="txtStock"]').prop('disabled', 'disabled');

     }


     var token_producto = token_producto;
     var sucursal = $('#idsucursal').val();
     var activo = $('#activo').val();

     var datos = new FormData();

     datos.append("token_producto", token_producto);
     datos.append("sucursal", sucursal);
     datos.append("tipo_producto", "SERVICIOS");
     datos.append("activo", activo);

     $.ajax({

         url: "ajax/productos.ajax.php",
         method: "POST",
         data: datos,
         cache: false,
         contentType: false,
         processData: false,
         dataType: "json",
         success: function(respuesta) {

             $('input[name="txtCodigoBarra"]').val(respuesta["CODBARRA"]);
             codigoBarraComparar = respuesta["CODBARRA"];
             var valor = respuesta["CODBARRA"];
             var valor1 = $("#cmbSucursalHasta").val();


             if (clonar == 1) {
                 validarRepetido("CODBARRA", valor, valor1, "txtCodigoBarra");
                 if ($("#idsucursal").val() === $("#cmbSucursalHasta").val()) {
                     $('input[name="idProducto"]').val("");
                     $('input[name="TokenProducto"]').val("");
                     insertar = 1;
                     sucursal = $("#cmbSucursalHasta").val();
                 } else {
                     $('input[name="idProducto"]').val(respuesta["COD_PRODUCTO"]);
                     $('input[name="TokenProducto"]').val(respuesta["TOKEN_PRODUCTO"]);
                     insertar = 0;
                     sucursal = $("#idsucursal").val();
                 }
             } else {

                 $('input[name="idProducto"]').val(respuesta["COD_PRODUCTO"]);
                 $('input[name="TokenProducto"]').val(respuesta["TOKEN_PRODUCTO"]);
                 insertar = 0;
                 sucursal=$("#idsucursal").val();
             }


             if ($('input[name="txtCodigoBarra"]').val() != "") {
                 generadorCodigoBarra(respuesta["CODBARRA"]);

             }

             $('input[name="txtDescripcion"]').val(respuesta["DESCRIPCION"]);

             $('input[name="txtPrecioVenta"]').val(respuesta["PRECIO_CONTADO"]);
             $('input[name="txtPrecioVenta"]').number(true, 0);

             $("#idStock").val(respuesta["COD_STOCK"] + "/" + respuesta["TOKEN_STOCK"]);
        

         }


     })

 }



 /*=============================================
 Eliminar PRODUCTOS
 =============================================*/

 $(document).on("click", ".eliminarProductos", function() {

     var tokenProductos = $(this).attr("tokenProductos");
     var galeria = [];
     var token_stock = $(this).attr("token_stock");
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
             datos.append("idEliminar", tokenProductos);
             datos.append("galeria", galeria);
             datos.append("token_stock", token_stock);

             $.ajax({

                 url: "ajax/productos.ajax.php",
                 method: "POST",
                 data: datos,
                 cache: false,
                 contentType: false,
                 processData: false,
                 success: function(respuesta) {

                     var objData = JSON.parse(respuesta);

                     if (objData.status) {

                         swal("success", objData.msg, "success");
                         recargarDatatable();


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
                                     //descactivar productos

                                     var datos = new FormData();

                                     datos.append("desactivarToken", token_stock);
                                     datos.append("estadoProducto", 0);


                                     $.ajax({

                                         url: "ajax/productos.ajax.php",
                                         method: "POST",
                                         data: datos,
                                         cache: false,
                                         contentType: false,
                                         processData: false,
                                         success: function(respuesta) {



                                             var objData = JSON.parse(respuesta);

                                             if (objData.status) {

                                                 swal("success", objData.msg, "success");
                                                 recargarDatatable();

                                             }

                                         }

                                     })

                                 }

                             });

                         }
                     }

                 }

             })

         }

     });

 })

 /*=============================================
 DESACTIVAR PRODUCTOS
 =============================================*/

 $(document).on("click", ".btnActivarProducto", function() {

     var token_stock = $(this).attr("token_stock");
     var estadoProducto = $(this).attr("estadoProducto");
     swal({
         title: '¿Está seguro de desactivar el registro?',
         text: "¡Si no lo está puede cancelar la acción!..¡Puedes volver a recuperar en el modulo dar de alta!",
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         cancelButtonText: 'Cancelar',
         confirmButtonText: 'Si, desactiar el dato!',
         closeOnConfirm: false,
         closeOnCancel: true
     }, function(isConfirm) {

         if (isConfirm) {

             var datos = new FormData();

             datos.append("desactivarToken", token_stock);
             datos.append("estadoProducto", estadoProducto);


             $.ajax({

                 url: "ajax/productos.ajax.php",
                 method: "POST",
                 data: datos,
                 cache: false,
                 contentType: false,
                 processData: false,
                 success: function(respuesta) {

                     var objData = JSON.parse(respuesta);

                     if (objData.status) {

                         swal("success", objData.msg, "success");
                         recargarDatatable();


                     }

                 }

             })

         }

     });

 })


 $(document).on("click", ".btnNuevo", function() {

     document.querySelector("#titulo").innerHTML = "Nuevo servicios";
     document.querySelector("#btnGuardar").innerHTML = "Guardar";
     LimpiarText();
     movimiento = "CARGA DIRECTA";
     $('input[name="txtStock"]').removeAttr('disabled', 'disabled');
     sucursal = $("#idsucursal").val();

 })

 function LimpiarText() {

    
     formProducto.reset();
     $("#idProducto").val("");
     $("#TokenProducto").val("");
     //$(".inputNuevaGaleria").val("");
     generadorCodigoBarra("");

 }


 /*=============================================
 VALIDAR EMAIL REPETIDO
 =============================================*/

 $('input[name="txtCodigoBarra"]').change(function() {

     var valor = $(this).val();
     var valor1 = $("#idsucursal").val();
     validarRepetido("CODBARRA", valor, valor1, "txtCodigoBarra");

 })


 function validarRepetido(item, valor, valor1, nombre) {
     $(".alert").remove();
     var datos = new FormData();
     datos.append("item", item);
     datos.append("valor", valor);
     datos.append("valor1", valor1);
     $.ajax({
         url: "ajax/productos.ajax.php",
         method: "POST",
         data: datos,
         cache: false,
         contentType: false,
         processData: false,
         success: function(respuesta) {
             if (respuesta == "true") {

                 $('#' + nombre).parent().after('<div class="alert alert-warning">  <strong>ERROR: </strong>Este registro ya existe en la base de datos</div>');

                 $('#' + nombre).val("");
                 return;

             }
         }

     })

 }

 /*=============================================
 VALIDAR EMAIL REPETIDO
 =============================================*/

 $('input[name="txtDescripcion"]').change(function() {
     var valor = $(this).val();

     validarRepetido("DESCRIPCION", valor, "txtDescripcion");


 })
