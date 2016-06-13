<?php
session_start();
include_once("../script/php/validatemember.php");
include_once("../model/conn.php");
$sql = "SELECT * FROM memberInfo ";
$sql .= "WHERE mbid = '".$_SESSION['mbid']."' AND mbname='".$_SESSION['mbname']."'";
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
	$mbpassword = $rowM['mbpassword'];
	$mblevel = $rowM['mblevel'];
	$mbimage = $rowM['mbimage'];
	$mbgender = $rowM['mbgender'];
	$mbbirthday = $rowM['mbbirthday'];
	$mbbirthday = ($mbbirthday == '') ? 'Example:1988-12-18' : $mbbirthday;
	$mbcountry = $rowM['mbcountry'];
	$mbprovince = $rowM['mbprovince'];
	$mbcity = $rowM['mbcity'];
	$mbpostalcode =$rowM['mbpostalcode'];
	$mbaddress = $rowM['mbaddress'];
	$mbphone = $rowM['mbphone'];
	$mbmobile = $rowM['mbmobile'];
	$mbtruename = $rowM['mbtruename'];
	$mbemail = $rowM['mbemail'];
	$mbquestion = $rowM['mbquestion'];
	$mbanswer = $rowM['mbanswer'];
}
?>
<?php
//perfect personal information
if(isset($_POST['mbgender'])){
	$mbgender = $_POST['mbgender'];
	$mbbirthday = $_POST['mbbirthday'];
	$mbcountry = $_POST['mbcountry'];
	$mbprovince = $_POST['mbprovince'];
	$mbcity = $_POST['mbcity'];
	$mbpostalcode =$_POST['mbpostalcode'];
	$mbaddress = $_POST['mbaddress'];
	$mbphone = $_POST['mbphone'];
	$mbmobile = $_POST['mbmobile'];
	$mbtruename = $_POST['mbtruename'];
	$mbemail = $_POST['mbemail'];
	$mbquestion = $_POST['mbquestion'];
	$mbanswer = $_POST['mbanswer'];
	$sql = "UPDATE memberInfo ";
	$sql .= "SET ";
	$sql .= "mbgender='$mbgender',mbcountry='$mbcountry',mbprovince='$mbprovince',";
	$sql .= "mbbirthday='$mbbirthday',mbcity='$mbcity',mbpostalcode='$mbpostalcode',";
	$sql .= "mbaddress='$mbaddress',mbphone='$mbphone',mbmobile='$mbmobile',";
	$sql .= "mbtruename='$mbtruename',mbemail='$mbemail',mbquestion='$mbquestion',mbanswer='$mbanswer'";
	$sql .= " WHERE mbid = '".$_SESSION['mbid']."'";
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
	if($mbpassword == $oldPassword){
		exit(" ");
	} else {
		exit('密码不符');
	}
}
/*----changePassword-------*/
if(isset($_POST['newPassword'])){
	$newPassword = $_POST['newPassword'];
	$sql = "UPDATE memberInfo ";
	$sql .= "SET mbpassword = '$newPassword' ";
	$sql .= "WHERE mbid = '".$_SESSION['mbid']."'";
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
		<td>昵称</td><td><?php echo $_SESSION['mbname']; ?></td>
		<td>账号</td><td><?php echo $_SESSION['mbid'] ?></td>
	</tr>
	<tr>
		<td>等级</td><td><?php echo $mblevel; ?></td>
		<td>头衔</td><td><?php echo "<img src=\"$mbimage\" />"; ?></td>
	</tr>
	<tr>
		<td>性别</td><td>
			<select name="mbgender">
				<option selected="selected" value="<?php echo $mbgender; ?>"><?php echo $mbgender; ?></option>
				<?php 
					echo "<option value=\"";
					echo ($mbgender=='男') ? '女">女' : '男">男';
					echo"</option>"; 
					echo ($mbgender=='') ? "<option value=\"女\">女</option>" : null; 
				?>
			</select></td>
		<td>生日</td><td>
				<?php echo "<input type=\"text\" name=\"mbbirthday\" value=\"$mbbirthday\" />"; ?></td>
	</tr>
	<tr>
		<td>国家/地区</td><td>
			<?php echo "<input type=\"text\" name=\"mbcountry\" value=\"$mbcountry\" />"; ?></td>
		<td>省份</td><td>
			<?php echo "<input type=\"text\" name=\"mbprovince\" value=\"$mbprovince\" />"; ?></td>
	</tr>
	<tr>
		<td>城市</td><td>
			<?php echo "<input type=\"text\" name=\"mbcity\" value=\"$mbcity\" />"; ?></td>
		<td>邮政编码</td><td>
			<?php echo "<input type=\"text\" name=\"mbpostalcode\" value=\"$mbpostalcode\" />"; ?></td>
	</tr>
	<tr>
		<td>详细地址</td><td colspan="3">
			<?php 
				echo "<input type=\"text\" size=\"68\" name=\"mbaddress\" value=\"$mbaddress\" />";
			?></td>
	</tr>
	<tr>
		<td>联系电话</td><td>
			<?php echo "<input type=\"text\" name=\"mbphone\" value=\"$mbphone\" />"; ?></td>
		<td>手机号码</td><td>
			<?php echo "<input type=\"text\" name=\"mbmobile\" value=\"$mbmobile\" />"; ?></td>
	</tr>
	<tr>
		<td>真实姓名</td><td>
			<?php echo "<input type=\"text\" name=\"mbtruename\" value=\"$mbtruename\" />"; ?></td>
		<td>电子邮件</td><td>
			<?php echo "<input type=\"text\" name=\"mbemail\" value=\"$mbemail\" />"; ?></td>
	</tr>
	<tr>
		<td>验证问题</td><td>
			<?php echo "<input type=\"text\" name=\"mbquestion\" value=\"$mbquestion\" />"; ?></td>
		<td>验证答案</td><td>
			<?php echo "<input type=\"text\" name=\"mbanswer\" value=\"$mbanswer\" />"; ?></td>
	</tr>
	<tr>
		<td colspan="2" style="color:#FF0000;">
			<?php echo ($flag ? '资料已完善!' : '抱歉,由于您的资料尚未完善，尚不能订购商品!'); ?></td>
		<td id="_idX" style="color:#ff0000;"></td>
		<td><button type="button" name="perfectInfo">确定</button></td>
	</tr>
</table>
</div><!-- 我的资料.stop -->