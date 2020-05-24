<?php

class Dogs {
 function greeting() {
    echo "bark!";
 }

 function warning() {
    echo "bark! bark!";
 }

}

$corgi = new Dogs();
$mutt = new Dogs();


$corgi->greeting();

?>
