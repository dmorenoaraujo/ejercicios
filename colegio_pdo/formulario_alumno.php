<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
    </head>
    <body>
        <div class="container">
            
            <h1>FORMULARIO ALUMNOS</h1>

            <form action="nuevo_alumno.php" method="post" enctype="multipart/form-data">
                <label for="nombre">NOMBRE</label>
                <input class="form-control" type="text" name="nombre" id="nombre" placeholder="NOMBRE">
                <label for="apellidos">APELLIDOS</label>
                <input class="form-control" type="text" name="apellidos" id="apellidos" placeholder="APELLIDOS">
                <label for="dni">DNI</label>
                <input class="form-control" type="text" name="dni" id="dni" placeholder="01234567">
                <label for="fecha">FECHA DE NACIMIENTO</label>
                <input class="form-control" type="text" name="fecha_nacimiento" id="fecha">
                
                <label for="cursos">CURSO:</label>

                <?php
                ini_set('display_errors',1);
                ini_set('diplay_startup_errors',1);
                error_reporting(E_ALL);
                //$conn = new mysqli("localhost", "root", "P15!1754123m", "colegio");
                //mysqli_set_charset($conn, 'utf8'); // con esta línea habilitamos los caracteres especiales para la conexión actual
                $db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','P15!1754123m');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $sql = "SELECT * FROM curso";
                try {
                    $st = $db->prepare($sql);
                    $st->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    return false;
                }
                echo '<select id="curso" name="curso_id">
                        <option selected disabled>Elija</option>';
                            while ($opcion=$st->fetch(PDO::FETCH_ASSOC)){
                                echo '<option value="'.$opcion['id'].'">'.$opcion['nombre'].'</option>';
                            }
                echo   '</select>';
                ?>
                <br>
                <label for="nota">Nota</label>
                <input class="form-control" type="text" name="nota" id="nota" placeholder="Nota">
                <label for="ficheros">Añadir imagenes</label>
                <input class="form-control" type="file" name="adjuntos" id="ficheros">
                <?php 
                $sql = "SELECT * FROM actividad_extra";
                try {
                    $st = $db->prepare($sql);
                    $st->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    return false;
                }
                while ($fila=$st->fetch(PDO::FETCH_ASSOC)){ ?>
                    
                    <label for="<?php echo $fila['nombre'] ?>"><?php echo $fila['nombre'] ?> </label>
                    <input type="checkbox" id="<?php echo $fila['nombre'] ?>"
                           value="<?php echo $fila['id'] ?>" 
                           name="actividad_extra[]">
                    <br>
                <?php    
                }
                ?>
                
                <input type="submit" value="Enviar">    
            </form>
            <button class="btn btn-info" onclick="location.href='lista_alumno_sin_datatable.php'" type="button">Listado de alumnos</button>
        </div>


        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.9.2/i18n/jquery.ui.datepicker-es.min.js"></script>
        <script>
            $( function() {
                $( "#fecha" ).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showAnim: 'bounce', // con esta línea añadimos animación al datepicker
                    dateFormat:'dd-mm-yy'       
                });
                // con este comando tambien se puede hacer la animación de datepicker $( "#fecha" ).datepicker( "option", "showAnim", "bounce" );
            } );
        </script>
        
        
    </body>
</html>