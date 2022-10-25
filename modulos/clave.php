 <?php
session_start();
if($_SESSION[user]==0)
{
    echo "<script>window.location='index.php';</script>";
}
?>
<?php
if($_GET[mod]=="ok")
{

    if(($_POST['clave_actual']!=$_POST['clave_nueva']) && !empty($_POST['clave_nueva']))
    {
                    
            $sql=mysqli_query($con,"update usuarios set clave='$_POST[clave_nueva]' where id_usuario=$_POST[id]");

            if(!mysqli_error())
            {
               
                echo "<script>alert('Registro Modificado Correctamente.');</script>";
                echo "<script>window.location='home.php?pagina=clave';</script>";
            }
                else
                {
                    echo "<script>alert('Error: No se pudo Modificar el registro.');</script>";
                }
        
    }
        else
        {
            echo "<script>alert('La clave nueva debe ser distinta a la actual(*).');</script>";
        }
}
?>

<div class="tab-content" id="nav-tabContent">                  
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
       <div id="accordion">
             <!-- Page Heading -->
                <div class="card shadow mb-4" id="headingOne">
                    <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">Gestionar clave</h6>
                    </div>
       
       <?php
                $showform="show";
                $sql=mysqli_query($con,"select *from usuarios where id_usuario=$_SESSION[user]");
                if(mysqli_num_rows($sql)!=0)
                {   
                    $r=mysqli_fetch_array($sql);
                }
                    $url="home.php?pagina=clave&mod=ok";
                    $showform="show";
            ?>
                <div id="collapseNuevo" class="collapse <?php echo $showform; ?> m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                    <div class="card-body" >
       
                        <form action="<?php echo $url; ?>" method="POST">
                        <!--Fila 1-->
                        <div class="form-group">
                            <label for="nombre">Clave actual</label>
                            <input type="text" class="form-control" id="clave_actual" name="clave_actual" value="<?php echo $r['clave']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nueva clave</label>
                            <input type="text" class="form-control" id="clave_nueva" name="clave_nueva" required>
                        </div>

                        <input type="hidden" name="id" id="id" value="<?php echo $r['id_usuario']; ?>">    
                        <button type="submit" class="btn btn-primary" style="float:right;">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>