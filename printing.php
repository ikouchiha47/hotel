<?php
function printr($value="") 
{
 return  filter_var($value,FILTER_SANITIZE_STRING); 
 
} 
function printrint($value=""){
	return filter_var($value,FILTER_SANITIZE_NUMBER_INT);
}
?>
