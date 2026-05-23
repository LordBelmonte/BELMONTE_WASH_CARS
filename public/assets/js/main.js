const mobileButton =
document.querySelector('.menu-mobile');

const navbar =
document.querySelector('.navbar');

mobileButton.addEventListener(
'click',
() => {

    navbar.classList.toggle('active');

});