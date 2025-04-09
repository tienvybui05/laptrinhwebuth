// trang quản lý product 
//- tạo product 
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector('.form-create-product').addEventListener('submit', function (e) {
        e.preventDefault()
        let isValid = true;
        let message = document.querySelector(".message-product");
        message.innerText = "";

        const tenSanPham = document.querySelector('input[name="tensanpham"]').value.trim();
        const thuongHieu = document.querySelector('input[name="thuonghieu"]').value.trim();
        const khuyenMai = document.querySelector('input[name="khuyenmai"]').value.trim();
        const gia = document.querySelector('input[name="gia"]').value.trim();
        const moTa = document.querySelector('textarea[name="mota"]').value.trim(); 
        const tonKho = document.querySelector('input[name="tonkho"]').value.trim();
        const doCung = document.querySelector('input[name="docung"]').value.trim();
        const diemCanBang = document.querySelector('input[name="diemcanbang"]').value.trim();
        const trinhDo = document.querySelector('input[name="trinhdo"]').value.trim();
        const trongLuong = document.querySelector('input[name="trongluong"]').value.trim();

        const anh1File = document.querySelector('input[name="anh1"]').files[0];
        const anh2File = document.querySelector('input[name="anh2"]').files[0];
        const anh3File = document.querySelector('input[name="anh3"]').files[0];
        const imageExtensions = /\.(jpg|jpeg|png|gif)$/i;

        if (
            tenSanPham === '' || thuongHieu === '' || khuyenMai === '' || gia === '' ||
            moTa === '' || tonKho === '' || doCung === '' || diemCanBang === '' ||
            trinhDo === '' || trongLuong === '' || !anh1File || !anh2File || !anh3File
        ) {
            isValid = false;
            message.innerText = "Vui lòng nhập đầy đủ thông tin!";
        } else if (
            !imageExtensions.test(anh1File.name) ||
            !imageExtensions.test(anh2File.name) ||
            !imageExtensions.test(anh3File.name)
        ) {
            isValid = false;
            message.innerText = "Ảnh phải là file jpg, jpeg, png hoặc gif.";
        }
        if (!isValid) {
            e.preventDefault(); // Chặn submit nếu có lỗi
        }
    });
});

/* đăng nhập*/
document.addEventListener("DOMContentLoaded", function () {
document.querySelector(".form-login").addEventListener("submit",function(event)
{
    event.preventDefault()// ngăn chặn tải lại trăng
    let username = document.querySelector(".username").value.trim();
    let password = document.querySelector(".password").value.trim();
    let message = document.querySelector(".message");
    message.innerText="";
    if (username === "" || password === "") {
        message.innerText = "Đăng nhập không hợp lệ, vui lòng thử lại!";
        return;
    }
    // chừng có php thì code phần xử lý tiếp
});
});
