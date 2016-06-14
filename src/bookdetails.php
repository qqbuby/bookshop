<?php
session_start();
include_once("model/conn.php");
include_once('script/php/payurl.php');
include_once('script/php/favoriteurl.php');
function showbookcomment($bookid,$conn) {
	$sql = "SELECT commenttitle,commentcontent,commentdate,mbname";
	$sql.= " FROM bookcomment,MemberInfo WHERE bookcomment.mbid=MemberInfo.mbid";
	$sql.=" AND bookid='".$bookid."'";
		//....................................//
	$pagesize = 10;     //每页显示的记录数
	$totalRows = mysql_num_rows(mysql_query($sql,$conn)); //记录总数
	$totalPages = ceil($totalRows/$pagesize);    //总页数
	$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1 ;		//当前页数
	$start = $pagesize*($page-1);				//LIMIT偏移量
	$stop = $pagesize;							//LIMIT 返回记录的最大数
	$sql = $sql." ORDER BY commentdate ASC";
	$sql = $sql." limit $start,$stop";
	//....................................//
	$resultC = mysql_query($sql,$conn);
	$i=($page-1)*$pagesize+1;
	while($rowC = mysql_fetch_array($resultC)){
		echo "<div class=\"comment-content\">";
		echo "<label>".$i,"楼</label>";
		echo "<pre><strong>标题:".$rowC['commenttitle']."</strong><br />".$rowC['commentcontent']."</pre>";
		echo "<ul>";
		echo "<li>发表于".$rowC['commentdate']."</li>";
		echo "<li>用户:".$rowC['mbname']."</li>";
		echo "<div class=\"clear\"></div></ul>";
		echo "<hr />";
		echo "</div>";
		$i++;
	}
	echo "<div class=\"pagecode\">";
		//.............首页...........
	$url = $_SERVER['PHP_SELF']."?bookid=$bookid&page=1";
	if ($page > 1){
		echo "<label><a href=\"$url\">首页</a></label>";
	} else {
		echo "<label>首页</label>";
	} 
	if ($page > 1) {
		$prev = $page - 1;
		$url = $_SERVER['PHP_SELF']."?bookid=$bookid&page=$prev";
		echo "<label><a href=\"$url\">上一页</a></label>";
	} else {
		echo "<label>上一页</label>";
	}
		//...........页码.............
	//没时间不搞了。。。。
		//...........下一页............	
	if ($totalPages > $page) {
		$next = $page + 1;
		$url = $_SERVER['PHP_SELF']."?bookid=$bookid&page=$next";
		echo "<label><a href=\"$url\">下一页</a></label>";
	} else {
		echo "<label>下一页</label>";
	}
		//............尾页...............
	if($page >= $totalPages){
		echo "<label>尾页</label>";
	}else {
		$url = $_SERVER['PHP_SELF']."?bookid=$bookid&page=$totalPages";
		echo "<label><a href=\"$url\">尾页</a></label>";
	}
		//............页码嘿嘿...........
	echo "<label>页数&nbsp;<a>".$page."/".$totalPages."</a></label>";
	echo "<div class=\"clear\"></div></div>";
		//........................
}
//Add Comment ..................
if(isset($_POST['commentTitle'])){
	if(!isset($_SESSION['mbid'])){
		echo "login";
		exit();
	}
	$bookid = $_POST['bookid'];
	$commentTitle = $_POST['commentTitle'];
	$commentContent = $_POST['commentContent'];
	$commentDate = date("Y-m-d-H-i-s");
	$mbid = $_SESSION['mbid'];
	$sql = "INSERT INTO bookcomment (bookid,mbid,commenttitle,commentdate,commentcontent)";
	$sql.= " VALUES ('$bookid','$mbid','$commentTitle','$commentDate','$commentContent')";
	mysql_query($sql,$con) or die('error'.mysql_error());
	showbookcomment($bookid,$con);
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="http://localhost/bookshoponline/" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
<link rel="stylesheet" type="text/css" href="style/header.css" />
<link rel="stylesheet" type="text/css" href="style/content.css" />
<title>BookDetails</title>
</head>

<body>
<?php
include_once("model/header.php");
include_once("index/bookdetailscontent.php");
include_once("model/footer.php");
?>
</body>
</html>
