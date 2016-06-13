<!-- Javascript -->
<script type="text/javascript" language="javascript" src="/script/getxmlhttpobject.js"></script>
<script type="text/javascript" language="javascript" src="/script/fold.js"></script>
<script type="text/javascript" language="javascript" src="/script/page.js"></script>
<script type="text/javascript" language="javascript">
/* document.getElementsByName.. */
function getValue(name,num){
	return document.getElementsByName(name)[num].value;
}
/* adminInfo					*/
function adminInfo(page,msg) {
	var xmlHttp = getXMLHttpObject();
	var url 	= "admin/" + page + ".php?" + msg + "&" + Math.random();
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
function adduser(){
	var username 	 = document.getElementsByName('username')[0].value;
	var userpassword = document.getElementsByName('userpassword')[0].value;
	var userrole     = document.getElementsByName('userrole')[0].value;
	if(username == '' || userpassword == ''){
		document.getElementById('addTips').innerHTML = '用户名或密码为空';
		return false;
	} /* End If 	*/
	var url     = "admin/userinfo.php";
	var sbody   = "adduser=" + username + "&userpassword=" + userpassword +"&userrole=" + userrole;
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
/*update user..					*/
function updateuser(userid){
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	var formName 	 = 'id' + userid;
	var username 	 = document.getElementsByName(formName)[0].value;
	var userpassword = document.getElementsByName(formName)[1].value;
	var userrole 	 = document.getElementsByName(formName)[2].value;
	var url 		 = "admin/userInfo.php";
	var sbody 		 = "updateuser=" + userid + "&username=" + username;
	    sbody 		+= "&userpassword=" + userpassword + "&userrole=" + userrole;
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
/*delete user .............		*/
function deleteuser(userid){
	var TF = confirm('请三思!');
	if(TF==false){
		return false;
	}
	var url   	= "admin/userinfo.php";
	var sbody   = "deleteuser=" + userid;
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
	var bmclassname  = getValue('bmclassname',0);
	var bmclasslabel = getValue('bmclasslabel',0);
	/*verify the data efficiency     */
	if (bmclassname == '' || bmclasslabel == '') {
		document.getElementById('MCtips').innerHTML = '分类名为空';
		return false;
	}
	var url 	= "admin/bmclass.php";	
	var sbody   = "addMC=" + bmclassname +"&bmclasslabel=" + bmclasslabel;
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
	
	var bmclassid    = id;
	var bmclassname  = getValue(name,0);
	var bmclasslabel = getValue(name,1);
	
	var url     = "admin/bmclass.php";
	var sbody   = "updateMC=" + bmclassid + "&bmclassname=" + bmclassname + "&bmclasslabel=" + bmclasslabel;
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
	
	var bmclassid = id;
	var url       = "admin/bmclass.php";
	var sbody     = "deleteMC=" + bmclassid;
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
	var bcclassname  = getValue('bcclassname',0);
	var bcclasslabel = getValue('bcclasslabel',0);
	var bmclassid	 = getValue('bmclassid',0);
	/*verify the data efficiency     */
	if (bcclassname == '') {
		document.getElementById('CCtips').innerHTML = '分类名为空';
		return false;
	}
	var url 	= "admin/bcclass.php";	
	var sbody   = "addCC=" + bcclassname +"&bcclasslabel=" + bcclasslabel + "&bmclassid=" + bmclassid;
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
	
	var bcclassid    = id;
	var bcclassname  = getValue(name,0);
	var bcclasslabel = getValue(name,1);
	var bmclassid	 = getValue(name,2);
	
	var url     = "admin/bcclass.php";
	var sbody   = "updateCC=" + bcclassid + "&bcclassname=" + bcclassname 
				+ "&bcclasslabel=" + bcclasslabel + "&bmclassid=" + bmclassid;
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
	
	var bcclassid = id;
	var url       = "admin/bcclass.php";
	var sbody     = "deleteCC=" + bcclassid;
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
	var url     = "admin/order.php";
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
	var url     = "admin/order.php";
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
	var linkname  = getValue('linkname',0);
	var linkurl   = getValue('linkurl',0);
	var linkimage = getValue('linkimage',0);
	var linklabel = getValue('linklabel',0);
	/*verify the data efficiency     */
	if (linkname == '' || linkurl == '') {
		document.getElementById('WLtips').innerHTML = '存在空值!';
		return false;
	}
	var url 	= "admin/weblink.php";	
	var sbody   = "addWL=" + linkname + "&linkurl=" + linkurl
			      + "&linkimage=" + linkimage + "&linklabel=" + linklabel;
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
	
	var linkid    = id;
	var linkname  = getValue(name,0);
	var linkurl   = getValue(name,1);
	var linkimage = getValue(name,2);
	var linklabel = getValue(name,3);
	
	var url     = "admin/webLink.php";
	var sbody   = "updateWL=" + linkid + "&linkname=" + linkname + "&linkurl=" + linkurl
			      + "&linkimage=" + linkimage + "&linklabel=" + linklabel;
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
	
	var linkid = id;
	var url       = "admin/weblink.php";
	var sbody     = "deleteWL=" + linkid;
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
	
	var mbid  = id;
	
	var url   = "admin/member.php";
	var sbody = "banMb=" + mbid;
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
	
	var mbid  = id;
	
	var url   = "admin/member.php";
	var sbody = "unsetMb=" + mbid;
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
	
	var mbid  = id;
	
	var url   = "admin/member.php";
	var sbody = "abolishMb=" + mbid;
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
	var adbusiness    = getValue('adbusiness',0);
	var adurl         = getValue('adurl',0);
	var adimage       = getValue('adimage',0);
	var adpower       = getValue('adpower',0);
	var addescription = getValue('addescription',0);
	/*verify the data efficiency     */
	if (adbusiness == '' || adurl == '' || adimage == '') {
		document.getElementById('Adtips').innerHTML = '存在空值!';
		return false;
	}
	var url 	= "admin/advertisement.php";	
	var sbody   = "addAd=" + adbusiness + "&adurl=" + adurl + "&addescription=" + addescription
			      + "&adimage=" + adimage + "&adpower=" + adpower;
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
	
	var adid          = id;
	var adbusiness    = getValue(name,0);
	var adurl         = getValue(name,1);
	var adimage       = getValue(name,2);
	var adpower       = getValue(name,3);
	var addescription = getValue(name,4);
	
	var url     = "admin/advertisement.php";
	var sbody   = "updateAd=" + adid + "&adbusiness=" + adbusiness + "&adurl=" + adurl 
				  + "&addescription=" + addescription + "&adimage=" + adimage + "&adpower=" + adpower;
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
	
	var adid = id;
	var url       = "admin/advertisement.php";
	var sbody     = "deleteAd=" + adid;
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
	var bookname         = getValue('bookname',0);
	var bookauthor       = getValue('bookauthor',0);
	var bookpress        = getValue('bookpress',0);
	var bookpublishtimes = getValue('bookpublishtimes',0);
	/*verify the data efficiency     */
	if (bookname == '' || bookauthor == '' || bookpress == '') {
		document.getElementById('libTips').innerHTML = '空值!';
		return false;
	}
	var url 	= "admin/library.php";	
	var sbody   = "addLib=" + bookname + "&bookauthor=" + bookauthor 
	            + "&bookpress=" + bookpress + "&bookpublishtimes=" + bookpublishtimes;
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
	
	var bookid           = id;
	var bookname         = getValue(name,0);
	var bookauthor       = getValue(name,1);
	var bookpress        = getValue(name,2);
	var bookpublishtimes = getValue(name,3);
	
	var url     = "admin/library.php";
	var sbody   = "updateLib=" + bookid +"&bookname=" + bookname + "&bookauthor=" + bookauthor 
	            + "&bookpress=" + bookpress + "&bookpublishtimes=" + bookpublishtimes;
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
	
	var bookid  = id;
	var url     = 'admin/library.php';
	var sbody   = 'deleteLib=' + bookid;
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
<!-- styleSheet -->
<style type="text/css">
#addTips,#MCtips,#CCtips,#WLtips,#Adtips,#libTips {
	background-color:#FFDDFF;
	color:#FF0000;}
</style>
<!-- document.userInforContent.start -->
<div id="content">
<!-- FunctionList.start -->
<div class="functionlist">
<!-- userManagement.start -->
<div onmousedown="fold('userinfor')" class="list-title">
<h1><img src="/image/spacer.gif" alt="userM" />用户管理</h1></div>
<div id="userinfor" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('userInfo','showuser');" ><li>޸查看用户</li></a>
	<a href="" onclick="return adminInfo('userInfo','changePassword');" ><li>޸修改密码</li></a>
	<a href="" onclick="return logout();" ><li>޸安全退出</li></a></ul></div><!-- userManagement.stop -->
<!-- myLibrary.start -->
<div onmousedown="fold('library')" class="list-title">
<h1><img src="/image/spacer.gif" alt="Library" />我的图书馆</h1></div>
<div id="library" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('BMClass','BMClass')" ><li>޸一级分类</li></a>
	<a href="" onclick="return adminInfo('BCClass','BCClass')" ><li>޸二级分类</li></a>
	<a href="" onclick="return adminInfo('Library','Library')" ><li>޸图书馆</li></a>
</ul></div><!--myLibrary.stop -->
<!-- Member Information.start -->
<div onmousedown="fold('member')" class="list-title">
<h1><img src="/image/spacer.gif" alt="memberInfo" />会员信息</h1></div>
<div id="member" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('Member','Member')"><li>会员处理</li></a>
</ul></div><!-- Member Information.stop -->
<!-- Order.start -->
<div onmousedown="fold('order')" class="list-title">
<h1><img src="/image/spacer.gif" alt="order" />我的订单</h1></div>
<div id="order" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('Order','Order')"><li>订单处理</li></a>
</ul></div><!-- Order.stop -->
<!-- news.start -->
<div onmousedown="fold('news')" class="list-title">
<h1><img src="/image/spacer.gif" alt="NewsAndNotice" />新闻与公告</h1></div>
<div id="news" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('News','News')"><li>新闻处理</li></a>
	<a href="" onclick="return adminInfo('News','Notice')"><li>公告处理</li></a>
</ul></div><!-- news.stop -->
<!-- Order.start -->
<div onmousedown="fold('advertise')" class="list-title">
<h1><img src="/image/spacer.gif" alt="AD." />广告赞助</h1></div>
<div id="advertise" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('advertisement','advertisement');"><li>广告处理</li></a>
	<a href="" onclick="return adminInfo('advertisement','Manual');"><li>޸更新指南</li></a>	
</ul></div><!-- Order.stop -->
<!-- webLink.start -->
<div onmousedown="fold('weblink')" class="list-title">
<h1><img src="/image/spacer.gif" alt="friendlylinks" />友情链接</h1></div>
<div id="weblink" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('weblink','Weblink');"><li>友情链接</li></a>
	<a href="" onclick="return adminInfo('weblink','Manual');"><li>޸更新指南</li></a>
</ul></div><!-- webLink.stop -->
<!-- DataBase optimization.start -->
<div onmousedown="fold('database')" class="list-title">
<h1><img src="/image/spacer.gif" alt="databaseOptimize" />数据库优化</h1></div>
<div id="database" class="list-content">
<ul>
	<a href="" onclick="return adminInfo('DataBase','OneKey')"><li>一键优化</li></a>
	<a href="" onclick="return adminInfo('DataBase','Detail')"><li>详细优化</li></a>
	<a href="" onclick="return adminInfo('DataBase','Manual')"><li>优化指南</li></a>
</ul></div><!-- DataBase optimization.stop -->
</div><!-- userInfor--FunctionList.sttop -->
<!-- userInfor--RightContent.start -->
<div id="rightContent">

</div><!-- userInfor.RightContent.stop -->
<div class="clear"></div></div><!-- document.userInforCotent.stop -->
