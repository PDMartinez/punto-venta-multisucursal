
// const boton = document.getElementById("botonFlotante");
// boton.style = "bottom:10px;right:10px;position:fixed;z-index:9999;"
// document.body.appendChild(boton);
/*=============================================
VARIABLE LOCAL STORAGE
=============================================*/

// ES PARA GUARDAR LOS DATOS EN LA BASE DE DATOS//


function Guardarformulario() {
     
      var txtnrocompra =document.querySelector('input[name="nuevaCompra"]').value;   

      var txtnrorecibo =document.querySelector('input[name="txtnroRecibo"]').value;    
    
      var txtUsuario =document.querySelector('input[name="idUsuario"]').value;
    
      var txtidSucursal = document.querySelector('input[name="idSucursal"]').value;
   
      var cmbproveedor = $("#cmbProveedor").val();
    
      var cmbFormapago = $("#cmbFormaPago").val();
   
      var cmbTipoMovimiento = $("#cmbTipoMovimiento").val();
   
      var cmbTipoPago = $("#cmbTipoPago").val();
   
      var txtcantidadCuota = document.querySelector('input[name="txtCantidadCuota"]').value;
     
      var txtFechaVencimiento = document.querySelector('input[name="txtFechaVencimiento"]').value;

      var txtFechaCompra = document.querySelector('input[name="txtFechaCompra"]').value;
    
      var txtMontoCuota = document.querySelector('input[name="txtMontoCuota"]').value;
    
      var txtproductos = $("#listaProductos").val();   
   
      var cmbMetodopago = $("#nuevoMetodoPago").val();
    
      var txtpreciototal = document.querySelector('input[name="txtTotal"]').value;
     
      var totalTalba= txtproductos.length;
      
     if(txtnrocompra==""){
      swal({
              title: "Cargue un N° compra",
              type: "error",
              confirmButtonText: "¡Cerrar!"

        })
      return false;
     }

     if(txtFechaCompra==""){
      swal({
              title: "Seleccione una fecha de compra",
              type: "error",
              confirmButtonText: "¡Cerrar!"

        })
      return false;
     }

     if(txtproductos.length<=2){
     	swal({
				      title: "Cargue un producto",
				      type: "error",
				      confirmButtonText: "¡Cerrar!"

				})
     	return false;
     }

     if(cmbFormapago=="Credito"){
        if(cmbTipoPago==""){

          swal({
              title: "Seleccione el tipo de pago",
              type: "error",
              confirmButtonText: "¡Cerrar!"

        })
      return false;
        }else if(txtcantidadCuota==""){

          swal({
              title: "Cargue la cantidad cuota",
              type: "error",
              confirmButtonText: "¡Cerrar!"

        })
      return false;
        }else if(txtFechaVencimiento==""){
          swal({
              title: "Seleccione la fecha vencimiento",
              type: "error",
              confirmButtonText: "¡Cerrar!"

        })
      return false;
        }else if(txtMontoCuota==""){
          swal({
              title: "Cargue el monto de cuota",
              type: "error",
              confirmButtonText: "¡Cerrar!"

        })
      return false;
        }
      
     }else{
        if(cmbMetodopago==""){

          swal({
              title: "Seleccione el método de pago",
              type: "error",
              confirmButtonText: "¡Cerrar!"

        })
      return false;
        }else if(txtnrorecibo==""){
           swal({
              title: "Cargue el N° recibo",
              type: "error",
              confirmButtonText: "¡Cerrar!"

        })
        }
     }

  //   return false;
  var datos = new FormData();
  datos.append("txtnrocompra", txtnrocompra);
  datos.append("txtnrorecibo", txtnrorecibo);
  datos.append("txtUsuario", txtUsuario);
  datos.append("txtidSucursal", txtidSucursal);
  datos.append("cmbproveedor", cmbproveedor);
  datos.append("txtproductos", txtproductos);
  datos.append("cmbFormapago", cmbFormapago);
  datos.append("cmbTipoMovimiento", cmbTipoMovimiento);
  datos.append("cmbTipoPago", cmbTipoPago);
  datos.append("txtcantidadCuota", txtcantidadCuota);
  datos.append("txtFechaVencimiento", txtFechaVencimiento);
  datos.append("txtMontoCuota", txtMontoCuota);
  datos.append("cmbMetodopago", cmbMetodopago);
  datos.append("txtpreciototal", txtpreciototal);
  datos.append("txtFechaCompra",txtFechaCompra);
 
  $.ajax({
    url: "ajax/compras.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,

    success: function(respuesta) {

      var objData = JSON.parse(respuesta);

      if (objData.status) {
    
       swal("success", objData.msg, "success");
      
        window.location ="vercompras";

      } else {
        swal("Error", objData.msg, "error");
      }
    }

  })
  
  return (false);


}

