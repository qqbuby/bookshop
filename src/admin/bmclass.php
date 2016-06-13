<?php
session_start();
require('../script/php/validateuser.php');
require('../model/conn.php');

/* insert input form model ...........        */
function getInput($value,$id) {
	echo "<input type=\"text\" name=\"__ID$id\" value=\"$value\" size=\"12\" />";
}

/* BOOKChildCLASS 										*/
/* display the bookMainClass table ..	..		*/
function showMainClass($con) {
	/*	Initilize parameters      		*/
	$sql	= " SELECT * FROM bookMainClass";
				/*....................................*/
	$pagesize   = 10;                                                /*每页显示的记录数                   */
	$totalRows  = mysql_num_rows(mysql_query($sql,$con));           /*记录总数                          */
	$totalPages = ceil($totalRows/$pagesize);                        /*总页数                           */
	$page       = (isset($_GET['page'])) ? (int) $_GET['page'] : 1 ; /*当前页数                         */
	$start      = $pagesize*($page-1);				                  /*LIMIT偏移量                      */
	$stop       = $pagesize;								          /*LIMIT 返回记录的最大数             */
	$sql        = $sql." limit $start,$stop";
		   /*....................................*/
	$result = mysql_query($sql,$con) or die('Error ...');
	/* table title                     */
	echo
	"<div class=\"bookInfo\">
	<table>
		<tr>
			<td colspan=\"5\">一级分类表</td>
		</tr>
		<tr>
			<th>分类ID</th>
			<th>分类名</th>
			<th>常用标识</th>
			<th>访问量</th>
			<th>操作</th>
		</tr>";
	/*	table body                       */
	while ($rowBM = mysql_fetch_array($result)) {
		echo "<tr>";
		echo "<td>".$rowBM['bmclassid']."</td>";
		echo "<td>";
			getinput($rowBM['bmclassname'],$rowBM['bmclassid']);
		echo "</td>";
		echo "<td>";
			echo "<select name=\"__ID".$rowBM['bmclassid']."\">";
			echo "<option value=\"".$rowBM['bmclasslabel']."\">";
			switch ($rowBM['bmclasslabel']){
			case 0:
				echo "是";
				break;
			case 1:
				echo "否";
				break;
			default:
			}
			echo "</option>";
			echo "<option value=\"0\">是</option>";
			echo "<option value=\"1\">否</option>";
			echo "</select>";
		echo "</td>";
		echo "<td>".$rowBM['bmclassviewcount']."</td>";
		echo "<td>";
		  echo "<button type=\"button\" onclick=\"return updateMC('".$rowBM['bmclassid']."');\">更新</button>";
		  echo "<button type=\"button\" onclick=\"return deleteMC('".$rowBM['bmclassid']."');\">删除</button>";
		echo "</td>";
		echo "</tr>";
	}
	/*  table tail                       */	
	echo
	   "<tr>
			<td id=\"MCtips\"></td>
			<td><input type=\"text\" name=\"bmclassname\" size=\"12\" /></td>
			<td>
				<select name=\"bmclasslabel\">
					<option value=\"0\">是</option>
					<option value=\"1\">否</option>
				</select>
			</td>
			<td></td>
			<td><button type=\"button\" onclick=\"return addMC();\">添加</button></td>
		</tr>";
	/* table page code 					*/
		echo"<tr>";
			   echo "<td colspan=\"5\">";
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
}/*end showMainClass  */

/*	show bookmainclass table                 */
if (isset($_GET['BMClass'])) {
	header('Content-type:charset=utf-8;');
	showMainClass($con);
	exit();
}
/* add bookMainClass .	.					*/
if (isset($_POST['addMC'])) {
	$bmclassname  = $_POST['addMC'];
	$bmclasslabel = $_POST['bmclasslabel'];
	/*validate the data uniqueness ...		*/
	$sql  = " SELECT * FROM bookMainClass";
	$sql .= " WHERE bmclassname = '$bmclassname'";
	
	$result = mysql_query($sql,$con);
	$num 	= mysql_num_rows($result);
	if ($num > 0) {
		exit('0');
	}
	/*add bookMainClass start				*/
	$sql  = " INSERT INTO bookMainClass";
	$sql .= " (bmclassname,bmclasslabel)";
	$sql .= " VALUES";
	$sql .= " ('$bmclassname','$bmclasslabel')";
	$result = mysql_query($sql,$con);
	if ($result) {
		showMainClass($con);
		exit();
	} else {
		exit('Error ....'.mysql_error());
	}/*END IF  */
}
/*update bookMainClass						*/
if (isset($_POST['updateMC'])) {
	$bmclassid    = $_POST['updateMC'];
	$bmclassname  = $_POST['bmclassname'];
	$bmclasslabel = $_POST['bmclasslabel'];
	
	$sql  = " UPDATE bookMainClass ";
	$sql .= " SET bmclassname = '$bmclassname',bmclasslabel = '$bmclasslabel'";
	$sql .= " WHERE bmclassid = '$bmclassid'";
	
	$result = mysql_query($sql,$con);
	if ($result) {
		showMainClass($con);
		exit();
	} else {
		exit('Error ...');
	}
}
/*delete bookMainClass 						*/
if (isset($_POST['deleteMC'])) {
	$bmclassid = $_POST['deleteMC'];
	$sql	   = " DELETE FROM bookMainClass";
	$sql	  .= " WHERE bmclassid = '$bmclassid'";
	
	$result = mysql_query($sql,$con);
	if ($result) {
		showMainClass($con);
		exit();
	} else {
		exit('Error ....');
	}/*END IF .. */
}
/* realize paging ..............*/
if(isset($_GET['page'])){
	showMainClass($con);
	exit();
}
?>