<?php 
if (!isset($_GET['pageAd']) || $_GET['pageAd'] !== 'orders') {
    header("Location: ../index.php?pageAd=orders&crud=index");
    exit();
}
$orders= new orders();
$result = $orders->getOrdersOfAdmin();
$groupOrders =[];
foreach($result as $ojb)
{
    $orderCode = $ojb['maTongDonHang'];
    if(!isset($groupOrders[$orderCode]))
    {
        $groupOrders[$orderCode] =[
            'orderCode' => $orderCode,
            'orderDate' => $ojb['ngayDatHang'],
            'totalAmount' => 0,
            'products' => [],
        ];
    }
    $groupOrders[$orderCode]['products'][] = [
        'price' => $ojb['thanhTien'] / $ojb['soLuong']
        
    ];
    $groupOrders[$orderCode]['totalAmount'] += $ojb['thanhTien'];
}
?>
                <h2>Quản lý giỏ hàng</h2>
                <!-- <div class="search-and-create">
                   
                    <div class="tim-kiem">
                        <form action="" method="get">
                            <input name="keyword" placeholder="Nhập mã sản phẩm" type="text" 
                            value ="<?php echo (isset($_GET['keyword']) ? $_GET['keyword'] : ''); ?>">
                            <input type="hidden" name="pageAd" value="orders">
                            <input type="hidden" name="crud" value="index">
                            <button type="submit"><p>Tìm kiếm</p></button>
                        </form>
                    </div>
                </div> -->
                <div class="danh-sach">
                    <table class="table-danh-sach">
                        <tr>
                            
                            <th>Mã đơn hàng</th>
                            <th>ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Hành động</th>
                        </tr>
                        <?php
                                foreach($groupOrders as $row) 
                                {
                                    ?><tr>
                                        <td><?php echo($row['orderCode']); ?></td>
                                        <td><?php echo($row['orderDate']); ?></td>
                                        <td><?php echo(number_format($row['totalAmount'], 0, ',', '.')); ?></td>
                                        <td class = "hanh-dong">
                                        <a class="chitiet chitiet-product" href="index.php?pageAd=orders&crud=detail&id=<?php echo ($row['orderCode']); ?>">Chi tiết</a>
                                        </td>
                                        </tr>
                                    <?php
                                }
                        ?>
                    </table>
                    
                </div>