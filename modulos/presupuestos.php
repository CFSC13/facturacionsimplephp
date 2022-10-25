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
    if($_POST['clientes']!="" && $_POST['formas_pagos']!="" && $_POST['fecha_vencimiento']!="" && $_POST['fecha_vencimiento']!="" && $_POST['cod_prod']!="" && $_POST['can_prod']!="")
    {
       // echo "insert into presupuestos (fecha, id_cliente, id_forma_pago, fecha_vencimiento,cerrado,total) values(now(), $_POST['clientes'], $_POST['formas_pagos'], '$_POST[fecha_vencimiento]', 0, '$_POST[total]') RETURNING *;";
        $sql=mysqli_query($con,"insert into presupuestos (fecha, id_cliente, id_forma_pago, fecha_vencimiento, cerrado, total, descuento) values(now(),$_POST[clientes],$_POST[formas_pagos],'$_POST[fecha_vencimiento]',0,'$_POST[total]','$_POST[descuento]')");
      
        if(!mysqli_error())
        {
            $r=mysqli_fetch_array(mysqli_query($con,"select MAX(id) as id from presupuestos"));
            $cant_articulos=count($_POST['cod_prod']);
            $n=0;
            $error=0;
            //echo "<hr>CANTIDAD DE PRODUCTOS: <h1>".$cant_articulos."</h1>";
            while($n<=$cant_articulos){
                if($_POST['cod_prod'][$n]!="" && $_POST['can_prod'][$n]){
                    $cod=$_POST['cod_prod'][$n];
                    $can=$_POST['can_prod'][$n];
                    $rp=mysqli_fetch_array(mysqli_query($con,"select precio from productos where codigo='$cod'"));
                    $subtotal=$rp['precio']*$can;
                    $sql2.="insert into presupuestos_detalles (id_presupuesto,id_producto,cantidad,precio,subtotal) values($r[id], '".$cod."', $can,'".$rp['precio']."', '$subtotal');";
                    //echo "<hr><h1>".$n.")-".$sql2."</h1>";
                }
                $n++;
            }

            $sql3=mysqli_multi_query($con,$sql2);
            if(!mysqli_error())
            {
                echo "<script>alert('Registro Insertado Correctamente.');</script>";
                echo "<script>window.open('modulos/presupuesto_pdf.php?id=".$r['id']."');window.location='home.php?pagina=presupuestos';</script>";
            }
            else{
                 echo "<script>alert('Error: para crear los detalles');</script>";
            }
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

if($_GET['del']!="")
{

        $sql=mysqli_query($con,"update presupuestos set eliminado='si' where id=".$_GET['del']);
        
        if(!mysqli_error())
        {
            echo "<script>alert('Registro Eliminado Correctamente.');</script>";
            echo "<script>window.location='home.php?pagina=presupuestos';</script>";
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
                            <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse show" data-target="#collapseNuevo" aria-expanded="true" aria-controls="collapseNuevo">Nuevo Presupuesto</h6>
                            </div>
               
               <?php
                        $showform="";
                        $showtable="";
                        if($_GET[ver]!=0)
                        {
                            $sql=mysqli_query($con,"select *from presupuestos where id=$_GET[ver]");
                                if(mysqli_num_rows($sql)!=0)
                                {   
                                    $r=mysqli_fetch_array($sql);
                                }
                                $url="home.php?pagina=presupuestos&mod=ok";
                                $showform="show";
                        }
                            else
                            {
                                $url="home.php?pagina=presupuestos&add=ok";
                                $showtable="show";
                            }
                    ?>
                        <div id="collapseNuevo" class="<?php echo $showform; ?> m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                            <div class="card-body" >
               
                                <form action="<?php echo $url; ?>" method="POST">
                                <!--Fila 1-->
                                 <div class="form-group">
                                    <label for="nombre">Clientes</label>
                                    <select name="clientes" id="clientes" class="form-control bg-light border-0 small" placeholder="clientes"  aria-label="Clientes
                                    " aria-describedby="basic-addon2" style="margin-right: 1%; width:100%;" required>
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g=mysqli_query($con,"select *from clientes order by nombre");
                                        if(mysqli_num_rows($sql_g)!=0)
                                        {
                                            while($r_g=mysqli_fetch_array($sql_g))
                                            {
                                                ?>
                                                <option value="<?php echo $r_g['id'];?>" <?php if($r_g['id']==$r['id_cliente']){?> selected <?php }?>><?php echo $r_g['nombre'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

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
                                                <option value="<?php echo $r_g['id'];?>" <?php if($r_g['id']==$r['id_forma_pago']){?> selected <?php }?>><?php echo $r_g['nombre'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nombre">Descuento (en %)</label>
                                    <input type="number" step=".01" class="form-control" id="descuento" name="descuento" value="<?php echo $r['descuento']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="telefono">Fecha de Vencimiento</label>
                                    <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo $r['fecha_vencimiento']; ?>" required>
                               
                                </div>

                                <fieldset class="border p-2">
                                    <legend class="w-auto h4">Agregar Productos</legend>
                                <div class="form-group">
                                    <label for="nombre">Producto</label>
                                    <select name="productos" id="productos" class="form-control small" placeholder="Producto"  aria-label="Producto
                                    " aria-describedby="basic-addon2" style="margin-right: 1%; width: 100%;">
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g=mysqli_query($con,"select p.*, m.nombre as marca, c.nombre as categoria from productos p, marcas m, categorias c where p.id_marca=m.id and p.activo='si' and p.id_categoria=c.id");
                                        if(mysqli_num_rows($sql_g)!=0)
                                        {
                                            while($r_g=mysqli_fetch_array($sql_g))
                                            {
                                                ?>
                                                <option data-precio="<?php echo $r_g[precio]; ?>" data-cod="<?php echo $r_g[codigo]; ?>" value="<?php echo $r_g['id'];?>"><?php echo $r_g['codigo']." - ".$r_g['marca']." - ".$r_g['nombre'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="Cantidad">Cantidad</label>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?php echo $r['cantidad']; ?>">
                               
                                </div>
                                <p style="text-align: left; float: left;"><button type="button" onclick="AddProductos()" class="btn btn-primary" style="float:right;">Agregar</button></p>
                                <br><br>
                                    <table class="table text-dark" id="prod-presu">
                                        <thead>
                                            <tr>
                                                <th scope="col">Cod.</th>
                                                <th scope="col">Poducto</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Sub-Total</th>
                                            </tr>
                                        </thead>
                                    <tbody id="tbody-prod-presu">
                                    </tbody>
                                    <tfoot id="tfoot-prod-presu" class="text-right">
                                    </tfoot>
                                    </table>
                                </fieldset>    
                                <p style="width: 100%; text-align: center;">
                                    <br>
                                    <button type="submit" class="btn btn-secondary">Finalizar y crear presupuesto </button>
                                </p>
                                </form>
                            </div>
                        </div>
                    </div>
            

           
            
                     <!-- Page Heading -->
                    <div class="card shadow mb-4 mx-auto" >
                        <div class="card-header py-3" id="headingTwo">
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Últimos 10 Presupuestos</h6>
                        </div>
                        <div id="collapseListado" class="collapse <?php echo $showtable; ?>" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                    <table class="table table-striped table-bordered display nowrap" id="dataTable-mensajes" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Cod.</th>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th>Forma de Pago</th>
                                        <th>Fecha Vencimiento</th>
                                        <th>% Descuento</th>
                                        <th>Total</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                       <th>Cod.</th>
                                        <th>Cliente</th>
                                        
                                        <th>Fecha</th>
                                        <th>Forma de Pago</th>
                                        <th>Fecha Vencimiento</th>
                                        <th>% Descuento</th>
                                        <th>Total</th>
                                        
                                        <th>Opciones</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                        //saco los últimos 10 registros
                                        $q=mysqli_query($con,"select p.*, c.nombre as cliente, f.nombre as forma_pago from presupuestos p, clientes c, formas_pagos f where p.id_cliente=c.id and p.id_forma_pago=f.id and p.eliminado='no' order by p.id desc limit 10"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                 <tr>
                                                    <td><?php echo $r['id']; ?></td>
                                                    <td style="text-transform: capitalize;"><?php echo $r['cliente']; ?></td>
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
                </div>
            </div>
    </div>  
<script type="text/javascript">
    var total=0;
    var tr=0;
    function AddProductos(){
        if($("#productos option:selected").val()!="" && $("#cantidad").val()!=0 && $("#cantidad").val()!=""){
            let precio=$("#productos option:selected").data("precio");
            let cod=$("#productos option:selected").data("cod");
            let pro=$("#productos option:selected").text();
            let can=$("#cantidad").val();

            let subtotal=(precio*can);
            total=total+subtotal;
            var numberFormat = new Intl.NumberFormat();
            tr=tr+1;
            $("#tbody-prod-presu").append("<tr class='tr_"+tr+"'><th scope='row'>"+cod+"</th><td>"+pro+"</td><td>"+can+"</td><td>$"+numberFormat.format(parseFloat(precio).toFixed(2))+"</td><td>$"+numberFormat.format(parseFloat(subtotal).toFixed(2))+"</td><td><a title='Eliminar' alt='Eliminar' href='javascript:deltr("+tr+","+subtotal+")'><i class='fas fa-eraser icono_borrar'></i></a></td></tr><input type='hidden' id='cod_prod' name='cod_prod[]' value='"+cod+"'/><input type='hidden' id='can_prod' name='can_prod[]' value='"+can+"'/>");

            $("#tfoot-prod-presu").html("<tr><td colspan='5' class='h4'>Total: $"+numberFormat.format(total.toFixed(2))+"</td></tr><input type='hidden' id='total' name='total' value='"+total+"'/>");

            //limpio el formulario para el próximo producto
            $("#cantidad").val('');
            $('#productos').val(null).trigger('change');
            $("#productos").focus();
        }
            else
            {
                alert('No deje los campos vacios');//mensaje de campos vacios
            }
    }

    function deltr(n,sub){
        $(".tr_"+n).remove();
        tr=tr-1;
        total=total-sub;
        var numberFormat = new Intl.NumberFormat('es-ES');
          $("#tfoot-prod-presu").html("<tr><td colspan='5' class='h4'>Total: $"+numberFormat.format(total.toFixed(2))+"</td></tr>");
    }
</script>    
<script src="vendor/ckeditor/ckeditor.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
    //combo de productos
    $('#productos').select2();
    $("#productos").focus();
    //combo de clientes
    $('#clientes').select2();
    $("#clientes").focus();

$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
  });
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
