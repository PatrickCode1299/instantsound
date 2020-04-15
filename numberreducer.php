<?php
function number_format_short($n,$precision = 1){
if($n < 900){
	$n_format=number_format($n, $precision);
	$suffix="";
}elseif ($n < 900000) {
	$n_format=number_format($n/1000, $precision);
	$suffix="K";
}elseif ($n < 900000000) {
	$n_format=number_format($n/1000000, $precision);
	$suffix="M";
}elseif ($n < 900000000000) {
	$n_format=number_format($n/100000000000, $precision);
	$suffix="B";
}else{
	$n_format=number_format($n/10000000000000, $precision);
	$suffix="T";
}
if($precision > 0){
	$dotzero='.'.str_repeat('0', $precision);
	$n_format=str_replace($dotzero, '', $n_format);
}
return $n_format.$suffix;
}
?>