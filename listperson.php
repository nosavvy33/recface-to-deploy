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

    <title>LISTA ALUMNOS</title>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">


</head>
<body>
     <div>
<p>Sesión iniciada como: <?php echo $_SESSION['givenName'];?></p><a href="logout.php" style="display: inline;" class="btn btn-danger btn-out">Log-out</a></div>
<h1>2 - Listar Alumno</h1>
<p>En la presente vista, se pueden observar los alumnos creados hasta el momento</p>
<hr>
<!--<input type="text" id="nombre">-->
<button id="crear" class="btn btn-primary">Crear Alumno</button>
<hr>
<table class="text-center" id="example" class="display" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Foto</th>
                <th>Editar perfil</th>
                <th>Eliminar alumno</th>
            </tr>
        </thead>
    </table>
    <hr>
    <div>
        <a class="btn btn-default" href="listgroups.php">Volver a Tabla Grupos</a>
    </div>
<script type="text/javascript">
            var groupname = location.search.split('group=')[1];
            var t = $('#example').DataTable({
                "language":{
             "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
            });

    $(document).ready(function(){
        getPersonas();
        entrenarGrupo();
    });

    //ENVIAR A OTRA PAGINA DONDE SE COMPARE UN ROSTRO CON LOS DE ESTE GRUPO DE PERSONAS
    $("#compare").on("click",function(){
        window.location.assign("comparefaces.php?group="+groupname); 
    });

    $("#crear").on("click",function(){
        window.location.assign("createperson.php?group="+groupname); 
    });

function entrenarGrupo(){
        var params = {
            // Request parameters
        };
      
        $.ajax({
            url: "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/"+groupname+"/train?" + $.param(params),
            beforeSend: function(xhrObj){
                // Request headers
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key","d51f69b3fcb74199aac608a19b165a28");
            },
            type: "POST"
        })
        .done(function(data) {
         
        })
        .fail(function() {
        });
    }

    function getPersonas(){
        $.ajax({
            url: "api/alumno/listaralumno.php?aula="+groupname,
            type: "GET",
            async:false
        })
        .done(function(data) {
            let obj = JSON.parse(data);
            for(let i = Object.keys(obj).length-1; i>=0;i--){
                console.log(obj[i].foto_64);
            t.row.add([obj[i].nombre,obj[i].paterno+" "+obj[i].materno,'<img class="foto-alu" src="'+obj[i].foto_64+'">','<a class="btn btn-success" href="editperson.php?group='+groupname+'&person='+obj[i].id_azure_persona+'&face='+obj[i].id_azure_rostro+'">Editar Alumno</a>','<button class="btn btn-danger" id="'+obj[i].id_azure_persona+'" onclick="eliminarPersona(this.id)">Eliminar persona</button>']).draw(false);
            }
            //alert(x[0].idalumno);
            /*personId=data.personId;
            t.row.add([nombre,personId,'<a class="btn btn-success" href="addfacetoperson.html?group='+groupname+'&person='+personId+'">Añadir foto</a>','<button class="btn btn-danger" id="'+personId+'" onclick="eliminarPersona(this.id)">Eliminar persona</button>']).draw(false);
            tryingphp(nombre);*/
        })
        .fail(function() {
            alert("error");
        });
    }

    function eliminarPersona(persona){
    var params = {
            // Request parameters
        };
      
        $.ajax({
            url: "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/"+groupname+"/persons/"+persona+"?" + $.param(params),
            beforeSend: function(xhrObj){
                // Request headers
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key","d51f69b3fcb74199aac608a19b165a28");
            },
            type: "DELETE"
        })
        .done(function(data) {
                alert("SE ELIMINÓ CORRECTAMENTE A LA PERSONA "+persona);
                t.clear();
                let alu = persona;
                phpeliminaralumno(alu);
                getPersonas();
        })
        .fail(function() {
            alert("error");
        });
    }

    function phpeliminaralumno(alumno){
    var dataString = "personid="+alumno;
        $.ajax({
            url: "api/alumno/eliminaralumno.php",
            processData: false,
            type: "POST",
            async: false,
            data: dataString
           // data: {"aula": groupname, "nombre": db_nombre, "paterno": db_paterno, "materno": db_materno, "password": db_password, "dni": db_dni, "ms_personid": microsoft_personid}
        })
        .done(function(data){
            
        })
        .fail(function(data){
            
        });
    }

    //CREAR UNA NUEVA PERSONA DENTRO DEL GRUPO DE PERSONAS
/*$("#crear").on("click",function(){
        var nombre = $("#nombre").val();
        var str = '{"name":"'+nombre+'"}';
        var req = JSON.parse(str);
        var req2 = JSON.stringify(req);
        var personId = "";
              
        $.ajax({
            url: "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/"+groupname+"/persons",
            beforeSend: function(xhrObj){
                // Request headers
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key","d51f69b3fcb74199aac608a19b165a28");
            },
            type: "POST",
            // Request body
            data: req2
        })
        .done(function(data) {
            personId=data.personId;
            t.row.add([nombre,personId,'<a class="btn btn-success" href="addfacetoperson.html?group='+groupname+'&person='+personId+'">Añadir foto</a>','<button class="btn btn-danger" id="'+personId+'" onclick="eliminarPersona(this.id)">Eliminar persona</button>']).draw(false);
            tryingphp(nombre);
        })
        .fail(function() {
            alert("error");
        });
    });*/






   /* function tryingphp(status){
        var tosendname = $("#nombre").val();
        var dataString = 'estado='+tosendname;
        $.ajax({
            url: "pdo.php",
            processData: true,
            type: "POST",
            async: false,
            data: dataString
        })
        .done(function(data){
            alert(data);
        })
        .fail(function(){
            alert("error al enviar a php");
        });
    }*/







    //OBTENER LISTADO DE PERSONAS DENTRO DE GRUPO DE PERSONAS
    /*function getPersonas(){
        var params = {
            // Request parameters
            "start": "1",
            "top": "1000",
        };
      
        $.ajax({
            url: "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/"+groupname+"/persons?" + $.param(params),
            beforeSend: function(xhrObj){
                // Request headers
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key","d51f69b3fcb74199aac608a19b165a28");
            },
            type: "GET",
            async: false
        })
        .done(function(data) {
            data.forEach(function(element){
                console.log("FACE "+element.persistedFaceIds[0]);
                t.row.add([element.name,element.personId,'<a class="btn btn-success" href="addfacetoperson.html?group='+groupname+'&person='+element.personId+'">Añadir foto</a>','<button class="btn btn-danger" id="'+element.personId+'" onclick="eliminarPersona(this.id)">Eliminar persona</button>']).draw(false);
            });
            
        })
        .fail(function() {
            alert("error");
        });
    }*/







    

    
</script>
</body>
</html>

