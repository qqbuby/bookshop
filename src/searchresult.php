<?php
session_start();
include_once("model/conn.php");
include_once('script/php/payUrl.php');
include_once('script/php/favoriteUrl.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="http://localhost/bookshoponline/" />
<link rel="stylesheet" type="text/css" href="Style/main.css" />
<link rel="stylesheet" type="text/css" href="Style/header.css" />
<link rel="stylesheet" type="text/css" href="Style/Content.css" />
<title>SearchResult</title>
</head>

<body>
<?php
include_once("model/header.php");
include_once("index/SearchContent.php");
include_once("model/footer.php");
?>
</body>
</html>
