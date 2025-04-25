
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
                <li><a href="../pages/contact.php">Tin tức</a></li>
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
            <div class="search-bar">
                <input type="text" placeholder="Tìm kiếm..." />
                <button type="submit"><i class="ti-search"></i></button>
            </div>
            <div class="right-icons">
                <a href="#" class="cart-icon"><i class="ti-shopping-cart"></i></a>
                <div class="user-menu">
                    <a href="#" class="user-icon"><i class="ti-user"></i></a>
                    <?php 
                         if(isset($_SESSION['idUser']))
                         { ?>
                    <ul class="dropdown-menu">
                        <li><a href="../auth/info.php"><i class="ti-user"></i> Thông tin người dùng</a></li>
                        <li><a href="../auth/logout.php"><i class="ti-power-off"></i> Đăng xuất</a></li>
                    </ul>
                    <?php }   
                        ?>

                </div>
                <script>// Lấy phần tử user-menu
                </script>

            </div>
        </nav>
    </div>
</header>