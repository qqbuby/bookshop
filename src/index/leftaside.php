<?php
$sql = "SELECT * FROM BookMainClass ORDER BY bmclassname";
$resultM = mysql_query($sql,$con);
echo "<table>";
while($rowM = mysql_fetch_array($resultM)){
	echo "<tr>";
	echo "<th colspan=\"4\">";
	echo "<a href='".$_SERVER['PHP_SELF']."?bmclassid=".$rowM['bmclassid']."'>".$rowM['bmclassname']."</a>";
	echo "</th>";
	echo "</tr>";
	$sql = "SELECT * FROM BookChildClass ";
	$sql =$sql."WHERE bmclassid='".$rowM['bmclassid']."'";
	$sql .= " ORDER BY bcclassname";
	$resultC = mysql_query($sql,$con) or exit(mysql_error());
	$num = mysql_num_rows($resultC);
	$num = $num + 4 - $num%4;
	$i=0;
	$bookChildName;
	$bookChildId;
	while($rowC = mysql_fetch_array($resultC)){
		$bookChildName[$i]=$rowC['bcclassname'];
		$bookChildId[$i] = $rowC['bcclassid'];
		$i++;
	}
	$bookChildName = array_pad($bookChildName,$num,'');
	$bookChildId = array_pad($bookChildId,$num,'');
	for($i=0;$i<($num-3);$i=$i+4){
		echo "<tr>";
		for($j=$i;$j<$i+4;$j++){
		echo "<td><a href='searchresult.php?bcclassid=".$bookChildId[$j]."'>".$bookChildName[$j]."</a></td>";
		}
		echo "</tr>";
	}
}
echo "</table>";
?>