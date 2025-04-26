<?php
if (!isset($_GET['pageAd']) || $_GET['pageAd'] !== 'news') {
    header("Location: ../index.php?pageAd=news&crud=index");
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $news = new news();
    $tieuDe=$moTa=$noiDung=$hinhAnh=$tacGia="";
    $row = $news->getNewsById($id);
    $tieuDe =  $row['tieuDe'];
    $moTa =$row['moTa'];
    $noiDung = $row['noiDung'];
    $hinhAnh =$row['hinhAnh'];
    $tacGia = $row['tacGia'];
}
function test_input($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>


<div>
    <h2>Chi tiết thông tin sản phẩm</h2>
</div>
<div class="detail-news">
    <div class="tieu-de">
        <h2>Tiêu đề : <?php echo ($row['tieuDe']); ?></h2>
    </div>
    <div class="mo-ta">
        <p>Mô tả: <span><?php echo ($row['moTa']); ?></span> </p>
    </div>
    <div class="hinh-anh-detail-news">
            <img src="../public/images/news/<?php echo ($row['hinhAnh']); ?>" alt="Hình">
    </div>
    <div class="noi-dung">
        <p>Nội dung:</p>
        <p class="noi-dung-news"><?php echo ($row['noiDung']); ?></p>
    </div>
    <div class="tac-gia">
        <p>Tác giả: <?php echo ($row['tacGia']); ?></p>
    </div>
    <div class="detail-news-quay-ve">
        <button class="quay-ve" type="button" onclick="window.location.href='index.php?pageAd=news&crud=index'">Quay về</button>
    </div>
</div>