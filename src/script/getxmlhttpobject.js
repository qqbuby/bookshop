// Javascript Document
function getXMLHttpObject(){
	var xmlHttp=null;
	try{
		//Mozilla /Safari /IE7
		xmlHttp=new XMLHttpRequest();
	} catch(e) {
		//IE
		var XMLHTTP_IDS = new Array('MSXML2.XMLHTP.5.0',
									'MSXML2.XMLHTTP.4.0',
									'MSXML2.XMLHTTP.3.0',
									'MSXML2.XMLHTTP',
									'Microsoft.XMLHTTP');
		var success = false;
		for (var i=0;i < XMLHTTP_IDS.length && !success; i++) {
			try{
				xmlHttp=new ActiveXObject(XMLHTTP_IDS[i]);
				success=true;
			} catch(e) {}
		}
		if (!success) {
			throw new Error('Unable to create XMLHttpRequest.');
		}
	}
return xmlHttp;
}