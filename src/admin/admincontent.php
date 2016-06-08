<!-- JavaScript -->
<script type="text/javascript" language="javascript" src="Script/getXMLHttpObject.js"></script>
<script type="text/javascript" language="javascript" src="Script/fold.js"></script>
<script type="text/javascript" language="javascript" src="Script/page.js"></script>
<script type="text/javascript" language="javascript">
/* document.getElementsByName.. */
function getValue(name,num){
	return document.getElementsByName(name)[num].value;
}
/* adminInfo					*/
function adminInfo(page,msg) {
	var xmlHttp = getXMLHttpObject();
	var url 	= "Admin/" + page + ".php?" + msg + "&" + Math.random();
	xmlHttp.onreadystatechange = function () {
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
				switch(msg){
					case 'changePassword':
						checkPassword();
						break;
				}
			}else{alert(xmlHttp.status+'|'+xmlHttp.statusText);
				document.getElementById('rightContent').innerHTML = "异常错误!";
				return false;
			}
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send();
	return false;
}
/*ChangePassword ..				*/
function checkPassword() {
	//checkOldPassword
	var oldPassword = document.getElementsByName('oldPassword')[0];
	oldPassword.onblur = function () {
		if(oldPassword.value == ''){
			document.getElementById('oldPassword').innerHTML = "密码为空!";
			return false;
		}else{
			document.getElementById('oldPassword').innerHTML = "";
			var xmlHttp = getXMLHttpObject();
			var url = "admin/userInfo.php";
			var sbody = "oldPassword=" + oldPassword.value;
			xmlHttp.onreadystatechange = function () {
				if(xmlHttp.readyState == 4)	{
					if(xmlHttp.status == 200) {
						document.getElementById('oldPassword').innerHTML = xmlHttp.responseText;
					} else {
						document.getElementById('oldPassword').innerHTML = "UNKNOW ERROR ....";
					}
				}
			}
			xmlHttp.open("POST",url,true);
			xmlHttp.setRequestHeader("Content-type","Application/x-www-form-urlencoded;");
			xmlHttp.send(sbody);
			return true;
		}
	}
/*	checkNewPassword		*/
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
	//checkOldPassword
	var oldPassword = document.getElementsByName('oldPassword')[0];
	if(oldPassword.value == ''){
		document.getElementById('oldPassword').innerHTML = "密码为空!";
		return false;
	}else{
		document.getElementById('oldPassword').innerHTML = "";
		var xmlHttp = getXMLHttpObject();
		var url = "admin/userInfo.php";
		var sbody = "oldPassword=" + oldPassword.value;
		xmlHttp.onreadystatechange = function () {
			if(xmlHttp.readyState == 4)	{
				if(xmlHttp.status == 200) {
					document.getElementById('oldPassword').innerHTML = xmlHttp.responseText;
				} else {
					document.getElementById('oldPassword').innerHTML = "UNKNOW ERROR ....";
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
	var length = newPassword0.value.length;
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
	//Submit the changePasswordFrom
	var xmlHttp = getXMLHttpObject();
	var url = "admin/userInfo.php";
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
/*add user ..					*/
function addUser(){
	var UserName 	 = document.getElementsByName('UserName')[0].value;
	var UserPassword = document.getElementsByName('UserPassword')[0].value;
	var UserRole     = document.getElementsByName('UserRole')[0].value;
	if(UserName == '' || UserPassword == ''){
		document.getElementById('addTips').innerHTML = '用户名或密码为空';
		return false;
	} /* End If 	*/
	var url     = "admin/userinfo.php";
	var sbody   = "addUser=" + UserName + "&UserPassword=" + UserPassword +"&UserRole=" + UserRole;
	var xmlHttp = getXMLHttpObject();
	xmlHttp.onreadystatechange = function(){
			if(xmlHttp.readyState == 4){
				if(xmlHttp.status == 200){
					if(parseInt(xmlHttp.responseText) == 0){
						document.getElementById('addTips').innerHTML='用户名已存在!';
						return false;
					}else{
						document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
					}
				}else{
					document.getElementById('addTips').innerHTML='异常错误!';
				}
			}
	}
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","Application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
	return false;
}
/*update User..					*/
function updateUser(UserId){
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	var formName 	 = 'id' + UserId;
	var UserName 	 = document.getElementsByName(formName)[0].value;
	var UserPassword = document.getElementsByName(formName)[1].value;
	var UserRole 	 = document.getElementsByName(formName)[2].value;
	var url 		 = "admin/userInfo.php";
	var sbody 		 = "updateUser=" + UserId + "&UserName=" + UserName;
	    sbody 		+= "&UserPassword=" + UserPassword + "&UserRole=" + UserRole;
	var xmlHttp  	 = getXMLHttpObject();
	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4){
			if(xmlHttp.status == 200){
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
				document.getElementById('addTips').innerHTML = '修改成功!'
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
/*delete User .............		*/
function deleteUser(UserId){
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	var url   	= "admin/userinfo.php";
	var sbody   = "deleteUser=" + UserId;
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

/*add BMClass ..				*/
function addMC() {
	var BMClassName  = getValue('BMClassName',0);
	var BMClassLabel = getValue('BMClassLabel',0);
	/*verify the data efficiency     */
	if (BMClassName == '' || BMClassLabel == '') {
		document.getElementById('MCtips').innerHTML = '分类名为空';
		return false;
	}
	var url 	= "admin/BMClass.php";	
	var sbody   = "addMC=" + BMClassName +"&BMClassLabel=" + BMClassLabel;
	var xmlHttp = getXMLHttpObject();
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) { 
			if (xmlHttp.status == 200) {
				if (parseInt(xmlHttp.responseText) == 0) {
					document.getElementById('MCtips').innerHTML = '分类名已存在';
					return false;
				} else {
					document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
				}
			} else {
				document.getElementById('MCtips').innerHTML = 'Error ...'+xmlHttp.status+xmlHttp.statusText;
			}
		}
	}/* end function    */
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded;');
	xmlHttp.send(sbody);
}
/*update BMClass ..				*/
function updateMC(id) {
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	var name         = "__ID" + id;
	
	var BMClassId    = id;
	var BMClassName  = getValue(name,0);
	var BMClassLabel = getValue(name,1);
	
	var url     = "admin/BMClass.php";
	var sbody   = "updateMC=" + BMClassId + "&BMClassName=" + BMClassName + "&BMClassLabel=" + BMClassLabel;
	var xmlHttp = getXMLHttpObject();
	
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
				document.getElementById('MCtips').innerHTML 	  = "更新成功!";
			} else {
				document.getElementById('MCtips').innerHTML = "Error ....";
			}
		}
	}
	
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
}
/*delete BMClass .. 			*/
function deleteMC(id) {
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	
	var BMClassId = id;
	var url       = "admin/BMClass.php";
	var sbody     = "deleteMC=" + BMClassId;
	var xmlHttp   = getXMLHttpObject();
	
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
			} else {
				document.getElementById('MCtips').innerHTML = "Error ..";
			}
		}
	}
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded;');
	xmlHttp.send(sbody);	
}

