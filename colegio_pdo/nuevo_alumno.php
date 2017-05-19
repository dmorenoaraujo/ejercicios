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
                ini_set('display_errors',1);
                ini_set('diplay_startup_errors',1);
                error_reporting(E_ALL);

                $db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','P15!1754123m');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //$conn = new mysqli("localhost", "root", "P15!1754123m", "colegio");
                //mysqli_set_charset($conn, 'utf8');
                
                //var_dump($db);
                
                /*if ($conn->connect_errno != 0){
                  echo "ERROR DE CONEXIÓN, REVISE CREDENCIALES Y/O SERVIDOR";
                }*/
                $nombreAdjunto = md5(uniqid());
                
                $ext = end(explode(".", $_FILES['adjuntos']['name']));
                
                var_dump($ext);
                var_dump($_FILES);
                //var_dump($nombreAdjunto);
                
                move_uploaded_file($_FILES['adjuntos']['tmp_name'], 'uploads/'. $nombreAdjunto .'.'.$ext);

                $sql = "INSERT INTO alumno (nombre,apellidos,dni,fecha_nacimiento,curso_id,nota,adjunto) 
                        VALUES (
                            '" . $_POST['nombre'] . "',
                            '" . $_POST['apellidos']. "',
                            '" . $_POST['dni']. "',    
                            '" . date ("Y-m-d", strtotime ($_POST['fecha_nacimiento'])). "',
                            '" . $_POST['curso_id']. "',
                            '" . str_replace (",",".",$_POST['nota']). "', 
                            '" . $nombreAdjunto . '.' . $ext . "' )";
                
                try {
                    $st = $db->prepare($sql);
                    $st->execute();/*die('1');*/
                } catch (PDOException $e) {
                    echo $e->getMessage();/*die('2');*/
                    return false;
                }
                //var_dump($sql);

                //$conn->query($sql);

                //$conn->close();

            ?>
            <button class="btn btn-info" onclick="location.href='formulario_alumno.php'" type="button">Formulario de alta</button>
            <button class="btn btn-info" onclick="location.href='lista_alumno.php'" type="button">Listado de alumnos</button>
        </div>


        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="crossorigin="anonymous"></script>
        
    </body>
</html>