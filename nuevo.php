<?php
  echo "foobar";
  var_dump($_GET);


$conn = new mysqli("localhost", "root", "P15!1754123m", "colegio");
if ($conn->connect_errno != 0){
  echo "ERROR DE CONEXIÓN, REVISE CREDENCIALES Y/O SERVIDOR";
}else{
  echo "CONECTADO";
}

var_dump($conn);

$sql = "INSERT INTO alumno (nombre,apellidos,fecha_nacimiento) VALUES ('" . $_GET['nombre'] . "','" . $_GET['apellidos']. "','" . $_GET['fecha_nacimiento']. "')";

var_dump($sql);

$conn->query($sql);

$conn->close();
?>
