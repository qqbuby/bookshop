<!--PHPscript -->
<?php
	//安全退出，销毁会话
	if(isset($_GET['logout'])){
		session_destroy();
	}
?>
<!-- stylesheet -->

<!-- Javascript -->
<script type="text/javascript" language="javascript" src="/script/addcart.js"></script>
<script type="text/javascript" language="javascript" src="/script/addfavorite.js"></script>
<script type="text/javascript" language="javascript" src="/script/getxmlhttpobject.js"></script>
<script type="text/javascript">
//topTipsClockFunction........
function clock()
{
var today=new Date()
var h=today.getHours()
var m=today.getMinutes()
var s=today.getSeconds()
// add a zero in front of numbers<10
m=checkTime(m)
s=checkTime(s)
document.getElementById('curTime').innerHTML=h+":"+m+":"+s
t=setTimeout('clock()',500)
}
function checkTime(i)
{
if (i<10) 
  {i="0" + i}
  return i
}
window.onload=clock;
//loginBoxJavascript
function display(id){
	if(id=="login"){
		document.getElementById("logina").className="cur";
		document.getElementById("registera").className="";
		document.getElementById("register").style.display="none";
		document.getElementById("loginb").style.display="block";
	}else if(id=="register"){
		document.getElementById("logina").className="";
		document.getElementById("registera").className="cur";
		document.getElementById("loginb").style.display="none";
		document.getElementById("register").style.display="block";
		}
}
//loginAndregisterFunction
function loginAndReg(id){
	document.getElementById('login').style.display='block';
	checkForm();
	display(id);
	return false;
}
//validateLoginForm
function loginSubmit() {
	var mbname = document.getElementsByName("userName")[0].value;
	var mbpassword = document.getElementsByName("userPassword")[0].value;
	if(mbname == '' || mbpassword == ''){
		document.getElementById('loginTips').innerText ='用户名或密码为空!';
		return false;
	}
	var url = "register.php";
	var sbody = "username=" + mbname + "&userpassword=" + mbpassword;
	var xmlHttp = getXMLHttpObject();
	xmlHttp.onreadystatechange = function (){
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				document.getElementById('loginTips').innerHTML = xmlHttp.responseText;
			}else {
				document.getElementById('loginTips').innerText = "异常错误!";
			}
		}
	}
	xmlHttp.open("POST",url,"TRUE");
	xmlHttp.setRequestHeader("COntent-type","Application/x-www-form-urlencoded; charset=utf-8");
	xmlHttp.send(sbody);
}
//validateRegisterForm
function checkForm(){
	//checkname
	document.getElementsByName("mbname")[0].onblur=function (){
		var name = /^[\u4e00-\u9fa5]{1,7}$|^[\dA-Za-z_]{1,14}$/; //此正则表达式目前待考虑......
		if(!name.test(this.value)){
			document.getElementById("nameStr").style.display="block";
			return false;
		}else {
			document.getElementById("nameStr").style.display="none"; 
			checkName();      //checkNameUnique............ajax检查名字的唯一性
			}
	}
	//checkmbpassword
	document.getElementsByName("mbpassword")[0].onblur=function (){
		if(this.value.length<6||this.value.length>14){
			document.getElementById("mbpasswordStr1").style.display="block";
			return false;
		}else{
			document.getElementById("mbpasswordStr1").style.display="none";
			}
	}
	document.getElementsByName("mbpassword")[1].onblur=function (){
		if(this.value!=document.getElementsByName("mbpassword")[0].value){
			document.getElementById("mbpasswordStr2").style.display="block";
			return false;
		}else{
			document.getElementById("mbpasswordStr2").style.display="none";
		}
	}
	//checkemail
	document.getElementsByName("email")[0].onblur=function(){
		var email=/^(?:\w+\.?)*\w+@(?:\w+\.?)*\w+$/;
		if(!email.test(this.value)){
			document.getElementById("email").style.display="block";
			return false;
			}else {
				document.getElementById("email").style.display="none";
				}
	}
}
//regSubmit........................
function regSubmit() {
	//Initilize Parameter
	var mbname = document.getElementsByName("mbname")[0].value;
	var mbpassword = document.getElementsByName("mbpassword")[0].value;
	var email = document.getElementsByName("email")[0].value;
	var gender = document.getElementsByName("gender");
	var gender = gender[0].checked ? gender[0].value : gender[1].value;
	//validateRegisterForm
	//checkName
	var name = /^[\u4e00-\u9fa5]{1,7}$|^[\dA-Za-z_]{1,14}$/; //此正则表达式目前待考虑......
	if(!name.test(mbname)){
		document.getElementById("nameStr").style.display="block";
		return false;
	}else {
		document.getElementById("nameStr").style.display="none"; 
		checkName();      //checkNameUnique............ajax检查名字的唯一性
	}
	//checkmbpassword
	if(mbpassword.length<6||mbpassword.length>14){
		document.getElementById("mbpasswordStr1").style.display="block";
		return false;
	}else{
		document.getElementById("mbpasswordStr1").style.display="none";
	}
	if(mbpassword!=document.getElementsByName("mbpassword")[1].value){
		document.getElementById("mbpasswordStr2").style.display="block";
		return false;
	}else{
		document.getElementById("mbpasswordStr2").style.display="none";
	}
	//checkemail
	var regEmail=/^(?:\w+\.?)*\w+@(?:\w+\.?)*\w+$/;
	if(!regEmail.test(email)){
		document.getElementById("email").style.display="block";
		return false;
	}else {
		document.getElementById("email").style.display="none";
	}
	//ajaxRequestString
	var sbody = "mbname="+mbname+"&mbpassword="+mbpassword+"&email="+email+"&gender="+gender;
	//requestURL
	var url = 'register.php';
	var xmlHttp = getXMLHttpObject();
	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				var responseText = xmlHttp.responseText;
				var cmpNum = parseInt(responseText);
				if(cmpNum == 0){
					document.getElementById("nameStr").style.display="block";
					return false;
				}else {
					document.getElementById("nameStr").style.display="none";
					}
				alert(responseText);
				document.getElementById('login').style.display='none';
			}else{
				alert("Loading Error:["+xmlHttp.status+"]"+xmlHttp.statusText);
			}			
		}
	}
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","Application/x-www-form-urlencoded; charset=utf-8");
	xmlHttp.send(sbody);
}
//checkNameUnique............................
function checkName(){
	var xmlHttp = getXMLHttpObject();	
	var mbname = document.getElementsByName("mbname")[0].value;
	var url = 'register.php?mbname='+mbname+"&"+Math.random();
	var sbody = 'mbname='+mbname;
	xmlHttp.onreadystatechange = function () {
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				var responseText = xmlHttp.responseText;
				var cmpNum = parseInt(responseText);
				if(cmpNum == 0){
					document.getElementById("nameStr").style.display="block";
					return false;
				}else {
					document.getElementById("nameStr").style.display="none";
					}
			} else {
					alert("Error");
				}
		}
	}
	xmlHttp.open("GET",url,true);
	//xmlHttp.setRequestHeader("Content-type","Application/x-www-form-urlencoded; charset=utf-8");
	xmlHttp.send();	
}
	//Search......................Form.......................
