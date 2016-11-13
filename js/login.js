var Login = new Vue({
    el: "#Login",
    data: {
        LoginError: false,
        Code: {},
        LoginInfo: {
            Username: "",
            Password: "",
            Remember: false
        }
    },
    methods: {
        verifyLoginInfo: function(){
             $.ajax({
                 type: "POST",
                 dataType: "json",
                 url: "./apis/verify_login.php",
                 data: {
                     username: Login.LoginInfo.Username,
                     password: md5(Login.LoginInfo.Password),
                     remember: Login.LoginInfo.Remember
                 },
                 success: function(data){
                     if (data.code == 0) {
                         Login.LoginError = false;
                         if (Login.LoginInfo.Remember)
                         {
                            setCookie("id", data.id, 30);
                            setCookie("token", data.token, 30);
                         }
                         else
                         {
                            setCookie("id", data.id);
                            setCookie("token", data.token);
                         }
                         navigateToHomepage();
                     }
                     else{
                         Login.Code = data;
                         Login.LoginError = true;
                     }
                 }
            })
        }
    },
    init: function(){
        if (checkCookie("id"))
        {
            navigateToHomepage();
        }
    }
})
