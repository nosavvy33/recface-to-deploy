<?php

require_once "../../common/Conexion.php";

$aula = $_POST["aula"];
$nombre = $_POST["nombre"];
$paterno = $_POST["paterno"];
$materno = $_POST["materno"];
$password = $_POST["password"];
$dni = $_POST["dni"];
$ms_personid = $_POST["mspersonid"];


$con = Conexion::getConexion();

        $query = $con->prepare("update alumno set nombre = ?, paterno = ?, materno = ? , dni = ?, password = ? where id_azure_persona = ?");
       	$query->execute([$nombre, $paterno, $materno, $dni, $password, $ms_personid]);
$con = null;
?>