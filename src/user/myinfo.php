<?php
session_start();
include_once("../script/php/validateMember.php");
include_once("../model/conn.php");
$sql = "SELECT * FROM memberInfo ";
$sql .= "WHERE MbId = '".$_SESSION['MbId']."' AND MbName='".$_SESSION['MbName']."'";
$result = mysql_query($sql,$con);
while($rowM = mysql_fetch_array($result)){
	$flag = 1;
	//verify the personal information
	foreach($rowM as $r=>$v){
		if($v == ''){
			$flag = 0;
			break;
		}
	}
	//.................
	$MbPassword = $rowM['MbPassword'];
	$MbLevel = $rowM['MbLevel'];
	$MbImage = $rowM['MbImage'];
	$MbGender = $rowM['MbGender'];
	$MbBirthday = $rowM['MbBirthday'];
	$MbBirthday = ($MbBirthday == '') ? 'Example:1988-12-18' : $MbBirthday;
	$MbCountry = $rowM['MbCountry'];
	$MbProvince = $rowM['MbProvince'];
	$MbCity = $rowM['MbCity'];
	$MbPostalCode =$rowM['MbPostalCode'];
	$MbAddress = $rowM['MbAddress'];
	$MbPhone = $rowM['MbPhone'];
	$MbMobile = $rowM['MbMobile'];
	$MbTrueName = $rowM['MbTrueName'];
	$MbEmail = $rowM['MbEmail'];
	$MbQuestion = $rowM['MbQuestion'];
	$MbAnswer = $rowM['MbAnswer'];
}
?>
<?php
//perfect personal information
if(isset($_POST['MbGender'])){
	$MbGender = $_POST['MbGender'];
	$MbBirthday = $_POST['MbBirthday'];
	$MbCountry = $_POST['MbCountry'];
	$MbProvince = $_POST['MbProvince'];
	$MbCity = $_POST['MbCity'];
	$MbPostalCode =$_POST['MbPostalCode'];
	$MbAddress = $_POST['MbAddress'];
	$MbPhone = $_POST['MbPhone'];
	$MbMobile = $_POST['MbMobile'];
	$MbTrueName = $_POST['MbTrueName'];
	$MbEmail = $_POST['MbEmail'];
	$MbQuestion = $_POST['MbQuestion'];
	$MbAnswer = $_POST['MbAnswer'];
	$sql = "UPDATE memberInfo ";
	$sql .= "SET ";
	$sql .= "MbGender='$MbGender',MbCountry='$MbCountry',MbProvince='$MbProvince',";
	$sql .= "MbBirthday='$MbBirthday',MbCity='$MbCity',MbPostalCode='$MbPostalCode',";
	$sql .= "MbAddress='$MbAddress',MbPhone='$MbPhone',MbMobile='$MbMobile',";
	$sql .= "MbTrueName='$MbTrueName',MbEmail='$MbEmail',MbQuestion='$MbQuestion',MbAnswer='$MbAnswer'";
	$sql .= " WHERE MbId = '".$_SESSION['MbId']."'";
	$result = mysql_query($sql,$con);
	if($result){
		exit('修改成功!');
	}else{
		exit('异常错误,请注意日期格式！');
	}
}
/*	修改密码.start 						*/
/*	CHECK THE OLD PASSWORD				*/
if(isset($_POST['oldPassword'])){
	$oldPassword = $_POST['oldPassword'];
	if($MbPassword == $oldPassword){
		exit(" ");
	} else {
		exit('密码不符');
	}
}
/*----changePassword-------*/
if(isset($_POST['newPassword'])){
	$newPassword = $_POST['newPassword'];
	$sql = "UPDATE memberInfo ";
	$sql .= "SET MbPassword = '$newPassword' ";
	$sql .= "WHERE MbId = '".$_SESSION['MbId']."'";
	$reuslt = mysql_query($sql,$con);
	if($result){
		exit('修改成功!');
	}else{
		exit('异常错误！');
	}
}
/*-----OUTPUT THE TABLE----------*/ 
if(isset($_GET['Password'])){
	exit(changePassword());
}
	/*--OuntPutChangePasswordTable----*/