var id = 'bookname';
var xmlHttpSearch = null;
function dynamicForm(dynamicId) {
	var dynamicId 	     = document.getElementById(dynamicId);
	var bookname         = document.getElementById('bookname');
	var bookauthor       = document.getElementById('bookauthor');
	var bookpress        = document.getElementById('bookpress');
	var bookisbn         = document.getElementById('bookisbn');
	var bookintroduction = document.getElementById('bookintroduction');
	bookname.className         = '';
	bookauthor.className       = '';
	bookpress.className        = '';
	bookisbn.className         = '';
	bookintroduction.className = '';
	dynamicId.className        = 'cur';
	id                         = dynamicId.id;
}
function searchSuggest() {
	var searchKey = document.getElementsByName('searchKey')[0].value;
	var xmlHttp   = getXMLHttpObject();
	var url       = "/searchtips.php?" + id + "=" + searchKey + "&flag=1";
	xmlHttp.onreadystatechange = function () {
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				document.getElementById("booktips").innerHTML = xmlHttp.responseText;
			} else {
					alert("Error");
				}
		}
	}
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","Application/x-www-form-urlencoded; charset=utf-8");
	xmlHttp.send();	
}
function searchForm(){
	var searchKey = document.getElementsByName('searchKey')[0].value;
	var myform = document.getElementsByTagName('form')[0];
		myform.action = encodeURI("/searchresult.php?" + id + "=" + searchKey);
	if (searchKey == ''){
		return false;
	}
	return true;
}
//logout.......注销........
function logout(){
	var TF = confirm("那啥,你真的要走吗?");
	if (TF == false){
		return false;
	}
	var xmlHttp = getXMLHttpObject();
	var url = window.location.href;
	url += "?logout=logout&" + Math.random();
	xmlHttp.onreadystatechange = function () {
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				alert('登出成功!');
			}else{
				alert('异常错误!');
			}
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send();
	return false;
}
</script>
<!-- document.start -->
<div id="main"> 
<!-- document.header.start -->
<div id="header">
<!-- topNavigater.start -->
<div id="topnav">
<ul class="curTime">
	<li style="margin-left:15px; margin-right:0px;">现在时间是:</li>
	<li id="curTime" style="margin-right:50px;">
	<li><a href="index.php">官方主页</a></li>
	<li><a href="userinfo.php?flag=myInfo">个人资料</a></li>
	<li><a href="userinfo.php?flag=Password">修改密码</a></li>
	<li><a href="userinfo.php?flag=Cart">我的购物车</a></li>
	<li><a href="userinfo.php?flag=Favorite">我的收藏架</a></li>
	<li><a href="userinfo.php?flag=Order">我的订单</a></li>
	<li>
		<a href="blog/index.html" onclick="alert('Sorry ,the function is not available now!');return false;">个人空间</a>
		</li>
	<li><a href="http://www.2006wl.cn/bbs/index.asp">官方论坛</a></li></ul>
