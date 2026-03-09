<?php require_once __DIR__ . '/../config/init.php'; ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Identification Responsable Conférence</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/theme-premium.css">
</head>
<body>
<div class="container py-5" style="max-width:600px;">
  <div class="card-premium p-4 p-md-5">
    <h1 class="hero-title mb-2">Responsable de Conférence</h1>
    <p class="text-muted mb-4">Renseignez votre identité avant de commencer le scan.</p>

    <div class="mb-3">
      <label class="form-label">Nom complet</label>
      <input type="text" id="operator_full_name" class="form-control">
    </div>

    <div class="mb-3">
      <label class="form-label">Promotion</label>
      <input type="text" id="operator_promotion" class="form-control">
    </div>

    <button class="btn btn-premium btn-green w-100" onclick="startOperatorSession()">Commencer</button>
    <div id="message" class="mt-3"></div>
  </div>
</div>

<script>
async function startOperatorSession(){
  const formData = new FormData();
  formData.append("operator_full_name", document.getElementById("operator_full_name").value.trim());
  formData.append("operator_promotion", document.getElementById("operator_promotion").value.trim());

  const response = await fetch("../api/operators.php?action=start_session", {
    method: "POST",
    body: formData
  });

  const result = await response.json();

  if(result.ok){
    window.location.href = result.data.redirect;
  } else {
    document.getElementById("message").innerHTML =
      `<div class="alert alert-premium-danger">${result.error}</div>`;
  }
}
</script>
</body>
</html>