function changePassword(){
echo "
<div class=\"myInfo\">
<table>
	<tr>
		<th colspan=\"4\">修改密码</th>
	</tr>
	<tr>
		<td>旧密码</td><td><input type=\"password\" name=\"oldPassword\" /></td>
		<td colspan=\"2\" id=\"oldPasswordTip\" style=\"color:#FF0000;\"></td>
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
?><!-- 修改密码.stop -->
<!-- 我的资料.start -->
<?php
	//截取信息
if(!isset($_GET['myInfo'])){
	exit();
}
?>
<div class="myInfo">
<table>
	<tr>
		<th colspan="4">个人资料</th>
	</tr>
	<tr>
		<td>昵称</td><td><?php echo $_SESSION['MbName']; ?></td>
		<td>账号</td><td><?php echo $_SESSION['MbId'] ?></td>
	</tr>
	<tr>
		<td>等级</td><td><?php echo $MbLevel; ?></td>
		<td>头衔</td><td><?php echo "<img src=\"$MbImage\" />"; ?></td>
	</tr>
	<tr>
		<td>性别</td><td>
			<select name="MbGender">
				<option selected="selected" value="<?php echo $MbGender; ?>"><?php echo $MbGender; ?></option>
				<?php 
					echo "<option value=\"";
					echo ($MbGender=='男') ? '女">女' : '男">男';
					echo"</option>"; 
					echo ($MbGender=='') ? "<option value=\"女\">女</option>" : null; 
				?>
			</select></td>
		<td>生日</td><td>
				<?php echo "<input type=\"text\" name=\"MbBirthday\" value=\"$MbBirthday\" />"; ?></td>
	</tr>
	<tr>
		<td>国家/地区</td><td>
			<?php echo "<input type=\"text\" name=\"MbCountry\" value=\"$MbCountry\" />"; ?></td>
		<td>省份</td><td>
			<?php echo "<input type=\"text\" name=\"MbProvince\" value=\"$MbProvince\" />"; ?></td>
	</tr>
	<tr>
		<td>城市</td><td>
			<?php echo "<input type=\"text\" name=\"MbCity\" value=\"$MbCity\" />"; ?></td>
		<td>邮政编码</td><td>
			<?php echo "<input type=\"text\" name=\"MbPostalCode\" value=\"$MbPostalCode\" />"; ?></td>
	</tr>
	<tr>
		<td>详细地址</td><td colspan="3">
			<?php 
				echo "<input type=\"text\" size=\"68\" name=\"MbAddress\" value=\"$MbAddress\" />";
			?></td>
	</tr>
	<tr>
		<td>联系电话</td><td>
			<?php echo "<input type=\"text\" name=\"MbPhone\" value=\"$MbPhone\" />"; ?></td>
		<td>手机号码</td><td>
			<?php echo "<input type=\"text\" name=\"MbMobile\" value=\"$MbMobile\" />"; ?></td>
	</tr>
	<tr>
		<td>真实姓名</td><td>
			<?php echo "<input type=\"text\" name=\"MbTrueName\" value=\"$MbTrueName\" />"; ?></td>
		<td>电子邮件</td><td>
			<?php echo "<input type=\"text\" name=\"MbEmail\" value=\"$MbEmail\" />"; ?></td>
	</tr>
	<tr>
		<td>验证问题</td><td>
			<?php echo "<input type=\"text\" name=\"MbQuestion\" value=\"$MbQuestion\" />"; ?></td>
		<td>验证答案</td><td>
			<?php echo "<input type=\"text\" name=\"MbAnswer\" value=\"$MbAnswer\" />"; ?></td>
	</tr>
	<tr>
		<td colspan="2" style="color:#FF0000;">
			<?php echo ($flag ? '资料已完善!' : '抱歉,由于您的资料尚未完善，尚不能订购商品!'); ?></td>
		<td id="_idX" style="color:#ff0000;"></td>
		<td><button type="button" name="perfectInfo">确定</button></td>
	</tr>
</table>
</div><!-- 我的资料.stop -->