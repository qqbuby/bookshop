// JavaScript Document
/*page ..................*/
function page(page,url){
	var url     = url+"?page=" + page + "&" + Math.random();        /*这么Math.random()是用来屏蔽缓存文件滴   */
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
	xmlHttp.open('GET',url,true);
	xmlHttp.send();
	return false;
}