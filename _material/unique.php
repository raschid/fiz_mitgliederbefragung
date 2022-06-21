<?php
function random_str_generator ($len_of_gen_str){
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890abcdefghijklmnopqrstuvwxyz";
    $var_size = strlen($chars);

    $randstr = '';

    for( $x = 0; $x < $len_of_gen_str; $x++ ) {  
        $randstr .= $chars[ rand( 0, $var_size - 1 ) ];  
    }

    return $randstr;
}

for($i=1;$i<=2000;$i++)
{
    echo random_str_generator (12);
    echo "\n"."<br>";
}

?>