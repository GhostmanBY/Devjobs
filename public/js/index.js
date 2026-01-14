document.addEventListener("DOMContentLoaded", () => {
    const btnRegister = document.getElementById("btn-register");
    const btnLogin = document.getElementById("btn-login");
    const btnUser = document.getElementById("btn-user");

    fetch ("http://localhost:8000/auth/login/verific", {
        method: "GET",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"
        }
    }).then(respo => {
        if (!respo.ok) throw new Error("Sesion invalidas");
        return respo.json();
    }).then(data => {
        const userName = data.user.username;
        console.log("Username: ", userName);

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
    }).catch(err => {
        console.error("Error al verificar sesión:", err);
    })

});
