<!-- JavaScript -->
<script type="text/javascript" language="javascript" src="Script/getXMLHttpObject.js"></script>
<script type="text/javascript" language="javascript" src="Script/fold.js"></script>
<script type="text/javascript" language="javascript" src="Script/page.js"></script>
<script type="text/javascript" language="javascript">
/*---myInfo------*/
function userInfo(page,msg) {
	var xmlHttp = getXMLHttpObject();
	var url = "User/" + page + ".php?" + msg + "&" + Math.random();
	xmlHttp.onreadystatechange = function () {
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
				switch(msg){
					case 'changePassword':
						checkPassword();
						break;
					case 'myInfo':
						perfectInfo();
						break;
				}
			}else{
				document.getElementById('rightContent').innerHTML = "异常错误!";
				return false;
			}
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send();
	return false;
}
//ChangePassword..............
function checkPassword() {
	//checkOldPassword
	var oldPassword = document.getElementsByName('oldPassword')[0];
	oldPassword.onblur = function () {
		if(oldPassword.value == ''){
			document.getElementById('oldPasswordTip').innerHTML = "密码为空!";
			return false;
		}else{
			document.getElementById('oldPasswordTip').innerHTML = "";
			var xmlHttp = getXMLHttpObject();
			var url = "user/myInfo.php";
			var sbody = "oldPassword=" + oldPassword.value;
			xmlHttp.onreadystatechange = function () {
				if(xmlHttp.readyState == 4)	{
					if(xmlHttp.status == 200) {
						document.getElementById('oldPasswordTip').innerHTML = xmlHttp.responseText;
					} else {
						document.getElementById('oldPasswordTip').innerHTML = "UNKNOW ERROR ....";
					}
				}
			}
			xmlHttp.open("POST",url,true);
			xmlHttp.setRequestHeader("Content-type","Application/x-www-form-urlencoded;");
			xmlHttp.send(sbody);
			return true;
		}
	}
	//checkNewPassword
	var newPassword0 = document.getElementsByName('newPassword')[0];
	var newPassword1 = document.getElementsByName('newPassword')[1];
	newPassword0.onblur = function () {
		var length = newPassword0.value.length;
		if(length < 6 || length > 14){
			document.getElementById('newPassword0').style.color = "red";
			return false;
		}else{
			document.getElementById('newPassword0').style.color = "";
		}
		return true;
	}
	newPassword1.onblur = function () {
		var value = newPassword0.value;
		if(this.value != value){
			document.getElementById('newPassword1').style.color = "red";
			return false;
		}else{
			document.getElementById('newPassword1').style.color = "";
		}
		return true;
	}
}
function changePassword(){
	/*----checkOldPassword------*/
	var oldPassword = document.getElementsByName('oldPassword')[0];
	if(oldPassword.value == ''){
		document.getElementById('oldPasswordTip').innerHTML = "密码为空!";
		return false;
	}else{
		document.getElementById('oldPasswordTip').innerHTML = "";
		var xmlHttp = getXMLHttpObject();
		var url     = "user/myInfo.php";
		var sbody   = "oldPassword=" + oldPassword.value;
		xmlHttp.onreadystatechange = function () {
			if(xmlHttp.readyState == 4)	{
				if(xmlHttp.status == 200) {
					document.getElementById('oldPasswordTip').innerHTML = xmlHttp.responseText;
				} else {
					document.getElementById('oldPasswordTip').innerHTML = "UNKNOW ERROR ....";
				}
			}
		}
		xmlHttp.open("POST",url,true);
		xmlHttp.setRequestHeader("Content-type","Application/x-www-form-urlencoded;");
		xmlHttp.send(sbody);
	}
	//checkNewPassword
	var newPassword0 = document.getElementsByName('newPassword')[0];
	var newPassword1 = document.getElementsByName('newPassword')[1];
	var length       = newPassword0.value.length;
	if(length < 6 || length > 14){
		document.getElementById('newPassword0').style.color = "red";
		return false;
	}else{
		document.getElementById('newPassword0').style.color = "";
	}
	var value0 = newPassword0.value;
	var value1 = newPassword1.value;
	if(value0 != value1){
		document.getElementById('newPassword1').style.color = "red";
		return false;
	}else{
		document.getElementById('newPassword1').style.color = "";
	}
	/*---Submit the changePasswordFrom----*/
	var xmlHttp = getXMLHttpObject();
	var url = "user/myInfo.php";
	var sbody = "newPassword=" + newPassword0.value;
	xmlHttp.onreadystatechange = function () {
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				document.getElementById('changePassword').innerHTML = xmlHttp.responseText;
			} else {
				document.getElementById('changePassword').innerHTML = "未知错误!";
			}
		}
	}
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","Application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
}
/*------------perfect personal information-----------*/
function perfectInfo(){
	document.getElementsByName('MbBirthday')[0].onblur = function () {
		var regDate = /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/;
		if(!regDate.test(this.value)){
			alert('日期格式不正确');
			this.style.color="red";
			return false;
		}else{
			this.style.color='';
		}
	}
	document.getElementsByName('perfectInfo')[0].onclick = function () {
		var TF = confirm("那啥,你真的要改动吗?");
		if (TF == false){
			return false;
		}
		var MbGender = getValue('MbGender');
		var MbBirthday = getValue('MbBirthday');
		var MbCountry = getValue('MbCountry');
		var MbProvince = getValue('MbProvince');
		var MbCity = getValue('MbCity');
		var MbPostalCode =getValue('MbPostalCode');
		var MbAddress = getValue('MbAddress');
		var MbPhone = getValue('MbPhone');
		var MbMobile = getValue('MbMobile');
		var MbTrueName = getValue('MbTrueName');
		var MbEmail = getValue('MbEmail');
		var MbQuestion = getValue('MbQuestion');
		var MbAnswer = getValue('MbAnswer');
		/*---简单的验证日期,哈，我自己写的第一个正则表达式---*/
		var regDate = /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/;
		if(!regDate.test(MbBirthday)){
			alert('日期格式不正确');
			document.getElementsByName('MbBirthday')[0].style.color="red";
			return false;
		}else{
			document.getElementsByName('MbBirthday')[0].style.color="";
		}
		var url = "user/myInfo.php";
		var sbody = "MbGender="+MbGender+"&MbCountry="+MbCountry+"&MbProvince="+MbProvince;
		sbody += "&MbBirthday="+MbBirthday+"&MbCity="+MbCity+"&MbPostalCode="+MbPostalCode;
		sbody += "&MbAddress="+MbAddress+"&MbPhone="+MbPhone+"&MbMobile="+MbMobile;
		sbody += "&MbTrueName="+MbTrueName+"&MbEmail="+MbEmail+"&MbQuestion="+MbQuestion+"&MbAnswer="+MbAnswer;
		var xmlHttp = getXMLHttpObject();
		xmlHttp.onreadystatechange=function (){
			if(xmlHttp.readyState==4){
				if(xmlHttp.status==200){
					document.getElementById('_idX').innerHTML = xmlHttp.responseText;
				}
			}
		}
		xmlHttp.open("POST",url,true);
		xmlHttp.setRequestHeader("Content-type","Application/x-www-form-urlencoded;");
		xmlHttp.send(sbody);
	}	
}
function getValue(name){
	return document.getElementsByName(name)[0].value;
}
/*update Cart Count............ */
function updateCart(BookId){
	var changeCount = document.getElementsByName('count'+BookId)[0].value;
	/*--- verify the validity of the value of the changeCount--*/
	if(changeCount < 0){
		var TF = confirm('对不起,我们是卖书滴，不收书!');
		return false;
	}else{
		if(changeCount == 0){
			var TF = confirm('好歹买一本啊!');
			if(TF == true){
				changeCount = 1;
			}
		}
	}
	var url = "user/myCart.php";
	var sbody = "updateCart=" + BookId + "&changeCount=" + changeCount;
	var xmlHttp = getXMLHttpObject();
	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				alert('修改成功!');
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
			}else{
				alert('0');
			}
		}
	}
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
	return false;
}
/*delete Cart .............*/
function deleteCart(BookId){
	var TF = confirm('走过路过，千万别错过!');
	if(TF==false){
		return false;
	}
	var url = "user/myCart.php";
	var sbody = "deleteCart=" + BookId;
	var xmlHttp = getXMLHttpObject();
	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
			}else{
				alert('0');
			}
		}
	}
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
	return false;
}
/*delete Favorite ...............*/
function deleteFavorite(BookId){
		var TF = confirm('走过路过，千万别错过!');
	if(TF==false){
		return false;
	}
	var url = "user/myFavorite.php";
	var sbody = "deleteFavorite=" + BookId;
	var xmlHttp = getXMLHttpObject();
	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
			}else{
				alert('0');
			}
		}
	}
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
	return false;
}
/*add Order .......... */
function addOrder(BookId,OrderCount,OrderAmount){
	//Initilize the parameters ......
	var BookId = BookId;
	var OrderCount = OrderCount;
	var OrderAmount = OrderAmount;
	var OrderPayment = document.getElementsByName('OrderPayment')[0].value;
	var OrderDelivery = document.getElementsByName('OrderDelivery')[0].value;
	var url = "user/myOrder.php";
	var sbody = "addOrder="+BookId+"&OrderCount="+OrderCount+"&OrderAmount="+OrderAmount;
		sbody += "&OrderPayment="+OrderPayment+"&OrderDelivery="+OrderDelivery;
	var xmlHttp = getXMLHttpObject();
	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
			}else{
				alert('Error');
			}
		}
	}
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
}
</script>
<!-- StyleSheet -->

