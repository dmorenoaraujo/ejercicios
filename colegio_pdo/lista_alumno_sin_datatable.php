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
            <h1><a href="lista_alumno_sin_datatable.php">ALUMNOS DEL COLEGIO CON QUERY</a></h1>

            <?php
            //ini_set('display_errors',1);
            //ini_set('diplay_startup_errors',1);
            //error_reporting(E_ALL);
                
            $db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','P15!1754123m');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sort=isset($_GET[sort])?$_GET[sort]:'ASC';
            $columsort=isset($_GET[columsort])?$_GET[columsort]:'id';
            
            
            $sql= "SELECT COUNT(*) from alumno";
            try {
                $st = $db->prepare($sql);
                $st->execute();
                
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }            
            $numTotalAlumnos = $st->fetch(PDO::FETCH_ASSOC);
            $numAlumnosPagina = 4;
            $numPaginas= ceil($numTotalAlumnos ['COUNT(*)']/ $numAlumnosPagina);
            $paginaActual=isset($_GET[pagina])?$_GET[pagina]:1;
            //LEEMOS LOS DATOS DE MYSQL, ORDENAMOS Y PAGINAMOS SI SE PASAN DATOS EN $_GET
            if ( $_GET[columsort] == NULL ){
                $sql = "SELECT * FROM alumno LIMIT ".$numAlumnosPagina." OFFSET ".($paginaActual-1)*$numAlumnosPagina;
            } else {
                $sql = "SELECT * FROM alumno ".
                        " ORDER BY ".$columsort." ".$sort.  
                        " LIMIT ".$numAlumnosPagina." OFFSET ".($paginaActual-1)*$numAlumnosPagina;
            };
            
            try {
                $st = $db->prepare($sql);
                $st->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
            
            $primerafila= $st->fetch(PDO::FETCH_ASSOC);
            echo '<table id="mitabla" class="display" width="100%" cellspacing="0">';
            echo "<thead>";
            echo "<tr>";
            //ESCRIBIMOS LAS CABECERAS
            foreach ($primerafila as $clave => $nombrecolumna){
                //COMPROBAMOS SI ES NECESARIO PERMUTAR EL TIPO DE ORDENACIÓN 
                if($_GET[columsort]==$clave){  
                    if ($_GET[sort]=='ASC'){
                        $togglesort='DESC';
                    } else {
                        $togglesort='ASC';
                    }
                } else {
                    $togglesort='ASC';
                }
                //PINTAMOS CABECERAS CON LINKS DE ORDENACIÓN
                if ($clave == 'curso_id'){
                    echo "<td><a href='http://localhost/colegio_pdo/lista_alumno_sin_datatable.php?sort=".$togglesort."&columsort=".$clave."'>" . str_replace ("curso_id","Nº Curso",$clave) . "</a</td>";
                } else if ($clave == 'fecha_nacimiento' || 'fecha_alta'){
                    echo "<td style='text-align: center'><a href='http://localhost/colegio_pdo/lista_alumno_sin_datatable.php?sort=".$togglesort."&columsort=".$clave."'>" . str_replace ("fecha_","Fecha de ",$clave) . "</a></td>";
                } else {
                    echo "<td><a href='http://localhost/colegio_pdo/lista_alumno_sin_datatable.php?sort=".$togglesort."&columsort=".$clave."'>" . $clave . "</a></td>";
                }
            }
            echo "<td>Acciones</td></tr>";
            echo "</thead>";
            echo "<tbody>";
            listar($primerafila);//PINTAMOS EL PRIMER REGISTRO DE MYSQL
            //RECORREMOS EL RESTO DE REGISTROS DE MYSQL
            while ($fila=$st->fetch(PDO::FETCH_ASSOC)){
                listar($fila);
            }
            echo "</tbody>";
            echo "</table>";
            
            
            //LINKS DE PAGINACIÓN DESHABILITANDO LOS INUTILES O INCOHERENTES
            if($paginaActual==1){
                echo "<a style='pointer-events:none' href='lista_alumno_sin_datatable.php?pagina=1&sort=".$sort."&columsort=".$columsort."'><<</a>";
                echo "<a style='pointer-events:none' href='lista_alumno_sin_datatable.php?pagina=".($paginaActual-1)."&sort=".$sort."&columsort=".$columsort."'> < </a>";
                for ( $i=0; $i<$numPaginas ; $i++ ){
                    if ($paginaActual==($i+1)){
                        echo "<a style='pointer-events:none' href='lista_alumno_sin_datatable.php?pagina=". ($i+1) ."&sort=".$sort."&columsort=".$columsort."'>".($i+1)."</a>";
                    } else {
                        echo "<a href='lista_alumno_sin_datatable.php?pagina=". ($i+1) ."&sort=".$sort."&columsort=".$columsort."'>".($i+1)."</a>";
                    }
                    
                }
                echo "<a href='lista_alumno_sin_datatable.php?pagina=".($_GET[pagina]+1)."&sort=".$sort."&columsort=".$columsort."'> > </a>";
                echo "<a href='lista_alumno_sin_datatable.php?pagina=".$numPaginas."&sort=".$sort."&columsort=".$columsort."'> >> </a>";
            } else if ($paginaActual==$numPaginas){
                echo "<a href='lista_alumno_sin_datatable.php?pagina=1&sort=".$sort."&columsort=".$columsort."'><<</a>";
                echo "<a href='lista_alumno_sin_datatable.php?pagina=".($paginaActual-1)."&sort=".$sort."&columsort=".$columsort."'> < </a>";
                for ( $i=0; $i<$numPaginas ; $i++ ){
                    if ($paginaActual==($i+1)){
                        echo "<a style='pointer-events:none' href='lista_alumno_sin_datatable.php?pagina=". ($i+1) ."&sort=".$sort."&columsort=".$columsort."'>".($i+1)."</a>";
                    } else {
                        echo "<a href='lista_alumno_sin_datatable.php?pagina=". ($i+1) ."&sort=".$sort."&columsort=".$columsort."'>".($i+1)."</a>";
                    }
                    
                }
                echo "<a style='pointer-events:none' href='lista_alumno_sin_datatable.php?pagina=".($_GET[pagina]+1)."&sort=".$sort."&columsort=".$columsort."'> > </a>";
                echo "<a style='pointer-events:none' href='lista_alumno_sin_datatable.php?pagina=".$numPaginas."&sort=".$sort."&columsort=".$columsort."'> >> </a>";
            } else {
                echo "<a href='lista_alumno_sin_datatable.php?pagina=1&sort=".$sort."&columsort=".$columsort."'><<</a>";
                echo "<a href='lista_alumno_sin_datatable.php?pagina=".($paginaActual-1)."&sort=".$sort."&columsort=".$columsort."'> < </a>";
                for ( $i=0; $i<$numPaginas ; $i++ ){
                    if ($paginaActual==($i+1)){
                        echo "<a style='pointer-events:none' href='lista_alumno_sin_datatable.php?pagina=". ($i+1) ."&sort=".$sort."&columsort=".$columsort."'>".($i+1)."</a>";
                    } else {
                        echo "<a href='lista_alumno_sin_datatable.php?pagina=". ($i+1) ."&sort=".$sort."&columsort=".$columsort."'>".($i+1)."</a>";
                    }
                    
                }
                echo "<a href='lista_alumno_sin_datatable.php?pagina=".($_GET[pagina]+1)."&sort=".$sort."&columsort=".$columsort."'> > </a>";
                echo "<a href='lista_alumno_sin_datatable.php?pagina=".$numPaginas."&sort=".$sort."&columsort=".$columsort."'> >> </a>";
            }       
            //FUNCION PARA LISTADO DE REGISTROS DE MYSQL
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
                     ."<br><a class='eliminar' href='eliminar_alumno.php?id=".$item['id']."'>Eliminar</a></td>";
                echo "</tr>";                
            }
            ?>

            <button class="btn btn-info" onclick="location.href='formulario_alumno.php'" type="button">Formulario de alta</button>


        </div>


        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="crossorigin="anonymous"></script>
        <script>
            $('.eliminar').on('click',function(){
                return confirm ('Va a proceder a borrar al alumno, ¿es correcto?');
            });
        </script>
    </body>
</html>