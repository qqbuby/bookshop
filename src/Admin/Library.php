<?php
session_start();
require('../script/php/validateUser.php');
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
		echo "<td>".$rowLib['BookId']."</td>";
		echo "<td>";
			getinput($rowLib['BookName'],$rowLib['BookId']);
		echo "</td>";
		echo "<td>";
			getinput($rowLib['BookAuthor'],$rowLib['BookId']);
		echo "</td>";
		echo "<td>";
			getinput($rowLib['BookPress'],$rowLib['BookId']);
		echo "</td>";
		echo "<td>";
			getinput($rowLib['BookPublishTimes'],$rowLib['BookId']);
		echo "</td>";
		echo "<td>";
		  echo "<button type=\"button\" onclick=\"return updateLib('".$rowLib['BookId']."');\">更新</button>";
		  echo "<button type=\"button\" onclick=\"return deleteLib('".$rowLib['BookId']."');\">删除</button>";
		  echo "<button type=\"button\" onclick=\"return detailLib('".$rowLib['BookId']."');\">详情</button>";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td colspan=\"6\" id=\"__detail".$rowLib['BookId']."\" style=\"display:none;\">";
		echo "图书详情,(*^__^*) 嘻嘻……";
		echo "</td>";
		echo "</tr>";
	}
	/*  table tail                       */	
	echo
	   "<tr>
			<td id=\"libTips\"></td>
			<td><input type=\"text\" name=\"BookName\" size=\"12\" /></td>
			<td><input type=\"text\" name=\"BookAuthor\" size=\"12\" /></td>
			<td><input type=\"text\" name=\"BookPress\" size=\"12\" /></td>
			<td><input type=\"text\" name=\"BookPublishTimes\" size=\"12\" /></td>
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
	$BookName         = $_POST['addLib'];
	$BookAuthor       = $_POST['BookAuthor'];
	$BookPress        = $_POST['BookPress'];
	$BookPublishTimes = $_POST['BookPublishTimes'];

	/*add book start				*/
	$sql  = " INSERT INTO bookInfo";
	$sql .= " (BookName,BookAuthor,BookPress,BookPublishTimes)";
	$sql .= " VALUES";
	$sql .= " ('$BookName','$BookAuthor','$BookPress','$BookPublishTimes')";
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
	$BookId           = $_POST['updateLib'];
	$BookName         = $_POST['BookName'];
	$BookAuthor       = $_POST['BookAuthor'];
	$BookPress        = $_POST['BookPress'];
	$BookPublishTimes = $_POST['BookPublishTimes'];
	
	$sql  = " UPDATE bookInfo ";
	$sql .= " SET";
	$sql .= " BookName = '$BookName',BookAuthor = '$BookAuthor',";
	$sql .= " BookPress='$BookPress',BookPublishTimes='$BookPublishTimes'";
	$sql .= " WHERE BookId = '$BookId'";

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
	$BookId = $_POST['deleteLib'];
	$sql	   = " DELETE FROM bookInfo";
	$sql	  .= " WHERE BookId = '$BookId'";
	
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
