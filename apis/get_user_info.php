<?php
include_once("./include.php");
if (isset($_GET['id']))
{
	if (!$con)
	{
		die(json_encode(new sql_error, JSON_UNESCAPED_UNICODE));
	}
	$id = $_GET['id'];
	$sql = "SELECT * FROM `user` WHERE `id` = " .$id . ";";
	$response = $con->query($sql);
	$result = $response->fetch_object();
	$result->password = "";
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
}
else
	echo json_encode(new parameter_is_expected_error, JSON_UNESCAPED_UNICODE);
?>
