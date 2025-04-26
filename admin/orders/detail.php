<?php
if (!isset($_GET['pageAd']) || $_GET['pageAd'] !== 'orders') {
 header("Location: ../index.php?pageAd=orders&crud=index");
 exit();
}
$orders= new orders();
if(isset($_GET['id']))
{
$orderCode = $_GET['id'];
$result = $orders->getOrderAdminById($orderCode);
$orderProducts = [];
$orderInfo = null;
$totalAmount = 0;
while($ojb =  $orders->getOrdersFetchAdmin())
{
    if (!$orderInfo) 
    {
        $orderInfo = [
            'orderCode' => $ojb['maTongDonHang'],
            'orderDate' => $ojb['ngayDatHang'],
            'customerName' => $ojb['khachHang'],
            'receiverName' => $ojb['nguoiNhan'],
            'customerPhone' => $ojb['soDienThoai'],
            'customerAddress' => $ojb['diaChi'],
            'paymentMethod' => $ojb['phuongThuc'],
            'orderNote' => $ojb['ghiChu']
        ];
    }
    $orderProducts[] = [
        'productId' => $ojb['idProduct'],
        'productName' => $ojb['tenSanPham'],
        'price' => $ojb['thanhTien'] / $ojb['soLuong'], 
        'quantity' => $ojb['soLuong'],
        'subtotal' => $ojb['thanhTien'],
        'image' => $ojb['hinhAnh']
    ];
    $totalAmount += $ojb['thanhTien'];
}
}

function test_input($data)
{
$data = trim($data);
$data = stripcslashes($data);
$data = htmlspecialchars($data);
return $data;
}
?>

<div class="chi-tiet-don-hang">
    <div class="thong-tin-khach-hang">
        <div class="tieu-de-1">
            <h2 style="color: rgb(108, 203, 229);">Mã hóa đơn: <?php echo($orderInfo['orderCode']); ?></h2>
            <h2 style="color: rgb(108, 203, 229);">Thông tin khách hàng</h2>
        </div>
        <div class="noi-dung">
            <p>Họ tên khách hàng: <?php echo($orderInfo['customerName']); ?></p>
            <p>Họ tên người nhận: <?php echo($orderInfo['receiverName']); ?></p>
            <p>Số điện thoại: <?php echo($orderInfo['customerPhone']); ?></p>
            <p>Địa chỉ giao hàng: <?php echo($orderInfo['customerAddress']); ?></p>
            <p>Phương thức thanh toán: <?php echo($orderInfo['paymentMethod']); ?></p>
            
        </div>
    </div>
    <div class="chi-tiet-san-pham-don-hang">
        <div class="tieu-de-2">
            <h2 style="color: rgb(108, 203, 229);">Chi tiết sản phẩm</h2>
        </div>
        <div class="san-pham">
           <table>
            <tr>
                <th>Sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>

            </tr>
            <?php foreach ($orderProducts as $product)
            {
                $listImage = explode(',', $product['image']);
                ?>
                    <tr>
                        <td><?php echo($product['productName']); ?></td>
                        <td >
                            <img class ="hinh-anh" src="../public/images/product/<?php echo ($listImage[0] . "/" . $listImage[1]); ?>">
                        </td>
                        <td><?php echo(number_format($product['price'])); ?>đ</td>
                        <td><?php echo($product['quantity']); ?></td>
                        <td><?php echo(number_format($product['subtotal'])); ?>đ</td>
                    </tr>
                    <?php 
                
                }?>
           </table>
        </div>
    </div>
    <div class="thanh-tien-ghi-chu">
        <div class="tong-thanh-toan">
                <h4>Tổng thanh toán: <?php echo(number_format($totalAmount)); ?> đ</h4>
        </div>
        <div class="ghi-chu">
                <p>Ghi chú: <?php echo($orderInfo['orderNote']); ?></p>
        </div>
    </div>
    
    <div class="detail-orders-quay-ve">
        <button class="quay-ve" type="button" onclick="window.location.href='index.php?pageAd=orders&crud=index'">Quay về</button>
        <button class="btn-print-order" onclick="window.print();">
                    <i class="ti-printer"></i> In đơn hàng
        </button>
    </div>
</div>