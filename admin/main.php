<?php
if (!defined('ALLOW_INCLUDE')) {
    header("location: auth/accessDenied.php");
}
$news = new news();
$orders = new orders();
$customer = new user();
$product = new product();
$numberCustomer = $customer->getNumberCustomer();
$numberProduct = $product->getNumberProduct();
$numberOrders = $orders->getNumberOrders();
$numberNews = $news->getNumberNews();
$thanhTien = $orders->getRevenue()
?>
<div class="row-dau">
    <div class="row-thong-tin">
        <div class="tai-khoan thong-tin">
            <p><i class="nav-arrow-down ti-user"></i></p>
            <p>Số khách hàng</p>
            <p style="font-size: 30px;"><?php echo($numberCustomer); ?></p>
            <!-- <button>
                <a href="#">Tài khoản</a>
            </button> -->
        </div>
        <div class="san-pham thong-tin">
            <p><i class="nav-arrow-down ti-gift"></i></p>
            <p>Số sản phẩm</p>
            <p style="font-size: 30px;"><?php echo($numberProduct); ?></p>
            <!-- <button>
                <a href="#">Sản phẩm</a>
            </button> -->
        </div>
        <div class="don-hang thong-tin">
            <p><i class="nav-arrow-down ti-shopping-cart-full"></i></p>
            <p>Số đơn hàng</p>
            <p style="font-size: 30px;"><?php echo($numberOrders); ?></p>
            <!-- <button>
                <a href="#">Đơn hàng</a>
            </button> -->
        </div>
        <div class="khach-hang thong-tin">
            <p><i class="nav-arrow-down ti-shopping-cart-full"></i></p>
            <p>Số tin tức</p>
            <p style="font-size: 30px;"><?php echo($numberNews); ?></p>
            <!-- <button>
                <a href="#">Đơn hàng</a>
            </button> -->
        </div>
        <div class="marquee-box">
            <marquee behavior="scroll" direction="left" scrollamount="6">
                🎉 Chào mừng bạn đến với trang quản trị! Cập nhật đơn hàng và sản phẩm mỗi ngày để giữ cho cửa hàng luôn hoạt động tốt nhé! 🚀
            </marquee>
        </div>
    </div>
    <div class="row-thong-ke">
        <div class="gioi-thieu">
            <h3>Giới thiệu</h3>
            <p>Chào mừng bạn đến với trang thống kê doanh thu.</p>
            <p> Tại đây, bạn có thể theo dõi các chỉ số kinh doanh quan trọng.</p>
        </div>
        <div class="doanh-thu">
            <p>Doanh thu: <?php echo(number_format($thanhTien)); ?>đ</p>
            <i class="nav-arrow-down ti-stats-up"></i>
        </div>
    </div>
</div>
<div class="row-hai">
</div>