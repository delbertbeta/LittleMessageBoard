<?php
session_start();
if (isset($_SESSION['id']))
{
    $id = $_SESSION['id'];
    $con = new mysqli("localhost","root","","message_board");
    mysqli_set_charset($con, "utf8");
    if (!$con) die();
    $result = mysqli_query($con ,"SELECT * FROM `user` WHERE `id` = '$id'");
    $userinfo = $result->fetch_array();
    $faceimage = $userinfo['faceimage'];
    $name = $userinfo['name'];
    echo <<<HEADER
<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <title>Message Board - Infomation</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./css/info-style.css" rel="stylesheet">
        <script src="./js/main.js"></script>
        <link href="./css/style.css" rel="stylesheet">
        <script src="./js/jquery.min.js"></script>
    </head>
    <body>
        <div id="ContentDiv">
            <table id="InfoTable">
                <tr>
                <td>
HEADER;
    if($faceimage != "")
        echo '<img id="InfoFaceImage" onclick="uploadFace(event)" src="' . $faceimage . '" />';
    else
        echo '<img id="InfoFaceImage" onclick="uploadFace(event)" src="./assets/defaultface.jpg" />';
    echo '</td><td>';
    echo '<p id="UserInfo"><span id="UserInfoTitle">ID: </span><span id="UserId">' . $id . '</span></p>';
    echo '<p id="UserInfo"><span id="UserInfoTitle">Username: </span><span>' . $name . '</span></p>';
    echo '<button onclick="logout()" id="LogoutButton">LOGOUT</button>';
    echo <<<TABLE
                </td>
                </tr>
            </table>
            <div id="NavigationDiv">
                <p id="TipText">回复我的</p>
                <svg id="Line" width="500px" height="2px" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <line x1="0" y1="0" x2="500" y2="0" style="stroke:rgb(99,99,99);stroke-width:1"></line>
                </svg>
            </div>
TABLE;
    $result = mysqli_query($con ,"SELECT * FROM `messages` WHERE `relative_id` = $id ORDER BY `id` DESC");
    if ($result->num_rows == 0)
    {
        echo '<p>真寂寞，没人回复你呢...</p></div>';
    }
    else
    {
        while ($message = $result->fetch_array())
        {
            echo '<div id="Content"><div id="ContentTitle">';
            $thisid = $message['userid'];
            $query = mysqli_query($con ,"SELECT * FROM `user` WHERE `id` = '$thisid'");
            $userinfo = $query->fetch_array();
            $faceimage = $userinfo['faceimage'];
            if($faceimage != "")
                echo '<img id="ContentFaceImage" src="' . $faceimage . '" />';
            else
                echo '<img id="ContentFaceImage" src="./assets/defaultface.jpg" />';
            echo '<span id="ContentName">';
            echo $userinfo['name'];
            echo '</span><span id="ContentTime">';
            echo $message['date'] . ' ' . $message['time'];
            echo '</span></p><p id="ContentId">';
            echo $message['id'];
            echo '</div>';
            if ($message['relative_message'] != 0)
            {
                $relativeMessageId = $message['relative_message'];
                $getRelativeMessage = mysqli_query($con ,"SELECT * FROM `messages` WHERE `id` = $relativeMessageId");
                $relativeMessage = $getRelativeMessage->fetch_array();
                $relativeUserId = $message['relative_id'];
                $getRelativeUser = mysqli_query($con, "SELECT * FROM `user` WHERE `id` = $relativeUserId");
                $relativeUser = $getRelativeUser->fetch_array();
                echo '<div id="RelativeContent"><p id="RelativeContentTitle"><span id="RelativeContentName">';
                echo $relativeUser['name'];
                echo '</span><span id="RelativeContentTime">';
                echo $relativeMessage['date'] . ' ' . $relativeMessage['time'];
                echo '</span></p><p id="ContentId">';
                echo $relativeMessage['id'];
                echo '<div id="RelativeContentText">';
                echo $relativeMessage['message'];
                echo '</div>';
                echo '</div>';
            }
            echo '<div id="ContentText">';
            echo $message['message'];
            echo '</div>';
            echo '<div id="ContentFunction">';
            echo '<a onclick="replyMessage(event)" id="FunctionLink">回复</a>';
            echo '</div>';
            echo '</div>';
        }
    }
}else{
    echo '<script>window.location = "./";</script>';
}

?>