<?php require_once __DIR__ . '/../config/init.php'; ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des Stands</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/theme-premium.css">
</head>
<body>
<div class="container py-4">
  <div class="card-premium p-4 mb-4">
    <h1 class="hero-title mb-3">Créer un stand</h1>
    <div class="row g-3">
      <div class="col-md-6"><input type="text" id="name" class="form-control" placeholder="Nom du stand"></div>
      <div class="col-md-6"><input type="text" id="location_label" class="form-control" placeholder="Emplacement"></div>
      <div class="col-md-8"><input type="text" id="description" class="form-control" placeholder="Description"></div>
      <div class="col-md-4"><input type="number" id="points_per_visit" class="form-control" value="5"></div>
    </div>
    <button class="btn btn-premium btn-cyan mt-3" onclick="createStand()">Créer</button>
    <div id="message" class="mt-3"></div>
  </div>

  <div class="card-premium p-4">
    <h2 class="section-title">Liste des stands</h2>
    <ul id="standList" class="mb-0"></ul>
  </div>
</div>

<script>
async function createStand(){
  const fd = new FormData();
  fd.append("name", document.getElementById("name").value.trim());
  fd.append("description", document.getElementById("description").value.trim());
  fd.append("location_label", document.getElementById("location_label").value.trim());
  fd.append("points_per_visit", document.getElementById("points_per_visit").value);

  const response = await fetch("../api/stands.php?action=create", { method: "POST", body: fd });
  const result = await response.json();

  document.getElementById("message").innerHTML = result.ok
    ? `<div class="alert alert-premium-success">Stand créé.</div>`
    : `<div class="alert alert-premium-danger">${result.error}</div>`;

  if(result.ok) loadStands();
}

async function loadStands(){
  const response = await fetch("../api/stands.php?action=list");
  const result = await response.json();

  if(result.ok){
    document.getElementById("standList").innerHTML = result.data.map(s =>
      `<li>${s.name} — ${s.location_label || '-'} — ${s.points_per_visit} pts</li>`
    ).join("");
  }
}

window.onload = loadStands;
</script>
</body>
</html>