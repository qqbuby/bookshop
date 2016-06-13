<?php
require_once("model/conn.php");
if (isset($_GET['flag'])) {
	/*...................SearchKeyGet..................*/
	$SearchKeyGet;
	$SearchKeyGet['bmclassid']   = isset($_GET['bmclassid'])  ? $_GET['bmclassid']  : null; 
	$SearchKeyGet['bcclassid']   = isset($_GET['bcclassid'])  ? $_GET['bcclassid']  : null;
	$SearchKeyGet['bookname']    = isset($_GET['bookname'])   ? $_GET['bookname']   : null;
	$SearchKeyGet['bookauthor']  = isset($_GET['bookauthor']) ? $_GET['bookauthor'] : null;
	$SearchKeyGet['bookpress']   = isset($_GET['bookpress'])  ? $_GET['bookpress']  : null;
	$SearchKeyGet['bookisbn']    = isset($_GET['bookisbn'])   ? $_GET['bookisbn']   : null;
	$SearchKeyGet['bookintroduction'] = isset($_GET['bookintroduction'])? $_GET['bookintroduction']: null;
	$condition = null;        /*查询条件字符串        */
	$key       = null;        /*查询字段             */
	$keyword   = null;        /*查询关键字           */
	foreach($SearchKeyGet as $k=>$v){
		if(trim($v) == ''){
			continue;
		}
		$key     .= trim($k);
		$keyword .= trim($v);
	}
	if ($keyword == "") {
		$condition .="FALSE";
	} else {
		$condition .=$key." LIKE '%".$keyword."%'";
	}
	/*-----handle the backgroud post data and response the search results----*/
	$sql = "SELECT bookid,bookname,bookprice,bookimage FROM BookInfo";
	$sql .= " WHERE ".$condition;
	$totalRows = mysql_num_rows(mysql_query($sql,$con));
	$searchTips = "获得约 ".$totalRows." 条结果 （用时 XX 秒）"; 
	echo($searchTips);
}
?>