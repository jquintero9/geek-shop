
/*function LoginForm(username, password) {
    this.username = username;
    this.password = password;
    
    this.regex = {
        "username": /^[a-z]+$/,
        "password": /^[a-zA-Z0-9_\-]+$/
    };
    //this.regexUserName = /^[a-z]+$/;
    //this.regexPassword = /^[a-zA-Z0-9_\-]+$/;
    
    this.validarInput = function(input) {
        var inputValue = input.value;
        var regex = this.regex[inputValue.name];
        
        if (!regex.exec(inputValue)) {
            this.username.focus();
        }
    };
    
    this.validarPassword = function() {
        
    };
    
    this.username.addEventListener("blur", this.validarUserName);
    this.password.addEventListener("blur", this.validarPassword);
}
*/

function enviarDatos(event) {
    var form = event.target;
    var datos = "";
}

window.onload = function() {
    loginForm = document.querySelector("#login-form");
    loginForm.addEventListener("submit", enviarDatos);
    //new LoginForm(loginForm["username"], loginForm["password"]);
};


