<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <style>
            h1{
                padding-top: 5rem;
            }


        </style>
    </head>
    <body>
        <div class="container">
            <h1>ALUMNOS DEL COLEGIO</h1>

            <?php
            $conn = new mysqli("localhost", "root", "P15!1754123m", "colegio");
            $sql = "SELECT * FROM alumno";
            $result = $conn->query($sql);

            $primerafila= $result->fetch_assoc();
            
            $nombrecolumnas=array_keys($primerafila);
            
            echo '<table id="mitabla" class="display" width="100%" cellspacing="0">';
            echo "<thead>";
            echo "<tr>";
            foreach ($nombrecolumnas as $nombrecolumna){
              echo "<td>" . $nombrecolumna . "</td>";
            }
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            listar($primerafila);{
              //echo "<td>". $elementosprimerafila . "</td>";            
}

            while ($fila=$result->fetch_assoc()){
                listar($fila);
            }
            echo "</tbody>";
            echo "</table>";

            $conn->close();

            
            
            function listar($item){
                echo "<tr>";
                echo "<td>".$item['id']."</td>";
                echo "<td>".$item['curso_id']."</td>";
                echo "<td>".$item['nombre']."</td>";
                echo "<td>".$item['apellidos']."</td>";
                echo "<td>".$item['dni']."</td>";
                echo "<td>".$item['nota']."</td>"; 
                echo "<td>".$item['fecha_nacimiento']."</td>";
                if ($item['matriculado']==1){
                echo "<td>Si</td>";
                }else{
                echo "<td>No</td>";
                };
                echo "<td><img src='/var/www/html/colegio/imagenes/".$item['adjunto']."'></td>";
                echo "</tr>";                
            }
            ?>

            <button class="btn btn-info" onclick="location.href='formulario_alumno.php'" type="button">Formulario de alta</button>


        </div>


        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#mitabla').dataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    "lengthMenu": [50, 10, 25]
                });
            });
        </script>
    </body>
</html>