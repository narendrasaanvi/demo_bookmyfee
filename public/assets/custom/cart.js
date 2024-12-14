console.log('cart.js loaded');
let totalPrice = 0;

async function updateCartCount() {
    var response = await fetch('/cart/count');
    var { count } = await response.json();
    const cartItemCount = document.getElementById('cart-count');
    if (!cartItemCount) {
        return;
    }
    cartItemCount.textContent = count;
}

async function removeItemFromCart(id) {
    var response = await fetch(`/cart/remove/${id}`);
    if (response.ok) {
        updatePrice();
        updateCartCount();
        document.getElementById(`cart_item_${id}`)?.remove();

        var data = await getCartList();

        updateSideCart(data);
        showToast("Tournament Removed successfully");
    }
}



/**
 *
 * @returns {Future<Array>} items
*/
const getCartList = async () => {
    var response = await fetch('/cart/view');
    var items = await response.json();
    return items;
}

// clear cart list on cart page except the last item
function clearCartList() {
    const rows = document.querySelector('.cart_table tbody')?.getElementsByTagName('tr');
    const rowCount = rows?.length ?? 0;
    for (let i = 0; i < rowCount - 1; i++) {
        document.querySelector('.cart_table tbody')?.removeChild(rows[0]);
    }
}


async function updateCartList() {
    var list = await getCartList();
    clearCartList();
    updateSideCart(list);
    // const cartTable = document.getElementById('cart-table');
    const cartTable = document.querySelector('.cart_table')?.getElementsByTagName('tbody')[0];
    list?.forEach((e) => {

        const { id, product_image, product_name, product_price, quantity } = e;

        let newRow = `<tr class="cart_item" id="cart_item_${id}">
                                <td data-title="Tournament">
                                    <a class="cart-productimage" href="shop-details.html"><img width="91" height="91"
                                            src="${product_image}" alt="Image"></a>
                                </td>
                                <td data-title="Name">
                                    <a class="cart-productname" href="shop-details.html">${product_name}</a>
                                </td>
                                <td data-title="Price">
                                    <span class="amount"><bdi><span>$</span><span class='cross-price'>${product_price}</span></bdi></span>
                                </td>
                                <td data-title="Quantity">
                                    <div class="quantity d-flex align-items-center">
                                        <button class="btn btn-dark quantity-minus qty-btn" onclick="updateQuantity('cart_item_${id}', -1,0)">
                                            <i class="fa fa-minus"></i>
                                        </button>

                                        <input type="number" name="item_quantity" id="${id}" class="qty-input form-control mx-2"
                                            value="${quantity}" min="1" max="99">

                                        <button class="btn btn-dark quantity-plus qty-btn" onclick="updateQuantity('cart_item_${id}', 1,0)">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>

                                </td>
                                <td data-title="Total">
                                    <span class="amount"><bdi><span>$</span><span class='cross-total-price'>${multiplyPrice(product_price, quantity)}</span>
                                           </bdi></span>
                                </td>
                                <td data-title="Remove">
                                    <span class="remove"><i class="fa fa-trash" onclick="removeItemFromCart('${id}')"></i></span>
                                </td>
                            </tr>`;


        cartTable?.insertAdjacentHTML('afterbegin', newRow);

    });

    document.querySelectorAll("input[name='item_quantity']")?.forEach((element) => {
        element.addEventListener('input', (event) => {
            var newValue = event.target.value;
            updateQuantity(`cart_item_${element.id}`, newValue, 1);
        });
    });
    updatePrice();
    updateCartCount();
}


function multiplyPrice(v1, v2) {
    var data = Number(`${v1}`) * Number(`${v2}`);
    return data.toFixed(2);
}


// Price Section --------------------
async function updateTotalPrice(price) {
    totalPrice = Number(`${price}`);
    document.querySelectorAll('.cart-tournament-total-price')?.forEach((e) => {
        e.textContent = totalPrice.toFixed(2);
    });
    document.querySelectorAll('.cart-tournament-sum-price')?.forEach((e) => {
        e.textContent = (totalPrice + 5).toFixed(2);
    });
}

