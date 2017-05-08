<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <h1>PRUEBA DE BASE DE DATOS</h1>

            <?php

            //echo "Hola mundo";
            $edad=32;
            $nombre="Dani";
            //var_dump($edad);

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
              echo "<td>".$fila['matriculado']."</td>";
              echo "<td><img src='/../../../tmp/".$fila['adjunto']."'></td>";
              echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";

            $conn->close();

            ?>


            <h2>Formulario para añadir nuevos alumnos</h2>

            <form action="prueba.php" method="post" enctype="multipart/form-data">
                <label for="nombre">Nombre</label>
                <input class="form-control" type="text" name="nombre" id="nombre" placeholder="NOMBRE">
                <label for="apellidos">Apellidos</label>
                <input class="form-control" type="text" name="apellidos" id="apellidos" placeholder="APELLIDOS">
                <label for="fecha">Fecha de Nacimiento</label>
                <input class="form-control" type="text" name="fecha_nacimiento" id="fecha" placeholder="aaaa-mm-dd">
                
                <label for="curso">Curso</label>
                <input class="form-control" type="text" name="fecha_nacimiento" id="fecha" placeholder="aaaa-mm-dd">

                <labe for="ficheros">Añadir imagenes</label>
                <input class="form-control" type="file" name="adjuntos" id="ficheros">
                <input type="submit" value="Enviar">    
            </form>
            <?php



                $conn = new mysqli("localhost", "root", "P15!1754123m", "colegio");
                
                if ($conn->connect_errno != 0){
                  echo "ERROR DE CONEXIÓN, REVISE CREDENCIALES Y/O SERVIDOR";
                }

                //var_dump($conn);

                var_dump($_FILES);
                move_uploaded_file($_FILES['adjuntos'] [tmp_name], '/tmp/'.$_FILES['adjuntos'] [name]);

                $sql = "INSERT INTO alumno (nombre,apellidos,fecha_nacimiento,adjunto) VALUES ('" . $_POST['nombre'] . "','" . $_POST['apellidos']. "','" . $_POST['fecha_nacimiento']. "','" . $_FILES['adjuntos'] [name]. "')";

                $conn->query($sql);

                $conn->close();

            ?>
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