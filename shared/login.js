const nameField = document.getElementById('username');
const passwordField = document.getElementById('password');
const form = document.getElementById('login');
form.addEventListener('submit', validateForm);

function validateForm(e) {

    let name = nameField.value;
    console.log(name);
    let password = passwordField.value;
    let errors = [];
    if (name === "") {
        errors.push("Introduce un nombre de usuario") ;
    }
    
    if (name.length > 25) {
        errors.push("El nombre solo puede tener 25 carácteres como máximo");
    }

    if (password === "") {
        errors.push("Introduce una contraseña") ;
    }

    if (errors.length > 0) {
        e.preventDefault();
        printErrors(errors); 
    } else {
        form.submit();
    }

}

function printErrors(list) {
    
    const container = document.getElementById("formContainer");
    if (document.getElementById("divErrors")) {
        container.removeChild(document.getElementById("divErrors"));
    }
    const divErrors = document.createElement('div');
    divErrors.className = "alert alert-danger my-2";
    divErrors.id = "divErrors";
    let ul = document.createElement('ul');
    list.forEach(listElement => {
        let li = document.createElement('li');
        li.appendChild(document.createTextNode(listElement));
        ul.appendChild(li);
    });
    divErrors.appendChild(ul);
    container.appendChild(divErrors);

}