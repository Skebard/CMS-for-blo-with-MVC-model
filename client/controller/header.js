
let menuBtn = document.getElementById("btn-menu");
let modalNavMenu = document.getElementById('modal-nav-menu-id')
let btnCloseMenu = document.getElementById("btn-close-modal-menu");
let body = document.querySelector("body");
menuBtn.addEventListener('click',()=>{
    body.style.overflow='hidden';
    modalNavMenu.classList.remove('hidden');
    console.log('hi');
});
btnCloseMenu.addEventListener('click',()=>{
    body.style.overflow='auto';
    modalNavMenu.classList.add('hidden');
});
modalNavMenu.addEventListener('click',()=>{
    body.style.overflow='auto';
    modalNavMenu.classList.add('hidden');
});