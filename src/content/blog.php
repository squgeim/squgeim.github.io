<?php

include './vendor/parsedown/Parsedown.php';

$Parsedown = new Parsedown();

$blog = file_get_contents($argv[1]);

echo $Parsedown->text($blog);


?>
