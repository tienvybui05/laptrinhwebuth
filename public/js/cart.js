document.addEventListener("DOMContentLoaded", function() {

    // an gio hang
    let iconcart = document.querySelector(".cart-icon");
    let closesidecart = document.querySelector(".close_cart-side");
    let body = document.querySelector('body');
    console.log(iconcart);
    iconcart.addEventListener("click",()=>{
        body.classList.add("showCart");
    });
    closesidecart.addEventListener("click",()=>{
        body.classList.remove("showCart");
    });
    // Khi click vào overlay (phần tối bên ngoài giỏ hàng)
    document.addEventListener('click', (e) => {
        if (body.classList.contains('showCart') && 
            !e.target.closest('.cart-side') && 
            !e.target.closest('.cart-icon')) {
        body.classList.remove('showCart');
        }
    });


    // xử lý thêm giỏ hàng và lưu vào storage
    const btn = document.querySelectorAll(".btn-add-cart")
    btn.forEach(function(button,index){
    button.addEventListener("click", function(event){{
        var btnItem = event.target
        var product = btnItem.closest(".san-pham-item")
        var productId = product.getAttribute("data-id");
        var productImg = product.querySelector("img").src
        var productName = product.querySelector("h3").innerText
        var productPrice = product.querySelector("p").innerText
        var productQuality = parseInt(1)
        addToCart(productId,productImg,productName,productPrice,productQuality)
        

    }})
    })    
    loadCart();

    const viewCartBtn = document.querySelector('.view-cart-btn');
    viewCartBtn.addEventListener('click', function () {
        if (!isLoggedIn) {
            // Chưa đăng nhập → Chuyển đến trang login
            window.location.href = '../auth/login.php';
        } else {
            // Lấy cart từ localStorage
            let cart = JSON.parse(localStorage.getItem("cart")) || [];

            // Gửi qua PHP để lưu vào DB
            fetch("../admin/carts/save-cart.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ cart: cart })
            })
            .then(response => {
                return response.json(); // vẫn parse như thường
            })
            .then(data => {
                if (data.success) {
                    // Chuyển sang trang giỏ hàng nếu lưu thành công
                    window.location.href = "../pages/cart.php";
                } else {
                    alert("Có lỗi khi lưu giỏ hàng");
                }
            })
            .catch(error => {
                console.error("Lỗi khi gửi cart:", error);
            });
        }
    });

});





function addToCart(id, img, name, price, quantity) {
    var cart = JSON.parse(localStorage.getItem("cart")) || [];
    const existingProduct = cart.find(item => item.id === id);
    
    if (existingProduct) {
        // Tăng số lượng trong localStorage
        existingProduct.quantity += 1;

        // Cập nhật UI: tìm phần tử hiển thị quantity và cập nhật lại
        const allItems = document.querySelectorAll(".detail_cart-side");
        allItems.forEach(item => {
            const itemName = item.querySelector(".item-name").innerText;
            if (itemName === name.toUpperCase()) {
                item.querySelector(".quantity").innerText = existingProduct.quantity;
            }
        });

        total();
    } else {
        cart.push({
            id: id,
            image: img,
            name: name,
            price: price,
            quantity: quantity
        });

        var productElement = document.createElement("div");
        productElement.className = "detail_cart-side";
        productElement.innerHTML = `
            <img src="${img}" alt="${name}" class="product-image">
            <div class="item-info">
                <div class="item-name">${name.toUpperCase()}</div>
                <div class="item-quantity">
                    <span class="quantity" style="color: red;">${quantity}</span> × <span class="price">${price}</span>
                </div>
            </div>
        `;
        
        document.querySelector(".detail-side").appendChild(productElement);
        total();
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    alert("Đã thêm vào giỏ hàng!");
}

function loadCart(){
    // Cập nhật giao diện
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart.forEach(item => {
        var productElement = document.createElement("div");
        productElement.className = "detail_cart-side";
        productElement.innerHTML = `
            <img src="${item.image}" alt="${item.name}" class="product-image">
            <div class="item-info">
                <div class="item-name">${item.name.toUpperCase()}</div>
                <div class="item-quantity">
                    <span class="quantity" style="color: red;">${item.quantity}</span> × <span class="price">${item.price}</span>
                </div>
            </div>
        `;
        
        document.querySelector(".detail-side").appendChild(productElement);
        total();
    });
}



function total() {
    var cartItem = document.querySelectorAll(".detail-side .detail_cart-side");
    var totalC = 0;
    // console.log(cartItem.length);
    for (var i = 0; i < cartItem.length; i++) {
        var inputValue = cartItem[i].querySelector(".item-quantity .price").innerText
        var cleanPrice = inputValue.replace(/[^\d]/g, ''); // Chỉ giữ lại số
        var numberPrice = parseInt(cleanPrice);
        var productPrice = cartItem[i].querySelector(".item-quantity .quantity").innerText
        totalA = productPrice*numberPrice
        totalC = totalC+totalA;
        totalD = totalC.toLocaleString('de-DE')
        
        
    }
    var cartTotalA = document.querySelector(".total-cart-side .productTotal .total-amount")
    cartTotalA.innerHTML = totalD;
}