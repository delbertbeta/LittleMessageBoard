var Register = new Vue({
    el: "#Register",
    data: {
        RegisterError: false,
        RegisterSuccess: false,
        Code: {},
        RegisterInfo: {
            Username: "",
            Password: "",
            ComfirmPassword: ""
        },
        UserInfo: {}
    },
    methods: {
        registerAccount: function(){
            if (Register.RegisterInfo.Username != "" && Register.RegisterInfo.Password != "" && Register.RegisterInfo.Password == Register.RegisterInfo.ComfirmPassword){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "./apis/register.php",
                    data: {
                        username: Register.RegisterInfo.Username,
                        password: md5(Register.RegisterInfo.Password)
                    },
                    success: function(data){
                        if (data.code == 0) {
                            Register.RegisterError = false;
                            Register.RegisterSuccess = true;
                            Register.UserInfo = data;
                            setTimeout("navigateToLogin()", 2000);
                        }
                        else{
                            Register.Code = data;
                            Register.RegisterError = true;
                            Register.RegisterSuccess = false;
                        }
                    }
                })
            }
            else{
                Register.RegisterError = true;
                Register.RegisterSuccess = false;
                Register.Code.code = 9;
                Register.Code.explain = "请检查输入的注册信息！";
            }
        }
    },
    init: function(){
        if (checkCookie("id"))
        {
            navigateToHomepage();
        }
    }
})
