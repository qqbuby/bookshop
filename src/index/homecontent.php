<!-- document.homecontent.start -->
<!-- javascript -->
<!-- stylesheet -->
<!-- content.start -->
<div id="content">
<!-- leftClassNav.start -->
<div id="leftClassNav" class="aside">
<?php
include_once("leftaside.php");
?>
</div><!-- leftClassNav.stop  -->
<!-- bookContent.start  -->
<div class="bookcontent">
<!-- adimage.start  -->
<div class="adImage">
</div><!-- adimage.stop  -->
<!-- HotContent.start  -->
<div class="hotcontent">
<!--<label>广告</label>-->
<?php
include_once("index/ad.php");
?>
<label>新书速递</label>
<?php
$sql = "SELECT bookid,bookname,bookprice,bookimage FROM bookinfo ";
$sql .= "ORDER BY bookadddate DESC Limit 5";
$resultS = mysql_query($sql,$con) or exit(mysql_error());
while($rowS = mysql_fetch_array($resultS)){
	echo "<div class=\"booklist\">";
	echo "<h6><a href='bookdetails.php?bookid=".$rowS['bookid']."'>".$rowS['bookname']."</a></h6>";
	echo "<table>";
	echo "<tr>";
	echo "<td colspan=\"2\">";
	echo "<a href='bookdetails.php?bookid=".$rowS['bookid']."'><img src=\"".$rowS['bookimage']."\" /></a>";
	echo "</td></tr>";
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
}
?>
<label>畅销图书</label>
<?php
$sql = "SELECT bookid,bookname,bookprice,bookimage FROM bookinfo ";
$sql .= "ORDER BY bookpaycount DESC Limit 5";
$resultS = mysql_query($sql,$con) or exit(mysql_error());
while($rowS = mysql_fetch_array($resultS)){
	echo "<div class=\"booklist\">";
	echo "<h6><a href='bookdetails.php?bookid=".$rowS['bookid']."'>".$rowS['bookname']."</a></h6>";
	echo "<table>";
	echo "<tr>";
	echo "<td colspan=\"2\">";
	echo "<a href='bookdetails.php?bookid=".$rowS['bookid']."'><img src=\"".$rowS['bookimage']."\" /></a>";
	echo "</td></tr>";
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
}
?>
<label>热点图书</label>
<?php
$sql = "SELECT bookid,bookname,bookprice,bookimage FROM bookinfo ";
$sql .= "ORDER BY bookviewcount DESC Limit 5";
$resultS = mysql_query($sql,$con) or exit(mysql_error());
while($rowS = mysql_fetch_array($resultS)){
	echo "<div class=\"booklist\">";
	echo "<h6><a href='bookdetails.php?bookid=".$rowS['bookid']."'>".$rowS['bookname']."</a></h6>";
	echo "<table>";
	echo "<tr>";
	echo "<td colspan=\"2\">";
	echo "<a href='bookdetails.php?bookid=".$rowS['bookid']."'><img src=\"".$rowS['bookimage']."\" /></a>";
	echo "</td></tr>";
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
}
?>
<label>网友推荐</label>
<?php
$sql = "SELECT bookid,bookname,bookprice,bookimage FROM bookinfo ";
$sql .= "ORDER BY bookrecommended DESC Limit 5";
$resultS = mysql_query($sql,$con) or exit(mysql_error());
while($rowS = mysql_fetch_array($resultS)){
	echo "<div class=\"booklist\">";
	echo "<h6><a href='bookdetails.php?bookid=".$rowS['bookid']."'>".$rowS['bookname']."</a></h6>";
	echo "<table>";
	echo "<tr>";
	echo "<td colspan=\"2\">";
	echo "<a href='bookdetails.php?bookid=".$rowS['bookid']."'><img src=\"".$rowS['bookimage']."\" /></a>";
	echo "</td></tr>";
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
}
?>
</div><!-- HotContent.stop  -->
</div><!-- bookContent.stop  -->
<!-- rangelist.start  -->
<div class="ranglist">
<?php
include_once("rangelist.php");
?>
</div><!-- ranglist.stop  -->
<div class="clear"></div></div><!-- content.stop  -->
<!-- document.homecontent.stop  -->
