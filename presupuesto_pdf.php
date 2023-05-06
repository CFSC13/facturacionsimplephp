<?php
//ini_set('display_errors', 1); 
//ini_set('display_startup_errors', 1); 
//error_reporting(E_ALL);
//@session_start();

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

include ("includes/conexion.php");
//include("incluir.php"); 
conectar();
// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';
//require_once ('vendor/autoload.php');


//if($_SESSION['user']==0)
/*
{
    echo "<script>window.location='index.php';</script>";
}
*/
$r=mysqli_fetch_array(mysqli_query($con,"select pr.id_factura, pr.fecha_de_emision, c.nombre, c.domicilio, f.nombre as forma_pago from factura pr, cliente c, condicion_venta f where pr.id_factura=".intval($_GET['id'])." and pr.id_cliente=c.id_cliente and pr.id_condicion_venta=f.id_condicion_venta"));

//echo mysqli_error($con);

$q=mysqli_query($con,"select pd.precio_unitario, pd.descuento as descuento, pd.precio_unitario, pd.subtotal, pd.cantidad, p.nombre, p.id_producto from detalle_factura pd, producto p where pd.id_factura=".intval($_GET['id'])." and pd.id_producto=p.id_producto order by pd.id_producto");
//echo mysqli_error($con);

$html="";


if(mysqli_num_rows($q)!=0){
    $html.='<table width="100%">
            <thead>
                <tr>
                    <th scope="col">Cod</th>
                    <th scope="col">Poducto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio Unitario</th>
                    <th scope="col">Sub-Total</th>
                </tr>
            </thead>
            <tbody>';
    $suma_total=0;       
    while($rs=mysqli_fetch_array($q)){
        $html.='<tr class="tr_1">
                    <td>'.$rs['id_producto'].'</td>
                    <td align="justify"> '.ucfirst($rs['nombre']).' </td>
                    <td>'.$rs['cantidad'].'</td>
                    <td>$'.number_format($rs['precio_unitario'],2,',','.').'</td>
                    <td>$'.number_format($rs['subtotal'],2,',','.').'</td>
                </tr>';
        $suma_total=$suma_total+$rs['subtotal'];
    }
    //pregunto si tiene descuento
    //ver como hacer con el descuento!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    //comparar con plantilla backend
                        //select DISTINCT f.id_factura, df.descuento from factura f, detalle_factura df join detalle_factura where f.id_factura=27;
    $descuento='';
    $t=mysqli_fetch_array(mysqli_query($con,"select DISTINCT f.id_factura, df.descuento from factura f, detalle_factura df join detalle_factura where f.id_factura=".intval($_GET['id'])));
    if(!empty($t['descuento']))
        $descuento='<b>Descuento: </b> '.$t['descuento'].'%';    
    $html.='</tbody>
            <tfoot id="tfoot-prod-presu">
                <tr>
                    <td align="left">'.$descuento.'</td>
                    <td colspan="3" align="right"> <b>Sub-Total:</b> </td>
                    <td align="right"> $'.number_format($suma_total,2,',','.').'</td>
                </tr>
                <tr>
                    <td align="left"></td>
                    <td colspan="3" align="right"> <b>Total:</b> </td>
                    <td align="right"> $'.number_format(($suma_total-(($suma_total*$t['descuento'])/100)),2,',','.').'</td>
                </tr>
            </tfoot>
            </table>';

}

$mpdf = new \Mpdf\Mpdf(

[
'margin_top' =>60,
'margin_left' => 10,
'margin_right' => 10,
'margin_bottom' => 25
]
);
$mpdf->debug = true;


$mpdf->AddPage();
$mpdf ->SetTitle('Presupuesto '.intval($_GET['id']).' - Distribuidora Lucas');

$stylesheet = file_get_contents('css/estilo_pdf.css');
$mpdf->WriteHTML($stylesheet,1);


$mpdf -> WriteHTML('<body>');

$cabecera=get_encabezado_pdf(intval($_GET['id']), date('d-m-Y',strtotime($r['fecha_de_emision'])), $r['nombre'], $r['domicilio'], $r['forma_pago']);
$mpdf->SetHTMLHeader($cabecera,'','E');

$pie=get_pie_pdf();
$mpdf->SetHTMLFooter($pie);

$mpdf->WriteHTML($html);
$mpdf -> WriteHTML('</body>');
//$mpdf->Output();
$mpdf->Output('factura.pdf', 'I');


//funciones de PDF
function get_encabezado_pdf($numero, $fecha_emision, $cliente, $domicilio, $forma_pago)
{
  $cuerpo=' 
            <table width="100%">
            <tr>
                <td width="45%" align="center">
                </td>
                <td width="10%" align="center" border="1"><h1><b>B</b></h1></td> 
                <td width="45%" align="center">
                    <h2>Factura</h2>
                </td>';
$cuerpo .= ' 
                </td>
            </tr>
            <tr>
                <td width="45%" style="padding-left:5%;">
                    <p><b>Teléfono:</b> 3764-111111</p>
                    <p><b>E-mail:</b> micorreo@gmail.com</p>
                </td>
                <td width="10%" align="center"></td> 
                <td width="45%" style="padding-left:5%;">
                <p><b>Número:</b> '.$numero.'</p>
                <p><b>Fecha:</b> '.$fecha_emision.'</p>
                </td>
            </tr>';

$cuerpo .= '
            </table>
            <hr>
            <table>
            <tr>
                <td width="15%"><b>Señor/es:</b> </td>
                <td width="55%">'.ucwords($cliente).' </td>
                <td  width="15%" align="left"><b>Forma de pago: </b> </td>
                <td  width="10%" align="left">'.ucfirst($forma_pago).' </td>
            </tr>
            <tr>
                <td><b>Domicilio:</b> </td>
                <td>'.ucfirst($domicilio).' </td>
                </tr>
            </table>';
  return $cuerpo;
}

function get_pie_pdf()
{
   // $username = $_SESSION['nombre'];
    $fecha = date("d/m/y H:i:s");
    $pie = '<hr>
            <table width="100%">
                <tr>
                    <td width="20%" align="center">
                        <img width="50px" src="img/logo_mmtr.png" />
                    </td>
                    <td width="60%" align="left" >
                        Generado: <i>'.$fecha.'</i> <br /> </i>
                        
                    </td>
                    <td width="20%" align="right">
                        P&aacute;gina: {PAGENO}/{nbpg}
                    </td>
            </tr>
            </table>';
  return $pie;
}


//fin de funciones de PDF
?>  