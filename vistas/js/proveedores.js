
//const formUsuario=document.getElementById("formProveedor");

/*==========================================================
      CARGAR LOS DATOS EN LA TABLA Y DARLE FORMATO
============================================================*/

var tablaProveedores = $(".tablaProveedores").DataTable({

  "ajax": "ajax/tablaProveedores.ajax.php",
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


/*==========================================================
      Guardar Proveedor
============================================================*/

function guardarFormulario(){

  var txtEmpresa = document.querySelector('input[name="txtEmpresa"]').value;

  var txtRUC = document.querySelector('input[name="txtRUC"]').value;

  var cmbCiudad = $("#cmbCiudad").val();

  //alert(cmbCiudad);

  var txtDireccion = document.querySelector('input[name="txtDireccion"]').value;

  var txtTelefono = document.querySelector('input[name="txtTelefono"]').value;

  var txtCelular = document.querySelector('input[name="txtCelular"]').value;

  var txtEmail = document.querySelector('input[name="txtEmail"]').value;

  var cmbEstado = $("#cmbEstado").val();

  var tokenProveedor = document.querySelector('input[name="tokenProveedor"]').value;

  var datos = new FormData();

    datos.append("txtEmpresa", txtEmpresa);
    datos.append("txtRUC", txtRUC);
    datos.append("cmbCiudad", cmbCiudad);
    datos.append("txtDireccion", txtDireccion);
    datos.append("txtTelefono", txtTelefono);
    datos.append("txtCelular", txtCelular);
    datos.append("txtEmail", txtEmail);
    datos.append("cmbEstado", cmbEstado);
    datos.append("tokenProveedor", tokenProveedor);


    $.ajax({
    url: "ajax/proveedores.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,

    success: function(respuesta) {

      var objData = JSON.parse(respuesta);

      if (objData.status) {

        $('#ModalProveedor').modal('hide');

        formProveedor.reset();

        swal("success", objData.msg, "success");

        tablaProveedores.ajax.reload(function() {

        //LimpiarText();

        });

      } else {

        swal("Error", objData.msg, "error");

      }

    }

  })
  
  return (false);

}


/*=============================================
      Editar Proveedor
=============================================*/

$(document).on("click", ".editarProveedor", function() {

  document.querySelector("#titulo").innerHTML = "Editar proveedor";
  document.querySelector("#btnGuardar").innerHTML = "Actualizar";
  LimpiarText();
  
  var token_proveedor = $(this).attr("tokenProveedor");
  
  var datos = new FormData();

  datos.append("token_proveedor", token_proveedor);

  $.ajax({

    url: "ajax/proveedores.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {
      
      $('input[name="idProveedor"]').val(respuesta["COD_PROVEEDOR"]);

      $('input[name="tokenProveedor"]').val(respuesta["TOKEN_PROVEEDOR"]);

      $('input[name="txtEmpresa"]').val(respuesta["NOMBRE"]);

      $('input[name="txtRUC"]').val(respuesta["RUC"]);

      $('input[name="txtRUC"]').val(respuesta["RUC"]);

      $("#cmbCiudad").val(respuesta["COD_CIUDAD"]+"/"+respuesta["TOKEN_CIUDAD"]);
      $("#cmbCiudad").select2().trigger('change');//aplicar la seleccion

      $('input[name="txtDireccion"]').val(respuesta["DIRECCION"]);

      $('input[name="txtTelefono"]').val(respuesta["LINEABAJA"]);

      $('input[name="txtCelular"]').val(respuesta["CELULAR"]);

      $('input[name="txtEmail"]').val(respuesta["EMAIL"]);

      $('input[name="txtEmail"]').val(respuesta["EMAIL"]);

      $("#cmbEstado").val(respuesta["ESTADO_PROVEEDOR"]);
      $("#cmbEstado").select2().trigger('change');//aplicar la seleccion

    }

  })

})


/*=============================================
Eliminar Proveedores
=============================================*/

$(document).on("click", ".eliminarProveedor", function() {

  var tokenProveedor = $(this).attr("tokenProveedor");

  //alert(tokenProveedor);

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

      datos.append("idEliminar", tokenProveedor);

      $.ajax({

        url: "ajax/proveedores.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {

          var objData = JSON.parse(respuesta);

          if (objData.status) {

            swal("success", objData.msg, "success");
            //recargarDatatable();
            
            tablaProveedores.ajax.reload(function() {

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
                            $(".tablaProductosStock").DataTable().ajax.reload();
                            $(".tablaProductosReposicion").DataTable().ajax.reload();
                            $(".tablaProductosAgotados").DataTable().ajax.reload();
                            tablaProducto.ajax.reload(function() {
                              var count = $('.tablaProductos > * > tr').length - 1;
                              bloquear(count);
                              LimpiarText();

                            });

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


$(document).on("click", ".btnNuevo", function() {
  
  document.querySelector("#titulo").innerHTML = "Nuevo proveedor";
  document.querySelector("#btnGuardar").innerHTML = "Guardar";
  //LimpiarText();

})

function LimpiarText() {

  formProveedor.reset();

  $("#idProveedor").val("");

  $("#tokenProveedor").val("");

  $('input[name="txtEmpresa"]').text("");

  $('input[name="txtRUC"]').text("");

  $("#cmbCiudad").select2().trigger('change');

  $('input[name="txtDireccion"]').text("");

  $('input[name="txtTelefono"]').text("");

  $('input[name="txtCelular"]').text("");

  $('input[name="txtEmail"]').text("");

  $("#cmbEstado").select2().trigger('change');

}

