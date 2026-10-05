// Variables 
const thumbImgBtns = document.querySelectorAll(".img-btn");
const mainImg = document.querySelector(".main-img");
const removeBtns = document.querySelectorAll(".remove");

// removeBtns.forEach(button => {
//     button.addEventListener("click", () => {
//         button.disabled = true;

//         setTimeout(() => {
//             button.disabled = false;
//         }, 1000);
//     })
// })

thumbImgBtns.forEach( button => {
    const image = button.querySelector("img");

    button.addEventListener("click", () => {
        var source = image.getAttribute('src');
        mainImg.setAttribute('src', source);
})
})
