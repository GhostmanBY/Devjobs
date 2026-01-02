document.addEventListener("DOMContentLoaded", () => {
    const formTrabajador = document.getElementById('form-trabajador');
    const heroTrabajador = document.getElementById('hero-trabajador');
    const formEmpresa = document.getElementById('form-empresa');
    const heroEmpresa = document.getElementById('hero-empresa');

    function getVisibleButtons() {
        return formTrabajador.classList.contains("active")
            ? formTrabajador.querySelectorAll(".tab-button")
            : formEmpresa.querySelectorAll(".tab-button");
    }

    function switchTo(tab) {
        if (tab === "trabajador") {
            formEmpresa.classList.remove("active");
            heroEmpresa.classList.remove("active");
            formTrabajador.classList.add("active");
            heroTrabajador.classList.add("active");
        } else {
            formTrabajador.classList.remove("active");
            heroTrabajador.classList.remove("active");
            formEmpresa.classList.add("active");
            heroEmpresa.classList.add("active");
        }

        const visibleButtons = getVisibleButtons();
        visibleButtons.forEach(b => {
            b.classList.toggle("active", b.dataset.tab === tab);
        });
    }

    document.querySelectorAll(".tab-button").forEach(btn => {
        btn.addEventListener("click", () => {
            switchTo(btn.dataset.tab);
        });
    });
});

document.getElementById("registerFormWorkers")
.addEventListener("submit", e => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const btn_form = document.getElementById("btn-worker");

    btn_form.disabled = true;

    fetch("http://localhost:8000/register/worker", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(res => {
        btn_form.style.color = "#00f82dff";
        btn_form.textContent = "✅ Registrado con éxito";

        setTimeout(() => {
            window.location.href = "Login.html";
        }, 2000);
    })
    .catch(err => {
        console.error(err);

        btn_form.style.color = "#c50000ff";
        btn_form.textContent = "❌ Error al registrar";

        setTimeout(() => {
            btn_form.style.color = "white";
            btn_form.textContent = "Crear cuenta";
            btn_form.disabled = false;
        }, 2000);
    });
});

document.getElementById("company-form").addEventListener("submit", e => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const btn_form = document.getElementById("btn-company");

    btn_form.disabled = true;
    btn_form.textContent = "Registrando...";

    fetch("http://localhost:8000/register/company", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(res => {
        btn_form.style.color = "#00f82dff";
        btn_form.textContent = "✅ Empresa registrada con éxito";

        setTimeout(() => {
            window.location.href = "Login.html";
        }, 2000);
    })
    .catch(err => {
        console.error(err);

        btn_form.style.color = "#c50000ff";
        btn_form.textContent = "❌ Error al registrar";

        setTimeout(() => {
            btn_form.style.color = "white";
            btn_form.textContent = "Crear cuenta de Empresa";
            btn_form.disabled = false;
        }, 2000);
    });
});

function hidden_pssw() {
    const container = document.getElementById("contet-buttom-pssw")
    
}