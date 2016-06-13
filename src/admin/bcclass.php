<?php
session_start();
require('../script/php/validateuser.php');
require('../model/conn.php');

/* insert input form model ...........        */
function getInput($value,$id) {
	echo "<input type=\"text\" name=\"__ID$id\" value=\"$value\" size=\"12\" />";
}

/*BOOKCHILDCLASS										*/
/* dipslay the bookClildClass table date 		*/
function showChildClass($con) {
	/*table title 					*/
	echo 
   "<div class=\"bookInfo\">
	<table>
		<tr>
			<td colspan=\"6\">二级分类表</td>
		</tr>
		<tr>
			<th>分类ID</th>
			<th>分类名</th>
			<th>常用标识</th>
			<th>访问量</th>
			<th>一级分类</th>
			<th>操作</th>
		</tr>";
	/*talbe body 					*/
	$sqlC  = " SELECT bcclassid,bcclassname
		    ,bcclasslabel,bcclassviewcount,bmclassname,bookChildClass.bmclassid as bmclassid";
	$sqlC .= " FROM bookChildClass,bookMainClass";
	$sqlC .= " WHERE bookChildClass.bmclassid = bookMainClass.bmclassid";
	$sqlC .= " ORDER BY bmclassid,bcclassname";
		/*....................................*/
	$pagesize   = 10;                                                /*每页显示的记录数                   */
	$totalRows  = mysql_num_rows(mysql_query($sqlC,$con));           /*记录总数                          */
	$totalPages = ceil($totalRows/$pagesize);                        /*总页数                           */
	$page       = (isset($_GET['page'])) ? (int) $_GET['page'] : 1 ; /*当前页数                         */
	$start = $pagesize*($page-1);				                     /*LIMIT偏移量                      */
	$stop = $pagesize;								                 /*LIMIT 返回记录的最大数             */
	$sqlC = $sqlC." limit $start,$stop";
		/*....................................*/
	$sqlM  = " SELECT bmclassid,bmclassname FROM bookMainClass";
	
	$resultC = mysql_query($sqlC,$con) or die('Error ...');
	
	while ($rowBC = mysql_fetch_array($resultC)) {
		echo "<tr>";
		echo "<td>".$rowBC['bcclassid']."</td>";
		echo "<td>";
			getinput($rowBC['bcclassname'],$rowBC['bcclassid']);
		echo "</td>";
		echo "<td>";
			echo "<select name=\"__ID".$rowBC['bcclassid']."\">";
			echo "<option value=\"".$rowBC['bcclasslabel']."\">";
			switch ($rowBC['bcclasslabel']){
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
		echo "<td>".$rowBC['bcclassviewcount']."</td>";
		echo "<td>";
			echo "<select name=\"__ID".$rowBC['bcclassid']."\">";
			echo "<option value=\"".$rowBC['bmclassid']."\">".$rowBC['bmclassname']."</option>";
			$resultM = mysql_query($sqlM,$con) or die('Error ...');		
			while ($rowMC = mysql_fetch_array($resultM)) {
				echo "<option value='".$rowMC['bmclassid']."'>".$rowMC['bmclassname']."</option>";
			}
			echo "</select>";
		echo "</td>";
	    echo "<td>";
		echo "<button type=\"buttton\" onclick=\"return updateCC('".$rowBC['bcclassid']."');\">更新</button>";
		echo "<button type=\"buttton\" onclick=\"return deleteCC('".$rowBC['bcclassid']."');\">删除</button>";
	    echo "</td>";
		echo "</tr>";
	}
	/* talbe tail 					*/
	echo 
	   "<tr>
			<td id=\"CCtips\"></td>
			<td><input type=\"text\" name=\"bcclassname\" size=\"12\" /></td>
			<td>
				<select name=\"bcclasslabel\">
					<option value=\"0\">是</option>
					<option value=\"1\">否</option>
				</select>
			</td>
			<td></td>
			<td>";
			echo "<select name=\"bmclassid\">";
			$resultM = mysql_query($sqlM,$con) or die('Error ...');
			while ($rowMC = mysql_fetch_array($resultM)) {
				echo "<option value='".$rowMC['bmclassid']."'>".$rowMC['bmclassname']."</option>";
			}
			echo "</select>
			</td>
			<td><button type=\"button\" onclick=\"return addCC();\">添加</button></td>
		</tr>";
	/* page code 				*/
	echo "<tr>";
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
}
/* show bookChildClass						*/
if (isset($_GET['BCClass'])) {
	showChildClass($con);
	exit();
}
/*add book Child Class 						*/
if (isset($_POST['addCC'])) {
	$bcclassname  = $_POST['addCC'];
	$bcclasslabel = $_POST['bcclasslabel'];
	$bmclassid 	  = $_POST['bmclassid'];
	/*validate the data uniqueness ...		*/
	$sql  = " SELECT * FROM bookChildClass";
	$sql .= " WHERE bcclassname = '$bcclassname'";
	
	$result = mysql_query($sql,$con);
	$num 	= mysql_num_rows($result);
	if ($num > 0) {
		exit('0');
	}
	/*add bookChildClass start				*/
	$sql  = " INSERT INTO bookChildClass";
	$sql .= " (bcclassname,bcclasslabel,bmclassid)";
	$sql .= " VALUES";
	$sql .= " ('$bcclassname','$bcclasslabel','$bmclassid')";
	$result = mysql_query($sql,$con);
	if ($result) {
		showChildClass($con);
		exit();
	} else {
		exit('Error ....');
	}/*END IF  */
}
/*update bookChildClass						*/
if (isset($_POST['updateCC'])) {
	$bcclassid    = $_POST['updateCC'];
	$bcclassname  = $_POST['bcclassname'];
	$bcclasslabel = $_POST['bcclasslabel'];
	$bmclassid    = $_POST['bmclassid'];
	$sql  = " UPDATE bookChildClass ";
	$sql .= " SET bcclassname = '$bcclassname',bcclasslabel = '$bcclasslabel',bmclassid='$bmclassid'";
	$sql .= " WHERE bcclassid = '$bcclassid'";
	$result = mysql_query($sql,$con) or die(mysql_error());
	if ($result) {
		showChildClass($con);
		exit();
	} else {
		exit('Error ...');
	}
}
/*delete bookChildClass 						*/
if (isset($_POST['deleteCC'])) {
	$bcclassid = $_POST['deleteCC'];
	$sql	   = " DELETE FROM bookChildClass";
	$sql	  .= " WHERE bcclassid = '$bcclassid'";
	
	$result = mysql_query($sql,$con);
	if ($result) {
		showChildClass($con);
		exit();
	} else {
		exit('Error ....');
	}/*END IF .. */
}
/* realize paging ..............*/
if(isset($_GET['page'])){
	showChildClass($con);
	exit();
}
?>