// xử lý thêm giỏ hàng và lư vào storage
const btn = document.querySelectorAll(".btn-add-cart")
btn.forEach(function(button,index){
button.addEventListener("click", function(event){{
    var btnItem = event.target
    var product = btnItem.closest(".san-pham-item")
    var shortSrc = product.querySelector("img").src
    var pathOnly = new URL(shortSrc).pathname;
    var productImg = pathOnly.replace("/laptrinhwebuth","..");
    var productName = product.querySelector("h3").innerText
    var productPrice = product.querySelector("p").innerText
    var productQuality = parseInt(1)
    addToCart(productImg,productName,productPrice,productQuality)
    
    

}})
})

function addToCart(img, name, price, quantity) {
    
    // 1. Lấy dữ liệu giỏ hàng hiện có từ localStorage (nếu chưa có sẽ là mảng rỗng)
    var cart = JSON.parse(localStorage.getItem("cart")) || [];

    // 2. Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
    const existingProduct = cart.find(item => item.name === name);
    
    if (existingProduct) {
        // Nếu có rồi: Tăng số lượng lên 1
        existingProduct.quantity += 1;
    } else {
        // Nếu chưa có: Thêm sản phẩm mới vào giỏ hàng
        cart.push({
            image: img,
            name: name,
            price: price,
            quantity: quantity
        });
    }

    // 3. Lưu lại giỏ hàng vào localStorage
    localStorage.setItem("cart", JSON.stringify(cart));
    // 4. Thông báo hoặc cập nhật UI
    alert("Đã thêm vào giỏ hàng!");
    console.log("Giỏ hàng hiện tại:", cart);
}