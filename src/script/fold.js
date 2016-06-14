// Javascript Document
function fold(id){
	var foldBox = document.getElementById(id).style.display;
	if(foldBox == "none"){
		document.getElementById(id).style.display = "block";
	} else {
		document.getElementById(id).style.display = "none";
	}
}