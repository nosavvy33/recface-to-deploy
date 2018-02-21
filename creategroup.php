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
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>CREAR SALÓN</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
        <div class="container">
    <div class="row">
<div class="col"><p>Sesión iniciada como: <?php echo $_SESSION['givenName'];?></p></div><div class="col"><a href="logout.php" style="display: inline;" class="btn btn-danger">Log-out</a></div>
</div>
</div>
<hr>
<h1>1 - Creación de salones</h1>
<p style="text-align: center;">Se creará un salón para luego añadir personas a tal salón</p>
<div class="centered">
<input id="salon" type="text" placeholder="Nombre del salón">
<button id="trigger">Crear Salón</button>
</br></br>
<a class="btn btn-info" href="listgroups.php">Volver a tabla de Grupos</a></div>
<script type="text/javascript">
	const key = "11131afade8d4760865c7db0715c87ee";
        var groupname = "";
    $("#trigger").on("click",function(){
        groupname = $("#salon").val();
        var str = '{"name":"'+groupname+'"}';
        var req = JSON.parse(str);
        var req2 = JSON.stringify(req);
         var params = {
            // Request parameters
        };
        $.ajax({
            url: "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/"+groupname+"?"+ $.param(params),
            beforeSend: function(xhrObj){
                // Request headers
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",key);
            },
            type: "PUT",
            // Request body
            data: req2,
            statusCode:{
                409: function(){
                    alert("Ya existe un aula con el mismo nombre, por favor, escoja otro");
                },
                400: function(){
                    alert("Nombre de aula demasiado largo, por favor, escoja otro");
                }
            }
        })
        .done(function(data) {
            entrenarGrupo();
            alert("SE CREÓ GRUPO CON ÉXITO");
            window.location.assign("listperson.php?group="+groupname); 

        })
        .fail(function(data) {
            alert("ERROR AL CREAR GRUPO: ASEGÚRESE DE QUE NO HAYA UN GRUPO CON EL MISMO NOMBRE O, REFRÉSQUE LA PÁGINA Y VUELVA A INTENTARLO");
        });
          
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
            phpcrearaula();
            alert("SE ENTRENÓ GRUPO EXITOSAMENTE: ESTE PASO ES DE SUMA IMPORTANCIA PARA COMENZAR A HACER COMPARACIONES DE ROSTROS");    
        })
        .fail(function() {
            alert("ERROR AL ENTRENAR GRUPO");
        });
    }

    function phpcrearaula(){
        var datatosend = "aula="+groupname;
        $.ajax({
            url: 'api/aula/crearaula.php',
            processData: true,
            type: "POST",
            async: false,
            data: datatosend
        })
        .done(function(data) {
         
        })
        .fail(function(data) {
            alert(JSON.stringify(data));
        });
    }
</script>
</body>
</html>

