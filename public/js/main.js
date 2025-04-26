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
