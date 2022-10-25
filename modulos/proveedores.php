<?php
session_start();

if($_SESSION[user]==0)
{
    echo "<script>window.location='index.php';</script>";
}
?>
<?php

if($_GET[add]=="ok")
{
    
    if(($_POST[nombre]!=""))
    {
                   
        //logo
        $archivo=$_FILES['logo']['name'];
        if($archivo!="")
        {
            $extension = explode(".",$archivo);
            if((end($extension)=="jpg") || (end($extension)=="jpeg") || (end($extension)=="JPG") || (end($extension)=="JPEG") || (end($extension)=="png"))
            {
                if (is_uploaded_file($_FILES['logo']['tmp_name'])) 
                {
                   $qu=time();
                   copy($_FILES['logo']['tmp_name'], "proveedores/".$qu.".".end($extension));
                }
            }
            $archivo=$qu.".".end($extension);
        }
        //fin de logo

            $sql=mysqli_query($con,"insert into proveedores (nombre, logo) values(lower('$_POST[nombre]'), '$archivo')");
            
            if(!mysqli_error())
            {
                
                echo "<script>alert('Registro Insertado Correctamente.');</script>";
                echo "<script>window.location='home.php?pagina=proveedores';</script>";
            }
                else
                {
                    echo "<script>alert('Error: No se pudo insertar el registro.');</script>";
                }
    }
        else
        {
            echo "<script>alert('Complete los Campos Obligatorios (*).');</script>";
        }
}

if($_GET[mod]=="ok")
{

    if(($_POST[nombre]!=""))
    {
        //logo
        $archivo=$_FILES['logo']['name'];
        if($archivo!="")
        {
            $extension = explode(".",$archivo);
            if((end($extension)=="jpg") || (end($extension)=="jpeg") || (end($extension)=="JPG") || (end($extension)=="JPEG") || (end($extension)=="png"))
            {
                if (is_uploaded_file($_FILES['logo']['tmp_name'])) 
                {
                   $qu=time();
                   copy($_FILES['logo']['tmp_name'], "proveedores/".$qu.".".end($extension));
                }
            }
            $archivo=", logo='".$qu.".".end($extension)."'";
        }
            else
            {
                $archivo="";
            }
        //fin de logo
            $sql=mysqli_query($con,"update proveedores set nombre=lower('$_POST[nombre]') $archivo where id=$_POST[id]");

            if(!mysqli_error())
            {
               
                echo "<script>alert('Registro Modificado Correctamente.');</script>";
                echo "<script>window.location='home.php?pagina=proveedores';</script>";
            }
                else
                {
                    echo "<script>alert('Error: No se pudo Modificar el registro.');</script>";
                }
        
    }
        else
        {
            echo "<script>alert('Complete los Campos Obligatorios (*).');</script>";
        }
}

if($_GET[del]!="")
{

        $sql=mysqli_query($con,"update proveedores set activo='no' where id=$_GET[del]");
        
        if(!mysqli_error())
        {
            echo "<script>alert('Registro Eliminado Correctamente.');</script>";
            echo "<script>window.location='home.php?pagina=proveedores';</script>";
        }
            else
            {
                echo "<script>alert('Error: No se pudo Eliminar el registro.');</script>";
            }

}

?>

  <div class="tab-content" id="nav-tabContent">
                           
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
               <div id="accordion">
                     <!-- Page Heading -->
                        <div class="card shadow mb-4" id="headingOne">
                            <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">Nuevo proveedor</h6>
                            </div>
               
               <?php
                        $showform="";
                        $showtable="";
                        if($_GET[ver]!=0)
                        {
                            $sql=mysqli_query($con,"select *from proveedores where id=$_GET[ver]");
                                if(mysqli_num_rows($sql)!=0)
                                {   
                                    $r=mysqli_fetch_array($sql);
                                }
                                $url="home.php?pagina=proveedores&mod=ok";
                                $showform="show";
                        }
                            else
                            {
                                $url="home.php?pagina=proveedores&add=ok";
                                $showtable="show";
                            }
                    ?>
                        <div id="collapseNuevo" class="collapse <?php echo $showform; ?> m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                            <div class="card-body" >
               
                                <form action="<?php echo $url; ?>" method="post" enctype="multipart/form-data">
                                <!--Fila 1-->
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $r['nombre']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" class="form-control" id="logo" name="logo">
                                </div>
                                <input type="hidden" name="id" id="id" value="<?php echo $r['id']; ?>">    
                                <button type="submit" class="btn btn-primary" style="float:right;">Guardar</button>
                                </form>

                            </div>
                        </div>
                    </div>           
            
                     <!-- Page Heading -->
                    <div class="card shadow mb-4 mx-auto" >
                        <div class="card-header py-3" id="headingTwo">
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Proveedores</h6>
                        </div>
                        <div id="collapseListado" class="collapse <?php echo $showtable; ?>" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                    <table class="table table-bordered display nowrap" id="dataTable-mensajes" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Logo</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Logo</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $q=mysqli_query($con,"select *from proveedores where activo='si' order by nombre"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                 <tr>
                                                     <td><?php echo $r['nombre']; ?></td>
                                                     <td style="text-align: center;">
                                                        <?php
                                                        if(!empty($r['logo']))
                                                            {
                                                                ?>
                                                                <img src="proveedores/<?php echo $r['logo'];?>" width="100" />
                                                                <?php
                                                            } 
                                                        ?>  
                                                    </td>
                                                     <td>
                                                        <a href="home.php?pagina=proveedores&ver=<?php echo $r['id'] ?>" title="Editar" alt="Editar"><i class="fas fa-edit icono_editar"></i></a> 
                                                        
                                                        <a href="javascript:if(confirm('Esta Seguro?')){ window.location='home.php?pagina=proveedores&del=<?php echo $r['id'] ?>'; }" title="Eliminar" alt="Eliminar"><i class="fas fa-eraser icono_borrar"></i></a>

                                                        <a href="#" title="Incremento de Precios" alt="Incremento de Precios" onclick="a=window.open('modulos/proveedores_precios_productos.php?id=<?php echo $r['id']; ?>','Incremento de Precios','width=1024,height=500,scrollbars=1'); a.moveTo(250,150)"><i class='fas fa-money-bill-alt'></i></a>
                                                    </td>
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




    
<script>
$(document).ready( function () {
    $('#dataTable-mensajes').DataTable({
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


    $('#dataTable-mensajes').DataTable();
} );    
</script>

