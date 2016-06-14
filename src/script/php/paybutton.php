<?php
//获取购买button
function payButton($bookid,$bookname,$bookprice){
	$button = "<button type=\"button\"";
	$button .= " onclick=\"return addCart(";
	$button .= "'".$bookid."','".$bookname."','".$bookprice."'";
	$button .= ");\" title=\"购买\">购买</button>";	
	return $button;
}
?>