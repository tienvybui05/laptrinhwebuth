document.addEventListener("DOMContentLoaded", () => {
  // Xử lý nút in đơn hàng
  const printButton = document.querySelector(".btn-print-order")
  if (printButton) {
    printButton.addEventListener("click", () => {
      window.print()
    })
  }

  // Xử lý nút liên hệ hỗ trợ
  const supportButton = document.querySelector(".btn-contact-support")
  if (supportButton) {
    supportButton.addEventListener("click", () => {
      // Có thể mở form liên hệ hoặc chuyển đến trang hỗ trợ
      alert("Vui lòng gọi số hotline: 0123.456.789 để được hỗ trợ!")
    })
  }

  // Hiệu ứng hover cho các section
  const sections = document.querySelectorAll(".order-detail-section")
  sections.forEach((section) => {
    section.addEventListener("mouseenter", function () {
      this.style.boxShadow = "0 5px 15px rgba(0, 0, 0, 0.1)"
      this.style.transition = "all 0.3s ease"
    })

    section.addEventListener("mouseleave", function () {
      this.style.boxShadow = "0 2px 10px rgba(0, 0, 0, 0.1)"
    })
  })
})
