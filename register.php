<?php
session_start();
if (isset($_SESSION['id']))
    echo '<script>location.href("./");</script>';

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwordconfirm']))
{
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $confirmpw = md5($_POST['passwordconfirm']);
    $con = new mysqli("localhost","root","","message_board");
    mysqli_set_charset($con, "utf8");



    if ($password != $confirmpw)
    {
        $con->close();
        echo <<<PWISNTMATCHERROR
<!DOCTYPE html>
<html lang="zh-cn" xmlns:svg="http://www.w3.org/2000/svg">
    <head>
        <title>Message Board - Register</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./css/register-style.css" rel="stylesheet">
        <script src="./js/main.js"></script>
    </head>
    <body>
        <div id="RegisterDiv">
            <div id="RegisterTitle">
                <span id="LargerText">R</span>
                <span id="LitterText">EGISTER</span>
            </div>
            <svg id="Line" width="400px" height="2px" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <line x1="0" y1="0" x2="350" y2="0" style="stroke:rgb(99,99,99);stroke-width:1"></line>
            </svg>
            <form id="InputArea" method="POST" action="./register.php">
                <p class="TipText" id="UsernameText">Username</p><input class="InputBox" id="UsernameBox" type="text" name="username"><br>
                <p class="TipText" id="PasswordText">Password</p><input class="InputBox" id="PasswordBox" type="password" name="password"><br>
                <p class="TipText" id="PasswordText">Confirm Password</p><input class="InputBox" id="PasswordBox" type="password" name="passwordconfirm"><br>
                <p id="ErrorTip">你的密码和说好的不一样啊喂(#`O′)</p>
                <input id="Submit" type="submit" value="REGISTER">
            </form>
            <button onclick="navigateToLogin()" id="LoginLink">LOGIN</button>
        </div>
    </body>
</html>
PWISNTMATCHERROR;
    }else
    {
        $result = mysqli_query($con ,"SELECT * FROM `user` WHERE `name` = '$username'");
        if ($result->num_rows == 1)
        {
            $con->close();
            echo <<<USEREXISTERROR
<!DOCTYPE html>
<html lang="zh-cn" xmlns:svg="http://www.w3.org/2000/svg">
    <head>
        <title>Message Board - Register</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./css/register-style.css" rel="stylesheet">
        <script src="./js/main.js"></script>
    </head>
    <body>
        <div id="RegisterDiv">
            <div id="RegisterTitle">
                <span id="LargerText">R</span>
                <span id="LitterText">EGISTER</span>
            </div>
            <svg id="Line" width="400px" height="2px" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <line x1="0" y1="0" x2="350" y2="0" style="stroke:rgb(99,99,99);stroke-width:1"></line>
            </svg>
            <form id="InputArea" method="POST" action="./register.php">
                <p class="TipText" id="UsernameText">Username</p><input class="InputBox" id="UsernameBox" type="text" name="username"><br>
                <p class="TipText" id="PasswordText">Password</p><input class="InputBox" id="PasswordBox" type="password" name="password"><br>
                <p class="TipText" id="PasswordText">Confirm Password</p><input class="InputBox" id="PasswordBox" type="password" name="passwordconfirm"><br>
                <p id="ErrorTip">有人的用户名和你一样哎(●ˇ∀ˇ●)</p>
                <input id="Submit" type="submit" value="REGISTER">
            </form>
            <button onclick="navigateToLogin()" id="LoginLink">LOGIN</button>
        </div>
    </body>
</html>
USEREXISTERROR;
        }
        else{
            $query = "INSERT INTO `user` (`id`, `name`, `password`, `faceimage`, `admin`) VALUES (NULL, '$username', '$password', '', '0');";
            mysqli_query($con ,$query);
            $result = mysqli_query($con ,"SELECT * FROM `user` WHERE `name` = '$username'");
            $userinfo = $result->fetch_array();
            $con->close();
            $_SESSION['id'] = $userinfo['id'];
            echo "<script>alert('注册成功 id:" .$userinfo['id'] . " username: " . $userinfo['name'] ." 请妥善保管！');location.href('./');</script>";
        }
    }
}
else echo <<<REGISTERPAGE
<!DOCTYPE html>
<html lang="zh-cn" xmlns:svg="http://www.w3.org/2000/svg">
    <head>
        <title>Message Board - Register</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./css/register-style.css" rel="stylesheet">
        <script src="./js/main.js"></script>
    </head>
    <body>
        <div id="RegisterDiv">
            <div id="RegisterTitle">
                <span id="LargerText">R</span>
                <span id="LitterText">EGISTER</span>
            </div>
            <svg id="Line" width="400px" height="2px" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <line x1="0" y1="0" x2="350" y2="0" style="stroke:rgb(99,99,99);stroke-width:1"></line>
            </svg>
            <form id="InputArea" method="POST" action="./register.php">
                <p class="TipText" id="UsernameText">Username</p><input class="InputBox" id="UsernameBox" type="text" name="username"><br>
                <p class="TipText" id="PasswordText">Password</p><input class="InputBox" id="PasswordBox" type="password" name="password"><br>
                <p class="TipText" id="PasswordText">Confirm Password</p><input class="InputBox" id="PasswordBox" type="password" name="passwordconfirm"><br>
                <input id="Submit" type="submit" value="REGISTER">
            </form>
            <button onclick="navigateToLogin()" id="LoginLink">LOGIN</button>
        </div>
    </body>
</html>
REGISTERPAGE;
?>