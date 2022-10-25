<?php
//funciones php
if($_GET['guardar']=="ok")
{
   #reviso que el monto no sea mayor al de la compra
   $rm=mysqli_fetch_array(mysqli_query($con,"select monto from clientes_compras where id=".$_POST['compras']));
   $total=$_POST['monto'];
   
   if($total>$rm['monto']){
    echo "<script>alert('El pago ingresado es mayor al monto de la compra');</script>";
   }else{ 

    $sql="insert into clientes_pagos (id_cliente, fecha, monto, observaciones, formas_pagos, id_compra) values (".intval($_GET['id']).", '".$_POST['fecha_pago']."', '".$_POST['monto']."', '".$_POST['observacion']."', '".$_POST['formas_pagos']."', ".$_POST['compras'].")";
    $sql=mysqli_query($con,$sql);
        
    if(!mysqli_error())
    {
        echo "<script>alert('Registro Insertado Correctamente.');</script>";
    }
        else
        {
            echo "<script>alert('Error: No se pudo insertar el registro.');</script>";
        }
    }
    echo "<script>window.location='home.php?pagina=ficha_cliente&id=".$_GET['id']."&modulo=ficha_cliente_pagos';</script>";        
}
?>
<div class="card shadow mb-4 mx-auto" >
    <div class="card-header py-3" id="abrir_formulario">
        <h6 class="m-0 font-weight-bold text-primary">Nuevo Pago</h6>
    </div>
    <div style="display:none;" id="formulario_compras_clientes">
        <div class="card-body" >
            <form method="post" action="home.php?pagina=ficha_cliente&id=<?php echo $_GET['id']?>&modulo=ficha_cliente_pagos&guardar=ok">
                <div class="table-responsive" style="padding-right: 1% !important;">
                    <div class="form-group">
                        <label for="nombre">Forma de Pago</label>
                        <select name="formas_pagos" id="formas_pagos" class="form-control bg-light border-0 small" placeholder="Formas de Pago"  aria-label="Formas de Pago
                        " aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                            <option value="">Seleccione...</option>
                            <?php
                            $sql_g=mysqli_query($con,"select *from formas_pagos order by nombre");
                            if(mysqli_num_rows($sql_g)!=0)
                            {
                                while($r_g=mysqli_fetch_array($sql_g))
                                {
                                    ?>
                                    <option value="<?php echo $r_g['nombre'];?>"><?php echo $r_g['nombre'];?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Compras</label>
                        <select name="compras" id="compras" class="form-control small" placeholder="Compras"  aria-label="Compras
                        " aria-describedby="basic-addon2" style="margin-right: 1%; width: 100%;" onchange="cargar_monto_presupuestos(this.value);">
                            <option value="">Seleccione...</option>
                            <?php
                            #busco las compras que todavia faltan cubrir el saldo
                            $sql_g=mysqli_query($con,"select c.* from clientes_compras c where c.id_cliente=".intval($_GET['id'])." and c.monto>(select case when SUM(monto)>0 then SUM(monto) else 0 end from clientes_pagos where id_compra=c.id) order by c.id desc");
                            if(mysqli_num_rows($sql_g)!=0)
                            {
                                $dif=0;
                                while($r_g=mysqli_fetch_array($sql_g))
                                {
                                    #saco el saldo que queda cubrir
                                    $rm=mysqli_fetch_array(mysqli_query($con,"select SUM(monto) as monto from clientes_pagos where id_compra=".$r_g['id']));
                                    $dif=$r_g['monto']-$rm['monto'];    
                                    ?>
                                    <option value="<?php echo $r_g['id']?>"><?php echo '(#'.$r_g['id'].' ) $'.number_format($r_g['monto'],2,',','.')." | Saldo: $".number_format($dif,2,',','.');?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Fecha de Pago</label>
                        <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" required>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Monto total</label>
                        <input type="number" step=".01" class="form-control" id="monto" name="monto" required>
                       
                    </div>

                    <div class="form-group">
                        <label for="nombre">Observación</label>
                        <textarea class="form-control" id="observacion" name="observacion"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="float:right;">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card shadow mb-4 mx-auto" >
    <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Listado de Pagos</h6>
    </div>
    <div>
        <div class="card-body" >
         <div class="table-responsive" style="padding-right: 1% !important;">
            <table class="table table-striped table-bordered display nowrap" id="dataTable-mensajes" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>#Cod.</th>
                    <th>Fecha</th>
                    <th>F. Pago</th>
                    <th>Total</th>
                    <th>OBS</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>#Cod.</th>
                    <th>Fecha</th>
                    <th>F. Pago</th>
                    <th>Total</th>
                    <th>OBS</th>
                    <th>Opciones</th>
                </tr>
                </tfoot>
                <tbody>
                    <?php 
                    $q=mysqli_query($con,"select *from clientes_pagos where id_cliente=".intval($_GET['id'])." order by id desc"); 
                        if(mysqli_num_rows($q)!=0){
                            while($r=mysqli_fetch_array($q)){?>
                             <tr>
                                <td><?php echo $r['id']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($r['fecha'])); ?></td>
                                <td><?php echo $r['formas_pagos']; ?></td>
                                <td>$<?php echo number_format($r['monto'],2,',','.'); ?></td>
                                <td><?php echo $r['observaciones']; ?></td>
                                <td>
                                    <!--
                                    <a href="javascript:if(confirm('¿Seguro desea elminar la compra?')){ window.location='home.php?pagina=xxxxxx'; }" class="btn btn-danger" title="Eliminar" alt="Eliminar">
                                        <i class="fas fa-eraser"></i> Eliminar
                                    </a>-->
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
<script type="text/javascript">
function cargar_monto_presupuestos(id)
{
    var valores = id.split("-");
    // [0]=id presupuesto - [1]=monto total - [2]=descuento
    var monto=valores[1]; var descuento=valores[2];
    var total=monto-((descuento*monto)/100);
    $("#monto").val(total.toFixed(2));
}
$( "#abrir_formulario" ).click(function() {
  $( "#formulario_compras_clientes" ).toggle( "slow", function() {
    // Animation complete.
  });
});
</script>