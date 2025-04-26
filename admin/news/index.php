<?php
if (!isset($_GET['pageAd']) || $_GET['pageAd'] !== 'news') {
    header("Location: ../index.php?pageAd=news&crud=index");
    exit();
}
$news = new news();
$soTinTuc = 5;
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$loaiTin = isset($_GET['sort']) ? $_GET['sort'] : 'tatca';
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$reuslut = $news->getPaginatedNewsOfAdmin($currentPage, $soTinTuc, $keyword,$loaiTin);
$reuslut1 =  $news->getAllNews(null);
?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'create_news'): ?>
    <div class="toast-alert">✅ Thêm sản phẩm thành công!</div>
<?php endif; ?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'edit_news'): ?>
    <div class="toast-alert">✅ Chỉnh sửa sản phẩm thành công!</div>
<?php endif; ?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'delete_news'): ?>
    <div class="toast-alert">✅ Xóa sản phẩm thành công!</div>
<?php endif; ?>
<h2>Danh sách tin tức</h2>
<div class="search-and-create">

    <div class="tim-kiem">
        <form action="" method="get">
            <input name="keyword" placeholder="Nhập tên sản phẩm" type="text"
                value="<?php echo (isset($_GET['keyword']) ? $_GET['keyword'] : ''); ?>">
                <input type="hidden" name="sort" value="<?php echo htmlspecialchars($loaiTin); ?>">
                <input type="hidden" name="pageAd" value="news">
                <input type="hidden" name="crud" value="index">
                <button type="submit">
                <p>Tìm kiếm</p>
            </button>
        </form>
        <select name="loaiTin" class="loc-loai-tin-news" onchange="applySort(this.value)">
            <option value="tatca" <?php if (isset($loaiTin) && $loaiTin == "tatca") {echo "selected";} ?>>Tất cả</option>
            <?php 
            foreach($reuslut1 as $tieuDe)
            { ?>
                <option value="<?php echo($tieuDe['tieuDe']); ?>" <?php if (isset($loaiTin) && $loaiTin == $tieuDe['tieuDe'] ) {echo "selected";} ?>><?php echo($tieuDe['tieuDe']); ?></option>
            <?php }
            ?>
            
        </select>
    </div>
    <div class="tao-moi">
        <a href="index.php?pageAd=news&crud=create">Tạo mới</a>
    </div>
</div>
<div class="danh-sach">
    <table class="table-danh-sach">
        <tr>
            <th>Tiêu đề</th>
            <th>Mô tả</th>
            <th>Hình ảnh</th>
            <th>Tác giả</th>
            <th>Hành động</th>
        </tr>
        <?php
        if (!empty($reuslut[0])) {

            foreach ($reuslut[0] as $row) 
            {

        ?><tr>
                    <td><?php echo ($row['tieuDe']); ?></td>
                    <td><?php echo ($row['moTa']); ?></td>
                    <td class="hinh-anh"><img src="../public/images/news/<?php  echo ($row['hinhAnh']); ?>" alt=""></td>
                    <td><?php echo ($row['tacGia']); ?></td>
                    <td class="hanh-dong">
                        <a class="sua sua-news" href="index.php?pageAd=news&crud=edit&id=<?php echo ($row['idTinTuc']); ?>">Sửa</a>
                        <a class="chitiet chitiet-news" href="index.php?pageAd=news&crud=detail&id=<?php echo ($row['idTinTuc']); ?>">Chi tiết</a>
                        <a class="xoa xoa-tin-tuc" href="#" data-url="index.php?pageAd=news&crud=delete&id=<?php echo ($row['idTinTuc']); ?>">Xóa</a>

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
        $link = "index.php?pageAd=news&crud=index&page=$i&keyword=" . urlencode($keyword) . "&sort=" . urlencode($loaiTin);
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