const updatePrice = async () => {
    var response = await fetch(`/cart/total`);
    if (response.ok) {
        const { total_amount } = await response.json();
        await updateTotalPrice(total_amount);
    }
}

//  quantity section --------------------------

/**
 * @param {String} keyword
 * @param {Number } value
 */
function updateQuantity(keyword, value, fromCode) {
    var currentRow = document.getElementById(keyword);
    let currentQuantityElement = currentRow?.querySelector("input[name='item_quantity']");
    var currentQuantity = parseInt(currentQuantityElement.value);

    if (fromCode == 0) {
        var newQuantity = currentQuantity + value;
        currentQuantityElement.value = newQuantity;
        updateQuantityOnServer(keyword.split('_').at(-1), currentQuantityElement?.value);

    }
    else {
        var newQuantity = value >= 99 ? 99 : value <= 0 ? 1 : value;
        if (value <= 0) {
            currentQuantityElement.value = 1;
        }
        if (value >= 99) {
            currentQuantityElement.value = 99;
        }
        // currentQuantityElement.value = newQuantity;
        updateQuantityOnServer(keyword.split('_').at(-1), newQuantity);
    }
    //showToast("Quantity Updated");

}


//============================================================
//================= Update Price =============================
//============================================================
function updatePriceOfElement(id, quantity) {
    document.querySelector(`#cart_item_${id} .cross-total-price`).textContent = multiplyPrice(
        document.querySelector(`#cart_item_${id} .cross-price`)?.textContent,
        quantity,
    );
}
//===============================================================
//================= Update Quantity =============================
//===============================================================
async function updateQuantityOnServer(id, newQuantity) {
    var response = await fetch(
        `/cart/update/${id}`,
        {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },

            body: JSON.stringify({
                "quantity": newQuantity
            })
        }
    );
    if (response.ok) {
        updatePrice();
        updatePriceOfElement(id, newQuantity);
    }
}


function clearSideCart() {
    const sideCart = document.getElementById('side-cart');
    console.log(
        'clear cart', sideCart
    );
    if (sideCart != null) {
        sideCart.innerHTML = '<p></p>';
    }

}

async function updateSideCart(list) {
    clearSideCart();
    const globalSideCart = document.getElementById('side-cart');

    if (list.length == 0) {
        console.log(
            'unknowm cart', globalSideCart
        );
        if (globalSideCart != null) {
            globalSideCart.innerHTML = 'Your cart is empty';
        }
    }
    else {

        list.forEach((e) => {
            const { id, product_image, product_name, product_price, quantity } = e;

            let item = `<li class="woocommerce-mini-cart-item mini_cart_item">
        <a class="remove remove_from_cart_button" data-id="${id}" onclick="removeItemFromCart('${id}')"><i class="far fa-times"></i></a>
        <a href="#"><img src="${product_image}" alt="Cart Image">${product_name}</a>
        <span class="quantity">${quantity} ×
            <span class="woocommerce-Price-amount amount">
                <span class="woocommerce-Price-currencySymbol">$</span>${product_price}</span>
        </span>
    </li>`
            console.log(
                'print cart', globalSideCart
            );
            if (globalSideCart != null) {
                globalSideCart.insertAdjacentHTML('afterbegin', item);
            }

        });

    }

}

async function refreshSideCartList() {
    var res = await getCartList();
    updateSideCart(res);
}


//==========================================================================
//=================     Clear Cart  ========================================
//==========================================================================
async function clearCart() {
    var response = await fetch(
        '/cart/clear',
        {
            method: "GET",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }
    );
    if (response.ok) {
        updateCartList();
        showToast("Cart Cleared");
    }
}
//=======================================================================
//================= Show toast ==========================================
//=======================================================================
function showToast(text) {
   alert(text);
}




