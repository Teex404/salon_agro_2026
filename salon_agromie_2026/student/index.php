<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Espace Étudiant</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../assets/css/theme-premium.css">

  <style>
    body{
      min-height: 100vh;
      margin: 0;
      color: #eef3f8;
      background:
        radial-gradient(circle at 12% 18%, rgba(0,209,255,0.10), transparent 24%),
        radial-gradient(circle at 88% 14%, rgba(212,175,55,0.09), transparent 22%),
        radial-gradient(circle at 82% 84%, rgba(0,168,107,0.11), transparent 24%),
        linear-gradient(135deg, #05080d 0%, #09111b 30%, #0c1522 65%, #04070b 100%);
      background-attachment: fixed;
      position: relative;
      overflow-x: hidden;
    }

    body::before{
      content: "";
      position: fixed;
      inset: 0;
      background:
        linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
      background-size: 38px 38px;
      opacity: 0.22;
      pointer-events: none;
      z-index: 0;
      mask-image: radial-gradient(circle at center, black 55%, transparent 100%);
      -webkit-mask-image: radial-gradient(circle at center, black 55%, transparent 100%);
    }

    body::after{
      content: "";
      position: fixed;
      inset: 0;
      background:
        linear-gradient(120deg, transparent 0%, rgba(255,255,255,0.025) 20%, transparent 40%),
        linear-gradient(300deg, transparent 0%, rgba(212,175,55,0.02) 18%, transparent 36%);
      pointer-events: none;
      z-index: 0;
    }

    .luxury-orb{
      position: fixed;
      border-radius: 50%;
      filter: blur(110px);
      pointer-events: none;
      z-index: 0;
      opacity: 0.95;
    }

    .luxury-orb.orb-cyan{
      width: 360px;
      height: 360px;
      top: 30px;
      left: 20px;
      background: rgba(0,209,255,0.12);
    }

    .luxury-orb.orb-gold{
      width: 300px;
      height: 300px;
      top: 90px;
      right: 70px;
      background: rgba(212,175,55,0.10);
    }

    .luxury-orb.orb-green{
      width: 340px;
      height: 340px;
      bottom: 10px;
      right: 80px;
      background: rgba(0,168,107,0.11);
    }

    .student-shell{
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 32px 0;
      position: relative;
      z-index: 2;
    }

    .student-card{
      width: 100%;
      max-width: 860px;
      position: relative;
      overflow: hidden;
      border-radius: 28px;
      background: linear-gradient(145deg, rgba(255,255,255,0.08), rgba(255,255,255,0.03));
      border: 1px solid rgba(255,255,255,0.10);
      box-shadow:
        0 22px 60px rgba(0,0,0,0.45),
        inset 0 1px 0 rgba(255,255,255,0.08);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
    }

    .student-card::before{
      content: "";
      position: absolute;
      top: -60px;
      right: -60px;
      width: 220px;
      height: 220px;
      background: radial-gradient(circle, rgba(0,209,255,0.18), transparent 65%);
      border-radius: 50%;
      pointer-events: none;
    }

    .student-card::after{
      content: "";
      position: absolute;
      bottom: -80px;
      left: -80px;
      width: 240px;
      height: 240px;
      background: radial-gradient(circle, rgba(0,168,107,0.16), transparent 65%);
      border-radius: 50%;
      pointer-events: none;
    }

    .brand-chip{
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 14px;
      border-radius: 999px;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.08);
      color: var(--text-muted);
      font-size: 0.92rem;
      margin-bottom: 14px;
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.05);
    }

    .student-subtitle{
      color: var(--text-muted);
      margin-bottom: 0;
    }

    .info-mini-card{
      background: linear-gradient(145deg, rgba(255,255,255,0.05), rgba(255,255,255,0.025));
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 18px;
      padding: 18px;
      height: 100%;
      transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.04);
    }

    .info-mini-card:hover{
      transform: translateY(-3px);
      box-shadow: 0 14px 30px rgba(0,0,0,0.24);
      border-color: rgba(0,209,255,0.20);
    }

    .info-mini-title{
      color: var(--text-muted);
      font-size: 0.9rem;
      margin-bottom: 8px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .info-mini-value{
      font-size: 1.15rem;
      font-weight: 700;
      color: var(--text-main);
      word-break: break-word;
    }

    .section-icon{
      width: 42px;
      height: 42px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 12px;
      background: rgba(255,255,255,0.07);
      border: 1px solid rgba(255,255,255,0.08);
      margin-right: 10px;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.05);
    }

    .message-box .alert{
      margin-bottom: 0;
      border-radius: 14px;
    }

    .student-points-badge{
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 14px;
      border-radius: 14px;
      background: linear-gradient(145deg, rgba(212,175,55,0.14), rgba(212,175,55,0.06));
      border: 1px solid rgba(212,175,55,0.22);
      color: var(--gold-soft);
      font-weight: 700;
      box-shadow:
        0 10px 22px rgba(0,0,0,0.18),
        inset 0 1px 0 rgba(255,255,255,0.05);
    }

    .input-group-text.premium-addon{
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.10);
      color: var(--text-muted);
      border-radius: 14px 0 0 14px;
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
    }

    .input-premium-leftfix{
      border-radius: 0 14px 14px 0 !important;
    }

    .soft-divider{
      height: 1px;
      background: linear-gradient(to right, transparent, rgba(255,255,255,0.15), transparent);
      margin: 1.5rem 0;
    }

    .student-card .card-premium{
      background: linear-gradient(145deg, rgba(255,255,255,0.055), rgba(255,255,255,0.02));
      border: 1px solid rgba(255,255,255,0.08);
      box-shadow:
        0 16px 34px rgba(0,0,0,0.22),
        inset 0 1px 0 rgba(255,255,255,0.04);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 22px;
    }

    .hero-title{
      text-shadow: 0 8px 28px rgba(0,0,0,0.35);
    }

    @media (max-width: 991.98px){
      .student-card{
        border-radius: 22px;
      }

      .luxury-orb.orb-cyan,
      .luxury-orb.orb-gold,
      .luxury-orb.orb-green{
        transform: scale(0.8);
      }
    }

    @media (max-width: 575.98px){
      .student-shell{
        padding: 18px 0;
      }

      .student-card{
        border-radius: 18px;
      }

      .brand-chip{
        font-size: 0.85rem;
      }
    }
  </style>
