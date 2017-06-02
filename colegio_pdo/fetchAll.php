<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	  <style>
		h1{
			padding-top: 5rem;
		}
	  </style>
  </head>
  <body>
	<div class="container">
	  <h1>PRUEBA FUNCION fetchAll()</h1>
	  <?php
	  ini_set('display_errors',1);
	  ini_set('diplay_startup_errors',1);
	  error_reporting(E_ALL);

	  $db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','P15!1754123m');
	  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	  $sql= "SELECT * FROM curso";
	  try {
		$st = $db->prepare($sql);
		$st->execute();
	  } 
	  catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	  }
	  $cursos=$st->fetchAll(PDO::FETCH_ASSOC);
	  var_dump($cursos);
	  
	  
	  $sql ="SELECT nombre FROM curso";
	  try {
		$st = $db->prepare($sql);
		$st->execute();
	  } 
	  catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	  }
	  $nombreCursos=$st->fetchAll(PDO::FETCH_COLUMN);
	  var_dump($nombreCursos);
	  
	  ?>
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