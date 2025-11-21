const registerForm = document.getElementById('register');
const userNameField = document.getElementById('username');
const firstPasswordField = document.getElementById('password');
const confirmPasswordField = document.getElementById('Newpassword');

registerForm.addEventListener("submit", validateRegisterForm);

function validateRegisterForm(e) {
    let name = userNameField.value;
    let firstPassword = firstPasswordField.value;
    let secondPassword = confirmPasswordField.value;
    let errors = [];

    const expression = /^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[*?¿!]).*$/;

    if (name === "") {
        errors.push("Debe introducir un nombre");
    }

    if (firstPassword === "") {
        errors.push("Debe introducir una contraseña");
    }

    if (secondPassword === "") {
        errors.push("Debe confirmar su contraseña");
    }

    if (firstPassword.length < 6) {
        errors.push("La contraseña debe tener un mínimo de 6 caracteres");
    } else if (!expression.test(firstPassword)) {
        errors.push("La contraseña debe tener al menos 1 letra, 1 número y 1 carácter especial como: (*?¿!)");
    }

    if (firstPassword !== secondPassword) {
        errors.push("Las contraseñas no coinciden");
    }

    if (errors.length > 0) {
        e.preventDefault();
        printErrors(errors);
    }
}

function printErrors(list) {
    const container = document.getElementById("formContainer");
    let divErrors = document.getElementById("divErrors");

    if (!divErrors) {
        divErrors = document.createElement('div');
        divErrors.className = "alert alert-danger my-2";
        divErrors.id = "divErrors";
        container.appendChild(divErrors);
    }

    divErrors.innerHTML = ''; 
    let ul = document.createElement('ul');
    list.forEach(listElement => {
        let li = document.createElement('li');
        li.textContent = listElement;
        ul.appendChild(li);
    });
    divErrors.appendChild(ul);
}
