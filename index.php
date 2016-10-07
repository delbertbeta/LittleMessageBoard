<?php
session_start();
$isLogin = false;
$isAdmin = false;
$id = 0;

$con = new mysqli("localhost","root","","message_board");
mysqli_set_charset($con, "utf8");
if (!$con) die();

if (!isset($_SESSION['id']))
{
    $isLogin = false;
}else{
    $isLogin = true;
    $id = $_SESSION['id'];
    $result = mysqli_query($con ,"SELECT * FROM `user` WHERE `id` = '$id'");
    $userinfo = $result->fetch_array();
    if ($userinfo['admin'] == 1)
        $isAdmin = true;
}

echo <<<HEAD
<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <title>Message Board</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./css/style.css" rel="stylesheet">
    <script src="./js/main.js"></script>
    <script src="./js/jquery.min.js"></script>
</head>

<body>
<div id="FunctionArea">
    <div id="FunctionBarDiv">
HEAD;
if (!$isLogin)
{
    echo '<a href="./login.php"><img id="FaceImage" src="./assets/defaultface.jpg" /></a>';
}
else
{
    $result = mysqli_query($con ,"SELECT * FROM `user` WHERE `id` = '$id'");
    $array = $result->fetch_array();
    echo '<a href="./info.php"><img id="FaceImage" src="';
    if ($array['faceimage'] == "")
        echo './assets/defaultface.jpg';
    else
    {
        $faceimage = $array['faceimage'];
        echo $faceimage;
    }
    echo '" /></a>';
}
echo <<<BAR
        <a href="./about.html">
            <p id="AboutButton">i</p>
        </a>
    </div>
</div>
BAR;

if ($isLogin)
{
    echo '<div id="CommentDiv"><textarea onkeydown="sendMessage(event,'. $id .')" id="CommentTextArea" placeholder="biubiubiu!留言吧~"></textarea></div>';
}

echo '<div id="ContentDiv">';

if (!$isLogin)
{
    $result = mysqli_query($con ,"SELECT * FROM `messages` ORDER BY `id` DESC");
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
        echo '</div>';
    }
}
else{
    $result = mysqli_query($con ,"SELECT * FROM `messages` ORDER BY `id` DESC");
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
        if ($id == $thisid || $isAdmin == true)
        {
        echo <<<FUNCTIONAREA
        <a onclick="modifyMessage(event)" id="FunctionLink">修改</a>
        <a onclick="deleteMessage(event)" id="FunctionLink">删除</a>
FUNCTIONAREA;
        }
        echo '</div>';
        echo '</div>';
    }
}
echo <<<END
    </div>
</body>

</html>
END;
$result->free();
$con->close();

?>

