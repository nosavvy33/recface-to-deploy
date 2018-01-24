<?php
//VARIABLES
date_default_timezone_set("America/Lima");
$inicio = date("Y-m-d H:i:s");
$estado = $_POST["estado"];


$servidor = "localhost";
$user = "root";
$pass = "feelingshitty";
$bd = "tests";
$con = new PDO("mysql:host=".$servidor.";dbname=".$bd.";charset=UTF8",$user, $pass);

        $query = $con->prepare("insert into tiempo (tiempo, estado) values (?, ?)");
       	$query->execute([$inicio, $estado]);
     	
     	$query2 = $con->prepare("select * from tiempo order by id desc limit 1");
     	$query2->execute();
     	$rs = $query2->fetch();
     	echo json_encode($rs);
$con = null;
?>