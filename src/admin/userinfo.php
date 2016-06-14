<?php
session_start();
require('../script/php/validateuser.php');
require('../model/conn.php');
/*  Initlize parameters 			*/
$sql    = "SELECT * FROM userInfo ";
$sql   .= "WHERE userid = '".$_SESSION['adminId']."'";
$result = mysql_query($sql,$con);
while($rowU = mysql_fetch_array($result)){
	$userid 	  = $rowU['userid'];
	$username 	  = $rowU['username'];
	$userpassword = $rowU['userpassword'];
	$userrole 	  = $rowU['userrole'];
	$userdeleted  = $rowU['userdeleted'];
} 
/*	修改密码.start							*/
/*	CHECK THE OLD PASSWORD			*/
if(isset($_POST['oldPassword'])){
	$oldPassword = $_POST['oldPassword'];
	if($userpassword == $oldPassword){
		exit();
	} else {
		exit('密码不符');
	}
}
/*	changePassword					*/
if(isset($_POST['newPassword'])){
	$newPassword = $_POST['newPassword'];
	$sql  = " UPDATE userInfo";
	$sql .= " SET userpassword = '$newPassword'";
	$sql .= " WHERE userid = '$userid'";
	$reuslt = mysql_query($sql,$con);
	if($result){
		exit('修改成功!');
	}else{
		exit('异常错误！');
	}
}
/*	OUTPUT THE TABLE				*/ 
if(isset($_GET['changePassword'])){
	exit(changePassword());
}
/*	OuntPutChangePasswordTable		*/
function changePassword(){
echo "
<div class=\"userInfo\">
<table>
	<tr>
		<th colspan=\"4\">修改密码</th>
	</tr>
	<tr>
		<td>旧密码</td><td><input type=\"password\" name=\"oldPassword\" /></td>
		<td colspan=\"2\" id=\"oldPassword\" style=\"color:#FF0000;\"></td>
	</tr>
	<tr>
		<td>新密码</td><td><input type=\"password\" name=\"newPassword\" /></td>
		<td colspan=\"2\" id=\"newPassword0\">密码最少6个字符，最长不得超过14个字符</td>
	</tr>
	<tr>
		<td>确认密码</td><td><input type=\"password\" name=\"newPassword\" /></td>
		<td colspan=\"2\" id=\"newPassword1\">密码最少6个字符，最长不得超过14个字符</td>
	</tr>
	<tr>
		<td></td><td><button type=\"submit\" onclick=\"return changePassword();\">确定</button></td>
		<td colspan=\"2\" id=\"changePassword\" style=\"color:#FF0000;\"></td>
	</tr>
</table>
</div>";
}
/*	修改密码.stop					*/
/*	显示用户					*/
function showuser($con,$userid){
	$sql  = " SELECT * FROM userInfo";
	$sql .= " WHERE userid != '$userid'";
	$result = mysql_query($sql,$con);
	/*table th */
	echo "<table>";
	echo "<tr>";
	echo "<td colspan='5'>用户信息表</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<th>用户ID</th>";
	echo "<th>用户名</th>";
	echo "<th>用户密码</th>";
	echo "<th>用户角色</th>";
	echo "<th>操作</th>";
	echo "</tr>";
	while($rowU = mysql_fetch_array($result)){
		echo "<tr>";
		echo "<td>".$rowU['userid']."</td>";
		echo "<td>";
			echo userInput($rowU['username'],$rowU['userid']);
		echo "</td>";
		echo "<td>";
			echo userInput($rowU['userpassword'],$rowU['userid']);
		echo "</td>";
		echo "<td>";
			echo "<select name='id".$rowU['userid']."'>";
				echo "<option value='".$rowU['userrole']."'>";
					switch($rowU['userrole']){
						case 0:
							echo "管理员";
							break;
						case 1:
							echo "配货员";
							break;
						case 2:
							echo "订货员";
							break;
					}
				echo "</option>";
				echo "<option value='0'>管理员</option>";
				echo "<option value='1'>配货员</option>";
				echo "<option value='2'>订货员</option>";
			echo "</select>";
		echo "</td>";
		echo "<td>";
			echo "<button type=\"button\" onclick=\"return updateuser('".$rowU['userid']."');\">更新</button>";
			echo "<button type=\"button\" onclick=\"return deleteuser('".$rowU['userid']."');\">删除</button>";
		echo "</td>";
		echo "</tr>";
	} /* while end	*/
	/* add user table form 		*/
	echo "<tr>";
	echo "<td id='addTips'></td>";
	echo "<td><input type='text' name='username' size='10' /></td>";
	echo "<td><input type='text' name='userpassword' size='10' /></td>";
	echo "<td>";
		echo "<select name='userrole'>";
			echo "<option value='0'>管理员</option>";
			echo "<option value='1'>配货员</option>";
			echo "<option value='2'>订货员</option>";
		echo "</select>";
	echo "</td>";
	echo "<td><button type=\"button\" onclick=\"return adduser();\">添加</button></td>";
	echo "</tr>";
	echo "</table>";
}/* showuser	*/
function userInput($value,$id){
	return "<input type='text' value='$value' name='id$id' size='10' />";
}
/* show user 					*/
if(isset($_GET['showuser'])){
	header('Content-type:text/html;charset=utf-8');
	echo showuser($con,$userid);
	exit();
}
/* add user 					*/
if(isset($_POST['adduser'])){
	$username     = $_POST['adduser'];
	$userpassword = $_POST['userpassword'];
	$userrole     = $_POST['userrole'];
	if($username == '' || $userpassword == ''){
		exit('Error.....');
	}
	/*verify the username uniqueness 		*/
	$sql    = " SELECT * FROM userInfo";
	$sql   .= " WHERE username = '$username'";
	$result = mysql_query($sql,$con);
	$num 	= mysql_num_rows($result);
	if($num > 0){
		exit('0');
	}
	$sql 		  = " INSERT INTO userInfo (username,userpassword,userrole)";
	$sql  		 .= " VALUES ('$username','$userpassword','$userrole')";
	$reuslt		  = mysql_query($sql,$con);
	if(!$result){
		exit('Error.....'.mysql_error());
	}
	exit(showuser($con,$userid));
}
/*	update user 				*/
if(isset($_POST['updateuser'])){
	$_uuserid 	  = $_POST['updateuser'];
	$username 	  = $_POST['username'];
	$userpassword = $_POST['userpassword'];
	$userrole 	  = $_POST['userrole'];
	if($username == '' || $userpassword == ''){
		exit('0');
	}
	$sql    = " UPDATE userInfo";
	$sql   .= " SET username = '$username',userpassword = '$userpassword',userrole = '$userrole'";
	$sql   .= " WHERE userid = '$_uuserid'";
	$result = mysql_query($sql,$con);
	if(!$result){
		exit('Error ... ');
	}else{
		exit(showuser($con,$userid));
	}
}
/*	delete user 				*/
if(isset($_POST['deleteuser'])){
	$_duserid = $_POST['deleteuser'];
	$sql    = " DELETE FROM userInfo";
	$sql   .= " WHERE userid = '$_duserid'";
	$result = mysql_query($sql,$con);
	if($result){
		exit(showuser($con,$userid));
	}else{
		exit('0');
	}
}
?>