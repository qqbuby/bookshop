<?php
/*<!-- Validate Member ..-->*/
if(!isset($_SESSION['MbId']) && !isset($_SESSION['MbName'])){
	die("各单位请注意,可能有异物来访............");
}
?>