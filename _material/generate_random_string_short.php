<?php
/**
 *
 * erzeugt alphanumerischen String gewünschter Länge
 * am 21.06.22 habe ich 18.000 Strings mit Länge 12 erzeugt - keine Duplikate dabei!
 *
 */

$length = 12;
$str = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

for($i=0;$i<1000; $i++){
    echo substr(str_shuffle($str), 0, $length);
    echo "\n";
}

?>