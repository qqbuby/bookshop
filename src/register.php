<?php
session_start();
include_once("model/conn.php");
//login..........validator.................
if(isset($_POST['username'])){
	$mbname = $_POST['username'];
	$mbpassword = isset($_POST['userpassword']) ? $_POST['userpassword'] : null;
	if($mbpassword == ''){
		echo "用户名或密码为空!";
		exit();
	}
	$sql = "SELECT mbid,mbname FROM MemberInfo ";
	$sql .= "WHERE mbname='$mbname' AND mbpassword='$mbpassword'";
	$result = mysql_query($sql,$con);
	$row = mysql_fetch_row($result);
	$mbid = $row[0];
	$flag = mysql_num_rows($result);
	if($flag){
		$_SESSION['mbid'] = $mbid;
		$_SESSION['mbname'] = $mbname;
		echo "登录成功,刷新页面以查看!";
	}else {
		echo "登录失败!请检查你的账号或口令";
	}
}
//register.....validator..................
if(isset($_GET['mbname'])){
	$mbname = $_GET['mbname'];
		//Validate mbname Unique
	$sql = "SELECT mbid FROM memberInfo";
	$sql .= " WHERE mbname = '".$mbname."'";
	$result = mysql_query($sql,$con) or die (mysql_error());
	$count = mysql_num_rows($result);
	if($count > 0){
		echo "0";
		exit();
	}
}
if(isset($_POST['mbname'])){
	//Initilize Parameter
	$mbname = $_POST['mbname'];
			//Validate mbname Unique
	$sql = "SELECT mbid FROM memberInfo";
	$sql .= " WHERE mbname = '".$mbname."'";
	$result = mysql_query($sql,$con) or die (mysql_error());
	$count = mysql_num_rows($result);
	if($count > 0){
		echo "0";
		exit();
	}
	$mbpassword = isset($_POST['mbpassword']) ? $_POST['mbpassword'] : null;
	$mbgender = isset($_POST['gender']) ? $_POST['gender'] : null;
	$mbemail = isset($_POST['email']) ? $_POST['email'] : null;
	$mbdate = date('Y-m-d');
	//Add Member .....
	$sql = "INSERT INTO memberInfo (mbname,mbpassword,mbgender,mbemail,mbdate)";
	$sql .= " VALUES ('$mbname','$mbpassword','$mbgender','$mbemail','$mbdate')";
	if(mysql_query($sql,$con)){
		echo "注册成功，请登录！";
	}else {
		echo "未知错误!";
	}
}
?>
