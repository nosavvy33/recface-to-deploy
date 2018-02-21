

            <?php
    session_start();

    if (!isset($_SESSION['access_token'])) {
        header('Location: login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EDITAR ALUMNO</title>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">


</head>
<body>
   
<div>
<p>Sesión iniciada como: <?php echo $_SESSION['givenName'];?></p><a href="logout.php" style="display: inline;" class="btn btn-danger btn-out">Log-out</a></div>
<h1>5 - Editar Alumno</h1>
<p>Ahora se editará la información de un alumno</p>
        <div class="container">
            <table class="table table-condensed text-center centered" id="example" class="display" width="60%" cellspacing="0">
            <form method="POST" id="formu" action="api/alumno/actualizarfoto.php" enctype="multipart/form-data" >
            <tr><td>(Obligatorio) Nombre: </td><td><input type="text" id="alunombre" required></td></tr>
            <tr><td>(Obligatorio) Apellido paterno: </td><td><input type="text" id="alupaterno" required></td></tr>
<tr><td>(Obligatorio) Apellido materno: </td><td><input type="text" id="alumaterno"></td></tr>
<tr><td>DNI: </td><td><input type="text" id="aludni"></td></tr>

<tr><td colspan="2">Insertar solamente fotos donde se muestre un solo rostro</td></tr>
<tr><td>Foto: </td><td><input type="file" id="alufoto" name="alufoto"></td></tr>
<tr><td>Vista previa: </br><p id="foto-modificada">(Foto antigua)</p></td><td><img id="prevista" src="" style="max-width: 200px; max-height: 200px;"></tr>
    <input name="idpersona" id="idpersona" type="hidden" ><input name="idgrupo" id="idgrupo" type="hidden" ><input name="idface" id="idface" type="hidden" >
<tr><td colspan="2"><input type="submit" class="btn btn-warning" id="guardar" value="Guardar cambios"/></form></td></tr>


            </table>
        </div>

          <div class="bottomed">
        <button class="btn btn-info" id="tabla_alumnos">Volver a Tabla de alumnos</button>
        <a class="btn btn-default" href="listgroups.php">Volver a Tabla Grupos</a>
</div>
    <script type="text/javascript">
	const key = "11131afade8d4760865c7db0715c87ee";
        function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
        var uri = window.location.search;
        var groupname = getParameterByName('group',uri);
        var personid = getParameterByName('person',uri);
        var faceid = getParameterByName('face',uri);
        $("#idpersona").val(personid);
        $("#idgrupo").val(groupname);
        console.log(groupname+personid+faceid);
        var binarios = null;

        function getAlumno(idperson){
            $.ajax({
            url: "api/alumno/selectunalumno.php?person="+idperson,
            type: "GET",
            async: false
        })
        .done(function(data) {
            let alumno = JSON.parse(data);
            $("#alunombre").val(alumno.nombre);
            $("#alupaterno").val(alumno.paterno);
            $("#alumaterno").val(alumno.materno);
            $("#aludni").val(alumno.dni);
          
            $("#prevista").attr("src",alumno.foto_64);
        })
        .fail(function() {
            alert("No se encontró a la persona consultada");
        });
        }

        $( document ).ready(function() {
        getAlumno(personid);
        });

        $("#alufoto").change(function(){
            if(document.getElementById("alufoto").files[0].size > 1000000){
        let x = document.getElementById("alufoto").files[0].size;
        let mb = x/(1024*1024);
        mb =  mb.toFixed(2);
        alert("Escoja una imagen de menos de 1MB. Actualmente, su archivo pesa "+mb +" MB");
        $("#guardar").attr("disabled","disabled");
            }else{
                document.getElementById("guardar").disabled= false;
                readURL(this);
            }
        });

        function readURL(input){
        if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            console.log("but why?");
        $('#prevista').attr('src', e.target.result);
        console.log("but why?");
            }        
        reader.readAsDataURL(input.files[0]);
        }
        }


        function phpactualizarpersona(){
            let db_nombre = $("#alunombre").val();
            let db_paterno = $("#alupaterno").val();
            let db_materno = $("#alumaterno").val();
            let db_dni = $("#aludni").val();
            
        var dataString = 'aula='+groupname+'&nombre='+db_nombre+'&paterno='+db_paterno+'&materno='+db_materno+'&dni='+db_dni+'&mspersonid='+personid;
        $.ajax({
            url: "api/alumno/actualizaralumno.php",
            processData: true,
            type: "POST",
            async: false,
            data: dataString
        })
        .done(function(data){
            if(document.getElementById("aulafoto") && document.getElementById("alufoto").files[0].size > 1000000){
                mseliminarrostro();
            }else{
                return;
            }
        })
        .fail(function(data){
            alert("Error al guardar en base de datos");
        });  
        }

