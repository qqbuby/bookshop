<?php
session_start();
require('../script/php/validateUser.php');
require('../model/conn.php');

/* Member Information              					*/
/* display the Member Information table ..	..		*/
function showMember($con) {
	/*	Initilize parameters      		*/
	$sql	    = " SELECT * FROM memberInfo";
	$sql       .= " ORDER BY MbId,MbDate,MbDeleted";
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
	"<div class=\"memberInfo\">
	<table>
		<tr>
			<td colspan=\"9\">会员信息表</td>
		</tr>
		<tr>
			<th>会员ID</th>
			<th>会员昵称</th>
			<th>会员密码</th>
			<th>会员等级</th>
			<th>消费积分</th>
			<th>注册日期</th>
			<th>在线时间</th>
			<th>状态</th>
			<th>操作</th>
		</tr>";
	/*	table body                       */
	while ($rowMb = mysql_fetch_array($result)) {
		echo "<tr>";
		echo "<td>".$rowMb['MbId']."</td>";
		echo "<td>".$rowMb['MbName']."</td>";
		echo "<td>".$rowMb['MbPassword']."</td>";
		echo "<td>".$rowMb['MbLevel']."</td>";
		echo "<td>".$rowMb['MbPoints']."</td>";
		echo "<td>".$rowMb['MbDate']."</td>";
		echo "<td>".$rowMb['MbTime']."</td>";
		/* show member Status (MbDeleted..)     */
			switch($rowMb['MbDeleted']){
				case 0:
					echo "<td class=\"status0\">正&nbsp;常....</td>";
					break;
				case 1:
					echo "<td class=\"status1\">已封侯....</td>";
					break;
				case 2:
					echo "<td class=\"status2\">已废除....</td>";
				default:
			}
		/*-----------            */
		echo "<td>";
			if ($rowMb['MbDeleted'] == 0) {
				echo "<button type=\"button\" onclick=\"return banMb('".$rowMb['MbId']."');\">";
		  		echo "封侯</button>";
				echo "<button type=\"button\" onclick=\"return abolishMb('".$rowMb['MbId']."');\">";
		  		echo "废除</button>";
			} elseif ($rowMb['MbDeleted'] == 1) {
				echo "<button type=\"button\" onclick=\"return unsetMb('".$rowMb['MbId']."');\">";
		  		echo "解封</button>";
				echo "<button type=\"button\" onclick=\"return abolishMb('".$rowMb['MbId']."');\">";
		  		echo "废除</button>";
			} else {
				echo "<button type=\"button\" >已废除....</button>";
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
}/*end showMember  */

/*	show Member Information table              */
if (isset($_GET['Member'])) {
	header('Content-type:charset=utf-8;');
	showMember($con);
	exit();
}
/*ban member            				*/
if (isset($_POST['banMb'])) {
	$MbId      = $_POST['banMb'];
	$MbDeleted = 1;
	
	$sql  = " UPDATE memberInfo";
	$sql .= " SET MbDeleted = '$MbDeleted'";
	$sql .= " WHERE MbId = '$MbId'";
	
	$result = mysql_query($sql,$con);
	if ($result) {
		showMember($con);
		exit();
	} else {
		exit('Error ...');
	}
}
/*unset member				*/
if (isset($_POST['unsetMb'])) {
	$MbId      = $_POST['unsetMb'];
	$MbDeleted = 0;
	
	$sql  = " UPDATE memberInfo";
	$sql .= " SET MbDeleted = '$MbDeleted'";
	$sql .= " WHERE MbId = '$MbId'";
	
	$result = mysql_query($sql,$con);
	if ($result) {
		showMember($con);
		exit();
	} else {
		exit('Error ...');
	}
}
/*abolish member				*/
if (isset($_POST['abolishMb'])) {
	$MbId      = $_POST['abolishMb'];
	$MbDeleted = 2;
	
	$sql  = " UPDATE memberInfo";
	$sql .= " SET MbDeleted = '$MbDeleted'";
	$sql .= " WHERE MbId = '$MbId'";
	
	$result = mysql_query($sql,$con);
	if ($result) {
		showMember($con);
		exit();
	} else {
		exit('Error ...');
	}
}
/* realize paging ..............*/
if(isset($_GET['page'])){
	showMbder($con);
	exit();
}
?>