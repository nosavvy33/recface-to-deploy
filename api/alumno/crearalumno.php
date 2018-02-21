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

			nombre*
            paterno*
            materno*
            dni
            password*
*/
           // $data = json_decode($_POST["data"]
$aula = $_POST["aula"];
$nombre = $_POST["nombre"];
$paterno = $_POST["paterno"];
$materno = $_POST["materno"];

$dni = $_POST["dni"];
$ms_personid = $_POST["mspersonid"];


$con = Conexion::getConexion();

        $query = $con->prepare("insert into alumno (nombre, paterno, materno, dni,  id_azure_persona, aula_idaula) values (?,?,?,?,?,(select idaula from aula where nombre = ?))");
       	$query->execute([$nombre, $paterno, $materno, $dni, $ms_personid, $aula]);
$con = null;
?>
