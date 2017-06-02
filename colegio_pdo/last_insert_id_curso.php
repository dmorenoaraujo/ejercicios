<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            
            <h1>PRUEBA DE COMANDO lastInsertId</h1>
            <?php
                //ini_set('display_errors',1);
                //ini_set('diplay_startup_errors',1);
                //error_reporting(E_ALL);

                $db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','P15!1754123m');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              

               
                try {
					$sql = "INSERT INTO curso 
					  (nombre)
					  VALUES
					  ('4º A')";
					$st = $db->prepare($sql);
                    $st->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    return false;
                }
                
				var_dump($idUltimoCursoInsertado=$db->lastInsertId());

            ?>
         
		</div>


        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="crossorigin="anonymous"></script>
        
    </body>
</html>