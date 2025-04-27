document.addEventListener("DOMContentLoaded", function() {
    // an gio hang
    let iconcart = document.querySelector(".cart-icon");
    let closesidecart = document.querySelector(".close_cart-side");
    let body = document.querySelector('body');
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

    if (idUser) {
        fetchCartFromDB(idUser);
    } else {
        loadCart();             
    }

    const btnBuyNow = document.querySelectorAll(".checkout-cart-btn");

    btnBuyNow.forEach(function(button) {
        button.addEventListener("click", function() {
            if (!isLoggedIn) {
                alert('Bạn chưa đăng nhập!');
                return;
            }

            fetch('../includes/cart/addCartToOrder.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ idUser: idUser })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Chỉ chuyển trang khi server đã thêm đơn hàng thành công
                    window.location.href = '../pages/payment.php';
                } else {
                    alert(data.message || "Có lỗi xảy ra khi thêm đơn hàng.");
                }
            })
            .catch(error => {
                console.error('Lỗi Fetch:', error);
                alert('Có lỗi khi gửi yêu cầu. Vui lòng thử lại.');
            });
        });
    });



    

    const btnn = document.querySelectorAll(".btn-buy-now");
    btnn.forEach(function(button, index) {
        button.addEventListener("click", function(event) {
            var btnItem = event.target
            var product = btnItem.closest(".san-pham-item")
            var productImg = product.querySelector("img").src
            var productName = product.querySelector("h3").innerText
            
            var idProduct = product.getAttribute('data-id')
            var productPrice = product.querySelector("p").innerText
            //var productPrice = product.getAttribute('data-price')
            var productQuality = 1
            
            
            
            const orderData = {
                order: [
                    {
                        id: idProduct,
                        image: productImg,
                        name: productName,
                        price: productPrice,
                        quantity: productQuality
                    }
                ]
            };
            console.log("orderData chi tiết:", orderData);
            console.log("idProduct:", idProduct);
            console.log("productPrice:", productPrice);
            console.log("productQuality:", productQuality);
            

            fetch('../includes/cart/load_buynow-order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = `../pages/payment.php`;
                } else {
                    alert('Có lỗi: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Lỗi Fetch:', error);
                alert('Không thể kết nối tới server.');
            });
        })
    })

});





function addToCart(id, img, name, price, quantity) {
    var cart = JSON.parse(localStorage.getItem("cart")) || [];
    const existingProduct = cart.find(item => item.id === id);
    console.log(idUser);
    
    if(!idUser){
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
    else{
        
            // Đã đăng nhập → gọi API lưu vào DB
            const product = { id, image: img, name, price, quantity };

            fetch("../admin/carts/save-cart.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    idUser: idUser,
                    cart: [product] // gửi 1 sản phẩm đơn
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Đã thêm vào giỏ hàng (server)!");
                    fetchCartFromDB(idUser); // Gọi lại giỏ hàng từ DB và render
                } else {
                    alert("Thêm vào giỏ hàng thất bại!");
                }
            })
            .catch(err => {
                console.error("Lỗi gửi giỏ hàng:", err);
            });
    }
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

function renderCart(cart) {
    const sidebarCart = document.querySelector(".detail-side");
    sidebarCart.innerHTML = "";

    cart.forEach((product, index) => {
        const sidebarItem = `
            <div class="detail_cart-side" data-index="${index}">
                <img src="${product.image}" alt="${product.name}" class="product-image">
                <div class="item-info">
                    <div class="item-name">${product.name.toUpperCase()}</div>
                    <div class="item-quantity">
                        <span class="quantity" style="color: red;">${product.quantity}</span> × <span class="price">${product.price}</span>
                    </div>
                </div>
            </div>
        `;
        sidebarCart.insertAdjacentHTML("beforeend", sidebarItem);
    });

    total();
}

function fetchCartFromDB(idUser) {
    fetch(`../includes/cart/load_side-cart.php`)
        .then(res => res.json())
        .then(data => {
            console.log("🛒 Dữ liệu fetch từ DB:", data);
            if (data.success) {
                renderCart(data.cart); // ✅ render ra side-cart
            } else {
                console.error("Không có dữ liệu giỏ hàng", data.message);
            }
        })
        .catch(err => {
            console.error("Lỗi khi fetch cart từ DB:", err);
        });
}