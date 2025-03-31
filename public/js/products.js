document.addEventListener('DOMContentLoaded', function() {
    // Hàm cập nhật số lượng sản phẩm hiển thị
    function updateProductCount() {
        const productCountElement = document.querySelector('.product-count');
        if (!productCountElement) return;
        
        const productGrid = document.querySelector('.product-grid');
        const visibleProducts = productGrid.querySelectorAll('.product-card');
        const totalProducts = visibleProducts.length; // Trong thực tế, đây có thể là tổng số sản phẩm từ server
        
        // Giả sử mỗi trang hiển thị 20 sản phẩm
        const itemsPerPage = 20;
        const currentPage = 1; // Trong thực tế, đây sẽ là trang hiện tại từ phân trang
        
        const startItem = (currentPage - 1) * itemsPerPage + 1;
        const endItem = Math.min(currentPage * itemsPerPage, totalProducts);
        
        productCountElement.textContent = `Hiển thị ${startItem}-${endItem} của ${totalProducts} kết quả`;
    }
    
    // Cập nhật số lượng sản phẩm khi trang được tải
    updateProductCount();
    
    // Xử lý hiệu ứng hiển thị nút thêm vào giỏ hàng khi hover
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const actions = this.querySelector('.product-actions');
            if (actions) {
                actions.style.opacity = '1';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const actions = this.querySelector('.product-actions');
            if (actions) {
                actions.style.opacity = '0';
            }
        });
    });
    
    // Xử lý nút thêm vào giỏ hàng
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productCard = this.closest('.product-card');
            const productTitle = productCard.querySelector('.product-title').textContent;
            const productPrice = productCard.querySelector('.sale-price').textContent;
            
            // Hiển thị thông báo thêm vào giỏ hàng thành công
            showNotification(`Đã thêm "${productTitle}" vào giỏ hàng!`);
        });
    });
    
    // Xử lý nút yêu thích
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');
    
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Toggle class để thay đổi màu icon trái tim
            const heartIcon = this.querySelector('i');
            heartIcon.classList.toggle('active');
            
            if (heartIcon.classList.contains('active')) {
                heartIcon.style.color = 'red';
            } else {
                heartIcon.style.color = '';
            }
        });
    });
    
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
                
                // Cập nhật vị trí của dropdown nếu nó đang hiển thị
                if (dropdown.classList.contains('visible')) {
                    updateDropdownPosition(this, dropdown);
                }
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
    
    // Cập nhật vị trí của dropdown khi cuộn trang
    window.addEventListener('scroll', function() {
        const visibleDropdowns = document.querySelectorAll('.filter-dropdown.visible');
        
        visibleDropdowns.forEach(dropdown => {
            const button = dropdown.previousElementSibling;
            if (button && button.classList.contains('filter-btn')) {
                updateDropdownPosition(button, dropdown);
            }
        });
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
    const brandOptions = document.querySelectorAll('.brand-option');
    const priceOptions = document.querySelectorAll('.price-option');
    
    brandOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Thêm class active cho option được chọn
            brandOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            // Đóng dropdown sau khi chọn
            setTimeout(() => {
                this.closest('.filter-dropdown').classList.remove('visible');
                this.closest('.filter-group').querySelector('.filter-btn').classList.remove('active');
            }, 300);
            
            // Cập nhật lại số lượng sản phẩm sau khi lọc
            updateProductCount();
        });
    });
    
    priceOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Thêm class active cho option được chọn
            priceOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            // Đóng dropdown sau khi chọn
            setTimeout(() => {
                this.closest('.filter-dropdown').classList.remove('visible');
                this.closest('.filter-group').querySelector('.filter-btn').classList.remove('active');
            }, 300);
            
            // Cập nhật lại số lượng sản phẩm sau khi lọc
            updateProductCount();
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
            
            // Cập nhật lại số lượng sản phẩm sau khi lọc
            updateProductCount();
        });
    }
    
    // Xử lý dropdown sắp xếp
    const sortSelect = document.querySelector('.product-sort select');
    
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            
            // Ở đây bạn có thể thêm code để sắp xếp sản phẩm dựa trên giá trị đã chọn
            console.log(`Sắp xếp sản phẩm theo: ${sortValue}`);
            
            // Ví dụ về cách sắp xếp sản phẩm
            sortProducts(sortValue);
            
            // Cập nhật lại số lượng sản phẩm sau khi sắp xếp
            updateProductCount();
        });
    }
    
    // Hàm sắp xếp sản phẩm
    function sortProducts(sortType) {
        const productGrid = document.querySelector('.product-grid');
        const products = Array.from(productGrid.querySelectorAll('.product-card'));
        
        products.sort((a, b) => {
            const priceA = parseFloat(a.querySelector('.sale-price').textContent.replace(/[^\d]/g, ''));
            const priceB = parseFloat(b.querySelector('.sale-price').textContent.replace(/[^\d]/g, ''));
            const titleA = a.querySelector('.product-title').textContent;
            const titleB = b.querySelector('.product-title').textContent;
            
            switch(sortType) {
                case 'Giá: Thấp đến cao':
                    return priceA - priceB;
                case 'Giá: Cao đến thấp':
                    return priceB - priceA;
                case 'Tên: A-Z':
                    return titleA.localeCompare(titleB);
                default: // Mới nhất
                    return 0; // Giữ nguyên thứ tự
            }
        });
        
        // Xóa tất cả sản phẩm hiện tại
        productGrid.innerHTML = '';
        
        // Thêm lại sản phẩm đã sắp xếp
        products.forEach(product => {
            productGrid.appendChild(product);
        });
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
            
            // Ở đây bạn có thể thêm code để lọc sản phẩm theo danh mục
            console.log(`Đã chọn danh mục: ${category}`);
            
            // Cập nhật lại số lượng sản phẩm sau khi chọn danh mục
            updateProductCount();
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
});

