var Userinfo = new Vue({
    el: "#InfoTable",
    data: {
        Userinfo: {}
    },
    methods: {
        logout: function(){
            logout();
        }
    },
    init: function(){
        if (checkCookie("id"))
        {
            $.getJSON("./apis/get_user_info.php", "id=" + getCookie("id"), function(data){
                Userinfo.Userinfo = data;
            })
        }
        else
        {
            navigateToHomepage();
        }
    }
})

var Content = new Vue({
    el: "#ContentApp",
    data: {
        messages: {},
        isThereMessages: false,
    },
    init: function(){
        $.getJSON("./apis/get_relative_messages.php", "id=" + getCookie("id"),function(data){
            Content.messages = data;
            for (var item in Content.messages)
            {
                Content.isThereMessages = true;
                break;
            }
        })
    },
    methods:{
        htmlDecode: function(str){
            var s = "";  
            if (str.length == 0) return "";  
            s = str.replace(/&amp;/g, "&");  
            s = s.replace(/&lt;/g, "<");  
            s = s.replace(/&gt;/g, ">");  
            s = s.replace(/&nbsp;/g, "    ");  
            s = s.replace(/'/g, "\'");  
            s = s.replace(/&quot;/g, "\"");  
            s = s.replace(/ <br>/g, "\n");  
            return s;  
        }
    }
})


var Upload = new Vue({
    el: "#FaceUpload",
    data: {
        Show: false,
        Status: "",
    },
    methods: {
        CloseUpload: function(){
            this.Show = false;
            $.getJSON("./apis/get_user_info.php", "id=" + getCookie("id"), function(data){
                Userinfo.Userinfo = data;
            })
            $.getJSON("./apis/get_relative_messages.php", "id=" + getCookie("id"),function(data){
                Content.messages = data;
                for (var item in Content.messages)
                {
                    Content.isThereMessages = true;
                    break;
                }
            })
        }
    }
})

function ShowUpload(){
    Upload.Show = true;
}

$('#UploadArea').dmUploader({
    url: "./apis/upload_face_image.php",
    dataType: 'json',
    allowedTypes: 'image/*',
    extFilter: 'jpg;png;gif',
    onInit: function(){
        Upload.Status = "Waiting...";
    },
    onUploadProgress: function(id, percent){
        var percentStr = percent + '%';
        Upload.Status = "Uploading..." + percentStr;
    },
    onUploadSuccess: function(id, data){
        if (data.code == 0){
            Upload.Status = "Success!";
            $.getJSON("./apis/get_user_info.php", "id=" + getCookie("id"), function(data){
                Userinfo.Userinfo = data;
            })
        }
        else{
            Upload.Status = "Error...Code: " + data.code + ", explain: " + data.explain;
        }
    },
    onComplete: function(){
        Upload.Status = "Success! Just close this window...";
    },
})