document.getElementById("login-form").addEventListener("submit", e =>{
    e.preventDefault();

    const formData = new FormData(e.target);
    const btn_login = document.getElementById("btn-login");

    btn_login.disabled = true

    fetch("http://localhost:8000/auth/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(Object.fromEntries(formData))
    }).then(res => {
        if (!res.ok) throw new Error("Login inválido");
        btn_login.style.color = "#00f82dff";
        btn_login.textContent = "✅ Ingreso con éxito";

        setTimeout(() => {
            window.location.href = "index.html";
        }, 2000);
    }).catch(err => {
        btn_login.style.color = "#c50000ff";
        btn_login.textContent = "❌ Error al Ingreso";

        console.log(err);

        setTimeout(() => {
            btn_login.style.color = "white";
            btn_login.textContent = "Ingreso";
            btn_login.disabled = false;
        }, 2000);
    });
});