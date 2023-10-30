 document.write(`<script src="assets/js/JsBarcode.all.min.js"></script>`);
 let movimiento;
 let codigoBarraComparar;
 let clonar;
 let sucursal;
 let insertar;

 const formProducto = document.getElementById("formProducto");


 tablaProducto = $(".tablaProductos").DataTable({

     "ajax": "ajax/tablaFletes.ajax.php?sucursal=" + $("#idsucursal").val() + " &activo=" + $("#activo").val() + " &tipo_producto=" + "FLETES",
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


     var txtpreciocompra = document.querySelector('input[name="txtPrecioCompra"]').value;
     var txtprecioventa = document.querySelector('input[name="txtPrecioVenta"]').value;

     var txtstock = 0;
     var cmbiva = 0;

     var cmbcanal = 1;

     var txtstockminimo = 0;
     var txtdimension = 0;
     var txtcantPaquete = 0;
     var cmbMedida ="UNIDADES";

     var txtUbicacion = 0;
     var txttipoProducto = "FLETES";
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

     // alert("Cod: "+txtcodProducto + " token: " + txtTokenProducto + " Desc: "+txtDescripcion + " Categ: "+cmbCategoria + " Subc: "+cmbSubCategoria + " Marca: "+cmbMarca + " Barra: "+txtcodigobarra + " Compra: "+txtpreciocompra + " Venta: "+txtprecioventa + " Mayor: "+txtpreciomayorista + " Desc: "+txtdescuento + " Stock: "+txtstock + " iva: "+cmbiva + " Galeria: "+galeria + " Antigua: "+galeriaAntigua + " Estatica: "+galeriaAntiguaEstatica + " idStock: " + idstock);
     // return;

     // mostrarLoading(); //se muestra el mensaje de cargando
 
     // return;

     $.ajax({
         url: "ajax/productos.ajax.php",
         method: "POST",
         data: datos,
         cache: false,
         contentType: false,
         processData: false,

         success: function(respuesta) {

             var objData = JSON.parse(respuesta);

             // verificarLoading();//verificar si se agregó alguna imagen

             if (objData.status) {

                
                 swal("success", objData.msg, "success");

                 $('#ModalProductos').modal('hide');

                 recargarDatatable();

             } else {

                 // cerrarLoading();

                 swal("Error", objData.msg, "error");

                 // LimpiarText();
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

         document.getElementById("agregarGaleria").style.display = "none";
         document.querySelector("#titulo").innerHTML = "Clonar flete";
         document.querySelector("#btnGuardar").innerHTML = "Clonar flete";
         $('input[name="txtStock"]').removeAttr('disabled', 'disabled');
         movimiento = "CLONACION DIRECTA";

     } else {
         document.getElementById("agregarGaleria").style.display = "block";
         document.querySelector("#titulo").innerHTML = "Editar flete";
         document.querySelector("#btnGuardar").innerHTML = "Actualizar";
         $('input[name="txtStock"]').prop('disabled', 'disabled');

     }


     var token_producto = token_producto;
     var sucursal = $('#idsucursal').val();
     var activo = $('#activo').val();

     var datos = new FormData();

     datos.append("token_producto", token_producto);
     datos.append("sucursal", sucursal);
     datos.append("tipo_producto", "FLETES");
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

             $("#cmbCategoria").val(respuesta["COD_CATEGORIA"] + '/' + respuesta["TOKEN_CATEGORIA"])


             //$('label[name="editarSubCategoria"]').text(respuesta["NOMBRE_PRODUCTOS"]);
             $("#cmbSubCategoria").val(respuesta["COD_SUBCATEGORIA"] + '/' + respuesta["TOKEN_SUBCATEGORIA"]);

             $("#cmbMarca").val(respuesta["COD_MARCA"] + '/' + respuesta["TOKEN_MARCA"]);

             $("#cmbcanal").val(respuesta["COD_CANAL"] + '/' + respuesta["TOKEN_CANAL"]);


             //   $('label[name="editarCategoria"]').text(respuesta["NOMBRE_FUNC"]);


             $('input[name="txtPrecioCompra"]').val(respuesta["PRECIO_COMPRA"]);
             $('input[name="txtPrecioCompra"]').number(true, 0);

             $('input[name="txtPrecioVenta"]').val(respuesta["PRECIO_CONTADO"]);
             $('input[name="txtPrecioVenta"]').number(true, 0);

             $("#idStock").val(respuesta["COD_STOCK"] + "/" + respuesta["TOKEN_STOCK"]);
             $(".inputAntiguaGaleria").val((respuesta["IMAGEN_PRODUCTO"]));

             // COLOCAR LAS IMAGENES

             if (respuesta["IMAGEN_PRODUCTO"] != '[""]' && respuesta["IMAGEN_PRODUCTO"] != null && respuesta["IMAGEN_PRODUCTO"] != '') {

                 multiplesArchivosAntiguos(respuesta["IMAGEN_PRODUCTO"]);

             }



         }


     })

 }



 /*=============================================
 Eliminar PRODUCTOS
 =============================================*/

 $(document).on("click", ".eliminarProductos", function() {

     var tokenProductos = $(this).attr("tokenProductos");
     var galeria = $(this).attr("galeria");
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

     document.getElementById("agregarGaleria").style.display = "none";
     document.querySelector("#titulo").innerHTML = "Nuevo flete";
     document.querySelector("#btnGuardar").innerHTML = "Guardar";
     LimpiarText();
     movimiento = "CARGA DIRECTA";
     $('input[name="txtStock"]').removeAttr('disabled', 'disabled');
     sucursal = $("#idsucursal").val();

 })

 function LimpiarText() {

     //$(".quitarFotoNueva").parent().parent().remove();
     $(".quitarFotoAntigua").parent().parent().remove();
     formProducto.reset();
     $("#idProducto").val("");
     $("#TokenProducto").val("");
     //$(".inputNuevaGaleria").val("");
     $(".inputAntiguaGaleria").val("");
     //$(".inputAntiguaGaleriaEstatica").val("");

     archivosTemporales = [];
     archivosTemporalesAntiguo = [];

     imagenPermitidoNuevo = [];
     imagenPermitidoAntiguo = [];
     ubicacion = [];

     mensajeFinal = "ninguno"

     $(".alert").remove();

     $("#galeria").val("");
     cerrarLoading();
     generadorCodigoBarra("");

 }

 function LimpiarTextProductos() {

     formProductoImagen.reset();
     // $(".quitarFotoAntiguaProducto").parent().parent().remove();
     // $("#idProductoImagen").val("");
     // $("#TokenProductoImagen").val("");
     //$(".inputNuevaGaleriaProducto").val("");
     $(".inputAntiguaGaleriaProducto").val("");
     //$(".inputAntiguaGaleriaProductoEstatica").val("");
     $("#galeriaProducto").val("");

     archivosTemporales = [];
     archivosTemporalesAntiguo = [];

     imagenPermitidoNuevo = [];
     imagenPermitidoAntiguo = [];
     ubicacion = [];
 }


 //============================================IMAGEN DE PRODUCTOS===========================================================

 /*=============================================
 ARRASTRAR VARIAS IMAGENES GALERÍA
 =============================================*/

 var archivosTemporales = [];
 var imagenPermitidoNuevo = [];
 var imagenPermitidoAntiguo = [];
 var ubicacion = [];

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

     document.getElementById('galeria').files = e.originalEvent.dataTransfer.files;
     var archivos = document.getElementById('galeria').files;

     multiplesArchivos(archivos);


 })

 /*=============================================
 AGREGAR IMAGEN EN LA GALERÍA
 =============================================*/

 function multiplesArchivos(archivos) {

     // alert(archivos.length+archivosTemporales.length+archivosTemporalesAntiguo.length);
     // return;
     for (var i = 0; i < archivos.length; i++) {
         if (archivosTemporalesAntiguo.length + i < 5) {

             //for (var i = 0; i < archivos.length; i++) {

             mostrarLoading(); //se muestra el mensaje de cargando

             var imagen = archivos[0];

             if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {

                 swal({
                     title: "Error al subir la imagen",
                     text: "¡La imagen debe estar en formato JPG o PNG!",
                     type: "error",
                     confirmButtonText: "¡Cerrar!"
                 });
                 cerrarLoading();
                 return;

             } else if (imagen["size"] > 15000000) {

                 swal({
                     title: "Error al subir la imagen",
                     text: "¡La imagen no debe pesar más de 15MB!",
                     type: "error",
                     confirmButtonText: "¡Cerrar!"
                 });
                 cerrarLoading();

                 return;

             } else {


                 //   archivosTemporales.push(rutaImagen);
                 ubicacion.push(imagen["name"]);

                 //     imagenPermitidoNuevo=archivosTemporales;


                 //   $(".inputNuevaGaleria").val(JSON.stringify(archivosTemporales));
                 // $(".inputGaleria").val(JSON.stringify(ubicacion));

                 var txtcodProducto = document.querySelector('input[name="idProducto"]').value;
                 var txtTokenProducto = document.querySelector('input[name="TokenProducto"]').value;

                 //  var galeria = $(".inputGaleria").val();
                 var galeriaAntigua = $(".inputAntiguaGaleria").val();
                 //  var galeriaAntiguaEstatica = $(".inputAntiguaGaleriaEstatica").val();
                 var img = document.getElementById('galeria').files[i];
                 var cantidad = ubicacion.length;
                 agregarImagen(img, txtTokenProducto, galeriaAntigua, cantidad);



             }

         } else {

             swal({
                 title: "Error al subir la imagen",
                 text: "¡Está permitido como máximo 5 imagenes!",
                 type: "error",
                 confirmButtonText: "¡Cerrar!"
             });

             cerrarLoading()

             return;

         }

     }

 }


 /*=============================================
 AGREGAR IMAGENES ANTIGUOS
 =============================================*/

 archivosTemporalesAntiguo = [];

 function multiplesArchivosAntiguos(archivos) {

     var longitud = JSON.parse(archivos);
     //console.log(longitud.length);

     $(".vistaGaleria").remove();

     $("#AgregarNuevo").append(`

    <ul class="row p-0 vistaGaleria">
    </ul>`

     );
     for (var i = 0; i < longitud.length; i++) {

         var imagen = longitud[i];

         //   $(imagen).on("load", function(event){

         var rutaImagen = imagen;

         $(".vistaGaleria").append(`

               <li class="col-12 col-md-6 col-lg-3 card px-0 rounded-10 shadow-none img-fluid" id="mostarImagenantiguo">
                      
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
     swal({
         title: '¿Está seguro de eliminar esta imagen?',
         text: "¡Si no lo está puede cancelar la acción!",
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         cancelButtonText: 'Cancelar',
         confirmButtonText: 'Si, eliminar imagen!',
         closeOnConfirm: false,
         closeOnCancel: true
     }, function(isConfirm) {

         if (isConfirm) {

             // GuardarImagen();
             //  var txtcodProducto =document.querySelector('input[name="idProducto"]').value;
             var txtTokenProducto = document.querySelector('input[name="TokenProducto"]').value;
             var rutavieja = $(".inputAntiguaGaleria").val();
             // var rutacompleta = $(".inputAntiguaGaleriaEstatica").val();
             BorrarImagen(txtTokenProducto, rutavieja);
         } else {
             var token_producto = "0/" + $('#TokenProducto').val();
             verImagen(token_producto);
         }

     });



 })


 /*=============================================
 AGREGAR EN LA BASE DE DATOS LA IMAGEN
 =============================================*/
 var a = 0;

 function agregarImagen(img, token, rutavieja, cant) {

     datosMultimedia = new FormData();



     //  for(var i = 0; i < document.getElementById('galeria').files.length; i++){

     // var img = document.getElementById('galeria').files[i];

     // alert(token, ruta, rutavieja, rutacompleta);
     // return;

     datosMultimedia.append("tabla", "productos");
     datosMultimedia.append("token", token);
     datosMultimedia.append("token_columna", "TOKEN_PRODUCTO");
     datosMultimedia.append("rutavieja", rutavieja);
     datosMultimedia.append("foto_columna", "IMAGEN_PRODUCTO");
     datosMultimedia.append("file", img);
     datosMultimedia.append("carpeta", "productos");

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

             a = cant - 1;
             // console.log("cant", a);

             if (a == 0) {

                 a = 0;
                 ubicacion = [];
                 cerrarLoading();
                 swal("success", res.msg, "success");
                 var token_producto = "0/" + $('#TokenProducto').val();

                 verImagen(token_producto);

             }

         } else {

             alert(res.msg);

         }

     }).fail(err => {

         // cerrarLoading();

         swal("Error", err.msg, "error");
         return;

     })

     //  }

 }



 function BorrarImagen(token, rutavieja) {

     /*=============================================
      PREGUNTAMOS SI LOS CAMPOS OBLIGATORIOS ESTÁN LLENOS
      =============================================*/

     // alert(imagen.length-1);
     // return;

     // if(rutavieja != ""){

     /*=============================================
       PREGUNTAMOS SI VIENEN IMÁGENES PARA MULTIMEDIA O LINK DE YOUTUBE
       =============================================*/

     //  if(rutavieja.length > 0){

     datosMultimedia = new FormData();
     var c = 0;


     //   document.getElementById('galeria').files[i]=imagen[i];

     datosMultimedia.append("tabla", "productos");
     datosMultimedia.append("token", token);
     datosMultimedia.append("token_columna", "TOKEN_PRODUCTO");
     datosMultimedia.append("rutavieja", rutavieja);
     datosMultimedia.append("foto_columna", "IMAGEN_PRODUCTO");
     datosMultimedia.append("carpeta", "productos");

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

             // cerrarLoading();

             c++;

             //  if( c == imagen.length){
             cerrarLoading();
             swal("success", res.msg, "success");
             var token_producto = "0/" + $('#TokenProducto').val();
             Editarformulario(token_producto);


             //    }

         } else {

             alert(res.msg);

         }

     }).fail(err => {

         // cerrarLoading();

         swal("Error", err.msg, "error");
         return;

     })



     //  }

     // }

 }

 //============================================FIN IMAGEN DE PRODUCTOS===========================================================

 //============================================IMAGEN DE MOSTRAR PRODUCTOS===========================================================

 /*=============================================
 ARRASTRAR VARIAS IMAGENES GALERÍA
 =============================================*/

 // var archivosTemporales = [];
 // var imagenPermitidoNuevo = [];
 // var imagenPermitidoAntiguo = [];
 // var ubicacion = [];

 $(".subirGaleriaProducto").on("dragenter", function(e) {

     // alert("dragenter");

     e.preventDefault();
     e.stopPropagation();

     $(".subirGaleriaProducto").css({
         "background": "url(vistas/img/plantilla/pattern.jpg)"
     })

 })

 $(".subirGaleriaProducto").on("dragleave", function(e) {

     // alert("dragleave");

     e.preventDefault();
     e.stopPropagation();

     $(".subirGaleriaProducto").css({
         "background": ""
     })

 })

 $(".subirGaleriaProducto").on("dragover", function(e) {

     // alert("dragover");

     e.preventDefault();
     e.stopPropagation();

 })

 $("#galeriaProducto").change(function() {

     // alert("change");
     // LimpiarTextProductos();

     var archivos = this.files;
     document.getElementById('galeriaProducto').files = this.files;

     multiplesArchivosProductos(archivos);

 })

 $(".subirGaleriaProducto").on("drop", function(e) {

     // alert("drop");

     e.preventDefault();
     e.stopPropagation();

     $(".subirGaleriaProducto").css({
         "background": ""
     })

     document.getElementById('galeriaProducto').files = e.originalEvent.dataTransfer.files;
     var archivos = document.getElementById('galeriaProducto').files;

     multiplesArchivosProductos(archivos);


 })

 /*=================================================
 AGREGAR IMAGEN EN LA GALERÍA DE VISTA DE PRODUCTOS
 ==================================================*/
 var imagenPermitido = [];

 function multiplesArchivosProductos(archivos) {

     // alert(archivos.length);
     // return;

     if (archivos.length > 0) {

         for (var i = 0; i < archivos.length; i++) {

             //  if((archivos.length+archivosTemporales.length+archivosTemporalesAntiguo.length) <= 5){
             if (archivosTemporalesAntiguo.length + i < 5) {

                 mostrarLoadingProducto(); //se muestra el mensaje de cargando

                 var imagen = archivos[0];

                 if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {

                     swal({
                         title: "Error al subir la imagen",
                         text: "¡La imagen debe estar en formato JPG o PNG!",
                         type: "error",
                         confirmButtonText: "¡Cerrar!"
                     });

                     cerrarLoadingProducto();
                     return;

                 } else if (imagen["size"] > 15000000) {

                     swal({
                         title: "Error al subir la imagen",
                         text: "¡La imagen no debe pesar más de 15MB!",
                         type: "error",
                         confirmButtonText: "¡Cerrar!"
                     });
                     cerrarLoadingProducto();

                     return;

                 } else {


                     ubicacion.push(imagen["name"]);

                     $(".inputGaleriaProducto").val(JSON.stringify(ubicacion));

                     var txtcodProducto = document.querySelector('input[name="idProductoImagen"]').value;
                     var txtTokenProducto = document.querySelector('input[name="TokenProductoImagen"]').value;

                     // var galeria = $(".inputGaleriaProducto").val();

                     // alert(galeriaAntigua);

                     var galeriaAntigua = $(".inputAntiguaGaleriaProducto").val();
                     //  var galeriaAntiguaEstatica = $(".inputAntiguaGaleriaProductoEstatica").val();
                     var img = document.getElementById('galeriaProducto').files[i];
                     var cantidad = ubicacion.length;
                     agregarImagenProducto(img, txtTokenProducto, galeriaAntigua, cantidad);



                 }

             } else {

                 swal({
                     title: "Error al subir la imagen",
                     text: "¡Está permitido como máximo 5 imagenes!",
                     type: "error",
                     confirmButtonText: "¡Cerrar!"
                 });

                 cerrarLoading()

                 return;

             }

         } // termina el for                


     }

 }


 /*=========================================================
 AGREGAR EN LA BASE DE DATOS LA IMAGEN DE VISTA DE PRODUCTOS
 ===========================================================*/
 var c = 0;

 function agregarImagenProducto(img, token, rutavieja, cant) {

     datosMultimedia = new FormData();


     // console.log(document.getElementById('galeriaProducto').files.length);

     //   for(var i = 0; i < document.getElementById('galeriaProducto').files.length; i++){


     //   console.log("img", img);
     //  var ruta =document.getElementById('galeriaProducto').files[i]["name"];
     // console.log("ruta", ruta);
     // return;

     datosMultimedia.append("tabla", "productos");
     datosMultimedia.append("token", token);
     datosMultimedia.append("token_columna", "TOKEN_PRODUCTO");
     datosMultimedia.append("rutavieja", rutavieja);
     datosMultimedia.append("foto_columna", "IMAGEN_PRODUCTO");
     datosMultimedia.append("file", img);
     datosMultimedia.append("carpeta", "productos");

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

             // cerrarLoading();

             c = cant - 1;
             //    console.log("cant", c);

             if (c == 0) {
                 ubicacion = [];
                 c = 0;
                 cerrarLoadingProducto();
                 swal("success", res.msg, "success");
                 var token_producto = "0/" + $('#TokenProductoImagen').val();
                 LimpiarTextProductos();
                 verImagenProductos(token_producto);

             }

         } else {

             alert(res.msg);

         }

     }).fail(err => {

         // cerrarLoading();

         swal("Error", err.msg, "error");
         return;

     })

     //    }


 }

 /*=============================================
 MOSTRAR IMAGENES DE PRODUCTOS
 =============================================*/

 $(document).on("click", ".verProductos", function() {

     LimpiarTextProductos();

     var token_producto = $(this).attr("tokenProductos");
     verImagenProductos(token_producto);


 })

 function verImagenProductos(token_producto) {

     var cadena = token_producto.split("/");

     $("#idProductoImagen").val(cadena[0]);
     $("#TokenProductoImagen").val(cadena[1]);

     var datos = new FormData();

     datos.append("token", token_producto);

     $.ajax({

         url: "ajax/productos.ajax.php",
         method: "POST",
         data: datos,
         cache: false,
         contentType: false,
         processData: false,
         dataType: "json",
         success: function(respuesta) {

             archivosTemporalesAntiguo = [];

             // COLOCAR LAS IMAGENES

             // $(".inputAntiguaGaleriaProductoEstatica").val((respuesta["IMAGEN_PRODUCTO"]));

             if (respuesta["IMAGEN_PRODUCTO"] != '[""]' && respuesta["IMAGEN_PRODUCTO"] != null && respuesta["IMAGEN_PRODUCTO"] != '') {

                 multiplesArchivosAntiguosProductos(respuesta["IMAGEN_PRODUCTO"]);

             }


         }


     })


 }


 function verImagen(token_producto) {


     var datos = new FormData();

     datos.append("token", token_producto);

     $.ajax({

         url: "ajax/productos.ajax.php",
         method: "POST",
         data: datos,
         cache: false,
         contentType: false,
         processData: false,
         dataType: "json",
         success: function(respuesta) {

             archivosTemporalesAntiguo = [];

             // COLOCAR LAS IMAGENES

             if (respuesta["IMAGEN_PRODUCTO"] != '[]' && respuesta["IMAGEN_PRODUCTO"] != null && respuesta["IMAGEN_PRODUCTO"] != '') {

                 multiplesArchivosAntiguos(respuesta["IMAGEN_PRODUCTO"]);

             }


         }


     })


 }

 /*=============================================
 AGREGAR IMAGENES ANTIGUOS
 =============================================*/

 archivosTemporalesAntiguo = [];

 function multiplesArchivosAntiguosProductos(archivos) {

     var longitud = JSON.parse(archivos);
     // console.log(longitud.length);

     $("#mostrarImagen").remove();

     $("#modalBodyProducto").append(

         '<div class="row" id="mostrarImagen"></div>'

     );

     if (longitud.length < 1) {

         $("#mostrarImagen").append(

             '<div class="col-lg-12 col-md-12 col-xs-12 rounded-10 shadow-none img-fluid" style="margin: 0 !important; padding: 20px;">' +

             '<img src="vistas/img/productos/default/anonymous.png" style="width: 100%; height: 100%;">' +

             '</div>'

         );

     }

     for (var i = 0; i < longitud.length; i++) {

         var imagen = longitud[i];

         var rutaImagen = imagen;


         $("#mostrarImagen").append(`

      <div class="col-lg-6 col-md-12 col-xs-12 rounded-10 shadow-none img-fluid" style=":hover {border: 5px solid #f7f7f7}; margin: 0 !important; padding: 10px;">

        <img src="` + rutaImagen + `" style="width: 100%; height: 100%;">

        <div class="card-img-overlay p-2 pr-2">
                        
          <button class="btn btn-danger btn-sm float-right shadow-sm quitarFotoAntiguaProducto" temporalProducto="` + rutaImagen + `">
                           
            <i class="fas fa-times"></i>

          </button>

        </div>

      </div>

    `);

         archivosTemporalesAntiguo.push(rutaImagen.split(','));
         imagenPermitidoAntiguo = archivosTemporalesAntiguo;

         $(".inputAntiguaGaleriaProducto").val(archivosTemporalesAntiguo);

     } // termina el for

 }

 /*=============================================
 QUITAR IMAGEN ANTIGUO VISTA DE PRODUCTOS
 =============================================*/

 $(document).on("click", ".quitarFotoAntiguaProducto", function() {

     var listaFotosAntiguas = $(".quitarFotoAntiguaProducto");

     var listaTemporales = $(".inputAntiguaGaleriaProducto").val().split(",");

     for (var i = 0; i < listaFotosAntiguas.length; i++) {

         quitarImagen = $(this).attr("temporalProducto");


         if (quitarImagen == listaTemporales[i]) {

             listaTemporales.splice(i, 1);

             $(".inputAntiguaGaleriaProducto").val(listaTemporales.toString());
             imagenPermitidoAntiguo = listaTemporales;
             $(".inputGaleriaProducto").val("");
             $(this).parent().parent().remove();

         }

     }

     swal({
         title: '¿Está seguro de eliminar esta imagen?',
         text: "¡Si no lo está puede cancelar la acción!",
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         cancelButtonText: 'Cancelar',
         confirmButtonText: 'Si, eliminar imagen!',
         closeOnConfirm: false,
         closeOnCancel: true
     }, function(isConfirm) {

         if (isConfirm) {

             var txtTokenProducto = document.querySelector('input[name="TokenProductoImagen"]').value;
             var rutavieja = $(".inputAntiguaGaleriaProducto").val();
             // var rutacompleta = $(".inputAntiguaGaleriaProductoEstatica").val();
             // console.log(txtTokenProducto, rutavieja, rutacompleta);
             // return;
             BorrarImagenProducto(txtTokenProducto, rutavieja);
         } else {
             var token_producto = "0/" + $('#TokenProductoImagen').val();
             verImagenProductos(token_producto);
         }

     });


 })

 /*=============================================
 BORRAR IMAGEN VISTA DE PRODUCTOS
 =============================================*/

 function BorrarImagenProducto(token, rutavieja) {

     datosMultimedia = new FormData();

     datosMultimedia.append("tabla", "productos");
     datosMultimedia.append("token", token);
     datosMultimedia.append("token_columna", "TOKEN_PRODUCTO");
     datosMultimedia.append("rutavieja", rutavieja);
     datosMultimedia.append("foto_columna", "IMAGEN_PRODUCTO");
     datosMultimedia.append("carpeta", "productos");

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

             cerrarLoadingProducto();
             swal("success", res.msg, "success");
             var token_producto = "0/" + $('#TokenProductoImagen').val();
             verImagenProductos(token_producto);



         } else {

             alert(res.msg);
             cerrarLoadingProducto();

         }

     }).fail(err => {

         swal("Error", err.msg, "error");
         cerrarLoadingProducto();
         return;

     })

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



 function mostrarLoading() {

     document.getElementById("mostrar_loading").style.display = "block";
     document.getElementById("modalBody").style.display = "none";

     // $("#titulo").html("Guardando...");

     $('#btnGuardar').hide();
     $('#btnCerrar').hide();

 }

 function cerrarLoading() {

     document.getElementById("mostrar_loading").style.display = "none";
     document.getElementById("modalBody").style.display = "block";

     $("#btnGuardar").prop('disabled', false);
     $("#btnCerrar").prop('disabled', false);

     $('#btnGuardar').show();
     $('#btnCerrar').show();

 }

 function verificarLoading() {

     if (archivosTemporales.length > 0) {

         mensajeFinal = "imagen";

     }

 }

 function mostrarLoadingProducto() {

     document.getElementById("mostrar_loadingProducto").style.display = "block";
     document.getElementById("modalBodyProducto").style.display = "none";

     // $("#titulo").html("Guardando...");

     // $('#btnGuardar').hide();
     $('#btnCerrar').hide();

 }

 function cerrarLoadingProducto() {

     document.getElementById("mostrar_loadingProducto").style.display = "none";
     document.getElementById("modalBodyProducto").style.display = "block";

     // $("#btnGuardar").prop('disabled', false);
     // $("#btnCerrar").prop('disabled', false);

     // $('#btnGuardar').show();
     $('#btnCerrar').show();

 }