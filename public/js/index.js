document.addEventListener("DOMContentLoaded", () => {
    const btnRegister = document.getElementById("btn-register");
    const btnLogin = document.getElementById("btn-login");
    const btnUser = document.getElementById("btn-user");

    const userName = document.body.dataset.username;

    console.log("Username:", userName);

    if (userName) {
        btnRegister.classList.add("hidden");
        btnLogin.classList.add("hidden");

        btnUser.textContent = userName;
        btnUser.classList.remove("hidden");
    } else {
        btnRegister.classList.remove("hidden");
        btnLogin.classList.remove("hidden");
        btnUser.classList.add("hidden");
    }
});
