<?php
session_start();
include_once("../script/php/validateMember.php");
include_once("../model/conn.php");
/* display the data of the Order table ...*/
function showOrder($con){
	$MbId = $_SESSION['MbId'];
	$sql  = " SELECT OrderId,BookName,OrderCount,OrderAmount,OrderPayment,";
	$sql .= " OrderDelivery,OrderDate,OrderArrival,OrderStatus FROM OrderInfo,BookInfo";
	$sql .= " WHERE OrderInfo.BookId = BookInfo.BookId AND MbId='$MbId'";
	$sql .= " ORDER BY OrderStatus,OrderArrival";	
		/*....................................*/
	$pagesize   = 10;                                                /*每页显示的记录数                   */
	$totalRows  = mysql_num_rows(mysql_query($sql,$con));           /*记录总数                          */
	$totalPages = ceil($totalRows/$pagesize);                        /*总页数                           */
	$page       = (isset($_GET['page'])) ? (int) $_GET['page'] : 1 ; /*当前页数                         */
	$start = $pagesize*($page-1);				                     /*LIMIT偏移量                      */
	$stop = $pagesize;								                 /*LIMIT 返回记录的最大数             */
	$sql = $sql." limit $start,$stop";
		/*....................................*/
	//exit($sql);
	$result = mysql_query($sql,$con);
	echo "<table>";
	echo "<tr>";
	echo "<td colspan=\"9\">我的订单</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<th>订单ID</th>";
	echo "<th>书名</th>";
	echo "<th>订购数量</th>";
	echo "<th>订购总额</th>";
	echo "<th>支付方式</th>";
	echo "<th>送货方式</th>";
	echo "<th>订购日期</th>";
	echo "<th>处理日期</th>";
	echo "<th>订单状态</th>";
	echo "</tr>";
	while ($rowOr = mysql_fetch_array($result)) {
		echo "<tr>";
		echo "<td>".$rowOr['OrderId']."</td>";
		echo "<td>".$rowOr['BookName']."</td>";
		echo "<td>".$rowOr['OrderCount']."</td>";
		echo "<td>".$rowOr['OrderAmount']."</td>";
		echo "<td>".$rowOr['OrderPayment']."</td>";
		echo "<td>".$rowOr['OrderDelivery']."</td>";
		echo "<td>".$rowOr['OrderDate']."</td>";
		echo "<td>".$rowOr['OrderArrival']."</td>";
		/* show Order Status         */
			switch($rowOr['OrderStatus']){
				case 0:
					echo "<td class=\"status0\">正在处理...</td>";
					break;
				case 1:
					echo "<td class=\"status1\">已经处理....</td>";
					break;
				case 2:
					echo "<td class=\"status2\">已经废除....</td>";
				default:
			}
		/*-----------            */
		echo "</tr>";
	}
	/*page code 		*/
	echo "<tr>";
	echo "<td colspan=\"9\">";
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
}
//purchase processor
if(isset($_POST['addOrder'])){
	$MbId = $_SESSION['MbId'];
	$BookId = $_POST['addOrder'];
	$OrderCount = $_POST['OrderCount'];
	$OrderAmount = $_POST['OrderAmount'];
	$OrderPayment = $_POST['OrderPayment'];
	$OrderDelivery = $_POST['OrderDelivery'];
	$OrderDate = date('Y-m-d');
	$sql = "INSERT INTO OrderInfo (MbId,BookId,OrderCount,";
	$sql .= "OrderAmount,OrderPayment,OrderDelivery,OrderDate)";
	$sql .= " VALUES ('$MbId','$BookId','$OrderCount','$OrderAmount',";
	$sql .= "'$OrderPayment','$OrderDelivery','$OrderDate')";
	$result = mysql_query($sql,$con);
	if($result){
		showOrder($con);
		exit();
	}else{
		exit('Error');
	}
}
/* display Order table ......*/
if (isset($_GET['Order'])) {
	showOrder($con);
}
/* realize paging ..............*/
if(isset($_GET['page'])){
	showOrder($con);
	exit();
}
?>