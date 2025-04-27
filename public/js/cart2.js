document.addEventListener("DOMContentLoaded", function() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartTable = document.querySelector(".product-table tbody");
    const sidebarCart = document.querySelector(".detail-side"); 
    const totalElement = document.querySelector(".total-cart-side div:last-child");
    const totalbill = document.querySelector(".total-sum");
    // Xóa nội dung cũ
    // cartTable.innerHTML = "";
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


    // Tăng giảm số lượng sản phẩm 
    document.querySelectorAll(".quantity-btn-minus, .quantity-btn-plus").forEach(button => {
        button.addEventListener("click", function() {
            const productRow = this.closest(".san-pham-items");
            const input = productRow.querySelector(".quantity-input");
            const idProduct = this.dataset.id;
            let quantity = parseInt(input.value);
            // Sau khi cập nhật số lượng trong cart...
            let cartphu = JSON.parse(localStorage.getItem("cartphu")) || [];
            const selectedProduct = cartphu.find(i => i.id == idProduct);
            
                if (this.classList.contains("quantity-btn-minus")) {
                    if (selectedProduct) {
                        quantity = Math.max(1, quantity - 1);
                        selectedProduct.quantity = quantity;
                    }
                    else{
                        quantity = Math.max(1, quantity - 1);
                    }
                } else {
                    if (selectedProduct) {
                        quantity += 1;
                        selectedProduct.quantity = quantity;
                    }
                    else{
                        quantity += 1;
                    }
                }
                
            
            input.value = quantity;
    
            // Gửi Ajax cập nhật số lượng
            $.ajax({
                url: '../admin/entities/update_quantity.php',
                method: 'POST',
                data: {
                    idProduct: idProduct,
                    quantity: quantity
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        //location.reload(); // reload lại để cập nhật thành tiền và tổng tiền
                        
                    } else {
                        alert(data.message);
                    }
                }
            });
            localStorage.setItem("cartphu", JSON.stringify(cartphu));
            updateTotal();
        });
    });
    

    document.querySelector("#chonhet").addEventListener("click", function () {
        const status = this.checked;
        const checkboxes = document.querySelectorAll('.product-checkbox');
        let cartPhu = [];
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = status;
            const row = checkbox.closest(".san-pham-items");
            const id = row.getAttribute("data-id");
            const img = row.querySelector("img").src;
            const name = row.querySelector(".product-name").innerText;
            const price = row.querySelector(".price").innerText;
            const quantity = parseInt(row.querySelector(".quantity-input").value);
    
            if (status) {
                // Nếu chọn hết → lưu vào cartphu
                cartPhu.push({ id, image: img, name, price, quantity });
            }
        });
    
        if (status) {
            // Ghi lại toàn bộ cartphu
            localStorage.setItem("cartphu", JSON.stringify(cartPhu));
        } else {
            // Bỏ chọn hết → xoá cartphu
            localStorage.removeItem("cartphu");
        }
        updateTotal();
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
    
    // Thêm sự kiện xóa sản phẩm
    document.querySelectorAll(".action-btn").forEach(button => {
        button.addEventListener("click", function () {
            const productRow = this.closest(".san-pham-items");
            const index = parseInt(productRow.dataset.index);
            const removedProduct = cart[index]; // Lưu lại sản phẩm sắp xóa
            const idUser = this.dataset.iduser; // Đảm bảo bạn đã lưu idUser vào localStorage khi đăng nhập
            const idProduct = this.dataset.id;
            // Xóa khỏi DOM chính
            productRow.remove();
            removeFromCartPhu(idProduct);
            // Xóa khỏi localStorage
            cart.splice(index, 1);
            localStorage.setItem("cart", JSON.stringify(cart));
    
            // Xóa khỏi sidebar
            const sidebarItem = document.querySelector(`.detail_cart-side[data-index="${index}"]`);
            if (sidebarItem) {
                sidebarItem.remove();
            }
                $.ajax({
                    url: '../admin/entities/delete_cart_item.php',
                    method: 'POST',
                    data: {
                        idUser: idUser,
                        idProduct: idProduct
                    },
                    dataType: 'text',
                    success: function (response) {
                        const data = JSON.parse(response);
                        if (data.status !== "success") {
                            alert("Xóa trên database thất bại: " + data.message);
                        }
                    }
                });
    
            // Cập nhật lại index DOM chính
            updateProductIndexes();
    
            // Cập nhật lại index sidebar
            document.querySelectorAll(".detail_cart-side").forEach((item, i) => {
                item.setAttribute("data-index", i);
            });
    
            updateTotal();
        });
    }); 

    const checkboxes = document.querySelectorAll(".product-checkbox");

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            const row = checkbox.closest(".san-pham-items");

            const id = row.getAttribute("data-id");
            const img = row.querySelector("img").src;
            const name = row.querySelector(".product-name").innerText;
            const price = row.querySelector(".price").innerText;
            const quantity = parseInt(row.querySelector(".quantity-input").value);

            if (checkbox.checked) {
                addToCartPhu(id, img, name, price, quantity);
            } else {
                removeFromCartPhu(id);
            }
            updateSelectAllCheckbox();
            updateTotal();
        });
    });

    
    const viewCartBtn = document.querySelector('.checkout-btn');

    viewCartBtn.addEventListener('click', function () {
        let cartPhu = JSON.parse(localStorage.getItem("cartphu")) || [];
        let cart = JSON.parse(localStorage.getItem("cart")) || [];

        fetch("../includes/cart/save_cartphu.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ cart: cartPhu })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                localStorage.removeItem('cartphu');
                window.location.href = "../pages/payment.php";
            } else {
                alert("Lỗi khi đặt hàng: " + data.message);
            }
        })
        .catch(error => {
            console.error("Lỗi khi gửi cart:", error);
        });
    });


    // Hàm updateTotal xử lý DOM mà không cần reload hay gọi lại DB
    function updateTotal() {
        let newTotal = 0;
        const rows = document.querySelectorAll(".san-pham-items");
    
        rows.forEach(row => {
            const checkbox = row.querySelector(".product-checkbox");
            if (checkbox && checkbox.checked) {
                const priceElement = row.querySelector(".price");
                const quantityInput = row.querySelector(".quantity-input");
                const subtotalCell = row.querySelector(".product-total");
    
                const price = parseInt(priceElement.textContent.replace(/\D/g, ""));
                const quantity = parseInt(quantityInput.value);
    
                const subtotal = price * quantity;
                newTotal += subtotal;
    
                if (subtotalCell) {
                    subtotalCell.textContent = `${formatVietnameseCurrency(subtotal)}đ`;
                }
            }
        });
    
        const totalElement = document.querySelector(".total-cart-side div:last-child");
        const totalAmountSpan = document.querySelector(".total-sum .total-amount");
    
        if (totalElement) totalElement.textContent = `${formatVietnameseCurrency(newTotal)}đ`;
        if (totalAmountSpan) totalAmountSpan.textContent = `${formatVietnameseCurrency(newTotal)}đ`;
    }
    

    // Hàm định dạng tiền
    function formatVietnameseCurrency(number) {
        return number.toString()
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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

    // Check sẵn và kích hoạt sự kiện click
    const chonHetCheckbox = document.querySelector("#chonhet");
    if (chonHetCheckbox) {
        chonHetCheckbox.checked = true;
        chonHetCheckbox.dispatchEvent(new Event('click'));
}

});


