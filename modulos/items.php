 <?php
session_start();
//include("conexion.php");
//conectar(); 
//include ("funciones.php");

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
                    
            $sql=mysqli_query($con,"insert into items_interno (nombre_item, url, id_grupo) values(lower('$_POST[nombre]'), lower('$_POST[url]'), $_POST[grupo_menu])");
            
            if(!mysqli_error())
            {
                
                echo "<script>alert('Registro Insertado Correctamente.');</script>";
                echo "<script>window.location='home.php?pagina=items';</script>";
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
                    
            $sql=mysqli_query($con,"update items_interno set nombre_item=lower('$_POST[nombre]'), url=lower('$_POST[url]'), id_grupo=$_POST[grupo_menu] where id_item=$_POST[id]");

            if(!mysqli_error())
            {
               
                echo "<script>alert('Registro Modificado Correctamente.');</script>";
                echo "<script>window.location='home.php?pagina=items';</script>";
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

        $sql=mysqli_query($con,"delete from items_interno where id_item=$_GET[del]");
        
        if(!mysqli_error())
        {
            echo "<script>alert('Registro Eliminado Correctamente.');</script>";
            echo "<script>window.location='home.php?pagina=items';</script>";
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
                            <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">Nuevo item del menú</h6>
                            </div>
               
               <?php
                        $showform="";
                        $showtable="";
                        if($_GET[ver]!=0)
                        {
                            $sql=mysqli_query($con,"select *from items_interno where id_item=$_GET[ver]");
                                if(mysqli_num_rows($sql)!=0)
                                {   
                                    $r=mysqli_fetch_array($sql);
                                }
                                $url="home.php?pagina=items&mod=ok";
                                $showform="show";
                        }
                            else
                            {
                                $url="home.php?pagina=items&add=ok";
                                $showtable="show";
                            }
                    ?>
                        <div id="collapseNuevo" class="collapse <?php echo $showform; ?> m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                            <div class="card-body" >
               
                                <form action="<?php echo $url; ?>" method="POST">
                                <!--Fila 1-->
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $r['nombre_item']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">URL</label>
                                    <input type="text" class="form-control" id="url" name="url" value="<?php echo $r['url']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Grupo del menú</label>
                                    <select name="grupo_menu" id="grupo_menu" class="form-control bg-light border-0 small" placeholder="Grupo"  aria-label="Grupo" aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g=mysqli_query($con,"select *from grupos_menu order by nombre_grupo");
                                        if(mysqli_num_rows($sql_g)!=0)
                                        {
                                            while($r_g=mysqli_fetch_array($sql_g))
                                            {
                                                ?>
                                                <option value="<?php echo $r_g['id_grupo'];?>" <?php if($r_g['id_grupo']==$r['id_grupo']){?> selected <?php }?>><?php echo $r_g['nombre_grupo'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input type="hidden" name="id" id="id" value="<?php echo $r['id_item']; ?>">    
                                <button type="submit" class="btn btn-primary" style="float:right;">Guardar</button>
                                </form>
                            </div>
                        </div>
                    </div>
            

           
            
                     <!-- Page Heading -->
                    <div class="card shadow mb-4 mx-auto" >
                        <div class="card-header py-3" id="headingTwo">
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Items del menú</h6>
                        </div>
                        <div id="collapseListado" class="collapse <?php echo $showtable; ?>" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                    <table class="table table-bordered display nowrap" id="dataTable-mensajes" width="100%" cellspacing="0">
                                    <thead>
                                    
                                    <tr>
                                        <th>Nombre</th>
                                        <th>URL</th>
                                        <th>Grupo</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>URL</th>
                                        <th>Grupo</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $q=mysqli_query($con,"select * from items_interno order by id_grupo, nombre_item"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                 <tr>
                                                     <td><?php echo $r['nombre_item']; ?></td>
                                                     <td><?php echo $r['url']; ?></td>
                                                     <td><?php echo datos_complejos1($con, "grupos_menu","nombre_grupo","id_grupo",$r['id_grupo']); ?></td>
                                                     <td><a href="home.php?pagina=items&ver=<?php echo $r['id_item'] ?>" title="Editar" alt="Editar"><i class="fas fa-edit icono_editar"></i></a> 
                                                        <a href="javascript:if(confirm('Esta Seguro?')){ window.location='home.php?pagina=items&del=<?php echo $r['id_item'] ?>'; }" title="Eliminar" alt="Eliminar"><i class="fas fa-eraser icono_borrar"></i></a></td>
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

