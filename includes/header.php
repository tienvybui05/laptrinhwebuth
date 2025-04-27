<header class="header">
    <div class="container">
        <!--Thanh menu  -->
        <nav class="navbar">
            <a href="../public/index.php" id="logo">
                <img src="../public/images/logo.png" alt="logo">
            </a>
            <ul id="main-menu">
                <li><a href="../public/index.php" class="">Trang chủ</a></li>
                <li><a href="../pages/about.php" class="">Giới thiệu</a></li>
                <li><a href="../pages/products.php">Sản phẩm</a></li>
                <li><a href="../pages/news.php">Tin tức</a></li>
                <li><a href="../pages/contact.php">Liên hệ</a></li>
            </ul>
            <script>
                // Lấy tên trang hiện tại (VD: index.html, about.html)
                const currentPage = window.location.pathname.split("/").pop();

                // Lấy tất cả link trong menu
                const navLinks = document.querySelectorAll('#main-menu a');

                // Duyệt qua từng link để so sánh
                navLinks.forEach(link => {
                    const linkHref = link.getAttribute("href").split("/").pop();

                    if (linkHref === currentPage) {
                        link.classList.add("active");
                    }
                });
            </script>

            <!--Thanh tìm kiếm  -->

            <div class="right-icons">


                <?php if(isset($_SESSION['idUser'])) { ?>
                <a href="#" class="cart-icon"><i class="ti-shopping-cart"></i></a>
                <div class="user-menu">
                    <p >
                        <a href="#" class="user-icon" onclick="toggleDropdown(event)" style="font-size: 18px;">
                            <?php echo $_SESSION['hoTen']; ?> <i class="ti-user"></i>
                        </a>
                    </p>

                    <!-- Dropdown menu khi đã đăng nhập -->
                    <ul class="dropdown-menu" style="display: none;">
                        <li><a href="../auth/info.php"><i class="ti-user"></i> Thông tin người dùng</a></li>
                        <li><a href="../auth/changePassword.php"><i class="ti-key"></i> Đổi mật khẩu</a></li>
                        <li><a href="../pages/order-history.php"><i class="ti-receipt"></i> Lịch sử đơn hàng</a></li>
                        <li><a href="../auth/logout.php"><i class="ti-power-off"></i> Đăng xuất</a></li>
                    </ul>
                </div>

                <script>
                    function toggleDropdown(event) {
                        event.preventDefault();
                        const dropdownMenu = event.target.closest('.user-menu').querySelector('.dropdown-menu');
                        dropdownMenu.style.display = dropdownMenu.style.display === 'none' ? 'block' : 'none';
                    }

                    // Đóng dropdown khi click bên ngoài
                    document.addEventListener('click', function (e) {
                        const userMenu = document.querySelector('.user-menu');
                        if (userMenu && !userMenu.contains(e.target)) {
                            const dropdownMenu = userMenu.querySelector('.dropdown-menu');
                            if (dropdownMenu) {
                                dropdownMenu.style.display = 'none';
                            }
                        }
                    });
                </script>
                    <?php } else { ?>
                    <!-- Hiển thị liên kết "Đăng nhập" nếu chưa đăng nhập -->
                    <a href="../auth/login.php" class="user-icon"><i class="ti-user"></i><span
                            style="font-size: 16px;margin-left: 10px;">Đăng nhập</span></a>
                    <?php } ?>

                </div>
        </nav>
    </div>
</header>