/*add BCClass ..				*/
function addCC() {
	var BCClassName  = getValue('BCClassName',0);
	var BCClassLabel = getValue('BCClassLabel',0);
	var BMClassId	 = getValue('BMClassId',0);
	/*verify the data efficiency     */
	if (BCClassName == '') {
		document.getElementById('CCtips').innerHTML = '分类名为空';
		return false;
	}
	var url 	= "admin/BCClass.php";	
	var sbody   = "addCC=" + BCClassName +"&BCClassLabel=" + BCClassLabel + "&BMClassId=" + BMClassId;
	var xmlHttp = getXMLHttpObject();
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) { 
			if (xmlHttp.status == 200) {
				if (parseInt(xmlHttp.responseText) == 0) {
					document.getElementById('CCtips').innerHTML = '分类名已存在';
					return false;
				} else {
					document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
				}
			} else {
				document.getElementById('CCtips').innerHTML = 'Error ...';
			}
		}
	}/* end function    */
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded;');
	xmlHttp.send(sbody);
}
/*update BCClass ..				*/
function updateCC(id) {
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	var name         = "__ID" + id;
	
	var BCClassId    = id;
	var BCClassName  = getValue(name,0);
	var BCClassLabel = getValue(name,1);
	var BMClassId	 = getValue(name,2);
	
	var url     = "admin/BCClass.php";
	var sbody   = "updateCC=" + BCClassId + "&BCClassName=" + BCClassName 
				+ "&BCClassLabel=" + BCClassLabel + "&BMClassId=" + BMClassId;
	var xmlHttp = getXMLHttpObject();
	//alert(sbody);return false;
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
				document.getElementById('CCtips').innerHTML 	  = "更新成功!";
			} else {
				document.getElementById('CCtips').innerHTML = "Error ....";
			}
		}
	}
	
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
}
/*delete BCClass .. 			*/
function deleteCC(id) {
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	
	var BCClassId = id;
	var url       = "admin/BCClass.php";
	var sbody     = "deleteCC=" + BCClassId;
	var xmlHttp   = getXMLHttpObject();
	
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
			} else {
				document.getElementById('CCtips').innerHTML = "Error ..";
			}
		}
	}
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded;');
	xmlHttp.send(sbody);	
}

