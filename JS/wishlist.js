var tooltip_right = document.querySelector(".tooltip-right");
var addToWishlistBtn = document.querySelector(".addToWishlist");
var productId = document.querySelector(".product-details").id;
var productName = encodeURIComponent(document.querySelector(".p-name").innerText);

const userId = document.cookie;
console.log(document.cookie.length);

function loadDoc(){
    const xmlHttp = new XMLHttpRequest();
    xmlHttp.onload = ()=>{
        var result = xmlHttp.responseText;
        // if(result == 0 ){
        //     tooltip_right.style.visibility = "visible";
        //     tooltip_right.innerHTML = "Not Added (Something went wrong)";
        // }else if(result == 1){
        //     tooltip_right.style.visibility = "visible";
        //     tooltip_right.innerHTML = "Added to Wishlist";  
        //     setTimeout(()=>{
        //         window.location.reload();
        //     }, 2200);              
        // }else if(result == 2){
        //     tooltip_right.style.visibility = "visible";
        //     tooltip_right.innerHTML = "Product already in wishlist";                
        // }
        // setTimeout(()=>{
        //     tooltip_right.style.visibility = "hidden";
        // }, 2000);
        console.log(result);
        
    }

    xmlHttp.open("POST", "/./controller/wishlist_control.php", true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.send("action=Add&product_id="+productId + "&product_name="+productName);
}


addToWishlistBtn.addEventListener("click", loadDoc);
// console.log(productName);


// function addToWishlist(){
//     var result = < ?php   
//         if(isset($wishlist)){
//             echo $wishlist->addProduct($product["product_id"], $product["product_name"]);
//             $run = true;
//         }
//     ?>;
    
//     if(result == 0 ){
//         tooltip_right.style.visibility = "visible";
//         tooltip_right.innerHTML = "Not Added (Something went wrong)";
//     }else if(result == 1){
//         tooltip_right.style.visibility = "visible";
//         tooltip_right.innerHTML = "Added to Wishlist";  
//         setTimeout(()=>{
//             window.location.reload();
//         }, 2200);              
//     }else if(result == 2){
//         tooltip_right.style.visibility = "visible";
//         tooltip_right.innerHTML = "Product already in wishlist";                
//     }
//     setTimeout(()=>{
//         tooltip_right.style.visibility = "hidden";
//     }, 2000);
// 
// addToWishlistBtn.addEventListener("click", addToWishlist);     