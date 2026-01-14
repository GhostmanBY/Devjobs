const API_URL = "http://localhost:8000/serch/page/";
const container = document.getElementById("jobs-container");

const pagination = document.getElementById("pagination");

let currentPage = 1;

async function loadJobs(page = 1) {
  currentPage = page;

  const res = await fetch(`${API_URL}`, {
    method: "POST",
    body: {
      "page": page
    },
    headers: {
      "Accept": "application/json"
    }
  });
  const data = await res.json();

  console.log(data);
  
  renderJobs(data.jobs);
  renderPagination(data.totalPages, data.currentPage);
}

function renderJobs(jobs) {
  container.innerHTML = "";
  console.log(jobs);

  jobs.forEach(job => {
    const article = document.createElement("article");
    article.className = "cards";

    article.innerHTML = `
      <div>
        <h3>${job.title}</h3>
        <small>${job.company_name} | ${job.name_city} | ${job.name_metod}</small>
        <p>${job.descripcion}</p>
      </div>
      <div class="Content-Button-Accion">
        <a href="job.html?id=${job.id}" id="Button-Accion" class="buton_view">Revisar</a>
      </div>
    `;

    container.appendChild(article);
  });
}

function renderPagination(totalPages, current) {
  pagination.innerHTML = "";

  for (let i = 1; i <= totalPages; i++) {
    const btn = document.createElement("button");
    btn.textContent = i;
    btn.className = i === current ? "active" : "";

    btn.onclick = () => loadJobs(i);
    pagination.appendChild(btn);
  }
}

loadJobs();
