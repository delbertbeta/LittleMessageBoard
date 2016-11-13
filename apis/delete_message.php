<?php
include_once("./include.php");

if (isset($_POST['id']))
{
	if (isset($_COOKIE['id']) || isset($_COOKIE['token']))
	{
		if (!$con)
		{
			die(json_encode(new sql_error, JSON_UNESCAPED_UNICODE));
		}
		$userid = $_COOKIE['id'];
		$token = $_COOKIE['token'];
		$id = $_POST['id'];
		if (!isTokenValid($userid, $token))
		{
			echo json_encode(new token_out_of_date, JSON_UNESCAPED_UNICODE);
			exit();
		}
		if (!checkAuthority($_POST['id'], $userid))
		{
			echo json_encode(new user_not_match_error, JSON_UNESCAPED_UNICODE);
			exit();
		}
		$sql = "DELETE FROM `messages` WHERE id = " . $id . ";";
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
		echo json_encode(new not_login_error, JSON_UNESCAPED_UNICODE);
		exit();
	}
}
else
{
	echo json_encode(new parameter_is_expected_error, JSON_UNESCAPED_UNICODE);
	exit();
}