/*dispose Order ..		        */
function disposeOrder(orderId) {
	var url     = "admin/Order.php";
	var sbody   = "disposeOrder=" + orderId;
	var xmlHttp = getXMLHttpObject();
	//alert(sbody);return false;
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
			} else {
				document.getElementById('rightContent').innerHTML = "Error ....";
			}
		}
	}
	
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
}
/*abolish Order ..		        */
function abolishOrder(orderId) {
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	var url     = "admin/Order.php";
	var sbody   = "abolishOrder=" + orderId;
	var xmlHttp = getXMLHttpObject();
	//alert(sbody);return false;
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
			} else {
				document.getElementById('rightContent').innerHTML = "Error ....";
			}
		}
	}
	
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
}

/*add webLink ..				*/
function addWL() {
	var LinkName  = getValue('LinkName',0);
	var LinkUrl   = getValue('LinkUrl',0);
	var LinkImage = getValue('LinkImage',0);
	var LinkLabel = getValue('LinkLabel',0);
	/*verify the data efficiency     */
	if (LinkName == '' || LinkUrl == '') {
		document.getElementById('WLtips').innerHTML = '存在空值!';
		return false;
	}
	var url 	= "admin/WebLink.php";	
	var sbody   = "addWL=" + LinkName + "&LinkUrl=" + LinkUrl
			      + "&LinkImage=" + LinkImage + "&LinkLabel=" + LinkLabel;
	var xmlHttp = getXMLHttpObject();
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) { 
			if (xmlHttp.status == 200) {
				if (parseInt(xmlHttp.responseText) == 0) {
					document.getElementById('WLtips').innerHTML = '文件类型不支持(gif)';
					return false;
				} else if (parseInt(xmlHttp.responseText) == 1) {
					document.getElementById('WLtips').innerHTML = '链接名已存在';
					return false;
				} else {
						document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
						document.getElementById('WLtips').innerHTML = '添加成功!';
				}
			} else {
				document.getElementById('WLtips').innerHTML = 'Error ...';
			}
		}
	}/* end function    */
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded;');
	xmlHttp.send(sbody);
}
/*update webLink ..				*/
function updateWL(id) {
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	var name         = "__ID" + id;
	
	var LinkId    = id;
	var LinkName  = getValue(name,0);
	var LinkUrl   = getValue(name,1);
	var LinkImage = getValue(name,2);
	var LinkLabel = getValue(name,3);
	
	var url     = "admin/webLink.php";
	var sbody   = "updateWL=" + LinkId + "&LinkName=" + LinkName + "&LinkUrl=" + LinkUrl
			      + "&LinkImage=" + LinkImage + "&LinkLabel=" + LinkLabel;
	var xmlHttp = getXMLHttpObject();

	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) { 
			if (xmlHttp.status == 200) {
				if (parseInt(xmlHttp.responseText) == 0) {
					document.getElementById('WLtips').innerHTML = '文件类型不支持(gif)';
					return false;
				} else if(parseInt(xmlHttp.responseText) == 1) {
					document.getElementById('WLtips').innerHTML = '链接名已存在';
					return false;
				} else {
						document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
						document.getElementById('WLtips').innerHTML = '更新成功!';
				}
			} else {
				document.getElementById('WLtips').innerHTML = 'Error ...';
			}
		}
	}/* end function    */
	
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
}
/*delete webLink .. 			*/
function deleteWL(id) {
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	
	var LinkId = id;
	var url       = "admin/WebLink.php";
	var sbody     = "deleteWL=" + LinkId;
	var xmlHttp   = getXMLHttpObject();
	
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
			} else {
				document.getElementById('WLtips').innerHTML = "Error ..";
			}
		}
	}
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded;');
	xmlHttp.send(sbody);	
}

