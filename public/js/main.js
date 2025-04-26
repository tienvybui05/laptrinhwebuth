document.addEventListener('DOMContentLoaded', function () {
    // Slide Banner
    let currentIndex = 0;
    let isTransitioning = false; // Biến kiểm soát trạng thái chuyển động
    const items = document.querySelectorAll('.carousel-item');
    const track = document.querySelector('.carousel-track');

    if (track && items.length > 0) {
        const totalItems = items.length;

        // Sao chép các slide để tạo hiệu ứng vô tận
        const firstClone = items[0].cloneNode(true);
        const lastClone = items[totalItems - 1].cloneNode(true);

        track.appendChild(firstClone);
        track.insertBefore(lastClone, items[0]);

        // Cập nhật lại danh sách slide sau khi sao chép
        const updatedItems = document.querySelectorAll('.carousel-item');
        const updatedTotalItems = updatedItems.length;

        // Đặt vị trí ban đầu
        track.style.transform = `translateX(-100%)`;

        function updateCarousel() {
            if (isTransitioning) return; // Nếu đang chuyển động, không thực hiện thêm
            isTransitioning = true; // Đặt trạng thái đang chuyển động

            track.style.transition = 'transform 0.5s ease-in-out';
            track.style.transform = `translateX(-${(currentIndex + 1) * 100}%)`;

            // Reset vị trí khi đến clone
            track.addEventListener(
                'transitionend',
                () => {
                    isTransitioning = false; // Kết thúc chuyển động
                    if (currentIndex === updatedTotalItems - 2) {
                        track.style.transition = 'none';
                        currentIndex = 0;
                        track.style.transform = `translateX(-100%)`;
                    } else if (currentIndex === -1) {
                        track.style.transition = 'none';
                        currentIndex = totalItems - 1;
                        track.style.transform = `translateX(-${(currentIndex + 1) * 100}%)`;
                    }
                },
                { once: true } // Sự kiện chỉ chạy một lần
            );
        }

        // Chuyển đến slide tiếp theo
        function nextSlide() {
            if (isTransitioning) return; // Không thực hiện nếu đang chuyển động
            currentIndex++;
            updateCarousel();
        }

        // Chuyển về slide trước
        function prevSlide() {
            if (isTransitioning) return; // Không thực hiện nếu đang chuyển động
            currentIndex--;
            updateCarousel();
        }

        // Tạo hiệu ứng auto-slide sau mỗi 3 giây
        setInterval(nextSlide, 3000);

        // Xử lý nút chuyển slide
        document.querySelector('.next-btn').addEventListener('click', nextSlide);
        document.querySelector('.prev-btn').addEventListener('click', prevSlide);
    } else {
        console.log('Slide banner không tồn tại.');
    }

    // Thông tin người dùng
    const userMenu = document.querySelector('.user-menu');
    const userIcon = document.querySelector('.user-icon');

    if (userIcon && userMenu) {
        // Thêm sự kiện click vào user-icon để mở/đóng menu người dùng
        userIcon.addEventListener('click', (e) => {
            e.preventDefault(); // Ngăn chặn hành động mặc định
            userMenu.classList.toggle('active'); // Thêm hoặc xóa class active
        });

        // Đóng menu khi click ra ngoài
        document.addEventListener('click', (e) => {
            // Kiểm tra nếu click ngoài userMenu và userIcon
            if (!userMenu.contains(e.target) && !userIcon.contains(e.target)) {
                userMenu.classList.remove('active'); // Đóng menu nếu click ra ngoài
            }
        });
    } else {
        console.log('userMenu hoặc userIcon không tồn tại.');
    }
});


document.addEventListener("DOMContentLoaded", () => {
    // Xử lý nút "Mua ngay" trên tất cả các trang
    const buyNowButtons = document.querySelectorAll(".btn-buy-now");

    buyNowButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            // Lấy thông tin sản phẩm
            const productId = this.getAttribute("data-id");
            if (!productId) return;

            // Lấy số lượng sản phẩm
            let quantity = "1"; // Mặc định là 1 nếu không có input số lượng
            const quantityInput = this.closest(".san-pham-item")?.querySelector(".quantity-input");
            if (quantityInput) {
                quantity = quantityInput.value;
            }

            // Gửi yêu cầu POST để lưu sản phẩm "Mua ngay"
            fetch("../admin/entities/orders.php?action=saveBuyNow", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    productId: productId,
                    quantity: quantity,
                }),
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Không thể lưu sản phẩm 'Mua ngay'.");
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        // Chuyển hướng đến trang thanh toán
                        window.location.href = "../pages/payment.php";
                    } else {
                        alert("Đã xảy ra lỗi: " + data.message);
                    }
                })
                .catch((error) => {
                    console.error("Lỗi:", error);
                    alert("Không thể lưu sản phẩm 'Mua ngay'. Vui lòng thử lại.");
                });
        });
    });
});


