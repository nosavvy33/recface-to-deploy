<?php

require_once "../../common/Conexion.php";


$mspersonid  = $_POST['mspersonid'];
$msfaceid = $_POST['msfaceid'];


$con = Conexion::getConexion();

        $query = $con->prepare("update alumno set id_azure_rostro = ? where id_azure_persona = ?");
       	$query->execute([$msfaceid, $mspersonid]);
$con = null;
?>