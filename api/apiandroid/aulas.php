<?php

require_once "../../common/Conexion.php";

$con = Conexion::getConexion();

        $query = $con->prepare("select nombre from aula");
       	$query->execute();
       	$ar = array();
       	while($rs = $query->fetch(PDO::FETCH_ASSOC)){
       		array_push($ar, $rs);
       	}
       	echo json_encode($ar, JSON_FORCE_OBJECT);

?>