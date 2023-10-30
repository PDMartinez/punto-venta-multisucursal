<?php

require_once "../../../controladores/preventas.controlador.php";
require_once "../../../modelos/preventas.modelo.php";


class imprimirVenta{


public function traerImpresionVenta(){

	$nombres = explode("/",$this->tokenVenta);

	// var_dump($nombres[0]);
	// return;

	/*=============================================
	MOSTRAR CABECERA VENTA
	=============================================*/

	$item = "COD_PEDIDO";
	$valor = $nombres[0];

	$cabeceraTicket = ControladorPreVentas::ctrMostrarCabeceraTicket($item, $valor);

	// var_dump($cabeceraTicket);
	// return;

	/*=============================================
	MOSTRAR DETALLE TICKET
	=============================================*/

	$itemDet = "p.COD_PEDIDO";
	$valorDet = $nombres[0];

	$detalleTicket = ControladorPreVentas::ctrMostrarDetalleTicket($item, $valorDet);

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
		            <b>ORDEN DE PEDIDO</b>
		            =========================================

		            <div style="font-size:8px; text-align:left">

			            Cajero: '.$cabeceraTicket["NOMBRE_FUNC"].'

			            <br>

			            N° Pedido: '.$cabeceraTicket["COD_PEDIDO"].'

			            <br>

			            Fecha: '.$cabeceraTicket["FECHA_PEDIDO"].'

			            <br>

			            Cliente: '.$cabeceraTicket["CLIENTE"].'

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

// // var_dump($descuento);

// // ---------------------------------------------------------

          
$html .= '
          
	      </table>

	      <table style="font-size:8px;">

	      	<tr style="text-align:center">
            <td>--------------------------------------------------------------------------</td>
          </tr>

	      	<tr>
		        <td style="text-align:center">TOTAL: '.number_format($total,0,',','.').' Gs</td>
	        </tr>

	        <tr style="text-align:center">
            <td>--------------------------------------------------------------------------</td>
          </tr>';


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