<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <style>
            label{
                text-transform: uppercase;
                font-family: Verdana;
            }
            button{
                margin: 2rem;
            }
        </style>
    </head>
    <body>
        <div class="container">
            
            <h1>EDICION DE ALUMNOS</h1>

            <form action="modificar_alumno.php" method="post" enctype="multipart/form-data">
                
                <?php
                ini_set('display_errors',1);
                ini_set('diplay_startup_errors',1);
                error_reporting(E_ALL);
                
                $db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','P15!1754123m');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $sql = "SELECT * FROM alumno WHERE id=".$_GET['id'];

                //$result = $conn->query($sql);
            
                try {
                    $st = $db->prepare($sql);
                    $st->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    return false;
                }

                $alumno=$st->fetch(PDO::FETCH_ASSOC);
                
                foreach ($alumno as $clave => $valor){
                    
                    if ($clave == 'id') {
                        echo "<div class='form-group row' style='display:none'>";
                            echo "<label for='".$clave."'>".$clave."</label>";
                            echo "<input class='form-control' type='text' name='".$clave."' id='".$clave."' value='".$valor."'>";
                        echo "</div>";
                    } else if ($clave == 'fecha_alta'){
                        echo "<div class='form-group row' style='display:none'>";
                            echo "<label for='".$clave."'>".$clave."</label>";
                            echo "<input class='form-control' type='text' name='".$clave."' id='".$clave."' value='".$valor."'>";
                        echo "</div>";  
                    } else if ($clave == 'curso_id'){

                        
                        $sql = "SELECT * FROM curso";
                        try {
                            $st = $db->prepare($sql);
                            $st->execute();
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                            return false;
                        }
                        echo "<div class='form-group row'>";
                        echo "<label for='curso'>curso</label>";
                        echo "<select id='curso' name='curso_id'>";
                                               
                        while ($opcion=$st->fetch(PDO::FETCH_ASSOC)){
                            //var_dump ($opcion);
                            //var_dump ($valor);
                        
                            if ($valor == $opcion ['id']){
                                echo "<option value='".$opcion['id']."' selected='selected'>".$opcion['nombre']."</option>";
                            }else {
                                echo "<option value='".$opcion['id']."'>".$opcion['nombre']."</option>";
                            }
                        }
                        echo   "</select>";
                        echo "</div>"; 
                        
                    } else if ($clave == 'adjunto') {
                        echo "<img src='uploads/".$valor."'>";
                        echo "<div class='form-group row'>";
                        echo "<label for='ficheros'>Añadir otra imagen</label>";
                        echo "<input class='form-control' type='file' name='adjuntos' id='ficheros'>";
                        echo "</div>"; 
                    } else if ($clave == 'nota') {
                        echo "<div class='form-group row'>";
                        echo "<label for='".$clave."'>".$clave."</label>";
                        echo "<input class='form-control' type='text' name='".$clave."' id='".$clave."' value='".number_format($valor,2,',','.')."'>";
                        echo "</div>";
                    } else if ($clave == 'fecha_nacimiento'){
                        echo "<div class='form-group row'>";
                        echo "<label for='".$clave."'>".$clave."</label>";
                        echo "<input class='form-control' type='text' name='".$clave."' id='fecha' value='". date ("d-m-Y", strtotime ($valor))."'>";
                        echo "</div>";
                    } else {
                        echo "<div class='form-group row'>";
                            echo "<label for='".$clave."'>".$clave."</label>";
                            echo "<input class='form-control' type='text' name='".$clave."' id='".$clave."' value='".$valor."'>";
                        echo "</div>";    
                    }
                    
                }
				?>
			  
			<h3>ACTIVIDADES EXTRAESCOLARES</h3>
				
				<?php
				$sql = "SELECT actividad_extra_id FROM alumno_actividad WHERE alumno_id=".$_GET['id'];
				
				try {
                    $st = $db->prepare($sql);
                    $st->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    return false;
                }
				
				/*$actividadesAlumno=array();
				while ($fila = $st->fetch(PDO::FETCH_ASSOC)){
				  $actividadesAlumno[]=$fila['actividad_extra_id'];  //con $actividadesAlumno[]= se van añadiendo registros al final del array
				}*/
				
				$actividadesAlumno=$st->fetchAll(PDO::FETCH_COLUMN);
				
				$sql = "SELECT * FROM actividad_extra";
                try {
                    $st = $db->prepare($sql);
                    $st->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    return false;
                }
				
                while ($fila=$st->fetch(PDO::FETCH_ASSOC)){ 
				  ?>
                    
                    <label for="<?php echo $fila['nombre'] ?>"><?php echo $fila['nombre'] ?> </label>
              <?php if (in_array($fila['id'],$actividadesAlumno)){?>
					  <input type="checkbox" id="<?php echo $fila['nombre'] ?>"
							 value="<?php echo $fila['id'] ?>" 
							 name="actividad_extra[]" checked>
					  <br>
			  <?php } else {?>
					  <input type="checkbox" id="<?php echo $fila['nombre'] ?>"
							 value="<?php echo $fila['id'] ?>" 
							 name="actividad_extra[]">
					  <br>
					  
					  
				<?php	  
					}
				}
                ?>
                <input type="submit" value="Modificar">
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
                    dateFormat: 'dd-mm-yy',
                });
                // con este comando tambien se puede hacer la animación de datepicker $( "#fecha" ).datepicker( "option", "showAnim", "bounce" );
            } );
        </script>
        
        
    </body>
</html>