<ul class="logina">
	<li style="margin-right:15px;">
		<?php
			if(isset($_SESSION['mbid'])){
				echo "&nbsp;|&nbsp;<a href=\"#\" onclick=\"return logout();\">注销</a>";
			}else{
				echo "&nbsp;|&nbsp;<a href=\"#\" onclick=\"return loginAndReg('register');\">注册</a>";
			}
		?>
	</li>
	<li>
		<?php
			if(isset($_SESSION['mbid'])){
				echo "您好:<a href=\"userInfo.php\" >".$_SESSION['mbname']."</a>";
			}else{
				echo "游客:&nbsp;<a href=\"#\" onclick=\"return loginAndReg('login');\">登录</a>|";
			}
		?>
	</li>
	<div class="clear"></div></ul></div><!-- topNavigater.stop -->
<!-- topbanner.start -->
<div id="topbanner">
<!-- leftbanner.start -->
<div id="leftbanner"><img width="100%" height="100%" src="/image/leftbanner.gif" /></div><!-- leftbanner.stop -->
<!-- rightbanner.start -->
<div id="rightbanner"><a href="http://www.2006wl.cn/" target="_blank"><img width="100%" height="100%" title="俺滴班级网站" src="/image/righbanner.gif" /></a></div><!-- rightbanner.stop -->
<div class="clear"></div></div><!-- topNavigater.stop -->
<!-- booksearchAndweather.start -->
<div id="weather_search">
<!-- weather.start -->
<div id="weather"><!--
<iframe src="http://m.weather.com.cn/m/pn12/weather.htm" width="100%" height="100%" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no"></iframe>--><!--暂停访问--></div><!-- weather.stop -->
<!-- search.start -->
<div id="search">
<ul>
	<li id="bookname" class="cur" onmousedown="dynamicForm('bookname')">书名</li>
	<li id="bookauthor" onmousedown="dynamicForm('bookauthor')">作者</li>
	<li id="bookpress" onmousedown="dynamicForm('bookpress')">出版社</li>
	<li id="bookisbn" onmousedown="dynamicForm('bookisbn')">ISBN</li>
	<li id="bookintroduction" onmousedown="dynamicForm('bookintroduction')">简介</li></ul>
