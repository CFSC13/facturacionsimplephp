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
          echo $_POST[nombre] ;   
          echo $_POST[precio] ; 
          echo $_POST[descuento] ;        
          echo $_POST[stock] ;        
          echo $_POST[codigo_barra] ;        
          echo $_POST[id_categoria] ;        
       
            $sql=mysqli_query($con,"insert into producto (nombre, precio, descuento, stock, codigo_barra, id_categoria) values(lower('$_POST[nombre]'), '$_POST[precio]','$_POST[descuento]', '$_POST[stock]','$_POST[codigo_barra]', $_POST[id_categoria])");
            if(!mysqli_error($con))
            {
                
                echo "<script>alert('Registro Insertado Correctamente.');</script>";
                echo "<script>window.location='home.php?pagina=producto';</script>";
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
        echo $_POST[nombre] ;   
        echo $_POST[precio] ; 
        echo $_POST[descuento] ;        
        echo $_POST[stock] ;        
        echo $_POST[codigo_barra] ;        
        echo $_POST[id_categoria] ; 

            $sql=mysqli_query($con,"update producto set nombre=lower('$_POST[nombre]'), precio='$_POST[precio]',descuento=$_POST[descuento], stock=$_POST[stock],codigo_barra ='$_POST[codigo_barra]', id_categoria =$_POST[id_categoria] where id_producto=$_POST[id_producto]");

            if(!mysqli_error($con))
            {
               
                echo "<script>alert('Registro Modificado Correctamente.');</script>";
                echo "<script>window.location='home.php?pagina=producto';</script>";
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

        $sql=mysqli_query($con,"delete from producto where id_producto=$_GET[del]");
        
        if(!mysqli_error())
        {
            echo "<script>alert('Registro Eliminado Correctamente.');</script>";
            echo "<script>window.location='home.php?pagina=producto';</script>";
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
                            <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">Nuevo Producto</h6>
                            </div>
               
               <?php
                        $showform="";
                        $showtable="";
                        if($_GET[ver]!=0)
                        {
                            $sql=mysqli_query($con,"select *from producto where id_producto=$_GET[ver]");
                                if(mysqli_num_rows($sql)!=0)
                                {   
                                    $r=mysqli_fetch_array($sql);
                                }
                                $url="home.php?pagina=producto&mod=ok";
                                $showform="show";
                        }
                            else
                            {
                                $url="home.php?pagina=producto&add=ok";
                                $showtable="show";
                            }
                    ?>
                        <div id="collapseNuevo" class="collapse <?php echo $showform; ?> m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                            <div class="card-body" >
               
                                <form action="<?php echo $url; ?>" method="POST">
                                <!--Fila 1-->
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $r['nombre']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="nombre">Precio</label>
                                    <input type="number" class="form-control" id="precio" name="precio" value="<?php echo $r['precio']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Descuento</label>
                                    <input type="number" class="form-control" id="descuento" name="descuento" value="<?php echo $r['descuento']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="nombre">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $r['stock']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="nombre">codigo_barra</label>
                                    <input type="text" class="form-control" id="codigo_barra" name="codigo_barra" value="<?php echo $r['codigo_barra']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="nombre">Categoría</label>
                                    <select name="id_categoria" id="id_categoria" class="form-control bg-light border-0 small" placeholder="Grupo"  aria-label="Grupo" aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g=mysqli_query($con,"select * from categoria order by nombre");
                                        if(mysqli_num_rows($sql_g)!=0)
                                        {
                                            while($r_g=mysqli_fetch_array($sql_g))
                                            {
                                                ?>
                                                <option value="<?php echo $r_g['id_categoria'];?>" <?php if($r_g['id_categoria']==$r['id_categoria']){?> selected <?php }?>><?php echo $r_g['nombre'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input type="hidden" name="id_producto" id="id_producto" value="<?php echo $r['id_producto']; ?>">    
                                <button type="submit" class="btn btn-primary" style="float:right;">Guardar</button>
                                </form>
                            </div>
                        </div>
                    </div>
            

           
            
                     <!-- Page Heading -->
                    <div class="card shadow mb-4 mx-auto" >
                        <div class="card-header py-3" id="headingTwo">
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Productos</h6>
                        </div>
                        <div id="collapseListado" class="collapse <?php echo $showtable; ?>" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                    <table class="table table-bordered display nowrap" id="dataTable-mensajes" width="100%" cellspacing="0">
                                    <thead>
                                    
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Descuento</th>
                                        <th>Stock</th>
                                        <th>Código de barras</th>
                                        <th>Categoria</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Precio</th> 
                                        <th>Descuento</th>
                                        <th>Stock</th>
                                        <th>Código de barras</th> 
                                        <th>Categoria</th>                                
                                        <th>Opciones</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $q=mysqli_query($con,"SELECT id_producto, P.Nombre as 'NombreP', P.Precio as 'PrecioP', P.descuento as 'DescuentoP', P.stock as 'StockP', P.codigo_barra as 'codigo_barraP',
                                                                    C.Nombre as 'NonbreC' 
                                                                    FROM producto P 
                                                                    JOIN categoria C 
                                                                    ON P.id_categoria = C.id_categoria
                                                                    order by P.nombre;"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                 <tr>
                                                     <td><?php echo $r['NombreP']; ?></td>
                                                     <td><?php echo $r['PrecioP']; ?></td>
                                                     <td><?php echo $r['DescuentoP']; ?></td>
                                                     <td><?php echo $r['StockP']; ?></td>
                                                     <td><?php echo $r['codigo_barraP']; ?></td>
                                                     <td><?php echo $r['NonbreC']; ?></td>
                                                     <td>
                                                        <a href="home.php?pagina=producto&ver=<?php echo $r['id_producto'] ?>" title="Editar" alt="Editar"><i class="fas fa-edit icono_editar"></i></a> 
                                                        <a href="javascript:if(confirm('Esta Seguro?')){ window.location='home.php?pagina=producto&del=<?php echo $r['id_producto'] ?>'; }" title="Eliminar" alt="Eliminar"><i class="fas fa-eraser icono_borrar"></i></a>
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

