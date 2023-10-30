<?php

require_once "../../../controladores/cuentasCobrar.controlador.php";
require_once "../../../modelos/cuentasCobrar.modelo.php";


class imprimirCobro{


public function traerImpresionCobro(){

	$nombres = explode("/",$this->detalleCuenta);
	$nombres1 = explode("/",$this->codCuenta);

	/*=============================================
	MOSTRAR CABECERA TICKET
	=============================================*/

	$item = "dcc.COD_DETCUENTAS";
	$valor = $nombres[0];

	$mostrarCuenta = ControladorCuentasCobrar::ctrMostrarCabeceraTicket($item, $valor);
	// var_dump($mostrarCuenta);

	/*=============================================
	MOSTRAR DETALLE TICKET
	=============================================*/

	$itemDet = "dcc.COD_DETCUENTAS";
	$valorDet = $nombres[0];
	$valorDet1 = $nombres1[0];

	$mostrarCuentaDet = ControladorCuentasCobrar::ctrMostrarDetalleTicket($item, $valorDet, $valorDet1);

	$productos = explode('||',$mostrarCuentaDet["DESCRIPCION"]);

	// var_dump($productos);
	// var_dump(count($productos));
	// return;

	// foreach ($productos as $key => $item) {
	// 	var_dump($item);
	// }
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

		            '.$mostrarCuenta["NOMBRE_EMPRESA"].'

		            <br>

		            De '.$mostrarCuenta["PROPIETARIO_EMPRESA"].'

		            <br>

		            RUC: '.$mostrarCuenta["RUC_EMPRESA"].'

		            <br>

		            Teléfonos: '.$mostrarCuenta["TELEFONO_SUC"].'

		            <br>

		            Dirección: '.$mostrarCuenta["DIRECCION"].'

		            =========================================
		            <br>
		            <b>RECIBO DE DINERO</b>
		            =========================================

		            <div style="font-size:8px; text-align:left">

			            Cajero: '.$mostrarCuenta["NOMBRE_FUNC"].'

			            <br>

			            Fecha: '.$mostrarCuenta["FECHA_PAGO"].'

			            <br>

			            Cliente: '.$mostrarCuenta["CLIENTE"].'

			            <br>

			            RUC/C.I.N°: '.$mostrarCuenta["RUC_CLIENTE"].'

			            <br>

			            N° Factura: '.$mostrarCuenta["NRO_MOVIMIENTO"].'

			          </div>

		          </td>

		        </tr>

		    </table>

		    <table style="font-size:8px; ">

	        <tr style="text-align:center">

	          <td>

	            =========================================

	            <b>CONCEPTO DE PRODUCTOS</b>

	          </td>

	        </tr>

	        <tr>

	          <td>

	            <table>';


// ---------------------------------------------------------

foreach ($productos as $key => $item) {

$html .= '

		            <tr>
			            <td style="text-align:left">'.$item.'</td>
		           	</tr>';

}

// ---------------------------------------------------------

$html .='
							</table>

	            =========================================

	          </td>

	        </tr>

	        <tr>

            <td>

            	<table>

	            	<tr>
		            	<td style="text-align:left">TOTAL DEUDA:</td> <td style="text-align:right">'.number_format($mostrarCuentaDet["TOTAL_CUENTA"],0,',','.').'</td>
	            	</tr>

	            	<tr>
		            	<td style="text-align:left">TOTAL PAGADO:</td> <td style="text-align:right">'.number_format($mostrarCuentaDet["MONTO_PAGADO_REIMP"],0,',','.').'</td>
	            	</tr>

	            	<tr>
		            	<td style="text-align:left" colspan="2">------------------------------------------------------------------------</td>
	            	</tr>

	            	<tr>
		            	<td style="text-align:left">N° recibo:</td> <td style="text-align:right">'.$mostrarCuentaDet["NRO_RECIBO"].'</td>
	            	</tr>

	            	<tr>
		            	<td style="text-align:left">Fecha pago:</td> <td style="text-align:right">'.$mostrarCuentaDet["FECHA_PAGO"].'</td>
	            	</tr>

	            	<tr>
		            	<td style="text-align:left">Fecha vencimiento:</td> <td style="text-align:right">'.$mostrarCuentaDet["FECHA_VENC"].'</td>
	            	</tr>

	            	<tr>
		            	<td style="text-align:left">N° cuota:</td> <td style="text-align:right">'.intval($mostrarCuentaDet["CUOTA_PAGADA_REIMP"]).'/'.$mostrarCuentaDet["CANT_CUOTA"].'</td>
	            	</tr>

	            	<tr>
		            	<td style="text-align:left">Monto cuota:</td> <td style="text-align:right">'.number_format($mostrarCuentaDet["MONTO_CUOTA"],0,',','.').'</td>
	            	</tr>

	            	<tr>
		            	<td style="text-align:left">Saldo anterior:</td> <td style="text-align:right">'.number_format($mostrarCuentaDet["SALDO_ANT"],0,',','.').'</td>
	            	</tr>

	            	<tr>
		            	<td style="text-align:left">Pago de Cuota:</td> <td style="text-align:right">'.number_format($mostrarCuentaDet["PAGO"],0,',','.').'</td>
	            	</tr>

	            	<tr>
		            	<td style="text-align:left">Saldo Actual:</td> <td style="text-align:right">'.number_format($mostrarCuentaDet["SALDO"],0,',','.').'</td>
	            	</tr>

	            	<tr>
		            	<td style="text-align:left" colspan="2">------------------------------------------------------------------------</td>
	            	</tr>

	            </table>            	

            </td>

          </tr>

          <tr>

            <td style="text-align:center">

              <br><br><br><br>

              <label>.............................................</label>

              <br>

              <label>FIRMA DEL CAJERO </label>

            </td>

          </tr>

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

$cobro = new imprimirCobro();
$cobro -> detalleCuenta = $_GET["detalleCuenta"];
$cobro -> codCuenta = $_GET["codCuenta"];

// var_dump($_GET["codCuenta"]);
// return;

$cobro -> traerImpresionCobro();

?>