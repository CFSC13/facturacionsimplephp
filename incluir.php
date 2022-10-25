<?php 
session_start();
//controlo la sesión del usuario
if($_SESSION['user']==0)
{
    echo "<script>window.location='index.php';</script>";
}
//conecto a la BD
include("includes/conexion.php");
conectar();
//cargo Fx
include("includes/funciones.php");
?>

<style type="text/css">
.icono_borrar{
    color: #E40000;
}
.icono_fotos{
    color: #22C01F;
}
.icono_editar{
    color: #09C6C6;
}
.icono_permisos{
    color: yellowgreen;
}
.icono_activar{
    color: greenyellow;
}
.m-0{
    cursor: pointer;
}
</style>