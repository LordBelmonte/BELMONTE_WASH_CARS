// TABS

const tabs =
document.querySelectorAll('.tab');

// FORMS

const loginForm =
document.querySelector('.login-form');

const registerForm =
document.querySelector('.register-form');

// BOTÕES

const loginTab = tabs[0];
const registerTab = tabs[1];

// ESTADO INICIAL

registerForm.style.display = 'none';

// LOGIN

loginTab.addEventListener('click', () => {

    // ACTIVE

    loginTab.classList.add('active');

    registerTab.classList.remove('active');

    // FORMS

    loginForm.style.display = 'block';

    registerForm.style.display = 'none';

});

// CADASTRO

registerTab.addEventListener('click', () => {

    // ACTIVE

    registerTab.classList.add('active');

    loginTab.classList.remove('active');

    // FORMS

    registerForm.style.display = 'block';

    loginForm.style.display = 'none';

});