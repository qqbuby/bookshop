<!-- javascript -->
<script type="text/javascript" language="javascript">
/*add comment 						*/
function addComment() {
	var commentTitle   = document.getElementById('commentTitle').value;
	var commentContent = document.getElementById('commentContent').value;
	var bookid         = document.getElementsByName('bookid')[0].value;
	if (commentContent=='') {
		alert('评论内容为空！');
		return false;
	}
	var url     = "bookdetails.php";
	var sbody   = "commentTitle=" + commentTitle + "&commentContent=" + commentContent + "&bookid=" + bookid;
	var xmlHttp = getXMLHttpObject();
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				if (xmlHttp.responseText == 'login') {
					alert('请登录....');
					return false;
				}
				if (xmlHttp.responseText == 'error') {
					alert(xmlHttp.responseText);
					alert('未知错误....');
					return false;
				}
				document.getElementById('book-comment').innerHTML = xmlHttp.responseText;
			} else {
				alert('Loading Error:['+xmlHttp.status+']'+xmlHttp.statusText);
			}		
		}
	}
	xmlHttp.open("POST",url,"TRUE");
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded; charset=utf-8");
	xmlHttp.send(sbody);
	return false;
}
/*book-catalog  ----  book-content 		*/
function displaybookcomment(id){
	if (id=="bookcontent") {
		document.getElementById("bookcontent").style.backgroundColor="#38b830";
		document.getElementById("bookcontent").style.color="#f8fcf0";
		
		document.getElementById("bookcatalog").style.backgroundColor = "";
		document.getElementById("bookcatalog").style.color           = "";
		
		document.getElementById("book-catalog").style.display="none";
		document.getElementById("book-content").style.display="block";
	} else if (id=="bookcatalog") {
		document.getElementById("bookcontent").style.backgroundColor="";
		document.getElementById("bookcontent").style.color="";
		
		document.getElementById("bookcatalog").style.backgroundColor = "#38b830";
		document.getElementById("bookcatalog").style.color           = "#f8fcf0";
				
		document.getElementById("book-catalog").style.display = "block";
		document.getElementById("book-content").style.display = "none";
		}
}
</script>
<!-- document.homecontent.start -->
<!-- stylesheet -->

