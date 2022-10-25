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


$q=mysqli_query($con,"select *, date_format(fecha,'%d/%m/%Y') as fecha from productos_historial_precio where ".urldecode($_GET[where]));
$html="";
if(mysqli_num_rows($q)!=0){
    $html.='<table width="100%" id="detalles_presupuesto" style="margin-top:-800px !important;">
            <thead>
                <tr>
                    
                    <th scope="col">Producto</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Fecha</th>
                  
                </tr>
            </thead>
            <tbody>';
    $suma_total=0;       
    while($rs=mysqli_fetch_array($q)){
        $rp=mysqli_fetch_array(mysqli_query($con,"select * from productos where id=".$rs['id_producto']));
        $html.='<tr class="tr_1">
                    <td>'.$rp['nombre'].'</td>
                    <td>$'.number_format($rs['precio'],2,',','.').'</td>
                    <td>'.$rs['fecha'].'</td>
                </tr>';
                
    }
   
    $html.='</tbody>
            <tfoot id="tfoot-prod-presu">
                
            </tfoot>
            </table>';
}

$mpdf = new \Mpdf\Mpdf(
[
'margin_top' =>30,
'margin_left' => 10,
'margin_right' => 10,
'margin_bottom' => 25
]
);

$mpdf->AddPage();
$mpdf ->SetTitle('Reporte - Distribuidora Lucas');

$stylesheet = file_get_contents('../css/estilo_pdf.css');
$mpdf->WriteHTML($stylesheet,1);


$mpdf -> WriteHTML('<body>');

$cabecera=get_encabezado_pdf(intval($_GET['id']), date('d-m-Y',strtotime($r['fecha'])), $r['nombre'], $r['direccion'], $r['forma_pago'], date('d-m-Y',strtotime($r['fecha_vencimiento'])));
$mpdf->SetHTMLHeader($cabecera,'','E');

//$pie=get_pie_pdf();
//$mpdf->SetHTMLFooter($pie);

$mpdf->WriteHTML($html);
$mpdf -> WriteHTML('</body>');

$mpdf->Output('reporte.pdf', 'I');

//funciones de PDF
function get_encabezado_pdf($numero, $fecha, $cliente, $domicilio, $forma_pago, $fecha_vencimiento)
{
  $cuerpo=' 
            <table width="100%">
            <tr>
                <td width="45%" align="center">
                    <img src="../img/logo_mm.png" width="100px"><br>
                </td>
              
                <td width="45%" align="center">
                    <h2>Historial de Precios</h2>
                </td>';
$cuerpo .= ' 
                
            </tr>
           ';

$cuerpo .= '
            </table>
            ';
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