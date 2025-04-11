// slide banner

let currentIndex = 0;
let isTransitioning = false; // Biến kiểm soát trạng thái chuyển động
const items = document.querySelectorAll('.carousel-item');
const track = document.querySelector('.carousel-track');
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
    track.addEventListener('transitionend', () => {
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
    }, { once: true }); // Sự kiện chỉ chạy một lần
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


//Thông tin người dùng
const userMenu = document.querySelector('.user-menu');

// Thêm sự kiện click vào user-icon
userMenu.addEventListener('click', (e) => {
    e.preventDefault(); // Ngăn chặn hành động mặc định
    userMenu.classList.toggle('active'); // Thêm hoặc xóa class active
});

// Đóng menu khi click ra ngoài
document.addEventListener('click', (e) => {
    if (!userMenu.contains(e.target)) {
        userMenu.classList.remove('active');
    }
});