if(localStorage.getItem("capturarRango")!=null){
	$("#daterange-btn span").html(localStorage.getItem("capturarRango"));
}else{
	$("#daterange-btn span").html('<i class="fa fa-calendar"></i> Rango de fecha');
}
/*=============================================
CARGAR LA TABLA DINÁMICA DE VENTAS
=============================================*/

 // $.ajax({

	// url: "ajax/datatable-ventas.ajax.php",
	// success:function(respuesta){
		
	// console.log("respuesta", respuesta);

 // 	}

 // })


 $(document).on("click", "#ProductoActivoOtros", function() {
var tablaCompraSucursales = $(".tablaComprasSucursales").DataTable({
   // dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
   //    buttons: [              
   //              'copyHtml5',
   //              'excelHtml5',
   //              'csvHtml5',
   //              'pdf'
   //          ],
  "ajax": "ajax/tablaProductosRemision.ajax.php?sucursal="+$("#idSucursal").val()+"&activo="+1+"&stock="+ 1,
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
 
});


 $('.tablaCompras').DataTable( {
   "ajax": "ajax/tablaProductosRemision.ajax.php?sucursal="+$("#idSucursal").val()+"&activo="+1+"&stock="+ 0,
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
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}

	}

} );
var cont=0;
// Agregar productos en la tablas
$(".tablaCompras tbody").on("click","button.btnAgregarProducto", function(){

var token_producto = $(this).attr("tokenProducto");
var idProducto = $(this).attr("idProducto");
var sucursal = $("#idSucursal").val();
 $(this).removeClass("btn-success btnAgregarProducto");
 $(this).addClass("btn-secondary");
var activo=1;

var datos = new FormData();
  	datos.append("token_producto", token_producto);
  	datos.append("sucursal", sucursal);
  	datos.append("activo", activo);
  	$.ajax({

      url:"ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
      		var precioNeto=0;
         var codigobarra=respuesta["CODBARRA"]
          var descripcion=respuesta["DESCRIPCION"]+' '+respuesta["NOMBRE_MARCA"]+' '+respuesta["NOMBRE_CATEGORIA"];
          var stock=respuesta["EXISTENCIA"];
          var precio=respuesta["PRECIO_COMPRA"];
         
          cont++;
          	token_producto=token_producto.replace(/'\'/g, '');
			 /*=============================================
			EVITAR QUE CARGUE, CUANDO EL STOCK ESTA EN CERO
			=============================================*/
       //    if(stock <= 0){

      	// 		swal({
			    //   title: "No hay stock disponible",
			    //   type: "error",
			    //   confirmButtonText: "¡Cerrar!"
			    // });

			    // $("button[idProducto='"+token_producto+"']").addClass("btn-success btnAgregarProducto");

			    // return;

       //    	}


            //Ingresamos un mensaje a mostrar



            let  cantidadProducto="";
            cantidadProducto = prompt("¡Ingese la cantidad!", 1);
                  
            if (cantidadProducto != null ){
              
              cantidadProducto= cantidadProducto.replace(/,/g, '.');

            while (isNaN(cantidadProducto) || cantidadProducto == "" || cantidadProducto <= 0 ) {
                cantidadProducto = prompt("¡Ingese la cantidad!", 1);
                };

            } else{
              cantidadProducto=1
            }

         
    

          
            //Detectamos si el usuario ingreso un valor
            

           
             precioNeto=respuesta["PRECIO_COMPRA"]*cantidadProducto;
             precioNeto = Math.round(precioNeto);
            
          	/*=================================================================*/

 
	    				$(".tdQuitar").append(

                '<!-- BOTON PARA QUITAR -->'+

                  '<div class="form-group nuevoQuitar'+idProducto+'">'+

                    '<div class="input-group">'+
                    
                      '<span class="input-group-addon">'+

                        '<button type="button" class="btn btn-danger btn-xs quitarProducto" style="width:35px" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button>'+

                      '</span>'+

                    '</div>'+

                  '</div>'

              );

               $(".tdNuevoCantidad").append(

                '<!-- Cantidad del producto -->'+

                  '<div class="form-group nuevoCantidad'+idProducto+'">'+

                    '<div class="input-group" style="width: 80px">'+
                
                      '<input type="text" class="form-control nuevaCantidadProducto" idProducto="'+idProducto+'" name="nuevaCantidadProducto" value="'+cantidadProducto+'" stock="'+stock+'" required>'+

                    '</div>'+

                  '</div>'

              );

              $(".tdNumero").append(

                '<!-- BOTON PARA QUITAR -->'+

                  '<div class="form-group nuevoNumero'+idProducto+'">'+

                    '<div class="input-group">'+
                   
                        '<label class="form-control nuevaNumero" idNumero="'+idProducto+'">'+codigobarra+'</label>'+

                    '</div>'+

                  '</div>'

              );

               $(".tdNuevoProducto").append(

                '<!-- Descripción del producto -->'+

                  '<div class="form-group nuevoProducto'+idProducto+'">'+
                    
                      '<div class="input-group" style="width: 200px">'+
                
                        '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'+token_producto+'" name="agregarProducto" value="'+descripcion+'" readonly required>'+

                      '</div>'+

                  '</div>'

              );

               $(".tdNuevoPrecio").append(

                '<!-- Impuesto del producto -->'+

                  '<div class="form-group nuevoPrecio'+idProducto+'">'+

                    '<div class="input-group" style="width: 150px">'+

                                                              
                      '<input type="text" class="form-control text-right nuevoPrecioProducto" idProducto="'+idProducto+'" precioReal="'+precio+'" name="nuevoPrecioProducto" value="'+precio+'" required>'+
                         
                    '</div>'+

                  '</div>'

              );

                $(".tdNuevoDescuento").append(

                '<!-- Impuesto del producto -->'+

                  '<div class="form-group nuevoDescuento'+idProducto+'">'+

                    '<div class="input-group" style="width: 150px">'+

                      '<input type="text" class="form-control text-right nuevoDescuentoProducto" idProducto="'+idProducto+'" name="nuevoDescuentoProducto" value="0">'+
                         
                    '</div>'+

                  '</div>'

              );

              $(".tdNuevoSubTotal").append(

                '<!--SubTotal-->'+

                  '<div class="form-group nuevoSubTotal'+idProducto+'">'+

                    '<div class="input-group" style="width: 150px">'+
                                           
                      '<input type="text" class="form-control text-right nuevoSubTotal" precioNeto="'+precioNeto+'" name="nuevoSubTotal" value="'+precioNeto+'" readonly required>'+
                         
                    '</div>'+

                  '</div>'
                
              ); 

	        //SUMAR LOS PRECIOS
	        sumarTotalPrecios();
	         // PONER FORMATO AL PRECIO DE LOS PRODUCTOS

	        $(".nuevoPrecioProducto").number(true, 0);
	        $(".nuevoSubTotal").number(true, 0);
             $(".nuevoDescuentoProducto").number(true, 0);

	        //listar producto en formato json

	        listarProductos();

             montocuota($("#txtCantidadCuota").val());
         
      }
  	});
 });

 /*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/

$(".tablas").on("draw.dt", function(){

	if(localStorage.getItem("quitarProducto") != null){

		var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));

		for(var i = 0; i < listaIdProductos.length; i++){

			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").removeClass('btn-dark');
			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").addClass('btn-success agregarProducto');

		}

//SUMAR LOS PRECIOS
	        sumarTotalPrecios();
	}


})


/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/

var idQuitarProducto = [];

localStorage.removeItem("quitarProducto");

 $(".formularioCompra").on("click", "button.quitarProducto", function(){

//	$(this).parent().parent().parent().parent().remove();
var idProducto=$(this).attr("idProducto");
 //id = $(this).attr("idProducto");

 // var nav = $(this).parent().parent().parent().parent().parent().children(".tdNuevoProducto").children(".nuevoProducto"+id);
  //console.log("Navegacion: ", nav);
  //console.log("idProducto: ", id);

  $(this).parent().parent().parent().parent().parent().children(".tdNumero").children(".nuevoNumero"+idProducto).remove();
  $(this).parent().parent().parent().parent().parent().children(".tdNuevoProducto").children(".nuevoProducto"+idProducto).remove();
  $(this).parent().parent().parent().parent().parent().children(".tdNuevoCantidad").children(".nuevoCantidad"+idProducto).remove();
  $(this).parent().parent().parent().parent().parent().children(".tdNuevoPrecio").children(".nuevoPrecio"+idProducto).remove();
   $(this).parent().parent().parent().parent().parent().children(".tdNuevoDescuento").children(".nuevoDescuento"+idProducto).remove();
  $(this).parent().parent().parent().parent().parent().children(".tdNuevoSubTotal").children(".nuevoSubTotal"+idProducto).remove();
  $(this).parent().parent().parent().parent().parent().children(".tdQuitar").children(".nuevoQuitar"+idProducto).remove();



/*=============================================
	ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
	=============================================*/

	if(localStorage.getItem("quitarProducto") == null){

		idQuitarProducto = [];
	
	}else{

		idQuitarProducto.concat(localStorage.getItem("quitarProducto"))

	}

	idQuitarProducto.push({"idProducto":idProducto});

	localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));

