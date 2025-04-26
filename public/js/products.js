document.addEventListener("DOMContentLoaded", () => {
  // Xử lý dropdown filter
  const filterButtons = document.querySelectorAll(".filter-btn")

  filterButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault()
      e.stopPropagation()

      // Đóng tất cả các dropdown khác
      document.querySelectorAll(".filter-dropdown").forEach((dropdown) => {
        if (dropdown !== this.nextElementSibling) {
          dropdown.classList.remove("visible")
        }
      })

      document.querySelectorAll(".filter-btn").forEach((btn) => {
        if (btn !== this) {
          btn.classList.remove("active")
        }
      })

      // Toggle dropdown hiện tại
      const dropdown = this.nextElementSibling
      if (dropdown) {
        dropdown.classList.toggle("visible")
        this.classList.toggle("active")
      }
    })
  })

  // Đóng dropdown khi click ra ngoài
  document.addEventListener("click", (e) => {
    if (!e.target.closest(".filter-group")) {
      document.querySelectorAll(".filter-dropdown").forEach((dropdown) => {
        dropdown.classList.remove("visible")
      })

      document.querySelectorAll(".filter-btn").forEach((button) => {
        button.classList.remove("active")
      })
    }
  })

  // Xử lý thanh trượt giá hai đầu
  function setupPriceRangeSlider() {
    const minSlider = document.getElementById("min-price-slider")
    const maxSlider = document.getElementById("max-price-slider")
    const minPriceInput = document.getElementById("min-price-input")
    const maxPriceInput = document.getElementById("max-price-input")

    if (!minSlider || !maxSlider || !minPriceInput || !maxPriceInput) return

    // Lấy giá trị min/max từ thuộc tính của slider
    const minValue = Number.parseInt(minSlider.min) || 0
    const maxValue = Number.parseInt(minSlider.max) || 19500000

    // Cập nhật giá trị hiển thị khi di chuyển thanh trượt
    function updateSliderValues() {
      // Đảm bảo min không vượt quá max
      if (Number.parseInt(minSlider.value) > Number.parseInt(maxSlider.value)) {
        minSlider.value = maxSlider.value
      }

      // Cập nhật giá trị trong ô input
      minPriceInput.value = minSlider.value
      maxPriceInput.value = maxSlider.value

      // Cập nhật vị trí của track highlight
      updateSliderTrack()
    }

    // Cập nhật track highlight giữa hai thumb
    function updateSliderTrack() {
      const sliderTrack = document.querySelector(".slider-track")
      if (!sliderTrack) return

      const percent1 = ((minSlider.value - minValue) / (maxValue - minValue)) * 100
      const percent2 = ((maxSlider.value - minValue) / (maxValue - minValue)) * 100

      sliderTrack.style.background = `linear-gradient(to right, #ddd ${percent1}%, #1e88e5 ${percent1}%, #1e88e5 ${percent2}%, #ddd ${percent2}%)`
    }

    // Cập nhật thanh trượt khi thay đổi giá trị trong ô input
    minPriceInput.addEventListener("input", function () {
      let value = Number.parseInt(this.value) || minValue

      // Đảm bảo giá trị không vượt quá max
      if (value > Number.parseInt(maxPriceInput.value)) {
        value = Number.parseInt(maxPriceInput.value)
        this.value = value
      }

      minSlider.value = value
      updateSliderTrack()
    })

    maxPriceInput.addEventListener("input", function () {
      let value = Number.parseInt(this.value) || maxValue

      // Đảm bảo giá trị không nhỏ hơn min
      if (value < Number.parseInt(minPriceInput.value)) {
        value = Number.parseInt(minPriceInput.value)
        this.value = value
      }

      maxSlider.value = value
      updateSliderTrack()
    })

    // Xử lý sự kiện khi di chuyển thanh trượt
    minSlider.addEventListener("input", updateSliderValues)
    maxSlider.addEventListener("input", updateSliderValues)

    // Khởi tạo ban đầu
    updateSliderTrack()
  }

  // Gọi hàm thiết lập thanh trượt
  setupPriceRangeSlider()

  // Xử lý sự kiện cho các tùy chọn lọc
  function setupFilterOptions() {
    // Xử lý sự kiện cho các tùy chọn lọc độ cứng
    const stiffnessOptions = document.querySelectorAll(".stiffness-option")
    stiffnessOptions.forEach((option) => {
      option.addEventListener("click", function (e) {
        e.preventDefault()
        const value = this.getAttribute("data-value")
        applyFilter("do_cung", value)
      })
    })

    // Xử lý sự kiện cho các tùy chọn lọc điểm cân bằng
    const balanceOptions = document.querySelectorAll(".balance-option")
    balanceOptions.forEach((option) => {
      option.addEventListener("click", function (e) {
        e.preventDefault()
        const value = this.getAttribute("data-value")
        applyFilter("diem_can_bang", value)
      })
    })

    // Xử lý sự kiện cho các tùy chọn lọc trọng lượng
    const tensionOptions = document.querySelectorAll(".tension-option")
    tensionOptions.forEach((option) => {
      option.addEventListener("click", function (e) {
        e.preventDefault()
        const value = this.getAttribute("data-value")
        applyFilter("trong_luong", value)
      })
    })

    // Xử lý sự kiện cho các tùy chọn lọc lối chơi
    const playStyleOptions = document.querySelectorAll(".play-style-option")
    playStyleOptions.forEach((option) => {
      option.addEventListener("click", function (e) {
        e.preventDefault()
        const value = this.getAttribute("data-value")
        applyFilter("loi_choi", value)
      })
    })

    // Xử lý sự kiện cho các tùy chọn lọc giá có sẵn
    const priceOptions = document.querySelectorAll(".price-option")
    priceOptions.forEach((option) => {
      option.addEventListener("click", function (e) {
        e.preventDefault()
        const minPrice = this.getAttribute("data-min")
        const maxPrice = this.getAttribute("data-max")

        // Cập nhật giá trị trong input và slider
        document.getElementById("min-price-input").value = minPrice
        document.getElementById("max-price-input").value = maxPrice

        // Cập nhật giá trị slider nếu có
        const minSlider = document.getElementById("min-price-slider")
        const maxSlider = document.getElementById("max-price-slider")
        if (minSlider && maxSlider) {
          minSlider.value = minPrice
          maxSlider.value = maxPrice

          // Cập nhật track highlight
          const sliderTrack = document.querySelector(".slider-track")
          if (sliderTrack) {
            const minValue = Number.parseInt(minSlider.min) || 0
            const maxValue = Number.parseInt(minSlider.max) || 19500000
            const percent1 = ((minPrice - minValue) / (maxValue - minValue)) * 100
            const percent2 = ((maxPrice - minValue) / (maxValue - minValue)) * 100
            sliderTrack.style.background = `linear-gradient(to right, #ddd ${percent1}%, #1e88e5 ${percent1}%, #1e88e5 ${percent2}%, #ddd ${percent2}%)`
          }
        }

        // Áp dụng bộ lọc giá
        applyPriceFilter()
      })
    })

    // Xử lý nút lọc giá
    const applyPriceFilterBtn = document.getElementById("apply-price-filter")
    if (applyPriceFilterBtn) {
      applyPriceFilterBtn.addEventListener("click", applyPriceFilter)
    }
  }

  // Gọi hàm thiết lập các tùy chọn lọc
  setupFilterOptions()

  // Hàm áp dụng bộ lọc
  function applyFilter(filterName, filterValue) {
    const urlParams = new URLSearchParams(window.location.search)
    urlParams.set(filterName, filterValue)
    urlParams.set("page", 1) // Reset về trang 1 khi áp dụng bộ lọc mới
    window.location.href = window.location.pathname + "?" + urlParams.toString()
  }

  // Hàm áp dụng bộ lọc giá
  function applyPriceFilter() {
    const minPrice = document.getElementById("min-price-input").value || 0
    const maxPrice = document.getElementById("max-price-input").value || 19500000

    const urlParams = new URLSearchParams(window.location.search)
    urlParams.set("price_min", minPrice)
    urlParams.set("price_max", maxPrice)
    urlParams.set("page", 1) // Reset về trang 1 khi áp dụng bộ lọc mới

    window.location.href = window.location.pathname + "?" + urlParams.toString()
  }

  // Hàm áp dụng sắp xếp
  window.applySort = (sortValue) => {
    const urlParams = new URLSearchParams(window.location.search)
    urlParams.set("sort", sortValue)
    window.location.href = window.location.pathname + "?" + urlParams.toString()
  }

  // Xử lý nút thêm vào giỏ hàng
  const addToCartButtons = document.querySelectorAll(".btn-add-cart")
  addToCartButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const productItem = this.closest(".san-pham-item")
      const productName = productItem.querySelector("h3").textContent
      const productId = this.getAttribute("data-id")

      // Hiển thị thông báo
      showNotification(`Đã thêm "${productName}" vào giỏ hàng!`)

      // Ở đây có thể thêm code để lưu sản phẩm vào giỏ hàng (localStorage hoặc gửi AJAX request)
      console.log(`Thêm sản phẩm ID: ${productId} vào giỏ hàng`)
    })
  })

  // Xử lý nút mua ngay
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
      const quantityInput = this.closest(".san-pham-item").querySelector(".quantity-input");
      if (quantityInput) {
        quantity = quantityInput.value;
      }

      // Chuyển hướng đến trang payment.php với thông tin sản phẩm
      const paymentUrl = `../pages/payment.php?product_id=${productId}&quantity=${quantity}`;
      window.location.href = paymentUrl;
    });
  });

  // Hàm hiển thị thông báo
  function showNotification(message) {
    // Xóa thông báo cũ nếu có
    const oldNotification = document.querySelector(".notification")
    if (oldNotification) {
      oldNotification.remove()
    }

    // Tạo thông báo mới
    const notification = document.createElement("div")
    notification.className = "notification"
    notification.textContent = message
    document.body.appendChild(notification)

    // Tự động xóa thông báo sau 3 giây
    setTimeout(() => {
      notification.remove()
    }, 3000)
  }
})
