<?php

class Dogs {
 function gretting() {
    echo "bark!";
 }
}

$the_methods = get_class_methods('Dogs');

foreach ($the_methods as $method) {
    echo $method . "<br>";
}

?>
