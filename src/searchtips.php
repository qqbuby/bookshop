<?php
require_once("model/conn.php");
if (isset($_GET['flag'])) {
	/*...................SearchKeyGet..................*/
	$SearchKeyGet;
	$SearchKeyGet['BMClassId']   = isset($_GET['BMClassId'])  ? $_GET['BMClassId']  : null; 
	$SearchKeyGet['BCClassId']   = isset($_GET['BCClassId'])  ? $_GET['BCClassId']  : null;
	$SearchKeyGet['BookName']    = isset($_GET['BookName'])   ? $_GET['BookName']   : null;
	$SearchKeyGet['BookAuthor']  = isset($_GET['BookAuthor']) ? $_GET['BookAuthor'] : null;
	$SearchKeyGet['BookPress']   = isset($_GET['BookPress'])  ? $_GET['BookPress']  : null;
	$SearchKeyGet['BookISBN']    = isset($_GET['BookISBN'])   ? $_GET['BookISBN']   : null;
	$SearchKeyGet['BookIntroduction'] = isset($_GET['BookIntroduction'])? $_GET['BookIntroduction']: null;
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
	$sql = "SELECT BookId,BookName,BookPrice,BookImage FROM BookInfo";
	$sql .= " WHERE ".$condition;
	$totalRows = mysql_num_rows(mysql_query($sql,$con));
	$searchTips = "获得约 ".$totalRows." 条结果 （用时 XX 秒）"; 
	echo($searchTips);
}
?>