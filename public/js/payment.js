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
});
