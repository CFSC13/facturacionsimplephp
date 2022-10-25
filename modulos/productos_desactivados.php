 <?php
if($_SESSION[user]==0)
{
    echo "<script>window.location='index.php';</script>";
}


//activar
if(!empty($_GET[activar]))
{
    $sql=mysqli_query($con, "update productos set activo='si' where id=$_GET[activar]");
    echo "<script>window.location='home.php?pagina=productos_desactivados';</script>"; 
}
//fin activar
?>
 <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div id="accordion">
            <!-- Page Heading -->
                    <div class="card shadow mb-4 mx-auto" >
                        <div class="card-header py-3" id="headingTwo">
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Productos desactivados</h6>
                        </div>
                        <div id="collapseListado" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                    <table class="table table-bordered display nowrap" id="dataTable-mensajes" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Cod.</th>
                                        <th>Nombre</th>
                                        
                                        <th>Precio</th>
                                        <th>Marca</th>
                                        
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Cod.</th>
                                        <th>Nombre</th>
                                        
                                        <th>Precio</th>
                                        
                                        <th>Marca</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $q=mysqli_query($con,"select p.*, m.nombre as marca from productos p, marcas m where p.id_marca=m.id and p.activo='no'"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                 <tr>
                                                    <td><?php echo $r['codigo']; ?></td>
                                                    <td><?php echo $r['nombre']; ?></td>
                                                    <td>$<?php echo number_format($r['precio'],0,',','.'); ?></td>
                                                    <td><?php echo $r['marca']; ?></td>
                                                    
                                                    <td>
                                                        <a href="javascript:if(confirm('Esta Seguro?')){ window.location='home.php?pagina=productos_desactivados&activar=<?php echo $r['id'] ?>'; }" title="Activar" alt="Activar"><i class="fas fa-check icono_editar"></i></a>
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