<!-- content.start -->
<div id="content">
<!-- leftClassNav.start -->
<div id="leftClassNav" class="aside">
<?php
include_once("leftaside.php");
?>
</div><!-- leftClassNav.stop  -->
<!-- bookDetailsContent.start  -->
<div class="bookcontent" class="bookDetailscontent">
<?php
if(isset($_GET['bookid'])){
	$bookid = $_GET['bookid'];
	echo "<input type=\"hidden\" value=\"$bookid\" name=\"bookid\" />";
	showBookDetails($bookid,$con);
}else {
	echo "ERROR...";
}
function showBookDetails($bookid,$conn) {
	$sql = "UPDATE BookInfo ";
	$sql .= "SET bookviewcount=bookviewcount+1";
	$sql .= " WHERE bookid='$bookid'";
	mysql_query($sql) or die('Error');
	$sql = "SELECT * FROM BookInfo ";
	$sql .= "WHERE bookid='".$bookid."'";
	$resultS = mysql_query($sql,$conn) or exit(mysql_error());
	$rowS = mysql_fetch_array($resultS);
	echo "<div class=\"book-details\">";                  /*book-details-start               */
	echo "<div class=\"booklist\">";
	echo "<label>".$rowS['bookname']."</label>";
	echo "<table>";
	echo "<tr>";
	echo "<td colspan=\"2\"><img src=\"".$rowS['bookimage']."\" /></td></tr>";
	echo "<tr>";
	echo "<td>定&nbsp;&nbsp;&nbsp;&nbsp;价:</td><td>".$rowS['bookprice']."</td></tr>";
	echo "<tr>";
	echo "<td>会员价:</td><td>".($rowS['bookprice']*7.5)."</td></tr>";
	echo "<tr>";
	echo "<td>";
		echo payUrl($rowS['bookid'],$rowS['bookname'],$rowS['bookprice']);
	echo "</td>";
	echo "<td>";
		echo favoriteUrl($rowS['bookid']);
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
	echo "<div class=\"bookdetails\">";
	echo "<label><strong>作　　者：</strong>".$rowS['bookauthor']."</label>";
	echo "<label><strong>出 版 社：</strong>".$rowS['bookpress']."</label>";
	echo "<label><strong>出版时间：</strong>".$rowS['bookpublishdate']."</label>";
	echo "<label><strong>版　　次：</strong>第".$rowS['bookpublishtimes']."版</label>";
	echo "<label><strong>页　　数：</strong>".$rowS['bookpagecount']."</label>";
	echo "<label><strong>印刷时间：<strong>".$rowS['BookPrintDate']."</label>";
	echo "<label><strong>开　　本：</strong>".$rowS['bookpagesize']."</label>";
	echo "<label>I S B N ：".$rowS['bookisbn']."</label>";
	echo "<label><strong>星　　级：</strong><img src=\"image/5star.gif\" /></label>";
	echo "</div>";  	                                       /*bookdetails.stop        */
	echo "</div>";		                                       /*book-details.stop       */
	echo "<div class=\"book-catalog-content\">";               /*book-catalog-content-start        */
	echo "<ul>";
	echo "<li id=\"bookcatalog\" style=\"cursor:pointer; background: #38B830; color: #f8fcf0;\"";
		echo " onclick=\"displaybookcomment('bookcatalog');\">图书目录</li>";
	echo "<li id=\"bookcontent\" style=\"cursor:pointer;\"";
		echo " onclick=\"displaybookcomment('bookcontent');\">内容简介</li>";
	echo "<div class=\"clear\"></div></ul>";
	echo "<div id=\"book-catalog\" class=\"book-catalog\">";	/*book-catalog-start    */
	echo "<textarea readonly=\"readonly\">".$rowS['bookcatalog']."</textarea>";
	echo "</div>";		//book-catalog-stop
	echo "<div id=\"book-content\" class=\"book-content\">";
	echo "<textarea readonly=\"readonly\">".$rowS['bookintroduction']."</textarea>";
	echo "</div>";		//book-content-stop
	echo "</div>";      //book-catalog-content-stop
	echo "<div id=\"book-comment\" class=\"book-comment\">";	/*book-comment-start      */
		showbookcomment($bookid,$conn);                         /*方法实现见于bookdetails.php     */
	echo "</div>";	                                            /*book-comment-stop      */
}
?>
<!-- add-comment-start -->
<div class="add-comment">
<label>网友评论</label>
<ul>
	<li>星级&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="star" /><img src="image/1star.gif" /></li>
	<li><input type="radio" name="star"/><img src="image/2star.gif" /></li>
	<li><input type="radio" name="star"/><img src="image/3star.gif" /></li>
	<li><input type="radio" name="star"/><img src="image/4star.gif" /></li>
	<li><input type="radio" name="star"/><img src="image/5star.gif" /></li>
<div class="clear"></div></ul>
<label for="commentTitle">评论标题</label><input type="text" name="commentTitle" id="commentTitle" /><br />
<label for="commentContent">评论内容</label>
	<textarea name="commentContent" id="commentContent"></textarea>
	<input onclick="addComment();" type="button" name="submit" id="submit" value="发表" />
<ul>
	<li>
	<?php
		if(isset($_SESSION['mbid'])){
			echo "您好:".$_SESSION['mbname'];
		}
		else {
			echo "游客:&nbsp;<a href=\"#\" onclick=\"return loginAndReg('login');\">登录</a>|</li>
			<li><a href=\"#\" onclick=\"return loginAndReg('register');\"> 注册</a></li>";
		}
	?>
	<div class="clear"></div></ul>
</div><!-- add-comment-stop-->
</div><!-- bookDetailsContent.stop  -->
<!-- rangelist.start  -->
<div class="ranglist">
<?php
include_once("rangelist.php");    /*右侧分类列表    --*/
?>
</div><!-- ranglist.stop  -->
<div class="clear"></div></div><!-- content.stop  -->
<!-- document.homecontent.stop  -->