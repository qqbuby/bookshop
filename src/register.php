<?php
session_start();
include_once("model/conn.php");
//login..........validator.................
if(isset($_POST['UserName'])){
	$MbName = $_POST['UserName'];
	$MbPassword = isset($_POST['UserPassword']) ? $_POST['UserPassword'] : null;
	if($MbPassword == ''){
		echo "用户名或密码为空!";
		exit();
	}
	$sql = "SELECT MbId,MbName FROM MemberInfo ";
	$sql .= "WHERE MbName='$MbName' AND MbPassword='$MbPassword'";
	$result = mysql_query($sql,$con);
	$row = mysql_fetch_row($result);
	$MbId = $row[0];
	$flag = mysql_num_rows($result);
	if($flag){
		$_SESSION['MbId'] = $MbId;
		$_SESSION['MbName'] = $MbName;
		echo "登录成功,刷新页面以查看!";
	}else {
		echo "登录失败!请检查你的账号或口令";
	}
}
//register.....validator..................
if(isset($_GET['MbName'])){
	$MbName = $_GET['MbName'];
		//Validate MbName Unique
	$sql = "SELECT MbId FROM memberInfo";
	$sql .= " WHERE MbName = '".$MbName."'";
	$result = mysql_query($sql,$con) or die (mysql_error());
	$count = mysql_num_rows($result);
	if($count > 0){
		echo "0";
		exit();
	}
}
if(isset($_POST['MbName'])){
	//Initilize Parameter
	$MbName = $_POST['MbName'];
			//Validate MbName Unique
	$sql = "SELECT MbId FROM memberInfo";
	$sql .= " WHERE MbName = '".$MbName."'";
	$result = mysql_query($sql,$con) or die (mysql_error());
	$count = mysql_num_rows($result);
	if($count > 0){
		echo "0";
		exit();
	}
	$MbPassword = isset($_POST['MbPassword']) ? $_POST['MbPassword'] : null;
	$MbGender = isset($_POST['gender']) ? $_POST['gender'] : null;
	$MbEmail = isset($_POST['email']) ? $_POST['email'] : null;
	$MbDate = date('Y-m-d');
	//Add Member .....
	$sql = "INSERT INTO memberInfo (MbName,MbPassword,MbGender,MbEmail,MbDate)";
	$sql .= " VALUES ('$MbName','$MbPassword','$MbGender','$MbEmail','$MbDate')";
	if(mysql_query($sql,$con)){
		echo "注册成功，请登录！";
	}else {
		echo "未知错误!";
	}
}
?>
