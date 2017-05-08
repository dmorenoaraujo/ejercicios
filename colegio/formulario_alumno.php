<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            
            <h1>FORMULARIO ALUMNOS</h2>

            <form action="nuevo_alumno.php" method="post" enctype="multipart/form-data">
                <label for="nombre">Nombre</label>
                <input class="form-control" type="text" name="nombrecito1" id="nombrecito2" placeholder="NOMBRE">
                <label for="apellidos">Apellidos</label>
                <input class="form-control" type="text" name="apellidos" id="apellidos" placeholder="APELLIDOS">
                <label for="fecha">Fecha de Nacimiento</label>
                <input class="form-control" type="text" name="fecha_nacimiento" id="fecha" placeholder="aaaa-mm-dd">
                
                <label for="cursos">Curso:</label>

                <?php
                $conn = new mysqli("localhost", "root", "P15!1754123m", "colegio");
                //var_dump($conn);
                $sql = "SELECT * FROM curso";
                //var_dump($sql);
                $result = $conn->query($sql);
                //var_dump($result);
                echo '<select id="cursos" name="curso_id">
                        <option selected disabled>Elija</option>'
                ;
                            while ($opcion=$result->fetch_assoc()){
                                echo '<option value="'.$opcion['id'].'">'.$opcion['nombre'].'</option>';
                            }
                echo   '</select>';
                //$conn->close();

                ?>
                <br>
                <label for="ficheros">Añadir imagenes</label>
                <input class="form-control" type="file" name="adjuntos" id="ficheros">
                <input type="submit" value="Enviar">    
            </form>
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