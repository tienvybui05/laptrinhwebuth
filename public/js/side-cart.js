document.addEventListener("DOMContentLoaded", function() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartTable = document.querySelector(".product-table tbody");
    const sidebarCart = document.querySelector(".detail-side"); 
    const totalElement = document.querySelector(".total-cart-side div:last-child");
    const totalbill = document.querySelector(".total-sum");
    // Xóa nội dung cũ
    sidebarCart.innerHTML = "";

    let total = 0;

    // Thêm từng sản phẩm vào bảng chính và sidebar
    cart.forEach((product, index) => {
        // Tính toán giá trị
        const numericPrice = parseInt(product.price.replace(/\D/g, ""));
        const productTotal = numericPrice * product.quantity;
        total += productTotal;


        // Thêm vào sidebar
        const sidebarItem = `
            <div class="detail_cart-side" data-index="${index}">
                <img src="${product.image}" alt="${product.name}" class="product-image">
                <div class="item-info">
                    <div class="item-name">${product.name.toUpperCase()}</div>
                    <div class="item-quantity">
                        <span style="color: red;">${product.quantity}</span> × ${product.price}
                    </div>
                </div>
            </div>
        `;
        sidebarCart.insertAdjacentHTML("beforeend", sidebarItem);
    });


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
    
    // Hàm cập nhật tổng tiền
    function updateTotal() {
        let newTotal = 0;
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        
        cart.forEach(product => {
            const numericPrice = parseInt(product.price.replace(/\D/g, ""));
            newTotal += numericPrice * product.quantity;
        });
        
        totalElement.textContent = `${formatVietnameseCurrency(newTotal)}đ`;
        totalbill.textContent = `${formatVietnameseCurrency(newTotal)}đ`;
    }
    // Hàm cập nhật sidebar item
    function updateSidebarItem(index, newQuantity) {
        const sidebarItem = document.querySelector(`.detail_cart-side[data-index="${index}"]`);
        if (sidebarItem) {
            const quantitySpan = sidebarItem.querySelector("span[style='color: red;']");
            quantitySpan.textContent = newQuantity;
        }
    }


    // Thêm hàm format tiền Việt
    function formatVietnameseCurrency(number) {
        return number.toString()
            .replace(/\D/g, "") // Loại bỏ tất cả ký tự không phải số
            .replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Thay dấu phẩy thành dấu chấm
    }
});

function calculateTotal(price, quantity) {
    const numericPrice = parseInt(price.replace(/\D/g, ""));
    const total = numericPrice * quantity;
    return `${total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}đ`;
}