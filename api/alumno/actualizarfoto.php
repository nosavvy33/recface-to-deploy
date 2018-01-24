<?php

require_once "../../common/Conexion.php";

$grupo = $_POST["idgrupo"];
$persona = $_POST['idpersona'];
$faceid = $_POST['idface'];
echo $grupo.$persona.$faceid;
if(isset($_FILES["alufoto"])){
	//echo "yes";
	/*echo $_FILES["image"]["tmp_name"];
	echo $_FILES["image"]["name"];
	echo $_FILES["image"]["type"];*/
		$errors=array();
    $allowed_ext= array('jpg','jpeg','png','gif');
    $file_name =$_FILES['alufoto']['name'];
 //   $file_name =$_FILES['image']['tmp_name'];
    $file_ext = strtolower( end(explode('.',$file_name)));


    $file_size=$_FILES['alufoto']['size'];
    $file_tmp= $_FILES['alufoto']['tmp_name'];
    echo $file_tmp;echo "<br>";

    $type = pathinfo($file_tmp, PATHINFO_EXTENSION);
    $data = file_get_contents($file_tmp);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    /*echo "Base64 is ".$base64;
    echo '<img src="'.$base64.'" />';
    $con = new PDO("mysql:host=localhost;dbname=tests;charset=utf8", "root", "feelingshitty");
    $query = $con->prepare("insert into imagen (foto) values (?)");
    $query->execute([$base64]);

    $q2 = $con->prepare("select foto from imagen");
    $q2->execute();
    $tosrc = $q2->fetch();
    echo '<img src="'.$tosrc[0].'"/>';*/

    //
$con = Conexion::getConexion();

        $query = $con->prepare("update alumno set foto_64 = ?, id_azure_rostro = ? where id_azure_persona = ?");
       	$query->execute([$base64 , $faceid, $persona]);
$con = null;
header('Location: ../../listperson.php?group='.$grupo);
}else{
    echo "archivo no llegó";
    header('Location: ../../listperson.php?group='.$grupo);

}





?>