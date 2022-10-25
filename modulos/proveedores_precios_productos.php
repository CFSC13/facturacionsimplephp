<?php
include ("../incluir.php");
if($_SESSION[user]==0)
{
    echo "<script>window.location='index.php';</script>";
}

//modifico los precios
if(!empty($_GET['id']) && !empty($_GET['modificar_precios']))
{
    $porcentaje=$_POST['porcentaje'];
    $q=mysqli_query($con,"select p.id, p.nombre, p.precio from productos p, marcas m where p.id_marca=m.id and m.id_proveedor=".$_GET[id]);
    if(mysqli_num_rows($q)!=0)
    {
        while($r=mysqli_fetch_array($q))
        {
            $precio_actual=$r['precio'];
            $incremento=($porcentaje*$precio_actual)/100;
            //guardo el historial
            $sumar=mysqli_query($con,"insert into productos_historial_precio (id_producto, precio) values($r[id], '$precio_actual')");
            $modifico=mysqli_query($con,"update productos set precio=precio+$incremento where id=$r[id]");
        }
    }
    //msj general
    echo "<script>alert('Precios actualizados correctamente.');</script>";
    echo "<script>window.location='proveedores_precios_productos.php?id=$_GET[id]';</script>";
}
//fin de modificar los precios
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
                    <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">Productos de <?php echo datos_complejos1($con, "proveedores","nombre","id",$_GET['id']); ?></h6>
                </div>
                <?php
                $showform="";
                $showtable="";
                ?>
                <div id="collapseNuevo" class="collapse show m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                    <div class="card-body" >
                        <form action="proveedores_precios_productos.php?id=<?php echo $_GET['id']; ?>&modificar_precios=ok" method="POST" id="formulario_precios">
                            <!--Fila 1-->
                            <div class="form-group">
                                <label for="nombre">% de aumento</label>
                                <input type="number" class="form-control" id="porcentaje" name="porcentaje" required>
                            </div>
                            <input type="hidden" name="id" id="id" value="<?php echo $r['id']; ?>">    
                            <input type="button" class="btn btn-primary" id="guardar_precios" value="Actualizar precios">
                        </form>
                    </div>
                </div>
            

                <!-- Page Heading -->
                <div class="">
                    <div id="collapseListado" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body" >
                            <div class="table-responsive">
                                    <input type="hidden" name="id" id="id" value="<?php echo $_GET[id];?>" />   
                                    <table class="table table-bordered display nowrap" id="dataTable-items" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Marca</th>
                                                <th>Producto</th>
                                                <th>Precio</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Marca</th>
                                                <th>Producto</th>
                                                <th>Precio</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php $q=mysqli_query($con,"select m.nombre as marca, p.nombre as producto, p.precio from productos p, marcas m where p.id_marca=m.id and m.id_proveedor=".$_GET[id]." order by m.nombre, p.nombre"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                    <tr>
                                                        <td>   
                                                            <?php echo $r['marca'];?>
                                                        </td>
                                                        <td>   
                                                            <?php echo $r['producto'];?>
                                                        </td>
                                                        <td>
                                                            $<?php echo number_format($r['precio'],0,',','.');?>
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

    $(function() {
       $("#guardar_precios").click(function(){
        //controlo el monto
        if($("#porcentaje").val()==""){
            alert("El campo <b>PORCENTAJE</b>,no puede estar vacío.");
            $("#porcentaje").focus();
            return false;
          }
            else
            {
                if(confirm("¿Está a punto de actualizar el precio de TODOS los productos de éste proveedor, esta seguro de continuar?"))
                {
                    $('form#formulario_precios').submit();
                }
            }
       });
    });   
</script>
