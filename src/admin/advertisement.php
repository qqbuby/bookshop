<?php
session_start();
require('../script/php/validateuser.php');
require('../model/conn.php');

/* insert input form model ...........        */
function getInput($value,$id) {
	echo "<input type=\"text\" name=\"__ID$id\" value=\"$value\" size=\"6\" />";
}

/* display the WebAd table ..	..		*/
function showAdvertisement($con) {
	/*	Initilize parameters      		*/
	$sql	    = " SELECT * FROM advertisementInfo";
	$sql       .= " ORDER BY adbusiness";
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
	"<div class=\"webAd\">
	<table>
		<tr>
			<td colspan=\"9\">广告信息表</td>
		</tr>
		<tr>
			<th>广告ID</th>
			<th>广告赞助商</th>
			<th>链接URL</th>
			<th>链接图片</th>
			<th>广告权值</th>
			<th>广告说明</th>			
			<th>处理人ID</th>
			<th>操作</th>
		</tr>";
	/*	table body                       */
	while ($rowAd = mysql_fetch_array($result)) {
		echo "<tr>";
		echo "<td>".$rowAd['adid']."</td>";
		echo "<td>";
			getinput($rowAd['adbusiness'],$rowAd['adid']);
		echo "</td>";
		echo "<td>";
			getinput($rowAd['adurl'],$rowAd['adid']);
		echo "</td>";
		echo "<td>";
			getinput($rowAd['adimage'],$rowAd['adid']);
		echo "</td>";
		echo "<td>";
			getinput($rowAd['adpower'],$rowAd['adid']);	
		echo "</td>";
		echo "<td>";
			getinput($rowAd['addescription'],$rowAd['adid']);	
		echo "</td>";
		echo "<td>".$rowAd['addperson']."</td>";
		echo "<td>";
		  echo "<button type=\"button\" onclick=\"return updateAd('".$rowAd['adid']."');\">更新</button>";
		  echo "<button type=\"button\" onclick=\"return deleteAd('".$rowAd['adid']."');\">删除</button>";
		echo "</td>";
		echo "</tr>";
	}
	/*  table tail                       */	
	echo
	   "<tr>
			<td id=\"Adtips\"></td>
			<td><input type=\"text\" name=\"adbusiness\" size=\"6\" /></td>
			<td><input type=\"text\" name=\"adurl\" size=\"6\" /></td>
			<td><input type=\"text\" name=\"adimage\" size=\"6\" /></td>
			<td><input type=\"text\" name=\"adpower\" size=\"6\" /></td>
			<td><input type=\"text\" name=\"addescription\" size=\"12\" /></td>
			<td></td>
			<td><button type=\"button\" onclick=\"return addAd();\">添加</button></td>
		</tr>";
	/* table page code 					*/
		echo"<tr>";
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
	            echo"</td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
}/*end showWebAd  */

/*	show advertisement table                 */
if (isset($_GET['advertisement'])) {
	showAdvertisement($con);
	exit();
}
/* add Ad .	.					*/
if (isset($_POST['addAd'])) {
	$adbusiness    = $_POST['addAd'];
	$adimage       = $_POST['adimage'];
	$adurl         = $_POST['adurl'];
	$addescription = $_POST['addescription'];
	
	$path      = $_POST['adimage'];
	$pathinfo  = pathinfo($path);
	$extension = strtolower($pathinfo['extension']);
	if ($extension != 'gif') {
		exit('0');
	}
	$adimage = "image/webadimage/".$pathinfo['basename'];
	$addperson = $_SESSION['adminId'];
	
	/*validate the data uniqueness ...		*/
	$sql  = " SELECT * FROM advertisementInfo";
	$sql .= " WHERE adbusiness = '$adbusiness'";
	
	$result = mysql_query($sql,$con);
	$num 	= mysql_num_rows($result);
	if ($num > 0) {
		exit('1');
	}
	/*add Ad start				*/
	$sql  = " INSERT INTO advertisementInfo";
	$sql .= " (adbusiness,adurl,adimage,addescription,addperson)";
	$sql .= " VALUES";
	$sql .= " ('$adbusiness','$adurl','$adimage','$addescription','$addperson')";
	$result = mysql_query($sql,$con);
	if ($result) {
		showAdvertisement($con);;
		exit();
	} else {
		exit('Error ....'.mysql_error());
	}/*END IF  */
}
/*update Advertisement						*/
if (isset($_POST['updateAd'])) {
	$adid	       = $_POST['updateAd'];
	$adbusiness    = $_POST['adbusiness'];
	$adpower       = $_POST['adpower'];
	$adurl         = $_POST['adurl'];
	$addescription = $_POST['addescription'];
	
	/*validate the adimage type (gif)       */
	$path      = $_POST['adimage'];
	$pathinfo  = pathinfo($path);
	$extension = strtolower($pathinfo['extension']);
	if ($extension != 'gif') {
		exit('0');
	}
	$adimage = "image/adimage/".$pathinfo['basename'];
	
	/*validate the data uniqueness ...		
	$sql  = " SELECT * FROM advertisementInfo";
	$sql .= " WHERE adbusiness = '$adbusiness'";
	
	$result = mysql_query($sql,$con);
	$num 	= mysql_num_rows($result);
	if ($num > 0) {
		exit('1');
	}*/
	
	$sql  = " UPDATE AdvertisementInfo ";
	$sql .= " SET adbusiness = '$adbusiness',adurl= '$adurl',";
	$sql .= " adimage = '$adimage',adpower = '$adpower',addescription='$addescription'";
	$sql .= " WHERE adid = '$adid'";

	$result = mysql_query($sql,$con);
	if ($result) {
		showAdvertisement($con);;
		exit();
	} else {
		exit('Error ...');
	}
}
/*delete Advertisement					*/
if (isset($_POST['deleteAd'])) {
	$adid = $_POST['deleteAd'];
	$sql	   = " DELETE FROM advertisementInfo";
	$sql	  .= " WHERE adid = '$adid'";
	
	$result = mysql_query($sql,$con);
	if ($result) {
		showAdvertisement($con);;
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
		<div class=\"webAd\" style=\"text-align:left; font-size:16px;\">
		<pre>
		1. 链接图片目前只支持gif格式文件。
		2. 目前没有图片预览功能,后期必会完善.
		3. 文件上传文件夹必须在根目录image/adimage/中。
		4. 添加或者修改时，请直接填写文件全名,如xxx.gif。
		5. 广告权值规定在0-100之间。
		6. 更新时，有可能导致同名记录...
		7. 关于上述缺陷,后期有待完善,敬请谅解!
		</pre>
		</div>";
}
?>