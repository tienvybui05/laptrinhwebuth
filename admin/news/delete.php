<?php
if (!isset($_GET['pageAd']) || $_GET['pageAd'] !== 'news') {
    header("Location: ../index.php?pageAd=news&crud=index");
    exit();
}
if(isset($_GET['id']))
{
$id = $_GET['id'];
$news = new news();
$row = $news->getNewsById($id);
$folder = "../public/images/news/";
$result = $news->deleteNews($id);
if($result)
{
    deleteImage($row['hinhAnh']);
    header("location: index.php?pageAd=news&crud=index&msg=delete_news");
    exit;
}
}
function deleteImage($anh)
{
    $target_dir="../public/images/news/";
    $target_file = $target_dir.basename($anh);
    if(file_exists($target_file))
    {
        unlink($target_file);
    }
}
?>