let form = {
    name: document.getElementById('name'),
    phone: document.getElementById('phone'),
    email: document.getElementById('email'),
    password: document.getElementById('password'),
    cword: document.getElementById('cword'),
};
// console.log(form);
let regExp = {
    name: /^.{6,}$/,
    phone: /^((\+?(91)?-?)|(0?))[6-9]\d{9}$/,
    email: /[^\s@\W]+\.?_?\.?[a-z]?@[^\s@\W]+\.?[^\s@\W]+?\.?[^\s@\W]+?\.?(com|in|edu)/,
    password: /(?=.{8,})(?=.*\d+)(?=.*\W+)(?=[A-Za-z]+)/,
    cword: /(?=.{8,})(?=.*\d+)(?=.*\W+)(?=[A-Za-z]+)/,
};
let labels = {
    name: "username. Atleast 6 characters..",
    phone: "phone number",
    email: "email-syntax",
    password: "password format. Must include atleast a digit and special character and atleast 8 characters.",
    cword: "form. Passowrd should match when confirmed",
};
let errorP = document.querySelectorAll('.error');
console.log(errorP);
let error = {
    name: errorP[0],
    phone: errorP[1],
    email: errorP[2],
    password: errorP[3],
    cword: errorP[4],
}
let inputs = document.querySelectorAll('.inputF');

function regCheck() {
    let b = false;

    for (const key in form) {
        if (!regExp[key].test(form[key].value)) {
            b = true;
        }
    }
    return !b;

}
document.querySelectorAll('.inputF').forEach(item => {
    item.addEventListener('input', () => {
        error[item.id].innerHTML = "";
        if (item.value.length == 0) {
            error[item.id].style.display = 'none';
        } else {
            if (item.id == 'cword') {
                console.log(item.id);
                if (form['cword'].value != form['password'].value) {
                    let text = document.createTextNode("Invalid " + labels[item.id]);
                    error[item.id].appendChild(text);
                    error[item.id].style.display = 'block';
                } else {
                    error[item.id].style.display = 'none';

                }
            } else if (!regExp[item.id].test(form[item.id].value)) {
                let text = document.createTextNode("Invalid, " + labels[item.id]);
                error[item.id].appendChild(text);
                error[item.id].style.display = 'block';

            } else {
                error[item.id].style.display = 'none';

            }

        }
    })
})