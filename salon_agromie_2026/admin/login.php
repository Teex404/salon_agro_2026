<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/theme-premium.css">
</head>
<body>
<div class="container py-5" style="max-width:520px;">
  <div class="card-premium p-4 p-md-5">
    <h1 class="hero-title mb-2">Connexion Admin</h1>
    <p class="text-muted mb-4">Salon de l’Agronomie 2026</p>

    <div class="mb-3">
      <label class="form-label">Nom d'utilisateur</label>
      <input type="text" id="username" class="form-control" placeholder="admin">
    </div>

    <div class="mb-3">
      <label class="form-label">Mot de passe</label>
      <input type="password" id="password" class="form-control" placeholder="••••••••">
    </div>

    <button class="btn btn-premium btn-cyan w-100" onclick="login()">Se connecter</button>
    <div id="message" class="mt-3"></div>
  </div>
</div>

<script>
async function login(){
  const formData = new FormData();
  formData.append("username", document.getElementById("username").value.trim());
  formData.append("password", document.getElementById("password").value.trim());

  const response = await fetch("../api/auth.php?action=login", {
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