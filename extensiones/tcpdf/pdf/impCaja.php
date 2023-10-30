<?php

require_once "../../../controladores/caja.controlador.php";
require_once "../../../modelos/caja.modelo.php";

class imprimirCajas{

public $idCajas;

public function traerImpresionCaja(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemCaja = "COD_APERTURA";
$valorCaja = $this->idCajas;

$cajaApertura = ControladorCaja::ctrMostrarCajaLimite($itemCaja, $valorCaja);

//date("d/m/Y", strtotime($originalDate))
$fecha_apertura = date("d/m/Y", strtotime(substr($cajaApertura["FECHA_APERTURA"],0,-8)));
$hora_apertura= $cajaApertura["HORA_APERTURA"];
$fecha_cierre = date("d/m/Y", strtotime(substr($cajaApertura["FECHA_CIERRE"],0,-8)));
$hora_cierre= $cajaApertura["HORA_CIERRE"];

$monto_parcial=$cajaApertura["MONTO_CIERRE"];


$monto_cierre= ($monto_parcial+$cajaApertura["MONTO"])- $cajaApertura["GASTOS"];

$gastos= $cajaApertura["GASTOS"];

$monto_apertura= number_format($cajaApertura["MONTO"]);
$monto_cierre= number_format($monto_cierre);
$monto_parcial=number_format($monto_parcial);
$gastos=number_format($gastos);
date_default_timezone_set('America/Asuncion');
$fechaActual = date('d-m-Y');
$horaActual = date('H:i:s');

$imagenes="images/back.jpg";

//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->setPrintHeader(false);

$pdf->setPrintFooter(false);

$pdf->AddPage('P', 'A7');

// ---------------------------------------------------------

$cabecera = <<<EOF

	<table style="font-size:8px; text-align:center">
		
		<tr>
			
			<!--<td style="width:80px"><img src="images/logoHollywood.jpg"></td>-->

			<td style="background-color:white; width:160px">
				
				<div style="font-size:10px; text-align:center; line-height:15px;">
					
					<br>
					MOTEL HOLLYWOOD
					<br>
					Arqueo de Caja
					<br>
					$fechaActual $horaActual
				</div>

			</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($cabecera, false, false, false, false, '');

// ---------------------------------------------------------

$datosDetalle = <<<EOF

	
	<table style="font-size:8px; text-align:center">
		<tr>
			<td><b>Detalle de la caja</b></td>
			<br><br>
		</tr>
	</table>


	<table style="font-size:8px; padding:5px 10px;">
	
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:160px">

				<b>Fecha y hora de apertura:</b> $fecha_apertura-$hora_apertura

			</td>

		</tr>
		
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:160px">
			
				<b>Fecha y hora de cierre:</b> $fecha_cierre-$hora_cierre

			</td>
		</tr>
		
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:160px">

					<b>Monto apertura:</b> $monto_apertura

			</td>
		</tr>

		<tr>
			<td style="border: 1px solid #666; background-color:white; width:160px">
					<b>Gastos:</b> $gastos
			</td>
		</tr>
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:160px">
					<b>Ingresos:</b> $monto_parcial
			</td>
		</tr>
		
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:160px">

					<b>Total cierre:</b> $monto_cierre

			</td>
		</tr>
		

	</table>

EOF;

$pdf->writeHTML($datosDetalle, false, false, false, false, '');

// ---------------------------------------------------------
// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 

$pdf->Output('impCaja.pdf');

}

}

$cajas = new imprimirCajas();
$cajas -> idCajas = $_GET["idApertura"];
$cajas -> traerImpresionCaja();

?>