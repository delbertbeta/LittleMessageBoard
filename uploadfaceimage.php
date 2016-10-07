<?php
session_start();
include("mysql.php");
if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 200000))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo '<script>alert("Return Code: ' . $_FILES["file"]["error"] . '");window.location = "./info.php";</script>");';
    }
    else
    {
        $filename = $_FILES["file"]["name"];
        $getName = end(explode('.', $filename));
        $filename = md5(date("H:i:s")) . '.' . $getName;
        move_uploaded_file($_FILES["file"]["tmp_name"], "./upload/" . $filename);
        $userid = $_SESSION['id'];
        $sql = "UPDATE `user` SET `faceimage` = './upload/$filename' WHERE `user`.`id` = $userid ;";
        if(mysqli_query($con, $sql))
        {
    	    echo '<script>alert("Success!");window.location = "./info.php";</script>';
        }
        else
        {	
    	    echo '<script>alert("Something bad happened... XD");window.location = "./info.php";</script>");';
        }
    }
}
else
{
    echo '<script>alert("Invalid file: The file must be png or jpg file and the image file must less than 200KB.");window.location = "./info.php";</script>';
}
?>