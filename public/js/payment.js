document.addEventListener("DOMContentLoaded", function(){
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const productall = document.querySelector(".product-all");
    
    productall.innerHTML = "";

    // Thêm từng sản phẩm vào bảng chính và sidebar
    cart.forEach((product, index) => {

        // Thêm vào bảng chính
        const row = `
            <div class="product-summary" data-index="${index}">
                <div class="product-info">
                    <p class="product-name">${product.name}</p>
                </div>
                <div class="product-qty">x ${product.quantity}</div>
                <div class="product-price">${calculateTotal(product.price, product.quantity)}</div>
            </div>
        `;
        productall.insertAdjacentHTML("beforeend", row);
    });
});

function calculateTotal(price, quantity) {
    const numericPrice = parseInt(price.replace(/\D/g, ""));
    const total = numericPrice * quantity;
    return `${total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}đ`;
}