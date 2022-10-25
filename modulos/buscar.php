 <?php
session_start();
//include("conexion.php");
//conectar(); 
//include ("funciones.php");

if($_SESSION[user]==0)
{
    echo "<script>window.location='index.php';</script>";
}
if(strlen($_POST['cadena'])<4)//controlo la cantidad mínima de caracteres antes de buscara
    echo "<script>window.location='home.php';</script>";
?>
  <div class="tab-content" id="nav-tabContent">               
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
           <div id="accordion">    
                <!-- Inicio Clientes -->
                <?php $q=mysqli_query($con,"select *from clientes where nombre like '%".$_POST['cadena']."%' or codigo like '%".$_POST['cadena']."%'");?>
                <div class="card shadow mb-4 mx-auto" >
                    <div class="card-header py-3" id="headingTwo">
                    <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado_clientes" aria-expanded="true" aria-controls="collapseListado_clientes">Clientes (<?php echo mysqli_num_rows($q);?>)</h6>
                    </div>
                    <div id="collapseListado_clientes" class="collapse " aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                <table class="table table-bordered display nowrap" id="dataTable-clientes" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Cod.</th>
                                        <th>Nombre</th>
                                        <th>Ficha</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Cod.</th>
                                        <th>Nombre</th>
                                        <th>Ficha</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    if(mysqli_num_rows($q)!=0){ 
                                        while($r=mysqli_fetch_array($q))
                                        {?>
                                         <tr>
                                            <td>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ficha_cliente_<?php echo $r['id'];?>"><?php echo $r['codigo'];?></a>
                                            </td>
                                             <td>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ficha_cliente_<?php echo $r['id'];?>"><?php echo $r['nombre'];?></a>
                                            </td>
                                            <td align="center">
                                                <a href="home.php?pagina=ficha_cliente&id=<?php echo $r['id'];?>" class="btn btn-primary" title="Ficha Cliente" alt="Ficha Cliente">
                                                    <i class="fas fa-address-card"></i> Ir a la ficha
                                                </a>
                                            </td>
                                         </tr>
                                         <!--Ficha Temporal -->
                                            <div class="modal fade" id="ficha_cliente_<?php echo $r['id'];?>" tabindex="-1" role="dialog" aria-labelledby="ficha_cliente_<?php echo $r['id'];?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="ficha_cliente_<?php echo $r['id'];?>" style="text-transform: capitalize;"><?php echo "#".$r['codigo']." - ".$r['nombre'];?></h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4 class="card-title"><b>Saldo</b>: $<?php echo number_format($saldo,0,',','.');?></h4>
                                                            <p>
                                                                <i class="fas fa-fw fa-phone"></i> <?php echo $r['telefono']; ?> 
                                                                <i class="fas fa-fw fa-envelope-open"></i> <?php echo $r['correo']; ?> 
                                                                <i class="fas fa-fw fa-home"></i> <?php echo $r['direccion']; ?> 
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-dismiss="modal" aria-label="Close">Cerrar</button>
                                                            <!--<button class="btn btn-primary" type="button">Ficha</button>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <!--FIN Ficha Temporal -->       
                                        <?php 
                                        }
                                    }
                                    ?>         
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fin Clientes-->
                <!-- Inicio Productos -->
                <?php $q=mysqli_query($con,"select p.*, m.nombre as marca, m.logo, (select url from fotos_productos where id_producto=p.id order by orden limit 1) as foto from productos p, marcas m where (p.nombre like '%".$_POST['cadena']."%' or p.codigo like '%".$_POST['cadena']."%') and p.id_marca=m.id and p.activo='si'");?>
                <div class="card shadow mb-4 mx-auto" >
                    <div class="card-header py-3" id="headingTwo">
                    <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado_productos" aria-expanded="true" aria-controls="collapseListado_productos">Productos (<?php echo mysqli_num_rows($q);?>)</h6>
                    </div>
                    <div id="collapseListado_productos" class="collapse " aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                <table class="table table-bordered display nowrap" id="dataTable-productos" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    if(mysqli_num_rows($q)!=0){ 
                                        while($r=mysqli_fetch_array($q))
                                        {?>
                                         <tr>
                                            <td>
                                               <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ficha_producto_<?php echo $r['id'];?>"><?php echo $r['codigo'];?></a>
                                            </td>
                                             <td>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ficha_producto_<?php echo $r['id'];?>"><?php echo $r['nombre'];?></a>           
                                            </td>
                                         </tr>      
                                         <!--Ficha Temporal -->
                                            <div class="modal fade" id="ficha_producto_<?php echo $r['id'];?>" tabindex="-1" role="dialog" aria-labelledby="ficha_producto_<?php echo $r['id'];?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="ficha_producto_<?php echo $r['id'];?>">Vista rápida</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="fotos/<?php echo $r['foto']; ?>" align="left" width="40%" style="margin-right: 2%;">
                                                            <p>Código: <b><?php echo $r['codigo'];?></b></p>
                                                            <hr>
                                                            <h5 class="card-title" style="text-transform: capitalize;"><?php echo $r['nombre'];?></h5>
                                                            <h4 class="card-title">$<?php echo number_format($r['precio'],2,',','.');?></h4>
                                                            <hr>
                                                            <p>Marca: <b style="text-transform:uppercase;"><?php echo $r['marca'];?></b> <?php echo $r['descripcion'];?></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-dismiss="modal" aria-label="Close">Cerrar</button>
                                                            <!--<button class="btn btn-primary" type="button">Ficha</button>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <!--FIN Ficha Temporal -->     
                                        <?php 
                                        }
                                    }
                                    ?>         
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fin productos-->
            </div>
        </div>
    </div>    
<script>
$(document).ready( function () {
    //clientes
    $('#dataTable-clientes').DataTable({
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
    $('#dataTable-clientes').DataTable();

    //productos
    $('#dataTable-productos').DataTable({
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
    $('#dataTable-productos').DataTable();
} );    
</script>

