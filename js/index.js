var userinfo;
var messages;

var FunctionComponent = Vue.extend({
    props: {
        message: null,
        userinfo: null
    },
    template:
            '<div v-show="!(!(userinfo))" id="ContentFunction">' +
                '<textarea v-if="isReply" transition="expand" id="EditArea" placeholder="请输入回复内容哟" @keydown.enter="reply" v-model="input_message"></textarea>' + 
                '<textarea v-if="isModify" transition="expand" id="EditArea" placeholder="请输入一些东西哟" @keydown.enter="modify" v-model="input_message"></textarea>' + 
                '<a v-show="!(isModify || isReply)" @click="replyMessage" id="FunctionLink">回复</a>' + 
                '<a v-show="(userinfo.admin == 1 || userinfo.id == message.userid) && !(isModify || isReply)" @click="modifyMessage" id="FunctionLink">修改</a>' +
                '<a v-show="(userinfo.admin == 1 || userinfo.id == message.userid) && !(isModify || isReply)" @click="deleteMessage" id="FunctionLink">删除</a>' +
                '<a v-show="isModify || isReply" @click="cancel" id="FunctionLink">取消</a>' +
                '<a v-show="isModify" @click="modify" id="FunctionLink">修改</a>' +
                '<a v-show="isReply" @click="reply" id="FunctionLink">回复</a>' +
            '</div>',
    data: function()
        {
            return {isModify: false, isReply: false, input_message: ""}
        },
    methods: {
        replyMessage: function(){
            this.isReply = true;
        },
        cancel: function(){
            this.isReply = false;
            this.isModify = false;
        },
        modifyMessage: function(){
            this.isModify = true;
            this.input_message = this.message.message;
        },
        deleteMessage: function(){
            $.ajax({
                url: "./apis/delete_message.php",
                type: "post",
                dataType: "json",
                data: "id=" + this.message.id,
                success: function(data){
                    if (data.code == 0){
                        getMessages();
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
        },
        modify: function(){
            $.ajax({
                url: "./apis/modify_message.php",
                type: "post",
                dataType: "json",
                data: "messageid=" + this.message.id + "&message=" + this.input_message,
                success: function(data){
                    if (data.code == 0){
                        getMessages();
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
        },
        reply: function(){
            $.ajax({
                url: "./apis/reply_message.php",
                type: "post",
                dataType: "json",
                data: "messageid=" + this.message.id + "&message=" + this.input_message,
                success: function(data){
                    if (data.code == 0){
                        getMessages();
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
        }
    }
})

Vue.component('function-bar', FunctionComponent)

var userInfo = new Vue({
    el: "#FunctionArea",
    data: {
        userinfo: userinfo,
    },
    init: function(){
        getUserinfo();
    },
    methods: {
        checkCookie: checkCookie("id")
    }
});

var comment = new Vue({
    el: "#CommentDiv",
    data: {
        userinfo: userinfo,
        message: "",
        tips: "biubiubiu!留言吧~"
    },
    methods: {
        sendMessage: function(id)
        {
            if (comment.message != "") {
                var postDataStr = 'message=' + comment.message;
                $.ajax({
                    url: "./apis/send_message.php",
                    type: "post",
                    dataType: "json",
                    data: postDataStr,
                    success: function(data){
                        if (data.code == 0){
                            cleanCommentBox();
                            getMessages();
                        }
                        else if(data.code == 8){
                            alert("发生了一些不好的事情：Code: " + data.code + ", " + data.explain);
                            logout();
                        }
                        else{
                            alert("发生了一些不好的事情：Code: " + data.code + ", " + data.explain);
                        }
                    }
                });
            } else {
                comment.tips = "你好像没输入东西呀...";
                setTimeout('cleanCommentBox()', 10);
            }
        }
    }
});

function cleanCommentBox(){
    comment.message = "";
}

var content = new Vue({
    el: "#ContentDiv",
    data: {
        messages: messages,
        userinfo: userinfo,
    },
    init: function(){
        getMessages();
    },
    methods:{
        htmlDecode: function(str){
            var s = "";
            if (str.length == 0) return "";
            s = str.replace(/&amp;/g, "&");
            s = s.replace(/&lt;/g, " <");
            s = s.replace(/&gt;/g, ">");
            s = s.replace(/&nbsp;/g, "    ");
            s = s.replace(/'/g, "\'");
            s = s.replace(/&quot;/g, "\"");
            s = s.replace(/ <br>/g, "\n");
            s = s.replace(/&middot;/g, "·");
            return s;
        }
    } 
});

function getUserinfo(){
    if (checkCookie("id"))
    {
        var id = getCookie("id");
        $.getJSON("./apis/get_user_info.php", "id="+id, function(data){
            userInfo.userinfo = data;
            comment.userinfo = data;
            content.userinfo = data;
            userinfo = data;
        })
    }
}

function getMessages(){
    $.getJSON("./apis/get_messages.php", function(data){
        content.messages = data;
    })
}
