<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            
            <h1>MODIFICACIÓN DE ALUMNO REALIZADA</h1>
            <?php
                ini_set('display_errors',1);
                ini_set('diplay_startup_errors',1);
                error_reporting(E_ALL);

                $db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','P15!1754123m');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $fecha=str_replace("/","-",date("Y-m-d", strtotime ($_POST['fecha_nacimiento'])));
                
				//COMPROBAMOS SI SE HA MODIFICADO LA IMAGEN, SI NO SE MODIFICA SE MANTIENE LA ANTERIOR
                if ($_FILES['adjuntos']['error']==4){
                    $modificarAdjunto='';
                }else {
                    $nombreAdjunto = md5(uniqid());
                    $ext = end(explode(".", $_FILES['adjuntos']['name']));
                    move_uploaded_file($_FILES['adjuntos']['tmp_name'], 'uploads/'. $nombreAdjunto .'.'.$ext);
                    $modificarAdjunto=", adjunto ='".$nombreAdjunto.".".$ext."'" ;
                };
				
				$sql = "UPDATE alumno 
                        SET   nombre='".$_POST['nombre']."', "
                            ."apellidos='".$_POST['apellidos']."',"
                            ."dni='".$_POST['dni']."',"
                            ."curso_id=".$_POST['curso_id'].","
                            ."nota=".str_replace (",",".",$_POST['nota']).","
                            ."fecha_nacimiento='".date ("Y-m-d", strtotime ($_POST['fecha_nacimiento']))."'"
                            .$modificarAdjunto.
                       "WHERE id=".$_POST['id'].";"
                ;
				try {
                    $st = $db->prepare($sql);
                    $st->execute();/*die('1');*/
                } catch (PDOException $e) {
                    echo $e->getMessage();/*die('2');*/
                    return false;
                }
				
				
				
				$sql = "SELECT actividad_extra_id FROM alumno_actividad WHERE alumno_id=".$_POST['id'];
				try {
				  $st = $db->prepare($sql);
				  $st->execute();
                } catch (PDOException $e) {
				  echo $e->getMessage();
				  return false;
                }
				$antiguasActividadesAlumno=$st->fetchAll(PDO::FETCH_COLUMN);
				$nuevasActividadesAlumno=isset($_POST['actividad_extra'])?$_POST['actividad_extra']:array();
				var_dump($nuevasActividadesAlumno);
				
				$actividadesAnadir=array_diff($nuevasActividadesAlumno, $antiguasActividadesAlumno);
				$actividadesEliminar=array_diff($antiguasActividadesAlumno, $nuevasActividadesAlumno);
				
				foreach ($actividadesAnadir as $actividadAnadida){
				  $sql= "INSERT INTO alumno_actividad (alumno_id, actividad_extra_id)".
						"VALUES (?,?)";
				  
				  try {
					$st = $db->prepare($sql);
					$st->execute(array($_POST['id'],$actividadAnadida));
				  } 
				  catch (PDOException $e) {
					echo $e->getMessage();
					return false;
				  }
				};
				  
				foreach ($actividadesEliminar as $actividadEliminada){
				  $sql= "DELETE FROM alumno_actividad WHERE alumno_id=? AND actividad_extra_id=?";
				  
				  try {
					$st = $db->prepare($sql);
					$st->execute(array($_POST['id'],$actividadEliminada));
				  } 
				  catch (PDOException $e) {
					echo $e->getMessage();
					return false;
				
				  }
				};

            ?>
            <button class="btn btn-info" onclick="location.href='formulario_alumno.php'" type="button">Formulario de alta</button>
            <button class="btn btn-info" onclick="location.href='lista_alumno_sin_datatable.php'" type="button">Listado de alumnos</button>
        </div>

        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

        
        
        

        
    </body>
</html>