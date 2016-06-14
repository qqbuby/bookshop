<?php
/*--------用于动态生成购买URL链接---------------*/
//获取购买URL
function payUrl($bookid,$bookname,$bookprice){
	$url = "<a href=\"userInfo.php\"";
	$url .= " onclick=\"return addCart(";
	$url .= "'".$bookid."','".$bookname."','".$bookprice."'";
	$url .= ");\" title=\"购买\">购买</a>";	
	return $url;
}
?>