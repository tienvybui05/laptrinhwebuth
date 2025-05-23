document.addEventListener("DOMContentLoaded", () => {
    // Xử lý hiển thị thông tin phương thức thanh toán
    const paymentMethods = document.querySelectorAll('input[name="payment"]');
    const codInfo = document.getElementById("cod-info");
    const bankInfo = document.getElementById("bank-info");

    // Ẩn cả hai thông tin thanh toán ban đầu
    codInfo.classList.remove("active");
    bankInfo.classList.remove("active");

    paymentMethods.forEach((method) => {
        method.addEventListener("change", function () {
            if (this.value === "COD") {
                codInfo.classList.add("active");
                bankInfo.classList.remove("active");
            } else if (this.value === "BANK") {
                bankInfo.classList.add("active");
                codInfo.classList.remove("active");
            }
        });
    });

    // Xử lý form thanh toán
    const checkoutForm = document.querySelector("form");

    checkoutForm.addEventListener("submit", (e) => {
        // Kiểm tra xem có sản phẩm trong giỏ hàng không
        const productSummaries = document.querySelectorAll(".product-summary");
        if (
            productSummaries.length === 0 ||
            (productSummaries.length === 1 && productSummaries[0].querySelector(".product-qty").textContent === "x 0")
        ) {
            e.preventDefault();
            alert("Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.");
            return;
        }

        // Kiểm tra các trường bắt buộc
        const requiredFields = checkoutForm.querySelectorAll("[required]");
        let isValid = true;

        requiredFields.forEach((field) => {
            if (!field.value.trim()) {
                isValid = false;
                field.style.borderColor = "red";
            } else {
                field.style.borderColor = "#ddd";
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert("Vui lòng điền đầy đủ thông tin giao hàng.");
        }
    }); 
    document.querySelector('.remove-btn').addEventListener('click', function(e) {
        e.preventDefault(); // Chặn load trang
        // Kiểm tra xem có sản phẩm trong giỏ hàng không
        const productSummaries = document.querySelectorAll(".product-summary");
        if (
            productSummaries.length === 0 ||
            (productSummaries.length === 1 && productSummaries[0].querySelector(".product-qty").textContent === "x 0")
        ) {
            e.preventDefault();
            alert("Giỏ hàng của bạn đang trống. Không xóa được!.");
            document.querySelector('.remove-btn').innerText = "Không còn đơn";
            return;
        }
        if (confirm("Bạn có chắc chắn muốn hủy tất cả sản phẩm trong đơn hàng không?")) {
            fetch('payment.php?action=remove_order')
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === 'success') {
                        alert("Đã hủy tất cả sản phẩm trong đơn hàng!");
                        document.querySelector('.remove-btn').style.display = 'none'; // Ẩn nút
                        window.location.reload(); // Reload lại trang cho chắc
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    alert("Có lỗi xảy ra, vui lòng thử lại.");
                });
        }
    });
    
     
});
