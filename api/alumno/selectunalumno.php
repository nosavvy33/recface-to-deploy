<?php

require_once "../../common/Conexion.php";
$personid = $_GET["person"];
$con = Conexion::getConexion();

        $query = $con->prepare("select * from alumno where id_azure_persona = ?");
       	$query->execute([$personid]);
       	$rs = $query->fetch();
       	echo json_encode($rs);

?>