<!-- document.UserInforContent.start -->
<div id="content">
<!-- FunctionList.start -->
<div class="functionlist">
<!-- PersonalDetails.start -->
<div onmousedown="fold('userinfor')" class="list-title">
<h1><img src="image/spacer.gif" alt="personaldetails" />我的资料</h1></div>
<div id="userinfor" class="list-content">
<ul>
	<a href="" onclick="return userInfo('myInfo','myInfo');" ><li>޸个人资料</li></a>
	<a href="" onclick="return userInfo('myInfo','Password');" ><li>޸修改密码</li></a>
	<a href="" onclick="return logout();" ><li>޸安全退出</li></a></ul></div><!-- PersonalDetails.stop -->
<!-- UserCart.start -->
<div onmousedown="fold('cart')" class="list-title">
<h1><img src="image/spacer.gif" alt="personaldetails" />我的购物车</h1></div>
<div id="cart" class="list-content">
<ul>
	<a href="" onclick="return userInfo('myCart','Cart')" ><li>޸我的小推车</li></a>
	<a href="" onclick="return userInfo('myCart','Bill')" ><li>޸我的账单</li></a>
	<a href="" onclick="alert('功能不详!');return false;" ><li>޸购物指南</li></a>
</ul></div><!--UserCart.stop -->
<!-- UserFavorites.start -->
<div onmousedown="fold('favorite')" class="list-title">
<h1><img src="image/spacer.gif" alt="personaldetails" />我的收藏</h1></div>
<div id="favorite" class="list-content">
<ul>
	<a href="" onclick="return userInfo('myFavorite','Favorite')"><li>޸我的收藏</li></a>
	<a href="" onclick="alert('功能不详!');return false;"><li>޸收藏指南</li></a>