function calculateTotal(price, quantity) {
    const numericPrice = parseInt(price.replace(/\D/g, ""));
    const total = numericPrice * quantity;
    return `${total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}đ`;
}


function addToCartPhu(id, img, name, price, quantity) {
    let cartPhu = JSON.parse(localStorage.getItem("cartphu")) || [];

    const existingProduct = cartPhu.find(item => item.id === id);

    if (!existingProduct) {
        cartPhu.push({
            id: id,
            image: img,
            name: name,
            price: price,
            quantity: quantity
        });
        localStorage.setItem("cartphu", JSON.stringify(cartPhu));
    }
}

function removeFromCartPhu(id) {
    let cartPhu = JSON.parse(localStorage.getItem("cartphu")) || [];

    cartPhu = cartPhu.filter(item => item.id !== id);
    localStorage.setItem("cartphu", JSON.stringify(cartPhu));
}


function updateSelectAllCheckbox() {
    const checkboxes = document.querySelectorAll(".product-checkbox");
    const checked = document.querySelectorAll(".product-checkbox:checked");

    const selectAllCheckbox = document.querySelector("#chonhet");

    if (checked.length === checkboxes.length) {
        selectAllCheckbox.checked = true;
    } else {
        selectAllCheckbox.checked = false;
    }
}
