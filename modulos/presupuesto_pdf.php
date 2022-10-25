<?php
@session_start();

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

include ("../conexion.php");
conectar();

require_once '../vendor_mpdf/autoload.php';

if($_SESSION['user']==0)
{
    echo "<script>window.location='index.php';</script>";
}

$r=mysqli_fetch_array(mysqli_query($con,"select pr.id, pr.fecha, c.nombre, c.direccion, f.nombre as forma_pago, pr.fecha_vencimiento, pr.descuento from presupuestos pr, clientes c, formas_pagos f where pr.id=".intval($_GET['id'])." and pr.id_cliente=c.id and pr.id_forma_pago=f.id"));

$q=mysqli_query($con,"select pd.precio, pd.precio, pd.subtotal, pd.cantidad, p.nombre, p.codigo from presupuestos_detalles pd, productos p where pd.id_presupuesto=".intval($_GET['id'])." and pd.id_producto=p.codigo order by pd.id");
$html="";
if(mysqli_num_rows($q)!=0){
    $html.='<table width="100%" id="detalles_presupuesto">
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
                    <td>'.$rs['codigo'].'</td>
                    <td align="justify"> '.ucfirst($rs['nombre']).' </td>
                    <td>'.$rs['cantidad'].'</td>
                    <td>$'.number_format($rs['precio'],2,',','.').'</td>
                    <td>$'.number_format($rs['subtotal'],2,',','.').'</td>
                </tr>';
                $suma_total=$suma_total+$rs['subtotal'];
    }
    //pregunto si tiene descuento
    $descuento='';
    if(!empty($r['descuento']))
        $descuento='<b>Descuento: </b> '.$r['descuento'].'%';
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
                    <td align="right"> $'.number_format(($suma_total-(($suma_total*$r['descuento'])/100)),2,',','.').'</td>
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

$mpdf->AddPage();
$mpdf ->SetTitle('Presupuesto '.intval($_GET['id']).' - Distribuidora Lucas');

$stylesheet = file_get_contents('../css/estilo_pdf.css');
$mpdf->WriteHTML($stylesheet,1);


$mpdf -> WriteHTML('<body>');

$cabecera=get_encabezado_pdf(intval($_GET['id']), date('d-m-Y',strtotime($r['fecha'])), $r['nombre'], $r['direccion'], $r['forma_pago'], date('d-m-Y',strtotime($r['fecha_vencimiento'])));
$mpdf->SetHTMLHeader($cabecera,'','E');

$pie=get_pie_pdf();
$mpdf->SetHTMLFooter($pie);

$mpdf->WriteHTML($html);
$mpdf -> WriteHTML('</body>');

$mpdf->Output('presupuesto.pdf', 'I');

//funciones de PDF
function get_encabezado_pdf($numero, $fecha, $cliente, $domicilio, $forma_pago, $fecha_vencimiento)
{
  $cuerpo=' 
            <table width="100%">
            <tr>
                <td width="45%" align="center">
                    <img src="../img/logo_mm.png" width="100px"><br>
                </td>
                <td width="10%" align="center" border="1"><h1><b>X</b></h1></td> 
                <td width="45%" align="center">
                    <h2>Presupuesto</h2>
                </td>';
$cuerpo .= ' 
                </td>
            </tr>
            <tr>
                <td width="45%" style="padding-left:5%;">
                    <p><b>Teléfono:</b> 3755-435564</p>
                    <p><b>E-mail:</b> lucas_ferfer@hotmail.com</p>
                </td>
                <td width="10%" align="center"></td> 
                <td width="45%" style="padding-left:5%;">
                    <p><b>Número:</b> '.$numero.'</p>
                    <p><b>Fecha:</b> '.$fecha.'</p>
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
                <td><b>Vencimiento:</b> </td>
                <td>'.$fecha_vencimiento.'</td>
            </tr>
            </table>';
  return $cuerpo;
}

function get_pie_pdf()
{
    $username = $_SESSION['nombre'];
    $fecha = date("d/m/y H:i:s");
    $pie = '<hr>
            <table width="100%">
                <tr>
                    <td width="20%" align="center">
                        <img width="50px" src="../img/logo_mm.png" />
                    </td>
                    <td width="60%" align="left" >
                        Generado: <i>'.$fecha.'</i> <br />
                        Usuario: <i>'.ucfirst($username).'</i> <br />
                        </i>
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