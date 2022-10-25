 <?php
session_start();
//include("conexion.php");
//conectar(); 
//include ("funciones.php");

if($_SESSION[user]==0)
{
    echo "<script>window.location='index.php';</script>";
}
    else
    {
        $sql=mysqli_query($con,"select *from clientes where id=".intval($_GET['id']));
        if(mysqli_num_rows($sql)!=0)
            $r=mysqli_fetch_array($sql); 
    }
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo strtoupper($r['nombre']);?></h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> #<?php echo $r['codigo'];?></a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- box Presupuestos -->
        <?php
        $sql_presupuestos=mysqli_query($con,"select p.*, f.nombre as forma_pago from presupuestos p, formas_pagos f where p.id_cliente=".intval($_GET['id'])." and p.id_forma_pago=f.id and p.eliminado='no' order by p.id desc" );
        $r_presupuestos=mysqli_fetch_array($sql_presupuestos);
        ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="home.php?pagina=ficha_cliente&id=<?php echo intval($_GET['id'])?>&modulo=ficha_cliente_presupuestos" style="text-decoration: none; color: gray;">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Presupuestos
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo mysqli_num_rows($sql_presupuestos);?></div>
                                        <span><?php if(!empty($r_presupuestos['fecha'])) echo date('d-m-Y',strtotime($r_presupuestos['fecha'])); else echo "-";?></span>
                                    </div>
                                    <div class="col">
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Compras -->
        <?php
        $sql_compras=mysqli_query($con,"select SUM(monto) as monto from clientes_compras where id_cliente=".intval($_GET['id'])." order by id desc");
        $r_compras=mysqli_fetch_array($sql_compras);
        ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="home.php?pagina=ficha_cliente&id=<?php echo intval($_GET['id'])?>&modulo=ficha_cliente_compras" style="text-decoration: none; color: gray;">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Compras</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if(!empty($r_compras['monto'])) echo '$'.number_format($r_compras['monto'],2,',','.'); else echo "-";?></div>
                                <span>al <?php echo date('d-m-Y');?></span>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pagos -->
        <?php
        $sql_pagos=mysqli_query($con,"select SUM(monto) as monto from clientes_pagos where id_cliente=".intval($_GET['id'])." order by id desc");
        $r_pagos=mysqli_fetch_array($sql_pagos);
        ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="home.php?pagina=ficha_cliente&id=<?php echo intval($_GET['id'])?>&modulo=ficha_cliente_pagos" style="text-decoration: none; color: gray;">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pagos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if(!empty($r_pagos['monto'])) echo '$'.number_format($r_pagos['monto'],2,',','.'); else echo "-";?></div>
                          <span>al <?php echo date('d-m-Y');?></span>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        </div>

        <!-- Saldo -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Saldo Total</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php $total=$r_compras['monto']-$r_pagos['monto']; echo '$'.number_format($total,2,',','.');?></div>
                            <span>al <?php echo date('d-m-Y');?></span>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
</div>                    
<?php 
    //cargo los modulos de la ficha del cliente
    if($_GET['modulo']!="") include("modulos/".$_GET['modulo'].".php"); 
?>