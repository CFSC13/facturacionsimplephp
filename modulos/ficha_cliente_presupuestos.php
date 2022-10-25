<div class="card shadow mb-4 mx-auto" >
    <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Listado de presupuestos activos</h6>
    </div>
    <div>
        <div class="card-body" >
         <div class="table-responsive" style="padding-right: 1% !important;">
                <table class="table table-striped table-bordered display nowrap" id="dataTable-mensajes" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Cod.</th>
                    <th>Fecha</th>
                    <th>Pago</th>
                    <th>Vencimiento</th>
                    <th>Descuento</th>
                    <th>Total</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                   <th>Cod.</th>
                    <th>Fecha</th>
                    <th>Pago</th>
                    <th>Vencimiento</th>
                    <th>Descuento</th>
                    <th>Total</th>
                    <th>Opciones</th>
                </tr>
                </tfoot>
                <tbody>
                    <?php 
                    $q=mysqli_query($con,"select p.*, c.nombre as cliente, f.nombre as forma_pago from presupuestos p, clientes c, formas_pagos f where p.id_cliente=c.id and p.id_forma_pago=f.id and p.eliminado='no' and p.id_cliente=".intval($_GET['id'])." order by p.id desc"); 
                        if(mysqli_num_rows($q)!=0){
                            while($r=mysqli_fetch_array($q)){?>
                             <tr>
                                <td><?php echo $r['id']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($r['fecha'])); ?></td>
                                <td><?php echo $r['forma_pago']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($r['fecha_vencimiento']));?></td>
                                <td><?php echo $r['descuento']; ?></td>
                                <td>$<?php echo number_format(($r['total']-(($r['descuento']*$r['total'])/100)),2,',','.'); ?></td>
                                <td>
                                    <a href="modulos/presupuesto_pdf.php?id=<?php echo $r['id'] ?>"  class="btn btn-primary" target="_blank" title="Ver PDF" alt="Ver PDF">
                                        <i class="fas fa-file-pdf"></i> Ver PDF
                                    </a>
                                    <a href="javascript:if(confirm('¿Seguro desea elminar el presupuesto?')){ window.location='home.php?pagina=presupuestos&del=<?php echo $r['id'] ?>'; }" class="btn btn-danger" title="Eliminar" alt="Eliminar">
                                        <i class="fas fa-eraser"></i> Eliminar
                                    </a>
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