$("button.btnrecuperarBoton[idProducto='"+idProducto+"']").removeClass("btn-secondary");
$("button.btnrecuperarBoton[idProducto='"+idProducto+"']").addClass("btn-success btnAgregarProducto");
 
 //listar producto en formato json        
 listarProductos();

if($("#listaProductos").val().length<=2){
$("#txtTotal").val("");
$("#txtTotalArticulos").val("");

}else{
			//SUMAR LOS PRECIOS
	sumarTotalPrecios();     

}
montocuota($("#txtCantidadCuota").val());

});


/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioCompra").on("change", "input.nuevaCantidadProducto,input.nuevoDescuentoProducto,input.nuevoPrecioProducto", function(){
	var idProducto=$(this).attr("idProducto");
  console.log("idProducto", idProducto);
	
	// var nav = $(this).parent().parent().parent().parent().children(".tdNuevoSubTotal").children().children().children(".nuevoSubTotal");
 //  console.log("Navegacion: ", nav);

	var precio = $(this).parent().parent().parent().parent().children(".tdNuevoPrecio").children(".nuevoPrecio"+idProducto).children().children(".nuevoPrecioProducto").val();
	var precioNeto = $(this).parent().parent().parent().parent().children(".tdNuevoSubTotal").children(".nuevoSubTotal"+idProducto).children().children(".nuevoSubTotal");
  var stockCargada = $(this).parent().parent().parent().parent().children(".tdNuevoCantidad").children(".nuevoCantidad"+idProducto).children().children(".nuevaCantidadProducto");
  var descuento = $(this).parent().parent().parent().parent().children(".tdNuevoDescuento").children(".nuevoDescuento"+idProducto).children().children(".nuevoDescuentoProducto").val();
  
	//var stock = $(this).parent().parent().parent().parent().children(".tdNuevoCantidad").children(".nuevoCantidad"+idProducto).children().children(".nuevaCantidadProducto");
	var stock=$(".nuevaCantidadProducto").attr("stock");

  var stockcargadanuevo=0;

    stockcargadanuevo= stockCargada.val();
    stockcargadanuevo=stockcargadanuevo.replace(/,/g, '.');

	if (isNaN(stockcargadanuevo) || stockcargadanuevo == "" || stockcargadanuevo <= 0){
   stockcargadanuevo =1;
    stockCargada.val(stockcargadanuevo);

  }
  
  
  	var precioFinal = (stockcargadanuevo * precio);
 
  precioFinal=precioFinal-descuento;
    
