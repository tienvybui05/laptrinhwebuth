<?php
include_once __DIR__ . '/../auth/checkLogin.php'; 
if(isset($_GET['id']))
{
$id = $_GET['id'];
$product = new product();
$row = $product->getProductbyId($id);
$listImage = explode(',',$row['hinhAnh']);
$folder = "../public/images/product/".$listImage[0];
$result = $product->deleteProduct($id);
if($result)
{
    foreach (array_slice($listImage, 1) as $img) {
        deleteImage($img, $listImage[0]);
    }
    if (is_dir($folder)) {
        rmdir($folder);
        header("location: index.php?pageAd=product&crud=index&msg=delete_product");
        exit;
    }
}
}
function deleteImage($anh,$duongDanFile)
{
    $target_dir="../public/images/product/".$duongDanFile."/";
    $target_file = $target_dir.basename($anh);
    if(file_exists($target_file))
    {
        unlink($target_file);
    }
}
?>