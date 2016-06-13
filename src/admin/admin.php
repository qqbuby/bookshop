<?php
session_start();
require("../script/php/validateuser.php");
require('../model/conn.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="http://localhost/bookshoponline/" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
<link rel="stylesheet" type="text/css" href="style/header.css" />
<link rel="stylesheet" type="text/css" href="style/admin_user.css" />
<title>admin</title>
</head>

<body>
<?php
include_once('../model/header.php');
include_once('adminContent.php');
include_once('../model/footer.php');
?>
</body>
</html>
