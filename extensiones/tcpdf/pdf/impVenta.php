<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";


class imprimirVenta{


public function traerImpresionVenta(){

	$nombres = explode("/",$this->tokenVenta);

	// var_dump($nombres[0]);
	// return;

	/*=============================================
	MOSTRAR CABECERA VENTA
	=============================================*/

	$item = "COD_FACTURA";
	$valor = $nombres[0];

	$cabeceraTicket = ControladorVentas::ctrMostrarCabeceraTicket($item, $valor);

	// var_dump($cabeceraTicket["MONTO_INGRESADO"]);
	// var_dump($cabeceraTicket["TOTAL_VENTA"]);
	$vuelto = intval($cabeceraTicket["MONTO_INGRESADO"]) - intval($cabeceraTicket["TOTAL_VENTA"]);
	// var_dump($vuelto);

	/*=============================================
	DECODIFICADOS NUESTRA CADENA JSON DE METODO PAGO
	=============================================*/

	$decodedText = html_entity_decode($cabeceraTicket["METODO_PAGO"]);
	$metodo_pago = (json_decode($decodedText, true));
	// var_dump(($metodo_pago[0]['entrega']));


	/*=============================================
	MOSTRAR DETALLE TICKET
	=============================================*/

	$itemDet = "v.COD_FACTURA";
	$valorDet = $nombres[0];

	$detalleTicket = ControladorVentas::ctrMostrarDetalleTicket($item, $valorDet);

	// var_dump($detalleTicket);
	// return;

/*=============================================
	REQUERIMOS LA CLASE TCPDF
=============================================*/

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->setPrintHeader(false);

$pdf->setPrintFooter(false);

$pdf->SetMargins(0, 0, 0, false); // set the margins

$pdf->SetAutoPageBreak(TRUE, 0);


$pdf->AddPage('P', 'A7');

// ---------------------------------------------------------

$html = '

			<FONT FACE="arial">

		    <table style="font-size:8px; text-align:center">
		    
		        <tr>

		          <td>

		            <br><br>

		            '.$cabeceraTicket["NOMBRE_EMPRESA"].'

		            <br>

		            De '.$cabeceraTicket["PROPIETARIO_EMPRESA"].'

		            <br>

		            RUC: '.$cabeceraTicket["RUC_EMPRESA"].'

		            <br>

		            Teléfonos: '.$cabeceraTicket["TELEFONO_SUC"].'

		            <br>

		            Dirección: '.$cabeceraTicket["DIRECCION"].'

		            =========================================
		            <br>
		            <b>NOTA DE PEDIDOS</b>
		            =========================================

		            <div style="font-size:8px; text-align:left">

			            Cajero: '.$cabeceraTicket["NOMBRE_FUNC"].'

			            <br>

			            N° Pedido: '.$cabeceraTicket["NRO_MOVIMIENTO"].'

			            <br>

			            Fecha: '.$cabeceraTicket["FECHA_VENTA"].'

			            <br>

			            Cliente: '.$cabeceraTicket["CLIENTE"].'

			            <br>

			            Condición Pedido: '.$cabeceraTicket["FORMA_PAGO"].'

			          </div>

		          </td>

		        </tr>

		    </table>

		    <table style="font-size:7px;">

		    	<tr>
                 
            <td colspan="6">------------------------------------------------------------------------------------</td>

          </tr>

	        <tr>

	          <td style="font-size:7px;"><b>Descrip.</b></td>
            <td style="font-size:7px; width:25px"><b>Cant.</b></td>
            <td style="font-size:7px; width:35px"><b>Bruto</b></td>
            <td style="font-size:7px; width:35px"><b>Neto</b></td>
            <td style="font-size:7px; width:35px"><b>Desc.</b></td>
            <td style="font-size:7px; width:43px"><b>Subtotal</b></td>

	        </tr>

	        <tr>
                 
            <td colspan="7">------------------------------------------------------------------------------------</td>

          </tr>';

// ---------------------------------------------------------
$total = 0;
$descuento = 0;

foreach ($detalleTicket as $key => $item) {

	$descuento = ($descuento + ($item["DESCUENTO"])*-1);

	$total = $total + intval($item["SUBTOTAL"]);

				$html .= '

		      <tr>

          	<td colspan="6" style="text-align:left">'.$item["DESCRIPCION"].'</td>

          </tr>

          <tr>
                 
            <td></td>
            <td style="text-align:left; width:25px">'.$item["CANTIDAD"].'</td>
            <td style="text-align:left; width:35px">'.number_format($item["BRUTO"],0,',','.').'</td>
            <td style="text-align:left; width:35px">'.number_format($item["NETO"],0,',','.').'</td>
            <td style="text-align:left; width:35px">'.number_format($item["DESCUENTO"],0,',','.').'</td>
            <td style="text-align:left; width:43px">'.number_format($item["SUBTOTAL"],0,',','.').'</td>

          </tr>';

}

// var_dump($descuento);

// ---------------------------------------------------------

          
$html .= '
          
	      </table>

	      <table style="font-size:8px;">

	      	<tr style="text-align:center">
            <td>--------------------------------------------------------------------------</td>
          </tr>

	      	<tr>
		        <td style="text-align:center">TOTAL: '.number_format($total,0,',','.').' Gs</td>
	        </tr>';

$idMetodo;

for ($i=0; $i < count($metodo_pago); $i++) {

	$idMetodo = explode("/", $metodo_pago[$i]["id_metodo"]);
	$item = "COD_FORMAPAGO";
	$valor = $idMetodo[0];

	$metodoPagoDesc = ControladorVentas::ctrMostrarMetodoPagoId($item, $valor);

	// var_dump($metodo_pago[$i]["entrega"]);

	$html .= '

					<tr>

            <td>

							<table>

			          <tr>
				          <td style="text-align:left; white-space: nowrap;">'.$metodoPagoDesc["DESCRIPCION_FORMA"].':</td> <td style="text-align:right; white-space: nowrap">'.number_format($metodo_pago[$i]['entrega'],0,',','.').' Gs</td>
			          </tr>

			        </table>

			    	</td>

          </tr>';
}

$html .= '
					<tr>

            <td>

							<table>

								<tr style="text-align:center">
			            <td colspan="2">--------------------------------------------------------------------------</td>
			          </tr>

								<tr>
				          <td style="text-align:left; white-space: nowrap">TOTAL RECIBIDO:</td> <td style="text-align:right; white-space: nowrap">'.number_format($cabeceraTicket["MONTO_INGRESADO"],0,',','.').' Gs</td>
			          </tr>

			          <tr>
				          <td style="text-align:left; white-space: nowrap">VUELTO:</td> <td style="text-align:right; white-space: nowrap">'.number_format($vuelto,0,',','.').' Gs</td>
			          </tr>

			        </table>

			    	</td>

          </tr>

          <tr style="text-align:center">
            <td>--------------------------------------------------------------------------</td>
          </tr>';

if($descuento > 0){

	$html .= '

          <tr>

            <td style="text-align:center">

              <br><br>

              <label>AHORRASTE EN ESTA COMPRA:  '.number_format($descuento,0,',','.').' Gs </label>

            </td>

          </tr>';

}

$html .= '

          <tr>

            <td style="text-align:center">

              <br><br>

              <label>MUCHAS GRACIAS POR SU PREFERENCIA!!! </label>

            </td>

          </tr>

	      </table>

		</FONT>';


// ---------------------------------------------------------


$pdf->writeHTML($html, true, false, false, false, '');


$pdf->Output('impCobro.pdf');

}

}

$cobro = new imprimirVenta();
$cobro -> tokenVenta = $_GET["tokenVenta"];

// var_dump($_GET["tokenVenta"]);
// return;

$cobro -> traerImpresionVenta();

?>