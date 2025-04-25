<?php
if (!isset($_GET['pageAd']) || $_GET['pageAd'] !== 'product') {
    header("Location: ../index.php?pageAd=product&crud=index");
    exit();
}
$product = new product();
$soSanPham = 5;
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$thuongHieu = isset($_GET['sort']) ? $_GET['sort'] : 'tatca';
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$reuslut = $product->getPaginatedProductsOfAdmin($currentPage, $soSanPham, $keyword, $thuongHieu);

?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'create_product'): ?>
    <div class="toast-alert">✅ Thêm sản phẩm thành công!</div>
<?php endif; ?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'edit_product'): ?>
    <div class="toast-alert">✅ Chỉnh sửa sản phẩm thành công!</div>
<?php endif; ?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'delete_product'): ?>
    <div class="toast-alert">✅ Xóa sản phẩm thành công!</div>
<?php endif; ?>
<h2>Danh sách sản phẩm</h2>
<div class="search-and-create">

    <div class="tim-kiem">
        <form action="" method="get">
            <input name="keyword" placeholder="Nhập tên sản phẩm" type="text"
                value="<?php echo (isset($_GET['keyword']) ? $_GET['keyword'] : ''); ?>">
            <input type="hidden" name="sort" value="<?php echo htmlspecialchars($thuongHieu); ?>">
            <input type="hidden" name="pageAd" value="product">
            <input type="hidden" name="crud" value="index">
            <button type="submit">
                <p>Tìm kiếm</p>
            </button>
        </form>
        <select name="thuonghieu" class="loc-thuong-hieu-product" onchange="applySort(this.value)">
            <option value="tatca" <?php if (isset($thuongHieu) && $thuongHieu == "tatca") {echo "selected";} ?>>Tất cả</option>
            <option value="Victor" <?php if (isset($thuongHieu) && $thuongHieu == "Victor") {echo "selected";} ?>>Victor</option>
            <option value="Yonex" <?php if (isset($thuongHieu) && $thuongHieu == "Yonex") {echo "selected";} ?>>Yonex</option>
            <option value="Lining" <?php if (isset($thuongHieu) && $thuongHieu == "Lining") {echo "selected";} ?>>Lining</option>
        </select>
    </div>
    <div class="tao-moi">
        <a href="index.php?pageAd=product&crud=create">Tạo mới</a>
    </div>
</div>
<div class="danh-sach">
    <table class="table-danh-sach">
        <tr>
            <th>Tên sản phẩm</th>
            <th>Thương hiệu</th>
            <th>Hình ảnh</th>
            <th>Khuyến mãi</th>
            <th>Giá</th>
            <th>Tồn kho</th>
            <th>Trình độ</th>
            <th>Hành động</th>
        </tr>
        <?php
        if (!empty($reuslut[0])) {

            foreach ($reuslut[0] as $row) 
            {
                $listImage = explode(',', $row['hinhAnh']);

        ?><tr>
                    <td><?php echo ($row['tenSanPham']); ?></td>
                    <td><?php echo ($row['thuongHieu']); ?></td>
                    <td class="hinh-anh"><img src="../public/images/product/<?php echo ($listImage[0] . "/" . $listImage[1]); ?>" alt=""></td>
                    <td><?php echo ($row['khuyenMai']); ?></td>
                    <td><?php echo ($row['gia']); ?></td>
                    <td><?php echo ($row['tonKho']); ?></td>
                    <td><?php echo ($row['trinhDo']); ?></td>
                    <td class="hanh-dong">
                        <a class="sua sua-product" href="index.php?pageAd=product&crud=edit&id=<?php echo ($row['idProduct']); ?>">Sửa</a>
                        <a class="chitiet chitiet-product" href="index.php?pageAd=product&crud=detail&id=<?php echo ($row['idProduct']); ?>">Chi tiết</a>
                        <a class="xoa xoa-product" href="#" data-url="index.php?pageAd=product&crud=delete&id=<?php echo ($row['idProduct']); ?>">Xóa</a>

                        <div class="xoa-confirmModal modal">
                            <div class="xoa-modal-content">
                                <p>Bạn có chắc chắn muốn xóa không?</p>
                                <div class="xoa-buttons">
                                    <button class="xoa-cancelBtn">Hủy</button>
                                    <button class="xoa-confirmBtn">Xóa</button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
        <?php
            }
        }
        ?>
    </table>
</div>
<div class="phan-trang">
    <?php
    for ($i = 1; $i <= $reuslut[1]; $i++) {
        $link = "index.php?pageAd=product&crud=index&page=$i&keyword=" . urlencode($keyword) . "&sort=" . urlencode($thuongHieu);
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