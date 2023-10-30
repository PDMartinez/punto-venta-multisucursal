// TEXTBOX
const txtCodigoBarra = document.querySelector("#txtCodigoBarra");
const txtSucursal = document.querySelector("#idSucursal").value;
const txtactivo = document.querySelector("#idSucursal").getAttribute('activo');
const avisoStock = document.querySelector("#avisoStock").value;
const avisoDescuento = document.querySelector("#avisodescuento").value;
const avisoCredito = document.querySelector("#avisocuota").value;
//const cmbFormapago = document.querySelector("#cmbFormaPago").value;
let CategoriaClientes;


//LABEL
const titulo = document.querySelector("#titulo");

//TABLAS
const tablaVenta = document.querySelector('#tablaVenta tbody');
const tablaProducto = document.querySelector('#tablaProductos');
//DIV
const carritoVenta = document.querySelector('#carritoVenta');

//BOTONES
const btnGuardarContado = document.querySelector("#btnGuardarContado");
const btnNuevo = document.querySelector("#btnNuevo");
const btnCancelar = document.querySelector(".btncancelar");
const btnAgregarMetodoPago = document.querySelector("#btnagregarMetodopago");
const btnActualizarProducto = document.querySelector("#btnActualizarProducto");
const btnGuardarClientes = document.querySelector("#btnGuardarClientes");
const btnListarDatos = document.querySelector(".btnListar");


const btnBusacarCodigoBarra = document.querySelector("#btnBusacarCodigoBarra");

let verCombosDetalle = 0;


let articulosVentas = [];


/*ICORPORANDO CODIGO NUEVO PARA OPTIMISAR EL PROCESO DE SELECCION DE DATOS DESDE HTML*/

// Listeners


window.addEventListener('load', function() {

  cargarEventListeners();
  $('.btncancelar').prop('disabled', true);
   cargarProductos();

});

function cargarEventListeners() {
  // Dispara cuando se presiona "Nuevo productos"
  if (typeof btnNuevo !== 'undefined') {
    btnNuevo.addEventListener('click', nuevoProducto);
  }
  tablaProducto.addEventListener('click', agregarProducto);


  // Cuando se elimina un curso del carrito
  carritoVenta.addEventListener('click', eliminarProductos);

  // Cancelar la venta, limpia toda la tabla
  btnCancelar.addEventListener('click', cancelarVenta);

  // Actualizar el producto
  btnActualizarProducto.addEventListener('click', ActualizarProducto);

  // Guardar el clientes
  btnGuardarClientes.addEventListener('click', GuardarFormularioClientes);


  // Listar Datos de venta y pedidos
  if (typeof btnListarDatos !== 'undefined') {
    btnListarDatos.addEventListener('click', ListarDatosVentas);
  }


  // Listar Datos de venta y pedidos
  if (typeof btnBusacarCodigoBarra !== 'undefined') {
    // Ahora sabemos que foo está definido, ahora podemos continuar.
    btnBusacarCodigoBarra.addEventListener('click', BuscarProductoBotones);
  }


  // Para buscar el codigo de barra
  txtCodigoBarra.addEventListener('keydown', BuscarProductoCodigo);

}


// Función que abrir nuevo boton
function nuevoProducto(e) {
  e.preventDefault();
 // cargarProductos();
  titulo.innerHTML = "Nueva Pre-Venta";
  btnGuardarContado.innerHTML = "Procesar pre-venta ";


  $(".ListarContenido").addClass("notblock");
  $(".CargarVenta").removeClass("notblock");

  if (localStorage.getItem('listarProductosPreVentas') != null) {
    if (articulosVentas.length > 0) {
      btnCancelar.disabled = false;

    } else {
      btnCancelar.disabled = true;
    }
  }



  if (articulosVentas.length <= 0) {

    articulosVentas = JSON.parse(localStorage.getItem('listarProductosPreVentas')) || [];
    VentaHTML();
    for (var i = 0; i < articulosVentas.length; i++) {
      if (articulosVentas[i]["cod_clientes"] != "") {
        $("#cmbClientes").val(articulosVentas[i]["cod_clientes"]);
        $("#cmbClientes").select2().trigger('change');

      }
    }



  }



}


// DETALLE DE VER COMBOS DE PRODUCTOS

$(document).on("click", ".btnVerDetalleCombos", function() {



  let combos = $(this).attr('combos');
  if (verCombosDetalle == 0) {

    $(".tablasDetCombos").DataTable({

      "ajax": "ajax/tablaVentas.ajax.php?combosProductos=" + combos,
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

      }

    });

    verCombosDetalle = 1;

  } else {
    $(".tablasDetCombos").DataTable().ajax.url("ajax/tablaVentas.ajax.php?combosProductos=" + combos).load();

  }

})


// Función que añade el producto en venta
function agregarProducto(e) {

  e.preventDefault();
  // Delegation para agregar-carrito
  if (e.target.classList.contains('btnAgregarProducto')) {
    const productos = e.target.parentElement.parentElement.parentElement;
    let tokencodigo = productos.querySelector('.btnAgregarProducto').getAttribute('tokenProducto');
    leerDatosProductos(tokencodigo, "T");

  } else if (e.target.classList.contains('btnAgregarProductoIcono')) {
    const productos = e.target.parentElement.parentElement.parentElement.parentElement;
    let tokencodigo = productos.querySelector('.btnAgregarProducto').getAttribute('tokenProducto');
    leerDatosProductos(tokencodigo, "T");

  }


}


// Función para actualizar producto
function ActualizarProducto(e) {
  e.preventDefault();
  $(".tablaProductos").DataTable().ajax.reload();
}



function ListarDatosVentas(e) {
  e.preventDefault();
  if ($('.tablasVerVentas > * > tr').length - 1 > 0) {

    $(".tablasVerVentas").DataTable().ajax.reload();

  }
  if ($('.tablasVerPedidos > * > tr').length - 1 > 0) {

    $(".tablasVerPedidos").DataTable().ajax.reload();

  }

  $(".ListarContenido").removeClass("notblock");
  $(".CargarVenta").addClass("notblock");
}



//FUNCION PARA CALCULAR DESCUENTO POR PRODUCTO O POR CANAL DEL CLIENTE
function descuentoCanalProducto(infoproducto) {

  // si es 1 sera descuento por producto
  // si no descuento por cliente
  infoproducto.cod_clientes = $("#cmbClientes").val();
  infoproducto.formaPago = $("#cmbFormaPago").val();
  var datos = new FormData();
  datos.append("canalProductos", infoproducto.codcanal);
  datos.append("activo", txtactivo);

  $.ajax({

    url: "ajax/ventas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    async: false,
    success: function(respuesta) {
      //  console.log("respuesta", respuesta);

      let precioventa = infoproducto.precioNormal.replace(/\./g, '');
      let descuentoPrecio = 0;
      let porcentajecompra = infoproducto.procentaje;
      let precio_contado = infoproducto.precioNormal.replace(/\./g, '');
      let cantidad = infoproducto.cantidad;

      if (respuesta.length > 0) {

        for (var i = 0; i < respuesta.length; i++) {

          if ((infoproducto.estadoOferta == "OFERTA" || infoproducto.estadoOferta == 1) && infoproducto.tipoProducto == "SOLITARIO") {
            precioventa = infoproducto.precio.replace(/\./g, '');;
            descuentoPrecio = Number(precio_contado) - Number(precioventa);

          } else if ((infoproducto.estadoOferta == "SIN OFERTA" || infoproducto.estadoOferta == 0) && infoproducto.tipoProducto == "SOLITARIO") {

            if (Number(cantidad) >= Number(respuesta[i]["CANTIDAD_DESDE"]) && Number(cantidad) <= Number(respuesta[i]["CANTIDAD_HASTA"])) {


              calcularporcentaje = 0;
              resto = 0;
              let sumarprocentaje = parseFloat(porcentajecompra) + 100;

              let compra = 0;
              calcularporcentaje = porcentajecompra - respuesta[i]["DESC_CANAL"];
              compra = (precio_contado * 100) / sumarprocentaje;
              compra = Math.round(compra);
              resto = (compra * calcularporcentaje) / 100;
              resto = Math.round(resto);
              // console.log("resto", resto);
              precioventa = Number(compra) + Number(resto);
              precioventa = Math.round(precioventa);
              descuentoPrecio = precio_contado - precioventa;

              if (respuesta[i]["DESC_CANAL"] > porcentajecompra) {
                mensajeEmergente("ERROR: ", "El descuento de canal es mayor a la ganancia, por favor verifique y asigne bien el descuento", "fa fa-times", "danger");
                return false;
              }


            } else if (i == respuesta.length - 1 && Number(cantidad) > Number(respuesta[i]["CANTIDAD_HASTA"])) {

              calcularporcentaje = 0;
              resto = 0;
              let sumarprocentaje = parseFloat(porcentajecompra) + 100;
              let compra = 0;
              calcularporcentaje = porcentajecompra - respuesta[i]["DESC_CANAL"];
              compra = (precio_contado * 100) / sumarprocentaje;
              resto = (compra * calcularporcentaje) / 100
              precioventa = Number(compra) + Number(resto);
              descuentoPrecio = precio_contado - precioventa;

              if (respuesta[i]["DESC_CANAL"] > porcentajecompra) {
                mensajeEmergente("ERROR: ", "El descuento de canal es mayor a la ganancia, por favor verifique y asigne bien el descuento", "fa fa-times", "danger");
                return false;
              }


            }



          }



        }

      } else {
        if ((infoproducto.estadoOferta == "OFERTA")) {
          precioventa = infoproducto.precio.replace(/\./g, '');
          descuentoPrecio = Number(precio_contado) - Number(precioventa);

        } else {
          precioventa = precio_contado;
          descuentoPrecio = 0;

        }

      }


      if (articulosVentas.some(producto => producto.id === infoproducto.id)) {
        const productos = articulosVentas.map(producto => {
          if (producto.id === infoproducto.id) {
            let descuentoTotal = (infoproducto.cantidad * descuentoPrecio);
            producto.cantidad = cantidad;
            producto.precio = precioventa;
            // console.log("precioventa", precioventa);
            producto.subTotal = Math.round(cantidad * precioventa);
            producto.descuento = formatNegativosVariables(descuentoTotal);
            producto.cod_clientes = $("#cmbClientes").val();
            return producto;
          } else {
            return producto;
          }
        })

      }

      VentaHTML();

    }


  })

}
//==================================================================

