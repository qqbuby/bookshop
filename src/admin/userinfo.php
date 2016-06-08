<?php
session_start();
require('../script/php/validateUser.php');
require('../model/conn.php');
/*  Initlize parameters 			*/
$sql    = "SELECT * FROM UserInfo ";
$sql   .= "WHERE UserId = '".$_SESSION['adminId']."'";
$result = mysql_query($sql,$con);
while($rowU = mysql_fetch_array($result)){
	$UserId 	  = $rowU['UserId'];
	$UserName 	  = $rowU['UserName'];
	$UserPassword = $rowU['UserPassword'];
	$UserRole 	  = $rowU['UserRole'];
	$UserDeleted  = $rowU['UserDeleted'];
} 
/*	修改密码.start							*/
/*	CHECK THE OLD PASSWORD			*/
if(isset($_POST['oldPassword'])){
	$oldPassword = $_POST['oldPassword'];
	if($UserPassword == $oldPassword){
		exit();
	} else {
		exit('密码不符');
	}
}
/*	changePassword					*/
if(isset($_POST['newPassword'])){
	$newPassword = $_POST['newPassword'];
	$sql  = " UPDATE UserInfo";
	$sql .= " SET UserPassword = '$newPassword'";
	$sql .= " WHERE UserId = '$UserId'";
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
function showUser($con,$UserId){
	$sql  = " SELECT * FROM UserInfo";
	$sql .= " WHERE UserId != '$UserId'";
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
		echo "<td>".$rowU['UserId']."</td>";
		echo "<td>";
			echo userInput($rowU['UserName'],$rowU['UserId']);
		echo "</td>";
		echo "<td>";
			echo userInput($rowU['UserPassword'],$rowU['UserId']);
		echo "</td>";
		echo "<td>";
			echo "<select name='id".$rowU['UserId']."'>";
				echo "<option value='".$rowU['UserRole']."'>";
					switch($rowU['UserRole']){
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
			echo "<button type=\"button\" onclick=\"return updateUser('".$rowU['UserId']."');\">更新</button>";
			echo "<button type=\"button\" onclick=\"return deleteUser('".$rowU['UserId']."');\">删除</button>";
		echo "</td>";
		echo "</tr>";
	} /* while end	*/
	/* add user table form 		*/
	echo "<tr>";
	echo "<td id='addTips'></td>";
	echo "<td><input type='text' name='UserName' size='10' /></td>";
	echo "<td><input type='text' name='UserPassword' size='10' /></td>";
	echo "<td>";
		echo "<select name='UserRole'>";
			echo "<option value='0'>管理员</option>";
			echo "<option value='1'>配货员</option>";
			echo "<option value='2'>订货员</option>";
		echo "</select>";
	echo "</td>";
	echo "<td><button type=\"button\" onclick=\"return addUser();\">添加</button></td>";
	echo "</tr>";
	echo "</table>";
}/* showUser	*/
function userInput($value,$id){
	return "<input type='text' value='$value' name='id$id' size='10' />";
}
/* show User 					*/
if(isset($_GET['showUser'])){
	header('Content-type:text/html;charset=utf-8');
	echo showUser($con,$UserId);
	exit();
}
/* add user 					*/
if(isset($_POST['addUser'])){
	$UserName     = $_POST['addUser'];
	$UserPassword = $_POST['UserPassword'];
	$UserRole     = $_POST['UserRole'];
	if($UserName == '' || $UserPassword == ''){
		exit('Error.....');
	}
	/*verify the UserName uniqueness 		*/
	$sql    = " SELECT * FROM UserInfo";
	$sql   .= " WHERE UserName = '$UserName'";
	$result = mysql_query($sql,$con);
	$num 	= mysql_num_rows($result);
	if($num > 0){
		exit('0');
	}
	$sql 		  = " INSERT INTO UserInfo (UserName,UserPassword,UserRole)";
	$sql  		 .= " VALUES ('$UserName','$UserPassword','$UserRole')";
	$reuslt		  = mysql_query($sql,$con);
	if(!$result){
		exit('Error.....'.mysql_error());
	}
	exit(showUser($con,$UserId));
}
/*	update user 				*/
if(isset($_POST['updateUser'])){
	$_uUserId 	  = $_POST['updateUser'];
	$UserName 	  = $_POST['UserName'];
	$UserPassword = $_POST['UserPassword'];
	$UserRole 	  = $_POST['UserRole'];
	if($UserName == '' || $UserPassword == ''){
		exit('0');
	}
	$sql    = " UPDATE UserInfo";
	$sql   .= " SET UserName = '$UserName',UserPassword = '$UserPassword',UserRole = '$UserRole'";
	$sql   .= " WHERE UserId = '$_uUserId'";
	$result = mysql_query($sql,$con);
	if(!$result){
		exit('Error ... ');
	}else{
		exit(showUser($con,$UserId));
	}
}
/*	delete user 				*/
if(isset($_POST['deleteUser'])){
	$_dUserId = $_POST['deleteUser'];
	$sql    = " DELETE FROM UserInfo";
	$sql   .= " WHERE UserId = '$_dUserId'";
	$result = mysql_query($sql,$con);
	if($result){
		exit(showUser($con,$UserId));
	}else{
		exit('0');
	}
}
?>