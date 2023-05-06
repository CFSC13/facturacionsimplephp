<audio id="beep" src="beep.mp3"></audio>


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
    if($_POST['cod_prod']!="" && $_POST['can_prod']!="")
    {
       // echo "insert into facturacion (fecha, id_cliente, id_forma_pago, fecha_vencimiento,cerrado,total) values(now(), $_POST['clientes'], $_POST['condicion_venta'], '$_POST[fecha_vencimiento]', 0, '$_POST[total]') RETURNING *;";
        $sql=mysqli_query($con,"insert into factura (fecha_de_emision, id_cliente, id_condicion_venta, importe_total, id_datos_empresa, id_tipo_factura, id_usuario) values(now(),1,1,'$_POST[total]', 1,1,1)");
      
        if(!mysqli_error($con))
        {
            $r=mysqli_fetch_array(mysqli_query($con,"select MAX(id_factura) as id from factura"));
            $cant_articulos=count($_POST['cod_prod']);
            $n=0;
            $error=0;
            echo "$r[0]";
            //echo "<hr>CANTIDAD DE PRODUCTOS: <h1>".$cant_articulos."</h1>";
            while($n<=$cant_articulos){
                if($_POST['cod_prod'][$n]!="" && $_POST['can_prod'][$n]){
                    $cod=$_POST['cod_prod'][$n];
                    $can=$_POST['can_prod'][$n];
                    $rp=mysqli_fetch_array(mysqli_query($con,"select precio from producto where id_producto='$cod'"));
                    $subtotal=$rp['precio']*$can;
                    $sql2.="insert into detalle_factura (id_factura,id_producto,cantidad,precio_unitario,subtotal, descuento) values($r[id], '".$cod."', $can,'".$rp['precio']."', '$subtotal',$_POST[descuento]);";
                    //echo "<hr><h1>".$n.")-".$sql2."</h1>";
                }
                $n++;
            }

            $sql3=mysqli_multi_query($con,$sql2);
            if(!mysqli_error($con))
            {
                echo "<script>alert('Registro Insertado Correctamente.');</script>";
                echo "<script>window.open('modulos/presupuesto_pdf.php?id=".$r['id_factura']."');window.location='home.php?pagina=facturacion';</script>";
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

        $sql=mysqli_query($con,"delete from factura where id_factura=".$_GET['del']);
        
        if(!mysqli_error($con))
        {
            echo "<script>alert('Registro Eliminado Correctamente.');</script>";
            echo "<script>window.location='home.php?pagina=facturacion';</script>";
        }
            else
            {
                echo "<script>alert('Error: No se pudo Eliminar el registro.');</script>";
            }

}
?>

<script src="https://unpkg.com/html5-qrcode"></script>

<style>
   @media only screen and (max-width: 767px) {
    #totalMostrado {
        text-align: center;
    }
}


 
</style>
  <div class="tab-content" id="nav-tabContent">                         
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
               <div id="accordion">
                     <!-- Page Heading -->
                        <div class="card shadow mb-4" id="headingOne">
                            <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse show" data-target="#collapseNuevo" aria-expanded="true" aria-controls="collapseNuevo">Nueva Venta</h6>
                            </div>
               
               <?php
                        $showform="";
                        $showtable="";
                        if($_GET[ver]!=0)
                        {
                            $sql=mysqli_query($con,"select *from facturacion where id_facturacion=$_GET[ver]");
                                if(mysqli_num_rows($sql)!=0)
                                {   
                                    $r=mysqli_fetch_array($sql);
                                }
                                $url="home.php?pagina=facturacion&mod=ok";
                                $showform="show";
                        }
                            else
                            {
                                $url="home.php?pagina=facturacion&add=ok";
                                $showtable="show";
                            }
                    ?>
                        <div id="collapseNuevo" class="<?php echo $showform; ?> m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                            <div class="card-body" >
                              
                                <form action="<?php echo $url; ?>" method="POST">
                                <!--Fila 1-->

                                <!--Todo este div esta oculto-->                            
                                <div style="display: none">

                                <div class="form-group">
                                    <label for="nombre">Clientes</label>
                                    <select name="clientes" id="clientes" class="form-control bg-light border-0 small" placeholder="clientes"  aria-label="Clientes
                                    " aria-describedby="basic-addon2" style="margin-right: 1%; width:100%;">
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g=mysqli_query($con,"select *from cliente order by nombre");
                                        if(mysqli_num_rows($sql_g)!=0)
                                        {
                                            while($r_g=mysqli_fetch_array($sql_g))
                                            {
                                                ?>
                                                <option value="<?php echo $r_g['id_cliente'];?>" <?php if($r_g['id_cliente']==$r['id_cliente']){?> selected <?php }?>><?php echo $r_g['nombre'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nombre">Forma de Pago</label>
                                    <select name="condicion_venta" id="condicion_venta" class="form-control bg-light border-0 small" placeholder="Formas de Pago"  aria-label="Formas de Pago
                                    " aria-describedby="basic-addon2" style="margin-right: 1%;">
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g=mysqli_query($con,"select *from condicion_venta order by nombre");
                                        if(mysqli_num_rows($sql_g)!=0)
                                        {
                                            while($r_g=mysqli_fetch_array($sql_g))
                                            {
                                                ?>
                                                <option id= "scan-input" value="<?php echo $r_g['id_condicion_venta'];?>" <?php if($r_g['id_condicion_venta']==$r['id_condicion_venta']){?> selected <?php }?>><?php echo $r_g['nombre'];?></option>
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
                                </div>


                                
                                <fieldset class="border p-2">
                                    <legend class="w-auto h4">Agregar Productos</legend>

                                <div class="form-group">
                                    <label for="nombre">Escanea el Producto</label>
                                    
                                    <div style="width: 280px" id="reader"></div>
                                    <br>

                                <div class="form-group">
                                    <label for="codigo">Codigo</label>
                                    <input type="text" class="form-control" id="codigo" name="codigo" value="">
                               
                                </div> 
                                
                                <div id="task-list"></div>
                                <div class="form-group">
                                    <label for="codigo">Nombre</label>
                                    <input type="text" class="form-control" id="nombreInput" name="nombreInput" value="">
                               
                                </div> 
                                <div class="form-group">
                                    <label for="codigo">Precio</label>
                                    <input type="number" class="form-control" id="precioInput" name="precioInput" value="">
                               
                                </div>
                                <input type="hidden" id="id" value="">                              
                                  
                                </div>

                                <div class="form-group">
                                    <label for="Cantidad">Cantidad</label>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad" value="1">
                               
                                </div>
                                <p style="text-align: left; float: left;"><button type="button" onclick="AddProductos()" class="btn btn-primary" style="float:right;">Agregar</button></p>
                                <br><br>
                                <div class="table-responsive">
                                    <table class="table table-sm text-dark" id="prod-presu">
                                        <thead>
                                            <tr>
                                                <th scope="col">Producto</th>                                                 
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Sub Total</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-prod-presu">
                                        </tbody>
                                        <tfoot id="tfoot-prod-presu" class="text-right">
                                        </tfoot>
                                    </table>
                                </div>
                                </fieldset>    
                                <p style="width: 100%; text-align: center;">
                                    <br>
                                    <button type="submit" class="btn btn-secondary">Facturar </button>
                                </p>
                                </form>
                            </div>
                        </div>
                    </div>
            

           
            
                     <!-- Page Heading -->
                    <div class="card shadow mb-4 mx-auto" >
                        <div class="card-header py-3" id="headingTwo">
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Últimas 10 Facturaciones</h6>
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
                                        <th>% Descuento</th>
                                        <th>Total</th>                                        
                                        <th>Opciones</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                        //saco los últimos 10 registros
                                        //uso  distinc para que traiga solo una fila
                                        $q=mysqli_query($con,"SELECT DISTINCT f.id_factura, c.nombre as cliente, f.importe_total, f.fecha_de_emision, c.id_cliente, cv.nombre as forma_pago, df.descuento FROM cliente c JOIN factura f on c.id_cliente=f.id_cliente JOIN detalle_factura df on f.id_factura=df.id_factura JOIN condicion_venta cv on f.id_condicion_venta=cv.id_condicion_venta GROUP by f.id_factura;"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                 <tr>
                                                    <td><?php echo $r['id_factura']; ?></td>
                                                    <td style="text-transform: capitalize;"><?php echo $r['cliente']; ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($r['fecha_de_emision'])); ?></td>
                                                    <td><?php echo $r['forma_pago']; ?></td>
                                                    <td><?php echo $r['descuento']; ?></td>
                                                    <td>$<?php echo number_format(($r['importe_total']-(($r['descuento']*$r['total'])/100)),2,',','.'); ?></td>
                                                    <td>
                                                        <a href="presupuesto_pdf.php?id=<?php echo $r['id_factura'] ?>"  class="btn btn-primary" target="_blank" title="Ver PDF" alt="Ver PDF">
                                                            <i class="fas fa-file-pdf"></i> Ver PDF
                                                        </a>
                                                        <a href="javascript:if(confirm('¿Seguro desea elminar la factura?')){ window.location='home.php?pagina=facturacion&del=<?php echo $r['id_factura'] ?>'; }" class="btn btn-danger" title="Eliminar" alt="Eliminar">
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
    if($("#cantidad").val()!=0 && $("#cantidad").val()!=""){
        let precio=$("#precioInput").val();
        //ver como traer el id par apoder trabajar con el id
        let cod=$("#id").val();
        let pro=$("#nombreInput").val();
        let can=$("#cantidad").val();
        let subtotal=(precio*can);
        total=total+subtotal;
        var numberFormat = new Intl.NumberFormat();
        tr=tr+1;
        $("#tbody-prod-presu").append("<tr class='tr_"+tr+"'><td>"+pro+"</td><td><button type='button' class='btn-qty' onclick='decrementQty("+tr+")'>-</button> <input class='input-qty' id='cantidad_"+tr+"' type='number' min='1' value='"+can+"' onchange='updateSubtotal("+tr+","+precio+")'> <button type='button' class='btn-qty' onclick='incrementQty("+tr+")'>+</button></td><td>$"+numberFormat.format(parseFloat(precio).toFixed(2))+"</td><td id='subtotal_"+tr+"'>$"+numberFormat.format(parseFloat(subtotal).toFixed(2))+"</td><td><a title='Eliminar' alt='Eliminar' href='javascript:deltr("+tr+","+subtotal+")'><i class='fas fa-eraser icono_borrar'></i></a></td></tr><input type='hidden' id='cod_prod' name='cod_prod[]' value='"+cod+"'/><input type='hidden' id='can_prod_"+tr+"' name='can_prod[]' value='"+can+"'/>");
        $("#tfoot-prod-presu").html("<tr><td colspan='5' id='totalMostrado' class='h4'>Total: $"+numberFormat.format(total.toFixed(2))+"</td></tr><input type='hidden' id='total' name='total' value='"+total+"'/>");
        //limpio el formulario para el próximo producto
        $("#cantidad").val('1');
        $('#productos').val(null).trigger('change');
        $("#productos").focus();
    }
    else
    {
        alert('No deje los campos vacios');//mensaje de campos vacios
    }
}

function updateSubtotal(n, precio) {
    let can=$("#cantidad_"+n).val();
    let subtotal=(precio*can);
    $("#subtotal_"+n).html("$"+new Intl.NumberFormat().format(parseFloat(subtotal).toFixed(2)));
    $("#can_prod_"+n).val(can);
    total=0;
    $(".input-qty").each(function(){
        let subtotal=parseFloat($(this).val())*parseFloat($("#precioInput").val());
        total+=subtotal;
        $("#totalMostrado").html("Total: $"+new Intl.NumberFormat().format(parseFloat(total).toFixed(2)));
        $("#total").val(total);
    });
}

function incrementQty(n) {
    let qty=$("#cantidad_"+n).val();
    $("#cantidad_"+n).val(parseInt(qty)+1);
    updateSubtotal(n, $("#precioInput").val());
}

function decrementQty(n) {
    let qty=$("#cantidad_"+n).val();
    if (qty > 1) {
        $("#cantidad_"+n).val(parseInt(qty)-1);
        updateSubtotal(n, $("#precioInput").val());
    }
}

function deltr(n,sub){
    $(".tr_"+n).remove();
    tr=tr-1;
    total=total-sub;
    var numberFormat = new Intl.NumberFormat('es-ES');
      $("#tfoot-prod-presu").html("<tr><td colspan='5' class='h4'>Total: $"+numberFormat.format(total.toFixed(2))+"</td></tr>");
      updateSubtotal();
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

<script>
    var html5QrcodeScanner = new Html5QrcodeScanner(
	"reader", { fps: 0.5, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);


function onScanSuccess(decodedText, decodedResult) {
  // Handle on success condition with the decoded text or result.
  var scanInput = $("#codigo");
  
  scanInput.val(decodedText);

  // Emite un sonido al escanear un código
  var beepSound = document.getElementById("beep");
  beepSound.play();

  // Para enviar el codigo por get
  var scanInputValue = decodedText;

  $.ajax({
    url: "https://6d50-138-186-162-59.ngrok-free.app/facturacionmovil/buscarAjax.php",
    //url: "http://localhost/facturacionmovil/buscarAjax.php",
    data: { w1: scanInputValue },
    type: "GET",
    //especifica que se recibe en formato JSON y no hace falta usar el parse
    //dataType: "json",
    success: function (response) {
        if (!response.error) {
            //aca se convirte el string en JSON
            let tasks = JSON.parse(response);           
            $('#nombreInput').val(tasks[0].name);
            $('#precioInput').val(tasks[0].price);
            $('#id').val(tasks[0].id);
              // Llama a la función AddProductos() después de actualizar los campos
            AddProductos();
                }
                } ,
            error: function(jqXHR, textStatus, errorThrown) {
                // Manejar errores aquí
                }
            });
            }

  
</script>



