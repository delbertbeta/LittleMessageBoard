<?php
session_start();
if (isset($_SESSION['id']))
    echo '<script>window.location = "./";</script>';

if (isset($_POST['username']))
{
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $con = new mysqli("localhost","root","","message_board");
    mysqli_set_charset($con, "utf8");
    $result = mysqli_query($con ,"SELECT * FROM `user` WHERE `name` = '$username'");
    if ($result->num_rows == 0)
    {
        $con->close();
        echo <<<LOGINERRORPAGE
<!DOCTYPE html>
<html lang="zh-cn" xmlns:svg="http://www.w3.org/2000/svg">
    <head>
        <title>Message Board - Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./css/login-style.css" rel="stylesheet">
        <script src="./js/main.js"></script>
    </head>
    <body>
        <div id="LoginDiv">
            <div id="LoginTitle">
                <span id="LargerText">L</span>
                <span id="LitterText">OGIN</span>
            </div>
            <svg id="Line" width="400px" height="2px" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <line x1="0" y1="0" x2="350" y2="0" style="stroke:rgb(99,99,99);stroke-width:1"></line>
            </svg>
            <form id="InputArea" method="POST" action="./login.php">
                <p class="TipText" id="UsernameText">Username</p><input class="InputBox" id="UsernameBox" type="text" name="username"><br>
                <p class="TipText" id="PasswordText">Password</p><input class="InputBox" id="PasswordBox" type="password" name="password"><br>
                <p id="ErrorTip">好像没这个用户呀（逃</p>
                <input id="Submit" type="submit" value="LOGIN">
                
            </form>
            <button onclick="navigateToRegister()" id="RegisterLink">REGISTER</button>
        </div>
    </body>
</html>
LOGINERRORPAGE;
    }
    else
    {
        $userinfo = $result->fetch_array();
        if ($userinfo['password'] == $password)
        {
            $con->close();
            $_SESSION['id'] = $userinfo['id'];
            echo '<script>window.location = "./";</script>';
        }
        else {
        $con->close();
        echo <<<LOGINERRORPAGE
<!DOCTYPE html>
<html lang="zh-cn" xmlns:svg="http://www.w3.org/2000/svg">
    <head>
        <title>Message Board - Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./css/login-style.css" rel="stylesheet">
        <script src="./js/main.js"></script>
    </head>
    <body>
        <div id="LoginDiv">
            <div id="LoginTitle">
                <span id="LargerText">L</span>
                <span id="LitterText">OGIN</span>
            </div>
            <svg id="Line" width="400px" height="2px" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <line x1="0" y1="0" x2="350" y2="0" style="stroke:rgb(99,99,99);stroke-width:1"></line>
            </svg>
            <form id="InputArea" method="POST" action="./login.php">
                <p class="TipText" id="UsernameText">Username</p><input class="InputBox" id="UsernameBox" type="text" name="username"><br>
                <p class="TipText" id="PasswordText">Password</p><input class="InputBox" id="PasswordBox" type="password" name="password"><br>
                <p id="ErrorTip">好像是密码错了？</p>
                <input id="Submit" type="submit" value="LOGIN">
            </form>
            <button onclick="navigateToRegister()" id="RegisterLink">REGISTER</button>
        </div>
    </body>
</html>
LOGINERRORPAGE;

        }
    }
}
else echo <<<LOGINPAGE
<!DOCTYPE html>
<html lang="zh-cn" xmlns:svg="http://www.w3.org/2000/svg">
    <head>
        <title>Message Board - Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./css/login-style.css" rel="stylesheet">
        <script src="./js/main.js"></script>
    </head>
    <body>
        <div id="LoginDiv">
            <div id="LoginTitle">
                <span id="LargerText">L</span>
                <span id="LitterText">OGIN</span>
            </div>
            <svg id="Line" width="400px" height="2px" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <line x1="0" y1="0" x2="350" y2="0" style="stroke:rgb(99,99,99);stroke-width:1"></line>
            </svg>
            <form id="InputArea" method="POST" action="./login.php">
                <p class="TipText" id="UsernameText">Username</p><input class="InputBox" id="UsernameBox" type="text" name="username"><br>
                <p class="TipText" id="PasswordText">Password</p><input class="InputBox" id="PasswordBox" type="password" name="password"><br>
                <input id="Submit" type="submit" value="LOGIN">
            </form>
            <button onclick="navigateToRegister()" id="RegisterLink">REGISTER</button>
        </div>
    </body>
</html>
LOGINPAGE;
?>