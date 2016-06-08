<?php
header("Content-type:text/html;charset=utf-8");
session_start();
include_once("Script/php/validateMember.php");
include_once('model/conn.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="http://localhost/bookshoponline/" />
<base target="_blank" />
<link rel="stylesheet" type="text/css" href="Style/main.css" />
<link rel="stylesheet" type="text/css" href="Style/header.css" />
<link rel="stylesheet" type="text/css" href="Style/Admin_User.css" />
<title>UserInfo</title>
</head>

<body>
<?php
include_once('Model/Header.php');
include_once('User/UserInforContent.php');
include_once('Model/Footer.php');
?>
</body>
</html>
