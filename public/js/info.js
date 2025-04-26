// Kiểm tra mật khẩu và cập nhật nút submit
document.addEventListener('DOMContentLoaded', function () {
    const passwordOldInput = document.querySelector('#password-cur-info');
    const passwordNewInput = document.querySelector('#password-after-info');
    const confirmPasswordInput = document.querySelector('#password-comfirm-info');
    const savePasswordButton = document.querySelector('#save-password');

    const errorPasswordOld = document.createElement('span');
    const errorPasswordNew = document.createElement('span');
    const errorConfirmPassword = document.createElement('span');

    // Thêm các phần tử hiển thị lỗi vào DOM
    passwordOldInput.parentElement.appendChild(errorPasswordOld);
    passwordNewInput.parentElement.appendChild(errorPasswordNew);
    confirmPasswordInput.parentElement.appendChild(errorConfirmPassword);

    // Đặt class và style cho các thông báo lỗi
    [errorPasswordOld, errorPasswordNew, errorConfirmPassword].forEach(error => {
        error.classList.add('error-message');
        error.style.color = 'red';
        error.style.fontSize = '14px';
        error.style.marginTop = '5px';
        error.style.display = 'block';
    });

    // Hàm kiểm tra mật khẩu
    function validatePassword() {
        let isValid = true;

        // Kiểm tra mật khẩu cũ không được để trống
        if (!passwordOldInput.value.trim()) {
            errorPasswordOld.innerText = 'Mật khẩu hiện tại không được để trống.';
            isValid = false;
        } else {
            errorPasswordOld.innerText = '';
        }

        // Kiểm tra mật khẩu mới không được để trống
        if (!passwordNewInput.value.trim()) {
            errorPasswordNew.innerText = 'Mật khẩu mới không được để trống.';
            isValid = false;
        } else {
            errorPasswordNew.innerText = '';
        }

        // Kiểm tra xác nhận mật khẩu mới phải trùng với mật khẩu mới
        if (passwordNewInput.value.trim() !== confirmPasswordInput.value.trim()) {
            errorConfirmPassword.innerText = 'Xác nhận mật khẩu mới không khớp.';
            isValid = false;
        } else {
            errorConfirmPassword.innerText = '';
        }

        // Vô hiệu hóa nút submit nếu không hợp lệ
        savePasswordButton.disabled = !isValid;
    }

    // Gắn sự kiện `input` để kiểm tra khi người dùng nhập
    passwordOldInput.addEventListener('input', validatePassword);
    passwordNewInput.addEventListener('input', validatePassword);
    confirmPasswordInput.addEventListener('input', validatePassword);

    // Vô hiệu hóa nút submit ban đầu
    savePasswordButton.disabled = true;
});

// Kiểm tra thông tin cá nhân và cập nhật nút submit
document.addEventListener('DOMContentLoaded', function () {
    const infonameInput = document.querySelector('#infoname');
    const infoemailInput = document.querySelector('#infoemail');
    const infoaddressInput = document.querySelector('#infoaddress');
    const saveInfoButton = document.querySelector('#save-info-user'); // Nút submit

    const errorInfoname = document.getElementById('error-infoname');
    const errorInfoemail = document.getElementById('error-infoemail');
    const errorInfoaddress = document.getElementById('error-infoaddress');

    // Lưu giá trị ban đầu
    const initialValues = {
        infoname: infonameInput.value.trim(),
        infoemail: infoemailInput.value.trim(),
        infoaddress: infoaddressInput.value.trim(),
    };

    // Kiểm tra họ và tên
    infonameInput.addEventListener('blur', function () {
        const value = infonameInput.value.trim();
        if (!value) {
            errorInfoname.innerText = 'Họ và tên không được để trống.';
        } else {
            errorInfoname.innerText = ''; // Xóa lỗi nếu hợp lệ
        }
        checkChanges(); // Kiểm tra xem có thay đổi hay không
    });

    // Kiểm tra số điện thoại
    infoemailInput.addEventListener('blur', function () {
        const value = infoemailInput.value.trim();
        const phoneRegex = /^[0-9]{9,11}$/;
        if (!value) {
            errorInfoemail.innerText = 'Số điện thoại không được để trống!';
        } else if (!phoneRegex.test(value)) {
            errorInfoemail.innerText = 'Số điện thoại không hợp lệ! Phải là 9-11 chữ số.';
        } else {
            errorInfoemail.innerText = ''; // Xóa lỗi nếu hợp lệ
        }
        checkChanges(); // Kiểm tra xem có thay đổi hay không
    });

    // Kiểm tra địa chỉ
    infoaddressInput.addEventListener('blur', function () {
        const value = infoaddressInput.value.trim();
        if (!value) {
            errorInfoaddress.innerText = 'Địa chỉ không được để trống.';
        } else {
            errorInfoaddress.innerText = ''; // Xóa lỗi nếu hợp lệ
        }
        checkChanges(); // Kiểm tra xem có thay đổi hay không
    });

    // Hàm kiểm tra nếu có thay đổi hoặc có lỗi
    function checkChanges() {
        // Kiểm tra xem các giá trị có thay đổi không và có lỗi hay không
        const currentValues = {
            infoname: infonameInput.value.trim(),
            infoemail: infoemailInput.value.trim(),
            infoaddress: infoaddressInput.value.trim(),
        };

        // Kiểm tra thay đổi
        const isChanged = initialValues.infoname !== currentValues.infoname ||
            initialValues.infoemail !== currentValues.infoemail ||
            initialValues.infoaddress !== currentValues.infoaddress;

        // Kiểm tra lỗi
        const hasError = errorInfoname.innerText || errorInfoemail.innerText || errorInfoaddress.innerText;

        // Vô hiệu hóa nút submit nếu không thay đổi hoặc có lỗi
        saveInfoButton.disabled = !isChanged || hasError;
    }

    // Vô hiệu hóa nút submit ban đầu
    saveInfoButton.disabled = true;
});
