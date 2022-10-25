<?php
include ("../incluir.php");


if($_SESSION[user]==0)
{
    echo "<script>window.location='index.php';</script>";
}
?>
<?php

if($_GET[id]!="")
    {
        if($_GET[add]=="ok")
        {
            if($_POST[item]!="")
            {
                $sql=mysqli_query($con,"insert into items_x_usuario (id_item,id_usuario) values($_POST[item],$_GET[id])");
                
            }
            echo "<script>window.location='items_x_usuarios.php?id=".$_GET[id]."'</script>";
        }
        
        if($_GET[del]=="ok")
        {
            $sql=mysqli_query($con,"delete from items_x_usuario where id_item=$_GET[item] and id_usuario=$_GET[id]");
        
            echo "<script>window.location='items_x_usuarios.php?id=".$_GET[id]."'</script>";
        }
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
                            <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">Nuevo Registro Usuario: <?php echo datos_complejos1($con, "usuarios","nombre","id_usuario",$_GET['id']); ?></h6>
                            </div>
               
               <?php
                        $showform="";
                        $showtable="";
                       
                    ?>
                        <div id="collapseNuevo" class="collapse <?php echo $showform; ?> m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                            <div class="card-body" >
               
                                <form action="items_x_usuarios.php?id=<?php echo $_GET[id]?>&add=ok" method="POST">
                              
                                            <div class="form-group col-md-6">
                                                <label for="roles">Item</label>
                                                <select id="item" class="form-control" name="item" required>
                                                    <option value="">Seleccione...</option>
                                                    <?php
                                                    $sql_in=mysqli_query($con,"SELECT * FROM items_interno ii, grupos_menu gm WHERE gm.id_grupo=ii.id_grupo and ii.id_item NOT IN (SELECT i.id_item FROM items_interno i, items_x_usuario iu, usuarios u WHERE iu.id_item=i.id_item AND iu.id_usuario=u.id_usuario AND u.id_usuario=".$_GET[id].") ORDER BY nombre_item");
                                                    if(mysqli_num_rows($sql_in)>0)
                                                    {
                                                        while($r_in=mysqli_fetch_array($sql_in))
                                                        {
                                                            ?>
                                                            <option value="<?php echo $r_in['id_item']?>"><?php echo $r_in['nombre_item']."(".$r_in['nombre_grupo'].")";?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                <input type="hidden" id="inmo" name="inmo" value="<?php echo $_GET[inmo];?>" /> 
                                <button type="submit" class="btn btn-primary" style="float:right;">Guardar</button>
                                </form>
                            </div>
                        </div>
                    </div>
            

           
            
                     <!-- Page Heading -->
                    <div class="card shadow mb-4 mx-auto" >
                        <div class="card-header py-3" id="headingTwo">
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Permisos</h6>
                        </div>
                        <div id="collapseListado" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                    <table class="table table-bordered display nowrap" id="dataTable-items" width="100%" cellspacing="0">
                                    <thead>
                                    
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Grupo</th>
                                      
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Grupo</th>
                                      
                                        <th>Opciones</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $q=mysqli_query($con,"select i.* from items_interno i, items_x_usuario iu, usuarios u where iu.id_item=i.id_item and iu.id_usuario=u.id_usuario and u.id_usuario=".$_GET[id]); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                 <tr>
                                                     <td><?php echo $r['nombre_item']; ?></td>
                                                     <td><?php echo datos_complejos1($con, "grupos_menu","nombre_grupo","id_grupo",$r['id_grupo']); ?></td>
                                                     <td>
                                                        <a href="javascript:if(confirm('Esta Seguro?')){ window.location='items_x_usuarios.php?del=ok&id=<?php echo $_GET[id]?>&item=<?php echo $r[id_item];?>'; }" title="Eliminar" alt="Eliminar"><i class="fas fa-eraser"></i></a></td>
                                                 </tr>       
                                             <?php }
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


  <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    

        <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

<link href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>

    

</body>

</html>
    
<script>
$(document).ready( function () {
    $('#dataTable-items').DataTable({
        responsive: true,
        language: {
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sProcessing":     "Procesando...",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
        "sInfo":           "Mostrando del _START_ al _END_ - total: _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando del 0 al 0 - total: de 0 registros",
        "sInfoFiltered":   "(filtrado de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
        }
      }
    });


    $('#dataTable-items').DataTable();
} );    
</script>

