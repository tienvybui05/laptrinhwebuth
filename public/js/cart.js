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
    // xử lý thêm giỏ hàng và lưu vào storage
    const btn = document.querySelectorAll(".btn-add-cart")
    btn.forEach(function(button,index){
    button.addEventListener("click", function(event){{
        var btnItem = event.target
        var product = btnItem.closest(".san-pham-item")
        var productImg = product.querySelector("img").src
        var productName = product.querySelector("h3").innerText
        var productPrice = product.querySelector("p").innerText
        var productQuality = parseInt(1)
        addToCart(productImg,productName,productPrice,productQuality)
        

    }})
    })    
    loadCart();
});





function addToCart(img, name, price, quantity) {
    var cart = JSON.parse(localStorage.getItem("cart")) || [];
    const existingProduct = cart.find(item => item.name === name);
    
    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.push({
            image: img,
            name: name,
            price: price,
            quantity: quantity
        });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    alert("Đã thêm vào giỏ hàng!");
    var productElement = document.createElement("div");
        productElement.className = "detail_cart-side";
        productElement.innerHTML = `
            <img src="${img}" alt="${name}" class="product-image">
            <div class="item-info">
                <div class="item-name">${name.toUpperCase()}</div>
                <div class="item-quantity">
                    <span style="color: red;">${quantity}</span> × ${price}
                </div>
            </div>
        `;
        
        document.querySelector(".detail-side").appendChild(productElement);
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
                    <span style="color: red;">${item.quantity}</span> × ${item.price}
                </div>
            </div>
        `;
        
        document.querySelector(".detail-side").appendChild(productElement);
    });
}