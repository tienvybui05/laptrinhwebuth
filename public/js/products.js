document.addEventListener('DOMContentLoaded', function() {
    // Xử lý dropdown filter
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Đóng tất cả các dropdown khác
            document.querySelectorAll('.filter-dropdown').forEach(dropdown => {
                if (dropdown !== this.nextElementSibling) {
                    dropdown.classList.remove('visible');
                }
            });
            
            document.querySelectorAll('.filter-btn').forEach(btn => {
                if (btn !== this) {
                    btn.classList.remove('active');
                }
            });
            
            // Toggle dropdown hiện tại
            const dropdown = this.nextElementSibling;
            if (dropdown) {
                dropdown.classList.toggle('visible');
                this.classList.toggle('active');
            }
        });
    });
    
    // Đóng dropdown khi click ra ngoài
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.filter-group')) {
            document.querySelectorAll('.filter-dropdown').forEach(dropdown => {
                dropdown.classList.remove('visible');
            });
            
            document.querySelectorAll('.filter-btn').forEach(button => {
                button.classList.remove('active');
            });
        }
    });
    
    // Xử lý thanh trượt giá hai đầu
    function setupPriceRangeSlider() {
        const minSlider = document.getElementById('min-price-slider');
        const maxSlider = document.getElementById('max-price-slider');
        const minPriceInput = document.getElementById('min-price-input');
        const maxPriceInput = document.getElementById('max-price-input');
        
        if (!minSlider || !maxSlider || !minPriceInput || !maxPriceInput) return;
        
        // Cập nhật giá trị hiển thị khi di chuyển thanh trượt
        function updateSliderValues() {
            // Đảm bảo min không vượt quá max
            if (parseInt(minSlider.value) > parseInt(maxSlider.value)) {
                minSlider.value = maxSlider.value;
            }
            
            // Cập nhật giá trị trong ô input
            minPriceInput.value = minSlider.value;
            maxPriceInput.value = maxSlider.value;
            
            // Cập nhật vị trí của track highlight
            updateSliderTrack();
        }
        
        // Cập nhật track highlight giữa hai thumb
        function updateSliderTrack() {
            const sliderTrack = document.querySelector('.slider-track');
            if (!sliderTrack) return;
            
            const percent1 = (minSlider.value / minSlider.max) * 100;
            const percent2 = (maxSlider.value / maxSlider.max) * 100;
            
            sliderTrack.style.background = `linear-gradient(to right, #ddd ${percent1}%, #1e88e5 ${percent1}%, #1e88e5 ${percent2}%, #ddd ${percent2}%)`;
        }
        
        // Cập nhật thanh trượt khi thay đổi giá trị trong ô input
        minPriceInput.addEventListener('input', function() {
            let value = parseInt(this.value) || 0;
            
            // Đảm bảo giá trị không vượt quá max
            if (value > parseInt(maxPriceInput.value)) {
                value = parseInt(maxPriceInput.value);
                this.value = value;
            }
            
            minSlider.value = value;
            updateSliderTrack();
        });
        
        maxPriceInput.addEventListener('input', function() {
            let value = parseInt(this.value) || 19500000;
            
            // Đảm bảo giá trị không nhỏ hơn min
            if (value < parseInt(minPriceInput.value)) {
                value = parseInt(minPriceInput.value);
                this.value = value;
            }
            
            maxSlider.value = value;
            updateSliderTrack();
        });
        
        // Xử lý sự kiện khi di chuyển thanh trượt
        minSlider.addEventListener('input', updateSliderValues);
        maxSlider.addEventListener('input', updateSliderValues);
        
        // Khởi tạo ban đầu
        updateSliderTrack();
    }
    
    // Gọi hàm thiết lập thanh trượt
    setupPriceRangeSlider();
    
    // Xử lý các tùy chọn lọc
    const filterOptions = document.querySelectorAll('.price-option, .stiffness-option, .balance-option, .tension-option, .play-style-option');
    
    filterOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Lấy tất cả các option cùng loại
            const optionType = this.classList[0];
            const sameTypeOptions = document.querySelectorAll('.' + optionType);
            
            // Thêm class active cho option được chọn
            sameTypeOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            // Đóng dropdown sau khi chọn
            setTimeout(() => {
                this.closest('.filter-dropdown').classList.remove('visible');
                this.closest('.filter-group').querySelector('.filter-btn').classList.remove('active');
            }, 300);
        });
    });
    
    // Xử lý nút áp dụng lọc giá
    const applyFilterBtn = document.querySelector('.apply-filter-btn');
    
    if (applyFilterBtn) {
        applyFilterBtn.addEventListener('click', function() {
            const minPrice = document.getElementById('min-price-input').value || 0;
            const maxPrice = document.getElementById('max-price-input').value || 19500000;
            
            console.log(`Lọc sản phẩm từ ${minPrice}đ đến ${maxPrice}đ`);
            
            // Đóng dropdown sau khi áp dụng
            this.closest('.filter-dropdown').classList.remove('visible');
            this.closest('.filter-group').querySelector('.filter-btn').classList.remove('active');
        });
    }
    
    // Xử lý dropdown sắp xếp
    const sortSelect = document.getElementById('sort-select');
    
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const productItems = Array.from(document.querySelectorAll('.san-pham-item'));
            
            // Sắp xếp sản phẩm dựa trên giá trị được chọn
            switch(sortValue) {
                case 'price-asc':
                    sortProductsByPrice(productItems, 'asc');
                    break;
                case 'price-desc':
                    sortProductsByPrice(productItems, 'desc');
                    break;
                case 'name-asc':
                    sortProductsByName(productItems);
                    break;
                case 'newest':
                default:
                    // Mặc định là mới nhất, không cần sắp xếp lại
                    break;
            }
            
            console.log(`Sắp xếp sản phẩm theo: ${sortValue}`);
        });
        
        // Hàm sắp xếp sản phẩm theo giá
        function sortProductsByPrice(products, order) {
            products.sort((a, b) => {
                const priceA = extractPrice(a.querySelector('.price').textContent);
                const priceB = extractPrice(b.querySelector('.price').textContent);
                
                return order === 'asc' ? priceA - priceB : priceB - priceA;
            });
            
            // Sắp xếp lại DOM
            const productList = document.querySelector('.san-pham-list');
            products.forEach(product => productList.appendChild(product));
        }
        
        // Hàm sắp xếp sản phẩm theo tên
        function sortProductsByName(products) {
            products.sort((a, b) => {
                const nameA = a.querySelector('h3').textContent.trim();
                const nameB = b.querySelector('h3').textContent.trim();
                
                return nameA.localeCompare(nameB);
            });
            
            // Sắp xếp lại DOM
            const productList = document.querySelector('.san-pham-list');
            products.forEach(product => productList.appendChild(product));
        }
        
        // Hàm trích xuất giá từ chuỗi (ví dụ: "2.550.000 đ" -> 2550000)
        function extractPrice(priceString) {
            return parseInt(priceString.replace(/\./g, '').replace(/\s+đ/g, ''));
        }
    }
    
    // Xử lý danh mục sản phẩm ở sidebar
    const categoryLinks = document.querySelectorAll('.category-list a');
    
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Xóa class active từ tất cả các link
            categoryLinks.forEach(l => l.classList.remove('active'));
            
            // Thêm class active cho link được chọn
            this.classList.add('active');
            
            const category = this.textContent;
            console.log(`Đã chọn danh mục: ${category}`);
        });
    });
    
    // Xử lý nút thêm vào giỏ hàng
    const addToCartButtons = document.querySelectorAll('.btn-add-cart');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productItem = this.closest('.san-pham-item');
            const productName = productItem.querySelector('h3').textContent;
            
            // Hiển thị thông báo
            showNotification(`Đã thêm "${productName}" vào giỏ hàng!`);
        });
    });
    
    // Xử lý nút mua ngay
    const buyNowButtons = document.querySelectorAll('.btn-buy-now');
    
    buyNowButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productItem = this.closest('.san-pham-item');
            const productName = productItem.querySelector('h3').textContent;
            
            alert(`Chuyển đến trang thanh toán cho sản phẩm: ${productName}`);
        });
    });
    
    // Hàm hiển thị thông báo
    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
    
    // Cập nhật số lượng sản phẩm hiển thị
    function updateProductCount() {
        const productCount = document.querySelector('.product-count');
        const totalProducts = document.querySelectorAll('.san-pham-item').length;
        const visibleProducts = document.querySelectorAll('.san-pham-item:not(.hidden)').length;
        
        if (productCount) {
            productCount.textContent = `Hiển thị 1–${visibleProducts} của ${totalProducts} kết quả`;
        }
    }
    
    // Gọi hàm cập nhật số lượng sản phẩm khi trang được tải
    updateProductCount();
});