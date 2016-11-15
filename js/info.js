var FunctionComponent = Vue.extend({
    props: {
        message: null,
        userinfo: null
    },
    template:
            '<div v-show="!(!(userinfo))" id="ContentFunction">' +
                '<textarea v-if="isReply" transition="expand" id="EditArea" placeholder="请输入回复内容哟" @keydown.enter="reply" v-model="input_message"></textarea>' + 
                '<a v-show="!(isReply)" @click="replyMessage" id="FunctionLink">回复</a>' + 
                '<a v-show="isReply" @click="cancel" id="FunctionLink">取消</a>' +
                '<a v-show="isReply" @click="reply" id="FunctionLink">回复</a>' +
            '</div>',
    data: function()
        {
            return {
                isReply: false,
                input_message: ""
            }
        },
    methods: {
        replyMessage: function(){
            this.isReply = true;
        },
        cancel: function(){
            this.isReply = false;
        },
        reply: function(){
            $.ajax({
                url: "./apis/reply_message.php",
                type: "post",
                dataType: "json",
                data: "messageid=" + this.message.id + "&message=" + this.input_message,
                success: function(data){
                    if (data.code == 0){
                        alert("回复好了哟！");
                    }
                    else if(data.code == 8){
                        alert("发生了一些不好的事情：Code: " + data.code + ", " + data.explain);
                        logout();
                    }
                    else{
                        alert("发生了一些不好的事情：Code: " + data.code + ", " + data.explain);
                    }
                }
            })
            this.isReply = false;
        }
    }
})

Vue.component('function-bar', FunctionComponent)


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
                Content.userinfo = data;
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
        userinfo: {},
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