$("#cmbClientes").change(function() {


  if (articulosVentas.length > 0) {
    // console.log("idclientes", $("#cmbClientes").val());

    if (avisoDescuento == 0) {
      agregarDescuentoCliente();

    } else {

    }
  }



})
//DESCUENTO DE PRODUCTO POR CANAL DE CLIENTES


function agregarDescuentoCliente() {

  document.querySelector('#Vertipoclientes').classList.add("notblock");
  // si es 1 sera descuento por producto
  // si no descuento por cliente

  let nombrecanal = $("#cmbClientes").val().split('/');
  codcanalcliente = nombrecanal[2];
  CategoriaClientes = nombrecanal[3];

  var datos = new FormData();
  datos.append("canalClientes", codcanalcliente);
  datos.append("activo", txtactivo);

  $.ajax({

    url: "ajax/ventas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    async: false,
    success: function(respuesta) {

      if (respuesta.length > 0) {

        document.querySelector('#Vertipoclientes').classList.remove("notblock");
        $("#txtTipoClientes").val(respuesta[0]["DESCRIPCION_CANAL"] + "- Categoria: " + CategoriaClientes);
        $("#TablaDescuento td").remove();
        var f;
        var can = 0;
        var monto = 0;
        for (var i = 0; i < respuesta.length; i++) {

          can += 1;

          f += `<tr>
          <td class="text-center"> ${can} </td>
          <td class = "text-center" > ${new Intl.NumberFormat().format(respuesta[i]["MONTO_DESDE"])}</td>
          <td class="text-center"> ${new Intl.NumberFormat().format(respuesta[i]["MONTO_HASTA"])}</td>
          <td class="text-center"> ${new Intl.NumberFormat("de-DE").format(respuesta[i]["DESC_CANAL"])} %</td>
          </tr>`;
        }
        $("#TablaDescuento").append(f);

        let calcularporcentaje = 0;
        let descuentoTotalCliente = 0;
        let resto = 0;
        let neto = 0;
        let asignacion = 0;
        let precioventa = 0;
        let precio_contado = 0;
        let cantidadProducto = 0;
        let subTotalnuevo = 0;
        let descuento = 0;
        let totales = $("#txtTotalSinOferta").val();

        // RECORREMOS PRIMERAMENTE PARA VER CUANTO ES EL DESCUENTO FINAL QUE TIENE EL CLIENTE 
        for (var i = 0; i < respuesta.length; i++) {

          if (Number(totales) >= Number(respuesta[i]["MONTO_DESDE"]) && Number(totales) <= Number(respuesta[i]["MONTO_HASTA"])) {

            descuentoTotalCliente = (totales * respuesta[i]["DESC_CANAL"]) / 100;

          } else if (i == respuesta.length - 1 && Number(totales) > Number(respuesta[i]["MONTO_HASTA"])) {
            descuentoTotalCliente = (totales * respuesta[i]["DESC_CANAL"]) / 100;

          }

        } // TERMINA EL FOR DE DESCUENTO POR CLIENTES.

        // RECORREMOS EL PRODUCTO PARA APLICAR EL DESCUENTO QUE HERMOS EXTRAIDO DEL CLIENTE.

        for (var i = 0; i < articulosVentas.length; i++) {
          cantidadProducto = articulosVentas[i]["cantidad"];
          precio_contado = articulosVentas[i]["precioNormal"];

          if (articulosVentas[i]["tipoProducto"] == "SOLITARIO" && articulosVentas[i]["estadoOferta"] != "OFERTA") {

            calcularporcentaje = 0;
            resto = 0;
            precioventa = 0;
            neto = Number(precio_contado) * Number(cantidadProducto);
            calcularporcentaje = ((neto * 100) / totales);
            asignacion = ((descuentoTotalCliente * calcularporcentaje) / 100);
            descuento = Number(asignacion) / Number(cantidadProducto);
            asignacion = Math.round(asignacion);
            descuento = Math.round(descuento);
            precioventa = Number(precio_contado) - Number(descuento);
            subTotalnuevo = Math.round(precioventa * cantidadProducto);
            subTotalnuevo = subTotalnuevo - asignacion;


            const infoProducto = {

              id: articulosVentas[i]["id"],
              token: articulosVentas[i]["token"],
              codigobarra: articulosVentas[i]["codigobarra"],
              descripcion: articulosVentas[i]["descripcion"],
              stock: articulosVentas[i]["stock"],
              precio: articulosVentas[i]["precio"],
              estadoOferta: articulosVentas[i]["estadoOferta"],
              subTotal: articulosVentas[i]["precio"] * articulosVentas[i]["cantidad"],
              tipoProducto: articulosVentas[i]["tipoProducto"],
              procentaje: articulosVentas[i]["procentaje"],
              precioNormal: articulosVentas[i]["precioNormal"],
              descuento: articulosVentas[i]["descuento"],
              codcanal: articulosVentas[i]["codcanal"],
              cantidad: articulosVentas[i]["cantidad"],
              cod_clientes: $("#cmbClientes").val()

            }

            if (articulosVentas.some(producto => producto.id === infoProducto.id)) {
              const productos = articulosVentas.map(producto => {
                if (producto.id === infoProducto.id) {
                  let precio;
                  precio = Number(precioventa);
                  producto.precio = precio;
                  producto.subTotal = Math.round(cantidadProducto * precioventa);
                  producto.descuento = formatNegativosVariables(asignacion);
                  return producto;
                } else {
                  return producto;
                }
              })

              articulosVentas = [...productos];

            }


          } // TERMINA EL IF DONDE PREGUNTA SI ES PRODUCTO SOLITARIO O NO

        } // TERMINA EL FOR DE RECORRIDO DEL PRODUCTO ARRAY 

        //=====================================================================================


      } // SI ES MAYOR LA INFORMACION EXTRAIDA ENTRA AQUI.
      else {

        //   console.log("articulosVentas", articulosVentas);

        for (var i = 0; i < articulosVentas.length; i++) {


          if ((articulosVentas[i]["estadoOferta"] != "OFERTA") && articulosVentas[i]["tipoProducto"] == "SOLITARIO") {

            const infoProducto = {

              id: articulosVentas[i]["id"],
              token: articulosVentas[i]["token"],
              codigobarra: articulosVentas[i]["codigobarra"],
              descripcion: articulosVentas[i]["descripcion"],
              stock: articulosVentas[i]["stock"],
              precio: articulosVentas[i]["precioNormal"],
              estadoOferta: articulosVentas[i]["estadoOferta"],
              subTotal: articulosVentas[i]["precioNormal"] * articulosVentas[i]["cantidad"],
              tipoProducto: articulosVentas[i]["tipoProducto"],
              procentaje: articulosVentas[i]["procentaje"],
              precioNormal: articulosVentas[i]["precioNormal"],
              descuento: 0,
              codcanal: articulosVentas[i]["codcanal"],
              cantidad: articulosVentas[i]["cantidad"],
              cod_clientes: $("#cmbClientes").val()

            }
            


            if (articulosVentas.some(producto => producto.id === infoProducto.id)) {
              const productos = articulosVentas.map(producto => {
                if (producto.id === infoProducto.id) {
                  producto.precio = infoProducto.precio;
                  producto.subTotal =  Math.round(infoProducto.cantidad * infoProducto.precio);
                  producto.descuento = 0;
                  cod_clientes = $("#cmbClientes").val();
                  return producto;
                } else {
                  return producto;
                }
              })
              articulosVentas = [...productos];
             
            }

          } // TERMINA EL IF DONDE PREGUNTA SI ES PRODUCTO SOLITARIO O NO

        } // TERMINA EL FOR DE RECORRIDO DEL PRODUCTO ARRAY 


        //VentaHTML();
      }

      VentaHTML();


    } // TERMINA LA RESPUESTA


  }) // TERMINA LA CONSULTA DE AJAX

}
//================================================================================

