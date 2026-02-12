
// Script selector for Bootstrap Tooltip
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

const whatsapp_float = document.querySelector(".whatsapp-float");
const whatsapp_chat = document.querySelector(".whatsapp-chat");
const account_icon = document.querySelector("#account-icon");
const account_menu = document.querySelector(".account-menu");




// Whats app function for home page
function whatsapp_open(){
    whatsapp_chat.classList.add("live");
    whatsapp_float.classList.add("hide");
};

function whatsapp_close(){
    whatsapp_chat.classList.remove("live");
    whatsapp_float.classList.remove("hide");
};


// Menubar account view toggle function
account_icon.addEventListener("click", ()=>{
    account_menu.classList.toggle("active");
});








