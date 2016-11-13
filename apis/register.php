<?php
include_once("./include.php");
if (!$con)
{
	die(json_encode(new sql_error, JSON_UNESCAPED_UNICODE));
}
if (isset($_POST['username']) && isset($_POST['password']))
{
    $username = refuseXss($_POST['username']);
    $password = $_POST['password'];
    $result = $con->query("SELECT * FROM `user` WHERE `name` = '$username'");
    if ($result->num_rows == 1)
    {
        echo json_encode(new register_error, JSON_UNESCAPED_UNICODE);
        exit();
    }
    else
    {
        $query = "INSERT INTO `user` (`id`, `name`, `password`, `faceimage`, `admin`) VALUES (NULL, '$username', '$password', '', '0');";
        $con->query($query);
        $result = $con->query("SELECT * FROM `user` WHERE `name` = '$username'");
        $userinfo = $result->fetch_object();
        $con->close();
        class registerSuccess {}
        $registerSuccessObject = new registerSuccess;
        $registerSuccessObject->code = 0;
        $registerSuccessObject->username = $username;
        $registerSuccessObject->id = $userinfo->id;
        echo json_encode($registerSuccessObject, JSON_UNESCAPED_UNICODE);
        exit();
    }
}
else
{
	echo json_encode(new parameter_is_expected_error, JSON_UNESCAPED_UNICODE);
    exit();
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