//	console.log("precioFinal", precioNeto);
//$(this).parent().parent().parent().parent().children(".tdNuevoSubTotal").children(".nuevoSubTotal"+idProducto).children().children(".nuevoSubTotal").val(precioFinal);

	precioNeto.val(precioFinal);

	// // SUMAR TOTAL DE PRECIOS

	 sumarTotalPrecios();
  
	// // AGREGAR IMPUESTO
	        
 //    agregarImpuesto()

 //    // AGRUPAR PRODUCTOS EN FORMATO JSON

  listarProductos()
  montocuota($("#txtCantidadCuota").val());


})

/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/

function sumarTotalPrecios(){

	var precioItem = $(".nuevoSubTotal");
	var arraySumaPrecio = [];  

	for(var i = 0; i < precioItem.length; i++){

		 arraySumaPrecio.push(Number($(precioItem[i]).val()));
		 
	}

	function sumaArrayPrecios(total, numero){

		return total + numero;

	}

	var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
	
	$("#txtTotal").val(sumaTotalPrecio);
	$("#txtTotalArticulos").val(sumaTotalPrecio);
	
	$("#totalVenta").val(sumaTotalPrecio);
	$("#txtTotal").attr("total",sumaTotalPrecio);

}

$("#txtTotal").number(true, 0)
$("#txtTotalArticulos").number(true, 0)

