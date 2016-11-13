<?php
include_once("./include.php");
if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 200000))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo json_encode(new upload_image_error, JSON_UNESCAPED_UNICODE);
    }
    else
    {
        if (isset($_COOKIE['id']) || isset($_COOKIE['token']))
        {

            if (! isTokenValid($_COOKIE['id'], $_COOKIE['token']))
            {
                echo json_encode(new token_out_of_date, JSON_UNESCAPED_UNICODE);
                exit();
            }
            $filename = $_FILES["file"]["name"];
            $getName = end(explode('.', $filename));
            $filename = md5(date("H:i:s")) . '.' . $getName;
            move_uploaded_file($_FILES["file"]["tmp_name"], "../upload/" . $filename);
            $userid = $_COOKIE['id'];
            $sql = "UPDATE `user` SET `faceimage` = './upload/$filename' WHERE `user`.`id` = $userid ;";
            if($con->query($sql))
            {
                echo json_encode(new operate_success, JSON_UNESCAPED_UNICODE);
                exit();
            }
            else
            {
                echo json_encode(new upload_image_error, JSON_UNESCAPED_UNICODE);
                exit();
            }
        }
        else
        {
            echo json_encode(new token_out_of_date, JSON_UNESCAPED_UNICODE);
            exit();
        }
    }
}
else
{
	echo json_encode(new upload_image_error, JSON_UNESCAPED_UNICODE);
    exit();
}
?>