/*ban  member ..				*/
function banMb(id) {
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	
	var MbId  = id;
	
	var url   = "admin/member.php";
	var sbody = "banMb=" + MbId;
	var xmlHttp = getXMLHttpObject();

	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
			} else {
				document.getElementById('rightContent').innerHTML = "Error ....";
			}
		}
	}
	
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
}
/*unset  member ..				*/
function unsetMb(id) {
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	
	var MbId  = id;
	
	var url   = "admin/member.php";
	var sbody = "unsetMb=" + MbId;
	var xmlHttp = getXMLHttpObject();

	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
			} else {
				document.getElementById('rightContent').innerHTML = "Error ....";
			}
		}
	}
	
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
}
/*abolish  member ..				*/
function abolishMb(id) {
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	
	var MbId  = id;
	
	var url   = "admin/member.php";
	var sbody = "abolishMb=" + MbId;
	var xmlHttp = getXMLHttpObject();

	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
			} else {
				document.getElementById('rightContent').innerHTML = "Error ....";
			}
		}
	}
	
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
}

/*add advertisement ..				*/
function addAd() {
	var AdBusiness    = getValue('AdBusiness',0);
	var AdUrl         = getValue('AdUrl',0);
	var AdImage       = getValue('AdImage',0);
	var AdPower       = getValue('AdPower',0);
	var AdDescription = getValue('AdDescription',0);
	/*verify the data efficiency     */
	if (AdBusiness == '' || AdUrl == '' || AdImage == '') {
		document.getElementById('Adtips').innerHTML = '存在空值!';
		return false;
	}
	var url 	= "admin/advertisement.php";	
	var sbody   = "addAd=" + AdBusiness + "&AdUrl=" + AdUrl + "&AdDescription=" + AdDescription
			      + "&AdImage=" + AdImage + "&AdPower=" + AdPower;
	var xmlHttp = getXMLHttpObject();
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) { 
			if (xmlHttp.status == 200) {
				if (parseInt(xmlHttp.responseText) == 0) {
					document.getElementById('Adtips').innerHTML = '文件类型不支持(gif)';
					return false;
				} else if(parseInt(xmlHttp.responseText) == 1) {
					document.getElementById('Adtips').innerHTML = '广告商已存在';
				} else {
						document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
						document.getElementById('Adtips').innerHTML = '添加成功!';
				}
			} else {
				document.getElementById('Adtips').innerHTML = 'Error ...';
			}
		}
	}/* end function    */
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded;');
	xmlHttp.send(sbody);
}
/*update advertisement ..				*/
function updateAd(id) {
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	var name         = "__ID" + id;
	
	var AdId          = id;
	var AdBusiness    = getValue(name,0);
	var AdUrl         = getValue(name,1);
	var AdImage       = getValue(name,2);
	var AdPower       = getValue(name,3);
	var AdDescription = getValue(name,4);
	
	var url     = "admin/advertisement.php";
	var sbody   = "updateAd=" + AdId + "&AdBusiness=" + AdBusiness + "&AdUrl=" + AdUrl 
				  + "&AdDescription=" + AdDescription + "&AdImage=" + AdImage + "&AdPower=" + AdPower;
	var xmlHttp = getXMLHttpObject();

	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) { 
			if (xmlHttp.status == 200) {
				if (parseInt(xmlHttp.responseText) == 0) {
					document.getElementById('Adtips').innerHTML = '文件类型不支持(gif)';
					return false;
				} else if(parseInt(xmlHttp.responseText) == 1) {
					document.getElementById('Adtips').innerHTML = '广告商已存在';
				} else {
						document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
						document.getElementById('Adtips').innerHTML = '更新成功!';
				}
			} else {
				document.getElementById('Adtips').innerHTML = 'Error ...';
			}
		}
	}/* end function    */
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
}
/*delete advertisement .. 			*/
function deleteAd(id) {
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	
	var AdId = id;
	var url       = "admin/advertisement.php";
	var sbody     = "deleteAd=" + AdId;
	var xmlHttp   = getXMLHttpObject();
	
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
			} else {
				document.getElementById('Adtips').innerHTML = "Error ..";
			}
		}
	}
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded;');
	xmlHttp.send(sbody);	
}