// Función para actualizar producto
function BuscarProductoCodigo(e) {
  if (event.which == 13) {
    const codigobarraNuevo = this.value;
    if (codigobarraNuevo != "") {
      this.value = "";
      leerDatosProductos(codigobarraNuevo, "C");
    } else {
      mensajeEmergente("Error", "Cargue el codigo de barra", "fa fa-times", "danger");
    }


  }

}


// Función para actualizar producto
function BuscarProductoBotones(e) {
  const codigobarraNuevo = txtCodigoBarra.value;
  if (codigobarraNuevo != "") {
    txtCodigoBarra.value = "";
    leerDatosProductos(codigobarraNuevo, "C");
  } else {
    mensajeEmergente("Error", "Cargue el codigo de barra", "fa fa-times", "danger");
  }


}



function leerDatosProductos(codigobarraNuevo, variable) {
  let descuentoTotal
  let cantidadAnterior;
  var datos = new FormData();
  datos.append("CodigoBarra", codigobarraNuevo);
  datos.append("sucursal", txtSucursal);
  datos.append("activo", txtactivo);
  datos.append("variable", variable);

  $.ajax({

    url: "ajax/ventas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      if (respuesta) {


        //======================================================
        let estadoOferta;
        if (respuesta["ESTADO_OFERTA"] == 1) {

          precioventa = respuesta["PRECIO_OFERTA"];
          descuentoPrecio = respuesta["PRECIO_CONTADO"] - respuesta["PRECIO_OFERTA"];
          estadoOferta = "OFERTA";
        } else {
          precioventa = respuesta["PRECIO_CONTADO"];
          descuentoPrecio = respuesta["PRECIO_CONTADO"] - respuesta["PRECIO_CONTADO"];
          estadoOferta = "SIN OFERTA";
        }

        const infoProducto = {

          id: respuesta["COD_PRODUCTO"],
          token: respuesta["TOKEN_PRODUCTO"],
          codigobarra: respuesta["CODBARRA"],
          descripcion: respuesta["PRODUCTOS"],
          stock: respuesta["EXISTENCIA"],
          precio: precioventa,
          estadoOferta: estadoOferta,
          subTotal: precioventa,
          tipoProducto: respuesta["TIPO_PRODUCTO"],
          procentaje: respuesta["PORCENTAJE"],
          precioNormal: respuesta["PRECIO_CONTADO"],
          descuento: descuentoPrecio,
          codcanal: respuesta["COD_CANAL"],
          cantidad: 1,
          cod_clientes: $("#cmbClientes").val()
        }


        if (infoProducto.tipoProducto != "FLETES") {

          cantidad = prompt("¡Ingese la cantidad!", 1);


          if (cantidad != null) {

            cantidad = cantidad.replace(/,/g, '.');

            while (isNaN(cantidad) || cantidad == "" || cantidad <= 0) {
              cantidad = prompt("¡Ingese la cantidad!", 1);
            };
            infoProducto.cantidad = cantidad;
            infoProducto.subTotal = Math.round(precioventa * cantidad);
            descuentoTotal = descuentoPrecio * cantidad;
            infoProducto.descuento = formatNegativosVariables(descuentoTotal);

          } else {

            return false;
          }

        } else {
          cantidad = 1;
          infoProducto.cantidad = 1;
        }


        if (AvisoStock(infoProducto.stock, cantidad, infoProducto.tipoProducto)) {
          return;
        }

        if (articulosVentas.some(producto => producto.id === infoProducto.id)) {
          const productos = articulosVentas.map(producto => {
            if (producto.id === infoProducto.id) {
              let precio, cantidadsum;
              //  precio = Number(producto.precio.replace(/\./g, ''));
              precio = Number(producto.precio);
              cantidadsum = Number(producto.cantidad) + Number(cantidad);
              producto.cantidad = cantidadsum;
              infoProducto.cantidad = cantidadsum;
              producto.subTotal = cantidadsum * precio;
              return producto;
            } else {
              return producto;
            }
          })
          articulosVentas = [...productos];
        } else {
          articulosVentas = [...articulosVentas, infoProducto];
        }


        mensajeEmergente("", "Producto agregado", "fa-solid fa-check", "success");
        //DESCUENTO 
        if (avisoDescuento == 1) {

          //DESCUENTO POR PRODUCTO AL CONTADO
          descuentoCanalProducto(infoProducto)

        } else if (avisoDescuento == 0) {
          //DESCUENTO POR CLIENTE CONTADO
          // if ($("#cmbClientes").val() != "") {

          agregarDescuentoCliente();
          //   }

        }

      } else {
        mensajeEmergente("Error", "El código de barra no existe!!!", "fa fa-times", "danger");
      }


    }



  })
}


//CALCULAR SI STOCK A NO

function AvisoStock(existencia, cantidad, tipoproducto) {

  if (avisoStock === "1" && tipoproducto === "SOLITARIO") {


    if (Number(existencia) < Number(cantidad)) {

      swal({
        title: "La cantidad ingresada supera el stock actual",
        type: "error",
        confirmButtonText: "¡Cerrar!"

      })
      return true;
    }

    return false;


  }
}



