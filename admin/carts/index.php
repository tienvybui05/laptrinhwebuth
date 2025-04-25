<?php
if (!isset($_GET['pageAd']) || $_GET['pageAd'] !== 'cart') {
    header("Location: ../index.php?pageAd=cart&crud=index");
    exit();
}
$cart = new cart();
$soGioHang =5;
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$thuongHieu = isset($_GET['sort']) ? $_GET['sort'] : 'tatca';
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$result = $cart->getPaginatedCartOfAdmin($currentPage,$soGioHang,$keyword,$thuongHieu);
?>
<h2>Quản lý giỏ hàng</h2>
<div class="search-and-create">

    <div class="tim-kiem">
        <form action="" method="get">
            <input name="keyword" placeholder="Nhập tên sản phẩm" type="text"
                value="<?php echo (isset($_GET['keyword']) ? $_GET['keyword'] : ''); ?>">
                <input type="hidden" name="sort" value="<?php echo htmlspecialchars($thuongHieu); ?>">
            <button type="submit"><p>Tìm kiếm</p></button>
        </form>
        <select name="thuonghieu" class="loc-thuong-hieu-product" onchange="applySort(this.value)">
            <option value="tatca" <?php if (isset($thuongHieu) && $thuongHieu == "tatca") {echo "selected";} ?>>Tất cả</option>
            <option value="Victor" <?php if (isset($thuongHieu) && $thuongHieu == "Victor") {echo "selected";} ?>>Victor</option>
            <option value="Yonex" <?php if (isset($thuongHieu) && $thuongHieu == "Yonex") {echo "selected";} ?>>Yonex</option>
            <option value="Lining" <?php if (isset($thuongHieu) && $thuongHieu == "Lining") {echo "selected";} ?>>Lining</option>
        </select>
    </div>
</div>
<div class="danh-sach">
    <table class="table-danh-sach">
        <tr>
            <th>Khách hàng</th>
            <th>Sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Thương hiệu</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
        </tr>
        <?php
       foreach($result[0] as $row) 
       {
            $listImage = explode(',', $row['hinhAnh']);
        ?><tr>
                <td><?php echo ($row['hoTen']); ?></td>
                <td><?php echo ($row['tenSanPham']); ?></td>
                <td class="hinh-anh"><img src="../public/images/product/<?php echo ($listImage[0] . "/" . $listImage[1]); ?>" alt=""></td>
                <td><?php echo ($row['thuongHieu']); ?></td>
                <td><?php echo ($row['soLuong']); ?></td>
                <td><?php echo ($row['thanhTien']); ?></td>
            </tr>
        <?php
        }
        ?>
    </table>

</div>
<div class="phan-trang">
    <?php
    for ($i = 1; $i <= $result[1]; $i++) {
        $link = "index.php?pageAd=cart&crud=index&page=$i&keyword=" . urlencode($keyword) . "&sort=" . urlencode($thuongHieu);
        if ($currentPage == $i) 
        {
            echo "<span class='now'>$i</span> ";
        } else 
        {
            echo "<a href='$link'>$i</a> ";
        }
    }

    ?>
</div>
