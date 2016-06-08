<?php
//获取购买button
function payButton($BookId,$BookName,$BookPrice){
	$button = "<button type=\"button\"";
	$button .= " onclick=\"return addCart(";
	$button .= "'".$BookId."','".$BookName."','".$BookPrice."'";
	$button .= ");\" title=\"购买\">购买</button>";	
	return $button;
}
?>