// Muestra el curso seleccionado en el Carrito
function VentaHTML() {
  let contador = 0;
  let habilitar = "";
  let descripcion = "";
  vaciarVenta();
  let precioOferta = 0;
  articulosVentas.forEach(productos => {
    habilitar = "";
    if (productos.tipoProducto == "FLETES") {
      habilitar = "readonly";
    }

    if (productos.tipoProducto == "COMBOS") {
      descripcion = ` <div class="input-group-append"><button class='btn btn-success btn-sm btnVerDetalleCombos' combos='${productos.id}' type="button" data-dismiss="modal" data-toggle="modal" data-target="#ModalDetCombos"><i class="fa-solid fa-arrows-to-eye"></i></button><input type="text" class="form-control" value="${productos.descripcion}" readonly required> </div>`;
    } else {
      descripcion = `<input type="text" class="form-control" value="${productos.descripcion}" readonly required>`;
    }

    if (productos.estadoOferta == "OFERTA") {
      precioOferta = 0;
    } else {
      precioOferta = productos.subTotal;
    }
    contador++;
    const row = document.createElement('tr');
    row.innerHTML = `
              <td>  
                <label class="text-muted">${contador}</label>
              </td>

              <td>  
                  <button type="button" class="btn btn-danger btn-xs quitarProducto quitarProducto${productos.id}" id-producto="${productos.id}"><i class="quitarProductoIcono fa-solid fa-circle-xmark"></i></button>

              </td>

              <td>
                <input type="text" class="form-control" id="txtCantidadProducto" id-producto="${productos.id}"  value="${productos.cantidad}" ${habilitar} required>
               
              </td>

              <td>
                
                <input type="text" class="form-control textright precioventa" value="${productos.precio}" readonly required>

              </td>

              <td>
               
                <input type="text" class="form-control textright subtotal" value="${productos.subTotal}" readonly required>

              </td>

              <td>
                <input type="text" class="form-control" value="${productos.codigobarra}" readonly>

              </td>

              <td>
               ${descripcion} 

              </td>

              <td>
                <input type="text" class="form-control textright DescuentoProducto" value="${productos.descuento}" readonly  >

              </td>

              <td>
                <input type="text" class="form-control textright PrecioNormal"  value="${productos.precioNormal}" readonly>

              </td>

              <td class="notblock">
                <input type="text" class="form-control textright Canaldescuento"  value="${productos.codcanal}" readonly>

              </td>

               <td class="notblock">
                <input type="text" class="form-control textright estadoOferta"  precioOfertas="${precioOferta}" value="${productos.estadoOferta}" readonly>

              </td>

               <td class="notblock">
                <input type="text" class="form-control textright tipoProducto"  value="${productos.tipoProducto}" readonly>

              </td>

               <td class="notblock">
                <input type="text" class="form-control textright stockProdcuto"  value="${productos.stock}" readonly>

              </td>
               <td class="notblock">
                <input type="text" class="form-control textright procentajeDescuento"  value="${productos.procentaje}" readonly>

              </td>

          `;

    tablaVenta.appendChild(row);

  });
  $(".subtotal").number(true, 0);
  $(".precioventa").number(true, 0);
  //$(".DescuentoProducto").number(true,0);
  // console.log("DescuentoProducto", $(".DescuentoProducto");

  $(".PrecioNormal").number(true, 0);


  btnCancelar.disabled = false;
  cantidadItems(articulosVentas.length);
  sumarTotalPrecios();
  // Sincronizamos con el local storage
  sincronizarStorage();
  quitarAgregarProductos();

}



/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/
function sumarTotalPrecios() {

  var precioItem = $(".subtotal");

  var preciofertaItem = $(".estadoOferta");

  if (precioItem.length > 0) {
    var descuentoItem = $(".DescuentoProducto");
    var arraySumaPrecio = [];
    var arraySumaDescuento = [];
    var arraySumaOferta = [];

    for (var i = 0; i < precioItem.length; i++) {

      arraySumaPrecio.push(Number($(precioItem[i]).val().replace(/\./g, '')));
      arraySumaDescuento.push(Number($(descuentoItem[i]).val().replace(/\./g, '')));
      arraySumaOferta.push(Number($(preciofertaItem[i]).attr('precioOfertas').replace(/\./g, '')));

    }

    function sumaArrayPrecios(total, numero) {

      return total + numero;

    }

    var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
    var sumaTotalDescuento = arraySumaDescuento.reduce(sumaArrayPrecios);
    var sumaTotalOferta = arraySumaOferta.reduce(sumaArrayPrecios);

    if ($("#txtentregaEfectivo").val() == $("#txtTotal").val()) {
      $("#txtentregaEfectivo").val(sumaTotalPrecio);
      $("#txtentregaEfectivo").number(true, 0)
    } else {

      $("#txtentregaEfectivo").val(sumaTotalPrecio);
      $('#txtentregaEfectivo').prop('disabled', false);
    }

    $("#txtTotal").val(sumaTotalPrecio);
    $("#txtTotalArticulos").val(sumaTotalPrecio);
    $("#txtTotalSinOferta").val(sumaTotalOferta);
    $("#totalVenta").val(sumaTotalPrecio);
    $("#txtTotal").attr("total", sumaTotalPrecio);
    $("#txtTotalDescuento").val(sumaTotalDescuento);
    $("#totalNuevoDescuento").val(sumaTotalDescuento);
    $("#totalventanuevo").val(sumaTotalPrecio);
    $("#txtTotalsindescuento").val(sumaTotalDescuento - sumaTotalPrecio);
    $("#txtTotal").number(true, 0)
    $("#txtTotalArticulos").number(true, 0)
    $("#txtTotalDescuento").number(true, 0)
    $("#txtTotalsindescuento").number(true, 0)
    $("#totalNuevoDescuento").number(true, 0)
    $("#totalventanuevo").number(true, 0)
  } else {
    $("#txtTotal").val(0);
    $("#txtTotalArticulos").val(0);
    $("#totalVenta").val(0);
    $("#txtTotal").attr("total", 0);
    $("#txtTotalDescuento").val(0);
    $("#totalNuevoDescuento").val(0);
    $("#totalventanuevo").val(0);
    $("#txtTotalsindescuento").val(0);
  }

}

var mostrar = 0;

$(document).on("click", "#ver", function() {

  if (mostrar == 0) {
    document.querySelector('#Verdescuento').classList.add("notblock");
    document.querySelector('#nodescuento').classList.remove("notblock");
    document.querySelector('#tablaOcultar').classList.remove("notblock");
    mostrar = 1;
  } else {
    document.querySelector('#Verdescuento').classList.remove("notblock");
    document.querySelector('#nodescuento').classList.add("notblock");
    document.querySelector('#tablaOcultar').classList.add("notblock");
    mostrar = 0;

  }

})


/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioVenta").on("change", "#txtCantidadProducto", function(e) {
  var stockcargadanuevo = $(this).val();
  stockcargadanuevo = stockcargadanuevo.replace(/,/g, '.');
  $(this).val(stockcargadanuevo);
  let producto = e.target.parentElement.parentElement;
  let existencia = producto.getElementsByTagName('td')[12].querySelector('.stockProdcuto').value;
  let tipoProducto = producto.getElementsByTagName('td')[11].querySelector('.tipoProducto').value;

  if (isNaN(stockcargadanuevo) || stockcargadanuevo == "" || stockcargadanuevo <= 0) {
    $(this).val(1);
    swal("error", "La cantidad no puede estar vacío- debe de ser numérico y mayor a cero", "error");
    return

  }

  if (AvisoStock(existencia, $(this).val(), tipoProducto)) {
    $(this).val(1);
    return;
  }

  ModificarDatosProductos(producto)

})



// Lee los datos del curso
function ModificarDatosProductos(producto) {

  const infoProducto = {
    id: producto.querySelector('.quitarProducto').getAttribute('id-Producto'),
    cantidad: producto.getElementsByTagName('td')[2].querySelector('#txtCantidadProducto').value,
    precio: producto.getElementsByTagName('td')[3].querySelector('.precioventa').value.replace(/\./g, ''),
    subTotal: producto.getElementsByTagName('td')[4].querySelector('.subtotal').value,
    descuento: producto.getElementsByTagName('td')[7].querySelector('.DescuentoProducto').value,
    precioNormal: producto.getElementsByTagName('td')[8].querySelector('.PrecioNormal').value,
    codcanal: producto.getElementsByTagName('td')[9].querySelector('.Canaldescuento').value,
    estadoOferta: producto.getElementsByTagName('td')[10].querySelector('.estadoOferta').value,
    tipoProducto: producto.getElementsByTagName('td')[11].querySelector('.tipoProducto').value,
    stock: producto.getElementsByTagName('td')[12].querySelector('.stockProdcuto').value,
    procentaje: producto.getElementsByTagName('td')[13].querySelector('.procentajeDescuento').value

  }



  if (articulosVentas.some(producto => producto.id === infoProducto.id)) {

    const productos = articulosVentas.map(producto => {

      if (producto.id === infoProducto.id) {

        //DESCUENTO 
        if (avisoDescuento == 1) {


          //DESCUENTO POR PRODUCTO AL CONTADO
          descuentoCanalProducto(infoProducto)

        } else {
          //CREDITO CAMBIAR TODO POR PRECIO DE VENTA

          if (avisoCredito == 0) {
            // si el estado es 0 entonces vamos a aplicar el aumento

          } else if (avisoCredito == 1) {

          }

        }


        let cantidad = Number(infoProducto.cantidad);
        let precio = Number(infoProducto.precio);
        let subtotales = cantidad * precio;

        let precioNormal= cantidad * infoProducto.precioNormal.replace(/\./g, '');
        let descuentounitario=precioNormal-subtotales;
        precioNormal=Math.round(precioNormal);
        producto.precio =  Math.round(precio);
        producto.cantidad = cantidad;
        producto.subTotal =  Math.round(subtotales);
        producto.descuento =   formatNegativosVariables(Math.round(descuentounitario));
        return producto;
      } else {
        return producto;
      }
    })

    articulosVentas = [...productos];
    VentaHTML();


  }

  if (avisoDescuento == 0) {
    //DESCUENTO POR CLIENTE CONTADO
    if ($("#cmbClientes").val() != "") {
      agregarDescuentoCliente();
    }
  }


}

