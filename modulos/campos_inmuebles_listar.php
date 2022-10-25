<?php
session_start();
include("../conexion.php");
conectar(); 

if($_GET['id']!="")
{
	$qc=mysqli_query($con, "select *from campos_inmuebles where id_tipo_inmueble=".$_GET['id']." order by linea,id");
		if(mysqli_num_rows($qc)!=0)
		{
			while($r=mysqli_fetch_array($qc))
			{
				if($r[etiqueta]=="balcon")
				{?>
				<div class="form-group">
                    <label for="nombre"><?php echo $r['etiqueta'];?></label>	
					<select id="<?php echo $r['nombre_input'];?>" name="<?php echo $r['nombre_input'];?>" class="form-control bg-light border-0 small" placeholder="Balcón"  aria-label="Balcón" aria-describedby="basic-addon2" style="margin-right: 1%;">
						<option value="">Seleccione...</option>
						<option value="balcon_frente">Frente</option>
						<option value="balcon_contrafrente">Contra Frente</option>
						<option value="balcon_lateral">Lateral</option>
					</select>
				</´div>

				<?php
				}
				else
				{
					$type="";
							if($r['tipo_dato']==0)
								$type="number";
							else
								$type="text";
				?>
				<div class="form-group">
                    <label for="nombre"><?php echo ucfirst($r['nombre_mostrar']);?></label>
                    <input type="<?php echo $type; ?>" class="form-control" id="<?php echo $r['nombre_input'];?>" name="<?php echo $r['nombre_input'];?>" value=""><i><?php echo $r['unidad'];?></i>
				</div>
				<?php
				}
			}
		}
			else
			{
				echo "<p style='color:#ff0000'>Sin Datos</p>";
			}
}
	else
	{
		echo "<p style='color:#ff0000'>Seleccione un tipo de inmueble</p>";
	}
?>