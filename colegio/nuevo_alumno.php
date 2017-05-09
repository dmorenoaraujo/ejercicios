<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            
            <h1>ALTA DE ALUMNO REALIZADA</h1>
            <?php



                $conn = new mysqli("localhost", "root", "P15!1754123m", "colegio");
                mysqli_set_charset($conn, 'utf8');
                if ($conn->connect_errno != 0){
                  echo "ERROR DE CONEXIÓN, REVISE CREDENCIALES Y/O SERVIDOR";
                }

                //var_dump($conn);

                var_dump($_FILES);
                move_uploaded_file($_FILES['adjuntos'] [tmp_name], '/var/www/html/colegio/imagenes/'.$_FILES['adjuntos'] [name]);

                $sql = "INSERT INTO alumno (nombre,apellidos,fecha_nacimiento,curso_id,adjunto) 
                        VALUES (
                            '" . $_POST['nombrecito1'] . "',
                            '" . $_POST['apellidos']. "',
                            '" . date ("Y-m-d", strtotime ($_POST['fecha_nacimiento'])). "',
                            '" . $_POST['curso_id'] [id]. "',
                            '" . $_FILES['adjuntos'] [name]. "')";

                $conn->query($sql);

                $conn->close();

            ?>
            <button class="btn btn-info" onclick="location.href='formulario_alumno.php'" type="button">Formulario de alta</button>
            <button class="btn btn-info" onclick="location.href='lista_alumno.php'" type="button">Listado de alumnos</button>
        </div>


        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
        </script>
    </body>
</html>