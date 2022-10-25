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
                   copy($_FILES['logo']['tmp_name'], "marcas/".$qu.".".end($extension));
                }
            }
            $archivo=$qu.".".end($extension);
        }
        //fin de logo

            $sql=mysqli_query($con,"insert into marcas (nombre, id_proveedor, logo) values(lower('$_POST[nombre]'), $_POST[proveedor], '$archivo')");
            
            if(!mysqli_error())
            {
                
                echo "<script>alert('Registro Insertado Correctamente.');</script>";
                echo "<script>window.location='home.php?pagina=marcas';</script>";
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
                   copy($_FILES['logo']['tmp_name'], "marcas/".$qu.".".end($extension));
                }
            }
            $archivo=", logo='".$qu.".".end($extension)."'";
        }
            else
            {
                $archivo="";
            }
        //fin de logo
                    
            $sql=mysqli_query($con,"update marcas set nombre=lower('$_POST[nombre]'), id_proveedor=$_POST[proveedor] $archivo where id=$_POST[id]");

            if(!mysqli_error())
            {
               
                echo "<script>alert('Registro Modificado Correctamente.');</script>";
                echo "<script>window.location='home.php?pagina=marcas';</script>";
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

        $sql=mysqli_query($con,"update marcas set activo='no' where id=$_GET[del]");
        
        if(!mysqli_error())
        {
            echo "<script>alert('Registro Eliminado Correctamente.');</script>";
            echo "<script>window.location='home.php?pagina=marcas';</script>";
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
                            <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">Nueva marca</h6>
                            </div>
               
               <?php
                        $showform="";
                        $showtable="";
                        if($_GET[ver]!=0)
                        {
                            $sql=mysqli_query($con,"select *from marcas where id=$_GET[ver]");
                                if(mysqli_num_rows($sql)!=0)
                                {   
                                    $r=mysqli_fetch_array($sql);
                                }
                                $url="home.php?pagina=marcas&mod=ok";
                                $showform="show";
                        }
                            else
                            {
                                $url="home.php?pagina=marcas&add=ok";
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
                                <div class="form-group">
                                    <label for="nombre">Proveedor</label>
                                    <select name="proveedor" id="proveedor" class="form-control bg-light border-0 small" placeholder="Proveedor"  aria-label="Proveedor
                                    " aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g=mysqli_query($con,"select *from proveedores where activo='si' order by nombre");
                                        if(mysqli_num_rows($sql_g)!=0)
                                        {
                                            while($r_g=mysqli_fetch_array($sql_g))
                                            {
                                                ?>
                                                <option value="<?php echo $r_g['id'];?>" <?php if($r_g['id']==$r['id_proveedor']){?> selected <?php }?>><?php echo $r_g['nombre'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
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
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Marcas</h6>
                        </div>
                        <div id="collapseListado" class="collapse <?php echo $showtable; ?>" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                    <table class="table table-bordered display nowrap" id="dataTable-mensajes" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Proveedor</th>
                                        <th>Logo</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Proveedor</th>
                                        <th>Logo</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $q=mysqli_query($con,"select m.id, m.nombre, m.logo, p.nombre as nombre_proveedor from marcas m, proveedores p where p.id=m.id_proveedor and m.activo='si' order by p.nombre, m.nombre"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                 <tr>
                                                     <td><?php echo $r['nombre']; ?></td>
                                                     <td><?php echo $r['nombre_proveedor']; ?></td>
                                                     <td style="text-align: center;">
                                                        <?php
                                                        if(!empty($r['logo']))
                                                            {
                                                                ?>
                                                                <img src="marcas/<?php echo $r['logo'];?>" width="100" />
                                                                <?php
                                                            } 
                                                        ?>  
                                                    </td>
                                                     <td><a href="home.php?pagina=marcas&ver=<?php echo $r['id'] ?>" title="Editar" alt="Editar"><i class="fas fa-edit icono_editar"></i></a> 
                                                        <a href="javascript:if(confirm('Esta Seguro?')){ window.location='home.php?pagina=marcas&del=<?php echo $r['id'] ?>'; }" title="Eliminar" alt="Eliminar"><i class="fas fa-eraser icono_borrar"></i></a></td>
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

