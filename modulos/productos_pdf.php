<?php
@session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');

include ("../conexion.php");
conectar();

require_once '../vendor_mpdf/autoload.php';

if($_SESSION['user']==0)
{
    echo "<script>window.location='index.php';</script>";
}

//caratula
$caratula="";
//saco las marcas
$sql_marcas=mysqli_query($con,"select *from marcas where activo='si' order by nombre"); 
if(mysqli_num_rows($sql_marcas)!=0)
{
    //logo de la empresa
    $caratula.='
                <table width="100%">
                    <tr>
                        <td align="center">
                            <img width="40%" src="../img/logo_mm.png" />
                        </td>
                    </tr>';
     $caratula.='<tr>
                    <td align="center">';            
                        while($r_marcas=mysqli_fetch_array($sql_marcas))
                        {
                            if(!empty($r_marcas['logo']))
                                $caratula.='<img src="../marcas/'.$r_marcas['logo'].'" width="20%">';
                        }   
    $caratula.='    </td>
                </tr>';
} 

//saco los rubros
$sql_rubros=mysqli_query($con,"select *from categorias order by nombre"); 
if(mysqli_num_rows($sql_rubros)!=0)
{
    //logo de la empresa
     $caratula.='<tr>
                    <td align="center">
                        <hr>';            
                        while($r_rubros=mysqli_fetch_array($sql_rubros))
                        {
                            $caratula.='<span class="rubros">- '.$r_rubros['nombre'].' </span>';
                        }   
    $caratula.='    </td>
                </tr>

                <tr>
                    <td align="center">
                        <hr>
                        <br>
                        <br>
                        <p>
                            <img src="../img/telefono.png" width="35px" align="absmiddle"> 3755-435564   
                            <img src="../img/email.png" width="35px" align="absmiddle"> lucas_ferfer@hotmail.com 
                        </p>
                        <p>
                            <br>
                            <img src="../img/ubicacion.png" width="35px" align="absmiddle"> Amalia Vera 4986 - Posadas - Misiones
                        </p>
                    </td>
                </tr>
                </table>';
} 

//fin de caratula

//listado
$cuerpo="";
$q=mysqli_query($con,"select p.*, m.nombre as marca, c.nombre as categoria, (select url from fotos_productos where id_producto=p.id order by orden limit 1) as foto from productos p, marcas m, categorias c where p.id_marca=m.id and p.activo='si' and p.id_categoria=c.id order by p.orden"); 
if(mysqli_num_rows($q)!=0)
{
    $cuerpo.='<table width="100%">';
    /*$cuerpo.='
                <thead>
                    <tr>
                        <th width="25%" align="center">Foto</th>
                        <th width="45%" align="center">Nombre</th>
                        <th width="10%" align="center">Código</th>
                        <th width="20%" align="center">Precio</th>
                    </tr>
                </thead>';*/
    $columnas=1;            
    while($r=mysqli_fetch_array($q))
    {
        if($columnas==1)
        {
            $cuerpo.='<tr align="center">';
        }
        if($columnas==5)
        {
            $cuerpo.='</tr>';
            $cuerpo.='<tr align="center">';
            $columnas=1;
        }
        $cuerpo.='  <td width="25%" align="center" class="celda">
                        <p class="nombre_producto">
                            <br>
                            '.$r['nombre'].'
                            <br>
                            <br>
                        </p>
                        <p><img src="../fotos/'.$r['foto'].'" height="240px"></p>
                        
                        <p class="codigo_producto">
                            <br>
                            Art.: '.$r['codigo'].'
                        </p>
                        <p class="precio_producto">
                            $'.number_format($r['precio'],2,',','.').'
                            <br>
                            <br>
                            <br>
                        </p>
                    </td>';
        $columnas++;
    }
    $cuerpo.='</tr></table>';
} 
//fin de listado

//primera hoja
$mpdf = new \Mpdf\Mpdf(
[
'margin_top' =>40,
'margin_left' => 10,
'margin_right' => 10,
'margin_bottom' => 25
]
);

$mpdf->AddPage();
$mpdf ->SetTitle('Catálogo de Productos - Distribuidora Lucas');

$stylesheet = file_get_contents('../css/estilo_pdf.css');
$mpdf->WriteHTML($stylesheet,1);

$mpdf -> WriteHTML('<body>');
$mpdf->WriteHTML($caratula);

//echo $caratula;
$mpdf->AddPage();
$cabecera=get_encabezado_pdf();
$mpdf->SetHTMLHeader($cabecera,'','E');

$pie=get_pie_pdf();
$mpdf->SetHTMLFooter($pie);

//echo $cuerpo;
$mpdf->WriteHTML($cuerpo);
$mpdf -> WriteHTML('</body>');
$mpdf -> Output('catalogo_distribuidora.pdf', 'I');

//funciones de PDF
function get_encabezado_pdf()
{
  $cuerpo=' 
            <table width="100%">
            <tr>
                <td width="30%" align="center">
                <img src="../img/logo_mm.png" width="100px"><br>
            </td> 
            <td width="60%"´align="center">Catálogo de Productos</td>';
            $cuerpo .= ' 
            </td>
            <td width="10%" align="center"></td>
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