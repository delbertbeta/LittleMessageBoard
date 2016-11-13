<?php
include_once("./include.php");
if (isset($_COOKIE['id']) || isset($_COOKIE['token']))
{
	if (isset($_POST['messageid']) || isset($_POST['message']))
	{
		if (!$con)
		{
			die(json_encode(new sql_error, JSON_UNESCAPED_UNICODE));
		}
		$messageid = $_POST['messageid'];
		if (!isTokenValid($_COOKIE['id'], $_COOKIE['token']))
		{
			echo json_encode(new token_out_of_date, JSON_UNESCAPED_UNICODE);
			exit();
		}


		if (!checkAuthority($messageid, $_COOKIE['id']))
		{
			echo json_encode(new user_not_match_error, JSON_UNESCAPED_UNICODE);
			exit();
		}
		#初始化日期时间
		$date = date("Y-m-d");
		$time = date("H:i:s");
		// echo($_POST['message']);
		$message = htmlentities($_POST['message']);
		$sql = "UPDATE `messages` SET `date` = '$date', `time` = '$time', `message` = '$message' WHERE `messages`.`id` = $messageid ;";
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
