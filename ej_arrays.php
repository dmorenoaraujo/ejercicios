<?php

$semana=array('lunes','martes','miercoles','jueves','viernes','sabado');

$edad=array('Dani'=>31,'Paula'=>3,'Adriana'=>0,'Veronica'=>32);

var_dump ($semana);
var_dump ($edad);

$semana[]='domingo';
$edad['Santi']=34;


var_dump ($edad);
var_dump ($semana);

foreach($semana as $dia){
  echo $dia.'<br>';
};

echo '<br>';

foreach($edad as $key=>$value){
  echo $key.' '.$value.'<br>';
};


?>
