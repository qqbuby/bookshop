<?php
//获取收藏URL
function favoriteUrl($BookId){
	$url = "<a href=\"userInfo.php\"";
	$url .= " onclick=\"return addFavorite(";
	$url .= "'".$BookId."'";
	$url .= ");\" title=\"收藏\">收藏</a>";	
	return $url;
}
?>