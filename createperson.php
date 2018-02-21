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

    <title>CREAR ALUMNO</title>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">


</head>
<body>
   <div>
<p>Sesión iniciada como: <?php echo $_SESSION['givenName'];?></p><a href="logout.php" style="display: inline;" class="btn btn-danger btn-out">Log-out</a></div>
<h1>3 - Crear Alumno</h1>
<p style="text-align: center;">Ahora se creará a un alumno con sus respectivos datos, los cuales podrán editarse luego si así se desea</p>

        <!-- 
            CAMPOS DE ALUMNO
            nombre*
            paterno*
            materno*
            dni
            password*
            foto-64
        -->
        <div class="container">
            <table class="table table-condensed text-center centered" id="example" class="display" width="60%" cellspacing="0">
            <form method="POST" id="formu" action="api/alumno/darfoto.php" enctype="multipart/form-data">
            <tr><td>(Obligatorio) Nombre: </td><td><input type="text" id="alunombre" required></td></tr>
            <tr><td>(Obligatorio) Apellido paterno: </td><td><input type="text" id="alupaterno" required></td></tr>
<tr><td>(Obligatorio) Apellido materno: </td><td><input type="text" id="alumaterno"></td></tr>
<tr><td>DNI: </td><td><input type="text" id="aludni"></td></tr>
<tr><td colspan="2">Insertar solamente fotos donde se muestre un solo rostro</td></tr>
<tr><td>Foto: </td><td><input type="file" id="alufoto" name="alufoto"></td></tr>
<tr><td>Vista previa: </td><td><img id="prevista" src="" style="max-width: 200px; max-height: 200px;"></tr>
    <input name="idpersona" id="idpersona" type="hidden" ><input name="idgrupo" id="idgrupo" type="hidden" ><input name="idface" id="idface" type="hidden" >
<tr><td colspan="2"><input type="submit" class="btn btn-success" id="crear" value="Crear Alumno"/></form></td></tr>


            </table>
        </div>

        <div class="bottomed">   
        <button class="btn btn-info" id="tabla_alumnos">Volver a Tabla de alumnos</button>
        <a class="btn btn-default" href="listgroups.php">Volver a Tabla Grupos</a>
</div>
    <script type="text/javascript">
	const key ="11131afade8d4760865c7db0715c87ee";
        var groupname = location.search.split('group=')[1];
        $("#idgrupo").val(groupname);
        $("#tabla_alumnos").on("click",function(){
        window.location.assign("listperson.php?group="+groupname); 
        });

        $("#alufoto").on("change",function(){
    if(document.getElementById("alufoto").files[0].size > 1000000){
        let x = document.getElementById("alufoto").files[0].size;
        let mb = x/(1024*1024);
        mb =  mb.toFixed(2);
        alert("Escoja una imagen de menos de 1MB. Actualmente, su archivo pesa "+mb +" MB");
        $("#crear").attr("disabled","disabled");
    }else{
        document.getElementById("crear").disabled= false;
    }
});
        $(document).ready(function(){
        entrenarGrupo();
    });
function entrenarGrupo(){
        var params = {
            // Request parameters
        };
      
        $.ajax({
            url: "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/"+groupname+"/train?" + $.param(params),
            beforeSend: function(xhrObj){
                // Request headers
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",key);
            },
            type: "POST"
        })
        .done(function(data) {
         
        })
        .fail(function() {
        });
    }

        $("#alufoto").on("change",function(){
            if(this.files[0].size);
        });

        //preview
        function readURL(input){
    if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {

                $('#prevista').attr('src', e.target.result);
                // SÍ RETORNA UN BASE 64 alert($('#prevista').attr('src'));

            }

           reader.readAsDataURL(input.files[0]);

        }
}
$("#alufoto").on("change",function(){

        readURL(this);
});


            var microsoft_personid = "";
            var microsoft_faceid = "";
            var db_base64 = "";
        $("#crear").on("click",function(){
            
            //console.log(groupname);
            let db_nombre = $("#alunombre").val();
            let db_paterno = $("#alupaterno").val();
            let db_materno = $("#alumaterno").val();
            let db_dni = $("#aludni").val();
          
            let microsoft_binarios = document.getElementById("alufoto").files[0];
            let db_foto64 = $('#prevista').attr('src');
            
           //alert(microsoft_binarios instanceof Blob);
            if(db_nombre == "" || db_paterno == "" || db_materno == ""){
                alert("Complete los campos obligatorios");
                
                return;
            }else{ /*if(microsoft_binarios == null || microsoft_binarios == undefined || db_foto64 == null || db_foto64 == undefined){*/
                //solo crear a la persona e ingresar sus datos
                mscrearpersona(db_nombre);
            }
            if(document.getElementById("alufoto").files[0]){
                mscrearrostro(document.getElementById("alufoto").files[0]);
            }else{
                alert("Alumno creado con éxito, volviendo a la tabla de alumnos...");
            window.location.assign("listperson.php?group="+groupname);
            }
                /*alert("Alumno creado con éxito, volviendo a la tabla de alumnos...");
            window.location.assign("listperson.php?group="+groupname);*/ 

            /*}else{
                //crear persona
                //ingresar sus datos
                //crear rostro
                //ingresar su rostro y guardar su base64
                console.log("asdad");
                mscrearpersona(db_nombre);
                mscrearrostro(microsoft_binarios);
                alert("Alumno creado con éxito, volviendo a la tabla de alumnos...");
            window.location.assign("listperson.php?group="+groupname); 
            }*/
        });