//Đăng ký tài khoản
document.addEventListener('DOMContentLoaded', function () {
    const fullnameInput = document.getElementById('fullname');
    const phoneInput = document.getElementById('soDienThoai');
    const diaChiInput = document.getElementById('diaChi');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');

    const errorFullname = document.getElementById('error-fullname');
    const errorPhone = document.getElementById('error-phone');
    const errorDiaChi = document.getElementById('error-diaChi');
    const errorUsername = document.getElementById('error-username');
    const errorPassword = document.getElementById('error-password');
    const errorConfirmPassword = document.getElementById('error-confirm-password');

    const submitButton = document.getElementById('submit');

    let isFormValid = true; // Biến để kiểm tra tính hợp lệ của form

    // Kiểm tra họ tên (không để trống) khi người dùng thoát khỏi ô
    fullnameInput.addEventListener('blur', function () {
        if (!fullnameInput.value.trim()) {
            errorFullname.textContent = "Họ và tên không được để trống.";
            isFormValid = false;
        } else {
            errorFullname.textContent = "";
            isFormValid = true;
        }
    });

    // Kiểm tra số điện thoại khi người dùng thoát khỏi ô
    phoneInput.addEventListener('blur', function () {
        const phoneRegex = /^[0-9]{9,11}$/;
        if (!phoneInput.value.trim()) {
            errorPhone.textContent = "Số điện thoại không được để trống!";
            isFormValid = false;
        } else if (!phoneRegex.test(phoneInput.value.trim())) {
            errorPhone.textContent = "Số điện thoại phải có từ 9 đến 11 chữ số.";
            isFormValid = false;
        } else {
            errorPhone.textContent = "";
            isFormValid = true;
        }
    });

    // Kiểm tra địa chỉ khi người dùng thoát khỏi ô
    diaChiInput.addEventListener('blur', function () {
        if (!diaChiInput.value.trim()) {
            errorDiaChi.textContent = "Địa chỉ không được để trống!";
            isFormValid = false;
        } else {
            errorDiaChi.textContent = "";
            isFormValid = true;
        }
    });

    // Kiểm tra username khi người dùng thoát khỏi ô
    usernameInput.addEventListener('blur', function () {
        if (!usernameInput.value.trim()) {
            errorUsername.textContent = "Username không được để trống!";
            isFormValid = false;
        } else {
            errorUsername.textContent = "";
            isFormValid = true;
        }
    });

    // Kiểm tra mật khẩu khi người dùng thoát khỏi ô
    passwordInput.addEventListener('blur', function () {
        if (!passwordInput.value.trim()) {
            errorPassword.textContent = "Mật khẩu không được để trống!";
            isFormValid = false;
        } else {
            errorPassword.textContent = "";
            isFormValid = true;
        }
    });

    // Kiểm tra xác nhận mật khẩu khi người dùng thoát khỏi ô
    confirmPasswordInput.addEventListener('blur', function () {
        if (confirmPasswordInput.value.trim() !== passwordInput.value.trim()) {
            errorConfirmPassword.textContent = "Mật khẩu và xác nhận mật khẩu không khớp.";
            isFormValid = false;
        } else if (!confirmPasswordInput.value.trim()) {
            errorConfirmPassword.textContent = "Xác nhận mật khẩu không được để trống.";
            isFormValid = false;
        } else {
            errorConfirmPassword.textContent = "";
            isFormValid = true;
        }
    });

    // Ngăn nút submit khi có lỗi
    submitButton.addEventListener('click', function (event) {
        if (!isFormValid) {
            event.preventDefault(); // Ngừng gửi form
            showToastMessage("Vui lòng sửa các lỗi trước khi gửi form!");
        }
    });

    // Hàm hiển thị thông báo toast
    function showToastMessage(message, isSuccess) {
        const toast = document.createElement('div');
        toast.classList.add('toast-message');
        toast.textContent = message;
        if (isSuccess) {
            toast.style.backgroundColor = '#4CAF50'; // Màu xanh cho thông báo thành công
        } else {
            toast.style.backgroundColor = '#f44336'; // Màu đỏ cho thông báo lỗi
        }
        document.body.appendChild(toast);

        // Ẩn thông báo sau 3 giây
        setTimeout(function () {
            toast.style.display = 'none';
        }, 3000);
    }
});