</head>
<body>

<div class="luxury-orb orb-cyan"></div>
<div class="luxury-orb orb-gold"></div>
<div class="luxury-orb orb-green"></div>

<div class="container student-shell">
  <div class="card-premium student-card p-4 p-md-5">

    <div class="text-center mb-4">
      <div class="brand-chip">
        <i class="bi bi-cpu-fill text-cyan"></i>
        Espace numérique étudiant
      </div>
      <h1 class="hero-title mb-2">Salon de l’Agronomie 2026</h1>
      <p class="student-subtitle">Validation de présence, participation aux conférences et suivi intelligent des points</p>
    </div>

    <div class="row g-4 align-items-stretch">
      <div class="col-lg-7">
        <div class="card-premium p-4 h-100">
          <div class="section-title d-flex align-items-center">
            <span class="section-icon"><i class="bi bi-person-badge-fill text-cyan"></i></span>
            Identification Étudiant
          </div>

          <label class="form-label mt-2">QR Token étudiant</label>
          <div class="input-group mb-3">
            <span class="input-group-text premium-addon">
              <i class="bi bi-qr-code-scan"></i>
            </span>
            <input type="text" id="token" class="form-control input-premium-leftfix" placeholder="Entrer votre token ou ouvrir avec ?t=...">
          </div>

          <div class="d-grid">
            <button class="btn btn-premium btn-cyan" onclick="checkIn()">
              <i class="bi bi-check2-circle me-2"></i>
              Valider ma présence au salon
            </button>
          </div>

          <div class="soft-divider"></div>

          <div class="section-title d-flex align-items-center">
            <span class="section-icon"><i class="bi bi-mic-fill text-green"></i></span>
            Validation conférence / évènement
          </div>

          <label class="form-label mt-2">Code conférence</label>
          <div class="input-group mb-3">
            <span class="input-group-text premium-addon">
              <i class="bi bi-shield-lock-fill"></i>
            </span>
            <input type="text" id="eventCode" class="form-control input-premium-leftfix" placeholder="Ex: CONF-AB12CD34">
          </div>

          <div class="d-grid">
            <button class="btn btn-premium btn-green" onclick="validateConference()">
              <i class="bi bi-lightning-charge-fill me-2"></i>
              Valider ma participation
            </button>
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="card-premium p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="section-title mb-0 d-flex align-items-center">
              <span class="section-icon"><i class="bi bi-person-lines-fill text-gold"></i></span>
              Mes informations
            </div>
            <div class="student-points-badge">
              <i class="bi bi-stars"></i>
              <span id="studentPoints">0</span> pts
            </div>
          </div>

          <div class="row g-3">
            <div class="col-12">
              <div class="info-mini-card">
                <div class="info-mini-title">Nom complet</div>
                <div class="info-mini-value" id="studentName">-</div>
              </div>
            </div>

            <div class="col-12">
              <div class="info-mini-card">
                <div class="info-mini-title">Promotion</div>
                <div class="info-mini-value" id="studentPromotion">-</div>
              </div>
            </div>

            <div class="col-12">
              <div class="info-mini-card">
                <div class="info-mini-title">Statut</div>
                <div class="info-mini-value text-cyan">Connecté au système du salon</div>
              </div>
            </div>
          </div>

          <div class="soft-divider"></div>

          <div class="small" style="color: var(--text-muted);">
            <i class="bi bi-info-circle-fill me-1 text-cyan"></i>
            Utilise ton token étudiant pour valider ton entrée au salon, puis entre le code affiché pendant la conférence pour recevoir tes points.
          </div>
        </div>
      </div>
    </div>

    <div id="message" class="message-box mt-4"></div>
  </div>
