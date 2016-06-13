<?php
//获取收藏URL
function favoriteUrl($bookid){
	$url = "<a href=\"userInfo.php\"";
	$url .= " onclick=\"return addFavorite(";
	$url .= "'".$bookid."'";
	$url .= ");\" title=\"收藏\">收藏</a>";	
	return $url;
}
?>