<?php
session_start();
require('../script/php/validateuser.php');
require('../model/conn.php');

/* insert input form model ...........        */
function getInput($value,$id) {
	echo "<input type=\"text\" name=\"__ID$id\" value=\"$value\" size=\"12\" />";
}

/* book information							*/
/* display theLibrary table ..	..			*/
function showLibrary($con) {
	/*	Initilize parameters      		*/
	$sql	= " SELECT * FROM bookInfo";
				/*....................................*/
	$pagesize   = 10;                                                /*每页显示的记录数                   */
	$totalRows  = mysql_num_rows(mysql_query($sql,$con));            /*记录总数                          */
	$totalPages = ceil($totalRows/$pagesize);                        /*总页数                           */
	$page       = (isset($_GET['page'])) ? (int) $_GET['page'] : 1 ; /*当前页数                          */
	$start      = $pagesize*($page-1);				                 /*LIMIT偏移量                       */
	$stop       = $pagesize;								         /*LIMIT 返回记录的最大数             */
	$sql        = $sql." limit $start,$stop";
		   /*....................................*/
	$result = mysql_query($sql,$con) or die('Error ...');
	/* table title                     */
	echo
	"<div class=\"myLibrary\">
	<table border=\"1\">
		<tr>
			<td colspan=\"6\">我的图书馆</td>
		</tr>
		<tr>
			<th>图书ID</th>
			<th>图书名</th>
			<th>作者/编著</th>
			<th>出版社</th>
			<th>出版次数</th>
			<th>操作</th>
		</tr>";
	/*	table body                       */
	while ($rowLib = mysql_fetch_array($result)) {
		echo "<tr>";
		echo "<td>".$rowLib['bookid']."</td>";
		echo "<td>";
			getinput($rowLib['bookname'],$rowLib['bookid']);
		echo "</td>";
		echo "<td>";
			getinput($rowLib['bookauthor'],$rowLib['bookid']);
		echo "</td>";
		echo "<td>";
			getinput($rowLib['bookpress'],$rowLib['bookid']);
		echo "</td>";
		echo "<td>";
			getinput($rowLib['bookpublishtimes'],$rowLib['bookid']);
		echo "</td>";
		echo "<td>";
		  echo "<button type=\"button\" onclick=\"return updateLib('".$rowLib['bookid']."');\">更新</button>";
		  echo "<button type=\"button\" onclick=\"return deleteLib('".$rowLib['bookid']."');\">删除</button>";
		  echo "<button type=\"button\" onclick=\"return detailLib('".$rowLib['bookid']."');\">详情</button>";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td colspan=\"6\" id=\"__detail".$rowLib['bookid']."\" style=\"display:none;\">";
		echo "图书详情,(*^__^*) 嘻嘻……";
		echo "</td>";
		echo "</tr>";
	}
	/*  table tail                       */	
	echo
	   "<tr>
			<td id=\"libTips\"></td>
			<td><input type=\"text\" name=\"bookname\" size=\"12\" /></td>
			<td><input type=\"text\" name=\"bookauthor\" size=\"12\" /></td>
			<td><input type=\"text\" name=\"bookpress\" size=\"12\" /></td>
			<td><input type=\"text\" name=\"bookpublishtimes\" size=\"12\" /></td>
			<td><button type=\"button\" onclick=\"return addLib();\">添加</button></td>
		</tr>";
	/* table page code 					*/
		echo"<tr>";
			   echo "<td colspan=\"6\">";
			   echo "<div class=\"pagecode\">";
					/*首页...........*/
				$url = $_SERVER['PHP_SELF'];
				if ($page > 1){
					echo "<label><a href =\"\" onclick=\"return page('1','$url');\">首页</a></label>";
				} else {
					echo "<label>首页</label>";
				} 
					/*上一页.........*/
				if ($page > 1) {
					$prev = $page - 1;
					echo "<label><a href =\"\" onclick=\"return page($prev,'$url');\">上一页</a></label>";
				} else {
					echo "<label>上一页</label>";
				}
					/*页码...........*/
						/*没时间不搞了    */
					/*下一页.........*/	
				if ($totalPages > $page) {
					$next = $page + 1;
					echo "<label><a href =\"\" onclick=\"return page($next,'$url');\">下一页</a></label>";
				} else {
					echo "<label>下一页</label>";
				}
					/*尾页...........*/
				if($page >= $totalPages){
					echo "<label>尾页</label>";
				}else {
					echo "<label>";
					echo "<a href =\"\" onclick=\"return page($totalPages,'$url');\">尾页</a>";
					echo "</label>";
				}
					/*页码嘿嘿........*/
				echo "<label>页数&nbsp;<a>".$page."/".$totalPages."</a></label>";
				echo "<div class=\"clear\"></div></div>";
	            echo"</td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
}/*end showLibrary  */

/*	show book information table                 */
if (isset($_GET['Library'])) {
	showLibrary($con);
	exit();
}
/* add book .	.					*/
if (isset($_POST['addLib'])) {
	$bookname         = $_POST['addLib'];
	$bookauthor       = $_POST['bookauthor'];
	$bookpress        = $_POST['bookpress'];
	$bookpublishtimes = $_POST['bookpublishtimes'];

	/*add book start				*/
	$sql  = " INSERT INTO bookInfo";
	$sql .= " (bookname,bookauthor,bookpress,bookpublishtimes)";
	$sql .= " VALUES";
	$sql .= " ('$bookname','$bookauthor','$bookpress','$bookpublishtimes')";
	$result = mysql_query($sql,$con);
	if ($result) {
		showLibrary($con);
		exit();
	} else {
		exit('Error ....');
	}/*END IF  */
}
/*update book 					*/
if (isset($_POST['updateLib'])) {
	$bookid           = $_POST['updateLib'];
	$bookname         = $_POST['bookname'];
	$bookauthor       = $_POST['bookauthor'];
	$bookpress        = $_POST['bookpress'];
	$bookpublishtimes = $_POST['bookpublishtimes'];
	
	$sql  = " UPDATE bookInfo ";
	$sql .= " SET";
	$sql .= " bookname = '$bookname',bookauthor = '$bookauthor',";
	$sql .= " bookpress='$bookpress',bookpublishtimes='$bookpublishtimes'";
	$sql .= " WHERE bookid = '$bookid'";

	$result = mysql_query($sql,$con);
	if ($result) {
		showLibrary($con);
		exit();
	} else {
		exit('Error ...');
	}
}
/*delete book 						*/
if (isset($_POST['deleteLib'])) {
	$bookid = $_POST['deleteLib'];
	$sql	   = " DELETE FROM bookInfo";
	$sql	  .= " WHERE bookid = '$bookid'";
	
	$result = mysql_query($sql,$con);
	if ($result) {
		showLibrary($con);
		exit();
	} else {
		exit('Error ....');
	}/*END IF .. */
}
/* realize paging ..............*/
if(isset($_GET['page'])){
	showLibrary($con);
	exit();
}
?>
