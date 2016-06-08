<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="qqbuby@126.com,小强" />
<meta name="description" content="安徽大学06级网络工程小强的个人网上书店,仅供参考,不会做任何商业用途。"
<meta name="ROBOTS" content="NOODP" />
<base href="http://localhost/bookshoponline/" target="_blank" />
<link rel="stylesheet" type="text/css" href="Style/main.css" />
<link rel="stylesheet" type="text/css" href="Style/header.css" />
<link rel="stylesheet" type="text/css" href="Style/Content.css" />
<title>06Book</title>
</head>

<body>
<?php
include_once("model/header.php");
include_once("model/conn.php");
include_once('script/php/payUrl.php');
include_once('script/php/favoriteUrl.php');
include_once("index/homecontent.php");
include_once("model/footer.php");
?>
</body>
</html>
