<?php 
include_once __DIR__ . '/../auth/checkLogin.php';
$orders= new orders();
$keyword = isset($_GET['keyword']) ? $_GET['keyword']:''; 
$result = $orders->getOrders($keyword);
?>
                <h2>Quản lý giỏ hàng</h2>
                <div class="search-and-create">
                   
                    <div class="tim-kiem">
                        <form action="" method="get">
                            <input name="keyword" placeholder="Nhập tên sản phẩm" type="text" 
                            value ="<?php echo (isset($_GET['keyword']) ? $_GET['keyword'] : ''); ?>">
                            <button type="submit"><p>Tìm kiếm</p></button>
                        </form>
                    </div>
                </div>
                <div class="danh-sach">
                    <table class="table-danh-sach">
                        <tr>
                            <th>Khách hàng</th>
                            <th>Người nhận</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Phương thức</th>
                            <th>Ngày đặt hàng</th>
                            <th>Thành tiền</th>
                            <th>Ghi chú</th>
                        </tr>
                        <?php
                                while($row = $orders->getOrdersFetch())
                                {
                                    ?><tr>
                                        <td><?php echo($row['hoTen']); ?></td>
                                        <td><?php echo($row['nguoiNhan']); ?></td>
                                        <td><?php echo($row['soDienThoai']); ?></td>
                                        <td><?php echo($row['diaChi']); ?></td>
                                        <td><?php echo($row['tenSanPham']); ?></td>
                                        <td><?php echo($row['soLuong']); ?></td>
                                        <td><?php echo($row['phuongThuc']); ?></td>
                                        <td><?php echo($row['ngayDatHang']); ?></td>
                                        <td><?php echo($row['thanhTien']); ?></td>
                                        <td><?php echo($row['ghiChu']); ?></td>
                                        </tr>
                                    <?php
                                }
                        ?>
                    </table>
                    
                </div>
                
            </div>
            <div id="footer">
                <p>Bản quyền thuộc <a href="https://github.com/tienvybui05/laptrinhwebuth" > Vợt cầu lông</a></p>
            </div>
        </div>
    </div>
<script src="../main.js"></script>
</body>
</html>