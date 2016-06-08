<?php
/*----<!-- myCart.start -->--------*/
session_start();
include_once("../script/php/validateMember.php");
?>
<?php
/*----display the Cart Table data -----*/
function showCart($cart) {	
	echo "<div class=\"myCart\">";
	echo "<table>";
	echo "<tr>";
	echo "<td colspan=\"5\">我的小推车</td>";
	echo "</tr>";
		/*购物车标题..........*/
	echo "<tr>";
	echo "<th>书名</th>";
	echo "<th>数量</th>";
	echo "<th>单价</th>";
	echo "<th>总价</th>";
	echo "<th>操作</th>";
	echo "</tr>";
		/*具体内容..............*/
	if($cart!=null){
		for($i=0;$i<count($cart);$i++){
			echo "<tr>";
			for($j=1;$j<count($cart[$i]);$j++){
				//Hidden Field for storage bookid 
				if($j==2){
					echo "<td><input type=\"text\" width=\"10\" value=\"".$cart[$i][$j]."\"";
						echo " name=\"count".$cart[$i][0]."\"/>";
					echo "<button type=\"button\" onclick=\"updateCart('";
						echo $cart[$i][0]."');\" >修改</button></td>";
					continue;
				}
				echo "<td>".$cart[$i][$j]."</td>";
			}
			echo "<td>";
			echo "<button type=\"button\" onclick=\"return addOrder('";
			echo $cart[$i][0]."','".$cart[$i][2]."','".$cart[$i][4]."');\"";
				echo " style=\"margin-right:2px;\">购买</button>";
			echo "<button type=\"button\" onclick=\"deleteCart('";
				echo $cart[$i][0]."');\" >取消</button>";
			echo "</td>";
			echo "</tr>";
		}
	}else{
		echo "<tr>";
		echo "<td colspan=\"5\">当前购物车里没东西,(*^__^*) 嘻嘻……</td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "<table>";
	echo "<tr>";
	echo "<td>付款方式</td>";
	echo "<td>";
		echo "<select name=\"OrderPayment\">
				<option value=\"大学\">大学</option>
				<option value=\"中学\">高中</option>
				<option value=\"初中\">初中</option
			</select>";
	echo "</td>";
	echo "<td>送货方式</td>";
	echo "<td>";
		echo "<select name=\"OrderDelivery\">
				<option value=\"大学\">大学</option>
				<option value=\"高中\">高中</option>
				<option value=\"初中\">初中</option>
			</select>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
}//showCart().stop.......

/*--------add Cart-----------*/
if(isset($_POST['addCart'])){
	$BookId    = $_POST['addCart'];
	$BookName  = $_POST['BookName'];
	$BookPrice = $_POST['BookPrice'];
	$BookCount = 1;
	$Bookprice = $BookPrice*$BookCount;
	$cart      = array($BookId,$BookName,$BookCount,$BookPrice,$Bookprice);
	/*----verify Cart Uniqueness------*/
	$cart_info = $_SESSION['cart'];
	for($i=0;$i<count($cart_info);$i++){                     /*验证该图书是否已放进购物车             */
		if($BookId == $cart_info[$i][0]){
			exit("图书《".$BookName."》已经放进小推车!");       /*回传给用户提示信息,并停止脚步执行       */
		}
	}
	$_SESSION['cart'][] = $cart;                             /*购物车数组追加该信息                  */
	exit('已放进小推车!');                                     /*回传给用户提示信息,并停止脚步执行      */
}
/*-------update Cart-----------*/
if(isset($_POST['updateCart'])){
	$BookId = $_POST['updateCart'];
	$changeCount = $_POST['changeCount'];
	$cart = $_SESSION['cart'];
	for($i=0;$i<count($cart);$i++){                           /*获取购物车指定项，并更新相应项         */
		if($BookId == $cart[$i][0]){
			$cart[$i][2] = $changeCount;
			$cart[$i][4] = $cart[$i][3]*$changeCount;
		}
	}
	$_SESSION['cart'] = $cart;                               /*重新更新购物车                        */
	exit(showCart($cart));                                   /*更新购物车列表                        */
}
/*--------delete Cart-------------*/
if(isset($_POST['deleteCart'])){                             
	$BookId = $_POST['deleteCart'];
	$cart_info = $_SESSION['cart'];
	for($i=0;$i<count($cart_info);$i++){	 		         /*获取购物车指定项，并删除相应项           */
		if($BookId != $cart_info[$i][0]){
			$cart[] = $cart_info[$i];
		}
	}
	$_SESSION['cart'] = $cart;                               /*更新购物车列表                         */
	exit(showCart($cart));
}
/*---------show cart table----------*/
if (isset($_GET['Cart'])) {
	$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;
	showCart($cart);
	exit();
}
?>
<!-- myCart.stop -->