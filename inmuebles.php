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
    
    if(($_POST['titulo']!=""))
    {
        //saco las caracteristicas
            $sql_a=mysqli_query($con, "select *from campos_inmuebles where id_tipo_inmueble=".$_POST['tipo_inmueble']);
            if(mysqli_num_rows($sql_a)>0)
            {
                while($r_a=mysqli_fetch_array($sql_a))
                {
                    $vble=$r_a['nombre_campo'];
                    if($_POST[$vble]!="")
                    {
                        if($r_a['tipo_dato']==0)
                        {
                            //0=numeros
                            $atributos.=",".$r_a['nombre_campo'];
                            $valores.=",".$_POST[$vble];
                        }
                            else
                            {
                                //1=texto
                                $atributos.=",".$r_a['nombre_campo'];
                                $valores.=",'".$_POST[$vble]."'";
                            }   
                    }
                }
            }
        //fin de las caracteristicas
        //inicio del mapa
            if($_SESSION['lat']!="")
            {
                $atributos.=",lat";
                $valores.=",'$_SESSION[lat]'";
            }
            if($_SESSION['lon']!="")
            {
                $atributos.=",lon";
                $valores.=",'$_SESSION[lon]'";
            }
        //fin del mapa             
        $sql=mysqli_query($con,"insert into inmuebles (titulo, tipo_inmueble, tipo_operacion, id_ciudad, ubicacion, moneda, precio, mostrar_precio, destacado, url_bitly ,descripcion".$atributos.") values(lower('$_POST[titulo]'), $_POST[tipo_inmueble], $_POST[tipo_operacion], $_POST[ciudad], lower('$_POST[ubicacion]'), '$_POST[moneda]', '".str_replace('.', '', $_POST[precio])."', '$_POST[mostrar_precio]', '$_POST[destacado]', '$_POST[url_bitly]','".base64_encode($_POST[descripcion])."' ".$valores.")");
        
        if(!mysqli_error())
        {
            echo "<script>alert('Registro Insertado Correctamente.');</script>";
            echo "<script>window.location='home.php?pagina=inmuebles';</script>";
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

    if(($_POST['titulo']!=""))
    {
        //saco las caracteristicas
        $sql_a=mysqli_query($con, "select *from campos_inmuebles where id_tipo_inmueble=".$_POST['tipo_inmueble']);
        if(mysqli_num_rows($sql_a)>0)
        {
            while($r_a=mysqli_fetch_array($sql_a))
            {
                    
                $vble=$r_a['nombre_campo'];
                if($_POST[$vble]!="")
                {
                    if($r_a['tipo_dato']==0)
                    {
                        //0=numeros
                        $atributos.=",".$r_a['nombre_campo']."=".$_POST[$vble];
                    }
                        else
                        {
                            //1=texto
                            $atributos.=",".$r_a['nombre_campo']."='".$_POST[$vble]."'";
                        }   
                }
                
            }
        }
        //fin de las caracteristicas    
        //inicio del mapa
            if($_SESSION['lat']!="")
            {
                $atributos.=",lat='$_SESSION[lat]'";
            }
            if($_SESSION['lon']!="")
            {
                $atributos.=",lon='$_SESSION[lon]'";
            }
        //fin del mapa            
            $sql=mysqli_query($con,"update inmuebles set titulo=lower('$_POST[titulo]'), tipo_inmueble=$_POST[tipo_inmueble], tipo_operacion=$_POST[tipo_operacion], id_ciudad=$_POST[ciudad], ubicacion=lower('$_POST[ubicacion]'), moneda='$_POST[moneda]', precio='".str_replace('.', '', $_POST[precio])."', mostrar_precio='$_POST[mostrar_precio]', destacado='$_POST[destacado]', url_bitly='$_POST[url_bitly]', descripcion='".base64_encode($_POST[descripcion])."'".$atributos." where id=$_POST[id]");

            if(!mysqli_error())
            {
               
                echo "<script>alert('Registro Modificado Correctamente.');</script>";
                echo "<script>window.location='home.php?pagina=inmuebles';</script>";
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

        $sql=mysqli_query($con,"update inmuebles set activo='no' where id=$_GET[desactivar]");
        
        if(!mysqli_error())
        {
            echo "<script>alert('Registro desactivado correctamente.');</script>";
            echo "<script>window.location='home.php?pagina=inmuebles';</script>";
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
                            <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">Nuevo Inmueble</h6>
                            </div>
               
               <?php
                        $showform="";
                        $showtable="";
                        if($_GET[ver]!=0)
                        {
                            $sql=mysqli_query($con,"select *from inmuebles where id=$_GET[ver]");
                                if(mysqli_num_rows($sql)!=0)
                                {   
                                    $r=mysqli_fetch_array($sql);
                                }
                                $url="home.php?pagina=inmuebles&mod=ok";
                                $showform="show";
                        }
                            else
                            {
                                $url="home.php?pagina=inmuebles&add=ok";
                                $showtable="show";
                            }
                    ?>
                        <div id="collapseNuevo" class="collapse <?php echo $showform; ?> m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                            <div class="card-body" >
               
                                <form action="<?php echo $url; ?>" method="POST">
                                <!--Fila 1-->
                                <div class="form-group">
                                    <label for="nombre">Título</label>
                                    <input type="text" class="form-control" id="tiutlo" name="titulo" value="<?php echo $r['titulo']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Tipo de inmueble</label>
                                    <select name="tipo_inmueble" id="tipo_inmueble" onchange="campos_inmuebles(this.value)" class="form-control bg-light border-0 small" placeholder="Tipo de inmueble"  aria-label="Tipo de inmueble" aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g=mysqli_query($con,"select *from tipos_inmuebles order by nombre");
                                        if(mysqli_num_rows($sql_g)!=0)
                                        {
                                            while($r_g=mysqli_fetch_array($sql_g))
                                            {
                                                ?>
                                                <option value="<?php echo $r_g['id'];?>" <?php if($r_g['id']==$r['tipo_inmueble']){?> selected <?php }?>><?php echo $r_g['nombre'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php if($_GET['ver']=="")
                                {?>
                                <div class="form-group">
                                    <div class="form-group" id="campos_mostrar"></div>
                                </div>
                                <?php }?>
                                <div class="form-group" id="campos_inmuebles_ver">
                                <?php 
                                if(!empty($_GET['ver']))
                                {
                                    ?>
                                    <div class="form-group" id="campos_mostrar">
                                        <?php           
                                        $qc=mysqli_query($con, "select *from campos_inmuebles where id_tipo_inmueble=".$r['tipo_inmueble']." order by linea,id");
                                            if(mysqli_num_rows($qc)!=0)
                                            {
                                                while($rc=mysqli_fetch_array($qc))
                                                {
                                                    if($rc['etiqueta']=="balcon")
                                                    {?>
                                                    <div class="form-group">
                                                        <label for="nombre"><?php echo $rc['etiqueta'];?></label>
                                                        <select id="<?php echo $rc['nombre_input']?>" name="<?php echo $rc['nombre_input']?>" class="form-control bg-light border-0 small" placeholder="Balcón"  aria-label="Balcón" aria-describedby="basic-addon2" style="margin-right: 1%;">
                                                            <option value="Seleccione...">Seleccione...</option>
                                                            <option value="balcon_frente" <?php if($r['balcon_frente']!=""){?> selected="selected" <?php } ?>>Frente</option>
                                                            <option value="balcon_contrafrente" <?php if($r['balcon_contrafrente']!=""){?> selected="selected" <?php } ?>>Contra Frente</option>
                                                            <option value="balcon_lateral" <?php if($r['balcon_lateral']!=""){?> selected="selected" <?php } ?>>Lateral</option>
                                                        </select>
                                                    </div>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                    $vble=$rc['nombre_campo']; $type="";
                                                        if($rc['tipo_dato']==0)
                                                            $type="number";
                                                        else
                                                            $type="text";   
                                                    ?>
                                                    <div class="form-group">
                                                        <label for="nombre"><?php echo ucfirst($rc['nombre_mostrar']);?></label>
                                                        <input type="<?php echo $type; ?>" id="<?php echo $rc['nombre_input']?>" name="<?php echo $rc['nombre_input']?>" value="<?php echo $r[$vble]; ?>" class="form-control" /><i><?php echo $rc['unidad'];?></i>
                                                    </div>
                                                    <?php
                                                    }       
                                                }
                                            }
                                        ?>
                                        </div>
                                    <?php       
                                }
                                ?>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Tipo de operación</label>
                                    <select name="tipo_operacion" id="tipo_operacion" class="form-control bg-light border-0 small" placeholder="Tipo de operación"  aria-label="Tipo de operación" aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g=mysqli_query($con,"select *from tipos_operaciones order by nombre");
                                        if(mysqli_num_rows($sql_g)!=0)
                                        {
                                            while($r_g=mysqli_fetch_array($sql_g))
                                            {
                                                ?>
                                                <option value="<?php echo $r_g['id'];?>" <?php if($r_g['id']==$r['tipo_operacion']){?> selected <?php }?>><?php echo $r_g['nombre'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Ciudad</label>
                                    <select name="ciudad" id="ciudad" class="form-control bg-light border-0 small" placeholder="Ciudad"  aria-label="Ciudad
                                    " aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g=mysqli_query($con,"select *from ciudades order by nombre");
                                        if(mysqli_num_rows($sql_g)!=0)
                                        {
                                            while($r_g=mysqli_fetch_array($sql_g))
                                            {
                                                ?>
                                                <option value="<?php echo $r_g['id'];?>" <?php if($r_g['id']==$r['id_ciudad']){?> selected <?php }?>><?php echo $r_g['nombre'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Ubicación</label>
                                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="<?php echo $r['ubicacion']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Mapa URL Bitly</label>
                                    <input type="text" class="form-control" id="url_bitly" name="url_bitly" value="<?php echo $r['url_bitly']; ?>" required>
                                        <?php
                                        //test de Fx para expandir URL Bitly
                                        if(!empty($r['url_bitly']))
                                        {
                                            $nueva_url=expandir_url($r['url_bitly']);//expande la url
                                            /*
                                            //transformar url a embed
                                            $matches = [];
                                            preg_match("/-(.*?),(.*?),/",$nueva_url,$matches);
                                            $place = $matches[1];
                                            preg_match("/-(.*?),(.*?),/",$nueva_url,$matches);
                                            $lat = '-'.$matches[1];
                                            $long = $matches[2];

                                            //nuevo cambio en la URL, nose que onda
                                            $lat=explode('%',$lat);
                                            $lat=$lat[0];
                                            $long=explode('%',$long);
                                            $long=$long[0];
                                            //fin de transformar url
                                            */
                                            //nueva forma
                                                $nueva_lat=explode('-',$nueva_url);
                                                $valor_lat=explode('!',$nueva_lat[count($nueva_lat)-2]);
                                                $valor_lon=explode('?',$nueva_lat[count($nueva_lat)-1]);

                                                $lat='-'.$valor_lat[0];
                                                $long='-'.$valor_lon[0];
                                            //fin nueva forma

                                                ##forma 3millones
                                            $nueva_url=urldecode($nueva_url);
                                            $matches = [];

                                                
                                                preg_match_all("/[-]+.\d[.]+.[0-9]+\d/m",$nueva_url,$matches);
                                                $lat=$matches[0][count($matches[0])-2];
                                                $long=$matches[0][count($matches[0])-1];   
                                            echo '<hr><iframe src="https://maps.google.com/maps?q='.$lat.','.$long.'&center='.$lat.','.$long.'&zoom=10&output=embed" frameborder="0" width="100%" height="300px"></iframe>';
                                        }
                                        ?>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Moneda</label>
                                    <select name="moneda" id="moneda" class="form-control bg-light border-0 small" placeholder="Moneda"  aria-label="Moneda" aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                                        <option value="">Seleccione...</option>
                                        <option value="peso" <?php if($r['moneda']=="peso"){?> selected <?php }?>>$</option>
                                        <option value="dolar" <?php if($r['moneda']=="dolar"){?> selected <?php }?>>U$D</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Precio</label>
                                    <input type="number" class="form-control" id="precio" name="precio" value="<?php echo $r['precio']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">¿Mostrar precio?</label>
                                    <select name="mostrar_precio" id="mostrar_precio" class="form-control bg-light border-0 small" placeholder="Monstrar precio"  aria-label="Mostrar precio
                                    " aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                                        <option value="">Seleccione...</option>
                                        <option value="si" <?php if($r['mostrar_precio']=="si"){?> selected <?php }?>>SI</option>
                                        <option value="no" <?php if($r['mostrar_precio']=="no"){?> selected <?php }?>>NO</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">¿Destacada?</label>
                                    <select name="destacado" id="destacado" class="form-control bg-light border-0 small" placeholder="Destacada"  aria-label="Destacada
                                    " aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                                        <option value="">Seleccione...</option>
                                        <option value="si" <?php if($r['destacado']=="si"){?> selected <?php }?>>SI</option>
                                        <option value="no" <?php if($r['destacado']=="no"){?> selected <?php }?>>NO</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Descripción</label>
                                    <textarea  class="form-control" type="text" name="descripcion" placeholder="Descripción"  id="descripcion" rows="5"><?php if(!empty($r['descripcion'])) echo base64_decode($r['descripcion']);?></textarea>
                                </div>
                                
                                <input type="hidden" name="id" id="id" value="<?php echo $r['id']; ?>">    
                                <button type="submit" class="btn btn-primary" style="float:right;">Guardar</button>
                                </form>
                            </div>
                        </div>
                    </div>
            

           
            
                     <!-- Page Heading -->
                    <div class="card shadow mb-4 mx-auto" <?php if(empty($_GET['pagina'])) echo "style='display:none;'";?>>
                        <div class="card-header py-3" id="headingTwo">
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Inmuebles activos</h6>
                        </div>
                        <div id="collapseListado" class="collapse <?php echo $showtable; ?>" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                    <table class="table table-striped table-bordered display nowrap" id="dataTable-mensajes" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Cod.</th>
                                        <th>Título</th>
                                        <th>Ubicación</th>
                                        <th>Precio</th>
                                        <th>Tipo</th>
                                        <th>Operación</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Cod.</th>
                                        <th>Título</th>
                                        <th>Ubicación</th>
                                        <th>Precio</th>
                                        <th>Tipo</th>
                                        <th>Operación</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $q=mysqli_query($con,"select i.*, ti.nombre as tipo, top.nombre as operacion from inmuebles i, tipos_inmuebles ti, tipos_operaciones top where i.tipo_inmueble=ti.id and i.tipo_operacion=top.id and i.activo='si' order by i.id desc"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){
                                                    if($r['moneda']=='peso')
                                                        $moneda='$';
                                                    else
                                                        $moneda='U$D';
                                                    ?>
                                                 <tr>
                                                    <td><?php echo $r['id']; ?></td>
                                                    <td><?php echo $r['titulo']; ?></td>
                                                    <td><?php echo $r['ubicacion']; ?></td>
                                                    <td><?php echo $moneda.number_format($r['precio'],0,',','.'); ?></td>
                                                    <td><?php echo $r['tipo']; ?></td>
                                                    <td><?php echo $r['operacion']; ?></td>
                                                    <td>
                                                        <a href="home.php?pagina=inmuebles&ver=<?php echo $r['id'] ?>" title="Editar" alt="Editar"><i class="fas fa-edit icono_editar"></i></a> 
                                                        <a href="javascript:if(confirm('Esta Seguro?')){ window.location='home.php?pagina=inmuebles&desactivar=<?php echo $r['id'] ?>'; }" title="Desactivar" alt="Desactivar"><i class="fas fa-eraser icono_borrar"></i></a>
                                                        <a href="#" onclick="a=window.open('modulos/fotos_inmuebles.php?id=<?php echo $r['id']; ?>','Permisos','width=1024,height=500,scrollbars=1'); a.moveTo(250,150)"><i class="fas fa-image icono_fotos"></i></a>
                                                        <a href="#" onclick="a=window.open('https://www.facebook.com/sharer/sharer.php?u=http://marcelomarini.com.ar/modulos/ficha_fb.php?id=<?php echo $r['id']; ?>','Compartir','width=1024,height=500,scrollbars=1'); a.moveTo(250,150)"><i class="fab fa-facebook"></i></a>

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

function campos_inmuebles(id)
{
    $.get("modulos/campos_inmuebles_listar.php?id="+id, function (dato) {
        $("#campos_mostrar").html(dato);
      });    
}
</script>
<?php
//Funcion para expandir URL bitly
function expandir_url($url){
    //Get response headers
    $response = get_headers($url, 1);
    //Get the location property of the response header. If failure, return original url
    if (array_key_exists('Location', $response)) {
        $location = $response["Location"];
        if (is_array($location)) {
            // t.co gives Location as an array
            return expandir_url($location[count($location) - 1]);
        } else {
            return expandir_url($location);
        }
    }
    return $url;
}
?>