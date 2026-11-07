const display = document.querySelector('.display');

// Button Click event listner for product increase, decrease and remove actions
display.addEventListener('click', async (e) => {
    // Code block for Increase quantity
    if (e.target && e.target.matches('.increase')) {
        var product_id = e.target.value;
        var parentElement = e.target.parentElement;
        var quantityElement = parentElement.querySelector('.quantity');
        parentElement.classList.add('element-disabled');
        const element = parentElement.querySelector('.decrease') ?? parentElement.querySelector('.remove');

        var data = await increaseQuantity(product_id);

        if (data) {
            setTimeout(() => {
                if (data.success == true) {
                    quantityElement.textContent = data.quantity;
                    
                    if (data.quantity > 1) {
                        element.outerHTML = decreaseBtn(product_id);
                    }

                    parentElement.classList.remove('element-disabled');
                }
            }, 1000);
        } else {
            alert(`Can't increase quantity ${data.message}`);
        }
    }   

    // Code block for Decrease quantity
    if (e.target && e.target.matches('.decrease')) {
        var product_id = e.target.value;
        var parentElement = e.target.parentElement;
        var quantityElement = parentElement.querySelector('.quantity');
        parentElement.classList.add('element-disabled');
        const element = parentElement.querySelector('.decrease') ?? parentElement.querySelector('.remove');
        
        var data = await decreaseQuantity(product_id);

        if (data) {
            setTimeout(() => {
                if (data.success == true) {
                    quantityElement.textContent = data.quantity;

                    if (data.quantity <= 1) {
                        element.outerHTML = removeBtn(product_id);
                    }

                    parentElement.classList.remove('element-disabled');
                }
            }, 1000);
        } else {
            alert(`Can't decrease quantity ${data.message}`);
        }
    }   

    // Code block for remove product
    if (e.target && e.target.matches('.remove')) {
        var product_id = e.target.value;
        var parentElement = e.target.parentElement;
        var quantityElement = parentElement.querySelector('.quantity');
        parentElement.classList.add('element-disabled');
        const productElement = document.querySelector('#card'+product_id);
        var data = await removeProduct(product_id);

        if (data) {
            setTimeout(() => {
                if (data.success == true) {
                    if (data.product_count > 0) {
                        productElement?.remove();
                    } else {
                        display.innerHTML =             
                                `<div class="container-fluid bg-warning py-5 m-0 shadow fw-bold text-center">
                                   Add Products to fill your card
                                </div>`
                    }
                } else {
                    alert('Something went wrong');
                }
            }, 1000);
        } else {
            alert(`Can't remove Something went wrong`);
        }
    }
    
})


// Request Card for load full data of card items from backend
async function reqCart () {
    try {
        const res = await fetch("/backend/cart-backend.php", {
            method: "POST",
            headers: {
                'Content-type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                request: 'cart',
                action: 'fetch-cart'
            }),
            credentials: 'include'
        });

        var data = await res.json();
        var status = res.status;
        return {
            status: status,
            data: data
        };
    } catch (error) {
        console.log(error.message);
        return false;

    }
}

function increaseBtn(value) {
    var btn = `<button type="button" class="increase card-btn btn border-warning border-2 fw-bold p-2" value=${value}>+</button> `;

    return(btn);
}

function decreaseBtn(value) {
    var btn = `<button type="button" class="decrease card-btn btn border-warning border-2 fw-bold" value=${value}>-</button> `;
    return(btn);
}

function removeBtn(value) {
    var btn = `<button type="button" class="remove card-btn btn border-warning border-2 fw-bold p-2" value=${value}>
                    <i class="fa-solid fa-trash"></i>
                </button> `;
    return(btn);
}

// function removeElement (value) {
//     var element = document.createElement('button');
//     element.innerHTML = '<i class="fa-solid fa-trash"></i>';
//     element.className = 'remove card-btn btn border-warning border-2 fw-bold p-2'
//     element.value = value;
//     return(element);    
// }

async function increaseQuantity (product_id) {
    try {
        const res = await fetch("http://localhost:3000/backend/cart-backend.php", {
            method: "POST",
            headers: {
                'Content-type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                request: 'cart',
                action: 'increase-quantity',
                product_id: product_id,
            })
        });

        var data = await res.json();
        var status = res.status;
        if (status == 200) {
            return data;
        } else if (status == 401) {
            return false;
        } else {
            return false;
        }
        
    } catch (error) {
        console.log(error.message);
        return false;
    }
}

async function decreaseQuantity (product_id) {
    try {
        const res = await fetch("http://localhost:3000/backend/cart-backend.php", {
            method: "POST",
            headers: {
                'Content-type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                request: 'cart',
                action: 'decrease-quantity',
                product_id: product_id,
            })
        });

        var data = await res.json();
        var status = res.status;
        if (status == 200) {
            return data;
        } else if (status == 401) {
            return false;
        } else {
            return false;
        }
        
    } catch (error) {
        return false;
    }
}

async function removeProduct (product_id) {
    try {
        const res = await fetch("http://localhost:3000/backend/cart-backend.php", {
            method: "POST",
            headers: {
                'Content-type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                request: 'cart',
                action: 'remove-product',
                product_id: product_id,
            })
        });

        var data = await res.json();
        var status = res.status;
        if (status == 200) {
            return data;
        } else if (status == 401) {
            return false;
        } else {
            return false;
        }
        
    } catch (error) {
        return false;
    }
}


window.addEventListener ('load', async () => {
    display.textContent = "loading...";

    try {
        const data = await reqCart();
        
        if (data.status == 401) {
            display.innerHTML = 
            `<div class="container-fluid bg-warning py-5 m-0 shadow fw-bold text-center">
                Login to view your Card
                <a href="login-mail.php" class="fw-bold"> Login here </a>
            </div>`;
        } else if (data.status == 200) {
            const cart_items = data.data;
            const cart_items_count = cart_items.length;

            if (cart_items_count > 0) {
                var html = '';
                for (var i=0; i<cart_items_count; i++) {
                    var key = '';
                    key += i;

                    html += `<div class="card col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 p-0" id="card${data.data[key].product_id}" style="width: 18rem; box-shadow: 0px 10px 30px 0px rgb(10, 10, 10, 0.5)">
                                    <img src="../product-images/${data.data[key].thumbImg}" class="card-img-top" alt="Alaya cotton image">
                                    <div class="card-body">
                                      <h5 class="truncation-2line">${data.data[key].product_name}</h5>
                                      <div class="container-fluid d-flex justify-content-spacebtween align-items-center gap-1">
                                        <a href="product-view.php?id=${data.data[key].product_id}" class="btn btn-warning">View Product</a>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                          ${data.data[key].quantity <= 1 ? removeBtn(data.data[key].product_id) : decreaseBtn(data.data[key].product_id)}
                                          <span class="quantity btn btn-warning fw-bold">${data.data[key].quantity}</span>
                                          ${increaseBtn(data.data[key].product_id)}
                                        </div>
                                      </div>
                                    </div>
                                </div>`;
                }
                display.innerHTML = html;

            } else {
                display.innerHTML = 
                    `<div class="container-fluid bg-warning py-5 m-0 shadow fw-bold text-center">
                        Add Products to fill your card
                    </div>`;
            }
        } else {
            display.innerHTML = 
                `<div class="container-fluid bg-warning py-5 m-0 shadow fw-bold text-center">
                    Something went wrong
                </div>`;
            console.log(data);
        }
    } catch (error) {
        display.textContent = "error" + error.message;
    }

});


