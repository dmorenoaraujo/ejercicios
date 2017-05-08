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

            //var_dump($conn);

            $sql = "SELECT * FROM alumno";

            //var_dump($sql);

            $result = $conn->query($sql);

            //var_dump($result);



            $primerafila= $result->fetch_assoc();

            //var_dump($primerafila);

            $nombrecolumnas=array_keys($primerafila);






            //var_dump($nombrecolumnas);

            echo '<table id="mitabla" class="display" width="100%" cellspacing="0">';
            echo "<thead>";
            echo "<tr>";
            foreach ($nombrecolumnas as $nombrecolumna){
              echo "<td>" . $nombrecolumna . "</td>";
            }




            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            echo "<tr>";

            foreach($primerafila as $elementosprimerafila){
              echo "<td>". $elementosprimerafila . "</td>";
            }
            echo "</tr>";

            while ($fila=$result->fetch_assoc()){
              echo "<tr>";
              echo "<td>".$fila['id']."</td>";
              echo "<td>".$fila['curso_id']."</td>";
              echo "<td>".$fila['nombre']."</td>";
              echo "<td>".$fila['apellidos']."</td>";
              echo "<td>".$fila['dni']."</td>";
              echo "<td>".$fila['nota']."</td>"; 
              echo "<td>".$fila['fecha_nacimiento']."</td>";
              if ($fila['matriculado']==1){
                echo "<td>Si</td>";
              }else{
                echo "<td>No</td>";
              };
              echo "<td><img src='/localhost/../../../../tmp/".$fila['adjunto']."'></td>";
              echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";

            $conn->close();

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