<?php
header("Content-type:text/html;charset=utf-8");
session_start();
include_once("script/php/validatemember.php");
include_once('model/conn.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base target="_blank" />
<link rel="stylesheet" type="text/css" href="/style/main.css" />
<link rel="stylesheet" type="text/css" href="/style/header.css" />
<link rel="stylesheet" type="text/css" href="/style/admin_user.css" />
<title>userInfo</title>
</head>

<body>
<?php
include_once('model/header.php');
include_once('user/userinforcontent.php');
include_once('model/footer.php');
?>
</body>
</html>
