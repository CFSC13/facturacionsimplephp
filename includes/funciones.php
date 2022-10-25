<?php
function ids($con,$tabla)
{
	$sql=mysqli_query($con,"select MAX(id) as id from $tabla");
	if(mysqli_num_rows($sql)!=0)
	{
		$r=mysqli_fetch_array($sql);
		$sum=$r['id']; $sum++;
		return $sum;
	}
		else
		{
			return 1;
		}
}

function fotos($tabla,$nombre,$carpeta,$mod)
{
	if($mod==0)
	{
		$sql=mysqli_query($con,"select MAX(id) as mas from $tabla");
		$r=mysqli_fetch_array($sql);
		$nuevo=$r[mas];
	}	
		else
		{
			$nuevo=$mod;
		}
		
		$archivo=$_FILES[$nombre]['name'];
		if($archivo!="")
		{
		$extension = explode(".",$archivo);
				//subo la imagen
				if(($extension[1]=="jpg")||($extension[1]=="JPG")||($extension[1]=="JPEG")||($extension[1]=="jpeg")||($extension[1]=="png"))
				{
					if (is_uploaded_file($_FILES[$nombre]['tmp_name'])) 
		  			{
						if(copy($_FILES[$nombre]['tmp_name'], $carpeta."/".$nuevo.".".$extension[1]))
						{				
							return true;
						}
							else
							{
								return false; 	
							}
					}						
					
				}
		}
			else
			{
				return true;
			}		
					
}


function rubro($id)
{
	$sql=mysqli_query($con,"select *from rubros where id=$id");
		if(mysqli_num_rows($sql)!=0)
		{
			$r=mysqli_fetch_array($sql);
			echo $r[nombre];
		}
			else{echo "Sin Datos";}
}

function personas($id)
{
	$sql=mysqli_query($con,"select nombre from productos where id=$id");
	if(mysqli_num_rows($sql)!=0)
	{
		$r=mysqli_fetch_array($sql);
		echo "<strong>$r[nombre]</strong>";
	}
}

 function ordeno($id, $pos)
 {
 	$q_sumar=mysqli_query($con,"select *from banners where posicion >=".$pos);
	if(mysqli_num_rows($q_sumar)>0)
	{
		while($r=mysqli_fetch_array($q_sumar))
		{
			$posi_nueva=$r[posicion];
			$posi_nueva++;
			
			$up=mysqli_query($con,"update banners set posicion=".$posi_nueva." where id=".$r[id]);
		}
	}
	
	$up=mysqli_query($con,"update banners set posicion=".$pos." where id=".$id);
 }
 
  function ordeno_subir($id, $pos)
 {
 	$q_sumar=mysqli_query($con,"select *from banners where posicion=".$pos);
	if(mysqli_num_rows($q_sumar)>0)
	{
		while($r=mysqli_fetch_array($q_sumar))
		{
			$posi_nueva=$pos;
			$posi_nueva++;
			$nueva=$r[posicion];
			$up=mysqli_query($con,"update banners set posicion=".$posi_nueva." where id=".$r[id]);
		}
	}
	
	$up=mysqli_query($con,"update banners set posicion=".$nueva." where id=".$id);
 }
 
   function ordeno_bajar($id, $pos)
 {
 	$q_sumar=mysqli_query($con,"select *from banners where posicion=".$pos);
	if(mysqli_num_rows($q_sumar)>0)
	{
		while($r=mysqli_fetch_array($q_sumar))
		{
			$posi_nueva=$pos;
			$posi_nueva--;
			$nueva=$r[posicion];
			$up=mysqli_query($con,"update banners set posicion=".$posi_nueva." where id=".$r[id]);
		}
	}
	
	$up=mysqli_query($con,"update banners set posicion=".$nueva." where id=".$id);
 }
 
 function novedades($id_persona,$tipo)
 {
 	if(($id_persona!="")&&($tipo!=""))
	{
		$sql=mysqli_query($con,"insert into novedades (id_persona,tipo,fecha) values($id_persona,'".$tipo."',now())");
	}
 }
 
function sendemail2 ($to, $subject, $email_message, $from,$adpost='0',$se='',$omit='', $img)
{
    
    $admin_email=$from;
    
		/*	if($adpost==1)
			{
			
				foreach($_POST as $key => $val)
				{
												
					if(!in_array($key,$omit))
					{
					if($val!="")
					{		

					$values.= '<p>'.$key.": ".$val.chr(10).'</p>';
					} 
						else
								{
								$msg="Debe Completar todos los campos";
								}
					}
				}
				$email_message.=$values;
			}*/
			$admin_email='newsletters@gatvip.com.ar';
                        $headers = "From: $admin_email \r\n";
   
                        $headers .= "Reply-To:  $admin_email \r\n".

                        $headers .= 'X-Mailer: PHP/' . phpversion().''. "\r\n" .

                        'MIME-Version: 1.0' . "\r\n".

                        'Content-type: text/html; charset=iso-8859-1' . "\r\n".

                        'Content-Transfer-Encoding: 8bit';

                        $headers .= "Return-path: ".$admin_email ;

	//	$email_message='<img src="http://www.renovacionmur.com.ar/archivos/mensaje.JPG" />';
        
            $email_message = get_email_temp(html_entity_decode(stripcslashes($email_message)));
			if($img!="")
			{
			$email_message.='<img src="http://www.gatavip.com.ar/admin/mail.jpg" />';		
			}
					@mail ($to, $subject, $email_message, $headers) ;
					
				//	echo "<script>window.location='".$se."'/script>";
} 

