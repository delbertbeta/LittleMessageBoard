<?php
session_start();
include("mysql.php");
if (isset($_SESSION['id']))
{
	#连接数据库部分
	if (!$con)
	{
		die(mysqli_connect_error);	
	}
	#初始化日期时间
	$date = date("Y-m-d");
	$time = date("H:i:s");
	// echo($_POST['message']);
	$message = htmlentities($_POST['message']);
	$userid = $_POST['userid'];
	$sql = "INSERT INTO `messages` (`id`, `userid`, `date`, `time`, `message`) VALUES (NULL, '$userid', '$date', '$time', '$message');";
	if(mysqli_query($con, $sql))
	{
		echo '好像是发出去了= =';	
	}
	else
	{	
		echo mysqli_error;
	}
	$con->close();
}
else
{
	echo '你居然没登陆就想来骗我？哼唧(╯▔皿▔)╯';
}
?>
