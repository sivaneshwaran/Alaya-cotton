const pass_input = document.querySelector("#password_input");
const cpass_input = document.querySelector("#cpassword_input");
const show_pass = document.querySelector(".show_pass");
const show_cpass = document.querySelector(".show_cpass");
const register_form = document.querySelector(".register-form");

//Registeration Form
show_pass.addEventListener("click", ()=>{
    let timeoutId;

    if(pass_input.type === "password"){
        pass_input.type = "text";
        show_pass.firstChild.classList.remove("fa-eye");
        show_pass.firstChild.classList.add("fa-eye-slash");

        clearTimeout(timeoutId);
        timeoutId = setTimeout(()=>{
            pass_input.type = "password";
            show_pass.firstChild.classList.remove("fa-eye-slash");
            show_pass.firstChild.classList.add("fa-eye");
        },5000);
    }else{
        pass_input.type = "password";
        show_pass.firstChild.classList.remove("fa-eye-slash");
        show_pass.firstChild.classList.add("fa-eye");
        clearTimeout(timeoutId);
    }
});

show_cpass.addEventListener("click", ()=>{
    let timeoutId;

    if(cpass_input.type === "password"){
        cpass_input.type = "text";
        show_cpass.firstChild.classList.remove("fa-eye");
        show_cpass.firstChild.classList.add("fa-eye-slash");

        clearTimeout(timeoutId);
        timeoutId = setTimeout(()=>{
            cpass_input.type = "password";
            show_cpass.firstChild.classList.remove("fa-eye-slash");
            show_cpass.firstChild.classList.add("fa-eye");
        },5000);

    }else{
        cpass_input.type = "password";
        show_cpass.firstChild.classList.remove("fa-eye-slash");
        show_cpass.firstChild.classList.add("fa-eye");
        clearTimeout(timeoutId);
    }
});

window.onload = ()=> {   
    register_form.reset();
}
