<?php
include_once("./include.php");
if (isset($_COOKIE['id']) || isset($_COOKIE['token']))
{
	if (isset($_POST['message']) || isset($_POST['messageid']))
	{
		if (!$con)
		{
			die(json_encode(new sql_error, JSON_UNESCAPED_UNICODE));
		}
		if (!isTokenValid($_COOKIE['id'], $_COOKIE['token']))
		{
			echo json_encode(new token_out_of_date, JSON_UNESCAPED_UNICODE);
			exit();
		}
		$userid = $_COOKIE['id'];
		#初始化日期时间
		$date = date("Y-m-d");
		$time = date("H:i:s");
		// echo($_POST['message']);
		$message = htmlentities($_POST['message']);
		$messageid = $_POST['messageid'];
		$findInfo = $con->query("SELECT * FROM `messages` WHERE `id` = $messageid");
		$messageInfo = $findInfo->fetch_array();
		$relativeUserId = $messageInfo['userid'];
		$sql = "INSERT INTO `messages` (`id`, `userid`, `date`, `time`, `message`, `relative_message`, `relative_id`, `is_viewed`) VALUES (NULL, '$userid', '$date', '$time', '$message', '$messageid', '$relativeUserId', 0);";
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
}

?>