/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductos(){

	var listaProductos = [];

	var descripcion = $(".nuevaDescripcionProducto");

	var cantidad = $(".nuevaCantidadProducto");
 
  var descuento = $(".nuevoDescuentoProducto");
  
	var precio = $(".nuevoPrecioProducto");

	var precioNeto = $(".nuevoSubTotal");

	for(var i = 0; i < descripcion.length; i++){

		listaProductos.push({ "id" : $(descripcion[i]).attr("idProducto"), 
							  "descripcion" : $(descripcion[i]).val(),
							  "cantidad" : $(cantidad[i]).val(),
                "descuento" : $(descuento[i]).val(),
							  "precio" : $(precio[i]).val(),
							  "total" : $(precioNeto[i]).val()})

	}

	$("#listaProductos").val(JSON.stringify(listaProductos)); 

     $.notify({
          title: "Compras: ",
          message: "Operación exitosa!!!",
          icon: 'fa fa-check' 
        },{
          type: "success"
        });
	//console.log((JSON.stringify(listaProductos))); 


}

/*=============================================
ANULAR PEDIDOS
=============================================*/
$(".tablas").on("click", ".btnEliminarCompras", function(){

	var idVenta = $(this).attr("idVenta");
	var estado =$(this).attr("estado");
	var usuario =$(this).attr("usuario");
	

if(estado=="EMITIDO"){

	swal({
        title: '¿Está seguro de anular la compra?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, anular compra!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=ventas&idVenta="+idVenta+"&estado="+estado+"&usuario="+usuario;
       					 }

  		})

		} else{
			swal({
        title: '¿Está seguro de recuperar el compra?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, recuperar compra!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=ventas&idVenta="+idVenta+"&estado="+estado+"&usuario="+usuario;
       					 }

  		})
		}

	//}
})


/*=============================================
RANGO DE FECHAS
=============================================*/
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Hoy'       : [moment(), moment()],
          'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
          'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
          'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
          'Últimos mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate  : moment()
      },

      function (start, end) {
        $('#daterange-btn span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));

      var fechaInicial = start.format('YYYY-MM-DD');
     
    	var fechaFinal = end.format('YYYY-MM-DD');
    
    	var capturarRango = $("#daterange-btn span").html();
        
   		localStorage.setItem("capturarRango", capturarRango);
   	
      })



    /*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/

$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function(){

	localStorage.removeItem("capturarRango");
})

/*=============================================
CAPTURAR HOY
=============================================*/

