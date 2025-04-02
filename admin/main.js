/* đăng nhập*/
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
})
