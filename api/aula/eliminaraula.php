<?php

require_once "../../common/Conexion.php";
$groupname = $_POST["aula"];


$con = Conexion::getConexion();

        $query = $con->prepare("delete from aula where nombre = ?");
       	$query->execute([$groupname]);
$con = null;
?>