document.addEventListener("DOMContentLoaded", () => {
  // Xử lý nút xem chi tiết
  const detailButtons = document.querySelectorAll(".btn-order-detail")
  detailButtons.forEach((button) => {
    button.addEventListener("click", function () {
      if (!this.getAttribute("href")) {
        const orderCode = this.closest(".order-card").querySelector(".order-id").textContent.split("#")[1].trim()
        window.location.href = `order-detail.php?code=${orderCode}`
      }
    })
  })

  // Hiệu ứng hover cho các đơn hàng
  const orderCards = document.querySelectorAll(".order-card")
  orderCards.forEach((card) => {
    card.addEventListener("mouseenter", function () {
      this.style.boxShadow = "0 5px 15px rgba(0, 0, 0, 0.2)"
      this.style.transform = "translateY(-2px)"
      this.style.transition = "all 0.3s ease"
    })

    card.addEventListener("mouseleave", function () {
      this.style.boxShadow = "0 2px 10px rgba(0, 0, 0, 0.1)"
      this.style.transform = "translateY(0)"
    })
  })
})
