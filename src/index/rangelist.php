<!-- 图书评级右侧内容 -->
<!-- annoucement.start  -->
<div class="news">
<label>新闻公告</label>
<?php
$sql = "SELECT * FROM NewsInfo ORDER BY NewsId DESC LIMIT 10";
$resultN = mysql_query($sql,$con);
echo "<ul>";
while($rowN = mysql_fetch_array($resultN)){
	echo "<li><a href=\"#\">".$rowN['NewsTitle']."</a></li>";
}
echo "<li><h2>系统公告与新闻</h2></li>";
echo "</ul>";
?>
</div><!-- annoucement.stop  -->
<div class="bookrange">
<!-- 热销图书.start -->
<label>热销图书</label>
<div class="sellingBooks">
<?php
$sql = "SELECT bookId,bookName From bookInfo ORDER BY BookPayCount DESC LIMIT 10";
$resultS = mysql_query($sql,$con);
$i=0;
echo "<ul>";
while($rowS = mysql_fetch_array($resultS)){
	echo "<li class=\"bg".($i%2)."\">";
	echo (int)($i+1).".<a href='BookDetails.php?BookId=".$rowS['bookId']."'>";
	echo $rowS['bookName']."</a></li>";
	$i++;
}
echo "</ul>";
?>
</div><!-- 热销图书.stop-->
<!-- 热评图书.start -->
<label>热评图书</label>
<div class="livelyBooks">
<?php
$sql = "SELECT bookId,bookName FROM bookInfo ORDER BY BookComment DESC LIMIT 10";
$resultC = mysql_query($sql,$con);
$i=0;
echo "<ul>";
while($rowC = mysql_fetch_array($resultC)){
	echo "<li class=\"bg".($i%2)."\">";
	echo (int)($i+1).".<a href='BookDetails.php?BookId=".$rowC['bookId']."'>";
	echo $rowC['bookName']."</a></li>";
	$i++;
}
echo "</ul>";
?>
</div><!-- 热评图书.stop -->
<!-- 热点图书.start -->
<label>热点图书</label>
<div class="hotBooks">
<?php
$sql = "SELECT bookId,bookName FROM bookInfo ORDER BY BookViewCount DESC LIMIT 10";
$resultL = mysql_query($sql,$con);
$i=0;
echo "<ul>";
while($rowL = mysql_fetch_array($resultL)){
	echo "<li class=\"bg".($i%2)."\">";
	echo (int)($i+1).".<a href='BookDetails.php?BookId=".$rowL['bookId']."'>";
	echo $rowL['bookName']."</a></li>";
	$i++;
}
echo "</ul>";
?>
</div><!-- 热点图书.stop -->
</div><!-- bookRange.stop -->