$(".daterangepicker.opensleft .ranges li").on("click", function(){

	var textoHoy = $(this).attr("data-range-key");

	if(textoHoy == "Hoy"){
   

		var d = new Date();
		
		var dia = d.getDate();
		var mes = d.getMonth()+1;
		var año = d.getFullYear();

		 if(mes < 10 && dia < 10){
			var fechaInicial = año+"-0"+mes+"-0"+dia;
			var fechaFinal = año+"-0"+mes+"-0"+dia;
			

		}else if(dia < 10){

			var fechaInicial = año+"-"+mes+"-0"+dia;
			var fechaFinal = año+"-"+mes+"-0"+dia;

		}else if (mes < 10){
			var fechaInicial = año+"-0"+mes+"-"+dia;
			var fechaFinal = año+"-0"+mes+"-"+dia;
			

		}else{

			var fechaInicial = año+"-"+mes+"-"+dia;
	    	var fechaFinal = año+"-"+mes+"-"+dia;

		}	


    	localStorage.setItem("capturarRango", "Hoy");


	}

})

//FORMATEAR NUMERO DE DECIMAL
//================================

function formatNegativos(input)
{

var num = input.value.replace(/\./g,'');
if(!isNaN(num)){
num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
num = num.split('').reverse().join('').replace(/^[\.]/,'');
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

function recargarDatatable(){
if( $('.tablaComprasSucursales > * > tr').length - 1>0){
          $(".tablaComprasSucursales").DataTable().ajax.reload();
        }

        if( $('.tablaCompras > * > tr').length - 1>0){
         $(".tablaCompras").DataTable().ajax.reload();
        }

      
}



// const getReminTime=deadline=>{
// 	let now=new Date();
// 	remainTime=(new Date(deadline) - now+1000)/1000,
// 	remainSecounds=('0'+Math.floor(remainTime % 60)).slice(-2),
// 	remainMinutes=('0'+Math.floor(remainTime / 60 % 60)).slice(-2),
// 	remainHours=('0'+Math.floor(remainTime / 3600 % 24)).slice(-2),
// 	reaminDays=Math.floor(remainTime/(3600*24));

// 	return{
// 		remainTime,
// 		remainSecounds,
// 		remainMinutes,
// 		remainHours,
// 		reaminDays
// 	}
// };

// console.log(getReminTime('Fri Jan 22 2021 06:36:23 GMT-0300'));

  $('#demoNotify').click(function(){
        $.notify({
          title: "Update Complete : ",
          message: "Something cool is just updated!",
          icon: 'fa fa-check' 
        },{
          type: "info"
        });
      });


function montocuota(cuota){

  var total=  $("#txtTotal").val();
  var cuotas=cuota;
  var montocuota=total/cuotas

  if (total<=0)
{
    $("#txtMontoCuota").val(0);
 
}else{
 
   $("#txtMontoCuota").val(montocuota);
  $("#txtMontoCuota").number(true, 0)
}
 

}

$("#txtCantidadCuota").change(function(){
   montocuota($(this).val());
})

$("#cmbFormaPago").change(function(){
  var Vercredito = document.getElementById("Credito");
  var vencimiento = document.getElementById("Vencimiento");
  var cantidadcuota = document.getElementById("cantidadCuota");
  var montocuota = document.getElementById("montocuota");
  
  var metodopago = document.getElementById("metodopago");
  var recibo = document.getElementById("recibo");
  
  if ($(this).val()=="Credito"){
    Vercredito.style.display = "block";
    vencimiento.style.display = "block";
    cantidadcuota.style.display = "block";
    montocuota.style.display = "block";

    metodopago.style.display = "none";
    recibo.style.display = "none";

  }else{
    Vercredito.style.display = "none";
    vencimiento.style.display = "none";
    cantidadcuota.style.display = "none";
     montocuota.style.display = "none";

    metodopago.style.display = "block";
    recibo.style.display = "block";
  }
 

})
   