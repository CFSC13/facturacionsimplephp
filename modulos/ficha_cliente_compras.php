<?php
//funciones php
if($_GET['guardar']=="ok")
{
    //consulto si tiene seleccionado un presupuesto
    $atributo_presupuesto=$valor_presupuesto='';
    if(!empty($_POST['presupuestos']))
    {
        $atributo_presupuesto=",id_presupuesto";
        $cadena_presupuesto=explode('-', $_POST['presupuestos']);
        $valor_presupuesto=",".$cadena_presupuesto[0];
    }

    $sql="insert into clientes_compras (id_cliente, fecha, monto, observaciones, formas_pagos $atributo_presupuesto) values (".intval($_GET['id']).", '".$_POST['fecha_compra']."', '".$_POST['monto']."', '".$_POST['observacion']."', '".$_POST['formas_pagos']."' $valor_presupuesto)";
    $sql=mysqli_query($con,$sql);
        
    if(!mysqli_error())
    {
        echo "<script>alert('Registro Insertado Correctamente.');</script>";
    }
        else
        {
            echo "<script>alert('Error: No se pudo insertar el registro.');</script>";
        }

    echo "<script>window.location='home.php?pagina=ficha_cliente&id=".$_GET['id']."&modulo=ficha_cliente_compras';</script>";        
}
?>
<div class="card shadow mb-4 mx-auto" >
    <div class="card-header py-3" id="abrir_formulario">
        <h6 class="m-0 font-weight-bold text-primary">Nueva compra</h6>
    </div>
    <div style="display:none;" id="formulario_compras_clientes">
        <div class="card-body" >
            <form method="post" action="home.php?pagina=ficha_cliente&id=<?php echo $_GET['id']?>&modulo=ficha_cliente_compras&guardar=ok">
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
                        <label for="nombre">Presupuestos</label>
                        <select name="presupuestos" id="presupuestos" class="form-control small" placeholder="Presupuestos"  aria-label="Presupuestos
                        " aria-describedby="basic-addon2" style="margin-right: 1%; width: 100%;" onchange="cargar_monto_presupuestos(this.value);">
                            <option value="">Seleccione...</option>
                            <?php
                            $sql_g=mysqli_query($con,"select p.*, c.nombre as cliente, f.nombre as forma_pago from presupuestos p, clientes c, formas_pagos f where p.id_cliente=c.id and p.id_forma_pago=f.id and p.eliminado='no' and p.id_cliente=".intval($_GET['id'])." order by p.id desc");
                            if(mysqli_num_rows($sql_g)!=0)
                            {
                                while($r_g=mysqli_fetch_array($sql_g))
                                {
                                    ?>
                                    <option value="<?php echo $r_g['id'].'-'.$r_g['total'].'-'.$r_g['descuento'];?>"><?php echo '(#'.$r_g['id'].' ) $'.number_format(($r_g['total']-(($r_g['descuento']*$r_g['total'])/100)),2,',','.');?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Fecha de compra</label>
                        <input type="date" class="form-control" id="fecha_compra" name="fecha_compra" required>
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
    <h6 class="m-0 font-weight-bold text-primary">Listado de compras</h6>
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
                    $q=mysqli_query($con,"select *from clientes_compras where id_cliente=".intval($_GET['id'])." order by id desc"); 
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