function cantidadItems(cantidadItems) {
  $('.Can').text(cantidadItems);
  btnCancelar.disabled = false;
}


// NUEVO: 
function sincronizarStorage() {

  localStorage.setItem('listarProductosPreVentas', JSON.stringify(articulosVentas));

}

// Elimina los cursos del carrito en el DOM
function vaciarVenta() {

  // forma rapida (recomendada)
  if (typeof tablaVenta !== 'undefined') {
    while (tablaVenta.firstChild) {
      tablaVenta.removeChild(tablaVenta.firstChild);
    }
  }


}

function cancelarVenta() {
  swal({
    title: '¿Estas seguro de cancelar la carga?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, cancelar!',
    closeOnConfirm: false,
    closeOnCancel: true
  }, function(isConfirm) {

    if (isConfirm) {
      vaciarVenta();
      localStorage.removeItem("listarProductosPreVentas");
      localStorage.removeItem("listarPedidos");
      cantidadItems(0);
      window.location = "preventas"
    }

  });

}


// Elimina el curso del carrito en el DOM
function eliminarProductos(e) {
  e.preventDefault();
  if (e.target.classList.contains('quitarProducto')) {
    // e.target.parentElement.parentElement.remove();
    const producto = e.target.parentElement.parentElement;
    const productoId = producto.querySelector('button').getAttribute('id-producto');
    // Eliminar del arreglo del carrito
    articulosVentas = articulosVentas.filter(producto => producto.id !== productoId);
    $(".btnAgregarProducto" + productoId).prop('disabled', false);
    VentaHTML();
    cantidadItems(articulosVentas.length);
  } else if (e.target.classList.contains('quitarProductoIcono')) {
    // e.target.parentElement.parentElement.remove();
    const producto = e.target.parentElement.parentElement.parentElement;
    const productoId = producto.querySelector('button').getAttribute('id-producto');
    // Eliminar del arreglo del carrito
    articulosVentas = articulosVentas.filter(producto => producto.id !== productoId);
    $(".btnAgregarProducto" + productoId).prop('disabled', false);
    VentaHTML();

    cantidadItems(articulosVentas.length);
  }
}

//===================================================================================



/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/

$(".tablaProductos").on("draw.dt", function() {

  quitarAgregarProductos();


})

var generales = document.getElementById('idSucursal');

var tablaVerVenta = $(".tablasVerVentas").DataTable({

  "ajax": "ajax/tablaPre-Venta.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + generales.getAttribute("activo") + " &txtfechaInicial=0&txtfechaFinal=0&var=0",
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
      "columns": [2, 3, 4, 5, 8, 9]
    }
  }, {
    "extend": "excelHtml5",
    "text": "<i class='fas fa-file-excel'></i> Excel",
    "titleAttr": "Esportar a Excel",
    "className": "btn btn-success",
    "exportOptions": {
      "columns": [2, 3, 4, 5, 8, 9]
    }
  }, {
    "extend": "pdfHtml5",
    "text": "<i class='fas fa-file-pdf'></i> PDF",
    "titleAttr": "Esportar a PDF",
    "className": "btn btn-danger",
    "exportOptions": {
      "columns": [2, 3, 4, 5, 8, 9]
    }
  }, {
    "extend": "csvHtml5",
    "text": "<i class='fas fa-file-csv'></i> CSV",
    "titleAttr": "Esportar a CSV",
    "className": "btn btn-info",
    "exportOptions": {
      "columns": [2, 3, 4, 5, 8, 9]
    }

  }]

});


var contadortabladetalle = 1;

$(document).on("click", ".detalleVenta", function() {
  var general = document.getElementById('idSucursal');

  var token_Venta = $(this).attr("tokenVenta");

  if (contadortabladetalle == 1) {

    $(".tablasDetVenta").DataTable({

      "ajax": "ajax/tablaPre-Venta.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + general.getAttribute("activo") + " &token_ventas=" + token_Venta,
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
          "columns": [2, 3, 4, 5, 8, 9]
        }
      }, {
        "extend": "excelHtml5",
        "text": "<i class='fas fa-file-excel'></i> Excel",
        "titleAttr": "Esportar a Excel",
        "className": "btn btn-success",
        "exportOptions": {
          "columns": [2, 3, 4, 5, 8, 9]
        }
      }, {
        "extend": "pdfHtml5",
        "text": "<i class='fas fa-file-pdf'></i> PDF",
        "titleAttr": "Esportar a PDF",
        "className": "btn btn-danger",
        "exportOptions": {
          "columns": [2, 3, 4, 5, 8, 9]
        }
      }, {
        "extend": "csvHtml5",
        "text": "<i class='fas fa-file-csv'></i> CSV",
        "titleAttr": "Esportar a CSV",
        "className": "btn btn-info",
        "exportOptions": {
          "columns": [2, 3, 4, 5, 8, 9]
        }

      }]

    });
    contadortabladetalle = 0;
  } else {

    $(".tablasDetVenta").DataTable().ajax.url("ajax/tablaPre-Venta.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + general.getAttribute("activo") + " &token_ventas=" + token_Venta).load();

  }


})



