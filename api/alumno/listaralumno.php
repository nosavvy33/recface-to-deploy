<?php

require_once "../../common/Conexion.php";
/*
| idalumno         | int(11)     | NO   | PRI | NULL    | auto_increment |
| nombre           | varchar(45) | YES  |     | NULL    |                |
| paterno          | varchar(45) | YES  |     | NULL    |                |
| materno          | varchar(45) | YES  |     | NULL    |                |
| dni              | varchar(8)  | YES  |     | NULL    |                |
| password         | varchar(45) | YES  |     | NULL    |                |
| aula_idaula      | int(11)     | NO   | MUL | NULL    |                |
| foto_64          | longtext    | YES  |     | NULL    |                |
| id_azure_persona | varchar(45) | YES  |     | NULL    |                |
| id_azure_rostro  | varchar(45) | YES  |     | NULL    |      
*/
           // $data = json_decode($_POST["data"]
//var dataString = "msfaceid="+microsoft_faceid+"&foto64="+db_foto64+"&mspersonid="+microsoft_personid;


$aula = $_GET["aula"];

$con = Conexion::getConexion();

        $query = $con->prepare("select * from alumno where aula_idaula = (select idaula from aula where nombre = ?)");
       	$query->execute([$aula]);
       	$ar = array();
       	while($rs = $query->fetch(PDO::FETCH_ASSOC)){
       		array_push($ar, $rs);
       	}
       	echo json_encode($ar, JSON_FORCE_OBJECT);

?>