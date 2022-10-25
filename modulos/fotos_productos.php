<?php
include ("../incluir.php");


if($_SESSION[user]==0)
{
    echo "<script>window.location='index.php';</script>";
}
?>
<?php


if($_GET[del_f]!="")
{
$q=mysqli_query($con,"delete from fotos_productos where id=".$_GET[id2]);
            if(!mysqli_error())
            {
            echo "<script>alert('Eliminado Correctamente.');</script>";

            }
            else
            {
                echo "<script>alert('Error: No se pudo eliminar el registro.');</script>";
            }
}

if($_GET[orden]=="ok")
{
$qq=mysqli_query($con,"select * from fotos_productos where id_producto=".$_POST[id]." order by orden");
    if(mysqli_num_rows($qq)!=0)
    {
        while($rs=mysqli_fetch_array($qq))
        {
            $valor="orden_".$rs[id];
            $q=mysqli_query($con,"update fotos_productos set orden=".$_POST[$valor]." where id=".$rs[id]);

        }
        
    }

echo "<script>alert('Actualizado Correctamente.');</script>";
echo "<script>window.location='fotos_productos.php?id=$_POST[id]';</script>";
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
               <div id="accordion">
                     <!-- Page Heading -->
                        <div class="card shadow mb-4" id="headingOne">
                            <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">Subir Fotos del producto: <?php echo datos_complejos1($con, "productos","nombre","id",$_GET['id']); ?></h6>
                            </div>
               
               <?php
                        $showform="";
                        $showtable="";
                       
                    ?>
                        <div id="collapseNuevo" class="collapse show m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                            <div class="card-body" >
               
                                <form action="fotos_productos.php?id=<?php echo $_GET[id]?>&add=ok" method="POST">
                              
                                            <div class="form-group col-md-6">
                                                <label for="roles">Fotos</label>
                                             <div id="queue"></div>
        <input id="file_upload" name="file_upload" type="file" multiple="true"  accept="image/png, image/jpeg">

    <script type="text/javascript">
        <?php $timestamp = time();?>
        $(function() {
            $('#file_upload').uploadifive({
                'auto'             : true,
                'formData'         : {
                                       'timestamp' : '<?php echo $timestamp;?>',
                                       'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
                                     },
                'queueID'          : 'queue',
                'uploadScript'     : '../uploadify-master/uploadifive.php?id=<?php echo $_GET[id]; ?>',
                'onQueueComplete' : function(file, data) { window.location='./fotos_productos.php?id=<?php echo $_GET[id];?>'}
            });
        });
    </script>
                                            </div>

                                <input type="hidden" id="inmo" name="inmo" value="<?php echo $_GET[id];?>" /> 
                              
                                </form>
                            </div>
                        </div>
                    </div>
            

           
            
                     <!-- Page Heading -->
                    <div class="card shadow mb-4 mx-auto" >
                        <div class="card-header py-3" id="headingTwo">
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Fotos</h6>
                        </div>
                        <div id="collapseListado" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                    <form method="post" action="fotos_productos.php?orden=ok&id=<?php echo $_GET[id];?>" id="formu" name="formu" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="<?php echo $_GET[id];?>" />   
                                    <table class="table table-bordered display nowrap" id="dataTable-items" width="100%" cellspacing="0">
                                    <thead>
                                    
                                    <tr>
                                        <th>Foto</th>
                                        <th>Orden</th>
                                      
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Orden</th>
                                      
                                        <th>Opciones</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $q=mysqli_query($con,"select * from fotos_productos where id_producto=".$_GET[id]." order by orden"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                 <tr>
                                                     <td>   
                                                        <div style="width:200px; height:200px; background: url(../fotos/<?php echo $r[url]; ?>); background-size: 100%; background-position: center; background-repeat: no-repeat;"></div>
                                                    </td>
                                                     <td>
                                                         <input type="text" name="orden_<?php echo $r[id];?>" style="width:25px !important;"  value="<?php echo $r['orden']?>"/>
                                                     </td>
                                                     <td>
                                                        <a href="javascript:if(confirm('Esta Seguro?')){ window.location='fotos_productos.php?del_f=ok&id=<?php echo $_GET[id]?>&id2=<?php echo $r[id];?>'; }" title="Eliminar" alt="Eliminar"><i class="fas fa-eraser"></i></a></td>
                                                 </tr>       
                                             <?php }
                                             ?>
                                             <tr>
                                                <td></td>
                                             <td><input type="submit" value="Guardar Posiciones" /></td>
                                             <td></td>
                                            </tr>
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
$(document).ready( function () {
  
} );    
</script>

