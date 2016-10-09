<?php
session_start();
include("mysql.php");
if (isset($_SESSION['id']))
{
	if (!$con)
	{
		die(mysqli_connect_error);	
	}
	#初始化日期时间
	$date = date("Y-m-d");
	$time = date("H:i:s");
	// echo($_POST['message']);
	$message = htmlentities($_POST['message']);
	$userid = $_SESSION['id'];
	$messageid = $_POST['messageid'];
	$findInfo = mysqli_query($con, "SELECT * FROM `messages` WHERE `id` = $messageid");
	$messageInfo = $findInfo->fetch_array();
	$relativeUserId = $messageInfo['userid'];
	$sql = "INSERT INTO `messages` (`id`, `userid`, `date`, `time`, `message`, `relative_message`, `relative_id`, `is_viewed`) VALUES (NULL, '$userid', '$date', '$time', '$message', '$messageid', '$relativeUserId', 0);";
	if(mysqli_query($con, $sql))
	{
		echo '回复成功了啦！';	
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
