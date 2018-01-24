<?php

require_once "../../common/Conexion.php";
$user = $_GET["usuario"];
$pass = $_GET["password"];

$con = Conexion::getConexion();

        $query = $con->prepare("select idalumno, password from alumno where idalumno = ? and password = ?");
       	$query->execute([$user,$pass]);
       	if($query->rowCount() == 1){
       		$ar = array("msg"=>"logged-in");
       		echo json_encode($ar,JSON_FORCE_OBJECT);
       	}else{
       		$ar = array("msg"=>"not found");
       		echo json_encode($ar);
       	}

?>