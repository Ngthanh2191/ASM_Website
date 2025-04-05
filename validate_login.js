document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("loginForm");

    form.addEventListener("submit", function (event) {
        let hasError = false;

        // Xóa lỗi cũ
        document.querySelectorAll(".error").forEach(error => error.style.display = "none");

        // Lấy giá trị input
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();

        // Kiểm tra email
        if (email === "") {
            document.getElementById("error-email").textContent = "Vui lòng nhập email!";
            document.getElementById("error-email").style.display = "block";
            hasError = true;
        } else if (!/\S+@\S+\.\S+/.test(email)) {
            document.getElementById("error-email").textContent = "Email không hợp lệ!";
            document.getElementById("error-email").style.display = "block";
            hasError = true;
        }

        // Kiểm tra mật khẩu
        if (password === "") {
            document.getElementById("error-password").textContent = "Vui lòng nhập mật khẩu!";
            document.getElementById("error-password").style.display = "block";
            hasError = true;
        }

        // Nếu có lỗi, ngăn form gửi đi
        if (hasError) {
            event.preventDefault();
        }
    });
});
