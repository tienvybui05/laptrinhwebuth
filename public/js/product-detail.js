document.addEventListener('DOMContentLoaded', function() {
    // Thumbnail image click handler
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.getElementById('main-product-image');
    
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            // Update main image
            const imageUrl = this.getAttribute('data-image');
            mainImage.src = imageUrl;
            
            // Update active thumbnail
            thumbnails.forEach(item => item.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Quantity controls
    const decreaseBtn = document.querySelector('.quantity-btn.decrease');
    const increaseBtn = document.querySelector('.quantity-btn.increase');
    const quantityInput = document.querySelector('.quantity-input');
    
    decreaseBtn.addEventListener('click', function() {
        let quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantityInput.value = quantity - 1;
        }
    });
    
    increaseBtn.addEventListener('click', function() {
        let quantity = parseInt(quantityInput.value);
        quantityInput.value = quantity + 1;
    });
    
    // Validate quantity input to only allow numbers
    quantityInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value === '' || parseInt(this.value) < 1) {
            this.value = 1;
        }
    });
    
    // Tab switching
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Update active tab
            tabs.forEach(item => item.classList.remove('active'));
            this.classList.add('active');
            
            // Show corresponding tab content
            tabContents.forEach(content => content.classList.remove('active'));
            document.getElementById(`${tabId}-content`).classList.add('active');
        });
    });
    
    // Add to cart button
    const addToCartBtn = document.querySelector('.btn-add-cart');
    
    addToCartBtn.addEventListener('click', function() {
        const quantity = parseInt(quantityInput.value);
        
        // Create notification
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = `Đã thêm ${quantity} sản phẩm vào giỏ hàng`;
        document.body.appendChild(notification);
        
        // Remove notification after animation
        setTimeout(() => {
            notification.remove();
        }, 3000);
    });
    
    // Buy now button
    const buyNowBtn = document.querySelector('.btn-buy-now');
    
    buyNowBtn.addEventListener('click', function() {
        // Redirect to checkout page (in a real implementation)
        alert('Chuyển đến trang thanh toán');
        // window.location.href = 'checkout.html';
    });
});