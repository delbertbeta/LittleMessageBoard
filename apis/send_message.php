<?php
include_once("./include.php");
if (isset($_COOKIE['id']) || isset($_COOKIE['token']))
{
	if (!$con)
	{
		die(json_encode(new sql_error, JSON_UNESCAPED_UNICODE));
	}
	if (isset($_POST['message']))
	{
		$userid = $_COOKIE['id'];
		$token = $_COOKIE['token'];
		if (! isTokenValid($userid, $token))
		{
			echo json_encode(new token_out_of_date, JSON_UNESCAPED_UNICODE);
			exit();
		}
		#初始化日期时间
		$date = date("Y-m-d");
		$time = date("H:i:s");
		// echo($_POST['message']);
		$message = htmlentities($_POST['message']);
		$sql = "INSERT INTO `messages` (`id`, `userid`, `date`, `time`, `message`) VALUES (NULL, '$userid', '$date', '$time', '$message');";
		if($con->query($sql))
		{
			echo json_encode(new operate_success, JSON_UNESCAPED_UNICODE);
			exit();
		}
		else
		{	
			echo json_encode(new sql_error, JSON_UNESCAPED_UNICODE);
			exit();
		}
		$con->close();
	}
	else
	{
		echo json_encode(new parameter_is_expected_error, JSON_UNESCAPED_UNICODE);
		exit();
	}
}
else
{
	echo json_encode(new not_login_error, JSON_UNESCAPED_UNICODE);
	exit();
}
?>
