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
            table thead td{
                text-transform: capitalize;
            }
            table tbody td img{
                width: 50px;
                height: 50px;
            }

        </style>
    </head>
    <body>
        <div class="container">
            <h1>ALUMNOS DEL COLEGIO MOLÓN</h1>

            <?php
            ini_set('display_errors',1);
            ini_set('diplay_startup_errors',1);
            error_reporting(E_ALL);
                
            $db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','P15!1754123m');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //mysqli_set_charset($conn, 'utf8');
            
            $sql = "SELECT * FROM alumno";

            //$result = $conn->query($sql);
            
            try {
                $st = $db->prepare($sql);
                $st->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
            
            $primerafila= $st->fetch(PDO::FETCH_ASSOC);
            
            //$nombrecolumnas=array_keys($primerafila);
            
            echo '<table id="mitabla" class="display" width="100%" cellspacing="0">';
            echo "<thead>";
            echo "<tr>";
            foreach ($primerafila as $clave => $nombrecolumna){
                //var_dump ($clave);
                //var_dump ($nombrecolumna);
                if ($clave == 'curso_id'){
                    echo "<td>" . str_replace ("curso_id","Nº Curso",$clave) . "</td>";
                } else if ($clave == 'nota'){
                    echo "<td>" . $clave . "</td>";
                } else if ($clave == 'fecha_nacimiento' || 'fecha_alta'){
                    echo "<td style='text-align: center'>" . str_replace ("fecha_","Fecha de ",$clave) . "</td>";
                } else {
                    echo "<td>" . $clave . "</td>";
                }
            }
            
            echo "<td>Acciones</td></tr>";
            echo "</thead>";
            echo "<tbody>";

            listar($primerafila);
              //echo "<td>". $elementosprimerafila . "</td>";            


            while ($fila=$st->fetch(PDO::FETCH_ASSOC)){
                listar($fila);
            }
            echo "</tbody>";
            echo "</table>";

            //$conn->close();

            
            
            function listar($item){
                echo "<tr>";
                echo "<td>".$item['id']."</td>";
                echo "<td>".$item['curso_id']."</td>";
                echo "<td>".$item['nombre']."</td>";
                echo "<td>".$item['apellidos']."</td>";
                echo "<td>".$item['dni']."</td>";
                echo "<td style='text-align:right'>". $nota = number_format($item['nota'],2,',','.') . "</td>"; 
                echo "<td  style='text-align: center'>". date ("d-m-Y", strtotime ($item['fecha_nacimiento']))."</td>";
                echo "<td><img src='uploads/".$item['adjunto']."'></td>";
                echo "<td>".$item['fecha_alta']."</td>";
                echo "<td><a href='editar_alumno.php?id=".$item['id']."'>Editar</a>"
                     ."<br><a href='eliminar_alumno.php?id=".$item['id']."'>Eliminar</a></td>";
                echo "</tr>";                
            }
            ?>

            <button class="btn btn-info" onclick="location.href='formulario_alumno.php'" type="button">Formulario de alta</button>


        </div>


        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/colreorder/1.3.3/js/dataTables.colReorder.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
        <script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/datetime-moment.js"></script>
        <script>
            $(document).ready(function () {
                $.fn.dataTable.moment ('DD-MM-YYYY'),
                $('#mitabla').dataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    "lengthMenu": [50, 10, 25],
                    "colReorder": true
                });
            });
            
        </script>
    </body>
</html>