document.addEventListener("DOMContentLoaded", function() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartTable = document.querySelector(".product-table tbody");
    const sidebarCart = document.querySelector(".detail-side"); 
    const totalElement = document.querySelector(".total-cart-side div:last-child"); // Thêm dòng này
    const totalbill = document.querySelector(".total-sum")
    // Xóa nội dung cũ
    cartTable.innerHTML = "";
    sidebarCart.innerHTML = "";

    let total = 0; // Khai báo biến tổng tiền

    // Thêm từng sản phẩm vào bảng chính và sidebar
    cart.forEach(product => {
        // Tính toán giá trị
        const numericPrice = parseInt(product.price.replace(/\D/g, ""));
        const productTotal = numericPrice * product.quantity;
        total += productTotal;

        // Thêm vào bảng chính
        const row = `
            <tr class="san-pham-items">
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
                        <button class="quantity-btn minus">-</button>
                        <input type="text" value="${product.quantity}" class="quantity-input">
                        <button class="quantity-btn plus">+</button>
                    </div>
                </td>
                <td class="price">${calculateTotal(product.price, product.quantity)}</td>
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
            <div class="detail_cart-side">
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

    // Cập nhật tổng tiền trong sidebar
    totalElement.textContent = `${formatVietnameseCurrency(total)}đ`;
    totalbill.textContent = `${formatVietnameseCurrency(total)}đ`
    // Thêm hàm format tiền Việt
    function formatVietnameseCurrency(number) {
        return number.toString()
            .replace(/\D/g, "") // Loại bỏ tất cả ký tự không phải số
            .replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Thay dấu phẩy thành dấu chấm
    }
    // Thêm sự kiện xóa sản phẩm
    document.querySelectorAll(".action-btn").forEach(button => {
        button.addEventListener("click", function() {
            const productRow = this.closest(".san-pham-items");
            const productName = productRow.querySelector(".product-name").textContent;
            
            // Xóa khỏi DOM
            productRow.remove();
            
            // Cập nhật localStorage
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            cart = cart.filter(item => item.name !== productName);
            localStorage.setItem("cart", JSON.stringify(cart));
            
            // Reload để cập nhật sidebar
            location.reload();
        });
    });
});

function calculateTotal(price, quantity) {
    // 1. Chuyển giá từ chuỗi "560.000đ" thành số 560000
    const numericPrice = parseInt(price.replace(/\D/g, ""));
    
    // 2. Tính tổng tiền
    const total = numericPrice * quantity;
    
    // 3. Định dạng với dấu chấm phân cách hàng nghìn
    return `${total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}đ`;
}