function get_email_temp($cont){
$content='
 <style type="text/css">

                        *{
                           font: 62.5% Verdana, Tahoma, Arial, Helvetica, sans-serif;
                        }

                        #container{
                        width: 1000px; 
                        margin: 0 10px 1em 10px;
                        }

                        #container p{
                            font-size: 12px;
                            margin-bottom: 15px;
                            margin-left: 5px;
                            color:#0D2B43;
                        }
                        #container h2{
                            background-color:#F3F3F3;
                            width:100%;
                            margin:10px 0 5px 0;
                            padding-left:20px;
                            line-height:35px;
                            font-family:Arial, Helvetica, sans-serif;
                            font-size:15px;
                            color:#0D2B43;
                        }

                        #container a{
                        text-decoration: none;
                        color: #387AE3;}

                        #container a:hover{
                        text-decoration: underline;
                        color: #387AE3;}

                        </style>
<div id="header">
</div>
<div id="container">
'.$cont.'
</div>
';
return $content;
}
 
function productos($id)
{
	$sql=mysqli_query($con,"select nombre from productos where id=$id");
	if(mysqli_num_rows($sql)!=0)
	{
		$r=mysqli_fetch_array($sql);
		echo $r[nombre];
	}
}

function datos($con,$tabla,$atributo,$id)
{
	echo "select $atributo from $tabla where id=$id";
	$sql=mysqli_query($con,"select $atributo from $tabla where id=$id");
	if(mysqli_num_rows($sql)!=0)
	{
		$r=mysqli_fetch_array($sql);
		return $r[$atributo];
	}
		else
		{
			return "-";
		}
}


function comprobar_email($email){ 
    $mail_correcto = 0; 
   
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){ 
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) { 
         
          if (substr_count($email,".")>= 1){ 
           
             $term_dom = substr(strrchr ($email, '.'),1); 
             
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){ 
              
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1); 
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1); 
                if ($caracter_ult != "@" && $caracter_ult != "."){ 
                   $mail_correcto = 1; 
                } 
             } 
          } 
       } 
    } 
    if ($mail_correcto) 
       return 1; 
    else 
       return 0; 
}

function atributo($tabla,$atributo,$id)
{
	$sql=mysqli_query($con,"select $atributo from $tabla where id=$id");
	if(mysqli_num_rows($sql)!=0)
	{
		$r=mysqli_fetch_array($sql);
		return $r[$atributo];
	}
		else{return "Sin Datos";}

}

function fechas($fe)
{
	$fecha=$fe[8].$fe[9]."/".$fe[5].$fe[6]."/".$fe[0].$fe[1].$fe[2].$fe[3];
	return $fecha;
}

function fechas_base($fe)
{
	$fecha=$fe[6].$fe[7].$fe[8].$fe[9]."-".$fe[3].$fe[4]."-".$fe[0].$fe[1];
	return $fecha;
}

function operaciones($id)
{
	$sql=mysqli_query($con,"select *from tipos_operaciones where id=$id");
	if(mysqli_num_rows($sql)!=0)
	{
		$r=mysqli_fetch_array($sql);
		return $r[nombre];
	}
}

function tipos($id)
{
	$sql=mysqli_query($con,"select *from tipos_inmuebles where id=$id");
	if(mysqli_num_rows($sql)!=0)
	{
		$r=mysqli_fetch_array($sql);
		return $r[nombre];
	}
}

function datos_complejos($tabla,$atributo,$comparar,$id)
{
	if(!empty($id))
	{
		$sql=mysqli_query($con,"select $atributo from $tabla where $comparar=$id");
		if(mysqli_num_rows($sql)!=0)
		{
			$r=mysqli_fetch_array($sql);
			return $r[$atributo];
		}
			else
			{
				return "Sin Datos";
			}
	}
		else
		{
			echo "-";
		}
}

function datos_complejos1($con,$tabla,$atributo,$comparar,$id)
{
	if(!empty($id))
	{
		$sql=mysqli_query($con,"select $atributo from $tabla where $comparar=$id");
		if(mysqli_num_rows($sql)!=0)
		{
			$r=mysqli_fetch_array($sql);
			return $r[$atributo];
		}
			else
			{
				return "Sin Datos";
			}
	}
		else
		{
			echo "-";
		}
}

//NUEVO 2014
function documentos($nombre_archivo,$nombre,$carpeta)
{
	$archivo=$_FILES[$nombre]['name'];
	if($archivo!="")
	{
		$extension = end(explode(".", $archivo));
			//subo la imagen
			if(($extension=="jpg")||($extension=="pdf")||($extension=="rtf")||($extension=="jpeg")||($extension=="png")||($extension=="doc")||($extension=="odt")||($extension=="docx"))
			{
				if (is_uploaded_file($_FILES[$nombre]['tmp_name'])) 
				{
					if(copy($_FILES[$nombre]['tmp_name'], $carpeta."/".$nombre_archivo.".".$extension))
					{				
						return true;
					}
						else
						{
							return false; 	
						}
				}										
			}
	}
		else
		{
			return true;
		}							
}
?>