function consultarRango(fechaInicial, fechaFinal) {

  var general = document.getElementById('idSucursal');

  let activo = general.getAttribute("activo");

  if (activo == 0) {
    $(".tablasVerVentasAnulada").DataTable().ajax.url("ajax/tablaPre-Venta.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + activo + " &txtfechaInicial=" + fechaInicial + "&txtfechaFinal=" + fechaFinal).load();
  } else {
    $(".tablasVerVentas").DataTable().ajax.url("ajax/tablaPre-Venta.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + activo + " &txtfechaInicial=" + fechaInicial + "&txtfechaFinal=" + fechaFinal).load();
  }



}



/*=============================================
CLONAR COMPRAS
=============================================*/

$(document).on("click", ".clonarVenta", function() {

  var token_Venta = $(this).attr("tokenVenta");

  ClonarVentas(token_Venta);

})

function ClonarVentas(token_Venta) {
  valorNuevo = 1;
  let codclientesnuevo=0;
  let estadoOfertanueva="SIN OFERTA";
  $(".ListarContenido").addClass("notblock");
  $(".CargarVenta").removeClass("notblock");
 // cargarProductos();

  document.querySelector("#titulo").innerHTML = "Clonar Pre-venta";

  document.querySelector("#btnGuardarContado").innerHTML = "Clonar Pre-venta ";
  $("#btnGuardarContado").append('<i class="fa-solid fa-share"></i>')
  articulosVentas = [];

  var general = document.getElementById('idSucursal');
  var sucursal = $('#idSucursal').val();
  var activo = generales.getAttribute("activo");


  var datos = new FormData();

  datos.append("TokenPedidos", token_Venta);
  datos.append("sucursal", sucursal);
  datos.append("activo", activo);

  $.ajax({

    url: "ajax/preventas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {

      for (var i = 0; i < respuesta.length; i++) {
        if(respuesta[i]["ESTADO_OFERTA"]==1){
          estadoOfertanueva="OFERTA";
        }else{
          estadoOfertanueva="SIN OFERTA";
        }

        const infoProducto = {

          id: respuesta[i]["COD_PRODUCTO"],
          token: respuesta[i]["TOKEN_PRODUCTO"],
          codigobarra: respuesta[i]["CODBARRA"],
          descripcion: respuesta[i]["DESCRIPCION"],
          stock: respuesta[i]["EXISTENCIA"],
          precio: respuesta[i]["PRECIO_UNI"],
          estadoOferta: estadoOfertanueva,
          subTotal: respuesta[i]["PRECIO_NETO"],
          tipoProducto: respuesta[i]["TIPO_PRODUCTO"],
          procentaje: respuesta[i]["PORCENTAJE"],
          precioNormal: respuesta[i]["PRECIO_CONTADO"],
          codcanal: respuesta[i]["COD_CANAL"],
          cantidad: respuesta[i]["CANTIDAD"],
          cod_clientes: respuesta[i]["tokenClientes"],
          descuento: respuesta[i]["DESCUENTO"]
        }


        if (articulosVentas.some(producto => producto.id === infoProducto.id)) {
          const productos = articulosVentas.map(producto => {
            if (producto.id === infoProducto.id) {
              let precio, cantidadsum;
              //  precio = Number(producto.precio.replace(/\./g, ''));
              precio = Number(producto.precio);
              cantidadsum = Number(producto.cantidad) + Number(infoProducto.cantidad);
              producto.cantidad = cantidadsum;
              infoProducto.cantidad = cantidadsum;
              producto.subTotal = cantidadsum * precio;
              return producto;
            } else {
              return producto;
            }
          })
          articulosVentas = [...productos];
        } else {
          articulosVentas = [...articulosVentas, infoProducto];
          
        }
      
codclientesnuevo=respuesta[i]["tokenClientes"];

      }
  VentaHTML();



      // if (avisoDescuento == 1) {

      //   //DESCUENTO POR PRODUCTO AL CONTADO
      //   descuentoCanalProducto(infoProducto)

      // } else if (avisoDescuento == 0) {
      //   //DESCUENTO POR CLIENTE CONTADO
      //   if ($("#cmbClientes").val() != "") {

      //     agregarDescuentoCliente();
      //   } else {
      //     VentaHTML();
      //   }

      // }


      $("#txtPrecioVenta").number(true, 0);
    
      quitarAgregarProductos();
      mensajeEmergente("", "Producto agregado con éxito", "fa-solid fa-check", "success");

          $("#cmbClientes").val(codclientesnuevo);
          $("#cmbClientes").select2().trigger('change');


    }

  })

}

$(document).on("click", ".btnListar", function() {
  // $("#tablaVenta td").remove();

  $(".rowNuevo").closest('tr').remove();
  // window.location = "compras";

  if ($('.tablasVerVentas > * > tr').length - 1 > 0) {

    $(".tablasVerVentas").DataTable().ajax.reload();

  }

  $(".ListarContenido").removeClass("notblock");
  $(".CargarVenta").addClass("notblock");
  formVenta.reset();

  // quitarAgregarProducto();


})



// ES PARA GUARDAR LOS DATOS EN LA BASE DE DATOS//

function Guardarformulario() {

  var txtUsuario = document.querySelector('input[name="idUsuario"]').value;

  var txtidSucursal = document.querySelector('input[name="idSucursal"]').value;

  var cmbClientes = $("#cmbClientes").val();

  var tipomovimiento = $("#tipomovimiento").val();

  var txtFechaVenta = document.querySelector('input[name="txtFechaVenta"]').value;
  

  var txtproductos = JSON.stringify(articulosVentas);

  var totalTalba = txtproductos.length;


  if (txtFechaVenta == "") {
    swal({
      title: "Seleccione una fecha de compra",
      type: "error",
      confirmButtonText: "¡Cerrar!"

    })
    return false;
  }

  if (txtproductos.length <= 2) {
    swal({
      title: "Cargue un producto",
      type: "error",
      confirmButtonText: "¡Cerrar!"

    })
    return false;
  }

  // console.log(articulosVentas);
  // return false;

  divLoading.style.display = "flex";

  //   return false;
  var datos = new FormData();
  datos.append("txtUsuario", txtUsuario);
  datos.append("txtidSucursal", txtidSucursal);
  datos.append("cmbClientes", cmbClientes);
  datos.append("txtproductos", txtproductos);
  datos.append("txtFechaVenta", txtFechaVenta);
  datos.append("tipomovimiento", tipomovimiento);

  $.ajax({
    url: "ajax/preventas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    async: false,
    contentType: false,
    processData: false,

    success: function(respuesta) {

      var objData = JSON.parse(respuesta);
      
      if (objData.status) {

        swal("success", objData.msg, "success");
        localStorage.removeItem("listarProductosPreVentas");

        var datos = new FormData();
        datos.append("txtCodVenta", objData.CODIGO_VENTA);

        $.ajax({
          url: "ajax/preventas.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          async: false,
          contentType: false,
          processData: false,

          success: function(respuesta) {

            // console.log(respuesta);
            // return;

            var objData = JSON.parse(respuesta);

            imprimirTicket(objData, articulosVentas);

            divLoading.style.display = "none";

            window.location = "preventas";

          }

        })

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

function imprimirTicket(objData, articulosVentas){

  var totalPedido = 0;

  /*==========================================================
      CONFIGURACIÓN DEL TAMAÑO DE PANTALLA
  ============================================================*/

    var mywindow = window.open('', 'PRINT', 'height=400, width=600');

    /*==========================================================
      CABECERA DEL TICKET
    ============================================================*/

    mywindow.document.write(

      '<FONT FACE="arial">'+

      '<table'+
    
        '<tr>'+

          '<td>'+

            '<div style="font-size:17px; text-align:center">'+

                '<br>'+

                objData["NOMBRE_EMPRESA"]+

                '<br>'+

                'De '+objData["PROPIETARIO_EMPRESA"]+

                '<br>'+

                'RUC: '+objData["RUC_EMPRESA"]+

                '<br>'+

                'Teléfonos: '+objData["TELEFONO_SUC"]+

                '<br>'+

                'Dirección: '+objData["DIRECCION"]+

                '<br>'+

                '============================================'+
                '<br>'+
                '<b>ORDEN DE PEDIDO</b>'+
                '<br>'+
                '============================================'+
                '<br>'+

                '<div style="font-size:17px; text-align:left">'+

                'Cajero:  '+objData["NOMBRE_FUNC"]+

                '<br>'+

                'N° Pedido: '+objData["COD_PEDIDO"]+

                '<br>'+

                'Fecha:  '+objData["FECHA_PEDIDO"]+

                '<br>'+

                'Cliente:  '+objData["CLIENTE"]+

                '<br>'+

            '</div>'+

          '</td>'+

        '</tr>'+

      '</table>'+

      '<table style="font-size:17px">'+

      '<label style="font-size:17px;">&nbsp--------------------------------------------------------------------</label>'+
               
          '<tr>'+
                 
            '<td style="width:150px;"><b>Descrip.</b></td>'+
            '<td style="width:150px;"><b>Cant.</b></td>'+
            '<td style="width:150px;"><b>Bruto</b></td>'+
            '<td style="width:150px;"><b>Neto</b></td>'+
            '<td style="width:150px;"><b>Desc.</b></td>'+
            '<td style="width:150px;"><b>Subtotal</b></td>'+

          '</tr>'+

        
          '<tr>'+
                 
            '<td colspan="6">-------------------------------------------------------------------</td>'+

          '</tr>'

    );

    /*==========================================================
      RECORRIDO E IMPRESIÓN DE PRODUCTOS EN EL TICKET
    ============================================================*/

    var total = 0;

    for (var i = 0; i < articulosVentas.length; i++) {

      totalPedido += parseInt(articulosVentas[i]["subTotal"]);

      mywindow.document.write(

          '<tr style="text-align:left">'+

            '<td colspan="6">'+articulosVentas[i]["descripcion"]+'<td>'+

          '</tr>'+

          '<tr>'+

            '<td style="width:150px; text-align:left"></td>'+
            '<td style="width:150px; text-align:left">'+articulosVentas[i]["cantidad"]+'</td>'+
            '<td style="width:150px; text-align:left">'+new Intl.NumberFormat("de-DE").format(articulosVentas[i]["precioNormal"])+'</td>'+
            '<td style="width:150px; text-align:left">'+new Intl.NumberFormat("de-DE").format(articulosVentas[i]["precio"])+'</td>'+
            '<td style="width:150px; text-align:left">'+articulosVentas[i]["descuento"]+'</td>'+
            '<td style="width:150px; text-align:left">'+new Intl.NumberFormat("de-DE").format(articulosVentas[i]["subTotal"])+'</td>'+

          '</tr>'

      );
          
    }

    /*==========================================================
      IMPRESIÓN DEL TOTAL DE LA COMPRA
    ============================================================*/
          
    mywindow.document.write(

        //'</tbody>'+        

      '</table>'+

      '<label style="font-size:17px;">---------------------------------------------------------------------</label>'+

      '<br>'+

      '<div style="font-size:17px; text-align:center">'+

        '<label>TOTAL: '+new Intl.NumberFormat("de-DE").format(totalPedido)+' Gs</label>'+

      '</div>'+

      '<div style="font-size:17px; text-align:left">'

    );


    mywindow.document.write(

      '</div>'+

      '<label style="font-size:17px;">---------------------------------------------------------------------</label>'+

      '<br><br>'

    );

    /*==========================================================
      IMPRESIÓN DE TEXTO FINAL
    ============================================================*/

    mywindow.document.write(

      '<div style="font-size:17px; text-align:center">'+
      '<label">MUCHAS GRACIAS POR SU PREFERENCIA!!! </label>'+
      '<div>'+
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
      REIMPRIMIR TICKET DE PRE-VENTAS
============================================================*/
$(".tablasVerVentas").on("click", "button.imprimirPreVenta", function() {

    var tokenVenta = $(this).attr("tokenVenta");

    // console.log(tokenVenta);

    window.open("extensiones/tcpdf/pdf/impPreVenta.php?tokenVenta="+tokenVenta,"_blank");

    return (false);

})


$(document).on("click", "#ProductoSucursalActual", function() {
  $(".CodigoBarra").removeClass("notblock")
  $("#VerporTipo").removeClass("notblock")

  $(".tablaProductos").DataTable().ajax.url("ajax/tablaPre-Venta.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + "&simbolo= <> &tipo_producto=o").load();

});

$(document).on("click", "#ProductoActivoOtros", function() {

  $(".CodigoBarra").addClass("notblock")
  $("#VerporTipo").addClass("notblock")

  $(".tablaProductos").DataTable().ajax.url("ajax/tablaPre-Venta.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + "&simbolo=0&tipo_producto=o").load();

});

$(document).on("click", "#btnTodosProductos", function() {


  $(".tablaProductos").DataTable().ajax.url("ajax/tablaPre-Venta.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + "&simbolo=<>&tipo_producto=o").load();
  $("#TextoPlataforma").html("Todos");

});

$(document).on("click", "#btnMasReciente", function() {


  $(".tablaProductos").DataTable().ajax.url("ajax/tablaPre-Venta.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + "&simbolo==&tipo_producto=MasRecientes").load();
  $("#TextoPlataforma").html("Productos mas reciente");

});

$(document).on("click", "#btnMasVendidos", function() {


  $(".tablaProductos").DataTable().ajax.url("ajax/tablaPre-Venta.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + "&simbolo==&tipo_producto=MasVendidos").load();
  $("#TextoPlataforma").html("Productos mas vendidos");

});

$(document).on("click", "#btncombos", function() {

  $(".tablaProductos").DataTable().ajax.url("ajax/tablaPre-Venta.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + "&simbolo==&tipo_producto=COMBOS").load();
  $("#TextoPlataforma").html("Combos productos");

});

$(document).on("click", "#btnfletes", function() {

  $(".tablaProductos").DataTable().ajax.url("ajax/tablaPre-Venta.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + "&simbolo==&tipo_producto=FLETES").load();
  $("#TextoPlataforma").html("Fletes");

});


$(document).on("click", "#btnServicios", function() {


  $(".tablaProductos").DataTable().ajax.url("ajax/tablaVentas.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + "&simbolo==&tipo_producto=SERVICIOS").load();
  $("#TextoPlataforma").html("Servicios");

});



$(document).on("click", "#btnEmitida", function() {


  $("#VerAnuladas").addClass("notblock");
  $("#VerEmitidas").removeClass("notblock");
  $("#btnEmitida").addClass("notblock");
  $("#btnAnulada").removeClass("notblock");
  document.querySelector("#tituloventa").innerHTML = "Administrar Pre-ventas emitidas";

  let generales = document.getElementById('idSucursal');
  let modificaractivo = generales.setAttribute("Activo", 1);
  let activo = generales.getAttribute("Activo");

  $(".tablasVerVentas").DataTable().ajax.url("ajax/tablaPre-Venta.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + activo + " &txtfechaInicial=0&txtfechaFinal=0&var=0").load();

});

let ventaAnulada = 0;
var tablaVerVentaAnuladas

$(document).on("click", "#btnAnulada", function() {

  $("#VerAnuladas").removeClass("notblock");
  $("#VerEmitidas").addClass("notblock");
  $("#btnEmitida").removeClass("notblock");
  $("#btnAnulada").addClass("notblock");
  document.querySelector("#tituloventa").innerHTML = "Administrar Pre-ventas anuladas";

  let generales = document.getElementById('idSucursal');
  let modificaractivo = generales.setAttribute("Activo", 0);
  let activo = generales.getAttribute("Activo");

  if (ventaAnulada == 0) {
    ventaAnulada = 1;
    tablaVerVentaAnuladas = $(".tablasVerVentasAnulada").DataTable({

      "ajax": "ajax/tablaPre-Venta.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + activo + " &txtfechaInicial=0&txtfechaFinal=0&var=0",
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
      // "createdRow": function(row, data, index) {
      //    $('td', row).eq(7).addClass('notblock');
      //  },
      'dom': 'lBfrtip',
      'buttons': [{
        "extend": "copyHtml5",
        "text": "<i class='far fa-copy'></i> Copiar",
        "titleAttr": "Copiar",
        "className": "btn btn-secondary",
        "exportOptions": {
          "columns": [2, 3, 4, 5, 8, 9]
        }
      }, {
        "extend": "excelHtml5",
        "text": "<i class='fas fa-file-excel'></i> Excel",
        "titleAttr": "Esportar a Excel",
        "className": "btn btn-success",
        "exportOptions": {
          "columns": [2, 3, 4, 5, 8, 9]
        }
      }, {
        "extend": "pdfHtml5",
        "text": "<i class='fas fa-file-pdf'></i> PDF",
        "titleAttr": "Esportar a PDF",
        "className": "btn btn-danger",
        "exportOptions": {
          "columns": [2, 3, 4, 5, 8, 9]
        }
      }, {
        "extend": "csvHtml5",
        "text": "<i class='fas fa-file-csv'></i> CSV",
        "titleAttr": "Esportar a CSV",
        "className": "btn btn-info",
        "exportOptions": {
          "columns": [2, 3, 4, 5, 8, 9]
        }

      }]

    });


  } else {

    $(".tablasVerVentasAnulada").DataTable().ajax.url("ajax/tablaPre-Venta.ajax.php?sucursal=" + $("#idSucursal").val() + " &activo=" + activo + " &txtfechaInicial=0&txtfechaFinal=0&var=0").load();
  }



});



function cargarProductos() {

  $('.tablaProductos').DataTable({
    "ajax": "ajax/tablaVentas.ajax.php?sucursal=" + $("#idSucursal").val() + "&activo=" + 1 + "&simbolo=<>&tipo_producto=o",
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

    "createdRow": function(row, data, index) {
      if (data[8] == "COMBOS") {
        $(row).addClass("table-success");

      } else if (data[8] == "FLETES") {
        $(row).addClass("table-warning");

      }

      $('td', row).eq(10).addClass('notblock');
      $('td', row).eq(11).addClass('notblock');
      $('td', row).eq(12).addClass('notblock');
      $('td', row).eq(13).addClass('notblock');
      $('td', row).eq(14).addClass('notblock');

    }

  });

}

function quitarAgregarProductos() {

  if (localStorage.getItem("listarProductosPreVentas") != null) {
    let idProductosStore = JSON.parse(localStorage.getItem("listarProductosPreVentas"));

    //Capturamos todos los id de productos que fueron elegidos en la venta
    var idProductos = $(".btnAgregarProducto");
    //Capturamos todos los botones de agregar que aparecen en la tabla
    // var botonesTabla = $(".tablaProductos tbody button.btnAgregarProducto");

    //Recorremos en un ciclo para obtener los diferentes idProductos que fueron agregados a la venta
    for (var i = 0; i < idProductos.length; i++) {

      //Capturamos los Id de los productos agregados a la venta
      var boton = $(idProductos[i]).attr("idProducto");

      //Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
      for (var j = 0; j < idProductosStore.length; j++) {
        let botonAmacenado = idProductosStore[j]["id"];
        if (botonAmacenado == boton) {

          // $(botonesTabla[j]).prop('disabled', true);
          $(".btnAgregarProducto" + botonAmacenado).prop('disabled', true);

        }

      }

    }
  }

}


/*=============================================
ANULAR PEDIDOS
=============================================*/
$(".tablasVerVentas, .tablasVerVentasAnulada").on("click", ".eliminarVenta", function() {

  var tokenVenta = $(this).attr("tokenVenta");

  var tokenSucursal = $(this).attr("tokenSucursal");
  var estado = $(this).attr("estado");
  var usuario = $("#idUsuario").val();

  if (estado == 1) {

    swal({
      title: '¿Está seguro de anular este registro?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, anular el dato!',
      closeOnConfirm: false,
      closeOnCancel: true
    }, function(isConfirm) {

      if (isConfirm) {


        let descripcion = "";
        descripcion = prompt("¡Ingrese una descripción de la anulación!");

        if (descripcion != null) {

          while (descripcion == "") {
            descripcion = prompt("¡Ingrese una descripción de la anulación!");
          };

        } else {

          return false;
        }
        divLoading.style.display = "flex";
        var datos = new FormData();

        datos.append("tokenVenta", tokenVenta);
        datos.append("estado", estado);
        datos.append("usuario", usuario);
        datos.append("descripcion", descripcion);
        datos.append("tokenSucursal", tokenSucursal);

        $.ajax({

          url: "ajax/preventas.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta) {
            var objData = JSON.parse(respuesta);

            if (objData.status) {
              divLoading.style.display = "none";
              swal("success", objData.msg, "success");
              tablaVerVenta.ajax.reload(function() {

              });

            } else {
              swal("Error", objData.msg, "error");
            }

          }

        })

      }

    });

  } else {
    swal({
      title: '¿Está seguro de recuperar este registro?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, recuperar el dato!',
      closeOnConfirm: false,
      closeOnCancel: true
    }, function(isConfirm) {

      if (isConfirm) {

        let descripcion = "";
        descripcion = prompt("¡Ingese Una descripcion de la recuperacion!");

        if (descripcion != null) {

          while (descripcion == "") {
            descripcion = prompt("¡Ingese Una descripcion de la recuperacion!");
          };

        } else {

          return false;
        }

        var datos = new FormData();
        datos.append("tokenVenta", tokenVenta);
        datos.append("estado", estado);
        datos.append("usuario", usuario);
        datos.append("descripcion", descripcion);
        datos.append("tokenSucursal", tokenSucursal);

        $.ajax({

          url: "ajax/preventas.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respuesta) {
            var objData = JSON.parse(respuesta);

            if (objData.status) {
              swal("success", objData.msg, "success");
              tablaVerVentaAnuladas.ajax.reload(function() {

              });

            } else {
              swal("Error", objData.msg, "error");
            }

          }

        })

      }


    });
  }

  //}
})


$(document).on("click", ".cancelBtn", function() {
  $(".daterange-btn span").html('<i class="fa fa-calendar"></i> Movimiento hoy');

  consultarRango(0, 0);
})


/*=============================================
RANGO DE FECHAS
=============================================*/
$('.daterange-btn').daterangepicker({
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

    $('.daterange-btn span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));

    var fechaInicial = start.format('YYYY-MM-DD');

    var fechaFinal = end.format('YYYY-MM-DD');

    consultarRango(fechaInicial, fechaFinal);


  })


//FORMATEAR NUMERO DE DECIMAL
//================================

function formatNegativos(input) {

  var num = input.value.replace(/\./g, '');
  if (!isNaN(num)) {
    num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
    num = num.split('').reverse().join('').replace(/^[\.]/, '');
    input.value = num;
  }

}

function check(e) {
  tecla = (document.all) ? e.keyCode : e.which;

  //Tecla de retroceso para borrar, siempre la permite
  if (tecla == 8) {
    return true;
  }

  // Patron de entrada, en este caso solo acepta numeros y letras
  patron = /[0-9-]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}


function quitarAgregarProducto() {

  //Capturamos todos los id de productos que fueron elegidos en la venta
  var idProductos = $(".quitarProducto");


  //Capturamos todos los botones de agregar que aparecen en la tabla
  var botonesTabla = $(".tablaProductos tbody button.btnAgregarProducto");

  //Recorremos en un ciclo para obtener los diferentes idProductos que fueron agregados a la venta
  for (var i = 0; i < idProductos.length; i++) {

    //Capturamos los Id de los productos agregados a la venta
    var boton = $(idProductos[i]).attr("idProducto");

    //Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
    for (var j = 0; j < botonesTabla.length; j++) {

      if ($(botonesTabla[j]).attr("idProducto") == boton) {
        $(botonesTabla[j]).removeClass("btn-success btnAgregarProducto");
        $(botonesTabla[j]).addClass("btn-secondary");

      }
    }

  }

}


/*==========================================================
      Guardar Clientes
============================================================*/


function GuardarFormularioClientes() {

  // OBTENEMOS LOS DATOS



  var txtCliente = $("#txtCliente").val();

  var txtRuc = $("#txtRUC").val();

  var cmbCiudad = $("#cmbCiudad").val();

  var txtDireccion = "0";

  var pClavesCelular = "1";

  var txtEmail = "Nomail@gmail.com";

  //var celular = dividirCadena(pClavesCelular, coma);

  var txtFechaNac = 0;

  var cmbTipoCliente = $("#cmbTipoCliente").val();

  var cmbCategoria = $("#cmbCategoria").val();

  var txtGarante = "0";

  var txtCedulaGarante = 0;

  var pClavesRefLaboral = "0";

  var pClavesRefPersonal = "0";

  var cmbEstado = $("#cmbEstado").val();


  var galeria;
  var galeriaAntigua;
  var galeriaAntiguaEstatica;

  var cedulaFrontal;
  var cedulaFrontalAntigua;
  var cedulaFrontalAntiguaEstatica;

  var cedulaTrasera;
  var cedulaTraseraAntigua;
  var cedulaTraseraAntiguaEstatica;

  var txtLatitud;
  var txtLongitud;

  var txtTokenCliente = $("#tokenCliente").val();
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

      if (objData.status) {


        $('#ModalClientes').modal('hide');
        formClientes.reset();

        swal("success", objData.msg, "success");

        var datos = new FormData();

        datos.append("validarRuc", txtRuc);

        $.ajax({

          url: "ajax/clientes.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function(respuesta) {

            // console.log("respuesta", respuesta);
          
            var combo = document.getElementById("cmbClientes");
            var option = document.createElement('option');

            // añadir el elemento option y sus valores
            combo.options.add(option, 1);
            combo.options[1].value = respuesta["COD_CLIENTE"] + "/" + respuesta["TOKEN_CLIENTE"];
            combo.options[1].innerText = respuesta["RUC"] + " " + respuesta["CLIENTE"];

            $("#cmbClientes").val(respuesta["COD_CLIENTE"] + "/" + respuesta["TOKEN_CLIENTE"]);

            if (articulosVentas.length > 0) {
              // console.log("idclientes", $("#cmbClientes").val());

              if (avisoDescuento == 0) {
                agregarDescuentoCliente();

              } else {

              }
            }



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


function formatNegativosVariables(input) {
  var num = input;

  if (!isNaN(input)) {
    num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
    num = num.split('').reverse().join('').replace(/^[\.]/, '');

  }

  return "-" + num;

}


function getFullscreen(element) {
  if (element.requestFullscreen) {
    element.requestFullscreen();
  } else if (element.mozRequestFullScreen) {
    element.mozRequestFullScreen();
  } else if (element.webkitRequestFullscreen) {
    element.webkitRequestFullscreen();
  } else if (element.msRequestFullscreen) {
    element.msRequestFullscreen();
  }


}


function exitFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if (document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  }

}

document.getElementById("fullscreen").addEventListener("click", function(e) {
  getFullscreen(document.documentElement);
  $(".salir").removeClass('notblock');
  $(".fullscreen").addClass("notblock");

}, false);



document.getElementById("salir").addEventListener("click", function(e) {
  exitFullscreen();
  $(".salir").addClass("notblock");
  $(".fullscreen").removeClass("notblock");

}, false);