<?php
function number_to_str($number){

		$number=$number-1;

      $alphabet = range('a', 'z');
	  return $alphabet[$number]; 


    }
	
	function alpha_to_number($code)
{
    $alphabets = array('', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');

    $sumval = 0;

    $code = strtolower(trim($code));

    $arr = str_split($code);
    $arr_length = count($arr);

    for($i = 0, $j = $arr_length-1; $i < $arr_length; $i++, $j--)
    {
        $arr_value = array_search($arr[$i], $alphabets);
        $sumval = $sumval + ($arr_value * pow(26, $j));
    }

    return $sumval;
}
	?>