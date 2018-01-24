<?php

require_once "../../common/Conexion.php";
date_default_timezone_set("America/Lima");
$creado = date("Y-m-d H:i:s");
$groupname = $_POST["aula"];


$con = Conexion::getConexion();

        $query = $con->prepare("insert into aula (nombre, created_at) values (?,?)");
       	$query->execute([$groupname, $creado]);
$con = null;
?>