// Xử lý các tùy chọn lọc độ cứng
const stiffnessOptions = document.querySelectorAll('.stiffness-option');

stiffnessOptions.forEach(option => {
    option.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Thêm class active cho option được chọn
        stiffnessOptions.forEach(opt => opt.classList.remove('active'));
        this.classList.add('active');
        
        // Đóng dropdown sau khi chọn
        setTimeout(() => {
            this.closest('.filter-dropdown').classList.remove('visible');
            this.closest('.filter-group').querySelector('.filter-btn').classList.remove('active');
        }, 300);
        
        // Cập nhật lại số lượng sản phẩm sau khi lọc
        updateProductCount();
    });
});

// Xử lý các tùy chọn lọc điểm cân bằng
const balanceOptions = document.querySelectorAll('.balance-option');

balanceOptions.forEach(option => {
    option.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Thêm class active cho option được chọn
        balanceOptions.forEach(opt => opt.classList.remove('active'));
        this.classList.add('active');
        
        // Đóng dropdown sau khi chọn
        setTimeout(() => {
            this.closest('.filter-dropdown').classList.remove('visible');
            this.closest('.filter-group').querySelector('.filter-btn').classList.remove('active');
        }, 300);
        
        // Cập nhật lại số lượng sản phẩm sau khi lọc
        updateProductCount();
    });
});

// Xử lý các tùy chọn lọc mức căng
const tensionOptions = document.querySelectorAll('.tension-option');

tensionOptions.forEach(option => {
    option.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Thêm class active cho option được chọn
        tensionOptions.forEach(opt => opt.classList.remove('active'));
        this.classList.add('active');
        
        // Đóng dropdown sau khi chọn
        setTimeout(() => {
            this.closest('.filter-dropdown').classList.remove('visible');
            this.closest('.filter-group').querySelector('.filter-btn').classList.remove('active');
        }, 300);
        
        // Cập nhật lại số lượng sản phẩm sau khi lọc
        updateProductCount();
    });
});