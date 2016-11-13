<?php
include_once("./include.php");

if (!$con)
{
	die(json_encode(new sql_error, JSON_UNESCAPED_UNICODE));
}
if (isset($_GET['id']))
{
    $id = $_GET['id'];
    $objectArray = array();
    $response = $con->query("SELECT * FROM `messages` WHERE `relative_id` = " . $id . " ORDER BY `id` DESC");
    while($result = $response->fetch_object())
    {
        $getUserInfo = $con->query("SELECT * FROM `user` WHERE `id` = " .$result->userid . ";");
        $userInfo = $getUserInfo->fetch_object();
        $result->username = $userInfo->name;
        $result->faceimage = $userInfo->faceimage;
        if ($result->relative_message != 0)
        {
            $getRelativeMessage = $con->query("SELECT * FROM `messages` WHERE `id` = " . $result->relative_message . ";");
            $relativeMessage = $getRelativeMessage->fetch_object();
            if ($relativeMessage != NULL)
            {
                $result->relative_deleted = false;
                $result->relative_message_content = $relativeMessage->message;
                $result->relative_date = $relativeMessage->date;
                $result->relative_time = $relativeMessage->time;
                $getRelativeUserInfo = $con->query("SELECT * FROM `user` WHERE `id` = " .$relativeMessage->userid . ";");
                $relativeUserInfo = $getRelativeUserInfo->fetch_object();
                $result->relative_username = $relativeUserInfo->name;
            }
            else
            {
                $result->relative_deleted = true;
            }
        }
        $objectArray[] = $result;
    }
    echo json_encode($objectArray, JSON_UNESCAPED_UNICODE);
}
else
{
    echo json_encode(new parameter_is_expected_error, JSON_UNESCAPED_UNICODE);
}

?>
