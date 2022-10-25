<?php
if($_SESSION['user']==1)
{
	$sql=mysqli_query($con,"select i.*, gm.icono from items_interno i, grupos_menu gm where i.id_grupo=gm.id_grupo order by i.id_grupo, i.nombre_item");
	
}
	else
	{
		$sql=mysqli_query($con, "select i.*, gm.icono from items_interno i, items_x_usuario iu, usuarios u, grupos_menu gm where i.id_grupo=gm.id_grupo and iu.id_item=i.id_item and iu.id_usuario=u.id_usuario and u.id_usuario=".$_SESSION['user']." order by i.id_grupo, i.nombre_item");
	}		

		$grupo=0;
		$total=mysqli_num_rows($sql);
		while($r=mysqli_fetch_array($sql))
		{
			if($r['id_grupo']!=$grupo)
			{
				if($grupo!=0)
				{
					?>
					</div>
		            </div>
		            	</li>
					<?php
				}
				?>
				<li class="nav-item">
		          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo<?php echo $r['id_grupo'];?>"
		              aria-expanded="true" aria-controls="collapseTwo<?php echo $r['id_grupo'];?>">
		              <i class="<?php echo $r['icono'];?>"></i>
		              <span><?php echo ucfirst(datos_complejos1($con, "grupos_menu","nombre_grupo","id_grupo",$r['id_grupo']));?></span>
		          </a>
		          <div id="collapseTwo<?php echo $r['id_grupo'];?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
		              <div class="bg-white py-2 collapse-inner rounded">
				<?php
				$grupo=$r['id_grupo'];	
			}
			$ur=explode(".",$r['url']);
			?>
			<a class="collapse-item" href="home.php?pagina=<?php echo $ur[0]; ?>"><?php echo ucfirst(datos_complejos1($con, "items_interno","nombre_item","id_item",$r['id_item']));?></a>
			<?php
		}
		?>
		</div>
         </div>
         	</li>