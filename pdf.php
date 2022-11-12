<?php 

// Include mpdf library file
require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();

//include ("../conexion.php");
include("incluir.php");
//Check for connection error
if($con->connect_error){
  die("Error in DB connection: ".$con->connect_errno." : ".$con->connect_error);    
}
// Select data from MySQL database


// Take PDF contents in a variable
$pdfcontent = '<h1>Welcome to etutorialspoint.com</h1>
		<h2>Employee Details</h2>
		<table autosize="1">
		<tr>
		<td style="width: 33%"><strong>NAME</strong></td>
		<td style="width: 36%"><strong>ADDRESS</strong></td>
		<td style="width: 30%"><strong>PHONE</strong></td>
		</tr>
		</table>';

$mpdf->WriteHTML($pdfcontent);

$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0; 

//call watermark content and image
$mpdf->SetWatermarkText('etutorialspoint');
$mpdf->showWatermarkText = true;
$mpdf->watermarkTextAlpha = 0.1;

//output in browser
$mpdf->Output();		
?>