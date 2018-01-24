<?php

require_once "../../common/Conexion.php";
$alumno = $_POST["personid"];

$con = Conexion::getConexion();

        $query = $con->prepare("delete from alumno where id_azure_persona = ?");
       	$query->execute([$alumno]);
$con = null;
?>