</ul></div><!-- UserFavorites.sttop -->
<!-- UserOrder.start -->
<div onmousedown="fold('order')" class="list-title">
<h1><img src="image/spacer.gif" alt="personaldetails" />我的订单</h1></div>
<div id="order" class="list-content">
<ul>
	<a href="" onclick="return userInfo('myOrder','Order')"><li>我的订单</li></a>
	<a href="" onclick="return userInfo('myCart','Cart')"><li>޸我的小推车</li></a>
	<a href="" onclick="return userInfo('myFavorite','Favorite')"><li>޸我的收藏</li></a>
</ul></div><!-- UserOrder.stop -->
<!-- BookSearch.start -->
<div onmousedown="fold('research')" class="list-title">
<h1><img src="image/spacer.gif" alt="personaldetails" />快速检索</h1></div>
<div id="research" class="list-content">
<label for="_id1">关键字</label>
<input type="text" id="_id1">
<select>
	<option>书名</option>
	<option>作者</option>
	<option>出版社</option>
	<option>ISBN</option>
	<option>简介</option>
</select>
<button type="button" onclick="alert('暂不开放此功能,敬请谅解!');">提交查询</button>
</div><!-- BookSearch.sttop -->
</div><!-- UserInfor--FunctionList.sttop -->
<!-- UserInfor--RightContent.start -->
<div id="rightContent">
<?php
$flag = isset($_GET['flag']) ? strtolower($_GET['flag']) : null;
$url  = null;
switch ($flag) {
case 'order':
	$url  = "myOrder";
	$flag = "Order";
	break;
case 'cart':
	$url  = "myCart";
	$flag = "Cart";
	break;
case 'favorite':
	$url = "myFavorite";
	$flag = "Favorite";
	break;
case 'myinfo':
	$url  = "myInfo";
	$flag = "myInfo";
	break;
case 'password':
	$url = "myInfo";
	$flag = "Password";
	break;
default:
	$url = "myInfo";
	$flag = "myInfo";
}
echo "<script type=\"text/javascript\">";
echo "userInfo('$url','$flag');";
echo "</script>";
?>
</div><!-- UserInfor.RightContent.stop -->
<div class="clear"></div></div><!-- document.UserInforCotent.stop -->