<!-- booksearch.start -->
<div id="booksearch">
		<form method="post" onsubmit="return searchForm();">
		<img src="/image/search.gif" title="行者无疆" />
		<input type="text" onkeydown="searchSuggest();" name="searchKey" size="50" />
		<button type="sbumit">Search</button></form>
</div><!-- booksearch.stop -->
<!-- booktips.start -->
<div id="booktips">
</div><!-- booktips.stop -->
<div class="clear"></div></div><!-- search.stop -->
<div class="clear"></div></div><!-- booksearchAndweather.stop -->
<!-- dynamicNavigater.start -->
<div id="dynamicnav">
</div><!-- dynamicNavigater.stop -->
</div><!-- header.stop -->
<!-- loginbox.start -->
<div id="login">
<div class="title">
<ul>
	<li id="logina" class="cur"><a onmousedown="display('login');return false;">登录</a></li>
	<li id="registera"><a onmousedown="display('register');return false;">注册</a></li>
	<li style="float:right;margin-top:0px;padding-top:0px;width:25px;"><img src="/image/x.gif" width="25px" height="22px" title="关闭" onclick="document.getElementById('login').style.display='none'" /></li>
<div class="clear"></div></ul></div>
<!-- loginBox.start -->
<div id="loginb" class="register">
<table>
	<tr>
		<td></td>
		<td id="loginTips" style="color:#FF0000;"></td></tr>
	<tr>
		<td><strong>用户名:</strong></td>
		<td><input type="text" name="userName"/></td></tr>
	<tr>
		<td><strong>密&nbsp;&nbsp;码:</strong></td>
		<td><input type="password" name="userPassword" /></td></tr>
	<tr>
		<td><button type="submit" onclick="return loginSubmit();">登录</button></td>
		<td>&nbsp;<a href="" onclick="alert('暂不开放此功能!');return false;">找回密码?</a></td></tr>
</table></div><!-- loginBox.stop-->
<!-- registerBox.start -->
<div id="register" class="register">
<table>
	<tr>
		<td><strong>用&nbsp;户&nbsp;名:</strong></td>
		<td><input type="text" name="mbname" maxlength="14" value="" autocomplete="off"/>
			<div id="nameStr" class="warning" >请填写用户名/此用户名已被注册，请另换一个</div>
			<div class="note">不超过7个汉字，或14个字节(数字，字母和下划线)</div></td></tr>
	<tr>
		<td><strong>设置密码:</strong></td>
		<td><input type="password" name="mbpassword" />
			<div id="mbpasswordStr1" class="warning">密码最少6个字符，最长不得超过14个字符</div></td></tr>
	<tr>
		<td><strong>确认密码:</strong></td>
		<td><input type="password" name="mbpassword" />
			<div id="mbpasswordStr2" class="warning">密码与确认密码不一致。</div>
			<div class="note">密码最少6个字符，最长不得超过14个字符</div></td></tr>
	<tr>
		<td><strong>性&nbsp;&nbsp;&nbsp;&nbsp;别:</strong></td>
		<td>
		<input style="width:auto;" checked="checked" type="radio" name="gender" value="男" />男	&nbsp;
		&nbsp;<input style="width:auto;" type="radio" name="gender" value="女" />女
		</td></tr>
	<tr>
		<td><strong>电子邮件:</strong></td>
		<td><input type="text" name="email" size="30" />
			<div id="email" class="warning">邮件格式不正确</div>
			<div class="note">请输入有效的邮件地址，当密码遗失时凭此领取</div></td></tr>
	<tr>
		<td colspan="2">
			<button type="submit" onclick="return regSubmit();" name="regSubmit">同意以下协议并提交</button>
		</td></tr>
	<tr>
		<td colspan="2">
		<textarea style="font-size:12px;" cols="62" rows="5" readonly="readonly">
		喝酒不开车，开车不喝酒！
		</textarea>
		</td></tr></table></div><!-- registerBox.stop -->
</div><!-- loginbox.stop -->
<!-- main.stop -->
