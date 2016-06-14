<?php
/*<!-- Validate Member ..-->*/
if(!isset($_SESSION['mbid']) && !isset($_SESSION['mbname'])){
	die("各单位请注意,可能有异物来访............");
}
?>