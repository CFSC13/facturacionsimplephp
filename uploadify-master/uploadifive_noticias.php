<?php
session_start();
ini_set('memory_limit', '100M');
ini_set("upload_max_filesize","10M");
ini_set('post_max_size', '10M');

include("../incluir.php");

/*
UploadiFive
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
*/


// Set the uplaod directory
$uploadDir = '/sistema/fotos_noticias/';

// Set the allowed file extensions
$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Allowed file extensions

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
//echo $targetFile;
	// Validate the filetype
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	if (in_array(strtolower($fileParts['extension']), $fileTypes)) {
	$tempFile   = $_FILES['Filedata']['tmp_name'];
	$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;
	
	//$targetFile = $uploadDir . $_FILES['Filedata']['name'];
	

			//nuevo	
			$archivo=$_FILES['Filedata']['name'];
			$extension = explode(".",$archivo);	
	
	$targetFile = $uploadDir .ids($con,"fotos_noticias").".".end($extension);
			
			//$ruta=	str_replace('//','/',$targetPath) .ids("inmu_fotos").".".end($extension);
			
			
			move_uploaded_file($tempFile, $targetFile);
				
			//cambio de img
			//	img(str_replace('//','/',$targetPath),ids("inmu_fotos").".".end($extension),end($extension));								
				img($uploadDir,ids($con,"fotos_noticias").".".end($extension),end($extension));								
			//fin de cambio
				
	$q=mysqli_query($con,"insert into fotos_noticias values(".ids($con,"fotos_noticias").", ".intval($_GET[id]).", '".ids($con,"fotos_noticias").".".end($extension)."',0)");
			//nuevo
			
							
			//move_uploaded_file($tempFile,$targetFile);
			//echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile)." nuevo : ".ids("inmu_fotos").".".end($extension);
	
			chmod($uploadDir, 0755);




		// Save the file
		
		echo 1;


	} else {

		// The file type wasn't allowed
		echo 'Invalid file type.';

	}
}	
	
function img($ruta,$nombre,$ext)
{
$archivo=$ruta.$nombre;  
//Ruta de la original
$rtOriginal=$archivo;
     
//Crear variable de imagen a partir de la original
if($ext=="jpg" || $ext=="JPG")
{
$original = imagecreatefromjpeg($rtOriginal);
}     
if($ext=="png" || $ext=="PNG")
{
$original = imagecreatefrompng($rtOriginal);
}
	list($width, $height) = getimagesize("$archivo");
			list($widthTRUE, $heightTRUE) = getimagesize("$archivo");
		/*	if($width > '640') $width = '640';
			elseif($width <= '640') $width = $width;
			if($height > '480') $height = '480';
			elseif($height <= '480') $height = $height;
 		*/
		$alto_nuevo=(1024*$height)/$width;
			if($width > '1024') $width = '1024';
			elseif($width <= '1024') $width = $width;
			if($height > '768') $height = '768';
			elseif($height <= '768') $height = $height;
//$lienzo=imagecreatetruecolor($width,$height); 
$lienzo=imagecreatetruecolor(1024,$alto_nuevo); 

 
//Copiar $original sobre la imagen que acabamos de crear en blanco ($tmp)
imagecopyresampled($lienzo,$original,0,0,0,0,1024, $alto_nuevo,$widthTRUE,$heightTRUE);
 
//Limpiar memoria
imagedestroy($original);
 
//Definimos la calidad de la imagen final
$cal=90;
 
//Se crea la imagen final en el directorio indicado
if($ext=="jpg" || $ext=="JPG")
{
imagejpeg($lienzo,$archivo,$cal);
}
if($ext=="png" || $ext=="PNG")
{
imagepng($lienzo,$archivo);
}
} 

function marca($ruta,$nombre)
{
 
	// Esta imagen es el logo que se pondra.
	$imagen_logo = imagecreatefrompng("marca.png");
	// Defino ancho, alto del logo.
	$ancho_logo = imagesx($imagen_logo);
	$alto_logo = imagesy($imagen_logo);
	 
	 $nom=$ruta.$nombre;
	// Creo la imagen a cual se le pondra el logo.
	$imagen_dest = imagecreatefromjpeg("$nom");
	// Defino ancho, alto de la imagen que se le colocara el logo.
	$ancho_dest = imagesx($imagen_dest);
	$alto_dest = imagesy($imagen_dest);
	 
	// Defino la posicion donde se mostrara el logo dejando
	// 10 pixeles de espacio. Se mostrara en la parte
	// inferior derecho.
	$ancho_muestra = ($ancho_dest - $ancho_logo) - 10;
	$alto_muestra = ($alto_dest - $alto_logo) - 10;
	 
	//Envio la cabecera para mostrar la imagen.
	header("Content-type: image/jpeg");
	 
	// Sobre pongo el logo a la imagen.
	imagecopyresized($imagen_dest,$imagen_logo,$ancho_muestra,$alto_muestra,0,0,$ancho_logo,$alto_logo,$ancho_logo,$alto_logo);
	 
	// Guardo la imagen que ya tiene el logo.
	imagejpeg($imagen_dest,"$nom",75);
	// Muestro la imagen.
	imagejpeg($imagen_dest,"",75);
	 
	// Destruyo las imagenes.
	imagedestroy($imagen_dest);
	imagedestroy($imagen_logo);
 
}	
?>
