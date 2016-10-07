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

	$id = $_POST['id'];
	$sql = "DELETE FROM `messages` WHERE id = " . $id . ";";
	if(mysqli_query($con, $sql))
	{
		echo '删除成功！';	
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
