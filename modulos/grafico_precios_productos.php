<?php
include ("../incluir.php");
error_reporting(E_ALL);
ini_set('display_errors', '0');
if($_SESSION[user]==0)
{
    echo "<script>window.location='index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Distribuidora Lucas - Sistema de Gestión</title>

    <!-- Custom fonts for this template-->
    
    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" rel="stylesheet">
    <script src="../uploadify-master/Sample/jquery.min.js" type="text/javascript"></script>
    <script src="../uploadify-master/Sample/jquery.uploadifive.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="../uploadify-master/Sample/uploadifive.css">

    <style type="text/css">

.uploadifive-button {
    float: left;
    margin-right: 10px;
}
#queue {
    border: 1px solid #E5E5E5;
    height: 177px;
    overflow: auto;
    margin-bottom: 10px;
    padding: 0 3px 3px;
    width: 300px;
}
</style>
</head>

<body id="page-top">

     <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                   <div class="container-fluid">

  <div class="tab-content" id="nav-tabContent">     

    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <!-- Area Chart -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">  
            <?php $r=mysqli_fetch_array(mysqli_query($con,"select * from cliente where id_cliente=".$_GET['id'])); ?>          
                Historial de Facturación del Cliente: <?php echo $r['nombre']; ?>
            </h6>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
            <hr>
            En la sección de abajo se muestra una tabla con los detalles.
        </div>
    </div>
    <!-- FIN Area Chart -->
        <div id="accordion">
            <!-- Page Heading -->
            <div class="card shadow mb-4" id="headingOne">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">Detalle</h6>
                </div>
                <?php
                $showform="";
                $showtable="";
                ?>
                <div id="collapseNuevo" class="collapse show m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                    <div class="card-body" >

                    </div>
                </div>
            

                <!-- Page Heading -->
                <div class="">
                    <div id="collapseListado" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body" >
                            <div class="table-responsive">
                                    <input type="hidden" name="id" id="id" value="<?php echo $_GET['id'];?>" />   
                                    <table class="table table-bordered display nowrap" id="dataTable-items" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Importe Total</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Importe Total</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php $q=mysqli_query($con,"select * from factura where id_cliente=".$_GET['id']." order by id_factura desc"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                    <tr>
                                                        <td>   
                                                            <?php echo date('d-m-Y',strtotime($r['fecha_de_emision']));?>
                                                        </td>
                                                        <td>
                                                            $<?php echo number_format($r['importe_total'],0,',','.');?>
                                                        </td>
                                                    </tr>       
                                                    <?php }
                                                    ?>
                                                    <?php
                                                }?>       
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    $(document).ready( function () {} );    
</script>
<!-- Page level plugins -->
<script src="../vendor/chart.js/Chart.min.js"></script>
<?php include('../js/demo/chart-area-demo.php')?>