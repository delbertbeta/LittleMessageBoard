<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <title>Message Board - Infomation</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/info-style.css" rel="stylesheet">
        <script src="./js/main.js"></script>
    </head>
    <body>
        <div id="ContentDiv">
            <div id="InfoDiv">
                <img id="FaceImage" src="./assets/myface.png" />
                <div id="UserInfoDiv">
                    <p id="UserInfo"><span id="UserInfoTitle">ID: </span>1</p>
                    <p id="UserInfo"><span id="UserInfoTitle">Username: </span>delbertbeta</p>
                    <button onclick="logout()" id="LogoutButton">LOGOUT</button>
                </div>
            </div>
            <svg id="Line" width="400px" height="2px" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <line x1="0" y1="0" x2="350" y2="0" style="stroke:rgb(99,99,99);stroke-width:1"></line>
            </svg>
        </div>
    </body>
</html>
