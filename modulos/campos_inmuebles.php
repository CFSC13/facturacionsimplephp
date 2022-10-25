 <?php
session_start();

if($_SESSION[user]==0)
{
    echo "<script>window.location='index.php';</script>";
}
?>
<?php

if($_GET['add']=="ok")
{
    
    if(($_POST['nombre_campo']!=""))
    {
                    
            $sql=mysqli_query($con,"insert into campos_inmuebles (nombre_campo, nombre_input, id_tipo_inmueble, tipo_dato, nombre_mostrar, unidad, linea) values('$_POST[nombre_campo]', '$_POST[nombre_input]', $_POST[tipo_inmueble], $_POST[tipo_dato], '$_POST[nombre_mostrar]' ,'$_POST[unidad]', $_POST[linea])");
            
            if(!mysqli_error())
            {
                
                echo "<script>alert('Registro Insertado Correctamente.');</script>";
                echo "<script>window.location='home.php?pagina=campos_inmuebles';</script>";
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

if($_GET['mod']=="ok")
{

    if(($_POST['nombre_campo']!=""))
    {
                    
            $sql=mysqli_query($con,"update campos_inmuebles set nombre_campo='$_POST[nombre_campo]', nombre_input='$_POST[nombre_input]', id_tipo_inmueble=$_POST[tipo_inmueble], tipo_dato=$_POST[tipo_dato], nombre_mostrar='$_POST[nombre_mostrar]', unidad='$_POST[unidad]', linea=$_POST[linea] where id=$_POST[id]");

            if(!mysqli_error())
            {
               
                echo "<script>alert('Registro Modificado Correctamente.');</script>";
                echo "<script>window.location='home.php?pagina=campos_inmuebles';</script>";
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

        $sql=mysqli_query($con,"delete from campos_inmuebles where id=$_GET[del]");
        
        if(!mysqli_error())
        {
            echo "<script>alert('Registro Eliminado Correctamente.');</script>";
            echo "<script>window.location='home.php?pagina=campos_inmuebles';</script>";
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
                            <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">Nuevo campo de inmueble</h6>
                            </div>
               
               <?php
                        $showform="";
                        $showtable="";
                        if($_GET[ver]!=0)
                        {
                            $sql=mysqli_query($con,"select *from campos_inmuebles where id=$_GET[ver]");
                                if(mysqli_num_rows($sql)!=0)
                                {   
                                    $r=mysqli_fetch_array($sql);
                                }
                                $url="home.php?pagina=campos_inmuebles&mod=ok";
                                $showform="show";
                        }
                            else
                            {
                                $url="home.php?pagina=campos_inmuebles&add=ok";
                                $showtable="show";
                            }
                    ?>
                        <div id="collapseNuevo" class="collapse <?php echo $showform; ?> m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                            <div class="card-body" >
               
                                <form action="<?php echo $url; ?>" method="POST">
                                <!--Fila 1-->
                                <div class="form-group">
                                    <label for="nombre">Tipo de inmueble:</label>
                                    <select name="tipo_inmueble" id="tipo_inmueble" class="form-control bg-light border-0 small" placeholder="Tipo de Inmueble"  aria-label="Tipo de Inmueble" aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g=mysqli_query($con,"select *from tipos_inmuebles order by nombre");
                                        if(mysqli_num_rows($sql_g)!=0)
                                        {
                                            while($r_g=mysqli_fetch_array($sql_g))
                                            {
                                                ?>
                                                <option value="<?php echo $r_g['id'];?>" <?php if($r_g['id']==$r['id_tipo_inmueble']){?> selected <?php }?>><?php echo $r_g['nombre'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Tipo de dato:</label>
                                    <select name="tipo_dato" id="tipo_dato" class="form-control bg-light border-0 small" placeholder="Tipo de Dato"  aria-label="Tipo de Dato" aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                                        <option value="">Seleccione...</option>
                                        <option value="0" <?php if($r['tipo_dato']==0){?> selected <?php }?>>Número</option>
                                        <option value="1" <?php if($r['tipo_dato']==1){?> selected <?php }?>>Texto</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre del campo:</label>
                                    <input type="text" class="form-control" id="nombre_campo" name="nombre_campo" value="<?php echo $r['nombre_campo']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre del input:</label>
                                    <input type="text" class="form-control" id="nombre_input" name="nombre_input" value="<?php echo $r['nombre_input']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre para mostrar:</label>
                                    <input type="text" class="form-control" id="nombre_mostrar" name="nombre_mostrar" value="<?php echo $r['nombre_mostrar']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Unidad:</label>
                                    <input type="text" class="form-control" id="unidad" name="unidad" value="<?php echo $r['unidad']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Línea:</label>
                                    <input type="text" class="form-control" id="linea" name="linea" value="<?php echo $r['linea']; ?>" required>
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
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Campos de inmuebles</h6>
                        </div>
                        <div id="collapseListado" class="collapse <?php echo $showtable; ?>" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                    <table class="table table-bordered display nowrap" id="dataTable-mensajes" width="100%" cellspacing="0">
                                    <thead>
                                    
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Nombre campo</th>
                                        <th>Nombre input</th>
                                        <th>Nombre mostrar</th>
                                        <th>Unidad</th>
                                        <th>Línea</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Nombre campo</th>
                                        <th>Nombre input</th>
                                        <th>Nombre mostrar</th>
                                        <th>Unidad</th>
                                        <th>Línea</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $q=mysqli_query($con,"select ci.*, ti.nombre as tipo from campos_inmuebles ci, tipos_inmuebles ti where ci.id_tipo_inmueble=ti.id order by ci.id_tipo_inmueble, ci.linea, ci.nombre_campo"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                 <tr>
                                                     <td><?php echo $r['tipo']; ?></td>
                                                     <td><?php echo $r['nombre_campo']; ?></td>
                                                     <td><?php echo $r['nombre_input']; ?></td>
                                                     <td><?php echo $r['nombre_mostrar']; ?></td>
                                                     <td><?php echo $r['unidad']; ?></td>
                                                     <td><?php echo $r['linea']; ?></td>
                                                     <td>
                                                        <a href="home.php?pagina=campos_inmuebles&ver=<?php echo $r['id'] ?>" title="Editar" alt="Editar"><i class="fas fa-edit icono_editar"></i></a> 
                                                        <a href="javascript:if(confirm('Esta Seguro?')){ window.location='home.php?pagina=campos_inmuebles&del=<?php echo $r['id'] ?>'; }" title="Eliminar" alt="Eliminar"><i class="fas fa-eraser icono_borrar"></i></a></td>
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