function mscrearpersona(nombre){
    //retorna el personId
    var str = '{"name":"'+nombre+'"}';
        var req = JSON.parse(str);
        var req2 = JSON.stringify(req);
    $.ajax({
            url: "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/"+groupname+"/persons",
            beforeSend: function(xhrObj){
                // Request headers
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",key);
            },
            type: "POST",
            // Request body
            data: req2,
            async: false
        })
        .done(function(data) {
            microsoft_personid=data.personId;
            console.log(microsoft_personid);
            $("#idpersona").val(microsoft_personid);

            phpcrearalumno();
        })
        .fail(function() {
            alert("error");
        });
}

function getBase64(file) {
   var reader = new FileReader();
   reader.readAsDataURL(file);
   reader.onload = function () {
     phpcrearrostro(reader.result);
         // console.log(reader.result);

   };
   reader.onerror = function (error) {
     console.log('Error: ', error);
   };
}

function mscrearrostro(binarios){
    var params = {
            // Request parameters
           
        };
      
        $.ajax({
            url: "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/"+groupname+"/persons/"+microsoft_personid+"/persistedFaces?" + $.param(params),
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
            console.log("FACE "+data.persistedFaceId);
            microsoft_faceid = data.persistedFaceId;
            $("#idface").val(microsoft_faceid);
            phpcrearrostro(id_face, id_persona);
            //extract base64 from binarios;
            //getBase64(binarios);
           // phpcrearrostro();
            
        })
        .fail(function() {
            alert("Microsoft: error");
        });
}

function phpcrearrostro(id_face, id_persona){
//guardar base64 foto y persistedfaceid
            //let db_foto64 = $('#prevista').attr('src');
            /*var file = document.getElementById("alufoto").files[0];
            var reader = new FileReader();*/
            /*reader.readAsDataURL(file);
            var b64 = "";
            reader.onload = function(){
                b64 = reader.result
            }*/
            /*reader.readAsDataURL(file);
            reader.onload = function () {
            console.log(reader.result);
            };
            reader.onerror = function (error) {
            console.log('Error: ', error);
            };*/
            /*var string64 = $("#prevista").attr("src");
            console.log(string64);*/
            

var dataString = "msfaceid="+id_face+"&mspersonid="+id_persona;
        $.ajax({
            url: "api/alumno/idfotoalumno.php",
            processData: false,
            type: "POST",
            async: false,
            data: dataString
           // data: {"aula": groupname, "nombre": db_nombre, "paterno": db_paterno, "materno": db_materno, "password": db_password, "dni": db_dni, "ms_personid": microsoft_personid}
        })
        .done(function(data){
            alert("Alumno creado con éxito, volviendo a la tabla de alumnos...");
            window.location.assign("listperson.php?group="+groupname);
        })
        .fail(function(data){
            alert("Error al guardar en base de datos");
        });
}

function phpcrearalumno(){
    //ingresa el personId junto a otros datos
            let db_nombre = $("#alunombre").val();
            let db_paterno = $("#alupaterno").val();
            let db_materno = $("#alumaterno").val();
            let db_dni = $("#aludni").val();
           
    console.log(db_materno+db_paterno+db_nombre+db_dni);
        var dataString = 'aula='+groupname+'&nombre='+db_nombre+'&paterno='+db_paterno+'&materno='+db_materno+'&dni='+db_dni+'&mspersonid='+microsoft_personid;
        console.log(dataString);
        $.ajax({
            url: "api/alumno/crearalumno.php",
            processData: true,
            type: "POST",
            async: false,
            data: dataString
           // data: {"aula": groupname, "nombre": db_nombre, "paterno": db_paterno, "materno": db_materno, "password": db_password, "dni": db_dni, "ms_personid": microsoft_personid}
        })
        .done(function(data){

        })
        .fail(function(data){
            alert("Error al guardar en base de datos");
        });
}



    </script>
</body>
</html>
