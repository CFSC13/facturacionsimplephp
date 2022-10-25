<?php
@session_start();

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

include ("../conexion.php");
conectar();

if($_GET['id_cliente']!="" && intval($_GET['id_cliente'])!=""){
	$q=mysqli_query($con,"select p.*, f.nombre as forma_pago from presupuestos p, formas_pagos f where p.id_cliente=".intval($_GET['id_cliente'])." and p.id_forma_pago=f.id and p.eliminado='no' order by p.id desc" );
	$tr="";
	while($r=mysqli_fetch_array($q)){
		$tr.='<tr><td>'.$r['id'].'</td><td>'.date('d-m-Y',strtotime($r['fecha'])).'</td><td>'.$r['forma_pago'].'</td><td>'.date('d-m-Y',strtotime($r['fecha_vencimiento'])).'</td><td>$'.number_format(($r['total']-(($r['descuento']*$r['total'])/100)),2,',','.').'</td><td><a href="modulos/presupuesto_pdf.php?id='.$r['id'].'" class="btn btn-primary" target="_blank" title="Ver PDF" alt="Ver PDF"><i class="fas fa-file-pdf"></i> Ver PDF</a></td></tr>';
	}
	echo $tr;
}