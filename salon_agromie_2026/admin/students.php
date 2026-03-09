<?php
require_once __DIR__ . '/../config/init.php'; ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion Étudiants</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/theme-premium.css">
</head>
<body>
<div class="container py-4">
  <div class="card-premium p-4 mb-4">
    <h1 class="hero-title mb-3">Créer un étudiant</h1>

    <div class="row g-3">
      <div class="col-md-4">
        <input type="text" id="first_name" class="form-control" placeholder="Prénom">
      </div>
      <div class="col-md-4">
        <input type="text" id="last_name" class="form-control" placeholder="Nom">
      </div>
      <div class="col-md-4">
        <input type="text" id="promotion" class="form-control" placeholder="Promotion">
      </div>
    </div>

    <button class="btn btn-premium btn-cyan mt-3" onclick="createStudent()">Créer</button>
    <div id="message" class="mt-3"></div>
  </div>

  <div class="card-premium p-4">
    <h2 class="section-title">Liste des étudiants</h2>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Promotion</th>
            <th>Token</th>
            <th>Points</th>
          </tr>
        </thead>
        <tbody id="studentsTable"></tbody>
      </table>
    </div>
  </div>
</div>

<script>
async function createStudent(){
  const formData = new FormData();
  formData.append("first_name", document.getElementById("first_name").value.trim());
  formData.append("last_name", document.getElementById("last_name").value.trim());
  formData.append("promotion", document.getElementById("promotion").value.trim());

  const response = await fetch("../api/students.php?action=create", {
    method: "POST",
    body: formData
  });

  const result = await response.json();

  if(result.ok){
    document.getElementById("message").innerHTML =
      `<div class="alert alert-premium-success">Étudiant créé. Token : ${result.data.qr_token}</div>`;
    loadStudents();
  } else {
    document.getElementById("message").innerHTML =
      `<div class="alert alert-premium-danger">${result.error}</div>`;
  }
}

async function loadStudents(){
  const response = await fetch("../api/students.php?action=list");
  const result = await response.json();

  if(result.ok){
    document.getElementById("studentsTable").innerHTML = result.data.map(s => `
      <tr>
        <td>${s.last_name} ${s.first_name}</td>
        <td>${s.promotion}</td>
        <td>${s.qr_token}</td>
        <td>${s.total_points}</td>
      </tr>
    `).join("");
  }
}

window.onload = loadStudents;
</script>
</body>
</html>