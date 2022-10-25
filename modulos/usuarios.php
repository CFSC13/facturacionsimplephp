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
    if($_POST[nombre]!="" && $_POST[usuario]!="" && $_POST[clave]!="" && $_POST[roles]!="")
    {
        $sql=mysqli_query($con,"insert into usuarios (nombre,usuario,clave,id_area,correo) values(lower('$_POST[nombre]'),'$_POST[usuario]','$_POST[clave]',$_POST[roles],lower('$_POST[correo]'))");
            if(!mysqli_error())
            {
                echo "<script>alert('Registro Insertado Correctamente')</script>";
            }
                else
                {
                    echo "<script>alert('Error: No se pudo insertar el registro');</script>";
                }
    }
        else
        {
            echo "<script>alert('No Deje Campos Vacios');</script>";
        }
        
    echo "<script>window.location='home.php?pagina=usuarios'</script>"; 
}

if($_GET[mod]=="ok")
{
    if($_POST[nombre]!="" && $_POST[usuario]!="" && $_POST[clave]!="" && $_POST[roles]!="")
    {
        $sql=mysqli_query($con,"update usuarios set nombre=lower('$_POST[nombre]'), usuario='$_POST[usuario]', clave='$_POST[clave]', id_area=$_POST[roles], correo='$_POST[correo]' where id_usuario=$_POST[id]");
        if(!mysqli_error())
        {
            echo "<script>alert('Registro Actualizado Correctamente.');</script>";
        }
            else
            {
                echo "<script>alert('Error: No se pudo Actualizar el registro.');</script>";
            }
    }
        else
        {
            echo "<script>alert('No deje Campos Vacios.');</script>";
        }
        
    echo "<script>window.location='home.php?pagina=usuarios'</script>";
}
?>

  <div class="tab-content" id="nav-tabContent">
                           
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
               <div id="accordion">
                     <!-- Page Heading -->
                        <div class="card shadow mb-4" id="headingOne">
                            <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">Nuevo Usuario</h6>
                            </div>
               
               <?php
                        $showform="";
                        $showtable="";
                        if($_GET[ver]!=0)
                        {
                            $sql=mysqli_query($con,"select *from usuarios where id_usuario=$_GET[ver]");
                                if(mysqli_num_rows($sql)!=0)
                                {   
                                    $r=mysqli_fetch_array($sql);
                                }
                                $url="home.php?pagina=usuarios&mod=ok";
                                $showform="show";
                        }
                            else
                            {
                                $url="home.php?pagina=usuarios&add=ok";
                                $showtable="show";
                            }
                    ?>
                        <div id="collapseNuevo" class="collapse <?php echo $showform; ?> m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                            <div class="card-body" >
               
                                <form action="<?php echo $url; ?>" method="POST">
                                    <div class="form-row">

                                            <div class="form-group col-md-6">
                                                <label for="roles">Areas</label>
                                                <select id="roles" class="form-control" name="roles" required>
                                                    <option value="">Seleccione...</option>
                                                    <?php
                                                    $sql_in=mysqli_query($con,"select *from areas order by nombre_area");
                                                    if(mysqli_num_rows($sql_in)>0)
                                                    {
                                                        while($r_in=mysqli_fetch_array($sql_in))
                                                        {
                                                            ?>
                                                            <option value="<?php echo $r_in[id_area]?>" <?php if($r[id_area]==$r_in[id_area]){?> selected="selected"<?php }?>><?php echo $r_in[nombre_area]?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="nombre">Nombre</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre" required value="<?php echo $r['nombre'] ?>">
                                            </div>

                                    </div>
                                    <div class="form-row">
                                        <!--Fila 2-->
                                        <div class="form-group col-md-6">
                                            <label for="usuario">Usuario</label>
                                            <input type="text" class="form-control" id="usuario" name="usuario" required value="<?php echo $r['usuario']; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="clave">Clave</label>
                                            <input type="text" class="form-control" id="clave" name="clave" required value="<?php echo $r['clave']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <!--Fila 3-->
                                        <div class="form-group col-md-6">
                                            <label for="correo">Email</label>
                                            <input type="email" class="form-control" id="correo" required name="correo" value="<?php echo $r['correo']; ?>">
                                        </div>
                                       
                                    </div>

                                <input type="hidden" name="id" id="id" value="<?php echo $r['id_usuario']; ?>">    
                                <button type="submit" class="btn btn-primary" style="float:right;">Guardar</button>
                                </form>
                            </div>
                        </div>
                    </div>
            

           
            
                     <!-- Page Heading -->
                    <div class="card shadow mb-4 mx-auto" >
                        <div class="card-header py-3" id="headingTwo">
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Usuarios</h6>
                        </div>
                        <div id="collapseListado" class="collapse <?php echo $showtable; ?>" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                    <table class="table table-bordered display nowrap" id="dataTable-mensajes" width="100%" cellspacing="0">
                                    <thead>
                                    
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Grupo</th>
                                        <th>Email</th>
                                      
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Grupo</th>
                                        <th>Email</th>
                                      
                                        <th>Opciones</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $q=mysqli_query($con,"select u.id_usuario,u.nombre,i.nombre_area as inmo, u.correo from usuarios u, areas i where u.id_area=i.id_area order by i.nombre_area, u.nombre"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                 <tr>
                                                     <td><?php echo $r['nombre']; ?></td>
                                                     <td><?php echo $r['inmo']; ?></td>
                                                     <td><?php echo $r['correo']; ?></td>
                                                     <td><a href="home.php?pagina=usuarios&ver=<?php echo $r['id_usuario'] ?>" title="Editar" alt="Editar"><i class="fas fa-edit icono_editar"></i></a> 
                                                     <a href="#" onclick="a=window.open('modulos/items_x_usuarios.php?id=<?php echo $r[id_usuario]; ?>','Permisos','width=1024,height=500,scrollbars=1'); a.moveTo(250,150)"><i class="fas fa-shield-alt icono_permisos"></i></a>
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



      <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

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

  $("#permisosModal").val();
</script>

