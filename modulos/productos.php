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
    
    if(($_POST['nombre']!=""))
    {
                   
        $sql=mysqli_query($con,"insert into productos (nombre, id_marca, precio, descripcion, id_categoria, codigo, orden) values(lower('$_POST[nombre]'), $_POST[marcas], lower('$_POST[precio]'),'$_POST[descripcion]',$_POST[categorias],'$_POST[codigo]', $_POST[orden])");
        
        if(!mysqli_error())
        {
            echo "<script>alert('Registro Insertado Correctamente.');</script>";
            echo "<script>window.location='home.php?pagina=productos';</script>";
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

    if(($_POST['nombre']!=""))
    {
        //controlo si cambia el precio, para agregar al historial
        if($_POST['precio']!=$_POST['precio_actual'])
            $sql=mysqli_query($con,"insert into productos_historial_precio (id_producto, precio) values($_POST[id], '$_POST[precio_actual]')");
        //fin de controlar si cambia el precio, para agregar al historial              
            $sql=mysqli_query($con,"update productos set nombre=lower('$_POST[nombre]'), id_marca=$_POST[marcas], precio='$_POST[precio]', descripcion='$_POST[descripcion]', id_categoria=$_POST[categorias], codigo='$_POST[codigo]', orden=$_POST[orden] where id=$_POST[id]");

            if(!mysqli_error())
            {
               
                echo "<script>alert('Registro Modificado Correctamente.');</script>";
                echo "<script>window.location='home.php?pagina=productos';</script>";
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

if($_GET[desactivar]!="")
{

        $sql=mysqli_query($con,"update productos set activo='no' where id=$_GET[desactivar]");
        
        if(!mysqli_error())
        {
            echo "<script>alert('Registro desactivado correctamente.');</script>";
            echo "<script>window.location='home.php?pagina=productos';</script>";
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
                            <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">Nuevo producto</h6>
                            </div>
               
               <?php
                        $showform="";
                        $showtable="";
                        if($_GET[ver]!=0)
                        {
                            $sql=mysqli_query($con,"select *from productos where id=$_GET[ver]");
                                if(mysqli_num_rows($sql)!=0)
                                {   
                                    $r=mysqli_fetch_array($sql);
                                }
                                $url="home.php?pagina=productos&mod=ok";
                                $showform="show";
                        }
                            else
                            {
                                $url="home.php?pagina=productos&add=ok";
                                $showtable="show";
                            }
                    ?>
                        <div id="collapseNuevo" class="collapse <?php echo $showform; ?> m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                            <div class="card-body" >
               
                                <form action="<?php echo $url; ?>" method="POST">
                                <!--Fila 1-->
                                <div class="form-group">
                                    <label for="nombre">Código</label>
                                    <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $r['codigo']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $r['nombre']; ?>" required>
                                </div>
                               
                               
                               
                                <div class="form-group">
                                    <label for="nombre">Categoria</label>
                                    <select name="categorias" id="categorias" class="form-control bg-light border-0 small" placeholder="Categoria"  aria-label="Categoria
                                    " aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g=mysqli_query($con,"select *from categorias order by nombre");
                                        if(mysqli_num_rows($sql_g)!=0)
                                        {
                                            while($r_g=mysqli_fetch_array($sql_g))
                                            {
                                                ?>
                                                <option value="<?php echo $r_g['id'];?>" <?php if($r_g['id']==$r['id_categoria']){?> selected <?php }?>><?php echo $r_g['nombre'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nombre">Marca</label>
                                    <select name="marcas" id="marcas" class="form-control bg-light border-0 small" placeholder="Marca"  aria-label="Marca
                                    " aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g=mysqli_query($con,"select *from marcas order by nombre");
                                        if(mysqli_num_rows($sql_g)!=0)
                                        {
                                            while($r_g=mysqli_fetch_array($sql_g))
                                            {
                                                ?>
                                                <option value="<?php echo $r_g['id'];?>" <?php if($r_g['id']==$r['id_marca']){?> selected <?php }?>><?php echo $r_g['nombre'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label for="nombre">Precio</label>
                                    <input type="text" class="form-control" id="precio" name="precio" value="<?php echo $r['precio'];?>" required>
                                    <input type="hidden" id="precio_actual" name="precio_actual" value="<?php echo $r['precio'];?>">
                                </div>

                                <div class="form-group">
                                    <label for="nombre">Orden</label>
                                    <input type="text" class="form-control" id="orden" name="orden" value="<?php echo $r['orden'];?>" required>
                                    
                                </div>
                                
                               
                                <div class="form-group">
                                    <label for="nombre">Descripción</label>
                                    <textarea  class="form-control" type="text" name="descripcion" placeholder="Descripción"  id="descripcion" rows="5"><?php if(!empty($r['descripcion'])) echo $r['descripcion'];?></textarea>
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
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Productos activos</h6>
                        </div>
                        <div id="collapseListado" class="collapse <?php echo $showtable; ?>" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                    <table class="table table-striped table-bordered display nowrap" id="dataTable-mensajes" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Cod.</th>
                                        <th>Nombre</th>
                                        
                                        <th>Precio</th>
                                        <th>Categoria</th>
                                        <th>Marca</th>
                                        <th>Orden</th>
                                        
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Cod.</th>
                                        <th>Nombre</th>
                                        
                                        <th>Precio</th>
                                        <th>Categoria</th>
                                        
                                        <th>Marca</th>
                                        <th>Orden</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $q=mysqli_query($con,"select p.*, m.nombre as marca, c.nombre as categoria from productos p, marcas m, categorias c where p.id_marca=m.id and p.activo='si' and p.id_categoria=c.id order by p.orden"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                 <tr>
                                                    <td><?php echo $r['codigo']; ?></td>
                                                    <td><?php echo $r['nombre']; ?></td>
                                                    <td>$<?php echo number_format($r['precio'],2,',','.'); ?></td>
                                                    <td><?php echo $r['categoria']; ?></td>
                                                    <td><?php echo $r['marca']; ?></td>
                                                    <td><?php echo $r['orden']; ?></td>
                                                    
                                                    <td>
                                                        <a href="home.php?pagina=productos&ver=<?php echo $r['id'] ?>" title="Editar" alt="Editar"><i class="fas fa-edit icono_editar"></i></a> 
                                                        
                                                        <a href="javascript:if(confirm('Esta Seguro?')){ window.location='home.php?pagina=productos&desactivar=<?php echo $r['id'] ?>'; }" title="Desactivar" alt="Desactivar"><i class="fas fa-eraser icono_borrar"></i></a>
                                                        
                                                        <a href="#" title="Gestón de Fotos" alt="Gestón de Fotos" onclick="a=window.open('modulos/fotos_productos.php?id=<?php echo $r['id']; ?>','Permisos','width=1024,height=500,scrollbars=1'); a.moveTo(250,150)"><i class="fas fa-image icono_fotos"></i></a>

                                                        <a href="#" title="Gráfico Histórico" alt="Gráfico Histórico" onclick="a=window.open('modulos/grafico_precios_productos.php?id=<?php echo $r['id']; ?>','Historial de Precios','width=1024,height=500,scrollbars=1'); a.moveTo(250,150)"><i class='fas fa-layer-group'></i></a>

                                                        <!--<a href="#" onclick="a=window.open('https://www.facebook.com/sharer/sharer.php?u=http://marcelomarini.com.ar/modulos/ficha_fb.php?id=<?php echo $r['id']; ?>','Compartir','width=1024,height=500,scrollbars=1'); a.moveTo(250,150)"><i class="fab fa-facebook"></i></a>-->

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
<script src="vendor/ckeditor/ckeditor.js"></script> 
<script type="text/javascript">
 //inicio editor
    CKEDITOR.replace('descripcion',
      {
        height  : '500px',
        width   : '100%',

        toolbar : [
        { name: 'document', items : [ 'Undo','Redo','-','NewPage','DocProps','Preview','Print'] },
        { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-' ] },
        { name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },'/',
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','-','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
        '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
        { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
        { name: 'insert', items : [ 'Image','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
        '/',
        { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
        { name: 'colors', items : [ 'TextColor','BGColor' ] },
        { name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','Source'] },

        ],
        filebrowserUploadUrl: "upload.php",
        allowedContent: true
      });
    //fin editor
</script>

<script>
$(document).ready( function () {
    //inicio datatable
    $('#dataTable-mensajes').DataTable({
        sort: true, 
        order : [[0,"desc"]],
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

    //inicializar datatable
    $('#dataTable-mensajes').DataTable();
} );    


</script>
