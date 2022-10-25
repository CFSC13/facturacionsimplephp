 <?php
session_start();

if($_SESSION[user]==0)
{
    echo "<script>window.location='index.php';</script>";
}
?>
 <div class="tab-content" id="nav-tabContent">
                           
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
               <div id="accordion">
                     <!-- Page Heading -->
                        <div class="card shadow mb-4" id="headingOne">
                            <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">Historial Precios</h6>
                            </div>
               
               <?php
                        $showform="show";
                        $showtable="";
                      
                                $url="home.php?pagina=reporte_precios&bus=ok";
                                $showtable="show";
                            
                    ?>
                        <div id="collapseNuevo" class="collapse <?php echo $showform; ?> m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                            <div class="card-body" >
               
                                <form action="<?php echo $url; ?>" method="POST">
                                <!--Fila 1-->
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
                                                <option data-precio="<?php echo $r_g[precio]; ?>" data-cod="<?php echo $r_g[codigo]; ?>" value="<?php echo $r_g['id'];?>" <?php if($_POST['productos']==$r_g[id]) echo "selected"; ?>><?php echo $r_g['codigo']." - ".$r_g['marca']." - ".$r_g['nombre'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="nombre">Fecha Desde</label>
                                    <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" value="<?php echo $_POST['fecha_desde']; ?>" >
                                </div>

                                <div class="form-group">
                                    <label for="nombre">Fecha Hasta</label>
                                    <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" value="<?php echo $_POST['fecha_hasta']; ?>" >
                                </div>

                                 
                                <button type="submit" class="btn btn-primary" style="float:right;">Buscar</button>
                                </form>
                            </div>
                        </div>
                    </div>
            

           
            
                     <!-- Page Heading -->
                    <div class="card shadow mb-4 mx-auto" >
                        <div class="card-header py-3 row align-items-start m-0" id="headingTwo">
                        <h6 class="m-0 font-weight-bold text-primary col" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Listado</h6>
                        <p class="text-right"><button type="button" id="descargar" class="btn btn-success d-none">Descargar</button></p>
                        </div>
                        <div id="collapseListado" class="collapse <?php echo $showtable; ?>" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                    <table class="table table-striped table-bordered display nowrap" id="dataTable-mensajes" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Fecha</th>
                                        
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Fecha</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                        if($_GET['bus']!=""){   

                                        $where="";
                                        if($_POST['productos']!="")
                                            $where="id_producto=".$_POST['productos'];

                                        if($_POST['fecha_desde']!=""){
                                            
                                            $where.=($where!="") ? " and date_format(fecha,'%Y-%m-%d')>='$_POST[fecha_desde]'" : "date_format(fecha,'%Y-%m-%d')>='$_POST[fecha_desde]'";
                                        }

                                        if($_POST['fecha_hasta']!="")
                                            $where.=($where!="") ? " and date_format(fecha,'%Y-%m-%d')<='$_POST[fecha_hasta]'" : "date_format(fecha,'%Y-%m-%d')<='$_POST[fecha_hasta]'";            

                                       echo "<script>$('#descargar').removeClass('d-none');</script>";
                                       echo "<script>$('#descargar').on('click',function(){ descargar('".urlencode($where)."'); });</script>";
                                           
                                        $q=mysqli_query($con,"select *, date_format(fecha,'%d/%m/%Y') as fecha from productos_historial_precio where $where"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){
                                                    $rp=mysqli_fetch_array(mysqli_query($con,"select * from productos where id=".$r['id_producto']));
                                                    ?>
                                                 <tr>
                                                    <td><?php echo $rp['nombre']; ?></td>
                                                    <td><?php echo "$".number_format($r['precio'],2,',','.'); ?></td>
                                                    <td><?php echo $r['fecha']; ?></td>
                                                    
                                                   
                                                 </tr>       
                                             <?php }
                                             }
                                        }
                                             ?>       
                                        
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
        function descargar(where){
            window.open("modulos/precios_pdf.php?where="+where);
        }
    </script>