</div>

<script>
function showMessage(type, text){
  let className = "alert alert-" + type;

  if(type === "success"){
    className = "alert alert-premium-success";
  } else if(type === "danger"){
    className = "alert alert-premium-danger";
  } else if(type === "warning"){
    className = "alert alert-warning";
  }

  document.getElementById("message").innerHTML =
    `<div class="${className}">${text}</div>`;
}

function getTokenFromUrl(){
  const params = new URLSearchParams(window.location.search);
  return params.get("t") || "";
}

async function loadStudentInfo(){
  const token = document.getElementById("token").value.trim();
  if(token === "") return;

  try{
    const response = await fetch("../api/students.php?action=me&t=" + encodeURIComponent(token));
    const result = await response.json();

    if(result.ok){
      document.getElementById("studentName").innerText =
        result.data.last_name + " " + result.data.first_name;
      document.getElementById("studentPromotion").innerText =
        result.data.promotion;
      document.getElementById("studentPoints").innerText =
        result.data.total_points;
    } else {
      showMessage("danger", result.error);
    }
  } catch(error){
    showMessage("danger", "Erreur lors du chargement des informations étudiant.");
  }
}

async function checkIn(){
  const token = document.getElementById("token").value.trim();

  if(token === ""){
    showMessage("warning", "Veuillez entrer votre token étudiant.");
    return;
  }

  try{
    const formData = new FormData();
    formData.append("qr_token", token);

    const response = await fetch("../api/students.php?action=checkin", {
      method: "POST",
      body: formData
    });

    const result = await response.json();

    if(result.ok){
      showMessage("success", "Présence au salon validée avec succès.");
      loadStudentInfo();
    } else {
      showMessage("danger", result.error);
    }
  } catch(error){
    showMessage("danger", "Erreur lors de la validation de présence.");
  }
}

async function validateConference(){
  const token = document.getElementById("token").value.trim();
  const code = document.getElementById("eventCode").value.trim();

  if(token === "" || code === ""){
    showMessage("warning", "Veuillez remplir le token étudiant et le code conférence.");
    return;
  }

  try{
    const formData = new FormData();
    formData.append("qr_token", token);
    formData.append("code", code);

    const response = await fetch("../api/events.php?action=validate_code", {
      method: "POST",
      body: formData
    });

    const result = await response.json();

    if(result.ok){
      showMessage("success", "Participation à la conférence validée avec succès. +20 points.");
      document.getElementById("eventCode").value = "";
      loadStudentInfo();
    } else {
      showMessage("danger", result.error);
    }
  } catch(error){
    showMessage("danger", "Erreur lors de la validation du code conférence.");
  }
}

document.getElementById("token").addEventListener("change", loadStudentInfo);

window.onload = function(){
  const tokenFromUrl = getTokenFromUrl();
  if(tokenFromUrl){
    document.getElementById("token").value = tokenFromUrl;
    loadStudentInfo();
  }
}
</script>

</body>
</html>