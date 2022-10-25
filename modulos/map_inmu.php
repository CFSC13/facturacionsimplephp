<?php
include("../conexion.php");
conectar();
session_start();

if($_GET['add']!="")
{
$p=explode("(",$_POST['posi']);
$pos=explode(", ",$p[1]);
$_SESSION['lat']=$pos[0];
$pos2=explode(")",$pos[1]);
$_SESSION['lon']=$pos2[0];
echo "<p style='color:red;'>Posicion Guardada Correctamente!!!</p>";
}
else
{
?>
<html>
<head>
</head>
<body>
<div id="map" style="width: 100%; height: 300px;"></div> 
<!-- Llave de GoogleMaps-->
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxg0nVWqSbx0KhLtP_W3p2EuP_nY2gepE&callback=initMap"></script>
<!--<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>-->

<script type="text/javascript"> 

var g = google.maps;
// var latlng = new google.maps.LatLng(-27.35968526256483, -55.93839148181155);
<?php if($_GET['ver2']!=""){ 
	$_SESSION['lat']="";
	$_SESSION['lon']="";
	if(!empty($_GET['lat']) && !empty($_GET['lon']))
	{
?>
var myLatLng = new google.maps.LatLng(<?php echo $_GET['lat'];?>,<?php echo $_GET['lon'];?>);
<?php 
	}
		else
		{
				?>
				var myLatLng = new google.maps.LatLng('-27.364445348284868','-55.91646174090579');

				<?php
		}
}else{
$lat="-27.364445348284868";
$lon="-55.91646174090579";
?>	
  var myLatLng = new google.maps.LatLng(<?php echo $lat;?>,<?php echo $lon;?>);
<?php }?>
    var myOptions = {
      zoom: 15,
      center: myLatLng,
      mapTypeId: google.maps.MapTypeId.TERRAIN
    };

    var bermudaTriangle;

    var map = new google.maps.Map(document.getElementById("map"),
        myOptions);
  
google.maps.event.addListener(map, "click", function(event){
     getColor(event);
});

<?php if($_GET['ver2']!=""){ ?>
getColor(true);
<?php }?>

function getColor(event) {
<?php if(!empty($_GET['lat']) && !empty($_GET['lon'])){ ?>
var latLng =new google.maps.LatLng(<?php echo $_GET['lat'];?>,<?php echo $_GET['lon'];?>);
<?php }else{?>
var latLng =event.latLng;
<?php }?>

var marker = new google.maps.Marker({
    map:map,
    draggable:true,
    position: latLng
  });
	
google.maps.event.addListener(marker, "dragend", function(event) {
	
<?php if($_GET['ver2']!=""){ ?>
var latLng =event.latLng;
<?php }?>
//var latLng =event.latLng;
	nose(latLng);
});

}
		
</script> 
<form action="map_inmu.php?add=ok" method="POST">
<input type="hidden" id="posi" name="posi"/>
<div id="cargar"></div>
</form>
</body>							   
</html>
<?php }?>
<script type="text/javascript">
function nose(a)
{
	document.getElementById("posi").value=a;
	document.getElementById("cargar").innerHTML='<button type="submit">Guardar Posicion</button>';
}
</script>