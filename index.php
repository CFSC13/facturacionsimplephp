<?php
session_start();
include("includes/conexion.php");
conectar();

error_reporting(E_ALL);
ini_set('display_errors', '0');

if($_GET['login']=="ok")
{
    if(($_POST['usuario']!="")&&($_POST['clave']!=""))
    {
        $sql=mysqli_query($con, "select *from usuarios where usuario='".addslashes($_POST['usuario'])."' and clave='".addslashes($_POST['clave'])."'");
    
            if(mysqli_num_rows($sql)!=0)
            {   
                $r=mysqli_fetch_array($sql);
                $_SESSION['user']=$r['id_usuario'];
                $_SESSION['nombre']=$r['nombre'];
                $_SESSION['id_area']=$r['id_area'];
                echo "<script>window.location='home.php'</script>";
            }
                else
                {
                    echo "<script>alert('Usuario o Clave Incorrecta.');</script>";
                }
    }
        else
        {
            echo "<script>alert('Ingrese su Usuario y Clave para Comenzar.');</script>";
        }
    echo "<script>window.location='index.php'</script>";    
        
}

if($_GET[logout]=="ok")
{
    session_destroy();  
    echo "<script>window.location='index.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Distribuidora Lucas - Sistema de Gestión">
    <meta name="author" content="ADM">

    <title>Facturación Simple - Sistema de Gestión</title>

    <!-- Custom fonts for this template-->

    <link rel="shortcut icon" href="img/logo_mmtrico4.png">

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-7 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                           
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="img/logo_mmtr.png" style="width:70%;">
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <h2 class="h5 text-gray-900 mb-4">Bienvenido</h2>
                                    </div>
                                    <form class="user" method="post" action="index.php?login=ok">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="usuario" name="usuario" aria-describedby="emailHelp"
                                                placeholder="Ingrese su usuario">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="clave" name="clave" placeholder="Ingrese su clave">
                                        </div>
                                      <!--  <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>-->
                                        <button class="btn btn-primary btn-user btn-block">Iniciar Sesión</button>
                                        <!--<hr>
                                        <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>-->
                                    </form>
                                    <!--
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="blanquear_clave.html">Olvidé mi contraseña!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Crear cuenta!</a>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!--Logo del pie-->
             <!--<div class="text-center">
                <a href="https://marcelomarini.com.ar/" target="_blank"><img src="img/logo_mm.png" style="width:20%;"></a>
            </div>-->
            <!--Fin Logo del pie-->
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

</body>

</html>