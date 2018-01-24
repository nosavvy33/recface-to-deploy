<?php
/*
mysql> desc alumno;
+------------------+-------------+------+-----+---------+----------------+
| Field            | Type        | Null | Key | Default | Extra          |
+------------------+-------------+------+-----+---------+----------------+
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
require_once "../../common/Conexion.php";
$personid = $_GET["personid"];

$con = Conexion::getConexion();

        $query = $con->prepare("select nombre, paterno, materno from alumno where id_azure_persona = ?");
       	$query->execute([$personid]);
       		$rs = $query->fetch(PDO::FETCH_ASSOC);
       	echo json_encode($rs,JSON_FORCE_OBJECT);

       	

?>