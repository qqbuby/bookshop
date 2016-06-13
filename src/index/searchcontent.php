<!-- document.homecontent.start -->
<!-- javascript -->
<!-- stylesheet -->
<!--content.start -->
<div id="content">
<!-- leftClassNav.start -->
<div id="leftClassNav" class="aside">
<?php
include_once("leftaside.php");
?>
</div><!-- leftClassNav.stop -->
<!-- bookContent.start -->
<div class="bookcontent">
<!-- adimage.start -->
<div class="adImage">
<!--<label>广告</label>-->
<?php
include_once("index/ad.php");
?>
</div><!-- adimage.stop -->
<label>&nbsp;&nbsp;搜索结果</label>
<?php
/*...................SearchKeyGet..................*/
$SearchKeyGet;
$SearchKeyGet['bmclassid']   = isset($_GET['bmclassid'])  ? $_GET['bmclassid']  : null; 
$SearchKeyGet['bcclassid']   = isset($_GET['bcclassid'])  ? $_GET['bcclassid']  : null;
$SearchKeyGet['bookname']    = isset($_GET['bookname'])   ? $_GET['bookname']   : null;
$SearchKeyGet['bookauthor']  = isset($_GET['bookauthor']) ? $_GET['bookauthor'] : null;
$SearchKeyGet['bookpress']   = isset($_GET['bookpress'])  ? $_GET['bookpress']  : null;
$SearchKeyGet['bookisbn']    = isset($_GET['bookisbn'])   ? $_GET['bookisbn']   : null;
$SearchKeyGet['bookintroduction'] = isset($_GET['bookintroduction'])? $_GET['bookintroduction']: null;
$condition = null;
$key       = null;
$keyword   = null;
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
/*---handle the backgroud post data and response the search results----*/
	/*....................................*/	
$sql = "SELECT bookid,bookname,bookprice,bookimage FROM bookinfo";
$sql .= " WHERE ".$condition;
$sql = $sql." ORDER BY bookpublishdate DESC";
	/*....................................*/
$pagesize = 20;                                             /*每页显示的记录                 */
$totalRows = mysql_num_rows(mysql_query($sql,$con));        /*记录总                       */
$totalPages = ceil($totalRows/$pagesize);                   /*总页数                        */
$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1 ;	/*当前页数                      */
$start = $pagesize*($page-1);				                /*LIMIT偏移量                   */
$stop = $pagesize;								            /*LIMIT 返回记录的最大数          */
$sql = $sql." limit $start,$stop";
	/*....................................*/
$resultS = mysql_query($sql,$con) or exit(mysql_error());
while($rowS = mysql_fetch_row($resultS)){
	echo "<div class=\"booklist\">";
	echo "<h6><a href=\"bookdetails.php?bookid=".$rowS[0]."\" >".$rowS[1]."</a></h6>";
	echo "<table>";
	echo "<tr>";
	echo "<td colspan=\"2\"><a href=\"bookdetails.php?bookid=".$rowS[0]."\" ><img src=\"".$rowS[3]."\" /></a></td></tr>";
	echo "<tr>";
	echo "<td>定&nbsp;&nbsp;&nbsp;&nbsp;价:</td><td>".$rowS[2]."</td></tr>";
	echo "<tr>";
	echo "<td>会员价:</td><td>".($rowS[2]*7.5)."</td></tr>";
	echo "<tr>";
	echo "<td>";
		echo payUrl($rowS[0],$rowS[1],$rowS[2]);
	echo "</td>";
	echo "<td>";
		echo favoriteUrl($rowS[0]);
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
}
echo "<div class=\"pagecode\">";
	/*首页...........*/
$url = $_SERVER['PHP_SELF']."?page=1";
if ($page > 1){
	echo "<label><a href=\"$url\">首页</a></label>";
} else {
	echo "<label>首页</label>";
} 
if ($page > 1) {
	$prev = $page - 1;
	$url = $_SERVER['PHP_SELF']."?page=$prev";
	echo "<label><a href=\"$url\">上一页</a></label>";
} else {
	echo "<label>上一页</label>";
}
	/*页码...........*/
    	/*没时间不搞了    */
	/*下一页.........*/	
if ($totalPages > $page) {
	$next = $page + 1;
	$url = $_SERVER['PHP_SELF']."?page=$next";
	echo "<label><a href=\"$url\">下一页</a></label>";
} else {
	echo "<label>下一页</label>";
}
	/*尾页...........*/
if($page >= $totalPages){
	echo "<label>尾页</label>";
}else {
	$url = $_SERVER['PHP_SELF']."?page=$totalPages";
	echo "<label><a href=\"$url\">尾页</a></label>";
}
	/*页码嘿嘿........*/
echo "<label>页数&nbsp;<a>".$page."/".$totalPages."</a></label>";
echo "<div class=\"clear\"></div></div>";
?>
</div><!-- bookContent.stop -->
<!-- rangelist.start -->
<div class="ranglist">
<?php
include_once("rangelist.php");
?>
</div><!-- ranglist.stop -->
<div class="clear"></div></div><!-- content.stop -->
<!-- document.homecontent.stop -->
