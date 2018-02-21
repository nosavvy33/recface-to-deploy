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

    <title>VISTA GRUPOS</title>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <div class="container">
    <div class="row">
<div class="col"><h1>Bienvenido <?php echo $_SESSION['givenName'];?></h1></div><div class="col"><a href="logout.php" style="display: inline;" class="btn btn-danger">Log-out</a></div>
</div>
</div>
<hr>

<h2>0 - Vista Grupos</h2>
<p>En esta vista, se observan los grupos creados hasta el momento, a la vez que se puede administrar</p>
<hr>
<table class="text-center" id="example" class="display" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Nombre de Grupo</th>
                <th>Ver Personas</th>
                <th>Eliminar Grupo</th>
            </tr>
        </thead>
    </table>
    <hr>
    <div>
        <button class="btn btn-info" id="crear">Crear grupo</button>
    </div>

<script type="text/javascript">
	const key = "11131afade8d4760865c7db0715c87ee";

    var t = $('#example').DataTable({
    	"language":{
    		 "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
    	}
    });
    var tobe="";
    $(document).ready(function(){
        getGrupos();
    });

    //ENVIAR A OTRA PAGINA DONDE SE CREA UN GRUPO DE PERSONAS
    $("#crear").on("click",function(){
        window.location.assign("creategroup.php"); 
    });


    //OBTENER LISTADO DE GRUPOS
    function getGrupos(){
        var params = {
            // Request parameters
            "start": "1",
            "top": "1000",
        };
      
        $.ajax({
            url: "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups?" + $.param(params),
            beforeSend: function(xhrObj){
                // Request headers
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",key);
            },
            type: "GET",
            // Request body
            async: false
        })
        .done(function(data) {
            data.forEach(function(element){
            	tobe = element.personGroupId;
                t.row.add([element.personGroupId,'<a class="btn btn-success" href="listperson.php?group='+tobe+'">Ver Grupo</a>','<button class="btn btn-danger" id = "'+tobe+'" onclick="eliminar(this.id)">Eliminar Grupo</button>']).draw(false);
            });
        })
        .fail(function() {
            alert("error");
        });
    }



    function eliminar(grupo){
 var params = {
            // Request parameters
        };
      
        $.ajax({
            url: "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/persongroups/"+grupo+"?" + $.param(params),
            beforeSend: function(xhrObj){
                // Request headers
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key",key);
            },
            type: "DELETE",
            async: false
        })
        .done(function(data) {
            alert("SE ELIMINÓ CORRECTAMENTE EL GRUPO "+grupo);
            phpeliminaraula(grupo);
            t.clear();
            getGrupos();
        })
        .fail(function() {
            alert("error");
        });
    }

    function phpeliminaraula(aula){
        var datatosend = "aula="+aula;
        $.ajax({
            url: "api/aula/eliminaraula.php",
            processData: true,
            type: "POST",
            async: false,
            data: datatosend
        })
        .done(function() {
         
        })
        .fail(function() {
            
        });
    }
    
</script>
</body>
</html>

