function sendMessage(e,id)
{
    if (e.keyCode == 13) {
        if (area.value != "") {
            $.ajax({
                async:false,
            });
            var area = document.getElementById("CommentTextArea");
            var postDataStr = 'message=' + area.value + '&userid=' + id;
            $.post("./sendmessage.php", postDataStr, function(data){
                alert(data);
                location.reload();
            });
        } else {
            alert("你好像没输入东西呀！");
            location.reload();
        }
    }   
}

function deleteMessage(event)
{
    $.ajax({
        async:false,
    });
    var thisElement = event.srcElement;
    var parent = thisElement.parentElement.parentElement;
    var id = parent.children.ContentTitle.children.ContentId.innerHTML;
    var postDataStr = "id=" + id;
    $.post("./deletemessage.php", postDataStr, function(data)
    {
        alert(data);
        location.reload();
    });
}

function modifyMessage_Send(event)
{
    $.ajax({
        async:false,
    });
    var thisElement = event.srcElement;
    var parent = thisElement.parentElement.parentElement;
    var messageText = parent.children.EditArea.value;
    var id = parent.children.ContentTitle.children.ContentId.innerHTML;
    var postDataStr = "messageid=" + id + "&message=" + messageText;
    $.post("./modifymessage.php", postDataStr, function(data)
    {
        alert(data);
        location.reload();
    });
}

function modifyMessage(event)
{
    var thisElement = event.srcElement;
    var parent = thisElement.parentElement;
    var parentLength = parent.children.length;
    for (var i=1; i<=parentLength; i++)
        parent.removeChild(parent.children.FunctionLink);
    var sendLink = document.createElement("a");
    sendLink.setAttribute("id", "FunctionLink");
    sendLink.setAttribute("onclick", "modifyMessage_Send(event)");
    sendLink.innerText = "发送";
    parent.appendChild(sendLink);
    var parentsparent = parent.parentElement;
    var messageText = parentsparent.children.ContentText.innerText;
    var editArea = document.createElement("textarea");
    editArea.setAttribute("id", "EditArea");
    editArea.value = messageText;
    parentsparent.replaceChild(editArea, parentsparent.children.ContentText);
}

function navigateToRegister()
{
    window.location = "./register.php";
}

function navigateToLogin()
{
    window.location = "./login.php";
}

function replyMessage(event)
{
    var thisElement = event.srcElement;
    var parent = thisElement.parentElement.parentElement;
    parent.removeChild(parent.children.ContentFunction);
    var editArea = document.createElement("textarea");
    editArea.setAttribute("id", "EditArea");
    editArea.setAttribute("placeholder", "回复吧~");
    parent.appendChild(editArea);
    var functionArea = document.createElement("div");
    functionArea.setAttribute("id", "ContentFunction");
    var replyLink = document.createElement("a");
    replyLink.setAttribute("id", "FunctionLink");
    replyLink.setAttribute("onclick", "replyMessage_Send(event)");
    replyLink.innerText = "发送";
    functionArea.appendChild(replyLink);
    parent.appendChild(functionArea);
}

function replyMessage_Send(event)
{
    $.ajax({
        async:false,
    });
    var thisElement = event.srcElement;
    var parent = thisElement.parentElement.parentElement;
    var messageText = parent.children.EditArea.value;
    var id = parent.children.ContentTitle.children.ContentId.innerHTML;
    var postDataStr = "messageid=" + id + "&message=" + messageText;
    $.post("./replymessage.php", postDataStr, function(data)
    {
        alert(data);
        location.reload();
    });
}

function logout()
{
    window.location = "./logout.php";
}

function uploadFace(event)
{
    var body = document.body;
    var shadowDiv = document.createElement("div");
    shadowDiv.setAttribute("id", "ShadowDiv");
    shadowDiv.style.opacity = 0;
    body.appendChild(shadowDiv);
    body.children.ShadowDiv.style.opacity = 0.5;
    var uploadDiv = document.createElement("div");
    uploadDiv.setAttribute("id", "UploadDiv");
    uploadDiv.innerHTML = '<button id="CloseButton" onclick="CloseUpload()">x</button><form id="UploadArea" action="./uploadfaceimage.php" method="post" enctype="multipart/form-data"><input type="file" name="file" id="FileUploadButton" accept=".png, .jpg, .jpeg" /><br><input type="submit" id="UploadButton" name="submit" value="UPLOAD" /></form>';
    body.appendChild(uploadDiv);
}

function CloseUpload()
{
    var body = document.body;
    body.removeChild(body.children.ShadowDiv);
    body.removeChild(body.children.UploadDiv);
}