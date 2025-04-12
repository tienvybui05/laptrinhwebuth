document.addEventListener("DOMContentLoaded", function() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartTable = document.querySelector(".product-table tbody");
    const sidebarCart = document.querySelector(".detail-side"); 
    const totalElement = document.querySelector(".total-cart-side div:last-child");
    const totalbill = document.querySelector(".total-sum");
    
    // Xóa nội dung cũ
    cartTable.innerHTML = "";
    sidebarCart.innerHTML = "";

    let total = 0;

    // Thêm từng sản phẩm vào bảng chính và sidebar
    cart.forEach((product, index) => {
        // Tính toán giá trị
        const numericPrice = parseInt(product.price.replace(/\D/g, ""));
        const productTotal = numericPrice * product.quantity;
        total += productTotal;

        // Thêm vào bảng chính
        const row = `
            <tr class="san-pham-items" data-index="${index}">
                <td><input type="checkbox" class="product-checkbox"></td>
                <td>
                    <div class="product-item">
                        <img src="${product.image}" alt="${product.name}" class="product-image">
                        <div class="product-info">
                            <div class="product-name">${product.name}</div>
                        </div>
                    </div>
                </td>
                <td class="price">${product.price}</td>
                <td>
                    <div class="quantity-control">
                        <button class="quantity-btn-minus">-</button>
                        <input type="text" value="${product.quantity}" class="quantity-input">
                        <button class="quantity-btn-plus">+</button>
                    </div>
                </td>
                <td class="product-total">${calculateTotal(product.price, product.quantity)}</td>
                <td class="close-cart_item">
                    <button class="action-btn">
                        <span>Xóa</span>
                    </button>
                </td>
            </tr>
        `;
        cartTable.insertAdjacentHTML("beforeend", row);

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

    // Cập nhật tổng tiền
    updateTotal();

    // Tăng giảm số lượng sản phẩm 
    document.querySelectorAll(".quantity-btn-minus, .quantity-btn-plus").forEach(button => {
        button.addEventListener("click", function() {
            const productRow = this.closest(".san-pham-items");
            const index = productRow.dataset.index;
            const productValue = productRow.querySelector(".quantity-input");
            let quantityvalue = parseInt(productValue.value);
            
            if (this.classList.contains("quantity-btn-minus")) {
                quantityvalue = Math.max(1, quantityvalue - 1);
            } else {
                quantityvalue = quantityvalue + 1;
            }
            
            productValue.value = quantityvalue;
            
            // Cập nhật số lượng trong giỏ hàng
            cart[index].quantity = quantityvalue;
            localStorage.setItem("cart", JSON.stringify(cart));
            
            // Cập nhật tổng tiền sản phẩm
            const price = cart[index].price;
            const productTotal = calculateTotal(price, quantityvalue);
            productRow.querySelector(".product-total").textContent = productTotal;
            
            // Cập nhật sidebar
            updateSidebarItem(index, quantityvalue);
            
            // Cập nhật tổng tiền
            updateTotal();
        });
    });

    // Thêm sự kiện xóa sản phẩm
    document.querySelectorAll(".action-btn").forEach(button => {
        button.addEventListener("click", function() {
            const productRow = this.closest(".san-pham-items");
            const index = productRow.dataset.index;
            
            // Xóa khỏi DOM
            productRow.remove();
            
            // Xóa khỏi giỏ hàng
            cart.splice(index, 1);
            localStorage.setItem("cart", JSON.stringify(cart));
            
            // Cập nhật lại index cho các sản phẩm còn lại
            updateProductIndexes();
            
            // Cập nhật tổng tiền
            updateTotal();
            
            // Reload để cập nhật sidebar (có thể tối ưu bằng cách cập nhật DOM thay vì reload)
            location.reload();
        });
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

    // Hàm cập nhật lại index sau khi xóa sản phẩm
    function updateProductIndexes() {
        document.querySelectorAll(".san-pham-items").forEach((row, newIndex) => {
            row.dataset.index = newIndex;
        });
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