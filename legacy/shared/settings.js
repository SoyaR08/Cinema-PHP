const form = document.getElementById("changeForm");
const passwordField = document.getElementById("currentPassword");
const newpasswordField = document.getElementById("newPassword");
const confirmnewpasswordField = document.getElementById("confirmPassword");
form.addEventListener("submit", validateNewPassword);

function validateNewPassword(e) {
    let password = passwordField.value;
    console.log(password);
    let newpassword = newpasswordField.value;
    let confirmnewpassword = confirmnewpasswordField.value;
    let errors = [];

    const expression = /^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[*?¿!]).*$/;

    if (password === "") {
        errors.push("Debe introducir un nombre");
    }

    if (newpassword === "") {
        errors.push("Debe introducir una contraseña");
    }

    if (confirmnewpassword === "") {
        errors.push("Debe confirmar su contraseña");
    }

    if (newpassword.length < 6) {
        errors.push("La contraseña debe tener un mínimo de 6 caracteres");
    } else if (!expression.test(newpassword)) {
        errors.push("La contraseña debe tener al menos 1 letra, 1 número y 1 carácter especial como: (*?¿!)");
    }

    if (newpassword !== confirmnewpassword) {
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