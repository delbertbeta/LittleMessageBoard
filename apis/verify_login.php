<?php
include_once("./include.php");
if (!$con)
{
	die(json_encode(new sql_error, JSON_UNESCAPED_UNICODE));
}
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['remember']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = $_POST['remember'];
    $result = $con->query("SELECT * FROM `user` WHERE `name` = '$username'");
    if ($result->num_rows == 0)
    {
	    echo json_encode(new login_error, JSON_UNESCAPED_UNICODE);
    }
    else
    {
        $userinfo = $result->fetch_object();
        if ($userinfo->password == $password)
        {
            class loginSuccess{};
            $loginSuccessObject = new loginSuccess;
            $loginSuccessObject->code = 0;
            $loginSuccessObject->id = $userinfo->id;
            $loginSuccessObject->token = md5(date("H:i:s"));
            $tokenEffectiveTime;
            if ($remember == "true")
            {
                $tokenEffectiveTime = date("Y-m-d H:i:s",strtotime("+30 day"));
            }
            else
            {
                $tokenEffectiveTime = date("Y-m-d H:i:s",strtotime("+1 day"));
            }
            $con->query("UPDATE `user` SET `login_token` = '" . $loginSuccessObject->token . "', `login_token_effective_time` = '" . $tokenEffectiveTime . "' WHERE `user`.`id` = " . $userinfo->id);
        	echo json_encode($loginSuccessObject, JSON_UNESCAPED_UNICODE);
        }
    }
    $con->close();
}
else
{
	echo json_encode(new parameter_is_expected_error, JSON_UNESCAPED_UNICODE);
}
?>