/* add book                           */
function addLib() {
	var BookName         = getValue('BookName',0);
	var BookAuthor       = getValue('BookAuthor',0);
	var BookPress        = getValue('BookPress',0);
	var BookPublishTimes = getValue('BookPublishTimes',0);
	/*verify the data efficiency     */
	if (BookName == '' || BookAuthor == '' || BookPress == '') {
		document.getElementById('libTips').innerHTML = '空值!';
		return false;
	}
	var url 	= "admin/Library.php";	
	var sbody   = "addLib=" + BookName + "&BookAuthor=" + BookAuthor 
	            + "&BookPress=" + BookPress + "&BookPublishTimes=" + BookPublishTimes;
	var xmlHttp = getXMLHttpObject();
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) { 
			if (xmlHttp.status == 200) {
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
				document.getElementById('libTips').innerHTML = '添加成功!';
			} else {
				document.getElementById('libTips').innerHTML = 'Error ...';
			}
		}
	}/* end function    */
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded;');
	xmlHttp.send(sbody);
}
/* update book                           */
function updateLib(id) {
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	var name         = "__ID" + id;
	
	var BookId           = id;
	var BookName         = getValue(name,0);
	var BookAuthor       = getValue(name,1);
	var BookPress        = getValue(name,2);
	var BookPublishTimes = getValue(name,3);
	
	var url     = "admin/Library.php";
	var sbody   = "updateLib=" + BookId +"&BookName=" + BookName + "&BookAuthor=" + BookAuthor 
	            + "&BookPress=" + BookPress + "&BookPublishTimes=" + BookPublishTimes;
	var xmlHttp = getXMLHttpObject();

	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) { 
			if (xmlHttp.status == 200) {
				document.getElementById('rightContent').innerHTML = xmlHttp.responseText;
				document.getElementById('libTips').innerHTML = '更新成功!';
			} else {
				document.getElementById('libTips').innerHTML = 'Error ...';
			}
		}
	}/* end function    */
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
}
/* delete book                        */
function deleteLib(id) {
	var TF = confirm('请三思！');
	if (TF == false) {
		return false;
	}
	
	var BookId  = id;
	var url     = 'admin/library.php';
	var sbody   = 'deleteLib=' + BookId;
	var xmlHttp = getXMLHttpObject();
	
	xmlHttp.onreadystatechange = function () {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				document.getElementById('rightContent') = xmlHttp.responseText;
			} else {
				document.getElementById('libTips') = 'Error..';
			}
		}
	}
	xmlHttp.open('POST',url,true);
	xmlHttp.setRequestHeader('Content-type','Application/x-www-form-urlencoded;');
	xmlHttp.send(sbody); 
}
/* show book details ..		          */
function detailLib(id) {
	var bookBlockId = '__detail' + id;
	var bookBlock   = document.getElementById(bookBlockId);
	if (bookBlock.style.display == 'none') {
		bookBlock.style.display = 'inline';
	} else if (bookBlock.style.display == 'inline') {
		bookBlock.style.display = 'none';
	}
}
</script>
<!-- StyleSheet -->
<style type="text/css">
#addTips,#MCtips,#CCtips,#WLtips,#Adtips,#libTips {
	background-color:#FFDDFF;
	color:#FF0000;}
