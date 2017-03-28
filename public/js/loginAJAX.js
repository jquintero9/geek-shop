

function Form (form, fields, regex, maxLengths, messages, messagesContainer, submitButton) {

    this.form = form;
    this.fields = fields;
    this.regex = regex;
    this.maxLengths = maxLengths;
    this.messages = messages;
    this.messagesContainer = messagesContainer;
    this.submitButton = submitButton;
    this.submitButton.disabled = true;
    this.submitButton.removeAttribute("class");
    this.submitButton.setAttribute("class", "input disabled");

    this.showMessage = function(name, messageType) {
        var container = this.messagesContainer[name];
        container.innerHTML = this.messages[messageType][name];
        container.style.display = "block";
    };
    
    this.hiddenMessage = function(name) {
        var container = this.messagesContainer[name];
        container.innerHTML = "";
        container.style.display = "none";
    };
    
    this.validateLength = function (name, value) {
        var isValid = true;
        
        if (value !== undefined) {
            if (value.trim().length === 0) {
                this.showMessage(name, "empty");
                isValid = false;
            }
            else if (value.trim().length > this.maxLengths[name]) {
                this.showMessage(name, "length");
                isValid = false;
            }
        }

        return isValid;
    };

    this.validateRegex = function(name, value) {
        var isValid = true;

        if (!this.regex[name].exec(value)) {
            this.showMessage(name, "regex");
            isValid = false;
        }

        return isValid;
    };

    function submitEnabled(object) {
        var fieldName;
        var isValid = true;

        for (fieldName in object.fields) {
            if (!object.fields[fieldName].validated) {
                isValid = false;
                break;
            }
        }

        if (isValid) {
            object.submitButton.disabled = false;
            object.submitButton.removeAttribute("class");
            object.submitButton.setAttribute("class", "input active");
        }
        else {
            object.submitButton.disabled = true;
            object.submitButton.removeAttribute("class");
            object.submitButton.setAttribute("class", "input disabled");
        }
    }
    
    function validate(event, object) {
        var inputName = event.target.name;
        var inputValue = event.target.value;
        var isValid = false;

        if (object.validateLength(inputName, inputValue)) {
            if (object.validateRegex(inputName, inputValue)) {
                object.fields[inputName].validated = true;
                object.hiddenMessage(inputName);
                isValid = true;
            }
        }

        if (!isValid) {
            object.fields[inputName].validated = false;
        }

        submitEnabled(object);
    }

    this.addEvents = function () {
        var object = this;
        var fieldName;

        /* Se asignan los eventos para los campos */
        for (fieldName in this.fields) {
            this.fields[fieldName].input.addEventListener(
                "blur", function (event) { validate(event, object); }
            );
        }
    };
    
    this.init = function() {
        this.addEvents();
    };
}

function Field(inputHTML) {
    this.input = inputHTML;
    this.validated = false;
    this.name = inputHTML.name;
}

function main() {
    var form = document.querySelector("#login-form");

    var fields = new Array(2);
    fields["username"] = new Field(form["username"]);
    fields["password"] = new Field(form["password"]);


    var regexForm = {
        username: /^[a-z0-9]+$/,
        password: /^[a-z0-9]+$/
    };

    var maxLengths = {
       "username": 30,
       "password": 16
    };

    var messageError = {
        regex: {
            username: "Username invalido.",
            password: "Password no válido."
        },
        length: {
            username: "Ingrese máximo 30 caracteres.",
            password: "Ingrese máximo 16 caracteres."
        },
        empty: {
            username: "¿Cúal es tu nombre de usuario?",
            password: "¿Cuál es tu contraseña?",
            submit: "El formulario no ha sido validado."
        }
    };

    var messagesContainer = {
        username: document.querySelector("#username-message"),
        password: document.querySelector("#password-message"),
    };


    /* Conexión al servidor mediante AJAX */
    var xhr = new XMLHttpRequest();
    var STATE_COMPLETE = 4;
    var OK = 200;

    var messageContainer = document.querySelectorAll(".messages")[0];

    function response(object) {

        object.submitButton.disabled = true;
        object.submitButton.removeAttribute("class");
        object.submitButton.setAttribute("class", "input disabled");

        if (xhr.readyState == STATE_COMPLETE) {
            if (xhr.status == OK) {
                var json = JSON.parse(xhr.responseText);
                console.log(json);
                if (json.state == "success") {
                    messageContainer.innerHTML = "Te estamos redireccionando...";
                    window.setTimeout(function() {
                        var url = this.location.href;
                        this.location.href = url + "admin";
                    }, 3000);
                }
                else if (json.state == "no_exists") {
                    object.fields["username"].input.focus();
                    object.fields["password"].input.value = "";
                    messageContainer.innerHTML = json.message;
                    object.submitButton.disabled = false;
                    object.submitButton.removeAttribute("class");
                    object.submitButton.setAttribute("class", "input active");
                }
            }
        }
        else {
            messageContainer.style.display = "block";
            messageContainer.innerHTML = "Se están procesando los datos...";
        }
    }

    function sendAJAX(json, object) {

        xhr.onreadystatechange = function () { response(object); };
        xhr.open("POST", "", true);
        xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
        //xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(json);
    }

    function prepareData(event, object) {
        event.preventDefault();

        var data = {};
        var name;

        for (name in object.fields) {
            data[name] = object.fields[name].input.value;
        }

        sendAJAX(JSON.stringify(data), object);
    }

    var loginForm;

    loginForm = new Form(
        form,
        fields,
        regexForm,
        maxLengths,
        messageError,
        messagesContainer,
        document.querySelector("#submit-button")
    );

    loginForm.init();

    loginForm.form.addEventListener("submit", function(event) { prepareData(event, loginForm); });
    console.log(loginForm.form);
}

window.addEventListener("load", main);
