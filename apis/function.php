<?php

function isTokenValid($id, $token)
{
    include("./mysql.php");
    $getUserInfo = $con->query("SELECT * FROM `user` WHERE `id` = " . $id);
    $userInfo = $getUserInfo->fetch_object();
    if ($token == $userInfo->login_token && (strtotime("now") < strtotime($userInfo->login_token_effective_time)))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function checkAuthority($messageId, $userId)
{
    include("./mysql.php");
    $getUserInfo = $con->query("SELECT * FROM `user` WHERE `id` = " . $userId);
    $userInfo = $getUserInfo->fetch_object();
    if ($userInfo->admin == 1)
    {
        return true;
    }
    $getMessage = $con->query("SELECT * FROM `messages` WHERE `id` = " . $messageId);
    $message = $getMessage->fetch_object();
    if ($userId == $message = $message->userid)
    {
        return true;
    }
    else
    {
        return false;
    }
}

?>