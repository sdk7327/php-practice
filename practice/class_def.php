<?php

class Dogs {
    var $body_length = 24;
    var $leg_length = 6;

 function greeting() {
    return "bark! From a height of " . $this->leg_length . " inches";
 }

 function warning() {
    echo "bark! bark!";
 }

}

$corgi = new Dogs();
$mutt = new Dogs();


echo $corgi->leg_length . " inches";
echo "<br>";
echo $mutt->leg_length = 14 . " inches";
echo "<br>";
echo $corgi->greeting();

?>
