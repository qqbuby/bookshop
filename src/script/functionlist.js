// Javascript Document
function puker(str){
	var display=document.getElementById(str).style.display;
	if (display=="none"){
		document.getElementById(str).style.display="inline";}
	else{
		document.getElementById(str).style.display="none";}
}