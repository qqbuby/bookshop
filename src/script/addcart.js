// Javascript Document
function addCart(bookid,bookname,bookprice){
	var url = "user/mycart.php";
	var sbody = "addCart=" + bookid + "&bookname=" + bookname +"&bookprice=" + bookprice;
	var xmlHttp = getXMLHttpObject();
	xmlHttp.onreadystatechange = function(){
			if(xmlHttp.readyState == 4){
				if(xmlHttp.status == 200){
					alert(xmlHttp.responseText);
				}else{
					alert('异常错误!');
				}
			}
	}
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Content-type","Application/x-www-form-urlencoded;");
	xmlHttp.send(sbody);
	return false;
}
	