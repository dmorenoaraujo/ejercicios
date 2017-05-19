<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        
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
            <h1>ALUMNOS DEL COLEGIO CON QUERY</h1>

            <?php
            //ini_set('display_errors',1);
            //ini_set('diplay_startup_errors',1);
            //error_reporting(E_ALL);
                
            $db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','P15!1754123m');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //var_dump ($_SERVER['QUERY_STRING']);
            
            list($sort,$order)=explode("&",$_SERVER['HTTP_REFERER']);
            $sort=end(explode("=",$sort));
            $order=end(explode("=",$order));
            
            var_dump($_SERVER['HTTP_REFERER']);
            var_dump($sort);
            
            var_dump($order);
            
            var_dump($_GET);
           
            
            if ( $_GET == NULL ){
                $sql = "SELECT * FROM alumno"
                ;   
            } else if($_GET[order] === $order){
                if($sort='ASC'){
                    $sort='DESC';
                }else{
                    $sort='ASC';
                }
                $sql = "SELECT * FROM alumno
                        ORDER BY ". $_GET[order]." ".$sort;
            } else {
                $sql = "SELECT * FROM alumno
                        ORDER BY ". $_GET[order];    
            };

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
                    echo "<td><a href='http://localhost/colegio_pdo/lista_alumno_1.php?sort=ASC&order=".$clave."'>" . str_replace ("curso_id","Nº Curso",$clave) . "</a</td>";
                } else if ($clave == 'fecha_nacimiento' || 'fecha_alta'){
                    echo "<td style='text-align: center'><a href='http://localhost/colegio_pdo/lista_alumno_1.php?sort=ASC&order=".$clave."'>" . str_replace ("fecha_","Fecha de ",$clave) . "</a></td>";
                } else {
                    echo "<td><a href='http://localhost/colegio_pdo/lista_alumno_1.php?sort=".$sort."ASC&order=".$clave."'>" . $clave . "</a></td>";
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
    </body>
</html>