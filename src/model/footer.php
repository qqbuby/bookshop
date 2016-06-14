<!-- document.footer.start -->
<!-- javascript -->
<!-- stylesheet -->
<style type="text/css">
#flinks {}
#webinfo ul li,#flinks ul li {
	margin:5px;
	padding:2px;
	background:#FFFFCC;
	float:left;}
#flinks ul li a {
	margin:0px;
	padding:0px;
	color:#00FFFF;}
#flinks label {
	float:left;
	margin:5px;
	padding:2px;
	text-align:left;
	background:#0099CC;}
#webinfo {
	border-top:1px dashed #0099CC;
	width:700px;
	margin:0 auto;}
</style>
<div id="footer">
<div id="flinks">
<ul><label>友情链接:</label>
<?php
$sql = "SELECT * FROM webLink";
$result = mysql_query($sql,$con);
while($row = mysql_fetch_array($result)){
	echo "<li>";
	echo "<a href='".$row['linkurl']."'>";
	echo $row['linkname']."</a>";
	echo "</li>";
}
?>
<div class="clear"></div></ul>
</div>
<div id="webinfo">
<ul>
	<li>联系地址:安徽大学06网络工程</li>
	<li>电话:0551-3694085</li>
	<li>QQ:136927535</li>
	<li>Email:qqbuby@126.com</li>
	<li>邮编:230039</li>
	<div class="clear"></div></ul>
<p>
版权所有，盗版不究!<a href="/admin/adminlogin.php"><span style="color:#FFFF99;">后台</span></a></p>
</div>
</div><!-- footer.stop -->
</div><!-- document.stop -->
