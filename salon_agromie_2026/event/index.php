<?php
require_once __DIR__ . '/../config/init.php';

if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'event_manager') {
    header('Location: ../admin/login.php');
    exit;
}

if (empty($_SESSION['operator_session_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Espace Conférence</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../assets/css/theme-premium.css">

  <style>
    .event-shell{
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 32px 0;
    }

    .event-card{
      width: 100%;
      max-width: 900px;
    }

    .operator-box{
      background: rgba(255,255,255,0.55);
      border: 1px solid rgba(15,23,42,0.08);
      border-radius: 18px;
      padding: 18px;
    }

    .student-info-card{
      background: rgba(255,255,255,0.55);
      border: 1px solid rgba(15,23,42,0.08);
      border-radius: 18px;
      padding: 18px;
      min-height: 140px;
    }

    #reader{
      width: 100%;
      max-width: 420px;
      margin: 0 auto;
      display: none;
    }

    .small-muted{
      color: var(--text-muted);
      font-size: 0.92rem;
    }
  </style>
</head>
<body>

<div class="container event-shell">
  <div class="card-premium event-card p-4 p-md-5">
    <div class="text-center mb-4">
      <h1 class="hero-title mb-2">Validation Conférence</h1>
      <p class="small-muted mb-0">Scan des étudiants par le responsable de conférence</p>
    </div>

    <div class="operator-box mb-4">
      <div class="row g-3">
        <div class="col-md-4">
          <strong>Responsable</strong><br>
          <?= htmlspecialchars($_SESSION['operator_full_name'] ?? '-') ?>
        </div>
        <div class="col-md-4">
          <strong>Promotion</strong><br>
          <?= htmlspecialchars($_SESSION['operator_promotion'] ?? '-') ?>
        </div>
        <div class="col-md-4">
          <strong>ID conférence</strong><br>
          <?= htmlspecialchars((string)($_SESSION['event_id'] ?? '-')) ?>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-lg-7">
        <label class="form-label">QR token étudiant</label>
        <div class="input-group mb-3">
          <span class="input-group-text">
            <i class="bi bi-qr-code-scan"></i>
          </span>
          <input
            type="text"
            id="qr_token"
            class="form-control"
            placeholder="Scanner ou coller le token étudiant">
        </div>

        <div class="d-grid gap-2 d-md-flex">
          <button class="btn btn-premium btn-green flex-fill" onclick="scanEventStudent()">
            <i class="bi bi-check2-circle me-2"></i>
            Valider la participation
          </button>

          <button class="btn btn-premium btn-cyan flex-fill" onclick="toggleCameraScanner()">
            <i class="bi bi-camera-fill me-2"></i>
            Scanner avec caméra
          </button>
        </div>

        <div class="mt-4">
          <div id="reader"></div>
        </div>

        <div id="message" class="mt-4"></div>
      </div>

      <div class="col-lg-5">
        <div class="student-info-card">
          <h5 class="mb-3">Informations étudiant</h5>
          <div id="studentInfo" class="small-muted">
            Aucun scan pour le moment.
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
let html5QrCode = null;
let cameraRunning = false;

function showMessage(type, text){
  let className = "alert alert-" + type;

  if(type === "success"){
    className = "alert alert-premium-success";
  } else if(type === "danger"){
    className = "alert alert-premium-danger";
  }

  document.getElementById("message").innerHTML = `<div class="${className}">${text}</div>`;
}

async function scanEventStudent(){
  const token = document.getElementById("qr_token").value.trim();

  if(token === ""){
    showMessage("danger", "Veuillez scanner ou entrer un token étudiant.");
    return;
  }

  const formData = new FormData();
  formData.append("qr_token", token);

  try{
    const response = await fetch("../api/events.php?action=scan_event", {
      method: "POST",
      body: formData
    });

    const result = await response.json();

    if(result.ok){
      showMessage("success", "Participation validée avec succès.");

      document.getElementById("studentInfo").innerHTML = `
        <div><strong>Étudiant :</strong> ${result.data.student_name}</div>
        <div><strong>Promotion :</strong> ${result.data.promotion}</div>
        <div><strong>Conférence :</strong> ${result.data.event_title}</div>
        <div><strong>Points ajoutés :</strong> ${result.data.points_added}</div>
      `;

      document.getElementById("qr_token").value = "";
      document.getElementById("qr_token").focus();
    } else {
      showMessage("danger", result.error || "Erreur lors de la validation.");
    }
  } catch(error){
    console.error(error);
    showMessage("danger", "Erreur réseau ou erreur serveur.");
  }
}

document.getElementById("qr_token").addEventListener("keydown", function(e){
  if(e.key === "Enter"){
    e.preventDefault();
    scanEventStudent();
  }
});

async function toggleCameraScanner(){
  const reader = document.getElementById("reader");

  if(cameraRunning){
    try{
      await html5QrCode.stop();
      reader.style.display = "none";
      cameraRunning = false;
    } catch(error){
      console.error(error);
    }
    return;
  }

  reader.style.display = "block";

  if(!html5QrCode){
    html5QrCode = new Html5Qrcode("reader");
  }

  try{
    const devices = await Html5Qrcode.getCameras();

    if(!devices || devices.length === 0){
      showMessage("danger", "Aucune caméra détectée.");
      return;
    }

    const cameraId = devices[0].id;

    await html5QrCode.start(
      cameraId,
      {
        fps: 10,
        qrbox: 220
      },
      async (decodedText) => {
        document.getElementById("qr_token").value = decodedText;

        try{
          await html5QrCode.stop();
          reader.style.display = "none";
          cameraRunning = false;
        } catch(stopError){
          console.error(stopError);
        }

        scanEventStudent();
      },
      (errorMessage) => {
        // erreurs de lecture ignorées
      }
    );

    cameraRunning = true;
  } catch(error){
    console.error(error);
    showMessage("danger", "Impossible d'accéder à la caméra.");
  }
}
</script>

</body>
</html>