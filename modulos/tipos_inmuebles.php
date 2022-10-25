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
	
	if($_POST[nombre]!="")
	{
		$sql=mysqli_query($con,"insert into tipos_inmuebles (nombre) values(lower('$_POST[nombre]'))");
		if(!mysqli_error())
		{
			echo "<script>alert('Registro Insertado Correctamente.');</script>";
			echo "<script>window.location='home.php?pagina=tipos_inmuebles';</script>";
		}
			else
			{
				echo "<script>alert('Error: No se pudo insertar el registro.');</script>";
			}
	}
		else
		{
			echo "<script>alert('No deje Campos Vacios.');</script>";
		}
}

if($_GET[mod]=="ok")
{

	if($_POST[nombre]!="")
	{
		$sql=mysqli_query($con,"update tipos_inmuebles set nombre=lower('$_POST[nombre]') where id=$_POST[id]");
		
		if(!mysqli_error())
		{
			echo "<script>alert('Registro Actualizado Correctamente.');</script>";
			echo "<script>window.location='home.php?pagina=tipos_inmuebles';</script>";
		}
			else
			{
				echo "<script>alert('Error: No se pudo insertar el registro.');</script>";
			}
	}
		else
		{
			echo "<script>alert('No deje Campos Vacios.');</script>";
		}
}
?>
 <div class="tab-content" id="nav-tabContent">
                           
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
               <div id="accordion">
                     <!-- Page Heading -->
                        <div class="card shadow mb-4" id="headingOne">
                            <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">Nuevo Registro</h6>
                            </div>
               
               <?php
                        $showform="";
                        $showtable="";
                        if($_GET[ver]!=0)
                        {
                            $sql=mysqli_query($con,"select *from tipos_inmuebles where id=$_GET[ver]");
                                if(mysqli_num_rows($sql)!=0)
                                {   
                                    $r=mysqli_fetch_array($sql);
                                }
                                $url="home.php?pagina=tipos_inmuebles&mod=ok";
                                $showform="show";
                        }
                            else
                            {
                                $url="home.php?pagina=tipos_inmuebles&add=ok";
                                $showtable="show";
                            }
                    ?>
                        <div id="collapseNuevo" class="collapse <?php echo $showform; ?> m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                            <div class="card-body" >
               
                                <form action="<?php echo $url; ?>" method="POST">
                                <!--Fila 1-->
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $r['nombre']; ?>" required>
                                </div>

                                <input type="hidden" name="id" id="id" value="<?php echo $r['id']; ?>">    
                                <button type="submit" class="btn btn-primary" style="float:right;">Guardar</button>
                                </form>
                            </div>
                        </div>
                    </div>
            

           
            
                     <!-- Page Heading -->
                    <div class="card shadow mb-4 mx-auto" >
                        <div class="card-header py-3" id="headingTwo">
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Listado</h6>
                        </div>
                        <div id="collapseListado" class="collapse <?php echo $showtable; ?>" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                    <table class="table table-bordered display nowrap" id="dataTable-mensajes" width="100%" cellspacing="0">
                                    <thead>
                                    
                                    <tr>
                                        <th>Nombre</th>
                                      
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                      
                                        <th>Opciones</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $q=mysqli_query($con,"select * from tipos_inmuebles order by nombre"); 
                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                 <tr>
                                                     <td><?php echo $r['nombre']; ?></td>
                                                     <td><a href="home.php?pagina=tipos_inmuebles&ver=<?php echo $r['id'] ?>" title="Editar" alt="Editar"><i class="fas fa-edit icono_editar"></i></a> 
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
</script>

