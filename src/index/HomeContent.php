<!-- document.homecontent.start -->
<!-- javascript -->
<!-- stylesheet -->
<!-- content.start -->
<div id="content">
<!-- leftClassNav.start -->
<div id="leftClassNav" class="aside">
<?php
include_once("LeftAside.php");
?>
</div><!-- leftClassNav.stop  -->
<!-- bookContent.start  -->
<div class="bookcontent">
<!-- AdImage.start  -->
<div class="adImage">
</div><!-- AdImage.stop  -->
<!-- HotContent.start  -->
<div class="hotcontent">
<!--<label>广告</label>-->
<?php
include_once("index/ad.php");
?>
<label>新书速递</label>
<?php
$sql = "SELECT BookId,BookName,BookPrice,BookImage FROM BookInfo ";
$sql .= "ORDER BY BookAddDate DESC Limit 5";
$resultS = mysql_query($sql,$con) or exit(mysql_error());
while($rowS = mysql_fetch_array($resultS)){
	echo "<div class=\"booklist\">";
	echo "<h6><a href='BookDetails.php?BookId=".$rowS['BookId']."'>".$rowS['BookName']."</a></h6>";
	echo "<table>";
	echo "<tr>";
	echo "<td colspan=\"2\">";
	echo "<a href='BookDetails.php?BookId=".$rowS['BookId']."'><img src=\"".$rowS['BookImage']."\" /></a>";
	echo "</td></tr>";
	echo "<tr>";
	echo "<td>定&nbsp;&nbsp;&nbsp;&nbsp;价:</td><td>".$rowS['BookPrice']."</td></tr>";
	echo "<tr>";
	echo "<td>会员价:</td><td>".($rowS['BookPrice']*7.5)."</td></tr>";
	echo "<tr>";
	echo "<td>";
		echo payUrl($rowS['BookId'],$rowS['BookName'],$rowS['BookPrice']);
	echo "</td>";
	echo "<td>";
		echo favoriteUrl($rowS['BookId']);
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
}
?>
<label>畅销图书</label>
<?php
$sql = "SELECT BookId,BookName,BookPrice,BookImage FROM BookInfo ";
$sql .= "ORDER BY BookPayCount DESC Limit 5";
$resultS = mysql_query($sql,$con) or exit(mysql_error());
while($rowS = mysql_fetch_array($resultS)){
	echo "<div class=\"booklist\">";
	echo "<h6><a href='BookDetails.php?BookId=".$rowS['BookId']."'>".$rowS['BookName']."</a></h6>";
	echo "<table>";
	echo "<tr>";
	echo "<td colspan=\"2\">";
	echo "<a href='BookDetails.php?BookId=".$rowS['BookId']."'><img src=\"".$rowS['BookImage']."\" /></a>";
	echo "</td></tr>";
	echo "<td>定&nbsp;&nbsp;&nbsp;&nbsp;价:</td><td>".$rowS['BookPrice']."</td></tr>";
	echo "<tr>";
	echo "<td>会员价:</td><td>".($rowS['BookPrice']*7.5)."</td></tr>";
	echo "<tr>";
	echo "<td>";
		echo payUrl($rowS['BookId'],$rowS['BookName'],$rowS['BookPrice']);
	echo "</td>";
	echo "<td>";
		echo favoriteUrl($rowS['BookId']);
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
}
?>
<label>热点图书</label>
<?php
$sql = "SELECT BookId,BookName,BookPrice,BookImage FROM BookInfo ";
$sql .= "ORDER BY BookViewCount DESC Limit 5";
$resultS = mysql_query($sql,$con) or exit(mysql_error());
while($rowS = mysql_fetch_array($resultS)){
	echo "<div class=\"booklist\">";
	echo "<h6><a href='BookDetails.php?BookId=".$rowS['BookId']."'>".$rowS['BookName']."</a></h6>";
	echo "<table>";
	echo "<tr>";
	echo "<td colspan=\"2\">";
	echo "<a href='BookDetails.php?BookId=".$rowS['BookId']."'><img src=\"".$rowS['BookImage']."\" /></a>";
	echo "</td></tr>";
	echo "<tr>";
	echo "<td>定&nbsp;&nbsp;&nbsp;&nbsp;价:</td><td>".$rowS['BookPrice']."</td></tr>";
	echo "<tr>";
	echo "<td>会员价:</td><td>".($rowS['BookPrice']*7.5)."</td></tr>";
	echo "<tr>";
	echo "<td>";
		echo payUrl($rowS['BookId'],$rowS['BookName'],$rowS['BookPrice']);
	echo "</td>";
	echo "<td>";
		echo favoriteUrl($rowS['BookId']);
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
}
?>
<label>网友推荐</label>
<?php
$sql = "SELECT BookId,BookName,BookPrice,BookImage FROM BookInfo ";
$sql .= "ORDER BY BookRecommended DESC Limit 5";
$resultS = mysql_query($sql,$con) or exit(mysql_error());
while($rowS = mysql_fetch_array($resultS)){
	echo "<div class=\"booklist\">";
	echo "<h6><a href='BookDetails.php?BookId=".$rowS['BookId']."'>".$rowS['BookName']."</a></h6>";
	echo "<table>";
	echo "<tr>";
	echo "<td colspan=\"2\">";
	echo "<a href='BookDetails.php?BookId=".$rowS['BookId']."'><img src=\"".$rowS['BookImage']."\" /></a>";
	echo "</td></tr>";
	echo "<tr>";
	echo "<td>定&nbsp;&nbsp;&nbsp;&nbsp;价:</td><td>".$rowS['BookPrice']."</td></tr>";
	echo "<tr>";
	echo "<td>会员价:</td><td>".($rowS['BookPrice']*7.5)."</td></tr>";
	echo "<tr>";
	echo "<td>";
		echo payUrl($rowS['BookId'],$rowS['BookName'],$rowS['BookPrice']);
	echo "</td>";
	echo "<td>";
		echo favoriteUrl($rowS['BookId']);
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
include_once("RangeList.php");
?>
</div><!-- ranglist.stop  -->
<div class="clear"></div></div><!-- content.stop  -->
<!-- document.homecontent.stop  -->