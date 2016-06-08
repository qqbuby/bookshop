<?php
/*<!-- myFavorite.start -->*/
session_start();
include_once("../script/php/validateMember.php");
include_once("../model/conn.php");
include_once("../script/php/payButton.php");
/*show Favorite table datas ........*/
function showFavorite($con){
	$sql = "SELECT FavoriteId,BookInfo.BookId as BookId";
	$sql .= ",BookName,BookPrice,BookGrade,BookStorage,FavoriteDate ";
	$sql .= "FROM favorites,BookInfo ";
	$sql .= "WHERE favorites.BookId = BookInfo.BookId AND MbId = '".$_SESSION['MbId']."'";
			/*....................................*/
	$pagesize   = 10;                                                /*每页显示的记录数                   */
	$totalRows  = mysql_num_rows(mysql_query($sql,$con));           /*记录总数                          */
	$totalPages = ceil($totalRows/$pagesize);                        /*总页数                           */
	$page       = (isset($_GET['page'])) ? (int) $_GET['page'] : 1 ; /*当前页数                         */
	$start      = $pagesize*($page-1);				                  /*LIMIT偏移量                      */
	$stop       = $pagesize;								          /*LIMIT 返回记录的最大数             */
	$sql        = $sql." limit $start,$stop";
		   /*....................................*/
	//exit($sql);
	$result = mysql_query($sql,$con);
	echo "<div class=\"myFavorite\">";
	echo "<table>";
	echo "<tr>";
	echo "<td colspan=\"8\">我的收藏</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<th>收藏架ID</th>";
	echo "<th>书名</th>";
	echo "<th>星级</th>";
	echo "<th>定价</th>";
	echo "<th>库存量</th>";
	echo "<th>收藏日期</th>";
	echo "<th>操作</th>";
	echo "</tr>";
	while($rowF = mysql_fetch_array($result)){
		echo "<tr>";
		echo "<td>".$rowF['FavoriteId']."</td>";
		echo "<td>".$rowF['BookName']."</td>";
		echo "<td>".$rowF['BookGrade']."</td>";
		echo "<td>".$rowF['BookPrice']."</td>";
		echo "<td>".$rowF['BookStorage']."</td>";
		echo "<td>".$rowF['FavoriteDate']."</td>";
		echo "<td>";
			echo payButton($rowF['BookId'],$rowF['BookName'],$rowF['BookPrice']);
			echo "<button type=\"button\" onclick=\"deleteFavorite('";
			echo $rowF['BookId']."');\" style=\"margin-left:2px;\">取消</button>";
		echo "</td>";
		echo "</tr>";
	}
		echo "<tr>";
	echo "<td colspan=\"8\">";
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
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
}	/*display favorite table data ...stop().....*/

	//delete favorite .........
if(isset($_POST['deleteFavorite'])){
	$BookId = $_POST['deleteFavorite'];
	$sql = "DELETE FROM Favorites";
	$sql .= " WHERE BookId='".$BookId."'";
	$result = mysql_query($sql);
	if($result){
		showFavorite($con);
		exit();
	} else {
		exit("Error ... ... ");
	}
}
	//Add favorite ..............
if(isset($_POST['addFavorite'])){
	//Initilize parameters .....
	$BookId = $_POST['addFavorite'];
	$MbId = $_SESSION['MbId'];
	$FavoriteDate = date("Y-m-d");
	//verify the favorites uniquensess
	$sql = "SELECT * FROM Favorites";
	$sql .= " WHERE BookId='$BookId'";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);
	if($num >0){
		exit('该书已收藏,谢谢！');
	}
	$sql = "INSERT INTO Favorites (BookId,MbId,FavoriteDate)";
	$sql .= " VALUES('$BookId','$MbId','$FavoriteDate')";
	$result = mysql_query($sql);
	if($result){
		exit('已放入收藏架!');
	}else{
		exit('出错啦.....');
	}
}
//function to display the favorite tables data .........
if (isset($_GET['Favorite'])) {
	showFavorite($con);
	exit();
}
?>
<!-- myFavorite.stop -->