function mseliminarrostro(){
            var params = {
            // Request parameters
        };
      
        $.ajax({
            url: "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/"+groupname+"/persons/"+personid+"/persistedFaces/"+faceid+"?" + $.param(params),
            beforeSend: function(xhrObj){
                // Request headers
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",key);
            },
            async: false,
            type: "DELETE",
            // Request body
            data: "",
        })
        .done(function(data) {
            mscrearrostro();
        })
        .fail(function() {
            alert("Error al eliminar rostro");
        });
        }

        function mscrearrostro(){
            var binarios = document.getElementById("alufoto").files[0];
            var params = {
            // Request parameters
           
        };   
        $.ajax({
            url: "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/"+groupname+"/persons/"+personid+"/persistedFaces?" + $.param(params),
            processData: false,

            beforeSend: function(xhrObj){
                // Request headers
                xhrObj.setRequestHeader("Content-Type","application/octet-stream");
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",key);
            },
            type: "POST",
            // Request body
            data: binarios,
            async: false
        })
        .done(function(data) {
            alert(data.persistedFaceId);
            $("#idface").val(data.persistedFaceId);            
        })
        .fail(function() {
            alert("Microsoft: error al actualizar rostro");
        });
        }

        $("#formu").on("submit",function(){
            if($("#alunombre").val() == null ||$("#alunombre").val() == "" ||$("#alupaterno").val() == null||$("#alupaterno").val() == ""||$("#alumaterno").val() == null||$("#alumaterno").val() == "" ){
                alert("Complete los campos obligatorios");
                return false;
            }else if(document.getElementById("alufoto").files[0]){
                mseliminarrostro();
                phpactualizarpersona();
                return true;
            }else{
                return false;
            }
        });

        /*$("#alufoto").on("change",function(){
        if(document.getElementById("alufoto").files[0].size > 1000000){
        let x = document.getElementById("alufoto").files[0].size;
        let mb = x/(1024*1024);
        mb =  mb.toFixed(2);
        alert("Escoja una imagen de menos de 1MB. Actualmente, su archivo pesa "+mb +" MB");
        $("#guardar").attr("disabled","disabled");
        }else{
            readURL(document.getElementById("alufoto"));
        document.getElementById("guardar").disabled= false;
        binarios = document.getElementById("alufoto").files[0];
        
        }
    });*/

        /*$("#guardar").on("click",function(){
            if($("#alunombre").val() == null ||$("#alunombre").val() == "" ||$("#alupaterno").val() == null||$("#alupaterno").val() == ""||$("#alumaterno").val() == null||$("#alumaterno").val() == ""||$("#alupassword").val()==null||$("#alupassword").val()=="" ){
                alert("Complete los campos obligatorios");
                $("#formu").attr('onsubmit','return false;');
                return;
            }else{
                phpactualizarpersona();

            }
            if(document.getElementById("alufoto").files[0] && document.getElementById("alufoto").files[0] <= 1000000){
                            
                //msactualizarrostro(binarios);
                mseliminarrostro();
                                $("#formu").attr('onsubmit','return true;');

            }else{
                window.location.assign = "listperson.php?group="+groupname;
            }
        });*/

    </script>
</body>
</html>