</style>
<!-- document.UserInforContent.start -->
<div id="content">
<!-- FunctionList.start -->
<div class="functionlist">
<!-- UserManagement.start -->
<div onmousedown="fold('userinfor')" class="list-title">
<h1><img src="image/spacer.gif" alt="UserM" />用户管理</h1></div>
<div id="userinfor" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('userInfo','showUser');" ><li>޸查看用户</li></a>
	<a href="" onclick="return adminInfo('userInfo','changePassword');" ><li>޸修改密码</li></a>
	<a href="" onclick="return logout();" ><li>޸安全退出</li></a></ul></div><!-- UserManagement.stop -->
<!-- myLibrary.start -->
<div onmousedown="fold('library')" class="list-title">
<h1><img src="image/spacer.gif" alt="Library" />我的图书馆</h1></div>
<div id="library" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('BMClass','BMClass')" ><li>޸一级分类</li></a>
	<a href="" onclick="return adminInfo('BCClass','BCClass')" ><li>޸二级分类</li></a>
	<a href="" onclick="return adminInfo('Library','Library')" ><li>޸图书馆</li></a>
</ul></div><!--myLibrary.stop -->
<!-- Member Information.start -->
<div onmousedown="fold('member')" class="list-title">
<h1><img src="image/spacer.gif" alt="memberInfo" />会员信息</h1></div>
<div id="member" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('Member','Member')"><li>会员处理</li></a>
</ul></div><!-- Member Information.stop -->
<!-- Order.start -->
<div onmousedown="fold('order')" class="list-title">
<h1><img src="image/spacer.gif" alt="order" />我的订单</h1></div>
<div id="order" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('Order','Order')"><li>订单处理</li></a>
</ul></div><!-- Order.stop -->
<!-- news.start -->
<div onmousedown="fold('news')" class="list-title">
<h1><img src="image/spacer.gif" alt="NewsAndNotice" />新闻与公告</h1></div>
<div id="news" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('News','News')"><li>新闻处理</li></a>
	<a href="" onclick="return adminInfo('News','Notice')"><li>公告处理</li></a>
</ul></div><!-- news.stop -->
<!-- Order.start -->
<div onmousedown="fold('advertise')" class="list-title">
<h1><img src="image/spacer.gif" alt="AD." />广告赞助</h1></div>
<div id="advertise" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('advertisement','advertisement');"><li>广告处理</li></a>
	<a href="" onclick="return adminInfo('advertisement','Manual');"><li>޸更新指南</li></a>	
</ul></div><!-- Order.stop -->
<!-- webLink.start -->
<div onmousedown="fold('weblink')" class="list-title">
<h1><img src="image/spacer.gif" alt="friendlylinks" />友情链接</h1></div>
<div id="weblink" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('weblink','Weblink');"><li>友情链接</li></a>
	<a href="" onclick="return adminInfo('weblink','Manual');"><li>޸更新指南</li></a>
</ul></div><!-- webLink.stop -->
<!-- DataBase optimization.start -->
<div onmousedown="fold('database')" class="list-title">
<h1><img src="image/spacer.gif" alt="databaseOptimize" />数据库优化</h1></div>
<div id="database" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('DataBase','OneKey')"><li>一键优化</li></a>
	<a href="" onclick="return adminInfo('DataBase','Detail')"><li>详细优化</li></a>
	<a href="" onclick="return adminInfo('DataBase','Manual')"><li>优化指南</li></a>
</ul></div><!-- DataBase optimization.stop -->
</div><!-- UserInfor--FunctionList.sttop -->
<!-- UserInfor--RightContent.start -->
<div id="rightContent">

</div><!-- UserInfor.RightContent.stop -->
<div class="clear"></div></div><!-- document.UserInforCotent.stop -->