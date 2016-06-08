<?php
session_start();
require('../script/php/validateUser.php');
require('../model/conn.php');

/* order Information              					*/
/* display the order Information table ..	..		*/
function showOrder($con) {
	/*	Initilize parameters      		*/
	$sql	    = " SELECT * FROM orderInfo";
	$sql       .= " ORDER BY OrderStatus,OrderDate";
				/*....................................*/
	$pagesize   = 10;                                                /*每页显示的记录数                   */
	$totalRows  = mysql_num_rows(mysql_query($sql,$con));           /*记录总数                          */
	$totalPages = ceil($totalRows/$pagesize);                        /*总页数                           */
	$page       = (isset($_GET['page'])) ? (int) $_GET['page'] : 1 ; /*当前页数                         */
	$start      = $pagesize*($page-1);				                  /*LIMIT偏移量                      */
	$stop       = $pagesize;								          /*LIMIT 返回记录的最大数             */
	$sql       .= " limit $start,$stop";
		   /*....................................*/
	$result = mysql_query($sql,$con) or die('Error ...');
	/* table title                     */
	echo
	"<div class=\"orderInfo\">
	<table>
		<tr>
			<td colspan=\"12\">用户订单信息表</td>
		</tr>
		<tr>
			<th>订单ID</th>
			<th>订货人ID</th>
			<th>图书ID</th>
			<th>订购数量</th>
			<th>总额</th>
			<th>支付方式</th>
			<th>送货方式</th>
			<th>订购日期</th>
			<th>处理日期</th>
			<th>处理人ID</th>
			<th>状态</th>
			<th>操作</th>
		</tr>";
	/*	table body                       */
	while ($rowOr = mysql_fetch_array($result)) {
		echo "<tr>";
		echo "<td>".$rowOr['OrderId']."</td>";
		echo "<td>".$rowOr['MbId']."</td>";
		echo "<td>".$rowOr['BookId']."</td>";
		echo "<td>".$rowOr['OrderCount']."</td>";
		echo "<td>".$rowOr['OrderAmount']."</td>";
		echo "<td>".$rowOr['OrderPayment']."</td>";
		echo "<td>".$rowOr['OrderDelivery']."</td>";
		echo "<td>".$rowOr['OrderDate']."</td>";
		echo "<td>".$rowOr['OrderArrival']."</td>";
		echo "<td>".$rowOr['UserId']."</td>";
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
		echo "<td>";
			if ($rowOr['OrderStatus'] == 0) {
				echo "<button type=\"button\" onclick=\"return disposeOrder('".$rowOr['OrderId']."');\">";
		  		echo "处理</button>";
			} elseif ($rowOr['OrderStatus'] == 1) {
				echo "<button type=\"button\" onclick=\"return abolishOrder('".$rowOr['OrderId']."');\">";
		  		echo "废除</button>";
			} else {
				echo "<button type=\"button\" >已废除</button>";
			}
		echo "</td>";
		echo "</tr>";
	}
	/*  table tail                       */	

	/* table page code 					*/
		echo"<tr>";
			   echo "<td colspan=\"12\">";
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
}/*end showOrder  */

/*	show Order Information table                 */
if (isset($_GET['Order'])) {
	header('Content-type:charset=utf-8;');
	showOrder($con);
	exit();
}
/*dispose order					*/
if (isset($_POST['disposeOrder'])) {
	$OrderId      = $_POST['disposeOrder'];
	$UserId       = $_SESSION['adminId']; 
	$OrderArrival = date('Y-m-d');
	$OrderStatus  = '1';
	
	$sql  = " UPDATE OrderInfo";
	$sql .= " SET UserId = '$UserId',OrderStatus = '$OrderStatus',OrderArrival='$OrderArrival'";
	$sql .= " WHERE OrderId = '$OrderId'";
	
	$result = mysql_query($sql,$con);
	if ($result) {
		showOrder($con);
		exit();
	} else {
		exit('Error ...');
	}
}
/*abolish order					*/
if (isset($_POST['abolishOrder'])) {
	$OrderId      = $_POST['abolishOrder'];
	$UserId       = $_SESSION['adminId']; 
	$OrderArrival = date('Y-m-d');
	$OrderStatus  = '2';
	
	$sql  = " UPDATE OrderInfo";
	$sql .= " SET UserId = '$UserId',OrderStatus = '$OrderStatus',OrderArrival='$OrderArrival'";
	$sql .= " WHERE OrderId = '$OrderId'";
	
	$result = mysql_query($sql,$con);
	if ($result) {
		showOrder($con);
		exit();
	} else {
		exit('Error ...');
	}
}
/* realize paging ..............*/
if(isset($_GET['page'])){
	showOrder($con);
	exit();
}
?>