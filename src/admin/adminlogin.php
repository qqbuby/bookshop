<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/style/main.css" />
<link rel="stylesheet" type="text/css" href="/style/header.css" />
<title>adminLogin</title>
<style type="text/css">
.logincontent {
	background-image:url(/image/line.gif);
	font-size:16px;
}
.logincontent select {
	margin:0px;
	padding:0px;}
.logincontent td {
	margin: 2px;
	padding: 2px;}
.logincontent input {
	font-size:16px;
	line-height:1.6em;
	width:155px;}
.logincontent button {
	font-size:16px;
	line-height:1.8em;}
#tips {
	color:red;}
</style>
<script type="text/javascript" language="javascript" src="/script/getxmlhttpobject.js"></script>
<script type="text/javascript" language="javascript">
var xmlHttp = null;
function submitForm(){
	var adminName = document.getElementsByName('adminName')[0].value;
	var adminPassword = document.getElementsByName('adminPassword')[0].value;
	if(adminName ==''||adminPassword==''){
		document.getElementById('tips').innerText = "用户名或密码不能为空!";
		return false;
	}
}
</script>
<?php
include("../model/conn.php");
$message = null;
if(isset($_POST['submit'])){
	login($con);
}
function login(&$con){
	$adminName = $_POST['adminName'];
	$adminPassword = $_POST['adminPassword'];
	$sql = "SELECT * From userInfo WHERE userName='$adminName' AND userPassword='$adminPassword'";
	mysql_select_db("bookshop",$con);
	$result = mysql_query($sql,$con);
	$num_rows = mysql_num_rows($result);
	if($num_rows<=0){
		$message="用户名或密码不正确!";
		return $message;
	}else {
		while($rowU = mysql_fetch_array($result)){
			$_SESSION['adminId'] = $rowU['userid'];
		}
		$_SESSION['adminName'] = $adminName;
		$url = "admin.php";
		header("location: $url");
	}
		
}
?>	
</head>

<body>
<?php
include_once("../model/header.php");
?>
<div class="logincontent">
<form action="/admin/adminlogin.php" method="post" onsubmit="return submitForm();">
<table>
	<tr>
		<td colspan="2"><span id="tips">
		<?php 
			if(isset($_POST['submit'])){
				echo login($con);
			}
		?></span></td>
	</tr>
	<tr>
		<td>用户名:</td>
		<td><input type="text" name="adminName" /></td>
	</tr>
	<tr>
		<td>密&nbsp;&nbsp;码:</td>
		<td><input type="password" name="adminPassword" /></td>
	</tr>
	<tr>
		<td><button type="submit" name="submit">登录</button></td>
		<td>
			<select name="adminRole">
				<option selected="selected" value="0">管理员</option>
				<option value="1">配货员</option>
				<option value="2">订货员</option>
			</select>
		</td>
	</tr>
</table>
</form>
</div>
<?php
include("../model/footer.php");
?>
</body>
</html>
