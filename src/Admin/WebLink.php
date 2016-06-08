<?php
session_start();
require('../script/php/validateUser.php');
require('../model/conn.php');

/* insert input form model ...........        */
function getInput($value,$id) {
	echo "<input type=\"text\" name=\"__ID$id\" value=\"$value\" size=\"12\" />";
}

/* display the WebLink table ..	..		*/
function showWebLink($con) {
	/*	Initilize parameters      		*/
	$sql	    = " SELECT * FROM webLink";
	$sql       .= " ORDER BY LinkLabel";
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
	"<div class=\"webLink\">
	<table>
		<tr>
			<td colspan=\"6\">友情链接表</td>
		</tr>
		<tr>
			<th>链接ID</th>
			<th>链接名</th>
			<th>链接URL</th>
			<th>链接图片</th>
			<th>链接标识</th>
			<th>操作</th>
		</tr>";
	/*	table body                       */
	while ($rowWL = mysql_fetch_array($result)) {
		echo "<tr>";
		echo "<td>".$rowWL['LinkId']."</td>";
		echo "<td>";
			getinput($rowWL['LinkName'],$rowWL['LinkId']);
		echo "</td>";
		echo "<td>";
			getinput($rowWL['LinkUrl'],$rowWL['LinkId']);
		echo "</td>";
		echo "<td>";
			getinput($rowWL['LinkImage'],$rowWL['LinkId']);
		echo "</td>";		
		echo "<td>";
			echo "<select name=\"__ID".$rowWL['LinkId']."\">";
			echo "<option value=\"".$rowWL['LinkLabel']."\">";
			switch ($rowWL['LinkLabel']){
			case 0:
				echo "内链接";
				break;
			case 1:
				echo "外链接";
				break;
			default:
			}
			echo "</option>";
			echo "<option value=\"0\">内链接</option>";
			echo "<option value=\"1\">外链接</option>";
			echo "</select>";
		echo "</td>";
		echo "<td>";
		  echo "<button type=\"button\" onclick=\"return updateWL('".$rowWL['LinkId']."');\">更新</button>";
		  echo "<button type=\"button\" onclick=\"return deleteWL('".$rowWL['LinkId']."');\">删除</button>";
		echo "</td>";
		echo "</tr>";
	}
	/*  table tail                       */	
	echo
	   "<tr>
			<td id=\"WLtips\"></td>
			<td><input type=\"text\" name=\"LinkName\" size=\"12\" /></td>
			<td><input type=\"text\" name=\"LinkUrl\" size=\"12\" /></td>
			<td><input type=\"text\" name=\"LinkImage\" size=\"12\" /></td>
			<td>
				<select name=\"LinkLabel\">
					<option value=\"0\">内链接</option>
					<option value=\"1\">外链接</option>
				</select>
			</td>
			<td><button type=\"button\" onclick=\"return addWL();\">添加</button></td>
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
}/*end showWebLink  */

/*	show webLink table                 */
if (isset($_GET['Weblink'])) {
	showWebLink($con);
	exit();
}
/* add webLink .	.					*/
if (isset($_POST['addWL'])) {
	$LinkName  = $_POST['addWL'];
	$LinkLabel = $_POST['LinkLabel'];
	$LinkUrl   = $_POST['LinkUrl'];
	
	$path      = $_POST['LinkImage'];
	$pathinfo  = pathinfo($path);
	$extension = strtolower($pathinfo['extension']);
	if ($extension != 'gif') {
		exit('0');
	}
	$LinkImage = "image/webLinkImage/".$pathinfo['basename'];
	$AddPerson = $_SESSION['adminId'];
	
	/*validate the data uniqueness ...		*/
	$sql  = " SELECT * FROM webLink";
	$sql .= " WHERE LinkName = '$LinkName'";
	
	$result = mysql_query($sql,$con);
	$num 	= mysql_num_rows($result);
	if ($num > 0) {
		exit('1');
	}
	/*add webLink start				*/
	$sql  = " INSERT INTO webLink";
	$sql .= " (LinkName,LinkUrl,LinkImage,LinkLabel,AddPerson)";
	$sql .= " VALUES";
	$sql .= " ('$LinkName','$LinkUrl','$LinkImage','$LinkLabel','$AddPerson')";
	$result = mysql_query($sql,$con);
	if ($result) {
		showWebLink($con);
		exit();
	} else {
		exit('Error ....');
	}/*END IF  */
}
/*update webLink						*/
if (isset($_POST['updateWL'])) {
	$LinkId	   = $_POST['updateWL'];
	$LinkName  = $_POST['LinkName'];
	$LinkLabel = $_POST['LinkLabel'];
	$LinkUrl   = $_POST['LinkUrl'];
	
	$path      = $_POST['LinkImage'];
	$pathinfo  = pathinfo($path);
	$extension = strtolower($pathinfo['extension']);
	if ($extension != 'gif') {
		exit('0');
	}
	$LinkImage = "image/webLinkImage/".$pathinfo['basename'];
	$AddPerson = $_SESSION['adminId'];
	
	/*validate the data uniqueness ...		
	$sql  = " SELECT * FROM webLink";
	$sql .= " WHERE LinkName = '$LinkName'";
	
	$result = mysql_query($sql,$con);
	$num 	= mysql_num_rows($result);
	if ($num > 0) {
		exit('1');
	}*/
	
	$sql  = " UPDATE webLink ";
	$sql .= " SET LinkName = '$LinkName',LinkUrl= '$LinkUrl',";
	$sql .= " LinkImage = '$LinkImage',LinkLabel = '$LinkLabel',AddPerson='$AddPerson";
	$sql .= " WHERE LinkId = '$LinkId'";

	$result = mysql_query($sql,$con);
	if ($result) {
		showWebLink($con);
		exit();
	} else {
		exit('Error ...');
	}
}
/*delete webLink						*/
if (isset($_POST['deleteWL'])) {
	$LinkId = $_POST['deleteWL'];
	$sql	   = " DELETE FROM webLink";
	$sql	  .= " WHERE LinkId = '$LinkId'";
	
	$result = mysql_query($sql,$con);
	if ($result) {
		showWebLink($con);
		exit();
	} else {
		exit('Error ....');
	}/*END IF .. */
}
/* realize paging ..............*/
if (isset($_GET['page'])){
	showMainClass($con);
	exit();
}

/*show manual .................*/
if (isset($_GET['Manual'])) {
	echo"
		<div class=\"webLink\" style=\"text-align:left; font-size:16px;\">
		<pre>
		1. 链接图片目前只支持gif格式文件。
		2. 目前没有图片预览功能,后期必会完善.
		3. 文件上传文件夹必须在根目录image/weblinkimage/中。
		4. 添加或者修改时，请直接填写文件全名,如xxx.gif。
		5. 更新时，有可能导致同名记录...		
		6. 关于上述缺陷,后期有待完善,敬请谅解!
		</pre>
		</div>";
}
?>