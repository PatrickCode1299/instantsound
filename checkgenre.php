<?php
function checkgenre($param){
if($param=='Rap'){
	return "Rapper";
}elseif($param=='Afropop'){
	return "Afropop";
}elseif ($param=='R&B') {
return "Soul Artiste";
}elseif ($param=='Instrumentalist') {
return "Instrumentalist";
}
else{
	return "Other";
}
}
?>