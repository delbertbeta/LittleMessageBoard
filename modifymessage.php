<?php
session_start();
if (isset($_SESSION['id']))
{
    #连接数据库部分
    $con = new mysqli("localhost","root","","message_board");
    mysqli_set_charset($con, "utf8");
    if (!$con)
    {
	    die(mysqli_connect_error);	
    }
    #初始化日期时间
    $date = date("Y-m-d");
    $time = date("H:i:s");
    // echo($_POST['message']);
    $message = refuseXss($_POST['message']);
    $messageid = $_POST['messageid'];
    $sql = "UPDATE `messages` SET `date` = '$date', `time` = '$time', `message` = '$message' WHERE `messages`.`id` = $messageid ;";
    if(mysqli_query($con, $sql))
    {
    	echo '好像是修改成功了！';	
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

function refuseXss($str)
{
	$farr = array(
	"/\\s+/",
	"/<(\\/?)(script|i?frame|style|html|body|title|link|meta|object|\\?|\\%)([^>]*?)>/isU",
	"/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",
	);
	$str = preg_replace($farr,"",$str);
	return $str;
}
?>
